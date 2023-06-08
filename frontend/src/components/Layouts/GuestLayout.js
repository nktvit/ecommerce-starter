import { useState } from 'react'
import { Dialog } from '@headlessui/react'
import ApplicationLogo from '@/components/ApplicationLogo'
import Link from 'next/link'
import { Navbar } from 'flowbite-react'
import { MdOutlineShoppingCart } from 'react-icons/md'
import { IoSearch } from 'react-icons/io5'
import { BiCategory } from 'react-icons/bi'
const GuestLayout = ({ children, header }) => {
    const theme = {
        navbar: {
            background: 'blue',
            textColor: 'white',
            height: '60px',
        },
    }

    const [isOpen, setIsOpen] = useState(true)

    function closeModal() {
        setIsOpen(false)
    }

    function openModal() {
        setIsOpen(true)
    }

    const SearchBar = ({ className }) => {
        const isAppleOS = () => {
            const platform =
                navigator?.userAgent?.platform ||
                navigator?.platform ||
                'unknown'
            return /Mac|iPod|iPhone|iPad/i.test(platform)
        }

        const keyboardShortcut = isAppleOS() ? '⌘K' : 'Ctrl+K'

        return (
            <label
                htmlFor="searchBar"
                className={`${className} inline-flex items-center px-3 bg-surface shadow-sm rounded-full cursor-text border border-gray-900/10 hover:border-gray-300 focus:outline-none focus:border-gray-300`}>
                <IoSearch className="flex-none h-6 w-6 text-gray-800" />
                <input
                    type="text"
                    id="searchBar"
                    name="searchBar"
                    placeholder="Search for anything"
                    className="grow w-auto text-gray-500 text-sm text-left border-none bg-inherit focus:ring-0 focus:outline-none"
                />
                <span className="flex-none text-sm text-gray-500 font-semibold">
                    {keyboardShortcut}
                </span>
            </label>
        )
    }

    return (
        <div className="min-h-screen bg-surface">
            <Navbar
                theme={theme}
                className="[&>*]:gap-x-5 bg-primary shadow-md">
                {/*Mobile Hamburger Menu*/}
                <Navbar.Toggle className="[&>*]:fill-white" />
                {/*Logo*/}
                <Navbar.Brand href="/" className="text-white">
                    <ApplicationLogo className="block h-10 w-auto mr-2 fill-current" />
                    <span className="self-center whitespace-nowrap text-xl font-semibold">
                        Laravel React
                    </span>
                </Navbar.Brand>
                {/*Categories dropdown and Search Bar*/}
                <div className="hidden md:flex grow gap-x-4 ">
                    <button className="px-3 py-1.5 text-lg text-white font-black bg-element border-2 border-element rounded-lg">
                        <BiCategory className="inline-block h-6 w-6 mr-1.5" />
                        Categories
                    </button>
                    <Dialog as="div" open={isOpen} onClose={closeModal}>
                        <Dialog.Panel className="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <Dialog.Title>Modal Title</Dialog.Title>
                        </Dialog.Panel>
                    </Dialog>
                    <SearchBar className="grow" />
                </div>

                {/*Links*/}
                <Navbar.Collapse className="mx-3">
                    <Navbar.Link className="list-none text-white" href="/about">
                        <p>About</p>
                    </Navbar.Link>
                </Navbar.Collapse>
                {/*Search and Cart - Mobile*/}
                <div className="flex gap-x-1.5 md:hidden mr-2 text-white">
                    <IoSearch className="mr-2 h-6 w-6" />
                    <Link href="/cart">
                        <MdOutlineShoppingCart className="h-6 w-6" />
                    </Link>
                </div>
                {/*Cart Desktop*/}
                <MdOutlineShoppingCart className="hidden md:inline h-6 w-6 mx-3 text-white" />
                {/*auth*/}
                <div className="hidden mx-3 md:block text-white">
                    <button className="px-3 py-1 mr-2 border-2 border-amber-400 rounded-lg">
                        Log In
                    </button>
                    <button className="px-3 py-1 border-2 border-amber-400 bg-amber-400 rounded-lg">
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
