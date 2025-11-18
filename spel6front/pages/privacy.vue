<template>
  <div class="min-h-screen bg-[#0a0a0a]">
    <AppNavbar />
    <main class="mx-auto max-w-4xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
      <header class="mb-16 text-center">
        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[var(--vibe-blue-light)]/20">
          <Shield class="h-10 w-10 text-[var(--vibe-blue-light)]" />
        </div>
        <h1 class="mb-4 text-4xl font-semibold text-white md:text-5xl">Privacy Statement</h1>
        <p class="text-xl text-gray-300">Jouw privacy is belangrijk voor ons</p>
        <p class="mt-4 text-sm text-gray-500">Laatst bijgewerkt: November 2024</p>
      </header>

      <section class="mb-16 grid gap-4 md:grid-cols-3">
        <article class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center">
          <Lock class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-green-light)]" />
          <h3 class="text-white">Veilig</h3>
          <p class="text-sm text-gray-400">Jouw data is beveiligd</p>
        </article>
        <article class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center">
          <Eye class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-yellow-light)]" />
          <h3 class="text-white">Transparant</h3>
          <p class="text-sm text-gray-400">Geen verborgen agenda</p>
        </article>
        <article class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center">
          <UserCheck class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-red-light)]" />
          <h3 class="text-white">Controle</h3>
          <p class="text-sm text-gray-400">Jij bepaalt</p>
        </article>
      </section>

      <section v-for="section in sections" :key="section.title" class="mb-12">
        <div class="mb-4 flex items-center gap-3">
          <component :is="section.icon" class="h-6 w-6" :class="section.color" />
          <h2 class="text-white">{{ section.title }}</h2>
        </div>
        <div class="space-y-4 rounded-2xl border border-white/10 bg-white/5 p-6">
          <p class="text-gray-300">{{ section.intro }}</p>
          <ul v-if="section.list" class="ml-4 list-disc space-y-2 text-gray-300">
            <li v-for="item in section.list" :key="item.title">
              <span>
                <strong class="text-white" v-if="item.title">{{ item.title }}</strong>
                {{ item.text }}
              </span>
            </li>
          </ul>
          <p v-if="section.extra" class="text-sm text-gray-400">{{ section.extra }}</p>
          <p v-if="section.highlight" class="rounded-xl bg-[var(--vibe-green-light)]/10 p-4 text-[var(--vibe-green-light)]">{{ section.highlight }}</p>
        </div>
      </section>

      <section class="rounded-2xl border border-white/10 bg-gradient-to-r from-[var(--vibe-blue-light)]/10 to-[var(--vibe-red-light)]/10 p-8 text-center">
        <h3 class="mb-4 text-2xl font-semibold text-white">Vragen over je privacy?</h3>
        <p class="mb-6 text-sm text-gray-300">We staan altijd klaar om je vragen te beantwoorden.</p>
        <NuxtLink class="cta-animated inline-flex items-center justify-center rounded-xl px-8 py-3 text-sm font-semibold text-white transition-transform duration-200 hover:scale-105" to="/contact">
          Neem contact op
        </NuxtLink>
      </section>
    </main>
    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { Database, Eye, FileText, Lock, Shield, UserCheck } from "lucide-vue-next";

const sections = [
  {
    title: "Welke gegevens verzamelen we?",
    intro: "SPEL6 verzamelt minimale gegevens om de app goed te laten functioneren:",
    icon: Database,
    color: "text-[var(--vibe-blue-light)]",
    list: [
      { title: "Apparaatinformatie:", text: " Type apparaat, besturingssysteem en app-versie voor technische ondersteuning." },
      { title: "Spelstatistieken:", text: " Anonieme gegevens over gebruik om de app te verbeteren." },
      { title: "Crashrapporten:", text: " Technische informatie bij app-crashes om bugs te kunnen oplossen." },
    ],
    extra: "We vragen GEEN persoonlijke informatie zoals naam, email of telefoonnummer voor het gebruik van de app.",
  },
  {
    title: "Hoe gebruiken we je gegevens?",
    intro: "De verzamelde gegevens worden uitsluitend gebruikt voor:",
    icon: Lock,
    color: "text-[var(--vibe-green-light)]",
    list: [
      { text: "Het verbeteren van de app-functionaliteit" },
      { text: "Het oplossen van technische problemen" },
      { text: "Het ontwikkelen van nieuwe features" },
      { text: "Het analyseren van gebruikspatronen (anoniem)" },
    ],
    highlight: "✓ We verkopen NOOIT je gegevens aan derden",
  },
  {
    title: "Hoe beschermen we je gegevens?",
    intro: "We nemen jouw privacy serieus en hebben verschillende veiligheidsmaatregelen getroffen:",
    icon: Shield,
    color: "text-[var(--vibe-yellow-light)]",
    list: [
      { text: "Alle data wordt versleuteld opgeslagen en verzonden" },
      { text: "We gebruiken veilige servers met regelmatige updates" },
      { text: "Beperkte toegang tot gegevens alleen voor noodzakelijk personeel" },
      { text: "Regelmatige beveiligingsaudits" },
    ],
  },
  {
    title: "Cookies en tracking",
    intro: "SPEL6 gebruikt minimale tracking technologie:",
    icon: Eye,
    color: "text-[var(--vibe-red-light)]",
    list: [
      { text: "Functionele cookies voor het opslaan van spelvoorkeuren" },
      { text: "Analytische cookies (anoniem) voor het begrijpen van app-gebruik" },
      { text: "Geen advertentie-tracking of social media pixels" },
    ],
  },
  {
    title: "Jouw rechten",
    intro: "Je hebt altijd het recht om:",
    icon: UserCheck,
    color: "text-[var(--vibe-blue-light)]",
    list: [
      { text: "Inzage te vragen in je gegevens" },
      { text: "Je gegevens te laten verwijderen" },
      { text: "Je gegevens te laten corrigeren" },
      { text: "Bezwaar te maken tegen gegevensverwerking" },
      { text: "Je toestemming in te trekken" },
    ],
    extra: "Neem contact op via privacy@spel6.nl voor het uitoefenen van je rechten.",
  },
  {
    title: "Wijzigingen in dit statement",
    intro: "We kunnen dit privacy statement van tijd tot tijd bijwerken om wijzigingen in onze praktijken of om juridische redenen te weerspiegelen.",
    icon: FileText,
    color: "text-[var(--vibe-green-light)]",
    extra: "Bij belangrijke wijzigingen zullen we je hiervan op de hoogte stellen via de app.",
  },
];
</script>
