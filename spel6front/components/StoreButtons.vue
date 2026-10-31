<template>
  <div class="stores" :class="{ 'stores-center': center }">
    <a v-for="store in stores" :key="store.name" :href="store.href" target="_blank" rel="noopener noreferrer" class="store" :aria-label="`${store.top} ${store.name}`">
      <svg v-if="store.name === 'App Store'" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16.37 12.6c-.02-2.1 1.72-3.12 1.8-3.17-.98-1.43-2.5-1.63-3.05-1.65-1.3-.13-2.53.76-3.19.76-.66 0-1.67-.74-2.75-.72-1.41.02-2.72.82-3.45 2.09-1.47 2.55-.38 6.33 1.06 8.4.7 1.01 1.53 2.15 2.62 2.11 1.05-.04 1.45-.68 2.72-.68 1.27 0 1.63.68 2.74.66 1.13-.02 1.85-1.03 2.54-2.05.8-1.17 1.13-2.3 1.15-2.36-.03-.01-2.2-.84-2.22-3.39ZM14.3 6.43c.58-.7.97-1.68.86-2.65-.83.03-1.84.55-2.44 1.25-.53.62-1 1.62-.88 2.57.93.07 1.88-.47 2.46-1.17Z" /></svg>
      <svg v-else width="20" height="22" viewBox="0 0 22 24" aria-hidden="true"><path fill="#34A853" d="M1.1.6 12.3 12 1.1 23.4c-.3-.3-.5-.8-.5-1.4V2c0-.6.2-1.1.5-1.4Z" /><path fill="#FBBC04" d="m16 15.7-3.7-3.7L16 8.3l4.4 2.5c1.3.7 1.3 1.9 0 2.6L16 15.7Z" /><path fill="#EA4335" d="M16 15.7 12.3 12 1.1 23.4c.4.4 1.1.5 1.9 0L16 15.7Z" /><path fill="#4285F4" d="M16 8.3 3 .7C2.2.2 1.5.3 1.1.6L12.3 12 16 8.3Z" /></svg>
      <span><small>{{ store.top }}</small>{{ store.name }}</span>
    </a>
  </div>
</template>

<script setup lang="ts">
defineProps<{ center?: boolean }>();

const stores = [
  { name: "App Store", top: "Download in de", href: "https://apps.apple.com/us/app/spel-6/id6755892478" },
  { name: "Google Play", top: "Ontdek het op", href: "https://play.google.com/store/apps/details?id=com.spel.zes" },
];
</script>

<style scoped>
.stores { display: flex; flex-wrap: wrap; gap: 12px; }
.stores-center { justify-content: center; }
.store { display: inline-flex; align-items: center; gap: 11px; min-height: 56px; padding: 9px 20px 9px 16px; border-radius: 14px; background: #f5eee5; color: #1a1318; font-weight: 600; font-size: 1.02rem; line-height: 1.15; box-shadow: 0 10px 30px -12px #f28c8566; transition: transform .2s, box-shadow .2s, background .2s; }
.store small { display: block; font-size: .68rem; font-weight: 500; opacity: .7; }
.store:hover { transform: translateY(-2px); background: #fff; box-shadow: 0 16px 36px -12px #f28c8599; }
.store:focus-visible { outline: 2px solid #f28c85; outline-offset: 3px; }
@media (prefers-reduced-motion: reduce) { .store { transition: none; } .store:hover { transform: none; } }
</style>
