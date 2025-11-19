<template>
  <div class="min-h-screen bg-[#0a0a0a] text-white">
    <AppNavbar />
    <main class="mx-auto max-w-4xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
      <header class="mb-16 text-center">
        <div
          class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[var(--vibe-blue-light)]/20"
        >
          <HelpCircle class="h-10 w-10 text-[var(--vibe-blue-light)]" />
        </div>
        <h1 class="text-4xl font-semibold md:text-5xl">Veelgestelde vragen</h1>
        <p class="mt-4 text-xl text-gray-300">
          Vind snel antwoord op je vragen over SPEL6.
        </p>
      </header>

      <section class="space-y-12">
        <article v-for="category in faqSections" :key="category.category">
          <h2 class="mb-6 flex items-center gap-3 text-2xl font-semibold">
            <span class="animated-gradient h-1 w-8 rounded-full" />
            {{ category.category }}
          </h2>
          <div class="space-y-4">
            <div
              v-for="question in category.questions"
              :key="question.id"
              class="overflow-hidden rounded-2xl border border-white/10 bg-white/5 transition hover:bg-white/10"
            >
              <button
                type="button"
                class="flex w-full items-center justify-between px-6 py-4 text-left"
                @click="toggle(question.id)"
              >
                <span class="pr-4 text-base font-medium">{{ question.q }}</span>
                <ChevronDown
                  class="h-5 w-5 flex-shrink-0 text-gray-400 transition-transform"
                  :class="{ 'rotate-180': isOpen(question.id) }"
                />
              </button>
              <div v-if="isOpen(question.id)" class="px-6 pb-4">
                <div
                  class="border-t border-white/10 pt-4 text-sm text-gray-300"
                >
                  {{ question.a }}
                </div>
              </div>
            </div>
          </div>
        </article>
      </section>

      <section
        class="mt-16 rounded-2xl border border-white/10 bg-gradient-to-br from-[var(--vibe-blue-light)]/10 to-[var(--vibe-red-light)]/10 p-8 text-center"
      >
        <h3 class="text-2xl font-semibold">Staat je vraag er niet tussen?</h3>
        <p class="mt-4 text-sm text-gray-300">
          Neem contact met ons op en we helpen je graag verder!
        </p>
        <NuxtLink
          class="cta-animated mt-6 inline-flex items-center justify-center rounded-xl px-8 py-3 text-sm font-semibold text-white transition-transform duration-200 hover:scale-105"
          to="/contact"
        >
          Neem contact op
        </NuxtLink>
      </section>

      <section class="mt-12 grid gap-6 md:grid-cols-2">
        <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
          <div class="text-2xl">💡</div>
          <h3 class="mt-2 text-lg font-semibold">Tip</h3>
          <p class="mt-2 text-sm text-gray-400">
            Check de Guide pagina voor uitgebreide instructies over hoe je SPEL6
            speelt en het maximale eruit haalt!
          </p>
          <NuxtLink
            class="cta-animated mt-4 inline-flex items-center justify-center rounded-xl px-6 py-2 text-sm font-semibold text-white transition-transform duration-200 hover:scale-105"
            to="/guide"
          >
            Bekijk Guide
          </NuxtLink>
        </article>
        <article class="rounded-2xl border border-white/10 bg-white/5 p-6">
          <div class="text-2xl">🛡️</div>
          <h3 class="mt-2 text-lg font-semibold">Privacy</h3>
          <p class="mt-2 text-sm text-gray-400">
            Lees de Privacy Statement voor alle details over dataverzameling en
            beveiliging.
          </p>
          <NuxtLink
            class="cta-animated mt-4 inline-flex items-center justify-center rounded-xl px-6 py-2 text-sm font-semibold text-white transition-transform duration-200 hover:scale-105"
            to="/privacy"
          >
            Privacy Statement
          </NuxtLink>
        </article>
      </section>
    </main>
    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { ChevronDown, HelpCircle } from "lucide-vue-next";
import { ref } from "vue";

interface Question {
  q: string;
  a: string;
}

interface FaqCategory {
  category: string;
  questions: Question[];
}

