<template>
  <div>
    <div class="container">
      <h2>📊 Bilan de la Classe</h2>

      <div class="stats">
        <div class="stat-card">
          <span class="label">Moyenne de classe</span>
          <span class="value">{{ bilan.moyenneClasse }}</span>
        </div>
        <div class="stat-card">
          <span class="label">Note minimale</span>
          <span class="value rouge">{{ bilan.min }}</span>
        </div>
        <div class="stat-card">
          <span class="label">Note maximale</span>
          <span class="value vert">{{ bilan.max }}</span>
        </div>
        <div class="stat-card">
          <span class="label">Admis (≥10)</span>
          <span class="value vert">{{ bilan.admis }}</span>
        </div>
        <div class="stat-card">
          <span class="label">Redoublants (&lt;10)</span>
          <span class="value rouge">{{ bilan.redoublants }}</span>
        </div>
      </div>

      <!-- GRAPHIQUE CAMEMBERT -->
      <div class="chart-container">
        <h3>Répartition Admis / Redoublants</h3>
        <canvas id="pieChart"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { Chart, registerables } from 'chart.js'
Chart.register(...registerables)

export default {
  data() {
    return {
      bilan: { moyenneClasse: 0, min: 0, max: 0, admis: 0, redoublants: 0 },
    }
  },
  async mounted() {
    const res = await axios.get('/api/etudiant.php')
    const etudiants = res.data
    const moyennes = etudiants.map((e) => parseFloat(e.moyenne))

    this.bilan = {
      moyenneClasse: (moyennes.reduce((a, b) => a + b, 0) / moyennes.length).toFixed(2),
      min: Math.min(...moyennes).toFixed(2),
      max: Math.max(...moyennes).toFixed(2),
      admis: etudiants.filter((e) => e.moyenne >= 10).length,
      redoublants: etudiants.filter((e) => e.moyenne < 10).length,
    }

    // Créer le camembert
    new Chart(document.getElementById('pieChart'), {
      type: 'pie',
      data: {
        labels: ['Admis', 'Redoublants'],
        datasets: [
          {
            data: [this.bilan.admis, this.bilan.redoublants],
            backgroundColor: ['#10b981', '#ef4444'],
          },
        ],
      },
      options: { responsive: true, plugins: { legend: { position: 'bottom' } } },
    })
  },
}
</script>

<style scoped>
body {
  font-family: cursive;
}
.container {
  max-width: 700px;
  margin: 40px auto;
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
h2 {
  margin-bottom: 24px;
  color: #1a237e;
  text-align: center;
}
.stats {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 30px;
}
.stat-card {
  flex: 1;
  min-width: 120px;
  background: #adcae7;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
}
.label {
  display: block;
  font-size: 13px;
  color: #666;
  margin-bottom: 8px;
}
.value {
  font-size: 28px;
  font-weight: bold;
  color: #1a237e;
}
.vert {
  color: #10b981 !important;
}
.rouge {
  color: #ef4444 !important;
}
.chart-container {
  .chart-container {
    text-align: center;
    position: relative;
    height: 350px;
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
  }
}
.chart-container h3 {
  margin-bottom: 20px;
  color: #444;
}
#pieChart {
  max-width: 350px;
  margin: 0 auto;
}
</style>
