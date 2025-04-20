<template>
  <div class="admin-profile">
    <!-- Header avec switch de thème -->
    <div class="profile-header">
      
      
    </div>

    <div class="content-container">
      



      <!-- 🔹 Formulaire + Activités -->
      <div class="double-section">
        <!-- Profil -->
        <div class="profile-form glow-border">
          <h3><i class="fas fa-user-cog"></i> Modifier le Profil</h3>
          <form @submit.prevent="updateProfile">
            <div class="input-group">
              <i class="fas fa-user icon"></i>
              <input type="text" v-model="user.nom" placeholder="Nom complet">
            </div>
            <div class="input-group">
              <i class="fas fa-envelope icon"></i>
              <input type="email" v-model="user.email" placeholder="Email professionnel">
            </div>
            <div class="input-group">
              <i class="fas fa-key icon"></i>
              <input type="password" v-model="user.password" placeholder="Nouveau mot de passe">
            </div>
            <div class="input-group">
              <i class="fas fa-key icon"></i>
              <input type="password" v-model="user.password" placeholder="Confirmation du mot de passe">
            </div>
            <button type="submit" class="save-button">
              <i class="fas fa-save"></i> Enregistrer
            </button>
          </form>
        </div>
</div>  
</div>
<!-- 🔹 Actions Admin (liées au sidebar) -->
<div class="admin-actions">
        <h3><i class="fas fa-shield-alt"></i> Actions Administratives</h3>
        <div class="action-buttons">
          <!-- Bouton 1 : Redirige vers "Utilisateurs" dans le sidebar -->
          <button @click="navigateTo('users')" class="action-btn primary">
            <i class="fas fa-users"></i> Gérer les admins
          </button>
          
          <!-- Bouton 2 : Redirige vers "Logs" -->
          <button @click="navigateTo('logs')" class="action-btn warning">
            <i class="fas fa-scroll"></i> Voir le dashboard
          </button>
          
          <!-- Bouton 3 : Redirige vers "Paramètres" -->
          <button @click="navigateTo('settings')" class="action-btn">
            <i class="fas fa-cogs"></i> Voir les offres
          </button>
        </div>
      </div>
    </div>
  
</template>

<script>
export default {
  data() {
    return {
      user: {
        nom: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  mounted() {
    // Essaye de récupérer les informations de l'utilisateur dès que le composant est monté
    this.fetchUserProfile();
  },
  methods: {
    // Récupérer les informations de l'utilisateur à partir de l'API
    fetchUserProfile() {
      axios.get('/api/admin/profile', { headers: { Authorization: `Bearer ${localStorage.getItem('token')}` } })
        .then(response => {
          this.user.nom = response.data.nom;
          this.user.email = response.data.email;
        })
        .catch(error => {
          console.error("Erreur lors du chargement du profil", error);
        });
    },
    
    // Mettre à jour les informations de l'utilisateur
    updateProfile() {
      axios.put('/api/admin/profile', this.user, { headers: { Authorization: `Bearer ${localStorage.getItem('token')}` } })
        .then(response => {
          alert('Profil mis à jour avec succès!');
          // Après la mise à jour, recharge les informations du profil
          this.fetchUserProfile();
        })
        .catch(error => {
          console.error("Erreur lors de la mise à jour du profil", error);
        });
    }
  }
}


</script>

<style scoped>
/* Style élégant et sobre sans dégradés */
.admin-profile {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #2d3748;
  background: #ffffff;
  padding: 2.5rem;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  width: 90%;
  max-width: 640px;
  margin: 3rem auto;
  border: 1px solid #e2e8f0;
  position: relative;
}

.admin-profile::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background-color: #2c5282;
}

.profile-header {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 2rem;
}

.profile-form h3 {
  color: #1a365d;
  margin-bottom: 2rem;
  font-size: 1.5rem;
  font-weight: 600;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
}

.profile-form h3 i {
  font-size: 1.25rem;
  color: #2c5282;
}

.form-fields {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.input-group {
  position: relative;
}

.input-group .icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  left: 10px;
  transform: translateY(-50%);
  color: #4a5568;
  font-size: 1rem;
}

.input-group input {
  width: 100%;
  padding: 1rem 1rem 1rem 2.75rem;
  background-color: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  color: #1a202c;
  font-size: 0.95rem;
  transition: all 0.2s ease;
}

.input-group input:focus {
  outline: none;
  border-color: #2c5282;
  box-shadow: 0 0 0 3px rgba(44, 82, 130, 0.1);
  background-color: #fff;
}

.button-group {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 2rem;
}

.save-button {
  background-color: #2c5282;
  color: white;
  border: none;
  padding: 1rem;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s ease;
  font-weight: 500;
  font-size: 1rem;
  display: flex;
  margin-left:250px;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.save-button i {
  font-size: 1rem;
}

.save-button:hover {
  background-color: #1a365d;
  transform: translateY(-1px);
}

/* Nouveau style pour les actions admin */
.admin-actions {
  margin-top: 2.5rem;
  padding-top: 2rem;
  border-top: 1px solid #edf2f7;
}

.admin-actions h3 {
  color: #2d3748;
  margin-bottom: 1.5rem;
  font-size: 1.25rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 10px;
}

.admin-actions h3 i {
  font-size: 1.1rem;
  color: #4a5568;
}

.action-buttons {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 12px;
}

.action-btn {
  padding: 0.75rem 1rem;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  font-size: 0.9rem;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  border: 1px solid transparent;
}

.action-btn i {
  font-size: 0.95rem;
}

/* Nouvelle palette de couleurs pour les boutons */
.action-btn.primary {
  background-color: #e6f2ff;
  color: #2c5282;
  border-color: #c3dafe;
}

.action-btn.primary:hover {
  background-color: #d6e6ff;
}

.action-btn.warning {
  background-color: #fff5f5;
  color: #c53030;
  border-color: #fed7d7;
}

.action-btn.warning:hover {
  background-color: #ffebeb;
}

.action-btn.default {
  background-color: #f8fafc;
  color: #4a5568;
  border-color: #e2e8f0;
}

.action-btn.default:hover {
  background-color: #edf2f7;
}

@media (max-width: 768px) {
  .admin-profile {
    padding: 2rem 1.5rem;
    width: 95%;
  }
  
  .action-buttons {
    grid-template-columns: 1fr;
  }
}
</style>