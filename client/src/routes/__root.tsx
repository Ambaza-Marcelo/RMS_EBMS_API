import { Outlet, createRootRoute } from "@tanstack/react-router";
import { Header } from "@/components/header";

export const Route = createRootRoute({
    component: () => <App />,
});

const App = () => {
    return (
        <div className="flex flex-col min-h-[100dvh] space-y-8">
            <Header />
            <Outlet />
        </div>
    );
};
