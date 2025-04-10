// UI helper functions

// Show an element
function showElement(id) {
  const element = document.getElementById(id)
  if (element) {
    element.classList.remove("hidden")
  }
}

// Hide an element
function hideElement(id) {
  const element = document.getElementById(id)
  if (element) {
    element.classList.add("hidden")
  }
}

// Show a modal
function showModal(id) {
  showElement(id)
}

// Hide a modal
function hideModal(id) {
  hideElement(id)
}

// Show error message
function showError(id, message) {
  const errorElement = document.getElementById(id)
  if (errorElement) {
    errorElement.textContent = message
    errorElement.classList.remove("hidden")
  }
}

// Hide error message
function hideError(id) {
  const errorElement = document.getElementById(id)
  if (errorElement) {
    errorElement.classList.add("hidden")
  }
}

// Toggle mobile menu
function toggleMobileMenu() {
  const mobileMenu = document.getElementById("mobile-menu")
  const menuIcon = document.getElementById("menu-icon")

  if (mobileMenu.classList.contains("hidden")) {
    mobileMenu.classList.remove("hidden")
    menuIcon.classList.remove("fa-bars")
    menuIcon.classList.add("fa-times")
  } else {
    mobileMenu.classList.add("hidden")
    menuIcon.classList.remove("fa-times")
    menuIcon.classList.add("fa-bars")
  }
}

// Setup UI event listeners
document.addEventListener("DOMContentLoaded", () => {
  // Mobile menu toggle
  const mobileMenuButton = document.getElementById("mobile-menu-button")
  if (mobileMenuButton) {
    mobileMenuButton.addEventListener("click", toggleMobileMenu)
  }

  // Bet modal
  const betModal = document.getElementById("bet-modal")
  if (betModal) {
    const closeBetModal = document.getElementById("close-bet-modal")
    const cancelBet = document.getElementById("cancel-bet")
    const betForm = document.getElementById("bet-form")
    const homeTeamBtn = document.getElementById("home-team-btn")
    const awayTeamBtn = document.getElementById("away-team-btn")

    // Variables pour stocker la sélection
    let selectedTeam = null
    let selectedOdds = null

    // Fermer le modal
    if (closeBetModal) {
      closeBetModal.addEventListener("click", () => hideModal("bet-modal"))
    }

    if (cancelBet) {
      cancelBet.addEventListener("click", () => hideModal("bet-modal"))
    }

    // Sélection d'équipe
    if (homeTeamBtn) {
      homeTeamBtn.addEventListener("click", () => {
        selectedTeam = homeTeamBtn.textContent
        selectedOdds = Number.parseFloat(homeTeamBtn.getAttribute("data-odds"))
        homeTeamBtn.classList.add("bg-[#10b981]", "text-white")
        awayTeamBtn.classList.remove("bg-[#10b981]", "text-white")
      })
    }

    if (awayTeamBtn) {
      awayTeamBtn.addEventListener("click", () => {
        selectedTeam = awayTeamBtn.textContent
        selectedOdds = Number.parseFloat(awayTeamBtn.getAttribute("data-odds"))
        awayTeamBtn.classList.add("bg-[#10b981]", "text-white")
        homeTeamBtn.classList.remove("bg-[#10b981]", "text-white")
      })
    }

    // Soumission du formulaire
    if (betForm) {
      betForm.addEventListener("submit", (e) => {
        e.preventDefault()

        // Vérifier si une équipe est sélectionnée
        if (!selectedTeam) {
          showError("bet-error", "Veuillez sélectionner une équipe")
          return
        }

        // Vérifier le montant du pari
        const betAmount = Number.parseFloat(document.getElementById("bet-amount").value)
        if (isNaN(betAmount) || betAmount <= 0) {
          showError("bet-error", "Veuillez entrer un montant valide")
          return
        }

        // Récupérer l'ID du match
        const matchId = document.getElementById("bet-match-id").value

        // Créer l'objet de pari
        const bet = {
          id: `bet-${Date.now()}`,
          matchId: matchId,
          team: selectedTeam,
          amount: betAmount,
          odds: selectedOdds,
          date: new Date().toISOString(),
          status: "pending",
        }

        console.log("Placing bet:", bet)

        // Placer le pari
        if (typeof window.placeBet === "function") {
          window.placeBet(bet)

          // Fermer le modal
          hideModal("bet-modal")

          // Réinitialiser le formulaire
          selectedTeam = null
          selectedOdds = null
          homeTeamBtn.classList.remove("bg-[#10b981]", "text-white")
          awayTeamBtn.classList.remove("bg-[#10b981]", "text-white")
          document.getElementById("bet-amount").value = ""

          // Afficher un message de confirmation
          alert(`Pari placé avec succès sur ${bet.team} pour ${bet.amount} XOF`)

          // Rafraîchir la liste des paris si on est sur la page des paris
          if (document.getElementById("bet-history-container") && typeof window.renderBetHistory === "function") {
            window.renderBetHistory()
          }
        } else {
          showError("bet-error", "Une erreur est survenue lors du placement du pari")
        }
      })
    }
  }
})

// Make functions globally available
window.showElement = showElement
window.hideElement = hideElement
window.showModal = showModal
window.hideModal = hideModal
window.showError = showError
window.hideError = hideError
window.toggleMobileMenu = toggleMobileMenu
