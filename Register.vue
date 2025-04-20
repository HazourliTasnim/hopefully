<template>
  <section class="form-container">
    <form id="msform" @submit.prevent="submitForm">
      <ul id="progressbar">
        <li :class="{ active: step === 1 }">{{ $t("registration.steps.accountInfo") }}</li>
        <li :class="{ active: step === 2 }">{{ $t("registration.steps.repContact") }}</li>
        <li :class="{ active: step === 3 }">{{ $t("registration.steps.companyInfo") }}</li>
      </ul>
      
<transition name="transitionName" mode="out-in">
  <fieldset v-if="step === 1">
    <h2 class="fs-title">{{ $t("registration.accountInfo.title") }}</h2>

    <input
      type="email"
      v-model="email"
      required
      :placeholder="$t('registration.accountInfo.emailPlaceholder')"
    />

    <div class="password-container">
      <input
        :type="showPassword1 ? 'text' : 'password'"
        v-model="password"
        required
        :placeholder="$t('registration.accountInfo.passwordPlaceholder')"
      />
      <span class="eye-pass" @click="togglePassword(1)">
        <i :class="showPassword1 ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash'"></i>
      </span>
    </div>

    <div class="password-container">
      <input
        :type="showPassword2 ? 'text' : 'password'"
        v-model="password2"
        required
        :placeholder="$t('registration.accountInfo.confirmPasswordPlaceholder')"
      />
      <span class="eye-pass" @click="togglePassword(2)">
        <i :class="showPassword2 ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash'"></i>
      </span>
    </div>

    <button type="button" @click="nextStep">{{ $t("registration.accountInfo.nextButton") }}</button>
  </fieldset>
</transition>


      <transition name="transitionName" mode="out-in">
        <fieldset v-if="step === 2">
          <h2 class="fs-title">{{ $t("registration.repContact.title") }}</h2>
          <input type="text" v-model="nomEntreprise" required :placeholder="$t('registration.repContact.companyNamePlaceholder')" />
          <select v-model="civilite" required>
            <option value="">{{ $t("registration.repContact.selectCivility") }}</option>
            <option value="Monsieur">Monsieur</option>
            <option value="Madame">Madame</option>
          </select>
          <input type="text" v-model="nomRepresentant" required :placeholder="$t('registration.repContact.repLastNamePlaceholder')" />
          <input type="text" v-model="prenomRepresentant" required :placeholder="$t('registration.repContact.repFirstNamePlaceholder')" />
          <input type="text" v-model="fonction" required :placeholder="$t('registration.repContact.positionPlaceholder')" />
          <input type="text" v-model="numero" required :placeholder="$t('registration.repContact.phonePlaceholder')" />
          <select id="pays" name="pays" v-model="selectedCountry" @change="updateWilayaRequirement" required>
  <option value="">{{ $t("registration.repContact.selectCountry") }}</option>
  <option v-for="(name, key) in pays" :key="key" :value="name">
    {{ name }}
  </option>
</select>

<select
  v-if="selectedCountry === 'Algérie'"
  name="wilaya"
  id="wilaya"
  v-model="selectedWilaya"
  required
>
  <option value="">{{ $t("registration.repContact.selectWilaya") }}</option>
  <option v-for="(name, key) in wilayas" :key="key" :value="name">
    {{ name }}
  </option>
