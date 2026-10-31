<template>
  <div class="demo">
    <div class="demo-modes" role="tablist" aria-label="Kies een spelvorm">
      <button v-for="m in modes" :key="m.code" type="button" role="tab" class="demo-mode" :class="{ active: mode === m.code }" :aria-selected="mode === m.code" :style="{ '--accent': m.accent }" @click="choose(m.code)">
        <span class="demo-mode-dot" aria-hidden="true"></span>{{ m.title }}
      </button>
    </div>

    <div class="demo-stage">
      <div class="demo-deck" aria-hidden="true"><i></i><i></i></div>
      <article ref="cardEl" class="demo-card" :style="{ '--accent': current.accent }" aria-live="polite">
        <header class="demo-card-head">
          <span><i class="dot"></i>{{ current.title }}</span>
          <span class="demo-count">{{ String(drawn).padStart(2, "0") }}</span>
        </header>
        <div class="demo-art" aria-hidden="true"><GameModeArtwork :code="mode" /></div>
        <p class="demo-for">{{ card.for }}</p>
        <h3 class="demo-question">{{ card.question }}</h3>

        <div v-if="mode === 'quiz'" class="demo-options">
          <button v-for="(text, key) in card.options" :key="key" type="button" class="demo-option" :class="{ picked: picked === key, correct: revealed && card.answer === key, wrong: revealed && picked === key && card.answer !== key }" :aria-pressed="picked === key" @click="picked = key">
            <span>{{ key }}</span>{{ text }}
          </button>
          <button type="button" class="demo-reveal" :aria-expanded="revealed" @click="reveal">
            {{ revealed ? (picked === card.answer ? "Goed! Een punt voor jou." : picked ? `Helaas, het was ${card.answer}.` : `Het antwoord is ${card.answer}.`) : "Onthul het antwoord" }}
          </button>
        </div>
        <div v-else-if="mode === 'dilemma'" class="demo-dilemma">
          <button v-for="(text, key) in card.options" :key="key" type="button" class="demo-side" :class="[`side-${key}`, { picked: picked === key }]" :aria-pressed="picked === key" @click="picked = key">
            <span>{{ key }}</span>{{ text }}
          </button>
          <p class="demo-hint">{{ picked ? "In het spel kiest iedereen tegelijk. De minderheid krijgt een opdracht." : "Kies een kant." }}</p>
        </div>
        <div v-else-if="mode === 'likely'" class="demo-players">
          <button v-for="name in players" :key="name" type="button" class="demo-player" :class="{ picked: picked === name }" :aria-pressed="picked === name" @click="picked = name">{{ name }}</button>
          <p class="demo-hint">{{ picked ? `${picked} krijgt de meeste stemmen en dus een opdracht.` : "Wijs tegelijk iemand aan." }}</p>
        </div>
        <p v-else class="demo-hint demo-rule">{{ card.rule }}</p>
      </article>
    </div>

    <button type="button" class="demo-draw" @click="draw">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="3" width="14" height="18" rx="2.5" /><path d="M9 8h6M9 12h6" /></svg>
      Trek een nieuwe kaart
    </button>
  </div>
</template>

<script setup lang="ts">
import { computed, onBeforeUnmount, ref } from "vue";
import { gsap } from "gsap";

type Mode = "knowme" | "chaos" | "likely" | "dilemma" | "quiz";
interface Sample { question: string; options?: Record<string, string>; answer?: string }

