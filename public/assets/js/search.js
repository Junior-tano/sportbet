// Fonctionnalité de recherche
let searchTimeout = null

function initializeSearch() {
  const searchInput = document.getElementById("search-input")
  const searchResults = document.getElementById("search-results")

  if (!searchInput || !searchResults) return

  // Fonction pour effectuer la recherche
  function performSearch(query) {
    if (!query || query.trim() === "") {
      searchResults.innerHTML = ""
      searchResults.classList.add("hidden")
      return
    }

    // Recherche dans les matchs
    const matches = typeof window.mockMatches !== "undefined" ? window.mockMatches : []
    const filteredMatches = matches.filter((match) => {
      const homeTeam = match.homeTeam.toLowerCase()
      const awayTeam = match.awayTeam.toLowerCase()
      const venue = match.venue.toLowerCase()
      const sport = match.sport.toLowerCase()
      const searchLower = query.toLowerCase()

      return (
        homeTeam.includes(searchLower) ||
        awayTeam.includes(searchLower) ||
        venue.includes(searchLower) ||
        sport.includes(searchLower)
      )
    })

    // Afficher les résultats
    if (filteredMatches.length === 0) {
      searchResults.innerHTML = `
        <div class="p-4 text-center">
          <p class="text-[#b3b3b3]">Aucun résultat trouvé pour "${query}"</p>
        </div>
      `
    } else {
      searchResults.innerHTML = `
        <div class="p-2">
          <p class="text-xs text-[#b3b3b3] mb-2">${filteredMatches.length} résultat(s) trouvé(s)</p>
          <div class="space-y-2">
            ${filteredMatches
              .map(
                (match) => `
              <div class="p-2 hover:bg-[#334155] rounded-md cursor-pointer search-result-item" data-match-id="${match.id}">
                <div class="flex justify-between items-center">
                  <div>
                    <p class="font-medium">${match.homeTeam} vs ${match.awayTeam}</p>
                    <p class="text-xs text-[#b3b3b3]">${formatDate(match.date)}</p>
                  </div>
                  <div class="text-xs px-2 py-1 rounded-full bg-[#334155]">
                    ${getSportIcon(match.sport)} ${match.sport}
                  </div>
                </div>
              </div>
            `,
              )
              .join("")}
          </div>
        </div>
      `

      // Ajouter des écouteurs d'événements aux résultats
      document.querySelectorAll(".search-result-item").forEach((item) => {
        item.addEventListener("click", function () {
          const matchId = this.getAttribute("data-match-id")
          if (typeof window.openBetModal === "function") {
            window.openBetModal(matchId)
            searchResults.classList.add("hidden")
            searchInput.value = ""
          }
        })
      })
    }

    searchResults.classList.remove("hidden")
  }

  // Écouteur d'événement pour l'input de recherche
  searchInput.addEventListener("input", function () {
    const query = this.value

    // Utiliser un délai pour éviter trop de recherches pendant la frappe
    clearTimeout(searchTimeout)
    searchTimeout = setTimeout(() => {
      performSearch(query)
    }, 300)
  })

  // Fermer les résultats lorsqu'on clique ailleurs
  document.addEventListener("click", (e) => {
    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
      searchResults.classList.add("hidden")
    }
  })

  // Ouvrir les résultats lorsqu'on clique sur l'input
  searchInput.addEventListener("focus", function () {
    if (this.value.trim() !== "") {
      searchResults.classList.remove("hidden")
    }
  })
}

// Helper function pour formater la date
function formatDate(dateString) {
  const date = new Date(dateString)
  const day = date.getDate()
  const month = date.getMonth() + 1
  const year = date.getFullYear()
  return `${day}/${month}/${year}`
}

// Helper function pour les icônes de sport
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

// Initialiser la recherche au chargement du DOM
document.addEventListener("DOMContentLoaded", initializeSearch)

// Rendre les fonctions disponibles globalement
window.initializeSearch = initializeSearch
