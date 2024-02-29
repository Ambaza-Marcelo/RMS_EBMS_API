import { Link } from "@tanstack/react-router";
import { Logo } from "./ui/logo";
import { Nav } from "./nav";

export const Header = () => {
    return (
        <header className="flex items-center">
            <Link to="#" className="flex items-center justify-center">
                <Logo className="w-6 h-6" />
                <span className="sr-only">Home</span>
            </Link>
            <Nav />
        </header>
    );
};
