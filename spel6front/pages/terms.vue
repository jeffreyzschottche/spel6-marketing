<template>
  <div class="min-h-screen bg-[#0a0a0a]">
    <AppNavbar />
    <main class="mx-auto max-w-4xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
      <header class="mb-16 text-center">
        <div
          class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[var(--vibe-yellow-light)]/20"
        >
          <FileText class="h-10 w-10 text-[var(--vibe-yellow-light)]" />
        </div>
        <h1 class="mb-4 text-4xl font-semibold text-white md:text-5xl">
          Algemene Voorwaarden
        </h1>
        <p class="text-xl text-gray-300">
          De spelregels voor het gebruik van SPEL6
        </p>
        <p class="mt-4 text-sm text-gray-500">
          Laatst bijgewerkt: November 2024
        </p>
      </header>

      <section class="mb-16 grid gap-4 md:grid-cols-3">
        <article
          class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center"
        >
          <Shield class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-green-light)]" />
          <h3 class="text-white">Bescherming</h3>
          <p class="text-sm text-gray-400">Wij waarborgen eerlijk spel</p>
        </article>
        <article
          class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center"
        >
          <UserCheck
            class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-blue-light)]"
          />
          <h3 class="text-white">Respect</h3>
          <p class="text-sm text-gray-400">Iedereen speelt veilig mee</p>
        </article>
        <article
          class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center"
        >
          <Lock class="mx-auto mb-3 h-6 w-6 text-[var(--vibe-red-light)]" />
          <h3 class="text-white">Verantwoord</h3>
          <p class="text-sm text-gray-400">Gebruik de app met zorg</p>
        </article>
      </section>

      <section v-for="section in terms" :key="section.title" class="mb-12">
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
            <li v-for="item in section.list" :key="item">
              {{ item }}
            </li>
          </ul>
          <p v-if="section.note" class="text-sm text-gray-400">
            {{ section.note }}
          </p>
        </div>
      </section>

      <section
        class="rounded-2xl border border-white/10 bg-gradient-to-r from-[var(--vibe-yellow-light)]/10 to-[var(--vibe-red-light)]/10 p-8 text-center"
      >
        <h3 class="mb-4 text-2xl font-semibold text-white">
          Vragen over deze voorwaarden?
        </h3>
        <p class="mb-6 text-sm text-gray-300">
          Neem contact met ons op voor toelichting of hulp.
        </p>
        <NuxtLink
          class="cta-animated inline-flex items-center justify-center rounded-xl px-8 py-3 text-sm font-semibold text-white transition-transform duration-200 hover:scale-105"
          to="/contact"
        >
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
    intro:
      "Deze voorwaarden hebben betrekking op het gebruik van de SPEL6 app en alle diensten die daarbij horen.",
    icon: FileText,
    color: "text-[var(--vibe-yellow-light)]",
    list: [
      "SPEL6: de mobiele applicatie en bijbehorende diensten.",
      "Gebruiker: elke persoon die SPEL6 downloadt of gebruikt.",
      "Content: alle vragen, challenges, opdrachten, straftypes en andere spelonderdelen in de app.",
    ],
  },
  {
    title: "2. Gebruik van de app",
    intro:
      "Door SPEL6 te gebruiken ga je akkoord met verantwoordelijk en respectvol gebruik. Jij blijft altijd zelf verantwoordelijk voor wat je doet tijdens het spelen.",
    icon: Shield,
    color: "text-[var(--vibe-green-light)]",
    list: [
      "Gebruik de app uitsluitend voor persoonlijke, niet-commerciële doeleinden.",
      "Je bent 18 jaar of ouder of hebt toestemming van een ouder/verzorger. Voor 18+ gamemodes, filters en straftypes geldt: alleen gebruiken als alle spelers 18+ zijn.",
      "Alle opdrachten en vragen zijn vrijwillig. Je bent nooit verplicht om een vraag te beantwoorden of een opdracht uit te voeren; er is altijd een overslaan-knop.",
      "De opdrachten, filters en straftypes zijn bedoeld om de sfeer te bepalen. Jij kiest zelf bewust welke intensiteit je aanzet. Denk na voordat je (spicy/18+) filters of straftypes activeert.",
      "Bij de start van een spel kun je per speler aangeven of iemand alcohol drinkt. Vink dit niet aan als iemand niet drinkt of een verslavingsverleden heeft. Respecteer elkaars grenzen.",
      "Bij de start van een spel kun je per speler aangeven of fysieke opdrachten mogelijk zijn. Vul dit serieus en eerlijk in en forceer niemand tot fysieke inspanning.",
      "SPEL6 moedigt alcoholgebruik niet aan. Als je toch drinkt tijdens het spel is dat volledig je eigen keuze en verantwoordelijkheid. Drink met mate, drink niet als je moet rijden en combineer het spel niet met gevaarlijke situaties.",
      "Seksuele of intieme opdrachten mogen alleen worden uitgevoerd als alle betrokken personen daar duidelijk en vrijwillig mee instemmen (consent). Maak bij voorkeur vóór het spel afspraken over grenzen, zeker als je de spicy gamemode of 18+ filters gebruikt.",
    ],
    note: "Wees voorzichtig tijdens fysieke opdrachten. Voer geen opdrachten uit die jouw gezondheid of die van anderen in gevaar kunnen brengen.",
  },
  {
    title: "3. Content en intellectueel eigendom",
    intro: "Alle content in SPEL6 is beschermd:",
    icon: Lock,
    color: "text-[var(--vibe-red-light)]",
    list: [
      "Content mag niet gekopieerd, gedeeld of hergebruikt worden zonder onze uitdrukkelijke toestemming.",
      "Gebruik eigen (custom) content respectvol en zonder rechten van derden (zoals auteursrecht of portretrecht) te schenden.",
      "We kunnen content en/of toegang tot de app blokkeren of verwijderen als deze tegen de wet, deze voorwaarden of onze huisregels ingaat.",
    ],
  },
  {
    title: "4. Aankopen en refunds",
    intro:
      "SPEL6 werkt met een eenmalige aankoop. Er zijn geen abonnementen of in-app aankopen binnen de app zelf.",
    icon: FileText,
    color: "text-[var(--vibe-blue-light)]",
    list: [
      "De aanschaf van de app verloopt via externe platforms zoals de Apple App Store en/of Google Play Store.",
      "Wij verwerken zelf geen betaalgegevens in de app; betalingen lopen via de systemen van deze platforms.",
      "Voor refunds en terugbetalingen van je aankoop moet je altijd bij de App Store of Play Store zijn. Zij hanteren hun eigen voorwaarden en processen.",
      "Wij kunnen geen directe terugbetalingen doen voor aankopen die via de App Store of Play Store zijn gedaan.",
    ],
    note: "Controleer altijd het refund-/annuleringsbeleid van het platform waarop je SPEL6 hebt aangeschaft.",
  },
  {
    title: "5. Privacy en data",
    intro:
      "We gebruiken geen persoonlijke informatie voor reclame of doorverkoop. SPEL6 is zo gebouwd dat we zo min mogelijk over jou hoeven te weten. Zie ook ons Privacy Statement.",
    icon: UserCheck,
    color: "text-[var(--vibe-green-light)]",
    list: [
      "We slaan geen spelantwoorden of gevoelige persoonlijke informatie van spelers op in een centrale database.",
      "Spelinstellingen en voortgang worden zoveel mogelijk lokaal op je eigen device opgeslagen.",
      "We delen geen gegevens met adverteerders en gebruiken je informatie niet voor gepersonaliseerde advertenties.",
    ],
    note: "Voor meer details over welke beperkte gegevens we verwerken en hoe we daarmee omgaan, zie de Privacy-pagina (/privacy).",
  },
  {
    title: "6. Aansprakelijkheid",
    intro:
      "SPEL6 wordt aangeboden zoals hij is (“as-is”). Jij blijft altijd zelf verantwoordelijk voor je gedrag tijdens het spel en de keuzes die je maakt op basis van de vragen en opdrachten.",
    icon: Shield,
    color: "text-[var(--vibe-red-light)]",
    list: [
      "We zijn niet aansprakelijk voor fysieke of emotionele schade die ontstaat doordat spelers opdrachten uitvoeren of gevoelige informatie delen.",
      "We zijn niet verantwoordelijk voor gevolgen van alcoholgebruik of druggebruik tijdens het spelen. Drink en gebruik verantwoordelijk, drink niet als je moet rijden en houd rekening met verslavingsverleden van jezelf en anderen.",
      "Alle informatie die je tijdens het spel deelt, deel je vrijwillig. SPEL6 is niet aansprakelijk voor eventuele verspreiding (“lekken”) van informatie die door spelers met elkaar gedeeld wordt.",
      "Gebruik van de app is op eigen risico. Jij beslist zelf welke filters, straftypes en gamemodes je activeert en welke opdrachten je wel of niet uitvoert.",
      "We doen ons best om bugs en technische problemen snel op te lossen, maar geven geen garanties op foutloze werking of ononderbroken beschikbaarheid.",
    ],
    note: "Houd rekening met elkaar, respecteer grenzen en probeer het spel veilig en leuk te houden voor iedereen die meespeelt.",
  },
  {
    title: "7. Wijzigingen",
    intro:
      "We kunnen deze voorwaarden van tijd tot tijd aanpassen, bijvoorbeeld als we functies toevoegen of wetgeving verandert.",
    icon: FileText,
    color: "text-[var(--vibe-yellow-light)]",
    note: "Belangrijke wijzigingen communiceren we via de app of de website en treden in werking zodra de nieuwe voorwaarden gepubliceerd zijn. Door SPEL6 te blijven gebruiken, ga je akkoord met de nieuwste versie van de voorwaarden.",
  },
];
</script>
