<template>
  <div>
    <div class="login-bg">
      <div class="login-box">
        <h2>Connexion</h2>
        <br />
        <div class="form-group">
          <label> Nom:</label>
          <input v-model="form.username" type="text" required placeholder="Ex: Rakoto Jean" />
        </div>

        <div class="form-group">
          <label>Mot de passe :</label>
          <input
            v-model="form.password"
            type="password"
            required
            placeholder="Votre mot de passe ici"
          />
        </div>

        <button @click="login">Se connecter</button>

        <p v-if="message" :class="messageClass">{{ message }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      form: { username: '', password: '' },
      message: '',
      messageClass: '',
    }
  },
  methods: {
    async login() {
      try {
        const res = await axios.post('/api/auth.php', this.form)
        if (res.data.success) {
          // Sauvegarder la session
          localStorage.setItem('auth', 'true')
          // Rediriger vers l'application
          this.$router.push('/')
        } else {
          this.message = res.data.message
          this.messageClass = 'error'
        }
      } catch (e) {
        this.message = 'Erreur de connexion au serveur'
        this.messageClass = 'error'
      }
    },
  },
}
</script>

<style scoped>
body {
  font-family: cursive;
}
.login-bg {
  min-height: 100vh;
  background: rgb(8, 168, 212);
  display: flex;
  align-items: center;
  justify-content: center;
}
.login-box {
  background: white;
  padding: 40px;
  border-radius: 16px;
  width: 380px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
  text-align: center;
}
h2 {
  color: #1a237e;
  font-size: 28px;
  margin-bottom: 6px;
}
.subtitle {
  color: #888;
  margin-bottom: 30px;
  font-size: 14px;
}
.form-group {
  margin-bottom: 18px;
  text-align: left;
}
label {
  display: block;
  margin-bottom: 6px;
  font-weight: bold;
  color: #444;
}
input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 15px;
}
input:focus {
  border-color: #1a237e;
  outline: none;
}
button {
  width: 100%;
  padding: 13px;
  background: #17f;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
  margin-top: 10px;
}
button:hover {
  background: #1b35e2;
}
.error {
  color: red;
  margin-top: 15px;
  font-size: 14px;
}
.success {
  color: green;
  margin-top: 15px;
  font-weight: bold;
}
</style>
