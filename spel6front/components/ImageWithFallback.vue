<template>
  <img v-bind="attrs" :src="currentSrc" :alt="alt" loading="lazy" @error="handleError" />
</template>

<script setup lang="ts">
import { computed, ref, useAttrs, watch } from "vue";

const placeholder = "http://localhost:8000/storage/placeholder.svg";

const props = defineProps<{ src?: string; alt?: string }>();
const attrs = useAttrs();

const source = ref(props.src || placeholder);

watch(
  () => props.src,
  (value) => {
    source.value = value || placeholder;
  }
);

const currentSrc = computed(() => source.value || placeholder);
const alt = computed(() => props.alt || "Image");

function handleError() {
  source.value = placeholder;
}
</script>