</select>

          <input type="text" v-model="adresse" required :placeholder="$t('registration.repContact.addressPlaceholder')" />
          <button type="button" @click="prevStep">{{ $t("registration.repContact.prevButton") }}</button>
          <button type="button" @click="nextStep">{{ $t("registration.repContact.nextButton") }}</button>
        </fieldset>
      </transition>
      <transition name="transitionName" mode="out-in">
        <fieldset v-if="step === 3">
          <h2 class="fs-title">{{ $t("registration.companyInfo.title") }}</h2>
          <select name="activite" id="activite" v-model="activite" required>
            <option value="">{{ $t("registration.companyInfo.selectActivity") }}</option>
            <option v-for="(value, key) in activiteOptions" :key="key" :value="value">
              {{ value }}
            </option>
          </select>
          <!-- Catégorie Dropdown -->
          <select name="categorie" id="categorie" v-model="categorie" required @change="changeCategorie">
            <option value="">{{ $t("registration.companyInfo.selectCategory") }}</option>
            <option v-for="(value, key) in categorieOptions" :key="key" :value="value">
              {{ value }}
            </option>
          </select>
          <input type="text" v-model="codeCommerce" required :placeholder="$t('registration.companyInfo.tradeCodePlaceholder')" />
          <input type="text" v-model="nif" required :placeholder="$t('registration.companyInfo.nifPlaceholder')" />
          <input type="text" v-model="nis" required :placeholder="$t('registration.companyInfo.nisPlaceholder')" />
          <input type="text" v-model="nin"  required :placeholder="$t('registration.companyInfo.ninPlaceholder')"
            pattern="^[0-9]{18}$" maxlength="18" inputmode="numeric"/>

          <select name="nbr_employe" v-model="nombreEmployes" required>
            <option value="">{{ $t("registration.companyInfo.selectEmployeeCount") }}</option>
            <option value="-10">{{ $t("registration.companyInfo.employeeCount.lessThan10") }}</option>
            <option value="10-49">{{ $t("registration.companyInfo.employeeCount.from10to49") }}</option>
            <option value="50-249">{{ $t("registration.companyInfo.employeeCount.from50to249") }}</option>
            <option value="+250">{{ $t("registration.companyInfo.employeeCount.moreThan250") }}</option>
          </select>
            <!-- Add a custom class to the RecaptchaV2 container -->
      <div class="recaptcha-container">
        <RecaptchaV2
          ref="recaptchaRef"
          :sitekey="sitekey"
          @loadCallback="onVerify"
          @expiredCallback="onExpired"
        />
      </div>
         <button type="button" @click="prevStep">Précédent</button>
      <button type="submit" @click.prevent="submitForm">S'inscrire</button>
        </fieldset>
      </transition>
    </form>
  </section>
</template>

<script>
import axios from 'axios';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

// Import separate JSON files for each data type and language
import wilayasFr from '@/data/wilayas_fr.json';
import wilayasAr from '@/data/wilayas_ar.json';

import paysFr from '@/data/pays_fr.json';
import paysAr from '@/data/pays_ar.json';

import categorieFr from '@/data/categorie_fr.json';
import categorieAr from '@/data/categorie_ar.json';

import activiteFr from '@/data/activite_fr.json';
import activiteAr from '@/data/activite_ar.json';

const apiUrl = import.meta.env.VITE_API_URL;

