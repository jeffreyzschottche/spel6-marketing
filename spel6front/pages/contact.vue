<template>
  <div class="min-h-screen bg-[#0a0a0a]">
    <AppNavbar />
    <main class="mx-auto max-w-6xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
      <header class="mb-16 text-center">
        <h1 class="mb-4 text-4xl font-semibold text-white md:text-5xl">Neem contact op</h1>
        <p class="mx-auto max-w-2xl text-xl text-gray-300">
          Heb je vragen, suggesties of feedback? We staan altijd open voor een gesprek!
        </p>
      </header>

      <div class="grid gap-12 lg:grid-cols-2">
        <section>
          <h2 class="mb-8 text-2xl font-semibold text-white">Contactgegevens</h2>
          <div class="space-y-6">
            <article class="flex gap-4 rounded-2xl border border-white/10 bg-white/5 p-6">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-[var(--vibe-blue-light)]/20">
                <Mail class="h-5 w-5 text-[var(--vibe-blue-light)]" />
              </div>
              <div>
                <h3 class="text-lg font-semibold text-white">Email</h3>
                <a href="mailto:info@spel6.nl" class="text-sm text-gray-400 transition hover:text-white">info@spel6.nl</a>
                <p class="text-xs text-gray-500">We reageren binnen 24 uur</p>
              </div>
            </article>
            <article class="flex gap-4 rounded-2xl border border-white/10 bg-white/5 p-6">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-[var(--vibe-green-light)]/20">
                <Phone class="h-5 w-5 text-[var(--vibe-green-light)]" />
              </div>
              <div>
                <h3 class="text-lg font-semibold text-white">Telefoon</h3>
                <a href="tel:+31612345678" class="text-sm text-gray-400 transition hover:text-white">+31 6 12 34 56 78</a>
                <p class="text-xs text-gray-500">Ma - Vr, 9:00 - 18:00</p>
              </div>
            </article>
            <article class="flex gap-4 rounded-2xl border border-white/10 bg-white/5 p-6">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-[var(--vibe-yellow-light)]/20">
                <MapPin class="h-5 w-5 text-[var(--vibe-yellow-light)]" />
              </div>
              <div>
                <h3 class="text-lg font-semibold text-white">Locatie</h3>
                <p class="text-sm text-gray-400">Amsterdam</p>
                <p class="text-sm text-gray-400">Nederland</p>
              </div>
            </article>
          </div>
          <div class="mt-12 rounded-2xl border border-white/10 bg-gradient-to-br from-[var(--vibe-blue-light)]/10 to-[var(--vibe-red-light)]/10 p-6">
            <h3 class="text-lg font-semibold text-white">Veelgestelde vragen?</h3>
            <p class="mt-2 text-sm text-gray-400">Bekijk eerst onze FAQ pagina, wellicht staat je vraag daar al beantwoord.</p>
            <NuxtLink class="mt-4 inline-block rounded-lg bg-white/10 px-6 py-2 text-sm text-white transition hover:bg-white/20" to="/faq">
              Naar FAQ
            </NuxtLink>
          </div>
        </section>

        <section>
          <h2 class="mb-8 text-2xl font-semibold text-white">Stuur ons een bericht</h2>
          <form class="space-y-6">
            <div>
              <label class="mb-2 block text-sm font-medium text-white" for="name">Naam</label>
              <input
                id="name"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-gray-500"
                placeholder="Je naam"
                type="text"
              />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-white" for="email">Email</label>
              <input
                id="email"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-gray-500"
                placeholder="je@email.nl"
                type="email"
              />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-white" for="subject">Onderwerp</label>
              <input
                id="subject"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-gray-500"
                placeholder="Waar gaat je bericht over?"
                type="text"
              />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-white" for="message">Bericht</label>
              <textarea
                id="message"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-gray-500"
                placeholder="Je bericht..."
                rows="6"
              ></textarea>
            </div>
            <button
              type="button"
              class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-[var(--vibe-green-light)] to-[var(--vibe-blue-light)] px-6 py-3 text-sm font-semibold text-white transition hover:opacity-90"
            >
              <Send class="h-5 w-5" />
              Verstuur bericht
            </button>
          </form>
        </section>
      </div>
    </main>
    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { Mail, MapPin, Phone, Send } from "lucide-vue-next";
</script>
