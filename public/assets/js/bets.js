// Bets management
let bets = []

// Initialize bets from localStorage
function initBets() {
  const savedBets = localStorage.getItem("bets")
  if (savedBets) {
    try {
      bets = JSON.parse(savedBets)
    } catch (e) {
      console.error("Error parsing bets from localStorage:", e)
      bets = []
    }
  }

  // Si aucun pari n'existe, ajoutons des paris de démonstration
  if (bets.length === 0) {
    addDemoBets()
  }
}

// Ajouter des paris de démonstration
function addDemoBets() {
  const demoBets = [
    {
      id: "bet-1",
      matchId: "1",
      team: "Real Madrid",
      amount: 1000,
      odds: 1.5,
      date: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000).toISOString(), // 3 jours avant
      status: "won",
    },
    {
      id: "bet-2",
      matchId: "2",
      team: "Los Angeles Lakers",
      amount: 500,
      odds: 1.8,
      date: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000).toISOString(), // 2 jours avant
      status: "lost",
    },
    {
      id: "bet-3",
      matchId: "3",
      team: "Rafael Nadal",
      amount: 800,
      odds: 1.7,
      date: new Date(Date.now() - 1 * 24 * 60 * 60 * 1000).toISOString(), // 1 jour avant
      status: "pending",
    },
    {
      id: "bet-4",
      matchId: "4",
      team: "Manchester City",
      amount: 1200,
      odds: 1.9,
      date: new Date().toISOString(), // Aujourd'hui
      status: "pending",
    },
    {
      id: "bet-5",
      matchId: "5",
      team: "Brooklyn Nets",
      amount: 700,
      odds: 1.65,
      date: new Date().toISOString(), // Aujourd'hui
      status: "pending",
    },
  ]

  bets = demoBets
  localStorage.setItem("bets", JSON.stringify(bets))
}

// Place a bet
function placeBet(bet) {
  console.log("Placing bet in bets.js:", bet)

  // Ajouter le pari à la liste
  bets.push(bet)

  // Sauvegarder dans localStorage
  localStorage.setItem("bets", JSON.stringify(bets))

  // Envoyer une notification
  if (typeof window.notifyBetPlaced === "function") {
    window.notifyBetPlaced(bet)
  }

  // Retourner true pour indiquer que le pari a été placé avec succès
  return true
}

// Simulate results for pending bets
function simulateResults() {
  bets = bets.map((bet) => {
    if (bet.status === "pending") {
      // 50% chance of winning
      const won = Math.random() > 0.5
      const updatedBet = {
        ...bet,
        status: won ? "won" : "lost",
      }

      // Envoyer une notification pour le résultat
      if (typeof window.notifyBetResult === "function") {
        window.notifyBetResult(updatedBet)
      }

      return updatedBet
    }
    return bet
  })

  localStorage.setItem("bets", JSON.stringify(bets))
  return bets
}

// Get all bets
function getAllBets() {
  return bets
}

// Get pending bets
function getPendingBets() {
  return bets.filter((bet) => bet.status === "pending")
}

// Get completed bets
function getCompletedBets() {
  return bets.filter((bet) => bet.status !== "pending")
}

// Initialize bets when DOM is loaded
document.addEventListener("DOMContentLoaded", initBets)

// Make functions globally available
window.placeBet = placeBet
window.getAllBets = getAllBets
window.getPendingBets = getPendingBets
window.getCompletedBets = getCompletedBets
window.simulateResults = simulateResults