export default {
  name: 'InscripForm',
  data() {
    return {
      step: 1,
      email: '',
      password: '',
      password2: '',
      showPassword1: false,
      showPassword2: false,
      nomEntreprise: '',
      civilite: '',
      nomRepresentant: '',
      prenomRepresentant: '',
      fonction: '',
      numero: '',
      selectedCountry: '',
      selectedWilaya: '',
      wilayaRequired: false,
      adresse: '',
      activite: '',
      categorie: '',
      codeCommerce: '',
      nif: '',
      nis: '',
      nin: '',
      nombreEmployes: '',
      captchaResponse: '',
      captchaSrc: ''
    };
  },
  computed: {
    // Dynamically select the appropriate JSON data based on the locale
    wilayas() {
      return this.$i18n.locale === 'fr' ? wilayasFr : wilayasAr;
    },
    pays() {
      return this.$i18n.locale === 'fr' ? paysFr : paysAr;
    },
    categorieOptions() {
      return this.$i18n.locale === 'fr' ? categorieFr : categorieAr;
    },
    activiteOptions() {
      return this.$i18n.locale === 'fr' ? activiteFr : activiteAr;
    }
  },
  methods: {
    nextStep() {
      this.step++;
    },
    prevStep() {
      this.animateContainer();
      if (this.step > 1) this.step--;
    },
    animateContainer() {
      const container = document.querySelector('.form-container');
      if (container) {
        container.classList.add('fade-scale');
        setTimeout(() => {
          container.classList.remove('fade-scale');
        }, 300);
      }
    },
    togglePassword(field) {
      if (field === 1) {
        this.showPassword1 = !this.showPassword1;
      } else {
        this.showPassword2 = !this.showPassword2;
      }
    },
    updateWilayaRequirement() {
  if (this.$i18n.locale === 'fr') {
    this.wilayaRequired = this.selectedCountry === 'Algérie';
  } else {
    this.wilayaRequired = this.selectedCountry === 'الجزائر';
  }
  if (!this.wilayaRequired) {
    this.selectedWilaya = "";
  }
}
,
    resetForm() {
      this.email = '';
      this.password = '';
      this.password2 = '';
      this.nomEntreprise = '';
      this.civilite = '';
      this.nomRepresentant = '';
      this.prenomRepresentant = '';
      this.fonction = '';
      this.numero = '';
      this.selectedCountry = '';
      this.selectedWilaya = '';
      this.wilayaRequired = false;
      this.adresse = '';
      this.activite = '';
      this.categorie = '';
      this.codeCommerce = '';
      this.nif = '';
      this.nis = '';
      this.nin = '';
      this.nombreEmployes = '';
      this.captchaResponse = '';
    },
    changeCategorie(event) {
      this.categorie = event.target.value;
      console.log("Catégorie sélectionnée :", this.categorie);
    },
    refreshCaptcha() {
      this.captchaSrc = "captcha/captcha.php?" + Math.random();
    },
    handleCaptchaVerified(response) {
      this.captchaResponse = response;
    },
    async submitForm() {
      if (!this.email || !this.password || !this.password2 || !this.selectedCountry || !this.activite || !this.categorie) {
        alert("Tous les champs requis doivent être remplis.");
        return;
      }
      if (this.password !== this.password2) {
        alert("Les mots de passe ne correspondent pas.");
        return;
      }
      let formData = new FormData();
      formData.append('email', this.email);
      formData.append('password', this.password);
      formData.append('password_confirmation', this.password2);
      formData.append('civilite', this.civilite);
      formData.append('nom', this.nomRepresentant);
      formData.append('prenom', this.prenomRepresentant);
      formData.append('fonction', this.fonction);
      formData.append('telephone', this.numero);
      formData.append('pays', this.selectedCountry);
      formData.append('adresse', this.adresse);
      formData.append('nom_entreprise', this.nomEntreprise);
      formData.append('activite', this.activite);
      formData.append('categorie', this.categorie);
      formData.append('code_commerce', this.codeCommerce);
      formData.append('num_fiscal', this.nif);
      formData.append('num_statistique', this.nis);
      formData.append('num_national', this.nin);
      formData.append('nombre_employes', 10);
      if (this.wilayaRequired) {
        formData.append('wilaya', this.selectedWilaya);
      }
      console.log("Données envoyées :", [...formData.entries()]);
      try {
        const response = await axios.post(`${apiUrl}/api/register`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });
        alert(response.data.message);
        const loginResponse = await axios.post(`${apiUrl}/api/login`, {
          email: this.email,
          password: this.password
        });
        if (loginResponse.data.success) {
          localStorage.setItem('token', loginResponse.data.token);
          localStorage.setItem('user', JSON.stringify(loginResponse.data.user));
          this.$router.push('/');
        } else {
          alert('Erreur de connexion : ' + loginResponse.data.message);
        }
      } catch (error) {
        console.error("Error submitting form:", error);
        const errorMessage = error.response?.data?.errors 
          ? JSON.stringify(error.response.data.errors) 
          : "Erreur inconnue.";
        alert("Erreur: " + errorMessage);
      } finally {
        this.resetForm();
      }
    }
  },
  mounted() {
    if (!window.grecaptcha) {
      console.error("Le script reCAPTCHA n'est pas chargé. Assurez-vous d'avoir ajouté la balise.");
    }
  }
};
</script>
<style>
.form-container {
  background-color: #ffffff;
  color: #001f3f;
  padding: 2rem;
  max-width: 600px;
  margin: 2rem auto;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-family: 'Segoe UI', sans-serif;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

#progressbar {
  display: flex;
  justify-content: space-between;
  margin-bottom: 2rem;
  padding: 0;
  list-style: none;
}

#progressbar li {
  width: 100%;
  text-align: center;
  position: relative;
  font-weight: bold;
  color: #ccc;
}

#progressbar li.active {
  color: #001f3f;
}

fieldset {
  border: none;
  padding: 0;
  margin: 0;
}

.fs-title {
  font-size: 1.5rem;
  margin-bottom: 1rem;
  color: #001f3f;
}
input, select {
  width: 100%;
  padding: 0.75rem;
  margin: 0.5rem 0;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 1rem;
  box-sizing: border-box;
}

input:focus, select:focus {
  outline: none;
  border-color: #001f3f;
  box-shadow: 0 0 5px #001f3f44;
}

.password-container {
  position: relative;
  width: 100%;
}

.password-container input {
  padding-right: 2.5rem; /* pour laisser la place à l'icône */
}

.eye-pass {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  font-size: 1.1rem;
  user-select: none;
}

button {
  background-color: #001f3f;
  color: white;
  padding: 0.75rem 1.5rem;
  margin: 1rem 0.5rem 0 0;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #003366;
}

.recaptcha-box {
  margin: 1rem 0;
  text-align: center;
}

/* 🔁 Smooth transitions */
.transitionName-enter-active,
.transitionName-leave-active {
  transition: opacity 0.5s ease;
}
.transitionName-enter-from,
.transitionName-leave-to {
  opacity: 0;
}
.recaptcha-container {
  margin: 20px auto;
  display: flex;
  justify-content: center;
  max-width: 400px;
}
</style>