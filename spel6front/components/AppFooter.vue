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
            Het ultieme partyspel voor jou en je vrienden. Maak de gekste
            momenten en deel de beste verhalen.
          </p>
          <NuxtLink
            to="/contact"
            class="cta-animated inline-flex items-center gap-2 rounded-xl px-5 py-2 text-sm font-semibold text-white transition-transform duration-200 hover:scale-105"
          >
            Neem contact op
          </NuxtLink>
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
import { Facebook, Instagram, Twitter } from "lucide-vue-next";

const spel6Logo = useStorageAsset("storage/spel6logo.png");

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
  { label: "Twitter", href: "#", icon: Twitter },
  { label: "Facebook", href: "#", icon: Facebook },
];

const currentYear = new Date().getFullYear();
</script>
