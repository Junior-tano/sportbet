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
@endsection

@section('scripts')
<script src="{{ asset('assets/js/matches.js') }}"></script>
@endsection
