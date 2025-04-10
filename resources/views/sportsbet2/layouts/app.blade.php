<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'SportsBet Simulator')</title>
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
    
    /* Styles pour les boutons désactivés */
    button:disabled {
      cursor: not-allowed;
      opacity: 0.7;
    }
    
    /* Animation de surbrillance pour le bouton de connexion au survol */
    .login-hover-effect {
      transition: all 0.3s ease;
    }
    
    .login-hover-effect:hover {
      transform: scale(1.05);
      box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
    }
  </style>
  @yield('styles')
</head>
<body>
  @include('sportsbet2.partials.header')

  <!-- Main Content -->
  <main class="min-h-screen bg-[#1a2332]">
    <div class="container mx-auto px-4 py-8">
      @yield('content')
    </div>
  </main>

  @include('sportsbet2.partials.footer')

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
  <script>
    // Define Chart globally
    window.Chart = Chart;
    
    // Exposer l'état d'authentification à JavaScript
    window.APP_STATE = {
      isAuthenticated: @json(auth()->check()),
      @auth
      user: {
        id: @json(auth()->user()->id),
        name: @json(auth()->user()->name)
      }
      @else
      user: null
      @endauth
    };
  </script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="{{ asset('assets/js/ui.js') }}"></script>
  <script src="{{ asset('assets/js/auth.js') }}"></script>
  <script src="{{ asset('assets/js/bets.js') }}"></script>
  <script src="{{ asset('assets/js/search.js') }}"></script>
  <script src="{{ asset('assets/js/notifications.js') }}"></script>
  <script src="{{ asset('assets/js/matches.js') }}"></script>
  @yield('scripts')
</body>
</html> 