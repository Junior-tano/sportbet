<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Matchs - SportsBet Simulator</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            background: '#1a2332',
            foreground: '#f2f2f2',
            card: '#1e293b',
            'card-foreground': '#f2f2f2',
            primary: '#10b981',
            'primary-foreground': '#ffffff',
            secondary: '#f59e0b',
            'secondary-foreground': '#1a1a1a',
            muted: '#334155',
            'muted-foreground': '#b3b3b3',
            border: '#334155',
          }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #1a2332;
      color: #f2f2f2;
    }
    .match-card-gradient {
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3)), #1e293b;
      background-size: cover;
      background-position: center;
    }
    .dashboard-card {
      background: linear-gradient(to bottom right, #1e293b, #1a2332);
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
</head>
<body>
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
          <a href="{{ route('home') }}" class="px-3 py-2 rounded-md hover:bg-[#334155] flex items-center gap-2">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
          </a>
          <a href="{{ route('matches') }}" class="px-3 py-2 rounded-md bg-[#334155] flex items-center gap-2">
            <i class="fas fa-trophy"></i>
            <span>Matchs</span>
          </a>
          <a href="{{ route('my-bets') }}" class="px-3 py-2 rounded-md hover:bg-[#334155] flex items-center gap-2">
            <i class="fas fa-history"></i>
            <span>Mes Paris</span>
          </a>
          <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md hover:bg-[#334155] flex items-center gap-2">
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
        <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-[#334155]">
          <i class="fas fa-home"></i>
          <span>Accueil</span>
        </a>
        <a href="{{ route('matches') }}" class="flex items-center gap-2 px-3 py-2 rounded-md bg-[#334155]">
          <i class="fas fa-trophy"></i>
          <span>Matchs</span>
        </a>
        <a href="{{ route('my-bets') }}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-[#334155]">
          <i class="fas fa-history"></i>
          <span>Mes Paris</span>
        </a>
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-[#334155]">
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

  <!-- Main Content -->
  <main class="min-h-screen bg-[#1a2332]">
    <div class="container mx-auto px-4 py-8">
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
    </div>
  </main>

  <!-- Bet Form Modal -->
  <div id="bet-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-md relative">
      <button id="close-bet-modal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
        <i class="fas fa-times h-6 w-6"></i>
      </button>

      <h2 id="bet-modal-title" class="text-2xl font-bold mb-6">Placer un pari</h2>

      <div id="bet-error" class="bg-red-900/20 border border-red-900/50 text-red-400 px-4 py-3 rounded mb-4 hidden"></div>

      <form id="bet-form">
        <input type="hidden" id="bet-match-id">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-2">Sélectionnez une équipe</label>
            <div class="grid grid-cols-2 gap-2">
              <button type="button" id="home-team-btn" class="w-full px-4 py-2 border border-[#334155] rounded-md text-center hover:bg-[#10b981] hover:text-white"></button>
              <button type="button" id="away-team-btn" class="w-full px-4 py-2 border border-[#334155] rounded-md text-center hover:bg-[#10b981] hover:text-white"></button>
            </div>
          </div>

          <div>
            <label for="bet-amount" class="block text-sm font-medium mb-1">Montant (XOF)</label>
            <input id="bet-amount" type="number" min="1" step="1" class="w-full px-3 py-2 bg-[#334155] text-[#f2f2f2] border border-[#334155] rounded-md focus:outline-none focus:ring-2 focus:ring-[#10b981]" placeholder="Montant du pari" required>
          </div>

          <div class="grid grid-cols-2 gap-2">
            <button type="button" id="cancel-bet" class="px-4 py-2 border border-[#334155] rounded-md hover:bg-[#334155]">
              Annuler
            </button>
            <button type="submit" class="bg-[#f59e0b] hover:bg-[#f59e0b]/90 text-[#1a1a1a] font-medium py-2 px-4 rounded-md">
              Parier
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
  <script>
    // Define Chart globally for dashboard.js
    window.Chart = Chart;
  </script>
  @vite(['resources/js/ui.js', 'resources/js/auth.js', 'resources/js/bets.js', 'resources/js/matches.js', 'resources/js/search.js', 'resources/js/notifications.js'])
</body>
</html>
