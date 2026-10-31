<template>
  <header class="nav" :class="{ 'nav-solid': scrolled || open }">
    <div class="nav-inner">
      <NuxtLink to="/" class="nav-brand" aria-label="Spel6, naar de homepage"><span class="wordmark" aria-hidden="true"></span></NuxtLink>
      <nav class="nav-links" aria-label="Hoofdmenu">
        <NuxtLink v-for="link in links" :key="link.to" :to="link.to" class="nav-link">{{ link.name }}</NuxtLink>
      </nav>
      <NuxtLink to="/#download" class="nav-cta">Download</NuxtLink>
      <button type="button" class="nav-toggle" :aria-expanded="open" aria-controls="mobile-menu" :aria-label="open ? 'Menu sluiten' : 'Menu openen'" @click="open = !open">
        <span :class="{ open }" aria-hidden="true"></span>
      </button>
    </div>
    <nav v-show="open" id="mobile-menu" class="nav-mobile" aria-label="Mobiel menu">
      <NuxtLink v-for="link in links" :key="link.to" :to="link.to" @click="open = false">{{ link.name }}</NuxtLink>
      <NuxtLink to="/#download" class="nav-mobile-cta" @click="open = false">Download de app</NuxtLink>
    </nav>
  </header>
</template>

<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref, watch } from "vue";

const links = [
  { name: "Zo werkt het", to: "/#zo-werkt-het" },
  { name: "Spelvormen", to: "/#spelvormen" },
  { name: "Probeer een kaart", to: "/#probeer" },
  { name: "FAQ", to: "/#faq" },
  { name: "Contact", to: "/contact" },
];

const route = useRoute();
const scrolled = ref(false);
const open = ref(false);
const onScroll = () => { scrolled.value = window.scrollY > 16; };

onMounted(() => { window.addEventListener("scroll", onScroll, { passive: true }); onScroll(); });
onBeforeUnmount(() => window.removeEventListener("scroll", onScroll));
watch(() => route.fullPath, () => { open.value = false; });
</script>

<style scoped>
.nav { position: fixed; inset: 0 0 auto; z-index: 50; transition: background .3s, border-color .3s, backdrop-filter .3s; border-bottom: 1px solid transparent; }
.nav-solid { background: #151115d9; backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); border-bottom-color: #ffffff12; }
.nav-inner { display: flex; align-items: center; gap: 28px; width: min(1180px, calc(100% - 40px)); height: 72px; margin: 0 auto; }
.nav-brand { width: 104px; flex-shrink: 0; }
.nav-links { display: flex; gap: 4px; margin-left: auto; }
.nav-link { padding: 10px 12px; border-radius: 10px; color: #cdbdb4; font-size: .9rem; transition: color .2s, background .2s; }
.nav-link:hover { color: #fff3e6; background: #ffffff0a; }
.nav-cta { padding: 11px 18px; border-radius: 12px; background: var(--cta-gradient); color: #2c1520; font-weight: 600; font-size: .9rem; box-shadow: 0 10px 26px -12px #f28c85aa; transition: transform .2s; }
.nav-cta:hover { transform: translateY(-1px); }
.nav-toggle { display: none; width: 44px; height: 44px; margin-left: auto; border-radius: 12px; }
.nav-toggle span, .nav-toggle span::before { position: relative; display: block; width: 20px; height: 1.5px; margin: auto; background: #f5eee5; transition: transform .25s; }
.nav-toggle span::before { content: ""; position: absolute; top: 6px; }
.nav-toggle span.open { transform: translateY(3px) rotate(45deg); }
.nav-toggle span.open::before { transform: translateY(-6px) rotate(-90deg); }
.nav-mobile { display: grid; gap: 2px; padding: 8px 20px 22px; }
.nav-mobile a { padding: 14px 4px; border-bottom: 1px solid #ffffff10; color: #e8dbd2; font-size: 1.05rem; }
.nav-mobile .nav-mobile-cta { margin-top: 12px; border: 0; border-radius: 14px; background: var(--cta-gradient); color: #2c1520; text-align: center; font-weight: 600; }
a:focus-visible, button:focus-visible { outline: 2px solid #f28c85; outline-offset: 3px; }
@media (max-width: 900px) {
  .nav-links, .nav-cta { display: none; }
  .nav-toggle { display: grid; }
  .nav-inner { height: 64px; width: calc(100% - 32px); }
}
@media (prefers-reduced-motion: reduce) { .nav, .nav-cta, .nav-toggle span, .nav-toggle span::before { transition: none; } }
</style>
