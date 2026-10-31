<template>
  <div ref="root" class="page">
    <AppNavbar />

    <main>
      <!-- Hero -->
      <section class="hero grain" aria-labelledby="hero-title">
        <div class="hero-photos" aria-hidden="true">
          <img src="/images/friends.webp" alt="" class="hero-photo hp-1" />
          <img src="/images/party-v2.webp" alt="" class="hero-photo hp-2" />
          <img src="/images/whisper-v2.webp" alt="" class="hero-photo hp-3" />
          <img src="/images/hands-v2.webp" alt="" class="hero-photo hp-4" />
          <div class="hero-glow"></div>
        </div>
        <div class="hero-inner">
          <div class="hero-copy">
            <p class="eyebrow">Het partyspel voor aan tafel</p>
            <h1 id="hero-title">Leer elkaar <em>écht</em> kennen.</h1>
            <p class="lede">Spel6 is het kaartspel op je telefoon voor vrienden, dates, feestjes en collega's. Kies jullie vibe, maak je eigen mix en speel. Wie verliest, krijgt een opdracht.</p>
            <StoreButtons />
            <p class="hero-note">Geen advertenties · Geen abonnement · Nederlands, Engels, Duits en Spaans</p>
          </div>
          <div class="hero-phone">
            <PhoneDemo :clips="reel" eager @change="reelIndex = $event" />
            <ol class="reel-steps" aria-label="Demo van de app">
              <li v-for="(clip, i) in reel" :key="clip.src" :class="{ active: i === reelIndex, done: i < reelIndex }"><span class="sr-only">{{ clip.label }}</span></li>
            </ol>
            <p class="reel-label" aria-live="polite">{{ reel[reelIndex]?.label }}</p>
          </div>
        </div>
      </section>

      <!-- Numbers -->
      <section class="stats" aria-label="Spel6 in cijfers">
        <div v-for="stat in stats" :key="stat.label" class="stat">
          <strong class="stat-value" :data-value="stat.value">{{ stat.display }}</strong>
          <span>{{ stat.label }}</span>
        </div>
      </section>

      <!-- How it works -->
      <section id="zo-werkt-het" class="section how" aria-labelledby="how-title">
        <header class="section-head">
          <p class="eyebrow">Zo werkt het</p>
          <h2 id="how-title">In vier tikken aan tafel.</h2>
          <p class="section-lede">Je stelt de avond samen, Spel6 zoekt de vragen en opdrachten die erbij passen.</p>
        </header>
        <div class="how-grid">
          <ol class="how-steps">
            <li v-for="(step, i) in steps" :key="step.title" class="how-step" :class="{ active: i === stepIndex }" :data-step="i">
              <span class="how-num">0{{ i + 1 }}</span>
              <h3>{{ step.title }}</h3>
              <p>{{ step.text }}</p>
              <ul><li v-for="point in step.points" :key="point">{{ point }}</li></ul>
              <div class="how-inline-phone"><PhoneDemo :clips="[step.clip]" small /></div>
            </li>
          </ol>
          <div class="how-sticky" aria-hidden="true">
            <PhoneDemo :clips="steps.map((s) => s.clip)" :active="stepIndex" />
          </div>
        </div>
      </section>

      <!-- Game modes -->
      <section id="spelvormen" class="section" aria-labelledby="modes-title">
        <header class="section-head">
          <p class="eyebrow">Zes spelvormen</p>
          <h2 id="modes-title">Elke ronde een ander spel.</h2>
          <p class="section-lede">Kies er één of maak een mix. Spel6 wisselt ze af, zodat het nooit hetzelfde voelt.</p>
        </header>
        <div class="modes">
          <article v-for="m in gameModes" :key="m.code" class="mode reveal-up" :style="{ '--accent': m.accent }">
            <div class="mode-art" aria-hidden="true"><GameModeArtwork :code="m.code" /></div>
            <h3>{{ m.title }}</h3>
            <p class="mode-tag">{{ m.tag }}</p>
            <p>{{ m.text }}</p>
            <p class="mode-example">{{ m.example }}</p>
          </article>
        </div>
      </section>

      <!-- Try a card -->
      <section id="probeer" class="section try grain" aria-labelledby="try-title">
        <header class="section-head">
          <p class="eyebrow">Probeer het zelf</p>
          <h2 id="try-title">Trek een kaart.</h2>
          <p class="section-lede">Echte kaarten uit de app. Kies een spelvorm en speel er één na.</p>
        </header>
        <CardDemo />
      </section>

      <!-- In the game -->
      <section class="section" aria-labelledby="game-title">
        <header class="section-head">
          <p class="eyebrow">Midden in het spel</p>
          <h2 id="game-title">Lezen, raden, kiezen. En soms een opdracht.</h2>
        </header>
        <div class="trio">
          <figure v-for="item in inGame" :key="item.clip.src" class="trio-item reveal-up">
            <PhoneDemo :clips="[item.clip]" small />
            <figcaption><strong>{{ item.title }}</strong>{{ item.text }}</figcaption>
          </figure>
        </div>
      </section>

      <!-- Vibes and limits -->
      <section class="section" aria-labelledby="vibes-title">
        <header class="section-head">
          <p class="eyebrow">Voor elke avond</p>
          <h2 id="vibes-title">Jullie gezelschap. Jullie regels.</h2>
          <p class="section-lede">De vibe bepaalt welke vragen langskomen. Met filters en voorkeuren houden jullie het zo licht of zo persoonlijk als je wilt.</p>
        </header>
        <div class="vibes">
          <article v-for="vibe in vibes" :key="vibe.title" class="vibe reveal-up">
            <img :src="vibe.image" :alt="vibe.alt" loading="lazy" />
            <div class="vibe-copy"><h3>{{ vibe.title }}</h3><p>{{ vibe.text }}</p></div>
          </article>
        </div>
        <div class="limits">
          <div class="limit reveal-up">
            <h3>Filters</h3>
            <div class="chips"><span v-for="f in filters" :key="f.name" class="chip" :class="f.kind">{{ f.name }}</span></div>
            <p>Spicy en 18+ staan alleen aan als iedereen eerst akkoord geeft. Romantiek en zoenen zitten bij 18+, seksuele vragen alleen bij Spicy.</p>
          </div>
          <div class="limit reveal-up">
            <h3>Voorkeuren per speler</h3>
            <div class="chips"><span class="chip">Alcohol</span><span class="chip">Fysieke opdrachten</span></div>
            <p>Drinkt iemand niet of wil iemand niet bewegen? Zet het uit bij die speler. Die krijgt dan geen drinkopdrachten of fysieke uitdagingen.</p>
          </div>
        </div>
      </section>

      <!-- Finale -->
      <section class="section finale" aria-labelledby="finale-title">
        <div class="finale-copy reveal-up">
          <p class="eyebrow">Het einde van de avond</p>
          <h2 id="finale-title">Afsluiten met een twist.</h2>
          <p class="section-lede">Na de laatste kaart volgt de eindstand. Wie onderaan staat, krijgt nog één laatste opdracht, gekozen door de winnaar. Daarna: nog een rondje?</p>
        </div>
        <PhoneDemo :clips="[clips.final]" />
      </section>

      <!-- FAQ -->
      <section id="faq" class="section faq" aria-labelledby="faq-title">
        <header class="section-head">
          <p class="eyebrow">Veelgestelde vragen</p>
          <h2 id="faq-title">Goed om te weten.</h2>
        </header>
        <div class="faq-list">
          <details v-for="item in faq" :key="item.q" class="faq-item">
            <summary>{{ item.q }}<span aria-hidden="true">+</span></summary>
            <p>{{ item.a }}</p>
          </details>
        </div>
      </section>

      <!-- Download -->
      <section id="download" class="download grain" aria-labelledby="download-title">
        <span class="wordmark download-mark" aria-hidden="true"></span>
        <h2 id="download-title">Zet de telefoon op tafel.</h2>
        <p>Download Spel6 en begin vanavond.</p>
        <StoreButtons center />
      </section>
    </main>

    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from "vue";
