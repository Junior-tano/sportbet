// Match list rendering
let currentFilter = "all"
let currentSort = "date"

// Mock data for matches - sera remplacé par les données du backend lorsque disponibles
let mockMatches = [
  {
    id: "1",
    homeTeam: "Real Madrid",
    awayTeam: "Barcelona",
    homeOdds: 20.5,
    awayOdds: 2.5,
    drawOdds: 3.2,
    date: "2024-04-15T18:00:00.000Z",
    venue: "Santiago Bernabéu",
    sport: "football",
    popularity: 95,
  },
  {
    id: "2",
    homeTeam: "Los Angeles Lakers",
    awayTeam: "Boston Celtics",
    homeOdds: 1.8,
    awayOdds: 2.0,
    date: "2024-04-16T20:00:00.000Z",
    venue: "Staples Center",
    sport: "basketball",
    popularity: 90,
  },
  {
    id: "3",
    homeTeam: "Roger Federer",
    awayTeam: "Rafael Nadal",
    homeOdds: 2.2,
    awayOdds: 1.7,
    date: "2024-04-17T16:00:00.000Z",
    venue: "Wimbledon",
    sport: "tennis",
    popularity: 85,
  },
  {
    id: "4",
    homeTeam: "Manchester City",
    awayTeam: "Liverpool",
    homeOdds: 1.9,
    awayOdds: 3.5,
    drawOdds: 3.2,
    date: "2024-04-18T19:30:00.000Z",
    venue: "Etihad Stadium",
    sport: "football",
    popularity: 88,
  },
  {
    id: "5",
    homeTeam: "Brooklyn Nets",
    awayTeam: "Chicago Bulls",
    homeOdds: 1.65,
    awayOdds: 2.3,
    date: "2024-04-19T18:00:00.000Z",
    venue: "Barclays Center",
    sport: "basketball",
    popularity: 75,
  },
  {
    id: "6",
    homeTeam: "Novak Djokovic",
    awayTeam: "Carlos Alcaraz",
    homeOdds: 1.85,
    awayOdds: 1.95,
    date: "2024-04-20T14:00:00.000Z",
    venue: "Roland Garros",
    sport: "tennis",
    popularity: 80,
  },
  {
    id: "7",
    homeTeam: "Bayern Munich",
    awayTeam: "Borussia Dortmund",
    homeOdds: 1.6,
    awayOdds: 4.2,
    drawOdds: 3.5,
    date: "2024-04-21T15:30:00.000Z",
    venue: "Allianz Arena",
    sport: "football",
    popularity: 92,
  },
  {
    id: "8",
    homeTeam: "Golden State Warriors",
    awayTeam: "Phoenix Suns",
    homeOdds: 1.75,
    awayOdds: 2.1,
    date: "2024-04-22T19:00:00.000Z",
    venue: "Chase Center",
    sport: "basketball",
    popularity: 82,
  },
  {
    id: "9",
    homeTeam: "Serena Williams",
    awayTeam: "Naomi Osaka",
    homeOdds: 2.0,
    awayOdds: 1.8,
    date: "2024-04-23T13:00:00.000Z",
    venue: "US Open",
    sport: "tennis",
    popularity: 78,
  },
  {
    id: "10",
    homeTeam: "Paris Saint-Germain",
    awayTeam: "Olympique de Marseille",
    homeOdds: 1.45,
    awayOdds: 6.5,
    drawOdds: 4.2,
    date: "2024-04-24T20:00:00.000Z",
    venue: "Parc des Princes",
    sport: "football",
    popularity: 87,
  },
  {
    id: "11",
    homeTeam: "Milwaukee Bucks",
    awayTeam: "Miami Heat",
    homeOdds: 1.7,
    awayOdds: 2.2,
    date: "2024-04-25T18:30:00.000Z",
    venue: "Fiserv Forum",
    sport: "basketball",
    popularity: 76,
  },
  {
    id: "12",
    homeTeam: "Daniil Medvedev",
    awayTeam: "Alexander Zverev",
    homeOdds: 1.9,
    awayOdds: 1.9,
    date: "2024-04-26T15:00:00.000Z",
    venue: "Australian Open",
    sport: "tennis",
    popularity: 70,
  },
]

// Helper functions
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

function formatDate(dateString) {
  const date = new Date(dateString)
  const options = { year: "numeric", month: "long", day: "numeric", hour: "2-digit", minute: "2-digit" }
  return date.toLocaleDateString("fr-FR", options)
}

