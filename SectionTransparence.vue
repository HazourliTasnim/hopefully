<template>
  <div class="home-container">
    <!-- Section Principale -->
    <section class="hero-section">
      <div class="content">
        <header class="header-section">
          <h1>{{ $t("home.hero.title") }}</h1>
          <h2>{{ $t("home.hero.subtitle") }}</h2>
        </header>

        <div class="info-grid">
          <article class="info-card">
            <div class="card-icon">
              <font-awesome-icon :icon="['fas', 'landmark']" />
            </div>
            <h3>{{ $t("home.infoCard1.title") }}</h3>
            <p>
              {{ $t("home.infoCard1.text") }}
            </p>
          </article>

          <article class="info-card highlight">
            <div class="card-icon">
              <font-awesome-icon :icon="['fas', 'laptop-code']" />
            </div>
            <h3>{{ $t("home.infoCard2.title") }}</h3>
            <ul class="feature-list">
              <li>
                <font-awesome-icon :icon="['fas', 'caret-right']" /> 
                {{ $t("home.infoCard2.features.0") }}
              </li>
              <li>
                <font-awesome-icon :icon="['fas', 'caret-right']" /> 
                {{ $t("home.infoCard2.features.1") }}
              </li>
              <li>
                <font-awesome-icon :icon="['fas', 'caret-right']" /> 
                {{ $t("home.infoCard2.features.2") }}
              </li>
            </ul>
          </article>

          <article class="info-card legal-notice">
            <div class="card-icon">
              <font-awesome-icon :icon="['fas', 'balance-scale']" />
            </div>
            <h3>{{ $t("home.infoCard3.title") }}</h3>
            <p>
              {{ $t("home.infoCard3.text") }}
            </p>
          </article>
        </div>

        <router-link to="/offres" class="cta-button">
          {{ $t("home.cta") }}
          <font-awesome-icon :icon="['fas', 'arrow-right']" class="arrow" />
        </router-link>
      </div>
    </section>
  <h2>Portail National des Appels d’Offres</h2>
  <p class="portal-lead">
    Un espace structuré et centralisé dédié à la modernisation de la passation des marchés publics.
  </p>
<section class="portal-section">
  <div class="portal-content">
    <div class="portal-text">
     
<div class="visual-zigzag">
  <div 
    v-for="(stack, index) in data"
    :key="index"
    :class="['stack-card-zigzag', index % 2 === 0 ? 'left' : 'right']"
  >
    <div class="stack-context">{{ stack.label }}</div>
    <div class="stack-body">{{ stack.value }}</div>
  </div>
</div>

<<div class="visual-stack">
  <div class="stack-card">
    <div class="stack-context">
      <i class="fas fa-bullhorn"></i> Publication
    </div>
    <div class="stack-body">
      Mise en ligne des appels d’offres avec toutes les informations nécessaires.
    </div>
  </div>

  <div class="stack-card">
    <div class="stack-context">
      <i class="fas fa-search"></i> Consultation
    </div>
    <div class="stack-body">
      Accès aux détails des appels d’offres disponibles pour les soumissionnaires.
    </div>
  </div>

  <div class="stack-card">
    <div class="stack-context">
      <i class="fas fa-file-signature"></i> Soumission
    </div>
    <div class="stack-body">
      Dépôt sécurisé des offres et des pièces justificatives.
    </div>
  </div>

  <div class="stack-card">
    <div class="stack-context">
      <i class="fas fa-tasks"></i> Suivi
    </div>
    <div class="stack-body">
      Suivi de l’état de traitement des dossiers et résultats des consultations.
    </div>
  </div>
</div>
</div>
</div>
</section>



    <!-- Section Partenaires -->
    <section class="partners-section">
      <div class="content">
        <h2>{{ $t("home.partners.title") }}</h2>
        <div class="logos-container">
          <div 
            v-for="(logo, index) in logos" 
            :key="index" 
            class="logo-item"
            @mouseover="hoverLogo(index)"
            @mouseleave="unhoverLogo(index)"
          >
            <img 
              :src="logo.src" 
              :alt="logo.alt" 
              :class="['logo-image', { 'hovered': logo.hover }]"
            >
          </div>
        </div>
      </div>
    </section>
  </div>
</template>


<style >

.home-container {
  background: #f8faff;
  min-height: 100vh;
  font-family: 'Inter', system-ui, sans-serif;
}