import type { DemoClip } from "~/components/PhoneDemo.vue";

useSeoMeta({
  title: "Spel6 – het partyspel om elkaar écht te leren kennen",
  description: "Spel6 is het kaartspel op je telefoon voor vrienden, dates, feestjes en collega's. Zes spelvormen, 815 vragen en 2.183 opdrachten in vier talen.",
  ogTitle: "Spel6 – leer elkaar écht kennen",
  ogDescription: "Kies jullie vibe, maak je eigen mix en speel. Voor vrienden, dates, feestjes en collega's.",
  ogImage: "/images/og.jpg",
  ogType: "website",
  twitterCard: "summary_large_image",
  themeColor: "#151115",
});
useHead({ htmlAttrs: { lang: "nl" }, link: [{ rel: "apple-touch-icon", href: "/icons/apple-touch-icon.png" }] });

const clip = (name: string, label: string): DemoClip => ({ src: `/demo/${name}.mp4`, poster: `/demo/${name}.jpg`, label });
const clips = {
  start: clip("start", "Kies je taal en start"),
  vibe: clip("vibe", "Kies jullie vibe"),
  players: clip("players", "Voeg de spelers toe"),
  gamemode: clip("gamemode", "Maak jullie mix"),
  filters: clip("filters", "Bepaal de regels"),
  quiz: clip("quiz", "Onthul het antwoord"),
  dilemma: clip("dilemma", "Iedereen kiest tegelijk"),
  penalty: clip("penalty", "Wie verliest, krijgt een opdracht"),
  final: clip("final", "De eindstand en een laatste twist"),
};
const reel = [clips.start, clips.vibe, clips.players, clips.gamemode, clips.filters, clips.quiz, clips.dilemma, clips.penalty, clips.final];
const reelIndex = ref(0);

