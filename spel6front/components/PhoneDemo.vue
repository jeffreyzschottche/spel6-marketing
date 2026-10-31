<template>
  <div ref="root" class="phone" :class="{ 'phone-small': small }">
    <div class="phone-screen">
      <div class="phone-status" aria-hidden="true">
        <span>21:30</span>
        <span class="phone-status-icons">
          <svg width="17" height="11" viewBox="0 0 17 11" fill="currentColor"><rect x="0" y="7" width="3" height="4" rx=".8" /><rect x="4.5" y="5" width="3" height="6" rx=".8" /><rect x="9" y="2.5" width="3" height="8.5" rx=".8" /><rect x="13.5" y="0" width="3" height="11" rx=".8" /></svg>
          <svg width="24" height="11" viewBox="0 0 24 11" fill="none"><rect x=".5" y=".5" width="20" height="10" rx="3" stroke="currentColor" opacity=".45" /><rect x="2" y="2" width="15" height="7" rx="1.6" fill="currentColor" /><path d="M22 3.8v3.4c.7-.3 1.2-1 1.2-1.7s-.5-1.4-1.2-1.7Z" fill="currentColor" opacity=".45" /></svg>
        </span>
      </div>
      <div class="phone-video">
        <video
          v-for="(clip, i) in clips"
          :key="clip.src"
          :ref="(el) => (videos[i] = el as HTMLVideoElement | null)"
          :class="{ current: i === index }"
          :poster="clip.poster"
          muted
          playsinline
          :preload="i === index || (eager && i === (index + 1) % clips.length) ? 'auto' : 'none'"
          :loop="looping"
          :aria-hidden="i !== index"
          :aria-label="clip.label"
          @ended="next"
          @playing="playing = i === index ? true : playing"
          @pause="playing = i === index ? false : playing"
        >
          <source :src="clip.src" type="video/mp4" />
        </video>
      </div>
      <button v-if="reduced && !playing" type="button" class="phone-play" :aria-label="`Speel demo af: ${clips[index]?.label}`" @click="play">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5.5v13l10-6.5-10-6.5Z" /></svg>
      </button>
    </div>
    <span class="phone-island" aria-hidden="true"></span>
  </div>
</template>

<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, watch } from "vue";

export interface DemoClip { src: string; poster: string; label: string }

/**
 * A phone frame playing app recordings like a GIF. With `active` it loops that clip; without it,
 * it plays the clips one after another. The clips are stacked and cross-fade, and video only
 * plays while the phone is on screen.
 */
const props = defineProps<{ clips: DemoClip[]; active?: number; small?: boolean; eager?: boolean }>();
const emit = defineEmits<{ change: [index: number] }>();

const root = ref<HTMLElement | null>(null);
const videos: (HTMLVideoElement | null)[] = [];
const index = ref(props.active ?? 0);
const visible = ref(false);
const playing = ref(false);
const reduced = ref(false);
const looping = computed(() => props.active !== undefined || props.clips.length === 1);
let observer: IntersectionObserver | undefined;

function play() {
  const video = videos[index.value];
  if (!video) return;
  if (!looping.value) video.currentTime = 0;
  video.play().catch(() => {});
}

function sync() {
  videos.forEach((video, i) => { if (video && i !== index.value) video.pause(); });
  if (visible.value && !reduced.value) play();
  else videos[index.value]?.pause();
}

function next() {
  if (looping.value) return;
  index.value = (index.value + 1) % props.clips.length;
  emit("change", index.value);
}

watch(() => props.active, (value) => {
  if (value !== undefined && value !== index.value) index.value = value;
});
watch(index, sync);

onMounted(() => {
  reduced.value = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  observer = new IntersectionObserver(([entry]) => {
    visible.value = !!entry?.isIntersecting;
    sync();
  }, { threshold: 0.35 });
  if (root.value) observer.observe(root.value);
});
onBeforeUnmount(() => observer?.disconnect());
</script>

<style scoped>
/* 844 px of recording plus a 44 px status bar, at a 390 px wide screen. */
.phone { --status: 44px; position: relative; width: min(300px, 74vw, calc((100svh - 190px) * 390 / 888)); aspect-ratio: 390 / 888; padding: 10px; border-radius: 48px; background: linear-gradient(145deg, #3a3036, #17121a 45%, #2b2329); box-shadow: 0 0 0 1px #ffffff1c inset, 0 2px 0 #ffffff12 inset, 0 40px 90px -20px #00000099, 0 18px 40px -18px #f28c8540; }
.phone-small { --status: 36px; width: min(240px, 62vw, calc((100svh - 160px) * 390 / 888)); padding: 8px; border-radius: 40px; }
.phone-screen { position: relative; display: flex; flex-direction: column; width: 100%; height: 100%; overflow: hidden; border-radius: 39px; background: #151115; }
.phone-small .phone-screen { border-radius: 32px; }
.phone-status { display: flex; justify-content: space-between; align-items: center; flex: 0 0 auto; height: calc(var(--status) * .82); padding: 6px 26px 0 30px; color: #f5eee5; font-size: 13px; font-weight: 600; letter-spacing: -.2px; }
.phone-small .phone-status { padding: 4px 20px 0 24px; font-size: 11px; }
.phone-status-icons { display: inline-flex; align-items: center; gap: 5px; }
.phone-video { position: relative; flex: 1; }
.phone-video video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: top; opacity: 0; transition: opacity .45s; }
.phone-video video.current { opacity: 1; }
.phone-island { position: absolute; top: 18px; left: 50%; width: 30%; height: 22px; transform: translateX(-50%); border-radius: 20px; background: #050405; }
.phone-small .phone-island { top: 14px; height: 18px; }
.phone-play { position: absolute; inset: 0; margin: auto; display: grid; place-items: center; width: 58px; height: 58px; border-radius: 50%; background: #f5eee5e6; color: #2c1a24; box-shadow: 0 10px 30px #0006; }
.phone-play:focus-visible { outline: 2px solid #f28c85; outline-offset: 4px; }
@media (prefers-reduced-motion: reduce) { .phone-video video { transition: none; } }
</style>
