<template>
  <div class="min-h-screen bg-[#0a0a0a]">
    <AppNavbar />
    <main class="mx-auto max-w-4xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
      <header class="mb-16 text-center">
        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[var(--vibe-yellow-light)]/20">
          <FileText class="h-10 w-10 text-[var(--vibe-yellow-light)]" />
        </div>
        <h1 class="mb-4 text-4xl font-semibold text-white md:text-5xl">Algemene Voorwaarden</h1>
        <p class="text-xl text-gray-300">De spelregels voor het gebruik van SPEL6</p>
        <p class="mt-4 text-sm text-gray-500">Laatst bijgewerkt: November 2024</p>
      </header>

      <section class="mb-16 grid gap-4 md:grid-cols-3">
        <article class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center">
          <Shield class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-green-light)]" />
          <h3 class="text-white">Bescherming</h3>
          <p class="text-sm text-gray-400">Wij waarborgen eerlijk spel</p>
        </article>
        <article class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center">
          <UserCheck class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-blue-light)]" />
          <h3 class="text-white">Respect</h3>
          <p class="text-sm text-gray-400">Iedereen speelt veilig mee</p>
        </article>
        <article class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center">
          <Lock class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-red-light)]" />
          <h3 class="text-white">Verantwoord</h3>
          <p class="text-sm text-gray-400">Gebruik de app met zorg</p>
        </article>
      </section>

      <section v-for="section in terms" :key="section.title" class="mb-12">
        <div class="mb-4 flex items-center gap-3">
          <component :is="section.icon" class="h-6 w-6" :class="section.color" />
          <h2 class="text-white">{{ section.title }}</h2>
        </div>
        <div class="space-y-4 rounded-2xl border border-white/10 bg-white/5 p-6">
          <p class="text-gray-300">{{ section.intro }}</p>
          <ul v-if="section.list" class="ml-4 list-disc space-y-2 text-gray-300">
            <li v-for="item in section.list" :key="item">
              {{ item }}
            </li>
          </ul>
          <p v-if="section.note" class="text-sm text-gray-400">{{ section.note }}</p>
        </div>
      </section>

      <section class="rounded-2xl border border-white/10 bg-gradient-to-r from-[var(--vibe-yellow-light)]/10 to-[var(--vibe-red-light)]/10 p-8 text-center">
        <h3 class="mb-4 text-2xl font-semibold text-white">Vragen over deze voorwaarden?</h3>
        <p class="mb-6 text-sm text-gray-300">Neem contact met ons op voor toelichting of hulp.</p>
        <NuxtLink class="cta-animated inline-flex items-center justify-center rounded-xl px-8 py-3 text-sm font-semibold text-white transition-transform duration-200 hover:scale-105" to="/contact">
          Contacteer ons
        </NuxtLink>
      </section>
    </main>
    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { FileText, Lock, Shield, UserCheck } from "lucide-vue-next";

const terms = [
  {
    title: "1. Definities",
    intro: "Deze voorwaarden hebben betrekking op het gebruik van de SPEL6 app en alle diensten die daarbij horen.",
    icon: FileText,
    color: "text-[var(--vibe-yellow-light)]",
    list: [
      "SPEL6: de mobiele applicatie en bijbehorende diensten.",
      "Gebruiker: elke persoon die SPEL6 downloadt of gebruikt.",
      "Content: alle vragen, challenges en andere spelonderdelen in de app.",
    ],
  },
  {
    title: "2. Gebruik van de app",
    intro: "Door SPEL6 te gebruiken ga je akkoord met verantwoordelijk gebruik:",
    icon: Shield,
    color: "text-[var(--vibe-green-light)]",
    list: [
      "Gebruik de app uitsluitend voor persoonlijke, niet-commerciële doeleinden.",
      "Je bent 18 jaar of ouder of hebt toestemming van een ouder/verzorger.",
      "Forceer of reverse-engineer de app niet.",
    ],
  },
  {
    title: "3. Content en intellectueel eigendom",
    intro: "Alle content in SPEL6 is beschermd:",
    icon: Lock,
    color: "text-[var(--vibe-red-light)]",
    list: [
      "Content mag niet gekopieerd, gedeeld of hergebruikt worden zonder toestemming.",
      "Gebruik custom content respectvol en zonder rechten van derden te schenden.",
      "We verwijderen content die tegen deze voorwaarden ingaat.",
    ],
  },
  {
    title: "4. Aankopen en abonnementen",
    intro: "Voor betaalde functies gelden de volgende regels:",
    icon: FileText,
    color: "text-[var(--vibe-blue-light)]",
    list: [
      "Aankopen verlopen via App Store of Google Play.",
      "Restitutie kan binnen 14 dagen worden aangevraagd volgens hun beleid.",
      "Wijzigingen in prijzen communiceren we vooraf via de app.",
    ],
  },
  {
    title: "5. Privacy en data",
    intro: "We gaan zorgvuldig om met je gegevens. Zie ook ons Privacy Statement.",
    icon: UserCheck,
    color: "text-[var(--vibe-green-light)]",
    note: "Bij vragen over privacy kun je mailen naar privacy@spel6.nl.",
  },
  {
    title: "6. Aansprakelijkheid",
    intro: "SPEL6 wordt aangeboden zoals hij is (\"as-is\").",
    icon: Shield,
    color: "text-[var(--vibe-red-light)]",
    list: [
      "We zijn niet aansprakelijk voor gevolgschade of gemiste inkomsten.",
      "Gebruik van de app is op eigen risico.",
      "We doen ons best om bugs snel op te lossen, maar geven geen garanties.",
    ],
  },
  {
    title: "7. Wijzigingen",
    intro: "We kunnen deze voorwaarden aanpassen.",
    icon: FileText,
    color: "text-[var(--vibe-yellow-light)]",
    note: "Belangrijke wijzigingen communiceren we via de app en treden direct in werking.",
  },
];
</script>
