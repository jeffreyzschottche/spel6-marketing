<template>
  <nav
    :class="[
      'fixed inset-x-0 top-0 z-50 border-b transition-all duration-300',
      isScrolled ? 'bg-black/80 border-white/10 backdrop-blur-lg' : 'border-transparent bg-transparent'
    ]"
  >
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
      <NuxtLink to="/" class="flex items-center gap-3">
        <div class="logo-pulse p-1 sm:p-1.5">
          <img :src="spel6Logo" alt="SPEL6" class="h-12 w-auto sm:h-14 lg:h-16" />
        </div>
      </NuxtLink>

      <div class="hidden items-center gap-8 md:flex">
        <template v-for="link in navLinks" :key="link.path">
          <span
            v-if="link.disabled"
            class="text-sm font-medium text-gray-600/70 cursor-not-allowed"
          >
            {{ link.name }}
          </span>
          <NuxtLink
            v-else
            :to="link.path"
            class="relative text-sm font-medium transition-colors"
            :class="isActive(link.path) ? 'text-white' : 'text-gray-400 hover:text-white'"
          >
            {{ link.name }}
            <div
              v-if="isActive(link.path)"
              class="animated-gradient absolute -bottom-1 left-0 right-0 h-0.5 rounded-full"
            />
          </NuxtLink>
        </template>
      </div>

      <button
        class="rounded-full p-2 text-white transition hover:bg-white/10 md:hidden"
        type="button"
        @click="toggleMobileMenu"
      >
        <component :is="isMobileMenuOpen ? X : Menu" class="h-6 w-6" />
      </button>
    </div>

    <div
      v-if="isMobileMenuOpen"
      class="border-t border-white/10 bg-black/95 px-4 py-6 text-base text-gray-200 md:hidden"
    >
      <template v-for="link in navLinks" :key="`mobile-${link.path}`">
        <span
          v-if="link.disabled"
          class="block py-2 text-gray-600/70 cursor-not-allowed"
        >
          {{ link.name }}
        </span>
        <NuxtLink
          v-else
          :to="link.path"
          class="block py-2"
          :class="isActive(link.path) ? 'text-white' : 'hover:text-white'"
          @click="closeMobileMenu"
        >
          {{ link.name }}
        </NuxtLink>
      </template>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { Menu, X } from "lucide-vue-next";
import { onBeforeUnmount, onMounted, ref, watch } from "vue";
import { useRoute } from "#imports";

const spel6Logo = useStorageAsset("storage/spel6logo.png");
const navLinks = [
  { name: "Home", path: "/" },
  { name: "Shop", path: "/shop", disabled: true },
  { name: "Guide", path: "/guide" },
  { name: "FAQ", path: "/faq" },
  { name: "Contact", path: "/contact" },
];

const route = useRoute();
const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const handleScroll = () => {
  if (!import.meta.client) return;
  isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
  if (!import.meta.client) return;
  window.addEventListener("scroll", handleScroll);
  handleScroll();
});

onBeforeUnmount(() => {
  if (!import.meta.client) return;
  window.removeEventListener("scroll", handleScroll);
});

function isActive(path: string) {
  return route.path === path;
}

function toggleMobileMenu() {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
}

function closeMobileMenu() {
  isMobileMenuOpen.value = false;
}

watch(
  () => route.fullPath,
  () => {
    isMobileMenuOpen.value = false;
  }
);
</script>
