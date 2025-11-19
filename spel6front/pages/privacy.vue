<template>
  <div class="min-h-screen bg-[#0a0a0a]">
    <AppNavbar />
    <main class="mx-auto max-w-4xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
      <header class="mb-16 text-center">
        <div
          class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[var(--vibe-blue-light)]/20"
        >
          <Shield class="h-10 w-10 text-[var(--vibe-blue-light)]" />
        </div>
        <h1 class="mb-4 text-4xl font-semibold text-white md:text-5xl">
          Privacy Statement
        </h1>
        <p class="text-xl text-gray-300">Jouw privacy is belangrijk voor ons</p>
        <p class="mt-2 text-sm text-gray-400">
          SPEL6 is zo gebouwd dat we zo min mogelijk van jou hoeven te weten.
        </p>
        <p class="mt-4 text-sm text-gray-500">
          Laatst bijgewerkt: November 2024
        </p>
      </header>

      <section class="mb-16 grid gap-4 md:grid-cols-3">
        <article
          class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center"
        >
          <Lock class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-green-light)]" />
          <h3 class="text-white">Veilig</h3>
          <p class="text-sm text-gray-400">
            Geen accounts, geen centrale spelersdatabase, geen opslag van
            antwoorden.
          </p>
        </article>
        <article
          class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center"
        >
          <Eye class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-yellow-light)]" />
          <h3 class="text-white">Transparant</h3>
          <p class="text-sm text-gray-400">
            We leggen duidelijk uit wat we wél en niet opslaan.
          </p>
        </article>
        <article
          class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center"
        >
          <UserCheck
            class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-red-light)]"
          />
          <h3 class="text-white">Controle</h3>
          <p class="text-sm text-gray-400">
            Je speldata blijft zoveel mogelijk op je eigen device.
          </p>
        </article>
      </section>

      <section v-for="section in sections" :key="section.title" class="mb-12">
        <div class="mb-4 flex items-center gap-3">
          <component
            :is="section.icon"
            class="h-6 w-6"
            :class="section.color"
          />
          <h2 class="text-white">{{ section.title }}</h2>
        </div>
        <div
          class="space-y-4 rounded-2xl border border-white/10 bg-white/5 p-6"
        >
          <p class="text-gray-300">
            {{ section.intro }}
          </p>
          <ul
            v-if="section.list"
            class="ml-4 list-disc space-y-2 text-gray-300"
          >
            <li v-for="item in section.list" :key="item.text">
              <span>
                <strong class="text-white" v-if="item.title">
                  {{ item.title }}
                </strong>
                {{ item.text }}
              </span>
            </li>
          </ul>
          <p v-if="section.extra" class="text-sm text-gray-400">
            {{ section.extra }}
          </p>
          <p
            v-if="section.highlight"
            class="rounded-xl bg-[var(--vibe-green-light)]/10 p-4 text-[var(--vibe-green-light)]"
          >
            {{ section.highlight }}
          </p>
        </div>
      </section>

      <section
        class="rounded-2xl border border-white/10 bg-gradient-to-r from-[var(--vibe-blue-light)]/10 to-[var(--vibe-red-light)]/10 p-8 text-center"
      >
        <h3 class="mb-4 text-2xl font-semibold text-white">
          Vragen over je privacy?
        </h3>
        <p class="mb-6 text-sm text-gray-300">
          We staan altijd klaar om je vragen te beantwoorden.
        </p>
        <NuxtLink
          class="cta-animated inline-flex items-center justify-center rounded-xl px-8 py-3 text-sm font-semibold text-white transition-transform duration-200 hover:scale-105"
          to="/contact"
        >
          Neem contact op
        </NuxtLink>
      </section>
    </main>
    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import {
  Database,
  Eye,
  FileText,
  Lock,
  Shield,
  UserCheck,
} from "lucide-vue-next";

