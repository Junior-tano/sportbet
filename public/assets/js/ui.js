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

// Sélectionner une équipe pour le pari
function selectTeam(team) {
  const homeTeamBtn = document.getElementById("home-team-btn")
  const awayTeamBtn = document.getElementById("away-team-btn")
  const betSelectionInput = document.getElementById("bet-selection")
  const placeBetBtn = document.getElementById("place-bet-btn")
  const betAmountInput = document.getElementById("bet-amount")
  
  if (team === 'home' && homeTeamBtn) {
    homeTeamBtn.classList.add("bg-[#10b981]", "text-white")
    if (awayTeamBtn) awayTeamBtn.classList.remove("bg-[#10b981]", "text-white")
    
    if (betSelectionInput) {
      // Stocker l'équipe sélectionnée
      betSelectionInput.value = homeTeamBtn.textContent
      // Stocker des attributs supplémentaires
      betSelectionInput.setAttribute('data-match-id', homeTeamBtn.getAttribute('data-match-id') || '')
      betSelectionInput.setAttribute('data-sport', homeTeamBtn.getAttribute('data-sport') || '')
      betSelectionInput.setAttribute('data-team', homeTeamBtn.getAttribute('data-team') || homeTeamBtn.textContent)
    }
    
    // Activer le bouton de pari si un montant est également entré
    if (placeBetBtn && betAmountInput && betAmountInput.value.trim() !== '') {
      placeBetBtn.disabled = false
    }
    
    // Calculer le gain potentiel
    updatePotentialWin()
    
    console.log("Équipe domicile sélectionnée:", homeTeamBtn.textContent);
    console.log("Sport:", homeTeamBtn.getAttribute('data-sport'));
    console.log("Match ID:", homeTeamBtn.getAttribute('data-match-id'));
  } else if (team === 'away' && awayTeamBtn) {
    awayTeamBtn.classList.add("bg-[#10b981]", "text-white")
    if (homeTeamBtn) homeTeamBtn.classList.remove("bg-[#10b981]", "text-white")
    
    if (betSelectionInput) {
      // Stocker l'équipe sélectionnée
      betSelectionInput.value = awayTeamBtn.textContent
      // Stocker des attributs supplémentaires
      betSelectionInput.setAttribute('data-match-id', awayTeamBtn.getAttribute('data-match-id') || '')
      betSelectionInput.setAttribute('data-sport', awayTeamBtn.getAttribute('data-sport') || '')
      betSelectionInput.setAttribute('data-team', awayTeamBtn.getAttribute('data-team') || awayTeamBtn.textContent)
    }
    
    // Activer le bouton de pari si un montant est également entré
    if (placeBetBtn && betAmountInput && betAmountInput.value.trim() !== '') {
      placeBetBtn.disabled = false
    }
    
    // Calculer le gain potentiel
    updatePotentialWin()
    
    console.log("Équipe extérieure sélectionnée:", awayTeamBtn.textContent);
    console.log("Sport:", awayTeamBtn.getAttribute('data-sport'));
    console.log("Match ID:", awayTeamBtn.getAttribute('data-match-id'));
  }
}

// Calculer et afficher le gain potentiel
function updatePotentialWin() {
  const homeTeamBtn = document.getElementById("home-team-btn")
  const awayTeamBtn = document.getElementById("away-team-btn")
  const betAmountInput = document.getElementById("bet-amount")
  const potentialWinElement = document.getElementById("potential-win")
  
  if (!potentialWinElement || !betAmountInput) return
  
  let selectedOdds = 0
  
  if (homeTeamBtn && homeTeamBtn.classList.contains("bg-[#10b981]")) {
    selectedOdds = parseFloat(homeTeamBtn.getAttribute("data-odds") || 0)
  } else if (awayTeamBtn && awayTeamBtn.classList.contains("bg-[#10b981]")) {
    selectedOdds = parseFloat(awayTeamBtn.getAttribute("data-odds") || 0)
  }
  
  const amount = parseFloat(betAmountInput.value || 0)
  
  if (amount > 0 && selectedOdds > 0) {
    const potentialWin = (amount * selectedOdds).toFixed(2)
    potentialWinElement.textContent = potentialWin
  } else {
    potentialWinElement.textContent = "0.00"
  }
}