const stats = [
  { value: 815, display: "815", label: "vragen per taal" },
  { value: 2183, display: "2.183", label: "opdrachten" },
  { value: 6, display: "6", label: "spelvormen" },
  { value: 4, display: "4", label: "talen" },
];

const steps = [
  { title: "Kies jullie vibe", text: "Vrienden, date, feest of collega's. De vibe bepaalt welke vragen en opdrachten langskomen.", points: ["Elke vibe een eigen sfeer", "Ook later nog te wisselen"], clip: clips.vibe },
  { title: "Wie schuiven er aan?", text: "Voeg 2 tot 10 spelers toe. Per speler zet je alcohol en fysieke opdrachten aan of uit.", points: ["Namen komen terug in de vragen", "Niemand hoeft iets wat die niet wil"], clip: clips.players },
  { title: "Maak jullie mix", text: "Zes spelvormen, van persoonlijke vragen tot een snelle quiz. Kies wat bij jullie avond past.", points: ["Alles aan of juist één spelvorm", "Of laat je verrassen"], clip: clips.gamemode },
  { title: "Bepaal de regels", text: "Hoe open, gek of persoonlijk mag het worden? Spicy en 18+ vragen eerst om ieders akkoord.", points: ["Een fijne basis staat al klaar", "Kies welke soort opdrachten meedoen"], clip: clips.filters },
];
const stepIndex = ref(0);

const gameModes = [
  { code: "knowme", title: "Do You Know Me?", tag: "Persoonlijk", accent: "#c4a9e4", text: "Hoe goed kennen jullie elkaar? Iedereen raadt het antwoord van één speler.", example: "Van welk klein dagelijks moment wordt Noor blij?" },
  { code: "chaos", title: "Chaos Crew", tag: "Actie", accent: "#eea0af", text: "Groepsopdrachten en mini-uitdagingen. Iedereen doet tegelijk mee.", example: "Vertel om de beurt een mop zonder te lachen." },
  { code: "songbird", title: "SongBird", tag: "Muziek", accent: "#e8c57f", text: "Herken de hit achter een fragment uit de songtekst. Wie het eerst raadt, wint.", example: "Een regel uit een bekende Nederlandse hit. Welk nummer is het?" },
  { code: "quiz", title: "Quizmaster", tag: "Kennis", accent: "#a1cbd7", text: "Een kleine pubquiz met vier antwoorden. Grote discussies gegarandeerd.", example: "Wat is de hoofdstad van Australië?" },
  { code: "dilemma", title: "Dilemma Duel", tag: "Kiezen", accent: "#eeb295", text: "Twee opties, één keuze. De minderheid krijgt een opdracht.", example: "Elke week verhuizen of nooit meer je geboorteplaats uit?" },
  { code: "likely", title: "Most Likely To", tag: "Wijzen", accent: "#c6d29a", text: "Wie zou het eerst…? Wijs tegelijk iemand aan. Meeste stemmen krijgt een opdracht.", example: "Wie zou een roadtrip starten zonder iets te plannen?" },
] as const;

