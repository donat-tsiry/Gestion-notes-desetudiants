<template>
  <div>
    <!-- MENU — caché sur la page login -->
    <nav v-if="$route.name !== 'login'">
      <div class="nav-top">Gestion des notes des étudiants</div>
      <div class="nav-bottom">
        <div class="nav-links">
          <RouterLink to="/"><span class="icon"></span> Ajout</RouterLink>
          <RouterLink to="/liste"><span class="icon"></span> Liste</RouterLink>
          <RouterLink to="/bilan"><span class="icon"></span> Bilan</RouterLink>
        </div>
        <button @click="confirmerDeconnexion" class="btn-deconnexion">Se déconnecter</button>
      </div>
    </nav>

    <RouterView />

    <!-- Popup confirmation déconnexion -->
    <div v-if="showConfirm" class="overlay">
      <div class="confirm-box">
        <div class="confirm-icon"></div>
        <h3>Déconnexion</h3>
        <p>Voulez-vous vraiment vous se déconnecter ?</p>
        <div class="confirm-buttons">
          <button @click="deconnecter" class="btn-oui">✔ Oui</button>
          <button @click="showConfirm = false" class="btn-non">✖ Non</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showConfirm: false,
    }
  },
  methods: {
    confirmerDeconnexion() {
      this.showConfirm = true
    },
    deconnecter() {
      this.showConfirm = false
      localStorage.removeItem('auth')
      this.$router.push('/login')
    },
  },
}
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  font-family: 'Segoe UI', Arial, sans-serif;
  background: #eef2f7;
}

/* ===== NAVBAR ===== */
nav {
  background: linear-gradient(135deg, #1a237e, #283593);
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
  position: sticky;
}
.nav-top {
  text-align: center;
  color: white;
  font-size: 22px;
  font-weight: bold;
  font-family: cursive;
  padding: 10px 0 6px 0;
  letter-spacing: 1px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.15);
}
.nav-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 30px;
}
/* Liens */
.nav-links {
  display: flex;
  gap: 8px;
  align-items: center;
}
nav a {
  color: white;
  text-decoration: none;
  font-size: 15px;
  font-weight: 500;
  padding: 8px 18px;
  border-radius: 8px;
  transition: all 0.25s ease;
  display: flex;
  align-items: center;
  gap: 6px;
  border: 2px solid transparent;
}
nav a:hover {
  background: rgba(255, 255, 255, 0.15);
  color: white;
  border-color: rgba(255, 255, 255, 0.3);
}
nav a.router-link-exact-active {
  background: white;
  color: #1a237e;
  font-weight: bold;
  border-color: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}
.icon {
  font-size: 14px;
}

/* Bouton déconnexion */
.btn-deconnexion {
  background: linear-gradient(135deg, #ef4444, #dc2626);
  color: white;
  border: none;
  padding: 9px 18px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  font-weight: bold;
  font-family: 'Segoe UI', Arial, sans-serif;
  transition: all 0.25s ease;
  box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
  display: flex;
  align-items: center;
  gap: 6px;
}
.btn-deconnexion:hover {
  background: linear-gradient(135deg, #dc2626, #b91c1c);
  transform: translateY(-1px);
  box-shadow: 0 4px 10px rgba(239, 68, 68, 0.5);
}

/* ===== OVERLAY ===== */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.55);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}
.confirm-box {
  background: white;
  padding: 35px 45px;
  border-radius: 16px;
  text-align: center;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
  animation: popIn 0.2s ease;
}
@keyframes popIn {
  from {
    transform: scale(0.8);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}
.confirm-icon {
  font-size: 40px;
  margin-bottom: 10px;
}
.confirm-box h3 {
  font-size: 1.3rem;
  color: #1a237e;
  margin-bottom: 8px;
}
.confirm-box p {
  font-size: 1rem;
  margin-bottom: 25px;
  color: #555;
}
.confirm-buttons {
  display: flex;
  gap: 15px;
  justify-content: center;
}
.btn-oui {
  background: green;
  color: white;
  border: none;
  padding: 10px 28px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
  font-size: 15px;
  transition: transform 0.2s;
}
.btn-oui:hover {
  transform: translateY(-1px);
  background: rgb(24, 139, 24);
}
.btn-non {
  background: rgb(190, 43, 43);
  color: white;
  border: none;
  padding: 10px 28px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
  font-size: 15px;
  transition: transform 0.2s;
}
.btn-non:hover {
  transform: translateY(-1px);
}
</style>