// Fonction pour placer un pari
function placeBet() {
  console.log("Placing bet from UI")
  
  // Vérifier si l'utilisateur est connecté
  if (typeof window.isUserLoggedIn === "function" && !window.isUserLoggedIn()) {
    showError("bet-error", "Vous devez être connecté pour parier")
    return
  }
  
  // Vérifier si une équipe est sélectionnée
  const betSelectionInput = document.getElementById("bet-selection")
  if (!betSelectionInput || !betSelectionInput.value) {
    showError("bet-error", "Veuillez sélectionner une équipe")
    return
  }
  
  // Vérifier le montant du pari
  const betAmountInput = document.getElementById("bet-amount")
  if (!betAmountInput || !betAmountInput.value || isNaN(betAmountInput.value) || parseInt(betAmountInput.value) <= 0) {
    showError("bet-error", "Veuillez entrer un montant valide")
    return
  }
  
  // Récupérer l'ID du match
  const matchIdInput = document.getElementById("bet-match-id")
  if (!matchIdInput || !matchIdInput.value) {
    showError("bet-error", "Erreur: ID du match manquant")
    return
  }
  
  // Récupérer les cotes
  let selectedOdds = 0
  const homeTeamBtn = document.getElementById("home-team-btn")
  const awayTeamBtn = document.getElementById("away-team-btn")
  
  if (homeTeamBtn && homeTeamBtn.classList.contains("bg-[#10b981]")) {
    selectedOdds = parseFloat(homeTeamBtn.getAttribute("data-odds") || 0)
  } else if (awayTeamBtn && awayTeamBtn.classList.contains("bg-[#10b981]")) {
    selectedOdds = parseFloat(awayTeamBtn.getAttribute("data-odds") || 0)
  }
  
  if (selectedOdds <= 0) {
    showError("bet-error", "Erreur: Cotes invalides")
    return
  }
  
  // Récupérer les informations supplémentaires
  const selectedTeam = betSelectionInput.value
  const selectedMatchId = matchIdInput.value
  const selectedSport = betSelectionInput.getAttribute('data-sport') || ''
  
  // Journaliser les informations du pari
  console.log("Détails du pari:");
  console.log(`- Match ID: ${selectedMatchId}`);
  console.log(`- Sport: ${selectedSport}`);
  console.log(`- Équipe: ${selectedTeam}`);
  console.log(`- Cotes: ${selectedOdds}`);
  console.log(`- Montant: ${betAmountInput.value} XOF`);
  
  // Créer l'objet pari
  const bet = {
    id: `bet-${Date.now()}`,
    matchId: selectedMatchId,
    team: selectedTeam,
    sport: selectedSport,
    amount: parseInt(betAmountInput.value),
    odds: selectedOdds,
    date: new Date().toISOString(),
    status: "pending"
  }
  
  console.log("Bet object created:", bet)
  
  // Appeler la fonction placeBet dans bets.js
  if (typeof window.placeBet === "function") {
    const success = window.placeBet(bet)
    
    if (success) {
      // Fermer le modal
      hideModal("bet-modal")
      
      // Réinitialiser le formulaire
      if (homeTeamBtn) homeTeamBtn.classList.remove("bg-[#10b981]", "text-white")
      if (awayTeamBtn) awayTeamBtn.classList.remove("bg-[#10b981]", "text-white")
      betSelectionInput.value = ""
      betAmountInput.value = ""
      
      const potentialWinElement = document.getElementById("potential-win");
      if (potentialWinElement) {
        potentialWinElement.textContent = "0.00"
      }
      
      // Afficher un message de confirmation
      const sportText = selectedSport ? ` (${selectedSport})` : '';
      alert(`Pari placé avec succès sur ${bet.team}${sportText} pour ${bet.amount} XOF`)
      
      // Déclencher un événement personnalisé
      document.dispatchEvent(new CustomEvent('betPlaced', { detail: bet }))
    } else {
      showError("bet-error", "Une erreur est survenue lors du placement du pari")
    }
  } else {
    showError("bet-error", "Fonction de pari non disponible")
  }
}

// Fermer un modal
function closeModal(id) {
  hideModal(id)
}

// Make functions globally available
window.showElement = showElement
window.hideElement = hideElement
window.showModal = showModal
window.hideModal = hideModal
window.showError = showError
window.hideError = hideError
window.toggleMobileMenu = toggleMobileMenu
window.selectTeam = selectTeam
window.updatePotentialWin = updatePotentialWin
window.placeBet = placeBet
window.closeModal = closeModal
