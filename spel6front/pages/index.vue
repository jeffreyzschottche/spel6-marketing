<template>
  <div class="min-h-screen bg-[#0a0a0a] text-white">
    <AppNavbar />

    <!-- Hero -->
    <section
      class="relative flex min-h-screen items-center justify-center overflow-hidden pt-24"
    >
      <div class="absolute inset-0">
        <div
          class="absolute top-1/4 left-1/4 h-96 w-96 rounded-full bg-[var(--vibe-blue-light)] blur-[120px] opacity-20"
        />
        <div
          class="absolute bottom-1/4 right-1/4 h-96 w-96 rounded-full bg-[var(--vibe-red-light)] blur-[120px] opacity-20"
        />
        <div
          class="absolute left-1/2 top-1/2 h-[500px] w-[500px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-[var(--vibe-yellow-light)] blur-[150px] opacity-10"
        />
      </div>
      <div
        class="relative z-10 mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8"
      >
        <div class="logo-pulse mx-auto mb-4 w-fit">
          <img
            :src="spel6Logo"
            alt="SPEL6"
            class="mx-auto h-auto w-full max-w-[240px] sm:max-w-[300px] lg:max-w-[360px]"
          />
        </div>
        <h1
          class="mx-auto mb-6 max-w-4xl text-4xl font-semibold leading-tight text-white md:text-6xl"
        >
          Het ultieme partyspel voor onvergetelijke momenten
        </h1>
        <p class="mx-auto mb-12 max-w-3xl text-xl text-gray-300">
          Kies je sfeer en gamemodes, speel met je crew en maak van elke avond
          een feest. Duizenden vragen, duizenden opdrachten eindeloos plezier.
        </p>
        <div class="mb-8 flex flex-col justify-center gap-4 sm:flex-row">
          <a
            v-for="store in stores"
            :key="store.label"
            href="#"
            class="inline-flex items-center justify-center gap-3 rounded-2xl bg-white px-8 py-4 text-black transition-all hover:scale-105 hover:bg-gray-100"
          >
            <img :src="store.iconSrc" :alt="store.label" class="h-6 w-auto" />
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
          <div
            class="absolute inset-0 rounded-3xl bg-gradient-to-r from-[var(--vibe-green-light)] to-[var(--vibe-blue-light)] opacity-20 blur-xl"
          />
          <ImageWithFallback
            :src="featureSections[0].image"
            alt="Spelen met vrienden"
            class="relative h-[400px] w-full rounded-3xl object-cover"
          />
        </div>
        <div>
          <h2 class="mb-6 text-3xl font-semibold text-white">
            Partyspel voor met je vrienden
          </h2>
          <p class="mb-6 text-lg text-gray-300">
            SPEL6 brengt je dichter bij je vrienden dan ooit tevoren. Met
            duizenden vragen en opdrachten leer je elkaar op een compleet nieuwe
            manier kennen terwijl je super veel lol hebt.
          </p>
          <ul class="space-y-4">
            <li
              v-for="item in friendHighlights"
              :key="item"
              class="flex items-start gap-3 text-gray-300"
            >
              <span
                class="mt-1 rounded-full bg-[var(--vibe-green-light)]/20 p-1"
              >
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
          <h2 class="mb-6 text-3xl font-semibold text-white">
            Altijd en overal
          </h2>
          <p class="mb-6 text-lg text-gray-300">
            Of je nu op een date bent, op een feestje, werk of bij vrienden,
            SPEL6 gaat overal mee naartoe. Het is beschikbaar in het Nederlands,
            Duits en Engels. Met verschillende game modes, vibes en filters
            creer je het perfecte spel voor het juiste moment.
          </p>
          <ul class="space-y-4">
            <li
              v-for="item in mobilityHighlights"
              :key="item"
              class="flex items-start gap-3 text-gray-300"
            >
              <span
                class="mt-1 rounded-full bg-[var(--vibe-yellow-light)]/20 p-1"
              >
                <Check class="h-4 w-4 text-[var(--vibe-yellow-light)]" />
              </span>
              <span>{{ item }}</span>
            </li>
          </ul>
        </div>
        <div class="order-1 relative md:order-2">
          <div
            class="absolute inset-0 rounded-3xl bg-gradient-to-l from-[var(--vibe-yellow-light)] to-[var(--vibe-red-light)] opacity-20 blur-xl"
          />
          <ImageWithFallback
            :src="featureSections[1].image"
            alt="Mobiele app"
            class="relative h-[400px] w-full rounded-3xl object-cover"
          />
        </div>
      </div>
    </section>

    <!-- Game Modes -->
    <section class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-6xl">
        <div class="text-center">
          <h2 class="text-3xl font-semibold text-white">Gamemodes</h2>
          <p class="mt-4 text-xl text-gray-300">
            Kies een deck dat past bij jullie avond – elk heeft zijn eigen
            energie, regels en opdrachten.
          </p>
        </div>
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <article
            v-for="mode in gameModes"
            :key="mode.title"
            class="relative w-full cursor-pointer overflow-hidden rounded-3xl border-[6px] text-white shadow-xl transition-transform duration-200 hover:-translate-y-1"
            :class="mode.surface"
          >
            <div
              class="relative z-10 flex min-h-[11rem] flex-col justify-between p-5"
            >
              <div class="mt-1 pr-8">
                <p
                  class="text-xs font-semibold uppercase tracking-wide text-white/70"
                >
                  {{ mode.tagline }}
                </p>
                <h3 class="mt-1 text-lg font-bold text-white">
                  {{ mode.title }}
                </h3>
                <p class="text-sm text-white/80">
                  {{ mode.description }}
                </p>
              </div>
              <div class="mt-4 text-5xl">{{ mode.emoji }}</div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Why SPEL6 -->
    <section class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-6xl">
        <div class="mb-12 text-center">
          <h2 class="text-3xl font-semibold text-white">Waarom SPEL6?</h2>
          <p class="mt-4 text-xl text-gray-300">
            Oneindig kaartspel, altijd in je broekzak
          </p>
        </div>
        <div class="grid gap-8 md:grid-cols-3">
          <div
            v-for="point in whySpel6Points"
            :key="point.title"
            class="rounded-3xl border border-white/10 bg-white/5 p-6 text-center"
          >
            <div
              :class="`mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl text-2xl ${point.accent}`"
            >
              {{ point.icon }}
            </div>
            <h3 class="mb-3 text-lg font-semibold text-white">
              {{ point.title }}
            </h3>
            <p class="text-sm text-gray-400">{{ point.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Vibes -->
    <section class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-5xl text-center">
        <h2 class="text-3xl font-semibold text-white">Voor elk moment</h2>
        <p class="mt-4 text-xl text-gray-300">
          Kies de perfecte sfeer voor jouw avond via de filters, straffen en
          gamemodes en laat SPEL6 automatisch de juiste vragen en opdrachten
          klaarzetten.
        </p>
      </div>
      <div
        class="setup-wrapper mx-auto mt-12 flex max-w-4xl flex-col items-center rounded-3xl bg-black/60 px-4 py-10 text-white sm:px-8"
      >
        <div class="mt-8 w-full space-y-4">
          <button
            v-for="vibe in setupVibes"
            :key="vibe.title"
            class="relative flex w-full items-center gap-4 rounded-2xl p-4 text-left transition hover:shadow-2xl"
            :style="{
              backgroundColor: vibe.bgLight,
            }"
            type="button"
          >
            <span class="text-3xl">{{ vibe.emoji }}</span>
            <div>
              <p
                class="text-xs font-semibold uppercase tracking-wide text-white/80"
              >
                {{ vibe.subtitle }}
              </p>
              <h3 class="text-xl font-bold uppercase text-white">
                {{ vibe.title }}
              </h3>
              <p class="text-sm text-white/90">
                {{ vibe.description }}
              </p>
            </div>
          </button>
        </div>
      </div>
    </section>

    <!-- Filters & Penalties -->
    <section class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-6xl">
        <div class="mb-12 text-center">
          <h2 class="text-3xl font-semibold text-white">
            Filters & Straftypes
          </h2>
          <p class="mt-4 text-xl text-gray-300">
            Maak het spel volledig eigen: kies welke vraagtypes je wilt zien en
            bepaal hoe pittig de straffen worden.
          </p>
        </div>
        <div class="grid gap-8 md:grid-cols-2">
          <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <div class="mb-6 flex items-center justify-between">
              <h3 class="text-2xl font-semibold text-white">Vraagtypes</h3>
              <span class="text-xs uppercase tracking-wide text-gray-400"
                >Minimaal één selecteren</span
              >
            </div>
            <ul class="space-y-5">
              <li
                v-for="filter in filterTypes"
                :key="filter.title"
                class="flex items-start gap-4"
              >
                <span
                  class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-2xl"
                >
                  {{ filter.icon }}
                </span>
                <div>
                  <p class="font-semibold text-white">{{ filter.title }}</p>
                  <p class="text-sm text-gray-400">
                    {{ filter.description }}
                  </p>
                </div>
              </li>
            </ul>
            <p class="mt-6 text-sm text-yellow-300">
              Tip: Spicy & 18+ kunnen heftig zijn. Er is altijd de mogelijkheid
              om een vraag of opdracht over te slaan.
            </p>
          </div>
          <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <div class="mb-6 flex items-center justify-between">
              <h3 class="text-2xl font-semibold text-white">Straftypes</h3>
              <span class="text-xs uppercase tracking-wide text-gray-400"
                >Combineer en wissel af</span
              >
            </div>
            <ul class="space-y-5">
              <li
                v-for="penalty in penaltyTypes"
                :key="penalty.title"
                class="flex items-start gap-4"
              >
                <span
                  class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-2xl"
                >
                  {{ penalty.icon }}
                </span>
                <div>
                  <p class="font-semibold text-white">{{ penalty.title }}</p>
                  <p class="text-sm text-gray-400">
                    {{ penalty.description }}
                  </p>
                </div>
              </li>
            </ul>
            <p class="mt-6 text-sm text-yellow-300">
              Tip: Speel met meerdere straftypes tegelijk voor maximale
              spanning.
            </p>
          </div>
        </div>
        <p class="mt-10 text-center text-sm text-gray-400">
          Selecteer minstens één vraagtype en één straftype om het spel te
          starten.
        </p>
      </div>
    </section>

    <!-- Promo -->
    <section class="relative my-20 px-4 py-32 sm:px-6 lg:px-8">
      <div
        class="absolute inset-0 bg-gradient-to-b from-transparent via-[var(--light-background)] to-transparent"
      />
      <div class="relative mx-auto max-w-5xl text-center">
        <div class="relative mx-auto mb-12 h-64 w-64">
          <div
            class="animated-gradient absolute inset-0 rounded-full opacity-40 blur-2xl"
          />
          <img
            :src="spel6Logo"
            alt="SPEL6 Promo"
            class="relative h-full w-full object-contain drop-shadow-2xl"
          />
        </div>
        <h2 class="mb-6 text-3xl font-semibold text-white">
          Klaar voor het feest?
        </h2>
        <p class="mx-auto mb-8 max-w-3xl text-xl text-gray-300">
          Sluit je aan bij duizenden spelers die SPEL6 al hebben ontdekt. Geen
          advertenties, geen abonnementen – alleen pure party vibes en continu
          nieuwe content.
        </p>
        <div class="mx-auto mb-8 grid max-w-4xl gap-4 sm:grid-cols-3">
          <div
            v-for="perk in promoHighlights"
            :key="perk.title"
            class="rounded-2xl border border-white/10 bg-white/5 p-4 text-center text-sm text-gray-300"
          >
            <div class="mb-2 text-2xl">{{ perk.icon }}</div>
            <p class="font-semibold text-white">{{ perk.title }}</p>
            <p class="text-xs text-gray-400">{{ perk.description }}</p>
          </div>
        </div>
        <div class="flex flex-col justify-center gap-4 sm:flex-row">
          <a
            v-for="store in stores"
            :key="`promo-${store.label}`"
            href="#"
            class="inline-flex items-center justify-center gap-3 rounded-2xl px-8 py-4 text-white transition-all hover:scale-105"
          >
            <img :src="store.iconSrc" :alt="store.label" class="h-6 w-auto" />
            <div class="text-left">
              <div class="text-sm font-semibold">{{ store.label }}</div>
              <div class="text-xs text-white/70">{{ store.cta }}</div>
            </div>
          </a>
        </div>
      </div>
    </section>

    <!-- Final Feature -->
    <section class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto grid max-w-7xl items-center gap-12 md:grid-cols-2">
        <div class="relative">
          <div
            class="absolute inset-0 rounded-3xl bg-gradient-to-r from-[var(--vibe-red-light)] to-[var(--vibe-blue-light)] opacity-20 blur-xl"
          />
          <ImageWithFallback
            :src="featureSections[2].image"
            alt="Groep vrienden"
            class="relative h-[400px] w-full rounded-3xl object-cover"
          />
        </div>
        <div>
          <h2 class="mb-6 text-3xl font-semibold text-white">
            Herinneringen voor het leven
          </h2>
          <p class="mb-6 text-lg text-gray-300">
            SPEL6 draait niet alleen om vragen en challenges. Het gaat om de
            momenten die je creëert, de verhalen die je deelt en de
            herinneringen die blijven.
          </p>
          <p class="text-lg text-gray-300">
            Elke keer at je speelt is een nieuw avontuur. Elke vraag brengt je
            dichter bij elkaar. De spanningen zullen stijgen. Dat is de magie
            van SPEL6.
          </p>
        </div>
      </div>
    </section>

    <!-- Warnings -->
    <section
      class="relative overflow-hidden bg-white/5 px-4 py-20 sm:px-6 lg:px-8"
    >
      <img
        :src="spel6GreyLogo"
        alt=""
        class="pointer-events-none absolute -right-10 top-1/2 hidden h-72 w-72 -translate-y-1/2 opacity-10 lg:block"
        aria-hidden="true"
      />
      <div class="mx-auto max-w-5xl text-center">
        <h2 class="text-3xl font-semibold text-white">Let op</h2>
        <p class="mt-4 text-lg text-gray-300">
          Sommige gamemodes van SPEL6 zijn bedoeld voor volwassenen en kan
          inhoud bevatten die niet geschikt is voor alle leeftijden.
        </p>
        <div class="mt-12 flex flex-wrap items-center justify-center gap-8">
          <div
            v-for="item in warnings"
            :key="item.label"
            class="flex flex-col items-center gap-2"
          >
            <div
              class="flex h-20 w-20 items-center justify-center rounded-full border-2 border-white/20 bg-white/10 text-2xl"
            >
              {{ item.icon }}
            </div>
            <span class="text-sm text-gray-400">{{ item.label }}</span>
          </div>
        </div>
        <p class="mt-8 text-sm text-gray-400">
          Speel verantwoord. Respecteer de grenzen van anderen.
        </p>
      </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="px-4 py-20 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-4xl">
        <div
          class="rounded-2xl border border-white/10 bg-gradient-to-br from-[var(--vibe-blue-light)]/10 to-[var(--vibe-red-light)]/10 p-8 text-center"
        >
          <h2 class="text-3xl font-semibold text-white">Contact</h2>
          <p class="mt-4 text-xl text-gray-300">
            Heb je vragen of feedback? We horen graag van je!
          </p>
          <NuxtLink
            to="/contact"
            class="cta-animated mt-8 inline-flex items-center justify-center rounded-xl px-8 py-3 text-sm font-semibold text-white transition-transform duration-200 hover:scale-105"
          >
            Neem contact op
          </NuxtLink>
        </div>
      </div>
    </section>

    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { Check } from "lucide-vue-next";

const spel6Logo = useStorageAsset("storage/spel6logo.png");
const appStoreBadge = useStorageAsset("storage/appstore.png");
const playStoreBadge = useStorageAsset("storage/playstore.png");
const spel6GreyLogo = useStorageAsset("storage/spel6-grey.png");

const stores = [
  {
    iconSrc: appStoreBadge,
    label: "App Store",
    subtext: "Download in de",
    cta: "Geen advertenties • Geen abonnement",
  },
  {
    iconSrc: playStoreBadge,
    label: "Google Play",
    subtext: "Download in de",
    cta: "Geen advertenties • Geen abonnement",
  },
];

const friendHighlights = [
  "Duizenden unieke vragen en challenges",
  "Voor elk moment de perfecte sfeer",
  "Van rustig tot volledig uit de hand",
];

const mobilityHighlights = [
  "Beschikbaar op iOS en Android",
  "Personaliseerbaar spel",
  "Regelmatige updates met nieuwe content",
];

const gameModes = [
  {
    title: "Do You Know Me?",
    description: "Persoonlijke vragen over je vrienden",
    tagline: "Persoonlijk",
    emoji: "🎭",
    surface:
      "bg-purple-700 border-purple-900/70 shadow-[0_0_24px_rgba(123,76,204,0.45)]",
  },
  {
    title: "Chaos Crew",
    description: "Iedereen doet mee. Opdrachten, actie, pure chaos!",
    tagline: "Party Challenges",
    emoji: "👊",
    surface:
      "bg-pink-700 border-pink-900/70 shadow-[0_0_24px_rgba(225,64,146,0.45)]",
  },
  {
    title: "SongBird",
    description:
      "Herken het lied door twee zinnen, soms is het ook nog vertaald...",
    tagline: "Music Quiz",
    emoji: "🎤",
    surface:
      "bg-amber-600 border-amber-800/70 shadow-[0_0_24px_rgba(255,175,64,0.4)]",
  },
  {
    title: "Quizmaster",
    description: "Pubquiz-vibes met verrassende thema's.",
    tagline: "Trivia",
    emoji: "🤔",
    surface:
      "bg-cyan-800 border-cyan-900/70 shadow-[0_0_24px_rgba(56,189,248,0.35)]",
  },
  {
    title: "Dilemma Duel",
    description: "Kies een kant, de meerderheid wint deze opdracht.",
    tagline: "Discussie",
    emoji: "💬",
    surface:
      "bg-red-700 border-red-900/70 shadow-[0_0_24px_rgba(220,38,38,0.45)]",
  },
  {
    title: "Most Likely To",
    description: "Wie o wie zou het doen? Wijs die persoon tegelijkertijd aan.",
    tagline: "Party Votes",
    emoji: "💥",
    surface:
      "bg-green-800 border-green-900/70 shadow-[0_0_24px_rgba(34,197,94,0.4)]",
  },
];

const whySpel6Points = [
  {
    title: "Betaalbaarder dan andere spellen",
    description:
      "Goedkoper dan fysieke spellen, minder ruimte, meer lol en meer opties.",
    icon: "💸",
    accent: "bg-[var(--vibe-green-light)]/15 text-[var(--vibe-green-light)]",
  },
  {
    title: "Altijd up-to-date",
    description:
      "Nieuwe vragen, opdrachten, gamemodes en functies blijven komen dankzij regelmatige updates.",
    icon: "🌀",
    accent: "bg-[var(--vibe-blue-light)]/15 text-[var(--vibe-blue-light)]",
  },
  {
    title: "Filters voor elke mood",
    description:
      "Elke gamemode heeft eigen filters en toon. Geen generieke vragen, maar precies wat past bij het moment.",
    icon: "🔍",
    accent: "bg-[var(--vibe-yellow-light)]/15 text-[var(--vibe-yellow-light)]",
  },
];

const promoHighlights = [
  {
    title: "Betaalbare keuze",
    description: "Goedkoper dan stapels fysieke kaartspellen.",
    icon: "💸",
  },
  {
    title: "Altijd nieuw",
    description: "Updates brengen verse vragen en gamemodes.",
    icon: "♻️",
  },
  {
    title: "Slimme content",
    description: "Vragen en opdrachten passen perfect bij elke sfeer.",
    icon: "✨",
  },
];

const finalFeatureImage = useStorageAsset("storage/img5.png");
const mobilityImage = useStorageAsset("storage/img6.png");
const friendsFeatureImage = useStorageAsset("storage/img7.png");

const setupVibes = [
  {
    title: "Feest",
    subtitle: "Party Mode",
    description: "Een avond vol lol en om steeds minder te herinneren.",
    emoji: "🍸",
    bgLight: "var(--vibe-yellow-light)",
  },
  {
    title: "Vrienden",
    subtitle: "Friends Deep Dive",
    description:
      "Ook al kennen jullie elkaar goed. Onthoud: niemand is veilig.",
    emoji: "🤝",
    bgLight: "var(--vibe-green-light)",
  },
  {
    title: "Collega's",
    subtitle: "Work Mode",
    description: "Na werktijd alsnog met ze opgescheept...",
    emoji: "👔",
    bgLight: "var(--vibe-blue-light)",
  },
  {
    title: "Date",
    subtitle: "Date Night",
    description:
      "Een avond zonder ongemakkelijke stiltes en vol spanning en gebroken ijs.",
    emoji: "❤️",
    bgLight: "var(--vibe-red-light)",
  },
];

const filterTypes = [
  {
    title: "18+",
    description: "18+ onderwerpen of seksueel getinte opdrachten & vragen.",
    icon: "🔥",
  },
  {
    title: "Normaal",
    description: "Mildere vragen & opdrachten voor een rustige mood.",
    icon: "✅",
  },
  {
    title: "Spicy",
    description: "Seksueel getinte vragen & opdrachten.",
    icon: "🌶️",
  },
  {
    title: "Diepgaand",
    description: "Emotionele of serieuzere vragen & opdrachten.",
    icon: "💬",
  },
  {
    title: "Random Straf",
    description: "Soms krijg je plots een straf zonder duidelijke reden.",
    icon: "🎲",
  },
];

const penaltyTypes = [
  {
    title: "Drinken",
    description: "Neem een (x) aantal slokken (alcohol)",
    icon: "🍻",
  },
  {
    title: "Vraag",
    description: "Krijg een extra persoonlijke of ongemakkelijke vraag.",
    icon: "❓",
  },
  {
    title: "Genant",
    description: "Vertel een genant verhaal of beantwoord een genante vraag.",
    icon: "😳",
  },
  {
    title: "Dare",
    description: "Voer een opdracht uit, van mild tot outrageous tot extreme.",
    icon: "🎯",
  },
  {
    title: "Acteren",
    description: "Doe een mini performance of speel een scène na.",
    icon: "🎭",
  },
  {
    title: "Persoonlijk",
    description:
      "Beantwoord een persoonlijke vraag of geef iemand een persoonlijk compliment.",
    icon: "💌",
  },
];

const featureSections = [
  {
    image: friendsFeatureImage,
  },
  {
    image: mobilityImage,
  },
  {
    image: finalFeatureImage,
  },
];

const warnings = [
  { label: "18 jaar en ouder", icon: "18+" },
  { label: "Alcohol", icon: "🍺" },
  { label: "Cannabis", icon: "🌿" },
  { label: "Expliciete inhoud", icon: "💋" },
  { label: "Kijkwijzer", icon: "👁️" },
];
</script>
