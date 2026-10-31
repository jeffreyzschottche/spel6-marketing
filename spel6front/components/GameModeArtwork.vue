<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, useId, watch } from "vue";
import { gsap } from "gsap";
type GameModeCode = "knowme" | "chaos" | "songbird" | "quiz" | "dilemma" | "likely";

const props = withDefaults(defineProps<{ code: GameModeCode; active?: boolean; preview?: boolean }>(), { active: true, preview: false });
const root = ref<SVGSVGElement | null>(null);
const uid = "mode-art-" + useId().replace(/[^a-zA-Z0-9_-]/g, "");
const paint = (name: string) => `url(#${uid}-${name})`;
const palettes = {
  knowme: { light: "#eee3ff", main: "#c4a9e4", deep: "#8d70b1", second: "#efbdad" },
  chaos: { light: "#ffe4df", main: "#eea0af", deep: "#bc647f", second: "#c9b5eb" },
  songbird: { light: "#fff2cd", main: "#e8c57f", deep: "#bd8c50", second: "#e9ac9f" },
  quiz: { light: "#e2f2f3", main: "#a1cbd7", deep: "#6795ad", second: "#c7b3dc" },
  dilemma: { light: "#ffead2", main: "#eeb295", deep: "#bf826b", second: "#c1b2df" },
  likely: { light: "#edf1d0", main: "#c6d29a", deep: "#87996a", second: "#d3b3cf" },
};
const palette = computed(() => palettes[props.code]);
let animations: gsap.core.Animation[] = [];
let context: gsap.Context | undefined;
let media: ReturnType<typeof gsap.matchMedia> | undefined;

function sync() {
  const playing = (props.active || props.preview) && !document.hidden;
  animations.forEach((animation) => {
    animation.timeScale(props.preview ? 1.3 : 1);
    if (playing) animation.resume(); else animation.pause();
  });
}
watch(() => [props.active, props.preview], sync);

onMounted(() => {
  context = gsap.context(() => {
    media = gsap.matchMedia();
    media.add("(prefers-reduced-motion: no-preference)", () => {
      const q = gsap.utils.selector(root.value!);
      const loop = (selector: string, vars: gsap.TweenVars) => {
        const targets = q(selector);
        if (!targets.length) return;
        animations.push(gsap.to(targets, { repeat: -1, paused: true, ease: "sine.inOut", ...vars }));
      };
      loop(".art-spark", { scale: .72, opacity: .45, transformOrigin: "50% 50%", duration: 2, stagger: .35, yoyo: true });
      if (props.code === "knowme") {
        loop(".art-person-left", { x: -3, y: -2, rotation: -3, transformOrigin: "50% 80%", duration: 2.8, yoyo: true });
        loop(".art-person-right", { x: 2, y: -4, rotation: 3, transformOrigin: "50% 80%", duration: 3.2, yoyo: true });
        loop(".art-question", { y: -3, rotation: 7, transformOrigin: "50% 50%", duration: 2.2, yoyo: true });
        loop(".art-heart", { scale: 1.12, transformOrigin: "50% 50%", duration: 1.9, yoyo: true });
      } else if (props.code === "chaos") {
        loop(".art-burst", { rotation: 360, svgOrigin: "91 63", duration: 22, ease: "none" });
        loop(".art-dice", { y: -4, rotation: -7, transformOrigin: "50% 65%", duration: 2.6, yoyo: true });
        loop(".art-satellite", { y: -5, x: 2, rotation: 9, transformOrigin: "50% 50%", stagger: .45, duration: 2.4, yoyo: true });
      } else if (props.code === "songbird") {
        loop(".art-record", { rotation: 360, svgOrigin: "76 64", duration: 12, ease: "none" });
        loop(".art-wave", { scaleY: .35, transformOrigin: "50% 100%", duration: .65, stagger: .17, yoyo: true });
        loop(".art-note", { y: -4, rotation: 7, transformOrigin: "50% 50%", duration: 2.3, yoyo: true });
      } else if (props.code === "quiz") {
        loop(".art-answer-a", { y: -3, rotation: -3, transformOrigin: "50% 80%", duration: 2.8, yoyo: true });
        loop(".art-answer-b", { y: -5, rotation: 2, transformOrigin: "50% 80%", duration: 2.5, yoyo: true });
        loop(".art-answer-c", { y: -2, rotation: 3, transformOrigin: "50% 80%", duration: 3.1, yoyo: true });
        loop(".art-quiz-seal", { rotation: -12, y: -3, transformOrigin: "50% 50%", duration: 2.6, yoyo: true });
      } else if (props.code === "dilemma") {
        loop(".art-choice-left", { x: -3, y: -2, rotation: -4, transformOrigin: "50% 65%", duration: 2.8, yoyo: true });
        loop(".art-choice-right", { x: 3, y: -4, rotation: 4, transformOrigin: "50% 65%", duration: 2.8, yoyo: true });
        loop(".art-choice-center", { rotation: 180, transformOrigin: "50% 50%", duration: 8, ease: "none" });
      } else {
        const vote = gsap.timeline({ paused: true, repeat: -1, defaults: { duration: .8, ease: "power2.inOut" } })
          .to(q(".art-pointer, .art-vote-ring"), { x: -45 }, "+=1.1")
          .to(q(".art-pointer, .art-vote-ring"), { x: 45 }, "+=1")
          .to(q(".art-pointer, .art-vote-ring"), { x: 0 }, "+=1");
        animations.push(vote);
        loop(".art-pointer-hand", { y: -2, duration: 1.7, yoyo: true });
        loop(".art-voter", { y: -2, stagger: .3, duration: 2.1, yoyo: true });
      }
      sync();
      return () => { animations = []; };
    });
  }, root.value!);
  document.addEventListener("visibilitychange", sync);
});
onBeforeUnmount(() => { document.removeEventListener("visibilitychange", sync); media?.revert(); context?.revert(); animations = []; });
</script>

