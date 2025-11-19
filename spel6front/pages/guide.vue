<template>
  <div class="min-h-screen bg-[#0a0a0a]">
    <AppNavbar />
    <main class="mx-auto max-w-4xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
      <section class="mb-16 text-center">
        <div
          class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[var(--vibe-green-light)]/20"
        >
          <BookOpen class="h-10 w-10 text-[var(--vibe-green-light)]" />
        </div>
        <h1 class="mb-4 text-4xl font-semibold text-white md:text-5xl">
          SPEL6 Guide
        </h1>
        <p class="text-xl text-gray-300">
          Alles wat je moet weten om het maximale uit SPEL6 te halen
        </p>
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
              <div
                :class="[
                  'w-16 h-16 rounded-full flex items-center justify-center text-2xl',
                  step.color,
                ]"
              >
                {{ step.icon }}
              </div>
            </div>
            <div>
              <h3 class="mb-2 text-white">
                Stap {{ step.step }}: {{ step.title }}
              </h3>
              <p class="text-gray-400">{{ step.description }}</p>
            </div>
          </article>
        </div>
      </section>

      <section class="mb-16">
        <div class="mb-8 flex items-center gap-3">
          <Filter class="h-7 w-7 text-[var(--vibe-yellow-light)]" />
          <h2 class="text-white">Filters & Straftypes</h2>
        </div>
        <div class="grid gap-6 md:grid-cols-2">
          <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <h3 class="mb-4 text-xl text-white">Vraagtypes</h3>
            <div class="space-y-4">
              <div
                v-for="filter in guideFilters"
                :key="filter.title"
                class="flex items-start gap-3 rounded-2xl border border-white/5 bg-black/40 p-4"
              >
                <div
                  class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-2xl"
                >
                  {{ filter.icon }}
                </div>
                <div>
                  <p class="font-semibold text-white">{{ filter.title }}</p>
                  <p class="text-sm text-gray-400">{{ filter.description }}</p>
                </div>
              </div>
            </div>
            <p class="mt-4 text-sm text-yellow-300">
              Let op of de filters bij het moment passen! 18+ en spicy kunnen
              heftige vragen bevatten.
            </p>
          </article>
          <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <h3 class="mb-4 text-xl text-white">Straftypes</h3>
            <div class="space-y-4">
              <div
                v-for="penalty in guidePenalties"
                :key="penalty.title"
                class="flex items-start gap-3 rounded-2xl border border-white/5 bg-black/40 p-4"
              >
                <div
                  class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-2xl"
                >
                  {{ penalty.icon }}
                </div>
                <div>
                  <p class="font-semibold text-white">{{ penalty.title }}</p>
                  <p class="text-sm text-gray-400">{{ penalty.description }}</p>
                </div>
              </div>
            </div>
            <p class="mt-4 text-sm text-yellow-300">
              Combineer gerust meerdere straffen. De app houdt bij wie wat nog
              open heeft staan.
            </p>
          </article>
        </div>
      </section>

      <section class="mb-16">
        <div class="mb-8 flex items-center gap-3">
          <Medal class="h-7 w-7 text-[var(--vibe-green-light)]" />
          <h2 class="text-white">Score & Eindstraf</h2>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
          <p class="mb-4 text-gray-300">
            SPEL6 houdt automatisch de score bij. Goede antwoorden en correct
            uitgevoerde opdrachten leveren punten op, als je het fout hebt, loop
            je punten mis.
          </p>
          <ul class="space-y-4">
            <li
              v-for="item in scoreHighlights"
              :key="item.title"
              class="flex gap-3"
            >
              <div
                class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-lg"
              >
                {{ item.icon }}
              </div>
              <div>
                <p class="font-semibold text-white">{{ item.title }}</p>
                <p class="text-sm text-gray-400">{{ item.description }}</p>
              </div>
            </li>
          </ul>
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
            <p class="text-sm text-gray-500">
              Intensiteit: {{ mode.intensity }}
            </p>
          </article>
        </div>
      </section>

      <section class="mb-16">
        <div class="mb-8 flex items-center gap-3">
          <Zap class="h-7 w-7 text-[var(--vibe-yellow-light)]" />
          <h2 class="text-white">Tips & Tricks</h2>
        </div>
        <div class="space-y-4">
          <article
            v-for="tip in tips"
            :key="tip.title"
            class="rounded-2xl border border-white/10 bg-white/5 p-6"
          >
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
        <div
          class="space-y-6 rounded-2xl border border-white/10 bg-white/5 p-6"
        >
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
        <div
          class="rounded-2xl border border-white/10 bg-gradient-to-br from-[var(--vibe-red-light)]/10 to-[var(--vibe-blue-light)]/10 p-8"
        >
          <ul class="space-y-4 text-gray-300">
            <li
              v-for="rule in rules"
              :key="rule.title"
              class="flex items-start gap-3"
            >
              <Trophy
                class="mt-1 h-5 w-5 flex-shrink-0 text-[var(--vibe-yellow-light)]"
              />
              <div>
                <strong class="text-white">{{ rule.title }}</strong>
                <span class="ml-1"> {{ rule.description }}</span>
              </div>
            </li>
          </ul>
        </div>
      </section>

      <section
        class="rounded-2xl border border-white/10 bg-white/5 p-8 text-center"
      >
        <h3 class="mb-4 text-white">Nog vragen?</h3>
        <p class="mb-6 text-gray-300">
          Bekijk onze FAQ of neem contact met ons op
        </p>
        <div class="flex flex-col justify-center gap-4 sm:flex-row">
          <NuxtLink
            class="cta-animated inline-flex items-center justify-center rounded-xl px-6 py-3 text-white transition-transform duration-200 hover:scale-105"
            to="/faq"
          >
            Naar FAQ
          </NuxtLink>
          <NuxtLink
            class="cta-animated inline-flex items-center justify-center rounded-xl px-6 py-3 text-white transition-transform duration-200 hover:scale-105"
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
import {
  BookOpen,
  Filter,
  Heart,
  Medal,
  Settings,
  Trophy,
  Users,
  Zap,
} from "lucide-vue-next";

