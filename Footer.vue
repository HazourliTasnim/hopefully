<template>
  <footer class="legal-footer">
    <div class="footer-left">
      <p>
        <i class="fas fa-handshake mr-1"></i>
        {{ $t("footer.text") }}
      </p>
    </div>


    <div class="footer-center">
      <a href="#" @click.prevent="openModal">
        <i class="fas fa-lightbulb mr-1"></i>
        {{ $t("footer.suggestionLink") }}
      </a>
      <a href="/cadre_legal.pdf" target="_blank" rel="noopener">
        <i class="fas fa-file-alt mr-1"></i>
        {{ $t("footer.legalLink") }}
      </a>
    </div>

    <div class="footer-right">
      <span class="year">
        <i class="fas fa-copyright"></i> {{ new Date().getFullYear() }}
      </span>
   
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal">
        <span class="close" @click="closeModal">&times;</span>
        <h2>{{ $t("footer.modalTitle") }}</h2>
        <form @submit.prevent="submitSuggestion">
          <input type="email" v-model="email" :placeholder="$t('footer.emailPlaceholder')" required />
          <textarea v-model="suggestion" :placeholder="$t('footer.suggestionPlaceholder')" required></textarea>
          <button type="submit">{{ $t("footer.sendButton") }}</button>
        </form>
      </div>
    </div>
  </footer>
</template>


<script>
export default {
  name: "CombinedFooter",
  data() {
    return {
      showModal: false,
      email: "",
      suggestion: ""
    };
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    submitSuggestion() {
      if (this.email.trim() === "" || this.suggestion.trim() === "") {
        alert("Veuillez remplir tous les champs.");
        return;
      }
      console.log("Suggestion envoyée :", { email: this.email, suggestion: this.suggestion });
      alert("Merci pour votre suggestion !");
      this.email = "";
      this.suggestion = "";
      this.closeModal();
    }
  }
};
</script>
<style scooped>
/* === COMPACT FOOTER === */

.legal-footer {
  background: #082847;
  color: #e0f0ff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  padding: 1rem 2rem;
  font-size: 0.9rem;
  border-top: 3px solid #0a3d62;
  gap: 1rem;
}

.footer-left,
.footer-center,
.footer-right {
  display: flex;
  align-items: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.footer-left i,
.footer-center i,
.footer-right i {
  color: #aee3ff;
}

.footer-center a {
  color: #ffffff;
  text-decoration: none;
  position: relative;
  font-weight: 500;
  transition: color 0.3s ease;
}

.footer-center a::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -2px;
  width: 0%;
  height: 2px;
  background: #00c0ff;
  transition: width 0.3s ease;
}

.footer-center a:hover {
  color: #aee3ff;
}
.footer-center a:hover::after {
  width: 100%;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 2000;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 15, 30, 0.75);
  backdrop-filter: blur(4px);
  display: flex;
  justify-content: center;
  align-items: center;
  animation: fadeIn 0.3s ease;
}

/* === MODAL CONTAINER === */
.modal {
  background: #ffffff;
  padding: 2rem;
  border-radius: 1rem;
  width: 90%;
  max-width: 480px;
  box-shadow: 0 8px 24px rgba(0, 47, 95, 0.2);
  position: relative;
  animation: slideUp 0.3s ease;
}

/* === CLOSE BUTTON === */
.close {
  position: absolute;
  top: 1rem;
  right: 1.2rem;
  font-size: 1.6rem;
  color: #888;
  cursor: pointer;
  transition: color 0.3s ease;
}
.close:hover {
  color: #002f5f;
}

/* === MODAL TITLE === */
.modal h2 {
  margin-bottom: 1.2rem;
  font-size: 1.4rem;
  text-align: center;
  color: #002f5f;
}

/* === INPUTS === */
.modal input,
.modal textarea {
  width: 90%;
  padding: 0.8rem 1rem;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 0.7rem;
  font-size: 0.95rem;
  background-color: #f7faff;
  transition: border-color 0.3s ease;
}

.modal input:focus,
.modal textarea:focus {
  border-color: #002f5f;
  outline: none;
}

/* === BUTTON === */
.modal button {
  background-color: #002f5f;
  color: #ffffff;
  padding: 0.8rem 1.5rem;
  border: none;
  font-weight: 600;
  font-size: 1rem;
  border-radius: 0.65rem;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
  display: block;
  margin: 0 auto;
}

.modal button:hover {
  background-color: #014080;
  transform: translateY(-2px);
}

/* === ANIMATIONS === */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

