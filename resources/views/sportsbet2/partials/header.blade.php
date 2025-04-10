<!-- Navbar -->
<nav class="bg-[#1e293b] shadow-lg border-b border-[#334155]">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center h-16">
      <div class="flex items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-[#10b981] flex items-center gap-2">
          <i class="fas fa-trophy"></i>
          <span>SportsBet</span>
        </a>
      </div>

      <!-- Desktop Navigation -->
      <div class="hidden md:flex items-center space-x-1">
        <a href="{{ route('home') }}" class="px-3 py-2 rounded-md hover:bg-[#334155] flex items-center gap-2 {{ request()->routeIs('home') ? 'bg-[#334155]' : '' }}">
          <i class="fas fa-home"></i>
          <span>Accueil</span>
        </a>
        <a href="{{ route('matches') }}" class="px-3 py-2 rounded-md hover:bg-[#334155] flex items-center gap-2 {{ request()->routeIs('matches') ? 'bg-[#334155]' : '' }}">
          <i class="fas fa-trophy"></i>
          <span>Matchs</span>
        </a>
        <a href="{{ route('my-bets') }}" class="px-3 py-2 rounded-md hover:bg-[#334155] flex items-center gap-2 {{ request()->routeIs('my-bets') ? 'bg-[#334155]' : '' }}">
          <i class="fas fa-history"></i>
          <span>Mes Paris</span>
        </a>
        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md hover:bg-[#334155] flex items-center gap-2 {{ request()->routeIs('dashboard') ? 'bg-[#334155]' : '' }}">
          <i class="fas fa-chart-line"></i>
          <span>Dashboard</span>
        </a>

        <!-- Recherche -->
        <div class="relative ml-4">
          <div class="flex items-center bg-[#334155] rounded-md">
            <input id="search-input" type="text" placeholder="Rechercher un match..." class="bg-transparent border-none focus:outline-none px-3 py-1 w-48">
            <button class="px-2 text-[#b3b3b3]">
              <i class="fas fa-search"></i>
            </button>
          </div>
          <div id="search-results" class="absolute top-full left-0 mt-1 w-64 bg-[#1e293b] border border-[#334155] rounded-md shadow-lg z-20 hidden"></div>
        </div>

        <!-- Notifications -->
        <div class="relative ml-2">
          <button class="notification-button p-2 rounded-md hover:bg-[#334155] relative">
            <i class="fas fa-bell"></i>
            <span class="notification-count absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center hidden"></span>
          </button>
          <div id="notification-panel" class="absolute top-full right-0 mt-1 w-80 bg-[#1e293b] border border-[#334155] rounded-md shadow-lg z-20 hidden">
            <div id="notification-list">
              <!-- Sera rempli par JavaScript -->
            </div>
          </div>
        </div>

        <div id="user-section" class="flex items-center space-x-4 ml-4">
          <!-- Will be populated by JavaScript -->
        </div>
      </div>

      <!-- Mobile menu button -->
      <div class="md:hidden">
        <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-[#f2f2f2] hover:text-[#10b981] hover:bg-[#334155] focus:outline-none">
          <span class="sr-only">Ouvrir le menu</span>
          <i class="fas fa-bars block h-6 w-6" id="menu-icon"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobile-menu" class="hidden md:hidden bg-[#1e293b] border-t border-[#334155]">
    <div class="px-2 pt-2 pb-3 space-y-1">
      <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-[#334155] {{ request()->routeIs('home') ? 'bg-[#334155]' : '' }}">
        <i class="fas fa-home"></i>
        <span>Accueil</span>
      </a>
      <a href="{{ route('matches') }}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-[#334155] {{ request()->routeIs('matches') ? 'bg-[#334155]' : '' }}">
        <i class="fas fa-trophy"></i>
        <span>Matchs</span>
      </a>
      <a href="{{ route('my-bets') }}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-[#334155] {{ request()->routeIs('my-bets') ? 'bg-[#334155]' : '' }}">
        <i class="fas fa-history"></i>
        <span>Mes Paris</span>
      </a>
      <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-[#334155] {{ request()->routeIs('dashboard') ? 'bg-[#334155]' : '' }}">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span>
      </a>

      <!-- Recherche mobile -->
      <div class="relative py-2">
        <div class="flex items-center bg-[#334155] rounded-md">
          <input id="mobile-search-input" type="text" placeholder="Rechercher un match..." class="bg-transparent border-none focus:outline-none px-3 py-1 w-full">
          <button class="px-2 text-[#b3b3b3]">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <div id="mobile-search-results" class="absolute top-full left-0 right-0 mt-1 bg-[#1e293b] border border-[#334155] rounded-md shadow-lg z-20 hidden"></div>
      </div>

      <!-- Notifications mobile -->
      <div class="flex items-center justify-between px-3 py-2">
        <button class="notification-button flex items-center gap-2 relative">
          <i class="fas fa-bell"></i>
          <span>Notifications</span>
          <span class="notification-count absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center hidden"></span>
        </button>
      </div>

      <div id="mobile-user-section" class="space-y-2 pt-2">
        <!-- Will be populated by JavaScript -->
      </div>
    </div>
  </div>
</nav> 