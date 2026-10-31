<template>
  <footer class="footer">
    <div class="footer-inner">
      <div class="footer-brand">
        <span class="wordmark" aria-hidden="true"></span>
        <p>Het partyspel voor aan tafel. Voor vrienden, dates, feestjes en collega's.</p>
        <StoreButtons />
      </div>
      <nav class="footer-cols" aria-label="Footer">
        <div>
          <h2>Spel6</h2>
          <NuxtLink to="/#zo-werkt-het">Zo werkt het</NuxtLink>
          <NuxtLink to="/#spelvormen">Spelvormen</NuxtLink>
          <NuxtLink to="/#probeer">Probeer een kaart</NuxtLink>
          <NuxtLink to="/guide">Handleiding</NuxtLink>
        </div>
        <div>
          <h2>Hulp</h2>
          <NuxtLink to="/faq">Veelgestelde vragen</NuxtLink>
          <NuxtLink to="/contact">Contact</NuxtLink>
        </div>
        <div>
          <h2>Juridisch</h2>
          <NuxtLink to="/privacy">Privacyverklaring</NuxtLink>
          <NuxtLink to="/terms">Algemene voorwaarden</NuxtLink>
        </div>
      </nav>
    </div>
    <p class="footer-bottom">© {{ year }} Spel6 · Speel met respect voor elkaars grenzen.</p>
  </footer>
</template>

<script setup lang="ts">
const year = new Date().getFullYear();
</script>

<style scoped>
.footer { border-top: 1px solid #ffffff10; background: #120e12; }
.footer-inner { display: grid; grid-template-columns: 1.2fr 1fr; gap: 48px; width: min(1180px, calc(100% - 40px)); margin: 0 auto; padding: 64px 0 40px; }
.footer-brand .wordmark { width: 140px; }
.footer-brand p { max-width: 340px; margin: 18px 0 24px; color: #b3a29a; font-size: .95rem; line-height: 1.6; }
.footer-cols { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.footer-cols h2 { margin-bottom: 14px; color: #f5eee5; font-size: .8rem; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; }
.footer-cols a { display: block; padding: 6px 0; color: #b3a29a; font-size: .92rem; transition: color .2s; }
.footer-cols a:hover { color: #fff3e6; }
.footer-cols a:focus-visible { outline: 2px solid #f28c85; outline-offset: 2px; border-radius: 4px; }
.footer-bottom { width: min(1180px, calc(100% - 40px)); margin: 0 auto; padding: 22px 0 34px; border-top: 1px solid #ffffff0d; color: #8c7b74; font-size: .82rem; }
@media (max-width: 820px) {
  .footer-inner { grid-template-columns: 1fr; gap: 40px; width: calc(100% - 32px); padding-top: 48px; }
  .footer-cols { grid-template-columns: repeat(2, 1fr); }
  .footer-bottom { width: calc(100% - 32px); }
}
</style>
