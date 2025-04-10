// Bet history rendering
function renderBetHistory() {
  const betHistoryContainer = document.getElementById("bet-history-container")
  if (!betHistoryContainer) return

  // Check if user is logged in
  const isLoggedIn = typeof window.isUserLoggedIn === "function" ? window.isUserLoggedIn() : false

  if (!isLoggedIn) {
    betHistoryContainer.innerHTML = `
      <div class="text-center py-12 bg-[#1e293b] rounded-lg border border-[#334155]">
        <i class="fas fa-trophy text-[#b3b3b3] text-4xl mb-4"></i>
        <h2 class="text-xl font-semibold mb-4">Connectez-vous pour voir vos paris</h2>
        <p class="text-[#b3b3b3] mb-6">Vous devez être connecté pour accéder à l'historique de vos paris.</p>
        <button id="login-history-btn" class="bg-[#10b981] hover:bg-[#10b981]/90 text-white font-medium py-2 px-4 rounded-md">
          Se connecter
        </button>
      </div>
    `

    document.getElementById("login-history-btn").addEventListener("click", () => {
      if (typeof window.toggleAuth === "function") {
        window.toggleAuth()
      }
    })
    return
  }

  // Get bets
  const allBets = typeof window.getAllBets === "function" ? window.getAllBets() : []
  const pendingBets = typeof window.getPendingBets === "function" ? window.getPendingBets() : []
  const completedBets = typeof window.getCompletedBets === "function" ? window.getCompletedBets() : []

  betHistoryContainer.innerHTML = `
    <div class="bg-[#1e293b] rounded-lg border border-[#334155] p-4">
      <div class="mb-4">
        <div class="flex border-b border-[#334155]">
          <button class="tab-btn px-4 py-2 border-b-2 border-[#10b981] text-[#f2f2f2]" data-tab="all">Tous</button>
          <button class="tab-btn px-4 py-2 border-b-2 border-transparent text-[#b3b3b3] hover:text-[#f2f2f2]" data-tab="pending">En attente</button>
          <button class="tab-btn px-4 py-2 border-b-2 border-transparent text-[#b3b3b3] hover:text-[#f2f2f2]" data-tab="completed">Terminés</button>
        </div>
      </div>
      
      <div id="all-bets-tab" class="tab-content">
        ${renderBetList(allBets)}
      </div>
      
      <div id="pending-bets-tab" class="tab-content hidden">
        ${renderBetList(pendingBets)}
      </div>
      
      <div id="completed-bets-tab" class="tab-content hidden">
        ${renderBetList(completedBets)}
      </div>
    </div>
    
    <div class="mt-4 text-center">
      <button id="simulate-results-btn" class="bg-[#f59e0b] hover:bg-[#f59e0b]/90 text-[#1a1a1a] font-medium py-2 px-4 rounded-md">
        Simuler les résultats
      </button>
    </div>
  `

  // Add event listeners to tabs
  const tabButtons = document.querySelectorAll(".tab-btn")
  tabButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const tab = this.getAttribute("data-tab")

      // Update active tab button
      tabButtons.forEach((btn) => {
        if (btn.getAttribute("data-tab") === tab) {
          btn.classList.add("border-[#10b981]", "text-[#f2f2f2]")
          btn.classList.remove("border-transparent", "text-[#b3b3b3]")
        } else {
          btn.classList.remove("border-[#10b981]", "text-[#f2f2f2]")
          btn.classList.add("border-transparent", "text-[#b3b3b3]")
        }
      })

      // Show active tab content
      document.querySelectorAll(".tab-content").forEach((content) => {
        content.classList.add("hidden")
      })
      document.getElementById(`${tab}-bets-tab`).classList.remove("hidden")
    })
  })

  // Add event listener to simulate results button
  document.getElementById("simulate-results-btn").addEventListener("click", () => {
    if (typeof window.simulateResults === "function") {
      window.simulateResults()
    }
    renderBetHistory()
  })
}