const sections = [
  {
    title: "Welke gegevens verzamelen we?",
    intro:
      "SPEL6 is zo ontworpen dat we geen persoonlijke gegevens van jou hoeven op te slaan. De app werkt volledig zonder account en zonder dat wij weten wie je bent.",
    icon: Database,
    color: "text-[var(--vibe-blue-light)]",
    list: [
      {
        title: "Apparaatinformatie:",
        text: " Type apparaat, besturingssysteem en app-versie. Dit gebruiken we alleen om de app technisch goed te laten werken en prestaties te verbeteren.",
      },
      {
        title: "Lokale spelgegevens:",
        text: " Spelinstellingen, gekozen gamemodes, filters en voortgang worden uitsluitend lokaal op jouw eigen device opgeslagen. Wij hebben hier geen toegang toe en er wordt niets naar een centrale database gestuurd.",
      },
      {
        title: "Contactformulier & e-mail:",
        text: " Als je ons een bericht stuurt via het contactformulier of rechtstreeks per e-mail, ontvangen we je bericht (en eventueel naam en e-mailadres) in onze mailbox. Deze gegevens worden niet in een database opgeslagen.",
      },
    ],
    extra:
      "We slaan géén accounts, wachtwoorden, spelantwoorden of andere persoonlijk herleidbare gegevens op in een eigen database.",
  },
  {
    title: "Hoe gebruiken we je gegevens?",
    intro:
      "De beperkte gegevens die we verwerken, gebruiken we alleen voor de volgende doelen:",
    icon: Lock,
    color: "text-[var(--vibe-green-light)]",
    list: [
      {
        text: "Het verbeteren van de app-prestaties op basis van (anonieme) app- en apparaat-informatie.",
      },
      {
        text: "Het oplossen van technische problemen, bijvoorbeeld met behulp van crashinformatie.",
      },
      {
        text: "Het beantwoorden van jouw vragen wanneer je ons contactformulier invult of mailt.",
      },
    ],
    highlight: "✓ We verkopen NOOIT je gegevens aan derden",
  },
  {
    title: "Hoe beschermen we je gegevens?",
    intro:
      "We houden de hoeveelheid data zo klein mogelijk en beschermen wat we wél verwerken:",
    icon: Shield,
    color: "text-[var(--vibe-yellow-light)]",
    list: [
      {
        text: "De app gebruikt zoveel mogelijk lokale opslag op je eigen toestel; er is geen centrale spelersdatabase.",
      },
      {
        text: "Berichten via het contactformulier en e-mail worden via versleutelde verbindingen (bijv. TLS) verzonden.",
      },
      {
        text: "Onze mailbox is beveiligd en alleen toegankelijk voor geautoriseerde personen.",
      },
    ],
  },
  {
    title: "Cookies en tracking",
    intro:
      "SPEL6 gebruikt minimale technieken voor instellingen en basisstatistieken, zonder agressieve tracking:",
    icon: Eye,
    color: "text-[var(--vibe-red-light)]",
    list: [
      {
        text: "In de app wordt lokale opslag gebruikt voor je instellingen en voorkeuren. Dit blijft op jouw device.",
      },
      {
        text: "Op de website kunnen functionele en anonieme analytische cookies worden gebruikt om de site te verbeteren.",
      },
      {
        text: "Er is geen advertentietracking, geen verkoop van data en geen social media pixels om je te volgen.",
      },
    ],
  },
  {
    title: "Jouw rechten",
    intro:
      "Omdat we vrijwel geen persoonlijke gegevens centraal opslaan, zijn de privacyrisico’s laag. Toch kun je altijd contact met ons opnemen om:",
    icon: UserCheck,
    color: "text-[var(--vibe-blue-light)]",
    list: [
      {
        text: "Na te vragen welke gegevens we eventueel van jou hebben (bijvoorbeeld e-mails in onze inbox).",
      },
      {
        text: "Te vragen om e-mails of contactformulier-berichten waarin jouw gegevens staan, te verwijderen.",
      },
      {
        text: "Bezwaar te maken als je vindt dat we gegevens onterecht verwerken.",
      },
    ],
    extra:
      "Let op: je spelantwoorden, voortgang en instellingen staan lokaal op je eigen device. Die worden niet in onze systemen opgeslagen en kunnen we dus ook niet voor je inzien of verwijderen.",
  },
  {
    title: "Wijzigingen in dit statement",
    intro:
      "We kunnen dit privacy statement van tijd tot tijd bijwerken om wijzigingen in onze praktijken of om juridische redenen te weerspiegelen.",
    icon: FileText,
    color: "text-[var(--vibe-green-light)]",
    extra:
      "Bij belangrijke wijzigingen zullen we je hiervan op de hoogte stellen via de website of de app.",
  },
];
</script>
