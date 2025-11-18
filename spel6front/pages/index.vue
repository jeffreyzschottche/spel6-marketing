<template>
  <div class="min-h-screen bg-[#0a0a0a] text-white">
    <AppNavbar />

    <!-- Hero -->
    <section class="relative flex min-h-screen items-center justify-center overflow-hidden pt-24">
      <div class="absolute inset-0">
        <div class="absolute top-1/4 left-1/4 h-96 w-96 rounded-full bg-[var(--vibe-blue-light)] blur-[120px] opacity-20" />
        <div class="absolute bottom-1/4 right-1/4 h-96 w-96 rounded-full bg-[var(--vibe-red-light)] blur-[120px] opacity-20" />
        <div class="absolute left-1/2 top-1/2 h-[500px] w-[500px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-[var(--vibe-yellow-light)] blur-[150px] opacity-10" />
      </div>
      <div class="relative z-10 mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
        <div class="logo-pulse mx-auto mb-8 w-fit">
          <img :src="placeholderImage" alt="SPEL6" class="mx-auto h-32 w-auto" />
        </div>
        <h1 class="mx-auto mb-6 max-w-4xl text-4xl font-semibold leading-tight text-white md:text-6xl">
          Het ultieme partyspel voor onvergetelijke momenten
        </h1>
        <p class="mx-auto mb-12 max-w-3xl text-xl text-gray-300">
          Kies je sfeer, speel met je crew en maak van elke avond een feest. Duizenden vragen, eindeloos plezier.
        </p>
        <div class="mb-8 flex flex-col justify-center gap-4 sm:flex-row">
          <a
            v-for="store in stores"
            :key="store.label"
            href="#"
            class="inline-flex items-center justify-center gap-3 rounded-2xl bg-white px-8 py-4 text-black transition-all hover:scale-105 hover:bg-gray-100"
          >
            <component :is="store.icon" class="h-6 w-6" />
            <div class="text-left">
              <div class="text-xs">{{ store.subtext }}</div>
              <div class="text-base font-semibold">{{ store.label }}</div>
            </div>
          </a>
        </div>
      </div>
    </section>

    <!-- Feature 1 -->
    <section class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto grid max-w-7xl items-center gap-12 md:grid-cols-2">
        <div class="relative">
          <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-[var(--vibe-green-light)] to-[var(--vibe-blue-light)] opacity-20 blur-xl" />
          <ImageWithFallback
            :src="featureSections[0].image"
            alt="Spelen met vrienden"
            class="relative h-[400px] w-full rounded-3xl object-cover"
          />
        </div>
        <div>
          <h2 class="mb-6 text-3xl font-semibold text-white">Spelen met je vrienden</h2>
          <p class="mb-6 text-lg text-gray-300">
            SPEL6 brengt je dichter bij je vrienden dan ooit tevoren. Met duizenden vragen en uitdagingen leer je elkaar
            op een compleet nieuwe manier kennen.
          </p>
          <ul class="space-y-4">
            <li v-for="item in friendHighlights" :key="item" class="flex items-start gap-3 text-gray-300">
              <span class="mt-1 rounded-full bg-[var(--vibe-green-light)]/20 p-1">
                <Check class="h-4 w-4 text-[var(--vibe-green-light)]" />
              </span>
              <span>{{ item }}</span>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- Feature 2 -->
    <section class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto grid max-w-7xl items-center gap-12 md:grid-cols-2">
        <div class="order-2 md:order-1">
          <h2 class="mb-6 text-3xl font-semibold text-white">Altijd en overal</h2>
          <p class="mb-6 text-lg text-gray-300">
            Of je nu thuis bent, op stap of bij vrienden - SPEL6 gaat overal mee naartoe. Start een nieuw spel in seconden en duik direct in de actie.
          </p>
          <ul class="space-y-4">
            <li v-for="item in mobilityHighlights" :key="item" class="flex items-start gap-3 text-gray-300">
              <span class="mt-1 rounded-full bg-[var(--vibe-yellow-light)]/20 p-1">
                <Check class="h-4 w-4 text-[var(--vibe-yellow-light)]" />
              </span>
              <span>{{ item }}</span>
            </li>
          </ul>
        </div>
        <div class="order-1 relative md:order-2">
          <div class="absolute inset-0 rounded-3xl bg-gradient-to-l from-[var(--vibe-yellow-light)] to-[var(--vibe-red-light)] opacity-20 blur-xl" />
          <ImageWithFallback
            :src="featureSections[1].image"
            alt="Mobiele app"
            class="relative h-[400px] w-full rounded-3xl object-cover"
          />
        </div>
      </div>
    </section>

    <!-- Steps -->
    <section class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-7xl text-center">
        <h2 class="text-3xl font-semibold text-white">Zo werkt het</h2>
        <p class="mt-4 text-xl text-gray-300">In 4 simpele stappen naar eindeloos plezier</p>
        <div class="mt-16 grid gap-8 md:grid-cols-4">
          <div v-for="step in steps" :key="step.step" class="text-center">
            <div class="relative mx-auto mb-6 inline-block">
              <div :class="`${step.color} absolute inset-0 rounded-full opacity-50 blur-xl`" />
              <div :class="`${step.color} relative flex h-20 w-20 items-center justify-center rounded-full text-2xl font-semibold`">
                {{ step.step }}
              </div>
            </div>
            <h3 class="mb-3 text-lg font-semibold text-white">{{ step.title }}</h3>
            <p class="text-sm text-gray-400">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Tabs -->
    <section class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-7xl">
        <div class="mb-16 text-center">
          <h2 class="text-3xl font-semibold text-white">Voor elk moment</h2>
          <p class="mt-4 text-xl text-gray-300">Kies de perfecte sfeer voor jouw avond</p>
        </div>
        <div class="grid items-center gap-12 lg:grid-cols-2">
          <div class="space-y-4">
            <button
              v-for="(tab, index) in tabs"
              :key="tab.title"
              class="w-full rounded-2xl border-2 p-6 text-left transition"
              :class="activeTab === index ? 'border-white/20 bg-white/10' : 'border-transparent bg-white/5 hover:bg-white/10'"
              type="button"
              @click="activeTab = index"
            >
              <h3 class="mb-2 text-xl font-semibold text-white">{{ tab.title }}</h3>
              <p class="text-gray-400">{{ tab.description }}</p>
            </button>
          </div>
          <div class="relative">
            <div class="animated-gradient absolute inset-0 rounded-3xl opacity-20 blur-2xl" />
            <ImageWithFallback
              :src="tabs[activeTab].image"
              :alt="tabs[activeTab].title"
              class="relative h-[500px] w-full rounded-3xl object-cover"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Promo -->
    <section class="relative my-20 px-4 py-32 sm:px-6 lg:px-8">
      <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[var(--light-background)] to-transparent" />
      <div class="relative mx-auto max-w-5xl text-center">
        <div class="relative mx-auto mb-12 h-64 w-64">
          <div class="animated-gradient absolute inset-0 rounded-full opacity-40 blur-2xl" />
          <img :src="placeholderImage" alt="SPEL6 Promo" class="relative h-full w-full object-contain drop-shadow-2xl" />
        </div>
        <h2 class="mb-6 text-3xl font-semibold text-white">Klaar voor het feest?</h2>
        <p class="mx-auto mb-8 max-w-3xl text-xl text-gray-300">
          Sluit je aan bij duizenden spelers die SPEL6 al hebben ontdekt. Download nu en maak van elke avond een onvergetelijk avontuur.
        </p>
        <div class="flex flex-col justify-center gap-4 sm:flex-row">
          <a
            v-for="store in stores"
            :key="`promo-${store.label}`"
            href="#"
            class="inline-flex items-center justify-center gap-3 rounded-2xl px-8 py-4 text-white transition-all hover:scale-105"
          >
            <component :is="store.icon" class="h-6 w-6" />
            <span>{{ store.cta }}</span>
          </a>
        </div>
      </div>
    </section>

    <!-- Final Feature -->
    <section class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto grid max-w-7xl items-center gap-12 md:grid-cols-2">
        <div class="relative">
          <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-[var(--vibe-red-light)] to-[var(--vibe-blue-light)] opacity-20 blur-xl" />
          <ImageWithFallback
            :src="featureSections[2].image"
            alt="Groep vrienden"
            class="relative h-[400px] w-full rounded-3xl object-cover"
          />
        </div>
        <div>
          <h2 class="mb-6 text-3xl font-semibold text-white">Herinneringen voor het leven</h2>
          <p class="mb-6 text-lg text-gray-300">
            SPEL6 draait niet alleen om vragen en challenges. Het gaat om de momenten die je creëert, de verhalen die je deelt en de herinneringen die blijven.
          </p>
          <p class="text-lg text-gray-300">
            Elke avond wordt een nieuw avontuur. Elke vraag brengt je dichter bij elkaar. Dat is de magie van SPEL6.
          </p>
        </div>
      </div>
    </section>

    <!-- Warnings -->
    <section class="bg-white/5 px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-5xl text-center">
        <h2 class="text-3xl font-semibold text-white">Let op</h2>
        <p class="mt-4 text-lg text-gray-300">
          SPEL6 is bedoeld voor volwassenen en kan inhoud bevatten die niet geschikt is voor alle leeftijden.
        </p>
        <div class="mt-12 flex flex-wrap items-center justify-center gap-8">
          <div v-for="item in warnings" :key="item.label" class="flex flex-col items-center gap-2">
            <div class="flex h-20 w-20 items-center justify-center rounded-full border-2 border-white/20 bg-white/10 text-2xl">
              {{ item.icon }}
            </div>
            <span class="text-sm text-gray-400">{{ item.label }}</span>
          </div>
        </div>
        <p class="mt-8 text-sm text-gray-400">Speel verantwoord. Respecteer de grenzen van anderen.</p>
      </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-4xl">
        <div class="mb-12 text-center">
          <h2 class="text-3xl font-semibold text-white">Contact</h2>
          <p class="mt-4 text-xl text-gray-300">Heb je vragen of feedback? We horen graag van je!</p>
        </div>
        <div class="grid gap-8 md:grid-cols-3">
          <div
            v-for="card in contactCards"
            :key="card.title"
            class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center"
          >
            <div :class="`mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full ${card.accent}`">
              <component :is="card.icon" :class="card.iconClass" />
            </div>
            <h3 class="mb-2 text-lg font-semibold text-white">{{ card.title }}</h3>
            <component
              :is="card.href ? 'a' : 'p'"
              :href="card.href"
              class="text-sm text-gray-400 transition hover:text-white"
            >
              {{ card.value }}
            </component>
          </div>
        </div>
      </div>
    </section>

    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { Apple, Check, Mail, MapPin, Phone, Play } from "lucide-vue-next";
