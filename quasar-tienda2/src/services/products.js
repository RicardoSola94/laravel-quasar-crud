import useApi from "src/composables/useApi"

export default function productsServices () {
    const { list, post, update, remove, getById } = useApi('products')

    return {
        list,
        post,
        update,
        remove,
        getById
    }

}
