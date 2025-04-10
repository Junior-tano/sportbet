@extends('sportsbet2.layouts.app')

@section('title', 'Matchs - SportsBet Simulator')

@section('styles')
<style>
  .match-card-gradient {
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3)), #1e293b;
    background-size: cover;
    background-position: center;
  }
  .odds-pulse {
    animation: pulse 2s infinite;
  }
  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.03); }
    100% { transform: scale(1); }
  }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
    <h1 class="text-3xl font-bold mb-4 md:mb-0">Matchs Disponibles</h1>
    <div class="flex flex-wrap gap-2">
      <button class="filter-btn px-4 py-2 rounded-md bg-[#10b981] text-white" data-filter="all">
        Tous
      </button>
      <button class="filter-btn px-4 py-2 rounded-md bg-transparent border border-[#334155]" data-filter="football">
        <i class="fas fa-futbol mr-2"></i>Football
      </button>
      <button class="filter-btn px-4 py-2 rounded-md bg-transparent border border-[#334155]" data-filter="basketball">
        <i class="fas fa-basketball-ball mr-2"></i>Basketball
      </button>
      <button class="filter-btn px-4 py-2 rounded-md bg-transparent border border-[#334155]" data-filter="tennis">
        <i class="fas fa-table-tennis mr-2"></i>Tennis
      </button>
    </div>
  </div>

  <!-- Message pour les utilisateurs non connectés -->
  <div id="auth-message" class="mb-8 p-4 bg-[#334155] rounded-lg flex items-center justify-between" 
       style="display: none;">
    <div class="flex items-center">
      <i class="fas fa-info-circle text-[#10b981] text-2xl mr-3"></i>
      <div>
        <p class="font-medium">Pour parier sur ces matchs, veuillez vous connecter</p>
        <p class="text-sm text-[#b3b3b3]">Créez un compte et recevez 1000€ virtuels pour commencer à parier</p>
      </div>
    </div>
    <div class="flex space-x-3">
      <a href="/register" class="border border-[#10b981] text-[#10b981] px-4 py-2 rounded-md hover:bg-[#10b981] hover:text-white login-hover-effect">
        Créer un compte
      </a>
      <a href="/login" class="bg-[#10b981] hover:bg-[#10b981]/90 text-white px-4 py-2 rounded-md login-hover-effect">
        Se connecter
      </a>
    </div>
  </div>

  <div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-medium">Résultats: <span id="match-count">0</span> matchs</h2>
    <div class="flex items-center">
      <label for="sort-select" class="mr-2 text-sm">Trier par:</label>
      <select id="sort-select" class="bg-[#334155] text-white border-none rounded-md p-2">
        <option value="date">Date</option>
        <option value="popularity">Popularité</option>
      </select>
    </div>
  </div>

  <div id="match-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Les matchs seront chargés dynamiquement par JavaScript -->
  </div>
</div>