const inGame = [
  { title: "Onthul het antwoord", text: "Iedereen kiest, één tik op de knop en je weet wie gelijk had.", clip: clips.quiz },
  { title: "Iedereen kiest tegelijk", text: "Bij een dilemma stem je per speler A of B. De meerderheid scoort.", clip: clips.dilemma },
  { title: "Een opdracht op maat", text: "Wie verliest, krijgt een opdracht die past bij jullie regels en voorkeuren.", clip: clips.penalty },
];

const vibes = [
  { title: "Vrienden", text: "Je denkt dat je ze kent.", image: "/images/friends.webp", alt: "Vrienden lachen samen aan tafel" },
  { title: "Date", text: "Sla de smalltalk maar over.", image: "/images/whisper-v2.webp", alt: "Twee mensen fluisteren elkaar iets toe" },
  { title: "Feest", text: "Laat de avond maar gebeuren.", image: "/images/party-v2.webp", alt: "Vrienden proosten op een feest" },
  { title: "Collega's", text: "Even geen werkpraat.", image: "/images/colleagues-v1.webp", alt: "Collega's lachen samen na het werk" },
];

const filters = [
  { name: "Normaal", kind: "" },
  { name: "Diepgaand", kind: "" },
  { name: "Onverwachte twist", kind: "" },
  { name: "Spicy", kind: "chip-warm" },
  { name: "18+", kind: "chip-warm" },
];

const faq = [
  { q: "Wat is Spel6?", a: "Een kaartspel op je telefoon voor aan tafel. Je leest om de beurt een kaart voor: een vraag, een dilemma, een quizvraag of een groepsopdracht. Wie verliest, krijgt een opdracht." },
  { q: "Met hoeveel mensen speel je?", a: "Met 2 tot 10 spelers. Iedereen speelt op één telefoon die rondgaat of op tafel ligt." },
  { q: "In welke talen kan ik spelen?", a: "In het Nederlands, Engels, Duits en Spaans. Je kiest de taal op het startscherm." },
  { q: "Is het geschikt voor collega's of familie?", a: "Ja. Kies de vibe Collega's en laat Spicy en 18+ uit. Die staan nooit vanzelf aan; ze vragen eerst om het akkoord van iedereen." },
  { q: "Moet iedereen drinken?", a: "Nee. Per speler zet je alcohol en fysieke opdrachten aan of uit. Wie niet drinkt, krijgt geen drinkopdrachten." },
  { q: "Heb ik internet nodig?", a: "Nee, alle kaarten zitten in de app. Ben je online, dan komen er nieuwe vragen bij." },
];

const root = ref<HTMLElement | null>(null);
let cleanup: (() => void) | undefined;

onMounted(async () => {
  const { gsap } = await import("gsap");
  const { ScrollTrigger } = await import("gsap/ScrollTrigger");
  gsap.registerPlugin(ScrollTrigger);
  const media = gsap.matchMedia();
  const ctx = gsap.context(() => {
    // Which step's recording the sticky phone shows.
    gsap.utils.toArray<HTMLElement>(".how-step").forEach((el) => {
      ScrollTrigger.create({ trigger: el, start: "top 55%", end: "bottom 55%", onToggle: (self) => { if (self.isActive) stepIndex.value = Number(el.dataset.step); } });
    });

    media.add("(prefers-reduced-motion: no-preference)", () => {
      gsap.from(".hero-copy > *", { y: 24, opacity: 0, duration: .8, stagger: .08, ease: "power3.out" });
      gsap.from(".hero-phone", { y: 50, rotation: 4, opacity: 0, duration: 1.1, ease: "power3.out", delay: .15 });
      gsap.from(".hero-photo", { scale: 1.08, opacity: 0, duration: 1.4, stagger: .1, ease: "power2.out" });
      gsap.to(".hero-photos", { yPercent: 18, ease: "none", scrollTrigger: { trigger: ".hero", start: "top top", end: "bottom top", scrub: true } });
      gsap.utils.toArray<HTMLElement>(".reveal-up").forEach((el) => {
        gsap.from(el, { y: 40, opacity: 0, duration: .8, ease: "power3.out", scrollTrigger: { trigger: el, start: "top 88%" } });
      });
      gsap.utils.toArray<HTMLElement>(".stat-value").forEach((el) => {
        const value = Number(el.dataset.value);
        const counter = { n: 0 };
        gsap.to(counter, { n: value, duration: 1.4, ease: "power2.out", scrollTrigger: { trigger: el, start: "top 90%" }, onUpdate: () => { el.textContent = Math.round(counter.n).toLocaleString("nl-NL"); } });
      });
    });
  }, root.value!);
  cleanup = () => { ctx.revert(); media.revert(); };
});
onBeforeUnmount(() => cleanup?.());
</script>

