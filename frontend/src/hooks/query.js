import { useRouter } from 'next/router'

export const useQuery = () => {
    const router = useRouter()
    const { slug } = router.query

    return slug || ''
}

export default useQuery
