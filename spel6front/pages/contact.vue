<template>
  <div class="min-h-screen bg-[#0a0a0a]">
    <AppNavbar />
    <main class="mx-auto max-w-6xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
      <header class="mb-16 text-center">
        <h1 class="mb-4 text-4xl font-semibold text-white md:text-5xl">
          Neem contact op
        </h1>
        <p class="mx-auto max-w-2xl text-xl text-gray-300">
          Heb je vragen, suggesties of feedback? We staan altijd open voor een
          gesprek!
        </p>
      </header>

      <div class="grid gap-12 lg:grid-cols-2">
        <section>
          <h2 class="mb-8 text-2xl font-semibold text-white">
            Contactgegevens
          </h2>
          <div class="space-y-6">
            <article
              class="flex gap-4 rounded-2xl border border-white/10 bg-white/5 p-6"
            >
              <div
                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-[var(--vibe-blue-light)]/20"
              >
                <Mail class="h-5 w-5 text-[var(--vibe-blue-light)]" />
              </div>
              <div>
                <h3 class="text-lg font-semibold text-white">Email</h3>
                <a
                  href="mailto:info@spel6.nl"
                  class="text-sm text-gray-400 transition hover:text-white"
                  >info@spel6.nl</a
                >
                <p class="text-xs text-gray-500">
                  Je krijgt een bevestiging als we je mail gelezen hebben.
                </p>
              </div>
            </article>
            <article
              class="flex gap-4 rounded-2xl border border-white/10 bg-white/5 p-6"
            >
              <div
                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-[var(--vibe-yellow-light)]/20"
              >
                <MapPin class="h-5 w-5 text-[var(--vibe-yellow-light)]" />
              </div>
              <div>
                <h3 class="text-lg font-semibold text-white">Locatie</h3>
                <p class="text-sm text-gray-400">Amsterdam</p>
                <p class="text-sm text-gray-400">Nederland</p>
              </div>
            </article>
          </div>
          <div
            class="mt-12 rounded-2xl border border-white/10 bg-gradient-to-br from-[var(--vibe-blue-light)]/10 to-[var(--vibe-red-light)]/10 p-6"
          >
            <h3 class="text-lg font-semibold text-white">
              Veelgestelde vragen?
            </h3>
            <p class="mt-2 text-sm text-gray-400">
              Bekijk eerst onze FAQ pagina, wellicht staat je vraag daar al
              beantwoord.
            </p>
            <NuxtLink
              class="cta-animated mt-4 inline-flex items-center justify-center rounded-lg px-6 py-2 text-sm text-white transition-transform duration-200 hover:scale-105"
              to="/faq"
            >
              Naar FAQ
            </NuxtLink>
          </div>
        </section>

        <section>
          <h2 class="mb-8 text-2xl font-semibold text-white">
            Stuur ons een bericht
          </h2>
          <form class="space-y-6" @submit.prevent="submitForm">
            <div>
              <label
                class="mb-2 block text-sm font-medium text-white"
                for="name"
                >Naam</label
              >
              <input
                id="name"
                v-model="form.name"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-gray-500"
                :class="{ 'border-red-500/60': fieldErrors?.name }"
                placeholder="Je naam"
                type="text"
                required
              />
              <p v-if="fieldErrors?.name" class="mt-2 text-xs text-red-400">
                {{ fieldErrors.name[0] }}
              </p>
            </div>
            <div>
              <label
                class="mb-2 block text-sm font-medium text-white"
                for="email"
                >Email</label
              >
              <input
                id="email"
                v-model="form.email"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-gray-500"
                :class="{ 'border-red-500/60': fieldErrors?.email }"
                placeholder="je@email.nl"
                type="email"
                required
              />
              <p v-if="fieldErrors?.email" class="mt-2 text-xs text-red-400">
                {{ fieldErrors.email[0] }}
              </p>
            </div>
            <div>
              <label
                class="mb-2 block text-sm font-medium text-white"
                for="subject"
                >Onderwerp</label
              >
              <input
                id="subject"
                v-model="form.subject"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-gray-500"
                :class="{ 'border-red-500/60': fieldErrors?.subject }"
                placeholder="Waar gaat je bericht over?"
                type="text"
                required
              />
              <p v-if="fieldErrors?.subject" class="mt-2 text-xs text-red-400">
                {{ fieldErrors.subject[0] }}
              </p>
            </div>
            <div>
              <label
                class="mb-2 block text-sm font-medium text-white"
                for="message"
                >Bericht</label
              >
              <textarea
                id="message"
                v-model="form.message"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-gray-500"
                :class="{ 'border-red-500/60': fieldErrors?.message }"
                placeholder="Je bericht..."
                rows="6"
                required
              ></textarea>
              <p v-if="fieldErrors?.message" class="mt-2 text-xs text-red-400">
                {{ fieldErrors.message[0] }}
              </p>
            </div>
            <div class="space-y-3">
              <label
                class="flex items-start gap-3 rounded-2xl border border-white/10 bg-white/5 p-4"
              >
                <input
                  v-model="hasConfirmedHuman"
                  class="mt-1 h-5 w-5 flex-shrink-0 cursor-pointer rounded border-white/40 bg-black/40 text-[var(--vibe-green-light)] focus:ring-[var(--vibe-green-light)]"
                  type="checkbox"
                />
                <div>
                  <p class="text-base font-semibold text-white">
                    Ik ben geen robot
                  </p>
                  <p class="text-xs text-gray-400">
                    Bevestig dit voordat je het formulier verstuurt.
                  </p>
                  <p v-if="humanError" class="mt-2 text-xs text-red-400">
                    {{ humanError }}
                  </p>
                </div>
              </label>
              <button
                type="submit"
                :disabled="isSubmitting || !hasConfirmedHuman"
                class="cta-animated flex w-full items-center justify-center gap-2 rounded-2xl px-6 py-3 text-sm font-semibold text-white transition-transform duration-200 hover:scale-105 disabled:cursor-not-allowed disabled:opacity-60 disabled:hover:scale-100"
              >
                <Send class="h-5 w-5" />
                <span>{{
                  isSubmitting ? "Versturen..." : "Verstuur bericht"
                }}</span>
              </button>
              <p v-if="successMessage" class="text-sm text-green-400">
                {{ successMessage }}
              </p>
              <p v-if="errorMessage" class="text-sm text-red-400">
                {{ errorMessage }}
              </p>
            </div>
          </form>
        </section>
      </div>
    </main>
    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { reactive, ref, watch } from "vue";