const players = ["Noor", "Daan", "Sanne", "Milan"];
// Real cards from the app (filter: Normaal). [player] is filled in with one of the example players.
const samples: Record<Mode, Sample[]> = {
  knowme: [
    { question: "Wat is de favoriete snack van [player]?" },
    { question: "Naar welk land wil [player] het liefst op vakantie?" },
    { question: "Wat voor weer vindt [player] het fijnst?" },
    { question: "Van welk klein dagelijks moment wordt [player] blij?" },
    { question: "Welk gerecht kookt [player] het liefst?" },
    { question: "Wat doet [player] als eerste als die thuiskomt?" },
  ],
  chaos: [
    { question: "Raak binnen 10 seconden een zwart object aan. De laatste of wie niets vindt krijgt straf." },
    { question: "Vertel om de beurt een mop zonder te lachen. Degene die zelf lacht of waarbij niemand lacht, krijgt straf." },
    { question: "Iedereen maakt een 10 seconden freestyle-rap over de kamer. Degene met de flauwste tekst krijgt straf." },
    { question: "Speel allemaal een scène waarin je een paparazzi ontwijkt. Degene die het minst dramatisch is krijgt straf." },
  ],
  likely: [
    { question: "Wie is most likely to te laat komen op zijn eigen bruiloft?" },
    { question: "Wie is most likely to een roadtrip starten zonder ook maar iets te plannen?" },
    { question: "Wie is most likely to een DM sturen naar een celebrity?" },
    { question: "Wie uit deze groep zou een vakantiefoto als een filmregisseur organiseren?" },
  ],
  dilemma: [
    { question: "Zou je liever elke ochtend om 4 uur opstaan of elke avond pas om 4 uur slapen?", options: { A: "Elke ochtend om 4 uur opstaan", B: "Elke avond pas om 4 uur slapen" } },
    { question: "Zou je liever elke week verhuizen of nooit meer je geboorteplaats verlaten?", options: { A: "Elke week verhuizen", B: "Nooit meer je geboorteplaats verlaten" } },
    { question: "Zou je liever rijk en beroemd zijn maar gehaat of geliefd en arm maar onbekend?", options: { A: "Rijk en beroemd, maar gehaat", B: "Geliefd en arm, maar onbekend" } },
    { question: "Zou je liever elke dag een presentatie geven of elke dag een sollicitatiegesprek voeren?", options: { A: "Elke dag een presentatie geven", B: "Elke dag een sollicitatiegesprek voeren" } },
  ],
  quiz: [
    { question: "Wat is de hoofdstad van Australië?", options: { A: "Sydney", B: "Canberra", C: "Melbourne", D: "Brisbane" }, answer: "B" },
    { question: "Welke schilder maakte 'Sterrennacht'?", options: { A: "Vincent van Gogh", B: "Claude Monet", C: "Paul Cézanne", D: "Pablo Picasso" }, answer: "A" },
    { question: "Wie schreef de roman 1984?", options: { A: "J.R.R. Tolkien", B: "George Orwell", C: "Aldous Huxley", D: "Ray Bradbury" }, answer: "B" },
    { question: "Wat is het grootste Waddeneiland van Nederland?", options: { A: "Texel", B: "Terschelling", C: "Ameland", D: "Vlieland" }, answer: "A" },
  ],
};
const modes: { code: Mode; title: string; accent: string; rule: string }[] = [
  { code: "knowme", title: "Do You Know Me?", accent: "#c4a9e4", rule: "Iedereen raadt om de beurt. Klopt het met wat [player] zegt? Dan een punt." },
  { code: "quiz", title: "Quizmaster", accent: "#a1cbd7", rule: "" },
  { code: "dilemma", title: "Dilemma Duel", accent: "#eeb295", rule: "" },
  { code: "likely", title: "Most Likely To", accent: "#c6d29a", rule: "" },
  { code: "chaos", title: "Chaos Crew", accent: "#eea0af", rule: "Iedereen doet tegelijk mee. Wie verliest, krijgt een opdracht." },
];

const mode = ref<Mode>("knowme");
const position = ref<Record<Mode, number>>({ knowme: 0, chaos: 0, likely: 0, dilemma: 0, quiz: 0 });
const player = ref(players[0]!);
const picked = ref<string | null>(null);
const revealed = ref(false);
const drawn = ref(1);
const cardEl = ref<HTMLElement | null>(null);
let tween: gsap.core.Timeline | undefined;

const current = computed(() => modes.find((m) => m.code === mode.value)!);
const card = computed(() => {
  const sample = samples[mode.value][position.value[mode.value] % samples[mode.value].length]!;
  const fill = (text: string) => text.replaceAll("[player]", player.value);
  return {
    ...sample,
    question: fill(sample.question),
    rule: fill(current.value.rule),
    for: mode.value === "knowme" ? `In de hoofdrol: ${player.value}` : "Iedereen doet mee",
  };
});

function animate(change: () => void) {
  if (!cardEl.value || window.matchMedia("(prefers-reduced-motion: reduce)").matches) { change(); return; }
  tween?.kill();
  tween = gsap.timeline()
    .to(cardEl.value, { x: 60, y: -14, rotation: 6, opacity: 0, duration: .22, ease: "power2.in" })
    .add(change)
    .fromTo(cardEl.value, { x: -30, y: 26, rotation: -4, opacity: 0 }, { x: 0, y: 0, rotation: 0, opacity: 1, duration: .5, ease: "back.out(1.4)" });
}

function draw() {
  animate(() => {
    position.value[mode.value]++;
    player.value = players[Math.floor(Math.random() * players.length)]!;
    picked.value = null;
    revealed.value = false;
    drawn.value++;
  });
}

function choose(code: Mode) {
  if (code === mode.value) return;
  animate(() => {
    mode.value = code;
    picked.value = null;
    revealed.value = false;
    drawn.value++;
  });
}

function reveal() {
  revealed.value = true;
}

onBeforeUnmount(() => tween?.kill());
</script>