// Fonction pour ouvrir le modal de paris
function openBetModal(matchId) {
  console.log("Opening bet modal for match:", matchId)

  // Vérifier si l'utilisateur est connecté
  if (typeof window.isUserLoggedIn === "function" && !window.isUserLoggedIn()) {
    console.log("User not logged in, showing login prompt")
    alert("Veuillez vous connecter pour parier")
    if (typeof window.toggleAuth === "function") {
      window.toggleAuth()
    }
    return
  }

  // Trouver le match correspondant
  const match = (window.mockMatches || mockMatches).find((m) => m.id === matchId)
  if (!match) {
    console.error("Match not found:", matchId)
    return
  }

  // Mettre à jour le titre du modal
  const betModalTitle = document.getElementById("bet-modal-title")
  if (betModalTitle) {
    betModalTitle.textContent = `Parier sur ${match.homeTeam} vs ${match.awayTeam}`
  }

  // Mettre à jour les boutons d'équipe
  const homeTeamBtn = document.getElementById("home-team-btn")
  const awayTeamBtn = document.getElementById("away-team-btn")

  if (homeTeamBtn) {
    homeTeamBtn.textContent = match.homeTeam
    homeTeamBtn.setAttribute("data-odds", match.homeOdds)
  }

  if (awayTeamBtn) {
    awayTeamBtn.textContent = match.awayTeam
    awayTeamBtn.setAttribute("data-odds", match.awayOdds)
  }

  // Réinitialiser la sélection d'équipe
  if (homeTeamBtn) homeTeamBtn.classList.remove("bg-[#10b981]", "text-white")
  if (awayTeamBtn) awayTeamBtn.classList.remove("bg-[#10b981]", "text-white")

  // Stocker l'ID du match dans le formulaire
  const betMatchIdInput = document.getElementById("bet-match-id")
  if (betMatchIdInput) {
    betMatchIdInput.value = matchId
  }

  // Réinitialiser le montant du pari
  const betAmountInput = document.getElementById("bet-amount")
  if (betAmountInput) {
    betAmountInput.value = ""
  }

  // Cacher les messages d'erreur
  if (typeof window.hideError === "function") {
    window.hideError("bet-error")
  }

  // Afficher le modal
  if (typeof window.showModal === "function") {
    window.showModal("bet-modal")
  } else {
    const betModal = document.getElementById("bet-modal")
    if (betModal) {
      betModal.classList.remove("hidden")
    }
  }
}

