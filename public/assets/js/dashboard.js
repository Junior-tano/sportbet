// Dashboard rendering
function renderDashboard() {
  const dashboardElement = document.getElementById("dashboard")
  if (!dashboardElement) return

  // Get bets
  const allBets = typeof window.getAllBets === "function" ? window.getAllBets() : []
  const pendingBets = typeof window.getPendingBets === "function" ? window.getPendingBets() : []
  const completedBets = typeof window.getCompletedBets === "function" ? window.getCompletedBets() : []
  const wonBets = completedBets.filter((bet) => bet.status === "won")

  // Calculate stats
  const totalBets = allBets.length
  const totalBetsAmount = allBets.reduce((total, bet) => total + bet.amount, 0)
  const totalWinnings = wonBets.reduce((total, bet) => total + bet.amount * bet.odds, 0)
  const netProfit = totalWinnings - totalBetsAmount

  // Calculate bets by sport
  const betsBySport = {}
  allBets.forEach((bet) => {
    const match =
      typeof window.mockMatches !== "undefined" ? window.mockMatches.find((m) => m.id === bet.matchId) : null

    if (match) {
      betsBySport[match.sport] = (betsBySport[match.sport] || 0) + 1
    }
  })

  dashboardElement.innerHTML = `
    <div class="dashboard-card border-0 shadow-lg p-4 rounded-lg">
      <div class="pb-2 border-b border-[#334155]">
        <div class="text-sm font-medium text-[#b3b3b3] flex items-center gap-2">
          <i class="fas fa-chart-line text-[#10b981]"></i>
          Total des paris
        </div>
      </div>
      <div class="pt-2">
        <div class="text-2xl font-bold">${totalBets}</div>
        <p class="text-xs text-[#b3b3b3]">
          Pour un montant total de <span class="text-[#10b981] font-medium">${totalBetsAmount.toFixed(2)} XOF</span>
        </p>
      </div>
    </div>

    <div class="dashboard-card border-0 shadow-lg p-4 rounded-lg">
      <div class="pb-2 border-b border-[#334155]">
        <div class="text-sm font-medium text-[#b3b3b3] flex items-center gap-2">
          <i class="fas fa-money-bill-wave text-[#10b981]"></i>
          Profit net
        </div>
      </div>
      <div class="pt-2">
        <div class="text-2xl font-bold ${netProfit >= 0 ? "text-[#10b981]" : "text-red-500"}">${netProfit >= 0 ? "+" : ""}${netProfit.toFixed(2)} XOF</div>
        <p class="text-xs text-[#b3b3b3]">
          Basé sur ${wonBets.length} paris gagnés
        </p>
      </div>
    </div>

    <div class="dashboard-card border-0 shadow-lg p-4 rounded-lg">
      <div class="pb-2 border-b border-[#334155]">
        <div class="text-sm font-medium text-[#b3b3b3] flex items-center gap-2">
          <i class="fas fa-percentage text-[#10b981]"></i>
          Taux de réussite
        </div>
      </div>
      <div class="pt-2">
        <div class="text-2xl font-bold">${completedBets.length > 0 ? ((wonBets.length / completedBets.length) * 100).toFixed(1) : "0"}%</div>
        <p class="text-xs text-[#b3b3b3]">
          ${wonBets.length} gagnés sur ${completedBets.length} terminés
        </p>
      </div>
    </div>

    <div class="dashboard-card border-0 shadow-lg p-4 rounded-lg">
      <div class="pb-2 border-b border-[#334155]">
        <div class="text-sm font-medium text-[#b3b3b3] flex items-center gap-2">
          <i class="fas fa-hourglass-half text-[#10b981]"></i>
          Paris en attente
        </div>
      </div>
      <div class="pt-2">
        <div class="text-2xl font-bold">${pendingBets.length}</div>
        <p class="text-xs text-[#b3b3b3]">
          Gain potentiel: <span class="text-[#10b981] font-medium">${pendingBets.reduce((total, bet) => total + bet.amount * bet.odds, 0).toFixed(2)} XOF</span>
        </p>
      </div>
    </div>
  `

  // Render bet stats if on dashboard page
  const betStatsElement = document.getElementById("bet-stats")
  if (betStatsElement) {
    if (Object.keys(betsBySport).length > 0) {
      betStatsElement.innerHTML = `<canvas id="betsBySportChart"></canvas>`

      const ctx = document.getElementById("betsBySportChart").getContext("2d")
      new window.Chart(ctx, {
        type: "pie",
        data: {
          labels: Object.keys(betsBySport).map((sport) => sport.charAt(0).toUpperCase() + sport.slice(1)),
          datasets: [
            {
              data: Object.values(betsBySport),
              backgroundColor: ["#10b981", "#f59e0b", "#3b82f6", "#ef4444"],
              borderColor: "#1e293b",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: "right",
              labels: {
                color: "#f2f2f2",
              },
            },
            tooltip: {
              callbacks: {
                label: (context) => {
                  const label = context.label || ""
                  const value = context.raw || 0
                  return `${label}: ${value} paris`
                },
              },
            },
          },
        },
      })
    } else {
      betStatsElement.innerHTML = `
        <div class="flex flex-col items-center justify-center h-full">
          <i class="fas fa-chart-pie text-[#334155] text-4xl mb-4"></i>
          <p class="text-[#b3b3b3]">Aucune donnée disponible</p>
        </div>
      `
    }
  }

  // Render upcoming matches if on dashboard page
  const upcomingMatchesElement = document.getElementById("upcoming-matches")
  if (upcomingMatchesElement && typeof window.mockMatches !== "undefined") {
    // Get upcoming matches (sorted by date)
    const now = new Date()
    const upcomingMatches = window.mockMatches
      .filter((match) => new Date(match.date) > now)
      .sort((a, b) => new Date(a.date) - new Date(b.date))
      .slice(0, 5)

    if (upcomingMatches.length > 0) {
      upcomingMatchesElement.innerHTML = `
        <div class="space-y-3">
          ${upcomingMatches
            .map(
              (match) => `
            <div class="bg-[#1a2332] p-3 rounded-md border border-[#334155]">
              <div class="flex justify-between items-center">
                <div>
                  <div class="font-medium">${match.homeTeam} vs ${match.awayTeam}</div>
                  <div class="text-xs text-[#b3b3b3] flex items-center gap-1 mt-1">
                    <i class="fas fa-clock"></i>
                    ${formatDate(match.date)}
                  </div>
                </div>
                <div class="text-xs px-2 py-1 rounded-full bg-[#334155] flex items-center gap-1">
                  ${getSportIcon(match.sport)} ${match.sport.charAt(0).toUpperCase() + match.sport.slice(1)}
                </div>
              </div>
            </div>
          `,
            )
            .join("")}
        </div>
      `
    } else {
      upcomingMatchesElement.innerHTML = `
        <div class="flex flex-col items-center justify-center h-full">
          <i class="fas fa-calendar text-[#334155] text-4xl mb-4"></i>
          <p class="text-[#b3b3b3]">Aucun match à venir</p>
        </div>
      `
    }
  }

  // Render recent activity
  const recentActivityElement = document.getElementById("recent-activity")
  if (recentActivityElement) {
    // Get recent bets (sorted by date)
    const recentBets = [...allBets].sort((a, b) => new Date(b.date) - new Date(a.date)).slice(0, 10)

    if (recentBets.length > 0) {
      recentActivityElement.innerHTML = `
        <div class="space-y-3">
          ${recentBets
            .map((bet) => {
              const match =
                typeof window.mockMatches !== "undefined" ? window.mockMatches.find((m) => m.id === bet.matchId) : null

              let statusIcon = ""
              switch (bet.status) {
                case "pending":
                  statusIcon = '<i class="fas fa-clock text-yellow-400"></i>'
                  break
                case "won":
                  statusIcon = '<i class="fas fa-check-circle text-green-400"></i>'
                  break
                case "lost":
                  statusIcon = '<i class="fas fa-times-circle text-red-400"></i>'
                  break
              }

              return `
                <div class="bg-[#1a2332] p-3 rounded-md border border-[#334155]">
                  <div class="flex justify-between items-center">
                    <div>
                      <div class="font-medium flex items-center gap-2">
                        ${statusIcon}
                        Pari sur ${match ? `${match.homeTeam} vs ${match.awayTeam}` : "un match"}
                      </div>
                      <div class="text-xs text-[#b3b3b3] mt-1">
                        Équipe: ${bet.team} | Montant: ${bet.amount.toFixed(2)} XOF | Cote: ${bet.odds.toFixed(2)}
                      </div>
                    </div>
                    <div class="text-xs text-[#b3b3b3]">
                      ${formatDate(bet.date)}
                    </div>
                  </div>
                </div>
              `
            })
            .join("")}
        </div>
      `
    } else {
      recentActivityElement.innerHTML = `
        <div class="flex flex-col items-center justify-center h-full">
          <i class="fas fa-history text-[#334155] text-4xl mb-4"></i>
          <p class="text-[#b3b3b3]">Aucune activité récente</p>
        </div>
      `
    }
  }
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

// Helper function for sport icons
function getSportIcon(sport) {
  switch (sport) {
    case "football":
      return '<i class="fas fa-futbol"></i>'
    case "basketball":
      return '<i class="fas fa-basketball-ball"></i>'
    case "tennis":
      return '<i class="fas fa-table-tennis"></i>'
    default:
      return '<i class="fas fa-trophy"></i>'
  }
}

// Initialize dashboard when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  renderDashboard()
})

// Make functions globally available
window.renderDashboard = renderDashboard