<!-- Bet Form Modal -->
<div id="bet-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-md relative">
    <button id="close-bet-modal" class="absolute top-4 right-4 text-gray-500 hover:text-white">
      <i class="fas fa-times"></i>
    </button>

    <h2 id="bet-modal-title" class="text-2xl font-bold mb-6">Placer un pari</h2>

    <div id="bet-error" class="bg-red-900/20 border border-red-900/50 text-red-400 px-4 py-3 rounded mb-4 hidden"></div>

    <form id="bet-form">
      <input type="hidden" id="bet-match-id">
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-2">Sélectionnez une équipe</label>
          <div class="grid grid-cols-2 gap-2">
            <button type="button" id="home-team-btn" class="w-full px-4 py-2 border border-[#334155] rounded-md text-center hover:bg-[#10b981] hover:text-white transition-colors" data-odds=""></button>
            <button type="button" id="away-team-btn" class="w-full px-4 py-2 border border-[#334155] rounded-md text-center hover:bg-[#10b981] hover:text-white transition-colors" data-odds=""></button>
          </div>
        </div>

        <div>
          <label for="bet-amount" class="block text-sm font-medium mb-1">Montant (XOF)</label>
          <input id="bet-amount" type="number" min="1" step="1" class="w-full px-3 py-2 bg-[#334155] text-[#f2f2f2] border border-[#334155] rounded-md focus:outline-none focus:ring-2 focus:ring-[#10b981]" placeholder="Montant du pari" required>
        </div>
        
        <div>
          <label class="block text-sm font-medium mb-1">Gain potentiel (XOF)</label>
          <div class="w-full px-3 py-2 bg-[#334155] text-[#f2f2f2] border border-[#334155] rounded-md">
            <span id="potential-win">0.00</span>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
          <button type="button" id="cancel-bet" class="px-4 py-2 border border-[#334155] rounded-md hover:bg-[#334155] transition-colors">
            Annuler
          </button>
          <button type="submit" id="place-bet-btn" class="bg-[#f59e0b] hover:bg-[#f59e0b]/90 text-[#1a1a1a] font-medium py-2 px-4 rounded-md disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled>
            Parier
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    console.log("Matchs page loaded, initializing...");
    
    // Utiliser les données des matchs provenant du backend
    window.mockMatches = {!! $matchesJson !!};
    console.log("Backend matches data:", window.mockMatches);
    
    // Configuration du modal de pari
    const homeTeamBtn = document.getElementById("home-team-btn");
    const awayTeamBtn = document.getElementById("away-team-btn");
    const betAmountInput = document.getElementById("bet-amount");
    const placeBetBtn = document.getElementById("place-bet-btn");
    const betForm = document.getElementById("bet-form");
    const closeBetModal = document.getElementById("close-bet-modal");
    const cancelBet = document.getElementById("cancel-bet");
    
    // Variables pour le modal de pari
    let selectedTeam = null;
    let selectedOdds = null;
    
    // Sélection d'équipe
    if (homeTeamBtn) {
      homeTeamBtn.addEventListener("click", function() {
        selectedTeam = homeTeamBtn.textContent;
        selectedOdds = parseFloat(homeTeamBtn.getAttribute("data-odds"));
        homeTeamBtn.classList.add("bg-[#10b981]", "text-white");
        awayTeamBtn.classList.remove("bg-[#10b981]", "text-white");
        updatePotentialWin();
        updatePlaceBetButton();
        console.log("Selected home team:", selectedTeam, "with odds:", selectedOdds);
      });
    }
    
    if (awayTeamBtn) {
      awayTeamBtn.addEventListener("click", function() {
        selectedTeam = awayTeamBtn.textContent;
        selectedOdds = parseFloat(awayTeamBtn.getAttribute("data-odds"));
        awayTeamBtn.classList.add("bg-[#10b981]", "text-white");
        homeTeamBtn.classList.remove("bg-[#10b981]", "text-white");
        updatePotentialWin();
        updatePlaceBetButton();
        console.log("Selected away team:", selectedTeam, "with odds:", selectedOdds);
      });
    }
    
    // Mise à jour du gain potentiel lorsque le montant change
    if (betAmountInput) {
      betAmountInput.addEventListener("input", function() {
        updatePotentialWin();
        updatePlaceBetButton();
      });
    }
    
    // Fermeture du modal
    if (closeBetModal) {
      closeBetModal.addEventListener("click", function() {
        document.getElementById("bet-modal").classList.add("hidden");
        resetBetForm();
      });
    }
    
    if (cancelBet) {
      cancelBet.addEventListener("click", function() {
        document.getElementById("bet-modal").classList.add("hidden");
        resetBetForm();
      });
    }
    
    // Soumission du formulaire
    if (betForm) {
      betForm.addEventListener("submit", function(e) {
        e.preventDefault();
        
        if (!selectedTeam) {
          showError("Veuillez sélectionner une équipe");
          return;
        }
        
        const betAmount = parseFloat(betAmountInput.value);
        if (isNaN(betAmount) || betAmount <= 0) {
          showError("Veuillez entrer un montant valide");
          return;
        }
        
        const matchId = document.getElementById("bet-match-id").value;
        
        // Créer l'objet pari
        const bet = {
          id: `bet-${Date.now()}`,
          matchId: matchId,
          team: selectedTeam,
          amount: betAmount,
          odds: selectedOdds,
          date: new Date().toISOString(),
          status: "pending"
        };
        
        console.log("Placing bet:", bet);
        
        // Appeler la fonction placeBet si disponible
        if (typeof window.placeBet === "function") {
          window.placeBet(bet);
          alert(`Pari placé avec succès sur ${bet.team} pour ${bet.amount} XOF`);
          document.getElementById("bet-modal").classList.add("hidden");
          resetBetForm();
        } else {
          showError("Erreur: Fonction de pari non disponible");
        }
      });
    }
    
    // Fonctions utilitaires
    function updatePotentialWin() {
      const amount = parseFloat(betAmountInput.value) || 0;
      const potentialWin = amount * (selectedOdds || 0);
      document.getElementById("potential-win").textContent = potentialWin.toFixed(2);
    }
    
    function updatePlaceBetButton() {
      const amount = parseFloat(betAmountInput.value) || 0;
      placeBetBtn.disabled = !selectedTeam || amount <= 0;
    }
    
    function resetBetForm() {
      selectedTeam = null;
      selectedOdds = null;
      if (homeTeamBtn) homeTeamBtn.classList.remove("bg-[#10b981]", "text-white");
      if (awayTeamBtn) awayTeamBtn.classList.remove("bg-[#10b981]", "text-white");
      if (betAmountInput) betAmountInput.value = "";
      document.getElementById("potential-win").textContent = "0.00";
      document.getElementById("bet-error").classList.add("hidden");
      if (placeBetBtn) placeBetBtn.disabled = true;
    }
    
    function showError(message) {
      const errorElement = document.getElementById("bet-error");
      errorElement.textContent = message;
      errorElement.classList.remove("hidden");
    }
    
    // S'assurer que l'état d'authentification est correctement détecté
    if (!window.isUserLoggedIn && window.APP_STATE) {
      window.isUserLoggedIn = function() {
        return window.APP_STATE.isAuthenticated;
      };
    }
    
    // Afficher le message d'authentification si l'utilisateur n'est pas connecté
    const authMessage = document.getElementById('auth-message');
    if (authMessage && !window.isUserLoggedIn()) {
      authMessage.style.display = 'flex';
    }
    
    // Mettre à jour le compteur de matchs
    function updateMatchCount() {
      const matchCount = document.getElementById('match-count');
      const matchList = document.getElementById('match-list');
      if (matchCount && matchList) {
        matchCount.textContent = matchList.children.length;
      }
    }
    
    // Surcharger la fonction renderMatches pour mettre à jour le compteur de matchs
    const originalRenderMatches = window.renderMatches;
    if (typeof originalRenderMatches === 'function') {
      window.renderMatches = function() {
        originalRenderMatches();
        updateMatchCount();
      }
    }
    
    // Initialiser les matchs
    if (typeof window.renderMatches === 'function') {
      window.renderMatches();
    } else {
      console.error("renderMatches function not found!");
    }
  });
</script>
@endsection
