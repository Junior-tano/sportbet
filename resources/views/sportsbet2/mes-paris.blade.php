@extends('sportsbet2.layouts.app')

@section('title', 'Mes Paris - SportsBet Simulator')

@section('content')
<h1 class="text-3xl font-bold mb-8">Mes Paris</h1>

<div id="bet-history-container">
  <!-- Will be populated by JavaScript -->
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/bet-history.js') }}"></script>
@endsection