const rawFaqs: FaqCategory[] = [
  {
    category: "Algemeen",
    questions: [
      {
        q: "Wat is SPEL6?",
        a: "SPEL6 is een interactief partyspel voor smartphones met duizenden vragen en challenges. Perfect voor feestjes, dates, en gezellige avonden met vrienden of collega's.",
      },
      {
        q: "Hoeveel spelers heb ik nodig?",
        a: "SPEL6 werkt het beste met minimaal 2 en maximaal 10 spelers.",
      },
      {
        q: "Hoeveel kost SPEL6?",
        a: "SPEL6 kost eenmalig € 2,99. Geen abonnementen en geen verborgen kosten.",
      },
      {
        q: "Zijn er abonnementen of verborgen kosten?",
        a: "Nee. SPEL6 heeft geen advertenties en geen abonnement. Je betaalt één keer en krijgt toegang tot alle vragen en updates, inclusief nieuwe gamemodes.",
      },
      {
        q: "Op welke apparaten werkt SPEL6?",
        a: "SPEL6 is beschikbaar voor iOS (iPhone/iPad) en Android smartphones en tablets.",
      },
    ],
  },
  {
    category: "Technisch",
    questions: [
      {
        q: "Heb ik internet nodig om te spelen?",
        a: "Nee! Na het downloaden van de app kun je volledig offline spelen. Internet is alleen nodig voor updates en het downloaden van nieuwe content.",
      },
      {
        q: "Waarom crasht de app?",
        a: "Zorg ervoor dat je de laatste versie van SPEL6 hebt geïnstalleerd. Als het probleem aanhoudt, probeer de app te verwijderen en opnieuw te installeren. Neem contact op als dit niet helpt.",
      },
      {
        q: "Hoe update ik de app?",
        a: "Ga naar de App Store (iOS) of Google Play Store (Android) en check voor updates. We raden aan automatische updates in te schakelen.",
      },
      {
        q: "Kan ik mijn voortgang opslaan?",
        a: "Elk spel is uniek en wordt niet opgeslagen. We geloven in het moment - elke speelsessie is een nieuw avontuur!",
      },
    ],
  },
  {
    category: "Gameplay",
    questions: [
      {
        q: "Wat is het verschil tussen de verschillende modi?",
        a: "Elke modus heeft een eigen set vragen: Feest is wild en onvoorspelbaar, Vrienden is gezellig en persoonlijk, Collegas is zakelijk maar leuk, en Date is intiem en spannend.",
      },
      {
        q: "Kan ik vragen overslaan?",
        a: "Ja, je kunt altijd een vraag skippen als iemand zich er niet prettig bij voelt. Respect voor elkaar is het belangrijkst!",
      },
      {
        q: "Komen er nieuwe vragen bij?",
        a: "Absoluut! We updaten SPEL6 regelmatig met nieuwe vragen, challenges en features. Houd je app up-to-date voor de nieuwste content.",
      },
      {
        q: "Kan ik zelf vragen toevoegen?",
        a: "Met de Custom Pack Creator (apart te koop) kun je je eigen vragensets maken en delen met vrienden!",
      },
    ],
  },
  {
    category: "Account & Betaling",
    questions: [
      {
        q: "Heb ik een account nodig?",
        a: "Nee, je hebt geen account nodig en er is op dit moment ook geen account-optie. Je speelt SPEL6 volledig zonder account.",
      },
      {
        q: "Hoe koop ik premium content?",
        a: "Aankopen verlopen niet via de app maar alleen via onze website. De app zelf bevat geen betalingen of in-app aankopen zodra je SPEL6 hebt aangeschaft.",
      },
      {
        q: "Kan ik een aankoop terugkrijgen?",
        a: "Voor terugbetalingen van je aankoop moet je bij de App Store of Google Play Store zijn. Zij verwerken alle betalingen en eventuele refunds volgens hun eigen voorwaarden.",
      },
      {
        q: "Op hoeveel apparaten kan ik SPEL6 gebruiken?",
        a: "Je kunt SPEL6 downloaden op elk apparaat waarop je bent ingelogd met hetzelfde Apple ID of Google-account waarmee je de app hebt gekocht.",
      },
    ],
  },
  {
    category: "Privacy & Veiligheid",
    questions: [
      {
        q: "Welke data verzamelt SPEL6?",
        a: "We verzamelen minimale data: apparaatinfo voor technische ondersteuning en anonieme gebruiksstatistieken. We vragen geen persoonlijke informatie.",
      },
      {
        q: "Is SPEL6 veilig voor minderjarigen?",
        a: "De basis van SPEL6 is kindvriendelijk en veel vragen en modi zijn geschikt voor jongere spelers. Sommige gamemodes, straftypes en filters zijn echter speciaal bedoeld voor 18+ en kunnen explicietere inhoud bevatten. Let goed op welke modus en filters je kiest en begeleid minderjarige spelers waar nodig.",
      },
      {
        q: "Worden mijn antwoorden opgeslagen?",
        a: "Nee! Je antwoorden worden nergens opgeslagen. Wat in het spel gebeurt, blijft in het spel.",
      },
      {
        q: "Kan ik mijn data laten verwijderen?",
        a: "We slaan geen persoonlijk herleidbare gegevens of antwoorden op, dus er valt niets te verwijderen.",
      },
    ],
  },
];

const faqSections = rawFaqs.map((category, categoryIndex) => ({
  category: category.category,
  questions: category.questions.map((question, questionIndex) => ({
    ...question,
    id: `${categoryIndex}-${questionIndex}`,
  })),
}));

const openId = ref<string | null>(faqSections[0]?.questions[0]?.id ?? null);

function isOpen(id: string) {
  return openId.value === id;
}

function toggle(id: string) {
  openId.value = openId.value === id ? null : id;
}
</script>