const quickStart = [
  {
    step: "1",
    title: "Download en open de app",
    description:
      "Download SPEL6 via de App Store of Google Play. Geen advertenties of abonnementen, een eenmalig bedrag van €2.99,-.",
    icon: "📱",
    color: "vibe-green-light",
  },
  {
    step: "2",
    title: "Kies je settings",
    description:
      "Selecteer de sfeer die bij het moment past: Feest, Vrienden, Collegas of Date. Elke sfeer heeft unieke vragen!",
    icon: "🎯",
    color: "vibe-yellow-light",
  },
  {
    step: "3",
    title: "Verzamel je spelers",
    description:
      "Roep de groep bij elkaar. SPEL6 werkt het beste met 3-6 spelers, maar je kunt het spelen met 2-10 spelers!",
    icon: "👥",
    color: "vibe-blue-light",
  },
  {
    step: "4",
    title: "Bepaal de straftypes",
    description:
      "Geef aan of jullie willen drinken, extra vragen beantwoorden, gênante verhalen delen of opdrachten/dare-cards doen.",
    icon: "🚀",
    color: "vibe-red-light",
  },
  {
    step: "5",
    title: "Kies vraagfilters",
    description:
      "Selecteer welke vraagtypes jullie willen: van Normaal en Diepgaand tot 18+, Spicy of Random Straf voor onverwachte wendingen.",
    icon: "🧭",
    color: "vibe-blue-dark",
  },
  {
    step: "6",
    title: "Start het spel!",
    description:
      "Druk op START en geef de telefoon door. Volg de instructies op het scherm en veel plezier!",
    icon: "⚡",
    color: "vibe-red-dark",
  },
];

const guideFilters = [
  {
    title: "18+",
    description:
      "Kies alleen voor 18+ onderwerpen als iedereen zich daar goed bij voelt.",
    icon: "🔥",
  },
  {
    title: "Normaal",
    description: "Lichte vragen om op te warmen of om met familie te spelen.",
    icon: "✅",
  },
  {
    title: "Spicy",
    description:
      "Seksuele of pikante vragen en opdrachten voor stelletjes & durvers.",
    icon: "🌶️",
  },
  {
    title: "Diepgaand",
    description: "Persoonlijke, serieuze of emotionele vragen.",
    icon: "💬",
  },
  {
    title: "Random Straf",
    description:
      "De app deelt uit het niets straffen uit, zelfs wanneer je antwoord juist was.",
    icon: "🎲",
  },
];

const guidePenalties = [
  {
    title: "Drinken",
    description:
      "Neem een slok (met of zonder alcohol) wanneer je de straf krijgt.",
    icon: "🍻",
  },
  {
    title: "Vraag",
    description: "Je beantwoordt een extra vraag of iets persoonlijks.",
    icon: "❓",
  },
  {
    title: "Genant",
    description: "Vertel iets gênants of herbeleef een cringy moment.",
    icon: "😳",
  },
  {
    title: "Dare",
    description: "Doe de opdracht, hoe maf die ook is.",
    icon: "🎯",
  },
  {
    title: "Acteren",
    description: "Speel een mini-scène of imiteer iemand.",
    icon: "🎭",
  },
  {
    title: "Persoonlijk",
    description: "Geef complimenten of deel iets liefs over iemand anders.",
    icon: "💌",
  },
];