import { Mail, MapPin, Send } from "lucide-vue-next";
import { apiFetch } from "~/services/apiFetch";
import { ApiError } from "~/services/ApiError";

const form = reactive({
  name: "",
  email: "",
  subject: "",
  message: "",
});

const isSubmitting = ref(false);
const successMessage = ref("");
const errorMessage = ref("");
const fieldErrors = ref<Record<string, string[]> | null>(null);
const hasConfirmedHuman = ref(false);
const humanError = ref("");

const resetFeedback = () => {
  successMessage.value = "";
  errorMessage.value = "";
  fieldErrors.value = null;
};

watch(hasConfirmedHuman, (value) => {
  if (value) {
    humanError.value = "";
  }
});

const submitForm = async () => {
  resetFeedback();

  if (!hasConfirmedHuman.value) {
    humanError.value = "Bevestig dat je geen robot bent voordat je verstuurt.";
    return;
  }
  isSubmitting.value = true;

  try {
    await apiFetch("/contact", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(form),
    });

    successMessage.value =
      "Bedankt! We nemen zo snel mogelijk contact met je op.";
    form.name = "";
    form.email = "";
    form.subject = "";
    form.message = "";
    hasConfirmedHuman.value = false;
  } catch (err) {
    if (err instanceof ApiError) {
      const validationErrors = err.data?.errors;
      if (validationErrors) {
        fieldErrors.value = validationErrors;
        errorMessage.value = "Controleer de invoer en probeer het opnieuw.";
      } else {
        errorMessage.value =
          err.data?.message ??
          "Er is iets misgegaan bij het versturen. Probeer het later nog eens.";
      }
    } else {
      errorMessage.value =
        "Er is iets misgegaan bij het versturen. Probeer het later nog eens.";
    }
  } finally {
    isSubmitting.value = false;
  }
};
</script>