import { ref } from "vue";

const placeholderImage = "http://localhost:8000/storage/placeholder.svg";

const stores = [
  { icon: Apple, label: "App Store", subtext: "Download op de", cta: "Download nu - Gratis" },
  { icon: Play, label: "Google Play", subtext: "Verkrijg het op", cta: "Download nu - Gratis" },
];

const friendHighlights = [
  "Duizenden unieke vragen en challenges",
  "Voor elk moment de perfecte sfeer",
  "Van rustig tot volledig uit de hand",
];

const mobilityHighlights = [
  "Beschikbaar op iOS en Android",
  "Geen internet nodig om te spelen",
  "Regelmatige updates met nieuwe content",
];

const steps = [
  { step: "1", title: "Download de app", description: "Gratis beschikbaar in de stores", color: "vibe-green-light" },
  { step: "2", title: "Kies je sfeer", description: "Feest, vrienden, collega's of een date", color: "vibe-yellow-light" },
  { step: "3", title: "Verzamel je crew", description: "Roep je vrienden bij elkaar", color: "vibe-blue-light" },
  { step: "4", title: "Let's go!", description: "Beantwoord vragen en doe challenges", color: "vibe-red-light" },
];

const tabs = [
  {
    title: "Feest",
    description: "Een wereld vol fun en chaos, perfect voor feestjes!",
    image: "https://images.unsplash.com/photo-1546512636-028082dff74d?auto=format&fit=crop&w=1080&q=80",
  },
  {
    title: "Vrienden",
    description: "Ook al kennen jullie elkaar goed, ontmoet elkaar nu pas echt!",
    image: "https://images.unsplash.com/photo-1688413235039-c6a2f715787e?auto=format&fit=crop&w=1080&q=80",
  },
  {
    title: "Collega's",
    description: "Nu werken jullie samen, straks spelen jullie samen!",
    image: "https://images.unsplash.com/photo-1528870884180-5649b20f6435?auto=format&fit=crop&w=1080&q=80",
  },
  {
    title: "Dates",
    description: "Spannende en originele vragen - het perfecte ijsbreker!",
    image: "https://images.unsplash.com/photo-1652962431991-42397e5e44a7?auto=format&fit=crop&w=1080&q=80",
  },
];

