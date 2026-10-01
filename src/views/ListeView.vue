<template>
  <div class="container">
    <h2>📜 Liste des Étudiants</h2>

    <table>
      <thead>
        <tr>
          <th>N°</th>
          <th>Nom</th>
          <th>Math</th>
          <th>Physique</th>
          <th>Moyenne</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="et in etudiants" :key="et.numEt">
          <td>{{ et.numEt }}</td>
          <td>{{ et.nom }}</td>
          <td>{{ et.note_math }}</td>
          <td>{{ et.note_phys }}</td>
          <td :class="et.moyenne >= 10 ? 'admis' : 'redoublant'">
            {{ et.moyenne }}
          </td>
          <td>
            <button class="btn-edit" @click="allerModifier(et)">Modifier</button>
            <button class="btn-delete" @click="demanderConfirmation(et.numEt)">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>

    <p v-if="message" :class="messageClass">{{ message }}</p>

    <!-- Boîte de confirmation personnalisée -->
    <div v-if="showConfirm" class="overlay">
      <div class="confirm-box">
        <p>Êtes-vous sûr de vouloir supprimer cet étudiant ?</p>
        <button class="btn-oui" @click="confirmerSuppression">Oui, supprimer</button>
        <button class="btn-non" @click="showConfirm = false">Annuler</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      etudiants: [],
      message: '',
      messageClass: '',
      showConfirm: false,
      numEtASupprimer: null,
    }
  },
  mounted() {
    this.charger()
  },
  methods: {
    async charger() {
      const res = await axios.get('/api/etudiant.php')
      this.etudiants = res.data
    },

    allerModifier(et) {
      this.$router.push({
        name: 'ajout',
        query: {
          numEt: et.numEt,
          nom: et.nom,
          note_math: et.note_math,
          note_phys: et.note_phys,
        },
      })
    },

    demanderConfirmation(numEt) {
      this.numEtASupprimer = numEt
      this.showConfirm = true
    },

    async confirmerSuppression() {
      this.showConfirm = false
      const res = await axios.delete('/api/etudiant.php', {
        data: { numEt: this.numEtASupprimer },
      })
      if (res.data.message.includes('réussie')) {
        this.message = '✅ Suppression avec succès !'
        this.messageClass = 'success'
      } else {
        this.message = '❌ Ces données ne sont pas supprimées !'
        this.messageClass = 'error'
      }
      this.charger()
    },
  },
}
</script>

<style scoped>
.container {
  max-width: 800px;
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
table {
  width: 100%;
  border-collapse: collapse;
}
th {
  background: #1a237e;
  color: white;
  padding: 10px;
}
td {
  padding: 10px;
  border-bottom: 1px solid #eee;
  text-align: center;
}
.admis {
  color: green;
  font-weight: bold;
}
.redoublant {
  color: red;
  font-weight: bold;
}
.btn-edit {
  background: #1777c6;
  color: white;
  border: none;
  padding: 5px 8px;
  border-radius: 4px;
  cursor: pointer;
  margin-right: 4px;
}
.btn-delete {
  background: #ef4444;
  color: white;
  border: none;
  padding: 5px 8px;
  border-radius: 4px;
  cursor: pointer;
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
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}
.confirm-box {
  background: white;
  padding: 30px;
  border-radius: 12px;
  text-align: center;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}
.confirm-box p {
  font-size: 16px;
  margin-bottom: 20px;
  color: #1a237e;
  font-weight: bold;
}
.btn-oui {
  background: #ef4444;
  color: white;
  border: none;
  padding: 8px 20px;
  border-radius: 8px;
  cursor: pointer;
  margin-right: 10px;
  font-size: 14px;
}
.btn-non {
  background: #6b7280;
  color: white;
  border: none;
  padding: 8px 20px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
}
</style>
