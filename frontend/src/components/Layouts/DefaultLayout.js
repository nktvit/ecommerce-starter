const DefaultLayout = ({ children }) => {
    return (
        <div className="min-h-screen bg-amber-100">
            <main>{children}</main>
        </div>
    )
}

export default DefaultLayout