const featureSections = [
  { image: "https://images.unsplash.com/photo-1546512636-028082dff74d?auto=format&fit=crop&w=1080&q=80" },
  { image: "https://images.unsplash.com/photo-1528870884180-5649b20f6435?auto=format&fit=crop&w=1080&q=80" },
  { image: "https://images.unsplash.com/photo-1688413235039-c6a2f715787e?auto=format&fit=crop&w=1080&q=80" },
];

const warnings = [
  { label: "18 jaar en ouder", icon: "18+" },
  { label: "Alcohol", icon: "🍺" },
  { label: "Cannabis", icon: "🌿" },
  { label: "Expliciete inhoud", icon: "💋" },
  { label: "Kijkwijzer", icon: "👁️" },
];

const contactCards = [
  {
    title: "Email",
    value: "info@spel6.nl",
    href: "mailto:info@spel6.nl",
    icon: Mail,
    iconClass: "h-5 w-5 text-[var(--vibe-blue-light)]",
    accent: "bg-[var(--vibe-blue-light)]/20",
  },
  {
    title: "Telefoon",
    value: "+31 6 12 34 56 78",
    href: "tel:+31612345678",
    icon: Phone,
    iconClass: "h-5 w-5 text-[var(--vibe-green-light)]",
    accent: "bg-[var(--vibe-green-light)]/20",
  },
  {
    title: "Locatie",
    value: "Amsterdam, Nederland",
    icon: MapPin,
    iconClass: "h-5 w-5 text-[var(--vibe-yellow-light)]",
    accent: "bg-[var(--vibe-yellow-light)]/20",
  },
];

const activeTab = ref(0);
</script>
