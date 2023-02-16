<template>
  <q-page padding>

    <q-form
     @submit="onSubmit"
     class="row q-col-gutter-sm"
    >
    <q-input
        outlined
        v-model="form.name"
        label="Name *"
        lazy-rules
        class="col-lg-8 col-xs-12"
        :rules="[ val => val && val.length > 0 || 'Campo obligatorio']"
    />

    <q-input
        outlined
        v-model="form.description"
        label="Descripcion *"
        type="textarea"
        class="col-lg-8 col-xs-12"
        :rules="[ val => val && val.length > 0 || 'Campo obligatorio']"
    />
    <q-input
        outlined
        v-model="form.price"
        label="Precio"
        mask="#.##"
        fill-mask="0"
        reverse-fill-mask
        input-class="text-right"
        class="col-lg-8 col-xs-12"
    />

    <div class="col-8 q-gutter-sm">
        <q-btn
           label="Guardar"
           color="primary"
           class="float-right"
           icon="save"
           type="submit"
        />
        <q-btn
           label="Cancelar"
           class="float-right"
           text-color="primary"
           :to="{ name:'home' }"
        />
    </div>

     </q-form>

    </q-page>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue'
import productsService from 'src/services/products'
import { useQuasar } from 'quasar'
import { useRouter, useRoute } from 'vue-router'

export default defineComponent ({
    name: 'formProduct',

    setup (){

        const { post, getById, update } = productsService()

        const $q = useQuasar()
        const router = useRouter()
        const route = useRoute()

        const form  = ref({
            name: '',
            description: '',
            price: ''
        })

        onMounted( async () => {
            if(route.params.id){
                getProduct(route.params.id)
            }
        })

        const getProduct = async (id) => {
            try {
                const data = await getById(id)
                form.value = data
            } catch (error) {
                $q.notify({message: 'ERROR BUSCANDO PRODUCTO', icon: 'time', color: 'negative'})
            }
        }

        const onSubmit = async () => {
            try {
                if(form.value.id){
                    await update(form.value)
                } else {
                    await post(form.value)
                }

                $q.notify({message: 'PRODUCTO GUARDADO CORRECTAMENTE', icon: 'check', color: 'positive'})
                router.push({ name: 'home'})
            } catch (error) {
                $q.notify({message: 'ERROR CREANDO PRODUCTO', icon: 'time', color: 'negative'})
            }
        }

        return {
            form,
            onSubmit
        }
    }

})
</script>
