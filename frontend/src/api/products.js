import axios from 'axios'

export const fetchProduct = async url => {
    try {
        const response = await axios.get(url)
        return response.data
    } catch (error) {
        //throw new Error(error.response.data.message)
        // eslint-disable-next-line no-console
        console.log(error.response.data.message)
    }
}