<style scoped>
.page { background: var(--ink); color: var(--cream); overflow-x: clip; }
.sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }
.eyebrow { margin-bottom: 14px; color: #efb5a8; font-size: .78rem; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; }
em { font-style: normal; background: var(--brand-gradient); -webkit-background-clip: text; background-clip: text; color: transparent; }

/* Hero */
.hero { position: relative; isolation: isolate; min-height: 100svh; display: flex; align-items: center; overflow: hidden; padding: 110px 0 70px; }
.hero-photos { position: absolute; inset: 0; z-index: -1; }
.hero-photo { position: absolute; width: clamp(180px, 22vw, 320px); aspect-ratio: 4 / 5; object-fit: cover; border-radius: 22px; filter: saturate(.85) brightness(.55); }
.hp-1 { top: 7%; left: -3%; transform: rotate(-7deg); }
.hp-2 { bottom: -6%; left: 12%; transform: rotate(5deg); }
.hp-3 { top: -6%; right: 22%; transform: rotate(6deg); }
.hp-4 { bottom: 4%; right: -4%; transform: rotate(-5deg); }
.hero-glow { position: absolute; inset: 0; background: radial-gradient(ellipse at 30% 45%, #151115 0%, #151115e6 30%, #151115b0 55%, #15111540 85%); }
.hero-inner { display: grid; grid-template-columns: 1.1fr .9fr; align-items: center; gap: 48px; width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
.hero-copy h1 { font-size: clamp(2.6rem, 6.4vw, 5.2rem); font-weight: 600; line-height: 1.02; letter-spacing: -2.5px; text-wrap: balance; }
.lede { max-width: 520px; margin: 22px 0 32px; color: #cdbdb4; font-size: clamp(1.02rem, 1.6vw, 1.2rem); line-height: 1.6; }
.hero-note { margin-top: 18px; color: #9b8a83; font-size: .85rem; }
.hero-phone { display: grid; justify-items: center; gap: 16px; }
.reel-steps { display: flex; gap: 5px; }
.reel-steps li { width: 18px; height: 3px; border-radius: 3px; background: #ffffff22; transition: background .3s, width .3s; }
.reel-steps li.done { background: #efb5a880; }
.reel-steps li.active { width: 34px; background: #f28c85; }
.reel-label { min-height: 1.4em; color: #cdbdb4; font-size: .88rem; }

/* Stats */
.stats { display: grid; grid-template-columns: repeat(4, 1fr); width: min(1180px, calc(100% - 40px)); margin: 0 auto; border-block: 1px solid #ffffff12; }
.stat { display: grid; gap: 4px; padding: 30px 12px; text-align: center; }
.stat + .stat { border-left: 1px solid #ffffff12; }
.stat strong { font-size: clamp(2rem, 4vw, 3rem); font-weight: 600; letter-spacing: -1.5px; background: var(--brand-gradient); -webkit-background-clip: text; background-clip: text; color: transparent; font-variant-numeric: tabular-nums; }
.stat span { color: #b3a29a; font-size: .9rem; }

/* Sections */
.section { position: relative; width: min(1180px, calc(100% - 40px)); margin: 0 auto; padding: 120px 0 0; }
.section-head { max-width: 640px; margin: 0 auto 56px; text-align: center; }
.section-head h2, .finale h2 { font-size: clamp(2rem, 4.4vw, 3.3rem); font-weight: 600; line-height: 1.08; letter-spacing: -1.6px; text-wrap: balance; }
.section-lede { margin-top: 16px; color: #b3a29a; font-size: 1.08rem; line-height: 1.6; }

/* How it works */
.how-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; }
.how-steps { display: grid; }
.how-step { min-height: 72vh; display: flex; flex-direction: column; justify-content: center; padding: 20px 0; opacity: .35; transition: opacity .4s; }
.how-step.active { opacity: 1; }
.how-num { color: #f28c85; font-size: .9rem; font-weight: 600; letter-spacing: 2px; }
.how-step h3 { margin: 10px 0 12px; font-size: clamp(1.6rem, 3vw, 2.3rem); font-weight: 600; letter-spacing: -1px; }
.how-step > p { max-width: 440px; color: #cdbdb4; font-size: 1.05rem; line-height: 1.6; }
.how-step ul { display: grid; gap: 8px; margin-top: 20px; }
.how-step ul li { display: flex; align-items: center; gap: 10px; color: #b3a29a; font-size: .95rem; }
.how-step ul li::before { content: ""; width: 18px; height: 18px; flex-shrink: 0; border-radius: 50%; background: #f28c8526 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' fill='none' stroke='%23f28c85' stroke-width='1.6'%3E%3Cpath d='m3 6 2 2 4-4'/%3E%3C/svg%3E") center / 12px no-repeat; }
.how-sticky { position: sticky; top: 12vh; height: 76vh; display: grid; place-items: center; }
.how-inline-phone { display: none; }

/* Game modes */
.modes { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
.mode { display: flex; flex-direction: column; padding: 26px; border: 1px solid #ffffff12; border-radius: 24px; background: radial-gradient(ellipse at 85% 0%, color-mix(in srgb, var(--accent) 18%, transparent), transparent 60%), var(--ink-2); transition: transform .3s, border-color .3s; }
.mode:hover { transform: translateY(-4px); border-color: color-mix(in srgb, var(--accent) 45%, transparent); }
.mode-art { width: 150px; height: 104px; margin: -4px 0 14px -6px; }
.mode h3 { font-size: 1.35rem; font-weight: 600; letter-spacing: -.5px; }
.mode-tag { margin: 4px 0 12px; color: var(--accent); font-size: .78rem; font-weight: 600; letter-spacing: 1.4px; text-transform: uppercase; }
.mode > p:not(.mode-tag):not(.mode-example) { color: #cdbdb4; line-height: 1.55; }
.mode-example { margin-top: auto; padding-top: 18px; color: #f5eee5; font-size: .95rem; line-height: 1.45; }
.mode-example::before { content: "“"; color: var(--accent); }
.mode-example::after { content: "”"; color: var(--accent); }

/* Try */
.try { padding-bottom: 20px; }

/* In the game */
.trio { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; justify-items: center; }
.trio-item { display: grid; justify-items: center; gap: 22px; text-align: center; }
.trio-item figcaption { max-width: 280px; color: #b3a29a; line-height: 1.55; }
.trio-item figcaption strong { display: block; margin-bottom: 6px; color: #f5eee5; font-size: 1.15rem; font-weight: 600; }

/* Vibes */
.vibes { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
.vibe { position: relative; overflow: hidden; aspect-ratio: 3 / 4; border-radius: 22px; }
.vibe img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s; }
.vibe:hover img { transform: scale(1.05); }
.vibe::after { content: ""; position: absolute; inset: 0; background: linear-gradient(180deg, transparent 40%, #151115e6); }
.vibe-copy { position: absolute; left: 18px; right: 18px; bottom: 18px; z-index: 1; }
.vibe h3 { font-size: 1.5rem; font-weight: 600; letter-spacing: -.5px; }
.vibe p { color: #d9c9c0; font-size: .92rem; }
.limits { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 14px; }
.limit { padding: 26px; border: 1px solid #ffffff12; border-radius: 22px; background: var(--ink-2); }
.limit h3 { font-size: 1.2rem; font-weight: 600; }
.limit p { margin-top: 14px; color: #b3a29a; line-height: 1.6; }
.chips { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; }
.chip { padding: 7px 13px; border: 1px solid #ffffff1c; border-radius: 99px; color: #e8dbd2; font-size: .85rem; }
.chip-warm { border-color: #f28c8566; color: #ffc9bd; background: #f28c8514; }

/* Finale */
.finale { display: grid; grid-template-columns: 1fr auto; align-items: center; gap: 60px; }
.finale-copy { max-width: 520px; }

/* FAQ */
.faq-list { display: grid; gap: 10px; max-width: 760px; margin: 0 auto; }
.faq-item { border: 1px solid #ffffff12; border-radius: 18px; background: var(--ink-2); }
.faq-item summary { display: flex; justify-content: space-between; align-items: center; gap: 16px; min-height: 64px; padding: 16px 22px; cursor: pointer; font-size: 1.05rem; font-weight: 500; list-style: none; }
.faq-item summary::-webkit-details-marker { display: none; }
.faq-item summary span { color: #f28c85; font-size: 1.4rem; transition: transform .25s; }
.faq-item[open] summary span { transform: rotate(45deg); }
.faq-item p { padding: 0 22px 20px; color: #b3a29a; line-height: 1.65; }
.faq-item summary:focus-visible { outline: 2px solid #f28c85; outline-offset: 2px; border-radius: 18px; }

/* Download */
.download { position: relative; isolation: isolate; overflow: hidden; display: grid; justify-items: center; gap: 14px; width: min(1180px, calc(100% - 40px)); margin: 120px auto 100px; padding: 72px 24px; border-radius: 32px; text-align: center; background: radial-gradient(ellipse at 50% 120%, #f28c8540, transparent 60%), radial-gradient(ellipse at 10% 0%, #8c4c6640, transparent 50%), var(--ink-2); border: 1px solid #ffffff12; }
.download-mark { width: 150px; margin-bottom: 10px; }
.download h2 { font-size: clamp(2rem, 4.4vw, 3.3rem); font-weight: 600; letter-spacing: -1.6px; }
.download p { margin-bottom: 14px; color: #cdbdb4; font-size: 1.1rem; }

@media (max-width: 960px) {
  .hero { padding-top: 96px; }
  .hero-inner { grid-template-columns: 1fr; text-align: center; gap: 40px; }
  .hero-copy { display: grid; justify-items: center; }
  .lede { margin-inline: auto; }
  .hero-copy :deep(.stores) { justify-content: center; }
  .hp-2, .hp-3 { display: none; }
  .how-grid { grid-template-columns: 1fr; }
  .how-sticky { display: none; }
  .how-step { min-height: 0; opacity: 1; padding: 0 0 72px; align-items: center; text-align: center; }
  .how-step ul { justify-items: center; }
  .how-inline-phone { display: block; margin-top: 32px; }
  .modes { grid-template-columns: repeat(2, 1fr); }
  .trio { grid-template-columns: 1fr; gap: 56px; }
  .vibes { grid-template-columns: repeat(2, 1fr); }
  .finale { grid-template-columns: 1fr; justify-items: center; text-align: center; gap: 40px; }
}
@media (max-width: 640px) {
  .section, .stats, .hero-inner, .download { width: calc(100% - 32px); }
  .section { padding-top: 88px; }
  .section-head { margin-bottom: 40px; }
  .hero-copy h1 { letter-spacing: -1.6px; }
  .stats { grid-template-columns: repeat(2, 1fr); }
  .stat:nth-child(3) { border-left: 0; }
  .stat:nth-child(n + 3) { border-top: 1px solid #ffffff12; }
  .modes, .limits { grid-template-columns: 1fr; }
  .mode { padding: 22px; }
  .vibes { gap: 10px; }
  .vibe-copy { left: 14px; right: 14px; bottom: 14px; }
  .vibe h3 { font-size: 1.2rem; }
  .vibe p { font-size: .8rem; }
  .download { margin: 88px auto 72px; padding: 56px 18px; border-radius: 26px; }
}
@media (prefers-reduced-motion: reduce) {
  .how-step, .mode, .vibe img, .reel-steps li, .faq-item summary span { transition: none; }
  .mode:hover { transform: none; }
}
</style>
