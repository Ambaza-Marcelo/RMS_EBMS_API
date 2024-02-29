import { MacbookScroll } from "@/components/macbook-scroll";
import { Button } from "@/components/ui/button";
import { createLazyFileRoute } from "@tanstack/react-router";

export const Route = createLazyFileRoute("/")({
    component: Index,
});

function Index() {
    return (
        <>
            <HeroSection />
            <MacbookScroll src="https://cdn.dribbble.com/userupload/13061189/file/original-fad44646e1e090d192aa0b2a756161c5.png?resize=2048x1536" />
            <FeaturesSection />
            <CtaSection />
            <TestimonialsSection />
            <PricingSection />
            {/* <Footer /> */}
        </>
    );
}

const HeroSection = () => {
    return (
        <section className="flex flex-col   justify-center items-center space-y-4">
            <div className="inline-block rounded-lg bg-gray-100 px-3 py-1 text-sm dark:bg-gray-800">
                Coming Soon!
            </div>
            <h1 className="text-5xl text-center font-bold tracking-tighter">
                Discover the Essence of Hospitality
            </h1>
            <p className="max-w-[600px] text-center text-gray-500 md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed dark:text-gray-400">
                Experience the comfort and efficiency of hotels with our modern
                management system. Seamless. Intuitive. Professional.
            </p>
            <Button size="lg" className="rounded-xl">
                Get Started
            </Button>
        </section>
    );
};

const FeaturesSection = () => {
    return (
        <section>
            <h1>Features Section</h1>
        </section>
    );
};
const CtaSection = () => {
    return (
        <section>
            <h1>Cta Section</h1>
        </section>
    );
};
const TestimonialsSection = () => {
    return (
        <section>
            <h1>Testimonials Section</h1>
        </section>
    );
};
const PricingSection = () => {
    return (
        <section>
            <h1>Pricing Section</h1>
        </section>
    );
};
