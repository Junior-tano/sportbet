<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mes Paris - SportsBet Simulator</title>
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
    .dashboard-card {
      background: linear-gradient(to bottom right, #1e293b, #1a2332);
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
          <a href="{{ route('matches') }}" class="px-3 py-2 rounded-md hover:bg-[#334155] flex items-center gap-2">
            <i class="fas fa-trophy"></i>
            <span>Matchs</span>
          </a>
          <a href="{{ route('my-bets') }}" class="px-3 py-2 rounded-md bg-[#334155] flex items-center gap-2">
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
        <a href="{{ route('matches') }}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-[#334155]">
          <i class="fas fa-trophy"></i>
          <span>Matchs</span>
        </a>
        <a href="{{ route('my-bets') }}" class="flex items-center gap-2 px-3 py-2 rounded-md bg-[#334155]">
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
      <h1 class="text-3xl font-bold mb-8">Mes Paris</h1>

      <div id="bet-history-container">
        <!-- Will be populated by JavaScript -->
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
  <script>
    // Define Chart globally for dashboard.js
    window.Chart = Chart;
  </script>
  @vite(['resources/js/ui.js', 'resources/js/auth.js', 'resources/js/bets.js', 'resources/js/matches.js', 'resources/js/bet-history.js', 'resources/js/search.js', 'resources/js/notifications.js'])
</body>
</html>
