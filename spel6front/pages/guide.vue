<template>
  <div class="min-h-screen bg-[#0a0a0a]">
    <AppNavbar />
    <main class="mx-auto max-w-4xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
      <section class="mb-16 text-center">
        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[var(--vibe-green-light)]/20">
          <BookOpen class="h-10 w-10 text-[var(--vibe-green-light)]" />
        </div>
        <h1 class="mb-4 text-4xl font-semibold text-white md:text-5xl">SPEL6 Guide</h1>
        <p class="text-xl text-gray-300">Alles wat je moet weten om het maximale uit SPEL6 te halen</p>
      </section>

      <section class="mb-16">
        <h2 class="mb-8 text-2xl font-semibold text-white">Snel aan de slag</h2>
        <div class="space-y-6">
          <article
            v-for="step in quickStart"
            :key="step.step"
            class="flex gap-6 rounded-2xl border border-white/10 bg-white/5 p-6 transition-all hover:bg-white/10"
          >
            <div class="flex-shrink-0">
              <div :class="['w-16 h-16 rounded-full flex items-center justify-center text-2xl', step.color]">
                {{ step.icon }}
              </div>
            </div>
            <div>
              <h3 class="mb-2 text-white">Stap {{ step.step }}: {{ step.title }}</h3>
              <p class="text-gray-400">{{ step.description }}</p>
            </div>
          </article>
        </div>
      </section>

      <section class="mb-16">
        <div class="mb-8 flex items-center gap-3">
          <Users class="h-7 w-7 text-[var(--vibe-blue-light)]" />
          <h2 class="text-white">Spelmodi uitgelegd</h2>
        </div>
        <div class="grid gap-6 md:grid-cols-2">
          <article
            v-for="mode in modes"
            :key="mode.title"
            class="rounded-2xl border border-white/10 p-6"
            :class="mode.class"
          >
            <div class="mb-3 text-3xl">{{ mode.icon }}</div>
            <h3 class="mb-3 text-white">{{ mode.title }}</h3>
            <p class="mb-4 text-gray-400">{{ mode.description }}</p>
            <p class="text-sm text-gray-500">Intensiteit: {{ mode.intensity }}</p>
          </article>
        </div>
      </section>

      <section class="mb-16">
        <div class="mb-8 flex items-center gap-3">
          <Zap class="h-7 w-7 text-[var(--vibe-yellow-light)]" />
          <h2 class="text-white">Tips & Tricks</h2>
        </div>
        <div class="space-y-4">
          <article v-for="tip in tips" :key="tip.title" class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <h3 class="mb-3 text-white">{{ tip.title }}</h3>
            <p class="text-gray-400">{{ tip.description }}</p>
          </article>
        </div>
      </section>

      <section class="mb-16">
        <div class="mb-8 flex items-center gap-3">
          <Settings class="h-7 w-7 text-[var(--vibe-green-light)]" />
          <h2 class="text-white">Features & Instellingen</h2>
        </div>
        <div class="space-y-6 rounded-2xl border border-white/10 bg-white/5 p-6">
          <div
            v-for="(feature, index) in features"
            :key="feature.title"
            :class="index === 0 ? '' : 'border-t border-white/10 pt-6'"
          >
            <h3 class="mb-2 text-white">{{ feature.title }}</h3>
            <p class="text-gray-400">{{ feature.description }}</p>
          </div>
        </div>
      </section>

      <section class="mb-16">
        <div class="mb-8 flex items-center gap-3">
          <Heart class="h-7 w-7 text-[var(--vibe-red-light)]" />
          <h2 class="text-white">Spelregels & Etiquette</h2>
        </div>
        <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-[var(--vibe-red-light)]/10 to-[var(--vibe-blue-light)]/10 p-8">
          <ul class="space-y-4 text-gray-300">
            <li v-for="rule in rules" :key="rule.title" class="flex items-start gap-3">
              <Trophy class="mt-1 h-5 w-5 flex-shrink-0 text-[var(--vibe-yellow-light)]" />
              <div>
                <strong class="text-white">{{ rule.title }}</strong>
                <span> {{ rule.description }}</span>
              </div>
            </li>
          </ul>
        </div>
      </section>

      <section class="rounded-2xl border border-white/10 bg-white/5 p-8 text-center">
        <h3 class="mb-4 text-white">Nog vragen?</h3>
        <p class="mb-6 text-gray-300">Bekijk onze FAQ of neem contact met ons op</p>
        <div class="flex flex-col justify-center gap-4 sm:flex-row">
          <NuxtLink class="rounded-xl bg-white/10 px-6 py-3 text-white transition-colors hover:bg-white/20" to="/faq">
            Naar FAQ
          </NuxtLink>
          <NuxtLink
            class="rounded-xl bg-gradient-to-r from-[var(--vibe-green-light)] to-[var(--vibe-blue-light)] px-6 py-3 text-white transition-opacity hover:opacity-90"
            to="/contact"
          >
            Contact
          </NuxtLink>
        </div>
      </section>
    </main>
    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { BookOpen, Heart, Settings, Trophy, Users, Zap } from "lucide-vue-next";

