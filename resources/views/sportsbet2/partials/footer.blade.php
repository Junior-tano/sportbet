<!-- Footer -->
<footer class="bg-[#1e293b] shadow-lg border-t border-[#334155] py-6">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <div>
        <h3 class="text-lg font-bold mb-4 text-[#10b981]">SportsBet</h3>
        <p class="text-[#b3b3b3] text-sm mb-4">
          Plateforme de paris sportifs virtuelle. Pariez sur vos équipes préférées sans risquer votre argent réel.
        </p>
        <div class="flex space-x-4">
          <a href="#" class="text-[#f2f2f2] hover:text-[#10b981]">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="text-[#f2f2f2] hover:text-[#10b981]">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="text-[#f2f2f2] hover:text-[#10b981]">
            <i class="fab fa-instagram"></i>
          </a>
        </div>
      </div>
      
      <div>
        <h3 class="text-lg font-bold mb-4 text-[#f2f2f2]">Liens Rapides</h3>
        <ul class="space-y-2">
          <li><a href="{{ route('home') }}" class="text-[#b3b3b3] hover:text-[#10b981]">Accueil</a></li>
          <li><a href="{{ route('matches') }}" class="text-[#b3b3b3] hover:text-[#10b981]">Matchs</a></li>
          <li><a href="{{ route('my.bets') }}" class="text-[#b3b3b3] hover:text-[#10b981]">Mes Paris</a></li>
          <li><a href="{{ route('dashboard') }}" class="text-[#b3b3b3] hover:text-[#10b981]">Dashboard</a></li>
        </ul>
      </div>
      
      <div>
        <h3 class="text-lg font-bold mb-4 text-[#f2f2f2]">Sports</h3>
        <ul class="space-y-2">
          <li><a href="{{ route('matches') }}?sport=football" class="text-[#b3b3b3] hover:text-[#10b981]">Football</a></li>
          <li><a href="{{ route('matches') }}?sport=basketball" class="text-[#b3b3b3] hover:text-[#10b981]">Basketball</a></li>
          <li><a href="{{ route('matches') }}?sport=tennis" class="text-[#b3b3b3] hover:text-[#10b981]">Tennis</a></li>
        </ul>
      </div>
      
      <div>
        <h3 class="text-lg font-bold mb-4 text-[#f2f2f2]">Contact</h3>
        <ul class="space-y-2 text-[#b3b3b3]">
          <li class="flex items-center gap-2">
            <i class="fas fa-envelope text-[#10b981]"></i>
            <span>contact@sportsbet.com</span>
          </li>
          <li class="flex items-center gap-2">
            <i class="fas fa-phone text-[#10b981]"></i>
            <span>+33 1 23 45 67 89</span>
          </li>
        </ul>
      </div>
    </div>
    
    <div class="border-t border-[#334155] mt-8 pt-6 text-center text-[#b3b3b3] text-sm">
      <p>&copy; {{ date('Y') }} SportsBet. Tous droits réservés.</p>
      <p class="mt-2">Ce site est fourni à des fins de divertissement uniquement. Les paris ne sont pas réels.</p>
    </div>
  </div>
</footer>

<!-- Bet Modal (For all pages) -->
<div id="bet-modal" class="fixed inset-0 z-50 hidden">
  <div class="absolute inset-0 bg-black bg-opacity-50"></div>
  <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#1e293b] rounded-lg p-6 w-full max-w-md">
    <h3 id="bet-modal-title" class="text-xl font-bold mb-4">Placer un pari</h3>
    <div id="bet-error" class="bg-red-500 bg-opacity-20 border border-red-500 text-red-500 rounded p-2 mb-4 hidden"></div>
    
    <form id="bet-form">
      <input type="hidden" id="bet-match-id" value="">
      <input type="hidden" id="bet-selection" value="">
      
      <p class="mb-4">Sélectionnez votre pronostic:</p>
      <div class="flex gap-2 mb-4">
        <button type="button" id="home-team-btn" class="flex-1 py-2 px-3 bg-[#334155] hover:bg-[#3a4a63] rounded-md transition-colors" onclick="selectTeam('home')"></button>
        <button type="button" id="away-team-btn" class="flex-1 py-2 px-3 bg-[#334155] hover:bg-[#3a4a63] rounded-md transition-colors" onclick="selectTeam('away')"></button>
      </div>
      
      <div class="mb-4">
        <label for="bet-amount" class="block mb-2">Montant du pari (XOF):</label>
        <input type="number" id="bet-amount" class="w-full bg-[#334155] rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-[#10b981]" min="1" step="1" required>
      </div>
      
      <div class="mb-4">
        <p>Gain potentiel: <span id="potential-win">0.00</span> XOF</p>
      </div>
      
      <div class="flex justify-end space-x-2 mt-6">
        <button type="button" class="py-2 px-4 bg-[#334155] hover:bg-[#3a4a63] rounded-md" onclick="closeModal('bet-modal')">Annuler</button>
        <button type="button" id="place-bet-btn" class="py-2 px-4 bg-[#10b981] hover:bg-[#0ea573] text-white rounded-md" onclick="placeBet()" disabled>Parier</button>
      </div>
    </form>
  </div>
</div> 