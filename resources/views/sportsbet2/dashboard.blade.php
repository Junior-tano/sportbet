@extends('sportsbet2.layouts.app')

@section('title', 'Dashboard - SportsBet Simulator')

@section('content')
<h1 class="text-3xl font-bold mb-8">Dashboard</h1>
      
<div id="dashboard" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
  <!-- Will be populated by JavaScript -->
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
  <div class="bg-[#1e293b] rounded-lg border border-[#334155] p-4">
    <h2 class="text-xl font-bold mb-4">Statistiques des paris</h2>
    <div id="bet-stats" class="h-64">
      <!-- Will be populated by JavaScript -->
    </div>
  </div>
  
  <div class="bg-[#1e293b] rounded-lg border border-[#334155] p-4">
    <h2 class="text-xl font-bold mb-4">Matchs à venir</h2>
    <div id="upcoming-matches" class="h-64 overflow-y-auto">
      <!-- Will be populated by JavaScript -->
    </div>
  </div>
</div>

<div class="mt-8 bg-[#1e293b] rounded-lg border border-[#334155] p-4">
  <h2 class="text-xl font-bold mb-4">Activité récente</h2>
  <div id="recent-activity" class="h-64 overflow-y-auto">
    <!-- Will be populated by JavaScript -->
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endsection