const scoreHighlights = [
  {
    title: "Live scoreboard",
    description:
      "De app telt automatisch de punten op. Na de laatste vraag zul je de score pas voor het eerst zien.",
    icon: "📊",
  },
  {
    title: "Laatste plek op de radar",
    description:
      "Spelers met de laagste score riskeren een eindstraf. Zijn er meerdere laatste plaatsen, dan kiest de winnaar uit wie de straf moet ondergaan.",
    icon: "🎯",
  },
  {
    title: "Winnaar kiest eindstraf",
    description:
      "Na de laatste ronde wijst de winnaar een straf toe én kiest hij/zij welke laagst scorende speler die moet uitvoeren.",
    icon: "👑",
  },
];

const modes = [
  {
    title: "Feest",
    description:
      "De wildste vragen en challenges voor een onvergetelijk feest. Laat je haar los en maak chaos!",
    icon: "🎉",
    intensity: "⭐⭐⭐⭐⭐",
    class:
      "bg-gradient-to-br from-[var(--vibe-yellow-light)]/10 to-transparent",
  },
  {
    title: "Vrienden",
    description:
      "Leer je vrienden beter kennen met diepgaande en grappige vragen. Perfect voor een gezellige avond.",
    icon: "🤝",
    intensity: "⭐⭐⭐",
    class: "bg-gradient-to-br from-[var(--vibe-green-light)]/10 to-transparent",
  },
  {
    title: "Collega's",
    description:
      "IJsbrekers en teambuilding vragen voor een ontspannen sfeer op het werk. Zakelijk maar niet saai!",
    icon: "💼",
    intensity: "⭐⭐",
    class: "bg-gradient-to-br from-[var(--vibe-blue-light)]/10 to-transparent",
  },
  {
    title: "Date",
    description:
      "Spannende vragen om elkaar beter te leren kennen. Van luchtig tot intiem - perfect voor een eerste of tweede date!",
    icon: "💘",
    intensity: "⭐⭐⭐⭐",
    class: "bg-gradient-to-br from-[var(--vibe-red-light)]/10 to-transparent",
  },
];

const tips = [
  {
    title: "💡 Stel grenzen vooraf",
    description:
      "Bespreek voor je begint wat wel en niet oké is. SPEL6 kan intensief worden - respecteer elkaars grenzen!",
  },
  {
    title: "🔄 Wissel regelmatig",
    description:
      "Geef de telefoon door na elke vraag. Zo blijft iedereen betrokken en kan niemand vals spelen!",
  },
  {
    title: "🎭 Maak er een show van",
    description:
      "Go all in! Hoe gekker, hoe leuker. Maak van elke ronde een safe space. Niemand oordeelt, iedereen doet mee.",
  },
  {
    title: "📸 Leg momenten vast",
    description:
      "Maak foto's en video's van de grappigste momenten (met toestemming natuurlijk). Herinneringen voor later!",
  },
];

const features = [
  {
    title: "⚙️ Pas het spel aan",
    description:
      "Gebruik de instellingen om de intensiteit aan te passen. Filter bepaalde type vragen of pas de straftypes aan.",
  },
  {
    title: "⏱️ Timer functie",
    description:
      "Sommige challenges vereisen een timer. Houd een tweede telefoon beschikbaar tijdens het spel!",
  },
  {
    title: "🚫",
    description:
      "SPEL6 bied de optie om een vraag of opdracht over te slaan. Dit geeft geen minpunten. Het doel is dat het spel leuk blijft voor iedereen. Geen groepsdruk.",
  },
];

const rules = [
  {
    title: "Respect is key:",
    description:
      "Lach met elkaar, niet om elkaar. Iedereen moet zich veilig voelen.",
  },
  {
    title: "Eerlijkheid duurt het langst:",
    description:
      "Wees eerlijk bij je antwoorden. Dat maakt het spel veel leuker!",
  },
  {
    title: "Geen dwang:",
    description:
      "Niemand hoeft iets te doen wat ze niet willen. Skip is altijd een optie.",
  },
  {
    title: "Wat in het spel gebeurt, blijft in het spel:",
    description:
      "Deel geen gênante verhalen buiten de groep zonder toestemming.",
  },
  {
    title: "Speel verantwoord:",
    description:
      "Als je kiest voor het drink straftype waar alcohol bij komt kijken - drink met mate en zorg voor elkaar.",
  },
];
</script>
