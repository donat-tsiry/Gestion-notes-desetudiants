<template>
  <div class="container">
    <h2>{{ modeModif ? '✏️ Modifier un Étudiant' : '➕ Ajouter un Étudiant' }}</h2>

    <form @submit.prevent="enregistrer">
      <div class="form-group">
        <label>Nom :</label>
        <input v-model="form.nom" type="text" placeholder="Nom de l'étudiant" required />
      </div>

      <div class="form-group">
        <label>Note Maths :</label>
        <input
          v-model="form.note_math"
          type="number"
          min="0"
          max="20"
          step="0.5"
          required
          placeholder="Saisir un nombre entre 0 à 20"
        />
      </div>

      <div class="form-group">
        <label>Note Physique :</label>
        <input
          v-model="form.note_phys"
          type="number"
          min="0"
          max="20"
          step="0.5"
          required
          placeholder="Saisir un nombre entre 0 à 20"
        />
      </div>
      <button type="submit">{{ modeModif ? 'Mettre à jour' : 'Enregistrer' }}</button>
      <button v-if="modeModif" type="button" class="btn-annuler" @click="annuler">Annuler</button>
    </form>

    <!-- MESSAGE RETOUR SERVEUR -->
    <p v-if="message" :class="messageClass">{{ message }}</p>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      form: { nom: '', note_math: '', note_phys: '' },
      modeModif: false,
      message: '',
      messageClass: '',
    }
  },
  mounted() {
    // Si on arrive depuis Liste avec des données → mode modification
    const q = this.$route.query
    if (q.numEt) {
      this.modeModif = true
      this.form = {
        numEt: q.numEt,
        nom: q.nom,
        note_math: q.note_math,
        note_phys: q.note_phys,
      }
    }
  },
  methods: {
    async enregistrer() {
      if (this.modeModif) {
        await this.modifierEtudiant()
      } else {
        await this.ajouterEtudiant()
      }
    },

    async ajouterEtudiant() {
      try {
        const res = await axios.post('/api/etudiant.php', this.form)
        if (res.data.message && res.data.message.includes('réussie')) {
          this.message = '✅ ' + res.data.message
          this.messageClass = 'success'
          this.form = { nom: '', note_math: '', note_phys: '' }
          setTimeout(() => {
            this.$router.push('/liste')
          }, 1000)
        } else {
          this.message = '❌ ' + res.data.message
          this.messageClass = 'error'
        }
      } catch (e) {
        this.message = '❌ Erreur de connexion au serveur'
        this.messageClass = 'error'
      }
    },

    async modifierEtudiant() {
      try {
        const res = await axios.put('/api/etudiant.php', this.form)
        if (res.data.message && res.data.message.includes('réussie')) {
          this.message = '✅ ' + res.data.message
          this.messageClass = 'success'
          setTimeout(() => {
            this.$router.push('/liste')
          }, 1000)
        } else {
          this.message = '❌ ' + res.data.message
          this.messageClass = 'error'
        }
      } catch {
        this.message = '❌ Erreur de connexion au serveur'
        this.messageClass = 'error'
      }
    },

    annuler() {
      this.$router.push('/liste')
    },
  },
}
</script>

<style scoped>
.container {
  max-width: 500px;
  margin: 40px auto;
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  font-family: cursive;
}
h2 {
  margin-bottom: 24px;
  color: #1a237e;
  text-align: center;
}
.form-group {
  margin-bottom: 16px;
}
label {
  display: block;
  margin-bottom: 6px;
  font-weight: bold;
  color: #444;
}
input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 15px;
}
button {
  width: 100%;
  padding: 12px;
  background: #17f;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  margin-top: 10px;
}
button:hover {
  background: #394fe0;
}
.btn-annuler {
  background: rgb(232, 47, 47);
  margin-top: 8px;
}
.btn-annuler:hover {
  background: rgb(203, 36, 36);
}
.success {
  color: green;
  margin-top: 15px;
  font-weight: bold;
}
.error {
  color: red;
  margin-top: 15px;
  font-weight: bold;
}
</style>
