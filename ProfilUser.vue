<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const user = ref({
    civilite: '',
    nom: '',
    prenom: '',
    email: '',
    fonction: '',
    telephone: '',
    entreprise: {}
});
const apiUrl = import.meta.env.VITE_API_URL;
const password = ref('');
const message = ref('');
const error = ref('');

// Helper function to get the logo URL with fallback to a default logo
const getLogoUrl = (logoPath) => {
  if (!logoPath || logoPath === "null") {
    return `${apiUrl}/storage/logo/default.png`;
  }
  return `${apiUrl}/storage/logo/` + logoPath.split("/").pop();
};

// Handle image error to display default logo
const handleImageError = (event) => {
  event.target.src = `${apiUrl}/storage/logo/default.png`;
};

const fetchUserData = async () => {
    try {
        const response = await axios.get(`${apiUrl}/api/profile`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
          }
        });
        user.value = response.data;
    } catch (err) {
        error.value = 'Erreur lors du chargement des données.';
    }
};

const updateProfile = async () => {
    try {
        const formData = { ...user.value };
        if (password.value) {
            formData.password = password.value;
        }
        
        const response = await axios.put(`${apiUrl}/api/profile`, formData, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
          }
        });
        message.value = response.data.message;
        error.value = '';
        password.value = '';
    } catch (err) {
        error.value = 'Erreur lors de la mise à jour du profil.';
    }
};

onMounted(fetchUserData);
</script>

<template>
  <div class="profile-wrapper">
   

    <!-- Right: Utilisateur -->
    <section id="profil-section-unique">
    
      <h2 class="section-title">
        <i class="fas fa-user-circle"></i> Mon Profil
      </h2>

      <div v-if="message" class="alert success">
        <i class="fas fa-check-circle"></i> {{ message }}
      </div>
      <div v-if="error" class="alert error">
        <i class="fas fa-exclamation-triangle"></i> {{ error }}
      </div>

      <div class="form-block">
        <div class="form-row">
          <i class="fas fa-user-tie"></i>
          <select v-model="user.civilite">
            <option value="Monsieur">Monsieur</option>
            <option value="Madame">Madame</option>
          </select>
        </div>

        <div class="form-row">
          <i class="fas fa-signature"></i>
          <input type="text" v-model="user.nom" placeholder="Nom" />
        </div>

        <div class="form-row">
          <i class="fas fa-signature"></i>
          <input type="text" v-model="user.prenom" placeholder="Prénom" />
        </div>

        <div class="form-row">
          <i class="fas fa-envelope"></i>
          <input type="email" v-model="user.email" placeholder="Email" />
        </div>

        <div class="form-row">
          <i class="fas fa-briefcase"></i>
          <input type="text" v-model="user.fonction" placeholder="Fonction" />
        </div>

        <div class="form-row">
          <i class="fas fa-phone"></i>
          <input type="text" v-model="user.telephone" placeholder="Téléphone" />
        </div>

        <div class="form-row">
          <i class="fas fa-lock"></i>
          <input type="password" v-model="password" placeholder="Mot de passe (laisser vide si inchangé)" />
        </div>

        <button @click="updateProfile">
          <i class="fas fa-save"></i> Enregistrer les modifications
        </button>
      </div>
    </section>
     <!-- Left: Entreprise -->
     <section id="entreprise-section-unique" class="enterprise-section">
    <!-- Votre contenu existant reste inchangé -->
    <h2 class="section-title">
      <i class="fas fa-building"></i> Entreprise Associée
    </h2>

      <div class="info-grid">
        <div v-for="(field, key) in {
          'Nom de l\'entreprise': 'nom_entreprise',
          'Activité': 'activite',
          'Catégorie': 'categorie',
          'Pays': 'pays',
          'Wilaya': 'wilaya',
          'Adresse': 'adresse',
          'Code Commerce': 'code_commerce',
          'Nombre d\'employés': 'nombre_employes'
        }" :key="key" class="info-block">
          <label>{{ key }}</label>
          <p>{{ user.entreprise[field] || '-' }}</p>
        </div>
      </div>

      <h3 class="sub-title">Identifiants Officiels</h3>
      <div class="info-grid triple">
        <div v-for="(field, key) in {
          'Numéro Fiscal': 'num_fiscal',
          'Numéro Statistique': 'num_statistique',
          'Numéro National': 'num_national'
        }" :key="key" class="info-block">
          <label>{{ key }}</label>
          <p>{{ user.entreprise[field] || '-' }}</p>
        </div>
      </div>

      <div class="logo-box">
        <p class="label">Logo de l'entreprise</p>
        <img :src="getLogoUrl(user.entreprise.logo)" alt="Logo" @error="handleImageError" />
      </div>
    </section>
  </div>
