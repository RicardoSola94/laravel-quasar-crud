import { api } from 'boot/axios'

export default function useApi (url){

    //Obtener productos del api
    const list = async () => {
        try  {
            const { data } = await api.get(url)
            return data
        } catch (error){
        }
    }

    //Obtener producto dado un Id del api
    const getById = async (id) => {
        try  {
            const { data } = await api.get(url + '/' + id)
            return data
        } catch (error){
        }
    }

    //Crear producto api
    const post = async (parametros) => {
        try  {
            const { data } = await api.post(url, parametros)
            return data
        } catch (error){
        }
    }

    //Update producto api
    const update = async (parametros) => {
        try  {
            const { data } = await api.put(url + '/' + parametros.id, parametros)
            return data
        } catch (error){
        }
    }

    //Eliminar producto api
    const remove = async (id) => {
        try  {
            const { data } = await api.delete(url + '/' + id)
            return data
        } catch (error){
        }
    }

    return {
        list,
        post,
        update,
        remove,
        getById
    }
}