function renderMatches() {
  console.log("Rendering matches...")
  
  // Check for match list (full list view)
  const matchListElement = document.getElementById("match-list")
  
  // Check for featured matches (on homepage)
  const featuredMatchesElement = document.getElementById("featured-matches")
  
  // Check for upcoming matches (on dashboard)
  const upcomingMatchesElement = document.getElementById("upcoming-matches")
  
  if (!matchListElement && !featuredMatchesElement && !upcomingMatchesElement) {
    console.log("No match elements found on this page")
    return
  }

  // Filter matches
  let filteredMatches = window.mockMatches || mockMatches
  if (currentFilter !== "all" && matchListElement) {
    console.log("Filtering by sport:", currentFilter);
    console.log("Before filter:", filteredMatches.length, "matches");
    
    filteredMatches = (window.mockMatches || mockMatches).filter((match) => {
      console.log("Match sport:", match.sport, "Filter:", currentFilter);
      return match.sport === currentFilter;
    });
    
    console.log("After filter:", filteredMatches.length, "matches");
  }

  // Sort matches
  const sortedMatches = [...filteredMatches].sort((a, b) => {
    if (currentSort === "date") {
      return new Date(a.date).getTime() - new Date(b.date).getTime()
    } else if (currentSort === "popularity") {
      return b.popularity - a.popularity
    }
    return 0
  })

  // Check if user is logged in
  const isLoggedIn = typeof window.isUserLoggedIn === "function" ? window.isUserLoggedIn() : false
  console.log("User logged in:", isLoggedIn)

  // Generate HTML for a match card
  const generateMatchCard = (match) => `
    <div class="overflow-hidden border-0 shadow-lg transition-all duration-200 hover:shadow-xl rounded-lg bg-[#1e293b]">
      <div class="match-card-gradient relative p-4 text-white">
        <div class="absolute right-3 top-3 rounded-full bg-[#f59e0b] px-2 py-1 text-xs font-bold text-[#1a1a1a]">
          ${getSportIcon(match.sport)} ${match.sport.toUpperCase()}
        </div>
        <h3 class="mb-1 text-lg font-bold">
          ${match.homeTeam} vs ${match.awayTeam}
        </h3>
        <div class="flex items-center gap-2 text-sm">
          <i class="fas fa-clock"></i>
          <span>${formatDate(match.date)}</span>
        </div>
        <div class="flex items-center gap-2 text-sm">
          <i class="fas fa-map-marker-alt"></i>
          <span>${match.venue}</span>
        </div>
      </div>

      <div class="p-4">
        <div class="flex justify-between">
          <div class="text-center w-1/2 border-r border-[#334155]">
            <p class="font-medium">${match.homeTeam}</p>
            <p class="odds-pulse text-2xl font-bold text-[#10b981]">${match.homeOdds.toFixed(2)}</p>
          </div>
          <div class="text-center w-1/2">
            <p class="font-medium">${match.awayTeam}</p>
            <p class="odds-pulse text-2xl font-bold text-[#10b981]">${match.awayOdds.toFixed(2)}</p>
          </div>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm">
          <div class="flex items-center gap-1">
            <i class="fas fa-chart-line text-[#f59e0b]"></i>
            <span>Popularité</span>
          </div>
          <div class="w-24 bg-[#334155] rounded-full h-2.5">
            <div class="bg-[#f59e0b] h-2.5 rounded-full" style="width: ${match.popularity}%"></div>
          </div>
        </div>
      </div>

      <div class="border-t border-[#334155] bg-[#1e293b] p-4">
        ${isLoggedIn
            ? `<button class="bet-button w-full bg-[#f59e0b] hover:bg-[#f59e0b]/90 text-[#1a1a1a] font-medium py-2 px-4 rounded-md" data-match-id="${match.id}">
              Parier maintenant
             </button>`
            : `<button class="login-to-bet w-full bg-[#334155] hover:bg-[#334155]/90 text-[#f2f2f2] font-medium py-2 px-4 rounded-md">
              Connectez-vous pour parier
             </button>`
        }
      </div>
    </div>
  `

  // Generate HTML for a compact match card (for dashboard)
  const generateCompactMatchCard = (match) => `
    <div class="flex items-center justify-between p-3 border-b border-[#334155] hover:bg-[#1a2332]/50 transition-colors">
      <div>
        <div class="flex items-center gap-2">
          <span class="text-[#f59e0b]">${getSportIcon(match.sport)}</span>
          <p class="font-medium">${match.homeTeam} vs ${match.awayTeam}</p>
        </div>
        <div class="text-xs text-[#b3b3b3] flex items-center gap-1 mt-1">
          <i class="fas fa-clock"></i>
          <span>${formatDate(match.date)}</span>
        </div>
      </div>
      <button class="bet-button text-xs bg-[#f59e0b] hover:bg-[#f59e0b]/90 text-[#1a1a1a] px-2 py-1 rounded" data-match-id="${match.id}">
        Parier
      </button>
    </div>
  `

  // Render main match list
  if (matchListElement) {
    matchListElement.innerHTML = sortedMatches
      .map(generateMatchCard)
      .join("")
  }
  
  // Render featured matches (only top 3 by popularity)
  if (featuredMatchesElement) {
    const featuredMatches = [...(window.mockMatches || mockMatches)]
      .sort((a, b) => b.popularity - a.popularity)
      .slice(0, 3)
    
    featuredMatchesElement.innerHTML = featuredMatches
      .map(generateMatchCard)
      .join("")
  }
  
  // Render upcoming matches for dashboard (only next 5 by date)
  if (upcomingMatchesElement) {
    const upcomingMatches = [...(window.mockMatches || mockMatches)]
      .sort((a, b) => new Date(a.date).getTime() - new Date(b.date).getTime())
      .slice(0, 5)
    
    upcomingMatchesElement.innerHTML = upcomingMatches
      .map(generateCompactMatchCard)
      .join("")
  }

  // Add event listeners to bet buttons
  const betButtons = document.querySelectorAll(".bet-button")
  betButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const matchId = this.getAttribute("data-match-id")
      openBetModal(matchId)
    })
  })

  // Add event listeners to login-to-bet buttons
  const loginToBetButtons = document.querySelectorAll(".login-to-bet")
  loginToBetButtons.forEach((button) => {
    button.addEventListener("click", () => {
      alert("Veuillez vous connecter pour parier")
      if (typeof window.toggleAuth === "function") {
        window.toggleAuth()
      }
    })
  })
}

// Initialize match list and filters when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM loaded, initializing matches...")

  // Render matches immediately
  renderMatches()

  // Filter buttons
  const filterButtons = document.querySelectorAll(".filter-btn")
  filterButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const filter = this.getAttribute("data-filter")
      currentFilter = filter

      // Update active button
      filterButtons.forEach((btn) => {
        if (btn.getAttribute("data-filter") === filter) {
          btn.classList.remove("bg-transparent", "border", "border-[#334155]")
          btn.classList.add("bg-[#10b981]", "text-white")
        } else {
          btn.classList.add("bg-transparent", "border", "border-[#334155]")
          btn.classList.remove("bg-[#10b981]", "text-white")
        }
      })

      renderMatches()
    })
  })

  // Sort select
  const sortSelect = document.getElementById("sort-select")
  if (sortSelect) {
    sortSelect.addEventListener("change", function () {
      currentSort = this.value
      renderMatches()
    })
  }
})

// Make functions globally available
window.renderMatches = renderMatches
window.openBetModal = openBetModal
