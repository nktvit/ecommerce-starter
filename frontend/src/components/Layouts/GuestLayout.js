import { Fragment } from 'react'
import { Menu, Transition } from '@headlessui/react'

import ApplicationLogo from '@/components/ApplicationLogo'
import Link from 'next/link'
import { Navbar } from 'flowbite-react'
import { MdOutlineShoppingCart } from 'react-icons/md'
import { IoSearch } from 'react-icons/io5'
import { ChevronDownIcon } from '@heroicons/react/20/solid'
const GuestLayout = ({ children, header }) => {
    function classNames(...classes) {
        return classes.filter(Boolean).join(' ')
    }

    function handleMouseEnter(target) {
        target.click()
    }

    return (
        <div className="min-h-screen bg-amber-100">
            <Navbar>
                {/*Hamburger Menu*/}
                <Navbar.Toggle />
                {/*Logo*/}
                <Navbar.Brand href="/">
                    <ApplicationLogo className="block h-10 w-auto fill-current text-gray-600 mr-2" />
                    <span className="self-center whitespace-nowrap text-xl font-semibold dark:text-white">
                        Laravel React
                    </span>
                </Navbar.Brand>
                {/*Categories dropdown*/}
                <Menu
                    as="div"
                    className="relative inline-block text-left ml-6 mr-2">
                    <Menu.Button
                        onMouseEnter={({ target }) => handleMouseEnter(target)}
                        // onMouseOut={({ target }) => target.click()}
                        className="flex items-center text-sm font-medium text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-offset-gray-100">
                        Categories
                        <ChevronDownIcon
                            className="ml-1 h-4 w-4"
                            aria-hidden="true"
                        />
                    </Menu.Button>
                    <Transition
                        as={Fragment}
                        enter="transition ease-out duration-100"
                        enterFrom="transform opacity-0 scale-95"
                        enterTo="transform opacity-100 scale-100"
                        leave="transition ease-in duration-75"
                        leaveFrom="transform opacity-100 scale-100"
                        leaveTo="transform opacity-0 scale-95">
                        <Menu.Items className="absolute left-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div className="py-1">
                                <Menu.Item>
                                    {({ active }) => (
                                        <Link
                                            href="#"
                                            className={classNames(
                                                active
                                                    ? 'bg-primary-light-bk text-gray-900'
                                                    : 'text-gray-500',
                                                'block px-4 py-2 text-sm',
                                            )}>
                                            Feature 1
                                        </Link>
                                    )}
                                </Menu.Item>
                                <Menu.Item>
                                    {({ active }) => (
                                        <Link
                                            href="#"
                                            className={classNames(
                                                active
                                                    ? 'bg-primary-light-bk text-gray-900'
                                                    : 'text-gray-500',
                                                'block px-4 py-2 text-sm',
                                            )}>
                                            Feature 2
                                        </Link>
                                    )}
                                </Menu.Item>
                            </div>
                        </Menu.Items>
                    </Transition>
                </Menu>
                {/*Search Bar*/}
                <div className="grow flex flex-row bg-gray-50 border-2 border-gray-800 rounded-3xl mx-8 px-5 py-2 text-gray-500">
                    <IoSearch className="mr-2 h-6 w-6 " />
                    Search for anything
                </div>
                {/*Links*/}
                <Navbar.Collapse className="mx-3">
                    <Navbar.Link className="list-none" href="/about">
                        About
                    </Navbar.Link>
                </Navbar.Collapse>
                {/*Search and Cart - Mobile*/}
                <div className="flex flex-wrap mr-2 md:hidden">
                    <IoSearch className="mr-2 h-6 w-6" />
                    <Link href="/cart">
                        <MdOutlineShoppingCart className="h-6 w-6" />
                    </Link>
                </div>
                {/*Cart Desktop*/}
                <MdOutlineShoppingCart className="h-6 w-6 mx-3" />
                {/*auth*/}
                <div className="mx-3">
                    <button className="border-2 border-amber-400 px-3 py-1 mr-2">
                        Log In
                    </button>
                    <button className="border-2 border-amber-400 bg-amber-400 text-white px-3 py-1">
                        Sign Up
                    </button>
                </div>
            </Navbar>

            {header && (
                <header className="bg-white shadow">
                    <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {header}
                    </div>
                </header>
            )}
            <main>{children}</main>
        </div>
    )
}

export default GuestLayout