.hero-section {
  padding: 4rem 2rem;
  background: linear-gradient(160deg, #ffffff 0%, #f3f6ff 100%);
}

.header-section {
  text-align: center;
  max-width: 800px;
  margin: 0 auto 4rem;
}

h1 {
  font-size: 2.8rem;
  color: #1a237e;
  line-height: 1.2;
  margin-bottom: 1.5rem;

}

h2 {
  font-size: 2rem;
  color: #3f51b5;
  font-weight: 600;
  margin-bottom: 3rem;
}

.info-grid {
  display: grid;
  gap: 2rem;
  margin: 4rem auto;
  max-width: 1200px;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
}

.info-card {
  position: relative;
  overflow: hidden;
  padding: 2.5rem;
  border-radius: 15px;
  background: rgba(31, 70, 144, 0.08);
  display: flex;
  flex-direction: column;
  transition: all 0.3s ease;
  min-height: 280px;
}

.info-card::before {
  content: "";
  height: 100px;
  width: 100px;
  position: absolute;
  top: -40%;
  left: -20%;
  border-radius: 50%;
  border: 35px solid rgba(255, 255, 255, 0.15);
  transition: all 0.8s ease;
  filter: blur(.5rem);
}

.info-card:hover::before {
  width: 140px;
  height: 140px;
  top: -30%;
  left: 50%;
  filter: blur(0);
  border-color: rgba(255, 255, 255, 0.25);
}

.info-card:hover {
  transform: translateY(-5px);
  background: rgba(31, 70, 144, 0.12);
}

.card-icon {
  font-size: 2.5rem;
  color: #1a237e;
  margin-bottom: 1.5rem;
  z-index: 2;
  position: relative;
}

.info-card h3 {
  color: #1a237e;
  font-size: 1.4em;
  margin-bottom: 1rem;
  position: relative;
  z-index: 2;
}

.info-card p {
  color: #2c387e;
  font-size: 0.95em;
  line-height: 1.6;
  position: relative;
  z-index: 2;
}

/* Highlight Card Variation */
.info-card.highlight {
  background: rgba(16, 108, 142, 0.1);
}

.info-card.highlight::before {
  border-color: rgba(152, 216, 244, 0.2);
}

.info-card.highlight:hover {
  background: rgba(16, 108, 142, 0.15);
}

/* Legal Notice Variation */
.info-card.legal-notice {
  background: rgba(13, 71, 46, 0.08);
}

.info-card.legal-notice::before {
  border-color: rgba(152, 244, 185, 0.15);
}

.info-card.legal-notice:hover {
  background: rgba(13, 71, 46, 0.12);
}

.feature-list {
  list-style: none;
  padding: 0;
  margin: 1rem 0;
  position: relative;
  z-index: 2;
}

.feature-list li {
  color: #2c387e;
  font-size: 0.9em;
  margin-bottom: 0.8rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.feature-list li svg {
  color: #1a237e;
  width: 0.8em;
}
.cta-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: #1a237e;
  color: #fff;
  padding: 0.75rem 2rem;
  border-radius: 50px;
  font-size: 1.1rem;
  text-decoration: none;
  transition: background 0.3s ease, transform 0.2s ease;
  margin: 0 auto;
}
.cta-button:hover {
  background: #151a56;
  transform: translateY(-2px);
}
.cta-button .arrow {
  margin-left: 0.5rem;
}
.portal-section {
  background: #f4f7fa;
  padding: 4rem 2rem;
  font-family: 'Segoe UI', sans-serif;
}

/* === LAYOUT CONTENU === */
.portal-content {
  display: flex;
  flex-wrap: wrap;
  align-items: flex-start;
  justify-content: space-between;
  gap: 3rem;
}


@media (max-width: 768px) {
  .reverse-layout {
    flex-direction: column;
  }
}

/* === BLOC TEXTE === */
.portal-text {
  flex: 1 1 500px;
  text-align: center; /* Centre le contenu texte */
}

.portal-title {
  font-size: 1.5rem;              
  color: rgb(29, 56, 146); /* Couleur souhaitée */
  font-weight: 700;
  margin: 0 auto 1rem auto; /* Centre le bloc du titre */
  text-align: center;       /* Centre le texte du titre */
  font-family: 'Merriweather', serif;
  letter-spacing: 0.5px;
}


.portal-lead {
  font-size: 1.15rem;
  color: black;                   /* Texte en noir */
  margin-bottom: 2rem;
  line-height: 1.6;
}

/* === STACK DE CARTES – ULTRA STYLÉ === */
:root {
  --card-border: #243375;
  --card-text: #151a56;
  --card-sub: #c28920;
  --card-glow: rgba(36, 51, 117, 0.3);
  --card-bg: linear-gradient(135deg, #f9fafe, #edf1fc);
}

.visual-stack {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  margin-top: 2rem;
  justify-content: space-between;
  font-family: 'Inter', sans-serif;
}

.stack-card {
  background: var(--card-bg);
  border-left: 6px solid var(--card-border);
  padding: 1.2rem 1.5rem;
  width: 200px;
  border-radius: 1.25rem;
  box-shadow: 0 8px 24px var(--card-glow);
  transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.5s ease;
  position: relative;
  overflow: hidden;
  opacity: 0;
  animation: fadeIn 0.6s ease-in forwards;
  animation-delay: 0.2s;
}

.stack-card::before {
  content: "";
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle at center, rgba(255, 255, 255, 0.25), transparent 60%);
  transform: rotate(25deg);
  pointer-events: none;
  transition: opacity 0.4s;
  opacity: 0;
}

.stack-card:hover::before {
  opacity: 1;
}

.stack-card:hover {
  transform: scale(1.03);
  box-shadow: 0 12px 30px rgba(36, 51, 117, 0.2);
  background: linear-gradient(135deg, #f3f6ff, #e3e8f8);
}

.stack-context {
  color: var(--card-sub);
  font-weight: 600;
  font-size: 0.95rem;
  letter-spacing: 0.5px;
  margin-bottom: 0.4rem;
}

.stack-body {
  color: var(--card-text);
  font-size: 1.05rem;
  font-weight: 500;
  line-height: 1.4;
}

/* Entry Animation */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 768px) {
  .stack-card {
    width: 100%;
  }
}

/* === IMAGE === */
.portal-image img {
  max-width: 450px;
  width: 100%;
  border-radius: 1rem;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
  position: relative;
  top: 10px; /* Décale l'image vers le bas */
}



/* Section Partenaires */
.partners-section {
  padding: 5rem 2rem;
  background: #f9fafe;
}

.logos-container {
  display: grid;
  grid-template-columns: repeat(8, 1fr);
  gap: 3rem;
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem;
}

.logo-item {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100px;
  padding: 1.5rem;
  background: white;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.logo-image {
  max-width: 100%;
  max-height: 90px; /* Augmentez cette valeur pour rendre l'image plus grande */
  filter: grayscale(100%);
  opacity: 0.7;
  transition: all 0.3s ease;
  object-fit: contain; /* Assure que l'image garde ses proportions */
}


.logo-image.hovered {
  filter: grayscale(0%);
  opacity: 1;
  transform: scale(1.1);
}


.reverse-layout {
  flex-direction: row-reverse; /* image left, content right */
}

@media (max-width: 768px) {
  .reverse-layout {
    flex-direction: column;
  }
}

.portal-image img {
  max-width: 450px;
  width: 100%;
  border-radius: 1rem;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Subtle pulse animation */
@keyframes pulsePoint {
  0% { transform: scale(1); opacity: 1; }
  50% { transform: scale(1.3); opacity: 0.7; }
  100% { transform: scale(1); opacity: 1; }
}



@media (max-width: 768px) {
  .grid-container {
    grid-template-columns: 1fr;
  }
  
  .logos-container {
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  }
  
  h1 {
    font-size: 2rem;
  }
  
  h2 {
    font-size: 1.5rem;
  }
}
</style>

<script>
import "@fortawesome/fontawesome-free/css/all.css";
export default {
  data() {
    return {
      logos: [
      { src: new URL('@/assets/logo-gta.png', import.meta.url).href, alt: 'GTA' },
  { src: new URL('@/assets/logo-at.png', import.meta.url).href, alt: 'Algérie Télécom' },
  { src: new URL('@/assets/logo-poste.png', import.meta.url).href, alt: 'Algérie Poste' },
  { src: new URL('@/assets/logo-mobilis.png', import.meta.url).href, alt: 'Mobilis' },
  { src: new URL('@/assets/logo-comintal.png', import.meta.url).href, alt: 'Comintal' },
  { src: new URL('@/assets/logo-saticom.png', import.meta.url).href, alt: 'Saticom' },
  { src: new URL('@/assets/logo-inttic.png', import.meta.url).href, alt: 'INTTIC' },
  { src: new URL('@/assets/logo-numirisation.png', import.meta.url).href, alt: 'Numérisation' },
  { src: new URL('@/assets/logo-anf.png', import.meta.url).href, alt: 'ANF' },
  { src: new URL('@/assets/logo-ats.png', import.meta.url).href, alt: 'ATS' },
  { src: new URL('@/assets/logo-natp.png', import.meta.url).href, alt: 'NATP' },
  { src: new URL('@/assets/logo-inptic.png', import.meta.url).href, alt: 'INPTIC' },
  { src: new URL('@/assets/logo-eci-tic.png', import.meta.url).href, alt: 'ECI-TIC' },
  { src: new URL('@/assets/logo-wb.png', import.meta.url).href, alt: 'WB' },
  { src: new URL('@/assets/logo-netbeopen.png', import.meta.url).href, alt: 'NetBeOpen' },
  { src: new URL('@/assets/logo-ems.png', import.meta.url).href, alt: 'EMS' }
      ].map(logo => ({ ...logo, hover: false }))
    }
  },
  methods: {
    hoverLogo(index) {
      this.logos[index].hover = true
    },
    unhoverLogo(index) {
      this.logos[index].hover = false
    }
  }
}
</script>