</template>

<script>
export default {
  props: ['user', 'password', 'message', 'error'],
  methods: {
    updateProfile() {
      this.$emit('update-profile');
    },
    getLogoUrl(logo) {
      return logo ? `/uploads/logos/${logo}` : '/default-logo.png';
    },
    handleImageError(e) {
      e.target.src = '/default-logo.png';
    }
  }
}
</script>

<style scoped>
#entreprise-section-unique {
  --ent-blue: #0a192f;
  --ent-light-blue: #6480ff;
  --ent-white: #ffffff;
  --ent-light-gray: #f8fafc;
  --ent-border: #e2e8f0;
}

#entreprise-section-unique {
  background: var(--ent-white);
  border-radius: 8px;
  padding: 1.5rem;
  margin: 1rem 0;
  border: 1px solid var(--ent-border);
}

#entreprise-section-unique .section-title {
  color: var(--ent-blue);
  font-size: 1.3rem;
  margin-bottom: 1.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid var(--ent-light-blue);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

#entreprise-section-unique .info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  margin-bottom: 1.5rem;
}

#entreprise-section-unique .info-block {
  background: var(--ent-light-gray);
  padding: 0.8rem;
  border-radius: 6px;
  border-left: 3px solid var(--ent-light-blue);
}

#entreprise-section-unique .info-block label {
  display: block;
  font-size: 0.8rem;
  color: var(--ent-blue);
  font-weight: 600;
  margin-bottom: 0.3rem;
}

#entreprise-section-unique .info-block p {
  color: var(--ent-blue);
  margin: 0;
  font-size: 0.95rem;
}

#entreprise-section-unique .sub-title {
  color: var(--ent-blue);
  font-size: 1.1rem;
  margin: 1.5rem 0 1rem;
}

#entreprise-section-unique .logo-box {
  margin-top: 1.5rem;
  text-align: center;
}

#entreprise-section-unique .logo-box .label {
  color: var(--ent-blue);
  font-weight: 600;
  margin-bottom: 0.8rem;
}

#entreprise-section-unique .logo-box img {
  max-width: 200px;
  max-height: 200px;
  border: 1px dashed var(--ent-border);
  padding: 1rem;
  border-radius: 8px;
  background: var(--ent-light-gray);
}

.profile-wrapper {
  display: flex;
  gap: 30px;
  padding: 2rem;
  max-width: 1200px;
  margin: auto;
  background: #fff;
  color: #002B5B;
  font-family: "Segoe UI", sans-serif;
  border-radius: 12px;
  box-shadow: 0 0 18px rgba(0,0,0,0.04);
}
section {
  flex: 1;
}
#profil-section-unique .section-title {
  color: #0a192f;
  font-size: 1.7rem;
  margin-bottom: 1.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid #6480ff; 
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.section-title {
  font-size: 1.4rem;
  color: #004080;
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 1rem;
}
.sub-title {
  margin-top: 2rem;
  font-weight: bold;
  color: #004080;
  font-size: 1.1rem;
}
.info-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 12px;
}

.info-block p {
  font-weight: bold;
  color: #002B5B;
}
.logo-box {
  margin-top: 2rem;
}
.logo-box img {
  max-width: 150px;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 5px;
  background: #f9f9f9;
}
.label {
  font-size: 0.85rem;
  margin-bottom: 0.5rem;
}
.alert {
  margin-bottom: 1rem;
  padding: 0.75rem 1rem;
  border-radius: 6px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.alert.success {
  background-color: #e9f7ef;
  color: #1e7e34;
}
.alert.error {
  background-color: #fcebea;
  color: #c82333;
}
.form-block {
  display: flex;
  flex-direction: column;
  gap: 15px;
}
.form-row {
  display: flex;
  align-items: center;
  gap: 10px;
}
.form-row input,
.form-row select {
  flex: 1;
  padding: 8px 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
}
button {
  background-color: #004080;
  color: white;
  padding: 10px 15px;
  font-weight: bold;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 10px;
}
button i {
  margin-right: 6px;
}
@media (max-width: 900px) {
  .profile-wrapper {
    flex-direction: column;
  }
}
/* Responsive spécifique */
@media (max-width: 768px) {
  #entreprise-section-unique .info-grid {
    grid-template-columns: 1fr;
  }
}

</style>