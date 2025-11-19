<template>
  <footer class="border-t border-white/10 bg-black text-gray-400">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
      <div class="mb-8 grid grid-cols-1 gap-8 md:grid-cols-4">
        <div class="flex flex-col items-start gap-4 md:col-span-2">
          <div class="logo-pulse -mb-2 sm:-mb-3">
            <img
              :src="spel6Logo"
              alt="SPEL6"
              class="h-16 w-auto sm:h-20 lg:h-24"
            />
          </div>
          <p class="max-w-lg text-sm text-gray-300">
            Het ultieme (party)spel voor elk moment. Leer mensen beter kennen,
            doe leuke opdrachten en beantwoord uitdagende vragen.
          </p>
          <div class="flex flex-wrap gap-3">
            <a
              v-for="store in footerStores"
              :key="store.label"
              :href="store.href"
              class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-black transition hover:scale-105 hover:bg-gray-100"
            >
              <img :src="store.iconSrc" :alt="store.label" class="h-5 w-auto" />
              <span>{{ store.label }}</span>
            </a>
          </div>
        </div>

        <div>
          <h3 class="text-white">Links</h3>
          <ul class="mt-4 space-y-2 text-sm">
            <li v-for="link in quickLinks" :key="link.label">
              <span
                v-if="link.disabled"
                class="text-gray-600/70 cursor-not-allowed"
              >
                {{ link.label }}
              </span>
              <NuxtLink
                v-else
                :to="link.path"
                class="transition hover:text-white"
              >
                {{ link.label }}
              </NuxtLink>
            </li>
          </ul>
        </div>

        <div>
          <h3 class="text-white">Legal</h3>
          <ul class="mt-4 space-y-2 text-sm">
            <li v-for="link in legalLinks" :key="link.label">
              <NuxtLink
                v-if="link.path"
                :to="link.path"
                class="transition hover:text-white"
              >
                {{ link.label }}
              </NuxtLink>
              <a v-else :href="link.href" class="transition hover:text-white">{{
                link.label
              }}</a>
            </li>
          </ul>
        </div>
      </div>

      <div
        class="flex flex-col items-center gap-4 border-t border-white/10 pt-8 text-sm md:flex-row md:justify-between"
      >
        <p>© {{ currentYear }} SPEL6. Alle rechten voorbehouden.</p>
        <div class="flex gap-4">
          <a
            v-for="social in socialLinks"
            :key="social.label"
            :href="social.href"
            class="transition hover:text-white"
            :aria-label="social.label"
          >
            <component :is="social.icon" class="h-5 w-5" />
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import { defineComponent, h } from "vue";
import { Instagram } from "lucide-vue-next";

const spel6Logo = useStorageAsset("storage/spel6logo.png");
const appStoreBadge = useStorageAsset("storage/appstore.png");
const playStoreBadge = useStorageAsset("storage/playstore.png");

const XIcon = defineComponent({
  name: "XIcon",
  setup() {
    return () =>
      h(
        "svg",
        {
          viewBox: "0 0 1200 1227",
          fill: "currentColor",
          class: "h-5 w-5",
          xmlns: "http://www.w3.org/2000/svg",
        },
        [
          h("path", {
            d: "M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z",
          }),
        ]
      );
  },
});

const TikTokIcon = defineComponent({
  name: "TikTokIcon",
  setup() {
    return () =>
      h(
        "svg",
        {
          viewBox: "0 0 32 32",
          fill: "currentColor",
          class: "h-5 w-5",
          xmlns: "http://www.w3.org/2000/svg",
        },
        [
          h("path", {
            d: "M16.656 1.029c1.637-.025 3.262-.012 4.886-.025.054 2.031.878 3.859 2.189 5.213 1.411 1.271 3.247 2.095 5.271 2.235v5.036c-1.912-.048-3.71-.489-5.331-1.247-.784-.377-1.447-.764-2.077-1.196-.012 3.649.012 7.298-.025 10.934-.103 1.853-.719 3.543-1.707 4.954-1.652 2.366-4.328 3.919-7.371 4.011-.123.006-.268.009-.414.009-1.73 0-3.347-.482-4.725-1.319-2.508-1.509-4.238-4.091-4.558-7.094-.025-.625-.037-1.25-.012-1.862.49-4.779 4.494-8.476 9.361-8.476.547 0 1.083.047 1.604.136.025 1.849-.05 3.699-.05 5.548-.423-.153-.911-.242-1.42-.242-1.868 0-3.457 1.194-4.045 2.861-.133.427-.21.918-.21 1.426 0 .206.013.41.037.61.332 2.046 2.086 3.59 4.201 3.59.061 0 .121-.001.181-.004 1.463-.044 2.733-.831 3.451-1.994.267-.372.45-.822.511-1.311.125-2.237.075-4.461.087-6.698.012-5.036-.012-10.06.025-15.083z",
          }),
        ]
      );
  },
});

const quickLinks = [
  { label: "Shop", path: "/shop", disabled: true },
  { label: "Guide", path: "/guide" },
  { label: "FAQ", path: "/faq" },
  { label: "Contact", path: "/contact" },
];

const legalLinks = [
  { label: "Privacy Statement", path: "/privacy" },
  { label: "Algemene Voorwaarden", href: "/terms" },
];

const socialLinks = [
  { label: "Instagram", href: "#", icon: Instagram },
  { label: "X", href: "#", icon: XIcon },
  { label: "TikTok", href: "#", icon: TikTokIcon },
];

const footerStores = [
  { label: "App Store", iconSrc: appStoreBadge, href: "#" },
  { label: "Play Store", iconSrc: playStoreBadge, href: "#" },
];

const currentYear = new Date().getFullYear();
</script>