<style scoped>
.demo { display: grid; justify-items: center; gap: 26px; }
.demo-modes { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; }
.demo-mode { display: inline-flex; align-items: center; gap: 8px; min-height: 42px; padding: 8px 15px; border: 1px solid #ffffff17; border-radius: 99px; color: #cdbdb4; font-size: .88rem; transition: background .2s, color .2s, border-color .2s; }
.demo-mode:hover { color: #fff3e6; border-color: #ffffff30; }
.demo-mode.active { background: color-mix(in srgb, var(--accent) 18%, #1c171b); border-color: color-mix(in srgb, var(--accent) 60%, transparent); color: #fff6ec; }
.demo-mode-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--accent); }
.demo-stage { position: relative; width: min(460px, 100%); }
.demo-deck i { position: absolute; inset: 10px 10px -10px; border-radius: 26px; border: 1px solid #dcb8a03b; z-index: 0; }
.demo-deck i:first-child { background: #a28396; opacity: .4; transform: rotate(-3deg); }
.demo-deck i:last-child { background: #bca18b; opacity: .45; transform: rotate(2.5deg); }
.demo-card { position: relative; z-index: 1; display: flex; flex-direction: column; min-height: 470px; padding: 24px 26px 26px; border-radius: 26px; color: #352932; text-align: center; background: radial-gradient(ellipse at 80% 0%, color-mix(in srgb, var(--accent) 60%, transparent), transparent 65%), linear-gradient(135deg, #f3e9da, #e9d5c4); box-shadow: 0 30px 80px -24px #000000aa; }
.demo-card-head { display: flex; justify-content: space-between; align-items: center; font-size: .78rem; font-weight: 600; }
.demo-card-head span:first-child { display: inline-flex; align-items: center; gap: 7px; }
.dot { width: 6px; height: 6px; border-radius: 50%; background: #4b354b; }
.demo-count { font-weight: 400; letter-spacing: 1.5px; color: #6c535780; }
.demo-art { width: 110px; height: 76px; margin: 14px auto 2px; color: #5a3c4f; }
.demo-for { margin-bottom: 10px; color: #775c60; font-size: .78rem; }
.demo-question { margin: 0 auto 20px; max-width: 380px; font-size: clamp(1.3rem, 3vw, 1.6rem); font-weight: 600; line-height: 1.28; letter-spacing: -.5px; text-wrap: balance; }
.demo-options { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: auto; }
.demo-option { position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; min-height: 64px; padding: 9px; border: 1px solid #68455524; border-radius: 12px; background: #fff4de4d; font-size: .85rem; font-weight: 500; transition: background .2s, border-color .2s; }
.demo-option span { display: grid; place-items: center; width: 22px; height: 22px; border-radius: 50%; background: #6845551a; font-size: .68rem; font-weight: 700; color: #6d4b58; }
.demo-option:hover { background: #fff8ea99; }
.demo-option.picked { border-color: #704664; background: #b99bb340; }
.demo-option.picked span { background: #704664; color: #fff3e6; }
.demo-option.correct { border-color: #5d7c55; background: #a3c08b4d; }
.demo-option.correct span { background: #5d7c55; color: #f5fbef; }
.demo-option.wrong { border-color: #b4586c; background: #e8a3b04d; }
.demo-reveal { grid-column: 1 / -1; min-height: 50px; margin-top: 4px; border-radius: 12px; background: linear-gradient(105deg, #ffc59a 0%, #f79a86 40%, #ee6f86 100%); color: #3a1726; font-weight: 700; font-size: .95rem; box-shadow: 0 8px 22px #e5677f40; }
.demo-reveal[aria-expanded="true"] { background: #3a2732; color: #ffe3d6; }
.demo-dilemma { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: auto; }
.demo-side { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 9px; min-height: 108px; padding: 14px 10px; border-radius: 14px; border: 1px solid #68455526; background: #fff4de4d; font-size: .88rem; font-weight: 500; line-height: 1.35; transition: transform .2s, background .2s, border-color .2s; }
.demo-side span { display: grid; place-items: center; width: 28px; height: 28px; border-radius: 50%; font-weight: 700; color: #2c1a24; }
.side-A span { background: #f3a08d; }
.side-B span { background: #c9b3ed; }
.demo-side.picked { transform: translateY(-3px); border-color: #704664; background: #fff8ea; box-shadow: 0 10px 24px -14px #00000055; }
.demo-players { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-top: auto; }
.demo-player { min-height: 44px; padding: 8px 16px; border-radius: 99px; border: 1px solid #68455530; background: #fff4de4d; font-weight: 500; }
.demo-player.picked { background: #3a2732; color: #ffe3d6; border-color: #3a2732; }
.demo-hint { grid-column: 1 / -1; width: 100%; margin-top: 8px; color: #6f4f59; font-size: .82rem; line-height: 1.5; }
.demo-rule { margin-top: auto; padding: 14px; border-radius: 12px; background: #fff4de59; }
.demo-draw { display: inline-flex; align-items: center; gap: 10px; min-height: 52px; padding: 12px 22px; border-radius: 14px; border: 1px solid #ffffff24; color: #f5eee5; font-weight: 600; transition: background .2s, border-color .2s; }
.demo-draw:hover { background: #ffffff0d; border-color: #ffffff40; }
button { cursor: pointer; }
button:focus-visible { outline: 2px solid #f28c85; outline-offset: 3px; }
@media (max-width: 520px) {
  .demo-card { min-height: 440px; padding: 20px 18px 20px; }
  .demo-modes { flex-wrap: nowrap; justify-content: flex-start; overflow-x: auto; width: 100%; padding-bottom: 6px; scrollbar-width: none; }
  .demo-mode { flex-shrink: 0; }
}
@media (prefers-reduced-motion: reduce) { .demo-mode, .demo-option, .demo-side, .demo-draw { transition: none; } .demo-side.picked { transform: none; } }
</style>
