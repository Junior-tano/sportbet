@extends('sportsbet2.layouts.app')

@section('title', 'Détails du match')

@section('content')
<div class="max-w-4xl mx-auto">
  <div class="mb-6">
    <a href="{{ route('matches') }}" class="flex items-center text-sm text-[#10b981] hover:underline">
      <i class="fas fa-arrow-left mr-2"></i> Retour aux matchs
    </a>
  </div>

  <div class="bg-[#1e293b] rounded-lg shadow-lg overflow-hidden">
    <div class="p-6 border-b border-[#334155]">
      <h1 class="text-2xl font-bold" id="match-title">Chargement des détails du match...</h1>
      <div class="flex items-center gap-2 text-sm text-[#b3b3b3] mt-2">
        <i class="fas fa-clock"></i>
        <span id="match-date">--/--/---- --:--</span>
      </div>
      <div class="flex items-center gap-2 text-sm text-[#b3b3b3] mt-1">
        <i class="fas fa-map-marker-alt"></i>
        <span id="match-venue">Chargement...</span>
      </div>
    </div>

    <div class="p-6">
      <div class="flex items-center gap-4 justify-center py-8">
        <div class="text-center flex-1">
          <h2 class="text-xl font-bold mb-2" id="home-team">Équipe domicile</h2>
          <div class="text-3xl font-bold text-[#10b981]" id="home-odds">-.--</div>
        </div>
        
        <div class="text-center px-4 py-2 bg-[#334155] rounded-lg">
          <span class="text-sm">VS</span>
        </div>
        
        <div class="text-center flex-1">
          <h2 class="text-xl font-bold mb-2" id="away-team">Équipe extérieure</h2>
          <div class="text-3xl font-bold text-[#10b981]" id="away-odds">-.--</div>
        </div>
      </div>

      <div class="mt-8">
        <button id="bet-now-btn" class="w-full bg-[#f59e0b] hover:bg-[#f59e0b]/90 text-[#1a1a1a] font-medium py-3 px-4 rounded-md requires-auth">
          Parier maintenant
        </button>
      </div>
    </div>
  </div>

  <div class="mt-8 bg-[#1e293b] rounded-lg shadow-lg overflow-hidden">
    <div class="p-6 border-b border-[#334155]">
      <h2 class="text-xl font-bold">Statistiques</h2>
    </div>
    
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <span>Popularité</span>
        <div class="w-64 bg-[#334155] rounded-full h-2.5">
          <div id="popularity-bar" class="bg-[#f59e0b] h-2.5 rounded-full" style="width: 0%"></div>
        </div>
      </div>
      
      <div class="grid grid-cols-3 gap-4 text-center">
        <div class="bg-[#334155] p-4 rounded-lg">
          <div class="text-sm text-[#b3b3b3]">Cote domicile</div>
          <div class="text-xl font-bold text-[#10b981]" id="stat-home-odds">-.--</div>
        </div>
        <div class="bg-[#334155] p-4 rounded-lg">
          <div class="text-sm text-[#b3b3b3]">Match nul</div>
          <div class="text-xl font-bold text-[#10b981]" id="stat-draw-odds">-.--</div>
        </div>
        <div class="bg-[#334155] p-4 rounded-lg">
          <div class="text-sm text-[#b3b3b3]">Cote extérieur</div>
          <div class="text-xl font-bold text-[#10b981]" id="stat-away-odds">-.--</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const matchId = "{{ $matchId }}";
    
    // Charger les détails du match depuis l'API ou utiliser les données mockées
    async function loadMatchDetails() {
      try {
        const response = await axios.get(`/api/matches/${matchId}`);
        if (response.data) {
          updateMatchUI(response.data);
          return;
        }
      } catch (error) {
        console.error("Erreur lors du chargement des détails du match:", error);
      }
      
      // Si l'API échoue, rechercher dans les données mockées
      if (window.mockMatches) {
        const match = window.mockMatches.find(m => m.id === matchId);
        if (match) {
          updateMatchUI(match);
          return;
        }
      }
      
      // Si aucune donnée n'est trouvée
      alert("Match non trouvé");
      window.location.href = "{{ route('matches') }}";
    }
    
    function updateMatchUI(match) {
      // Mettre à jour les informations du match
      document.getElementById('match-title').textContent = `${match.homeTeam} vs ${match.awayTeam}`;
      document.getElementById('match-date').textContent = new Date(match.date).toLocaleString('fr-FR');
      document.getElementById('match-venue').textContent = match.venue;
      
      document.getElementById('home-team').textContent = match.homeTeam;
      document.getElementById('away-team').textContent = match.awayTeam;
      
      document.getElementById('home-odds').textContent = match.homeOdds.toFixed(2);
      document.getElementById('away-odds').textContent = match.awayOdds.toFixed(2);
      
      document.getElementById('stat-home-odds').textContent = match.homeOdds.toFixed(2);
      document.getElementById('stat-away-odds').textContent = match.awayOdds.toFixed(2);
      
      // Match nul (peut être null pour certains sports)
      if (match.drawOdds) {
        document.getElementById('stat-draw-odds').textContent = match.drawOdds.toFixed(2);
      } else {
        document.getElementById('stat-draw-odds').textContent = '-';
      }
      
      // Popularité
      document.getElementById('popularity-bar').style.width = `${match.popularity}%`;
      
      // Configurer le bouton de pari
      const betButton = document.getElementById('bet-now-btn');
      if (betButton) {
        betButton.addEventListener('click', function() {
          if (typeof window.openBetModal === 'function') {
            window.openBetModal(matchId);
          }
        });
      }
    }
    
    // Charger les détails du match
    loadMatchDetails();
  });
</script>
@endsection 