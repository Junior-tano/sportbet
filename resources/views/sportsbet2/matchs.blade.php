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
<h1 class="text-3xl font-bold mb-8">Matchs à venir</h1>

<div id="match-filters" class="flex flex-col md:flex-row justify-between mb-4 gap-4">
  <div class="flex flex-wrap gap-2">
    <button class="filter-btn text-sm px-4 py-2 rounded-md bg-[#10b981] text-white" data-filter="all">Tous</button>
    <button class="filter-btn text-sm px-4 py-2 rounded-md bg-transparent border border-[#334155] hover:bg-[#334155]" data-filter="football">Football</button>
    <button class="filter-btn text-sm px-4 py-2 rounded-md bg-transparent border border-[#334155] hover:bg-[#334155]" data-filter="basketball">Basketball</button>
    <button class="filter-btn text-sm px-4 py-2 rounded-md bg-transparent border border-[#334155] hover:bg-[#334155]" data-filter="tennis">Tennis</button>
  </div>
  <div class="w-full md:w-48">
    <select id="sort-select" class="w-full px-4 py-2 rounded-md bg-[#334155] text-[#f2f2f2] border border-[#334155] focus:outline-none focus:ring-2 focus:ring-[#10b981]">
      <option value="date">Trier par date</option>
      <option value="popularity">Trier par popularité</option>
    </select>
  </div>
</div>

<div id="match-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
  <!-- Will be populated by JavaScript -->
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
    
    // Définir isUserLoggedIn pour les tests
    window.isUserLoggedIn = function() {
      return true; // Toujours retourner true pour les tests
    };
    
    // Initialiser les matchs
    if (typeof window.renderMatches === 'function') {
      window.renderMatches();
    } else {
      console.error("renderMatches function not found!");
    }
  });
</script>
@endsection
