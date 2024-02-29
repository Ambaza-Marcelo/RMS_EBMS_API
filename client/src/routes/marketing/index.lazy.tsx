import { createLazyFileRoute } from '@tanstack/react-router'

export const Route = createLazyFileRoute('/marketing/')({
  component: () => <div>Hello /marketing/!</div>
})