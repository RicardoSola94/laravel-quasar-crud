<template>
  <q-page padding>
    <q-table
      title="Productos"
      :rows="products"
      :columns="columns"
      row-key="name"
    >
    <template v-slot:top>
      <span class="text-h5">Productos</span>
      <q-space />
      <q-btn color="primary" label="Nuevo" :to="{ name: 'formProduct'}" />
    </template>
    <template v-slot:body-cell-actions="props">
      <q-td :props="props" class="q-gutter-sm">
        <q-btn icon ="edit" color="info" dense  size="sm" @click="editProduct(props.row.id)"/>
        <q-btn icon ="delete" color="negative" dense  size="sm" @click="deleteProduct(props.row.id)"/>
      </q-td>
    </template>
    </q-table>
  </q-page>
</template>

<script>
import { defineComponent, ref, onMounted} from 'vue'
import productsService from 'src/services/products'
import { useQuasar }from 'quasar'
import { useRouter } from 'vue-router'

export default defineComponent({
  name: 'IndexPage',
  setup(){
    const products = ref([])
    const { list, remove } = productsService()

    const $q = useQuasar()
    const route = useRouter()

    const columns = [
      { name: 'name', field: 'name', label: 'Nombre', align: 'left', sortable: true },
      { name: 'description', field: 'description', label: 'Descripcion', align: 'left', sortable: true },
      { name: 'price', field: 'price', label: 'Precio', align: 'left', sortable: true },
      { name: 'actions', field: 'actions', label: 'Acciones', align: 'right' }
    ]

    onMounted(() => {
      getProducts()
    })

    const getProducts = async () => {
                const data = await list()
                products.value = data
            }

    const deleteProduct = async (id) => {
      try{
        $q.dialog({
          title: 'Eliminar',
          message: 'DESEA ELIMINAR ESTE PRODUCTO?',
          ok: {
            push: true
          },
          cancel: {
              push: true,
              color: 'negative'
            },
            persistent: true
          }).onOk( async () => {
            await remove(id)
            $q.notify({message: 'PRODUCTO ELIMINADO CORRECTAMENTE', icon: 'check', color: 'positive'})
            await getProducts()
          })
      }catch(error){
        $q.notify({message: 'ERROR EN ELIMINAR', icon: 'time', color: 'negative'})
      }
    }

    const editProduct = async (id) => {
      route.push({ name: 'formProduct', params: { id }})
      try {

      } catch (error) {

      }
    }


    return {
      products,
      columns,
      deleteProduct,
      editProduct
    }
  }
})
</script>