const quickStart = [
  {
    step: "1",
    title: "Download en open de app",
    description: "Download SPEL6 gratis via de App Store of Google Play. Open de app en kies je taal.",
    icon: "📱",
    color: "vibe-green-light",
  },
  {
    step: "2",
    title: "Kies je speltype",
    description: "Selecteer de sfeer die bij jullie past: Feest, Vrienden, Collegas of Date. Elke sfeer heeft unieke vragen!",
    icon: "🎯",
    color: "vibe-yellow-light",
  },
  {
    step: "3",
    title: "Verzamel je spelers",
    description: "Roep je vrienden bij elkaar. SPEL6 werkt het beste met 3-8 spelers, maar je kunt met zoveel spelen als je wilt!",
    icon: "👥",
    color: "vibe-blue-light",
  },
  {
    step: "4",
    title: "Start het spel!",
    description: "Druk op START en geef de telefoon door. Volg de instructies op het scherm en veel plezier!",
    icon: "🚀",
    color: "vibe-red-light",
  },
];

const modes = [
  {
    title: "Feest",
    description: "De wildste vragen en challenges voor een onvergetelijk feest. Laat je haar los en maak chaos!",
    icon: "🎉",
    intensity: "⭐⭐⭐⭐⭐",
    class: "bg-gradient-to-br from-[var(--vibe-yellow-light)]/10 to-transparent",
  },
  {
    title: "Vrienden",
    description: "Leer je vrienden beter kennen met diepgaande en grappige vragen. Perfect voor een gezellige avond.",
    icon: "🤝",
    intensity: "⭐⭐⭐",
    class: "bg-gradient-to-br from-[var(--vibe-green-light)]/10 to-transparent",
  },
  {
    title: "Collega's",
    description: "IJsbrekers en teambuilding vragen voor een ontspannen sfeer op het werk. Zakelijk maar niet saai!",
    icon: "💼",
    intensity: "⭐⭐",
    class: "bg-gradient-to-br from-[var(--vibe-blue-light)]/10 to-transparent",
  },
  {
    title: "Date",
    description: "Spannende vragen om elkaar beter te leren kennen. Van luchtig tot intiem - perfect voor een eerste of tweede date!",
    icon: "💘",
    intensity: "⭐⭐⭐⭐",
    class: "bg-gradient-to-br from-[var(--vibe-red-light)]/10 to-transparent",
  },
];

const tips = [
  { title: "💡 Stel grenzen vooraf", description: "Bespreek voor je begint wat wel en niet oké is. SPEL6 kan intensief worden - respecteer elkaars grenzen!" },
  { title: "🔄 Wissel regelmatig", description: "Geef de telefoon door na elke vraag. Zo blijft iedereen betrokken en niemand kan vals spelen!" },
  { title: "🎭 Maak er een show van", description: "Bij challenges - go all in! Hoe gekker, hoe leuker. Niemand oordeelt, iedereen doet mee." },
  { title: "📸 Leg momenten vast", description: "Maak foto's en video's van de grappigste momenten (met toestemming natuurlijk). Herinneringen voor later!" },
];

const features = [
  {
    title: "⚙️ Pas het spel aan",
    description: "Gebruik de instellingen om de intensiteit aan te passen. Filter bepaalde type vragen of pas de snelheid aan.",
  },
  {
    title: "🔇 Geluid & Trillingen",
    description: "Zet geluid en trillingen aan voor extra spanning bij bepaalde vragen en challenges!",
  },
  {
    title: "⏱️ Timer functie",
    description: "Sommige challenges hebben een timer. Houd je telefoon in de gaten en wees snel!",
  },
  {
    title: "🌙 Donkere modus",
    description: "SPEL6 gebruikt standaard een donker thema - perfect voor 's avonds en vriendelijk voor je ogen.",
  },
];

const rules = [
  { title: "Respect is key:", description: "Lach met elkaar, niet om elkaar. Iedereen moet zich veilig voelen." },
  { title: "Eerlijkheid duurt het langst:", description: "Wees eerlijk bij je antwoorden. Dat maakt het spel veel leuker!" },
  { title: "Geen dwang:", description: "Niemand hoeft iets te doen wat ze niet willen. Skip is altijd een optie." },
  {
    title: "Wat in het spel gebeurt, blijft in het spel:",
    description: "Deel geen gênante verhalen buiten de groep zonder toestemming.",
  },
  { title: "Speel verantwoord:", description: "Als er alcohol bij komt kijken - drink met mate en zorg voor elkaar." },
];
</script>
