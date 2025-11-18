<template>
  <div class="min-h-screen bg-[#0a0a0a] text-white">
    <AppNavbar />
    <main class="mx-auto max-w-7xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
      <header class="mb-16 text-center">
        <p class="text-sm uppercase tracking-[0.3em] text-white/50">Shop</p>
        <h1 class="mt-4 text-4xl font-semibold md:text-5xl">SPEL6 Shop</h1>
        <p class="mx-auto mt-4 max-w-2xl text-lg text-gray-300">
          Upgrade je ervaring met premium content en officiële merchandise.
        </p>
      </header>

      <section class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <article
          v-for="product in products"
          :key="product.id"
          class="group relative flex h-full flex-col rounded-2xl border border-white/10 bg-white/5 p-6 transition hover:bg-white/10"
        >
          <div
            v-if="product.popular"
            class="absolute -top-3 right-4 flex items-center gap-1 rounded-full bg-gradient-to-r from-[var(--vibe-yellow-light)] to-[var(--vibe-red-light)] px-4 py-1 text-xs font-semibold"
          >
            <Star class="h-4 w-4" />
            Populair
          </div>
          <div class="relative mb-6 flex h-48 items-center justify-center rounded-xl bg-gradient-to-br from-[var(--vibe-blue-light)]/10 to-[var(--vibe-red-light)]/10 p-8">
            <ImageWithFallback :src="placeholderImage" :alt="product.name" class="h-32 w-auto object-contain" />
          </div>
          <div class="mb-4 space-y-2">
            <h3 class="text-xl font-semibold">{{ product.name }}</h3>
            <p class="text-sm text-gray-400">{{ product.description }}</p>
          </div>
          <ul class="mb-6 space-y-2 text-sm text-gray-300">
            <li v-for="(feature, index) in product.features" :key="index" class="flex items-center gap-2">
              <span class="h-1.5 w-1.5 rounded-full bg-[var(--vibe-green-light)]" />
              {{ feature }}
            </li>
          </ul>
          <div class="mt-auto flex items-center justify-between border-t border-white/10 pt-4">
            <span class="text-2xl font-semibold">{{ product.price }}</span>
            <button
              class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[var(--vibe-green-light)] to-[var(--vibe-blue-light)] px-5 py-2 text-sm font-semibold transition hover:opacity-90"
              type="button"
            >
              <ShoppingCart class="h-4 w-4" />
              Bestel
            </button>
          </div>
        </article>
      </section>

      <section class="mt-16 grid gap-6 md:grid-cols-3">
        <div v-for="(card, index) in infoCards" :key="index" class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center">
          <div
            class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full text-2xl"
            :class="card.pill"
          >
            {{ card.icon }}
          </div>
          <h3 class="text-lg font-semibold">{{ card.title }}</h3>
          <p class="mt-2 text-sm text-gray-400">{{ card.description }}</p>
        </div>
      </section>
    </main>
    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { ShoppingCart, Star } from "lucide-vue-next";

definePageMeta({
  middleware: () => {
    return navigateTo("/", { replace: true });
  },
});

const placeholderImage = "http://localhost:8000/storage/placeholder.svg";

const products = [
  {
    id: 1,
    name: "SPEL6 Premium Pack",
    price: "€9,99",
    description: "Ontgrendel alle premium vragen en challenges",
    features: ["1000+ extra vragen", "Exclusieve challenges", "Geen advertenties"],
    popular: true,
  },
  {
    id: 2,
    name: "SPEL6 T-Shirt",
    price: "€24,99",
    description: "Officiële SPEL6 merchandise in verschillende kleuren",
    features: ["100% katoen", "Unisex fit", "Maten S t/m XXL"],
    popular: false,
  },
  {
    id: 3,
    name: "Party Pack Bundle",
    price: "€14,99",
    description: "Alles wat je nodig hebt voor het ultieme feest",
    features: ["Premium content", "Fysieke kaartjes", "Exclusieve stickers"],
    popular: false,
  },
  {
    id: 4,
    name: "SPEL6 Drinkglas Set",
    price: "€19,99",
    description: "4 glazen met iconische SPEL6 kleuren",
    features: ["Set van 4 stuks", "Vaatwasbestendig", "Stevige kwaliteit"],
    popular: false,
  },
  {
    id: 5,
    name: "Custom Pack Creator",
    price: "€4,99",
    description: "Maak je eigen vraagpakket en deel met vrienden",
    features: ["Onbeperkte vragen", "Delen met vrienden", "Cloud opslag"],
    popular: false,
  },
  {
    id: 6,
    name: "SPEL6 Hoodie",
    price: "€44,99",
    description: "Comfortabele hoodie met SPEL6 logo",
    features: ["Premium kwaliteit", "Warme fleece", "Verschillende kleuren"],
    popular: false,
  },
];

const infoCards = [
  {
    title: "Gratis verzending",
    description: "Bij bestellingen boven €30",
    icon: "🚚",
    pill: "bg-[var(--vibe-green-light)]/20",
  },
  {
    title: "Veilig betalen",
    description: "iDeal, creditcard en meer",
    icon: "💳",
    pill: "bg-[var(--vibe-blue-light)]/20",
  },
  {
    title: "14 dagen retour",
    description: "Niet tevreden? Geld terug",
    icon: "🔄",
    pill: "bg-[var(--vibe-yellow-light)]/20",
  },
];
</script>
