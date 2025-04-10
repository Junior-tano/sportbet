@extends('sportsbet2.layouts.app')

@section('title', 'SportsBet Simulator')

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
<div class="relative overflow-hidden">
  <div class="absolute inset-0 z-0 opacity-20" style="background-color: #0f172a;"></div>
  <div class="relative z-10">
    <div class="flex flex-col items-center justify-center py-12 text-center">
      <h1 class="mb-2 text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl">
        SportsBet <span class="text-[#10b981]">Simulator</span>
      </h1>
      <p class="mb-8 max-w-2xl text-lg text-[#b3b3b3]">
        Vivez l'excitation des paris sportifs sans risque financier
      </p>
      <div class="flex flex-wrap justify-center gap-6">
        <div class="flex items-center gap-2">
          <i class="fas fa-trophy text-[#f59e0b]"></i>
          <span class="text-lg font-medium">Matchs Premium</span>
        </div>
        <div class="flex items-center gap-2">
          <i class="fas fa-chart-line text-[#f59e0b]"></i>
          <span class="text-lg font-medium">Cotes en Direct</span>
        </div>
        <div class="flex items-center gap-2">
          <i class="fas fa-bolt text-[#f59e0b]"></i>
          <span class="text-lg font-medium">Résultats Instantanés</span>
        </div>
      </div>
    </div>

    <!-- Dashboard -->
    <div id="dashboard" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
      <!-- Will be populated by JavaScript -->
    </div>

    <!-- Featured Matches -->
    <div class="mt-16">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold mb-2">Matchs Populaires</h2>
        <p class="text-[#b3b3b3]">Placez vos paris sur les matchs les plus attendus</p>
      </div>

      <div id="featured-matches" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Les cartes de match seront chargées dynamiquement par JavaScript -->
        <div class="animate-pulse bg-[#1e293b] rounded-lg p-4">
          <div class="h-40 bg-[#334155] rounded-md mb-4"></div>
          <div class="h-6 bg-[#334155] rounded w-3/4 mb-2"></div>
          <div class="h-4 bg-[#334155] rounded w-1/2 mb-4"></div>
          <div class="h-8 bg-[#334155] rounded w-full"></div>
        </div>
        <div class="animate-pulse bg-[#1e293b] rounded-lg p-4">
          <div class="h-40 bg-[#334155] rounded-md mb-4"></div>
          <div class="h-6 bg-[#334155] rounded w-3/4 mb-2"></div>
          <div class="h-4 bg-[#334155] rounded w-1/2 mb-4"></div>
          <div class="h-8 bg-[#334155] rounded w-full"></div>
        </div>
        <div class="animate-pulse bg-[#1e293b] rounded-lg p-4">
          <div class="h-40 bg-[#334155] rounded-md mb-4"></div>
          <div class="h-6 bg-[#334155] rounded w-3/4 mb-2"></div>
          <div class="h-4 bg-[#334155] rounded w-1/2 mb-4"></div>
          <div class="h-8 bg-[#334155] rounded w-full"></div>
        </div>
      </div>

      <div class="text-center mt-8">
        <a href="{{ route('matches') }}" class="inline-block bg-[#10b981] hover:bg-[#10b981]/90 text-white font-medium py-3 px-6 rounded-md">
          Voir tous les matchs
        </a>
      </div>
    </div>

    <!-- User Stats -->
    <div class="mt-16 bg-[#1e293b] rounded-lg shadow-lg p-6 border border-[#334155]">
      <h2 class="text-2xl font-bold mb-6">Vos Statistiques</h2>
      <div id="user-stats" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Will be populated by JavaScript -->
      </div>
    </div>

    <!-- Recent Bets -->
    <div class="mt-16">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Paris Récents</h2>
        <a href="{{ route('my.bets') }}" class="flex items-center text-[#10b981] hover:underline">
          <span>Voir tous les paris</span>
          <i class="fas fa-arrow-right ml-2"></i>
        </a>
      </div>
      <div id="recent-bets" class="overflow-x-auto">
        <!-- Will be populated by JavaScript -->
      </div>
    </div>

    <!-- CTA Section -->
    <div class="mt-16 mb-12 bg-gradient-to-r from-[#10b981] to-[#059669] rounded-lg shadow-lg p-8 text-white">
      <div class="flex flex-col md:flex-row items-center justify-between">
        <div class="mb-6 md:mb-0">
          <h2 class="text-2xl font-bold mb-2">Prêt à commencer ?</h2>
          <p class="text-white text-opacity-80">Inscrivez-vous et recevez 1000XOF virtuels pour commencer à parier</p>
        </div>
        <a href="{{ route('register') }}" class="bg-white text-[#10b981] font-bold py-3 px-6 rounded-md hover:bg-opacity-90 transition-colors login-hover-effect">
          Créer un compte
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/mock-data.js') }}"></script>
<script src="{{ asset('assets/js/matches.js') }}"></script>
<script src="{{ asset('assets/js/bets.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Initialiser les matchs du backend
  window.mockMatches = {!! $matchesJson !!};
  console.log("Index page loaded, matches data:", window.mockMatches);
  
  // S'assurer que l'état d'authentification est correctement détecté
  if (!window.isUserLoggedIn && window.APP_STATE) {
    window.isUserLoggedIn = function() {
      return window.APP_STATE.isAuthenticated;
    };
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
