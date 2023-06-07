import { useEffect, useState } from 'react'
import Image from 'next/image'
import Link from 'next/link'
import Head from 'next/head'

import GuestLayout from '@/components/Layouts/GuestLayout'
import { useQuery } from '@/hooks/query'
import { fetchProduct } from '@/api/products'
const Product = () => {
    const baseUrl = process.env.NEXT_PUBLIC_BACKEND_API
    const slug = useQuery()

    const [product, setProduct] = useState(null)
    const [error, setError] = useState(null)

    useEffect(() => {
        const fetchProductData = async () => {
            try {
                if (slug) {
                    const productData = await fetchProduct(
                        `${baseUrl}/product/${slug}`,
                    )
                    setProduct(productData.data)
                }
            } catch (error) {
                setError(error)
            }
        }

        fetchProductData()
    }, [slug])

    if (error?.message) {
        return <div>Error: {error.message}</div>
    }

    if (!product) {
        return <div>Loading...</div>
    }

    return (
        <GuestLayout>
            <Head>
                <title>Store - {slug}</title>
            </Head>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <nav className="mb-4">
                                <ol className="list-none p-0 inline-flex">
                                    <li className="flex items-center">
                                        <Link href="/">
                                            <span className="text-blue-500">
                                                Home
                                            </span>
                                        </Link>
                                        <span className="mx-2">/</span>
                                    </li>
                                    <li className="flex items-center">
                                        <Link href="/products">
                                            <span className="text-blue-500">
                                                Products
                                            </span>
                                        </Link>
                                        <span className="mx-2">/</span>
                                    </li>
                                    <li className="flex items-center">
                                        <span className="text-gray-500">
                                            {slug}
                                        </span>
                                    </li>
                                </ol>
                            </nav>
                            {product && (
                                <div className="flex">
                                    <div className="flex-1">
                                        <Image
                                            src={product.img}
                                            alt={product.name}
                                            width={640}
                                            height={480}
                                            className="max-w-full"
                                        />
                                    </div>
                                    <div className="flex-1">
                                        <h3 className="text-xl font-semibold mb-2">
                                            {product.name}
                                        </h3>
                                        <p className="text-gray-600 mb-4">
                                            {product.description}
                                        </p>
                                        <p className="text-lg font-semibold">
                                            {product.price}
                                        </p>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </GuestLayout>
    )
}

export default Product