// Helper function to render a list of bets
function renderBetList(bets) {
  if (bets.length === 0) {
    return `
      <div class="text-center py-8">
        <i class="fas fa-info-circle text-[#b3b3b3] text-4xl mb-4"></i>
        <p class="text-[#b3b3b3]">Aucun pari à afficher.</p>
      </div>
    `
  }

  // Trier les paris par date (plus récent en premier)
  const sortedBets = [...bets].sort((a, b) => {
    return new Date(b.date).getTime() - new Date(a.date).getTime()
  })

  return `
    <div class="space-y-4">
      ${sortedBets
        .map((bet) => {
          // Get match details
          const match =
            typeof window.mockMatches !== "undefined"
              ? window.mockMatches.find((m) => m.id === bet.matchId)
              : { homeTeam: "Équipe A", awayTeam: "Équipe B" }

          // Render bet status badge
          let statusBadge = ""
          switch (bet.status) {
            case "pending":
              statusBadge = `<span class="bg-yellow-900/20 text-yellow-400 border border-yellow-900/50 flex items-center gap-1 px-2 py-1 rounded-md text-xs">
              <i class="fas fa-exclamation-circle"></i>
              <span>En attente</span>
            </span>`
              break
            case "won":
              statusBadge = `<span class="bg-green-900/20 text-green-400 border border-green-900/50 flex items-center gap-1 px-2 py-1 rounded-md text-xs">
              <i class="fas fa-check-circle"></i>
              <span>Gagné</span>
            </span>`
              break
            case "lost":
              statusBadge = `<span class="bg-red-900/20 text-red-400 border border-red-900/50 flex items-center gap-1 px-2 py-1 rounded-md text-xs">
              <i class="fas fa-times-circle"></i>
              <span>Perdu</span>
            </span>`
              break
          }

          return `
          <div class="border-0 shadow-md bg-[#1e293b] overflow-hidden rounded-lg">
            <div class="pb-2 border-b border-[#334155] p-4">
              <div class="flex justify-between items-center">
                <div class="text-lg flex items-center gap-2">
                  <i class="fas fa-trophy text-[#f59e0b]"></i>
                  ${match ? `${match.homeTeam} vs ${match.awayTeam}` : "Match inconnu"}
                </div>
                ${statusBadge}
              </div>
            </div>
            <div class="p-4">
              <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center gap-2">
                  <i class="fas fa-trophy text-[#10b981]"></i>
                  <div>
                    <p class="text-sm text-[#b3b3b3]">Équipe sélectionnée</p>
                    <p class="font-medium">${bet.team}</p>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <i class="fas fa-dollar-sign text-[#10b981]"></i>
                  <div>
                    <p class="text-sm text-[#b3b3b3]">Cote</p>
                    <p class="font-medium">${bet.odds.toFixed(2)}</p>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <i class="fas fa-dollar-sign text-[#10b981]"></i>
                  <div>
                    <p class="text-sm text-[#b3b3b3]">Montant parié</p>
                    <p class="font-medium">${bet.amount.toFixed(2)} XOF</p>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <i class="fas fa-dollar-sign text-[#10b981]"></i>
                  <div>
                    <p class="text-sm text-[#b3b3b3]">
                      ${bet.status === "won" ? "Gain réalisé" : bet.status === "lost" ? "Montant perdu" : "Gain potentiel"}
                    </p>
                    <p class="font-medium">
                      ${
                        bet.status === "won"
                          ? `+${(bet.amount * bet.odds).toFixed(2)} XOF`
                          : bet.status === "lost"
                            ? `-${bet.amount.toFixed(2)} XOF`
                            : `${(bet.amount * bet.odds).toFixed(2)} XOF`
                      }
                    </p>
                  </div>
                </div>
              </div>
              <div class="mt-4 flex items-center gap-2 text-xs text-[#b3b3b3]">
                <i class="fas fa-clock"></i>
                <span>Placé le ${formatDate(bet.date)}</span>
              </div>
            </div>
          </div>
        `
        })
        .join("")}
    </div>
  `
}

// Helper function to format date
function formatDate(dateString) {
  const date = new Date(dateString)
  const day = date.getDate()
  const month = date.getMonth() + 1
  const year = date.getFullYear()
  const hours = date.getHours().toString().padStart(2, "0")
  const minutes = date.getMinutes().toString().padStart(2, "0")
  return `${day}/${month}/${year} à ${hours}:${minutes}`
}

// Initialize bet history when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  renderBetHistory()
})

// Make functions globally available
window.renderBetHistory = renderBetHistory