<template>
  <svg ref="root" class="mode-artwork" :data-artwork="code" viewBox="0 0 180 125" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <defs>
      <linearGradient :id="uid + '-main'" x1=".15" y1="0" x2=".85" y2="1" gradientUnits="objectBoundingBox"><stop :stop-color="palette.light"/><stop offset=".38" :stop-color="palette.main"/><stop offset="1" :stop-color="palette.deep"/></linearGradient>
      <linearGradient :id="uid + '-second'" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#fff0df"/><stop offset=".36" :stop-color="palette.second"/><stop offset="1" :stop-color="palette.second" stop-opacity=".8"/></linearGradient>
      <linearGradient :id="uid + '-paper'" x1="0" y1="0" x2=".85" y2="1"><stop stop-color="#fff6e6"/><stop offset=".6" stop-color="#ebdccd"/><stop offset="1" stop-color="#c6afa7"/></linearGradient>
      <linearGradient :id="uid + '-skin'" x1=".1" y1="0" x2=".9" y2="1"><stop stop-color="#ffe5c8"/><stop offset="1" stop-color="#d9a494"/></linearGradient>
      <linearGradient :id="uid + '-gold'" x1="0" y1="0" x2=".8" y2="1"><stop stop-color="#fff0bf"/><stop offset=".5" stop-color="#e5c381"/><stop offset="1" stop-color="#b68552"/></linearGradient>
      <radialGradient :id="uid + '-vinyl'" cx=".35" cy=".2" r=".85"><stop stop-color="#574454"/><stop offset=".45" stop-color="#2e2637"/><stop offset="1" stop-color="#161723"/></radialGradient>
      <radialGradient :id="uid + '-halo'"><stop :stop-color="palette.main" stop-opacity=".17"/><stop offset="1" :stop-color="palette.main" stop-opacity="0"/></radialGradient>
      <filter :id="uid + '-shadow'" x="-40%" y="-30%" width="180%" height="180%" color-interpolation-filters="sRGB"><feDropShadow dx="0" dy="4" stdDeviation="3" flood-color="#0d0716" flood-opacity=".23"/></filter>
      <pattern :id="uid + '-speckle'" width="11" height="13" patternUnits="userSpaceOnUse"><circle cx="2" cy="3" r=".55" fill="#fff6e5" fill-opacity=".2"/><circle cx="8" cy="9" r=".4" fill="#493543" fill-opacity=".12"/></pattern>
    </defs>
    <ellipse cx="91" cy="66" rx="85" ry="58" :fill="paint('halo')"/>
    <ellipse cx="92" cy="113" rx="54" ry="4" fill="#0e0816" fill-opacity=".1"/>

    <template v-if="code === 'knowme'">
      <path d="M23 71c9-26 27-38 56-32 29 6 46 50 75 33" :stroke="palette.main" stroke-opacity=".3" stroke-width="1.2" stroke-dasharray="2 5" stroke-linecap="round"/>
      <g class="art-person-left"><g transform="rotate(-12 61 68)" :filter="paint('shadow')">
        <rect x="29" y="29" width="62" height="80" rx="9" :fill="palette.deep"/>
        <rect x="29" y="26" width="62" height="80" rx="9" :fill="paint('main')" stroke="#fff1ea" stroke-opacity=".45"/>
        <rect x="35" y="33" width="50" height="51" rx="5" :fill="paint('second')"/>
        <path d="M40 84c1-14 9-21 20-21s19 7 20 21" fill="#725877"/>
        <path d="m55 64 5 8 5-8" fill="#e9b8a6"/>
        <ellipse cx="60" cy="53" rx="10" ry="13" :fill="paint('skin')"/>
        <path d="M50 52c-1-8 3-14 11-13 9 0 12 7 8 14l-3-8c-6 4-11 0-16 7Z" fill="#513647"/>
        <path d="M57 57c2 2 4 2 6 0" stroke="#9b6464" stroke-width="1.1" stroke-linecap="round"/>
        <circle cx="56" cy="53" r=".8" fill="#513647"/><circle cx="64" cy="53" r=".8" fill="#513647"/>
        <path d="M46 94h28m-21 4h15" stroke="#654b70" stroke-opacity=".6" stroke-width="1.5" stroke-linecap="round"/>
        <rect x="30" y="27" width="60" height="78" rx="8" :fill="paint('speckle')"/>
        <path d="M35 29h45" stroke="#fff4e5" stroke-opacity=".5" stroke-linecap="round"/>
      </g></g>
      <g class="art-person-right"><g transform="rotate(10 114 64)" :filter="paint('shadow')">
        <rect x="83" y="25" width="63" height="83" rx="9" fill="#b29da2"/>
        <rect x="83" y="22" width="63" height="83" rx="9" :fill="paint('paper')" stroke="#fff4e4" stroke-opacity=".7"/>
        <rect x="89" y="29" width="51" height="53" rx="5" :fill="paint('main')"/>
        <path d="M102 61c-8-14-1-27 12-27 16-1 22 18 12 30" fill="#654457"/>
        <path d="M95 82c1-14 9-20 19-20s18 6 20 20" :fill="paint('second')"/>
        <path d="m109 63 5 7 5-7" fill="#d9a392"/>
        <ellipse cx="114" cy="51" rx="10" ry="13" :fill="paint('skin')"/>
        <path d="M104 47c0-10 14-14 20-1-5 1-10-3-12-6-1 4-4 6-8 7Z" fill="#654457"/>
        <circle cx="110" cy="51" r=".8" fill="#654457"/><circle cx="118" cy="51" r=".8" fill="#654457"/>
        <path d="M111 57c2 2 4 2 6 0" stroke="#a36d6c" stroke-width="1.1" stroke-linecap="round"/>
        <path d="M100 93h28m-21 4h14" stroke="#a68b92" stroke-width="1.5" stroke-linecap="round"/>
        <rect x="84" y="23" width="61" height="81" rx="8" :fill="paint('speckle')"/>
      </g></g>
      <g class="art-question" :filter="paint('shadow')"><circle cx="145" cy="26" r="13" :fill="paint('main')" stroke="#f8ebff" stroke-opacity=".7"/><path d="M141 23c0-5 8-5 8 0 0 3-4 3-4 6m0 4h.01" stroke="#593c74" stroke-width="1.8" stroke-linecap="round"/></g>
      <path class="art-heart" d="M140 105s-9-5-9-10c0-5 7-6 9-1 2-5 9-4 9 1 0 5-9 10-9 10Z" :fill="paint('second')" stroke="#ffe8d7" stroke-opacity=".4"/>
      <path class="art-spark" d="m25 18 2 5 5 2-5 2-2 5-2-5-5-2 5-2Z" :fill="paint('gold')"/>
    </template>

    <template v-else-if="code === 'chaos'">
      <ellipse cx="92" cy="63" rx="65" ry="37" transform="rotate(-25 92 63)" :stroke="palette.main" stroke-opacity=".25" stroke-dasharray="2 5"/>
      <g class="art-burst" :filter="paint('shadow')">
        <path d="M91 18c5 0 6 16 10 19 4 2 17-11 21-7 5 4-8 17-6 21 2 5 19 6 19 12s-17 7-19 11c-2 4 10 17 6 21-4 5-17-8-21-6-5 2-4 19-10 19s-7-17-11-19c-4-2-17 11-21 6-4-4 9-17 7-21-2-4-19-5-19-11s17-7 19-12c2-4-11-17-7-21 4-4 17 9 21 7 4-3 5-19 11-19Z" :fill="paint('main')" stroke="#ffe6dd" stroke-opacity=".65" stroke-width=".9"/>
        <path d="M91 18c5 0 6 16 10 19 4 2 17-11 21-7 5 4-8 17-6 21 2 5 19 6 19 12s-17 7-19 11c-2 4 10 17 6 21-4 5-17-8-21-6-5 2-4 19-10 19s-7-17-11-19c-4-2-17 11-21 6-4-4 9-17 7-21-2-4-19-5-19-11s17-7 19-12c2-4-11-17-7-21 4-4 17 9 21 7 4-3 5-19 11-19Z" :fill="paint('speckle')"/>
        <path d="m91 47 4 12 12 4-12 4-4 12-4-12-12-4 12-4Z" fill="#fff0df" fill-opacity=".87"/>
        <path d="M62 34c5 2 11 8 16 8m18-17 3 12" stroke="#fff1df" stroke-opacity=".5" stroke-width="1.5" stroke-linecap="round"/>
      </g>
      <g class="art-dice"><g transform="rotate(-17 39 88)" :filter="paint('shadow')"><rect x="20" y="73" width="37" height="37" rx="10" fill="#806a9b"/><rect x="20" y="69" width="37" height="37" rx="10" :fill="paint('second')" stroke="#eee1ff" stroke-opacity=".7"/><circle cx="30" cy="79" r="2.5" fill="#6c507e"/><circle cx="39" cy="88" r="2.5" fill="#6c507e"/><circle cx="48" cy="97" r="2.5" fill="#6c507e"/><path d="M25 73h17" stroke="#fff0e4" stroke-opacity=".7" stroke-linecap="round"/></g></g>
      <g class="art-satellite"><circle cx="149" cy="88" r="10" :fill="paint('gold')" stroke="#fff0d3" stroke-opacity=".7"/><path d="M145 84c1-2 4-3 6-1" stroke="#fff6d9" stroke-width="1.5" stroke-linecap="round"/></g>
      <path class="art-satellite" d="m142 15 6 8-6 8-6-8Z" :fill="paint('second')"/>
      <path class="art-spark" d="m30 27 2 6 6 2-6 2-2 6-2-6-6-2 6-2Z" :fill="paint('gold')"/>
    </template>

    <template v-else-if="code === 'songbird'">
      <path d="M16 74c-8-25 7-49 35-55" :stroke="palette.main" stroke-opacity=".3" stroke-width="1.1" stroke-dasharray="2 5"/>
      <circle cx="76" cy="68" r="43" fill="#100d19" fill-opacity=".45"/>
      <g class="art-record" :filter="paint('shadow')">
        <circle cx="76" cy="64" r="43" :fill="paint('vinyl')" stroke="#d7c4ca" stroke-opacity=".4"/>
        <circle cx="76" cy="64" r="36" stroke="#e6d4c6" stroke-opacity=".16" stroke-width=".7"/><circle cx="76" cy="64" r="32" stroke="#e6d4c6" stroke-opacity=".13" stroke-width=".7"/><circle cx="76" cy="64" r="28" stroke="#e6d4c6" stroke-opacity=".12" stroke-width=".7"/>
        <path d="M76 64 46 34a43 43 0 0 1 48-9Z" fill="#fff5e6" fill-opacity=".09"/><path d="m76 64 30 30a43 43 0 0 1-48 9Z" fill="#fff5e6" fill-opacity=".045"/>
        <path d="M43 51a36 36 0 0 1 16-18m34 64a36 36 0 0 0 16-18" stroke="#f0e3da" stroke-opacity=".35" stroke-width="1.6" stroke-linecap="round"/>
        <circle cx="76" cy="64" r="18" :fill="paint('gold')" stroke="#f9dfad" stroke-width=".5"/>
        <circle cx="76" cy="64" r="13" stroke="#80573e" stroke-opacity=".25" stroke-dasharray="1 3"/>
        <path d="m76 52 2 5 5 2-5 2-2 5-2-5-5-2 5-2Z" fill="#74513f" fill-opacity=".6"/>
        <circle cx="76" cy="64" r="3.2" fill="#29212e" stroke="#f6dbad" stroke-width=".7"/>
        <path d="M69 72h14m-10 3h6" stroke="#8b6747" stroke-opacity=".6" stroke-width="1" stroke-linecap="round"/>
      </g>
      <g :filter="paint('shadow')"><circle cx="119" cy="29" r="5" :fill="paint('paper')"/><path d="m119 29 6 33-16 19" stroke="#f8ddad" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="m108 77-5 7 7 4 5-7Z" :fill="paint('gold')" stroke="#fff0cc" stroke-width=".6"/></g>
      <rect x="132" y="55" width="31" height="40" rx="9" :fill="paint('main')" fill-opacity=".15" stroke="#f0d5a3" stroke-opacity=".25"/>
      <rect class="art-wave" x="138" y="68" width="3.5" height="18" rx="1.75" :fill="paint('gold')"/><rect class="art-wave" x="145" y="62" width="3.5" height="24" rx="1.75" :fill="paint('gold')"/><rect class="art-wave" x="152" y="72" width="3.5" height="14" rx="1.75" :fill="paint('gold')"/>
      <g class="art-note" stroke="#f2d294" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M144 31V17l15-3v14m-15-7 15-3"/><ellipse cx="140" cy="32" rx="4.5" ry="3" :fill="paint('gold')"/><ellipse cx="155" cy="29" rx="4.5" ry="3" :fill="paint('gold')"/></g>
      <path class="art-spark" d="m28 16 2 6 6 2-6 2-2 6-2-6-6-2 6-2Z" :fill="paint('second')"/>
    </template>

    <template v-else-if="code === 'quiz'">
      <g class="art-answer-a"><g transform="rotate(-15 49 74)" :filter="paint('shadow')"><rect x="27" y="44" width="45" height="62" rx="8" fill="#9e8cad"/><rect x="27" y="41" width="45" height="62" rx="8" :fill="paint('second')" stroke="#f1e5f5" stroke-opacity=".6"/><text x="49" y="80" text-anchor="middle" fill="#72557c" font-size="27" font-weight="600">A</text><path d="M41 90h16" stroke="#745b7f" stroke-opacity=".35" stroke-width="1.5" stroke-linecap="round"/></g></g>
      <g class="art-answer-c"><g transform="rotate(14 133 71)" :filter="paint('shadow')"><rect x="111" y="41" width="45" height="65" rx="8" fill="#b9a390"/><rect x="111" y="38" width="45" height="65" rx="8" :fill="paint('paper')" stroke="#fff0df" stroke-opacity=".65"/><text x="134" y="79" text-anchor="middle" fill="#a17b6a" font-size="27" font-weight="600">C</text><path d="M126 90h16" stroke="#aa8b78" stroke-opacity=".45" stroke-width="1.5" stroke-linecap="round"/></g></g>
      <g class="art-answer-b"><g transform="rotate(-2 91 64)" :filter="paint('shadow')"><rect x="63" y="29" width="56" height="79" rx="10" :fill="palette.deep"/><rect x="63" y="25" width="56" height="79" rx="10" :fill="paint('main')" stroke="#e7fbfa" stroke-opacity=".7"/><rect x="69" y="31" width="44" height="67" rx="6" stroke="#f4ffff" stroke-opacity=".3"/><text x="91" y="77" text-anchor="middle" fill="#406478" font-size="37" font-weight="600">B</text><path d="M80 88h22m-17 4h12" stroke="#406478" stroke-opacity=".45" stroke-width="1.4" stroke-linecap="round"/><path d="M69 28h35" stroke="#f4ffff" stroke-opacity=".7" stroke-linecap="round"/></g></g>
      <g class="art-quiz-seal" :filter="paint('shadow')"><path d="m140 14 4 3 5-1 2 5 4 3-1 5 1 5-4 3-2 5-5-1-4 3-4-3-5 1-2-5-4-3 1-5-1-5 4-3 2-5 5 1Z" :fill="paint('gold')" stroke="#fff0c6" stroke-opacity=".8"/><path d="m134 28 4 4 8-9" stroke="#8f683e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></g>
      <path class="art-spark" d="m22 22 2 5 5 2-5 2-2 5-2-5-5-2 5-2Z" :fill="paint('main')"/>
    </template>

    <template v-else-if="code === 'dilemma'">
      <path d="M17 83c18 22 43 20 67-1 23-21 45-28 77-10" :stroke="palette.main" stroke-opacity=".25" stroke-dasharray="2 5"/>
      <g class="art-choice-left"><g transform="rotate(-11 58 69)" :filter="paint('shadow')"><rect x="30" y="33" width="55" height="77" rx="12" fill="#927fa9"/><rect x="30" y="29" width="55" height="77" rx="12" :fill="paint('second')" stroke="#f2e6ff" stroke-opacity=".6"/><rect x="36" y="35" width="43" height="65" rx="8" stroke="#fff6e7" stroke-opacity=".3"/><path d="M68 68H46m8-8-8 8 8 8" stroke="#785b8b" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/><circle cx="47" cy="46" r="3" fill="#fff3dd" fill-opacity=".6"/><path d="M38 32h29" stroke="#fff0e4" stroke-opacity=".6" stroke-linecap="round"/></g></g>
      <g class="art-choice-right"><g transform="rotate(10 126 64)" :filter="paint('shadow')"><rect x="98" y="28" width="55" height="78" rx="12" :fill="palette.deep"/><rect x="98" y="24" width="55" height="78" rx="12" :fill="paint('main')" stroke="#fff0d5" stroke-opacity=".7"/><rect x="104" y="30" width="43" height="66" rx="8" stroke="#fff7df" stroke-opacity=".35"/><path d="M115 64h22m-8-8 8 8-8 8" stroke="#9d614f" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/><circle cx="137" cy="41" r="3" fill="#fff3dd" fill-opacity=".7"/><path d="M106 27h30" stroke="#fff5dc" stroke-opacity=".65" stroke-linecap="round"/></g></g>
      <g class="art-choice-center" :filter="paint('shadow')"><circle cx="91" cy="69" r="14" :fill="paint('gold')" stroke="#fff0c8" stroke-width=".8"/><path d="m85 66 3-3h8m1 9-3 3h-8" stroke="#946641" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/><path d="m85 66 3 3m9 3-3-3" stroke="#946641" stroke-width="1.4" stroke-linecap="round"/></g>
      <path class="art-spark" d="m20 21 2 6 6 2-6 2-2 6-2-6-6-2 6-2Z" :fill="paint('gold')"/><circle class="art-spark" cx="161" cy="99" r="2.3" :fill="palette.second"/>
    </template>

    <template v-else>
      <g class="art-vote-ring"><circle cx="90" cy="50" r="24" :stroke="palette.main" stroke-opacity=".35" stroke-width="1.2" stroke-dasharray="2 4"/><circle cx="90" cy="50" r="20" :fill="paint('halo')"/></g>
      <g class="art-voter" :filter="paint('shadow')"><path d="M25 105V84a20 20 0 0 1 40 0v21Z" :fill="paint('paper')" stroke="#ffefd8" stroke-opacity=".45"/><path d="M31 85v19m28-19v19" stroke="#a98d82" stroke-opacity=".35"/><path d="m39 65 6 10 6-10" fill="#c99183"/><ellipse cx="45" cy="51" rx="12" ry="15" :fill="paint('skin')"/><path d="M33 50c-1-8 4-16 13-15 9 0 14 7 11 16l-5-10c-7 5-12 1-19 9Z" fill="#685163"/><circle cx="41" cy="52" r=".8" fill="#685163"/><circle cx="49" cy="52" r=".8" fill="#685163"/><path d="M42 58c2 2 4 2 6 0" stroke="#a06e69" stroke-width="1.1" stroke-linecap="round"/></g>
      <g class="art-voter" :filter="paint('shadow')"><path d="M69 105V80a21 21 0 0 1 42 0v25Z" :fill="paint('main')" stroke="#edf3d1" stroke-opacity=".65"/><path d="M76 82v23m28-23v23" :stroke="palette.deep" stroke-opacity=".4"/><path d="m84 60 6 11 6-11" fill="#d69e87"/><ellipse cx="90" cy="45" rx="13" ry="16" :fill="paint('skin')"/><path d="M77 44c-2-8 4-17 14-17 12-1 17 9 11 18l-3-11c-5 6-14 0-22 10Z" fill="#4e3e4b"/><circle cx="85" cy="46" r=".9" fill="#4e3e4b"/><circle cx="95" cy="46" r=".9" fill="#4e3e4b"/><path d="M86 53c2 3 6 3 8 0" stroke="#a46f66" stroke-width="1.2" stroke-linecap="round"/><path d="M84 77h12" stroke="#eff1d5" stroke-opacity=".5" stroke-width="1.1" stroke-linecap="round"/></g>
      <g class="art-voter" :filter="paint('shadow')"><path d="M115 105V85a20 20 0 0 1 40 0v20Z" :fill="paint('second')" stroke="#f6e0e6" stroke-opacity=".6"/><path d="M121 86v19m28-19v19" stroke="#a17a9c" stroke-opacity=".4"/><path d="m130 65 5 10 5-10" fill="#c18a7d"/><path d="M121 62c-7-16 0-30 14-29 16 0 21 17 12 31" fill="#7e5d66"/><ellipse cx="135" cy="51" rx="12" ry="15" :fill="paint('skin')"/><path d="M124 46c0-12 17-15 23 0-6 0-11-3-14-7-1 4-5 6-9 7Z" fill="#7e5d66"/><circle cx="131" cy="51" r=".8" fill="#7e5d66"/><circle cx="139" cy="51" r=".8" fill="#7e5d66"/><path d="M132 58c2 2 4 2 6 0" stroke="#a46f66" stroke-width="1.1" stroke-linecap="round"/></g>
      <g class="art-pointer"><g class="art-pointer-hand" :filter="paint('shadow')"><path d="M83 6h14a4 4 0 0 1 4 4v7c0 4-2 6-5 8l-3 2v8a3 3 0 0 1-6 0V23l-3 2c-3 2-6-2-4-5l2-3v-7a4 4 0 0 1 4-4Z" :fill="paint('skin')" stroke="#ffe8cd" stroke-width=".8"/><path d="M87 15v8m6-9v12m-6-5h6" stroke="#bf8d7c" stroke-opacity=".65" stroke-width=".9" stroke-linecap="round"/><rect x="82" y="3" width="18" height="7" rx="2.5" :fill="paint('main')" stroke="#eef1d0" stroke-opacity=".6"/></g></g>
      <path class="art-spark" d="m21 22 2 5 5 2-5 2-2 5-2-5-5-2 5-2Z" :fill="paint('gold')"/><path class="art-spark" d="m159 43 2 5 5 2-5 2-2 5-2-5-5-2 5-2Z" :fill="paint('second')"/>
    </template>
  </svg>
</template>

<style scoped>
.mode-artwork { display: block; width: 100%; height: 100%; overflow: visible; pointer-events: none; }
text { font-family: "Spel6 Sans", sans-serif; }
</style>
