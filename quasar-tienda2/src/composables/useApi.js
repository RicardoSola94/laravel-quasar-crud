import { api } from 'boot/axios'

export default function useApi (url){
    const list = async () => {
        try  {
            const { data } = await api.get(url)
            return data
        } catch (error){
        }
    }

    const getById = async (id) => {
        try  {
            const { data } = await api.get(url + '/' + id)
            return data
        } catch (error){
        }
    }

    const post = async (parametros) => {
        try  {
            const { data } = await api.post(url, parametros)
            return data
        } catch (error){
        }
    }

    const update = async (parametros) => {
        try  {
            const { data } = await api.put(url + '/' + parametros.id, parametros)
            return data
        } catch (error){
        }
    }

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
