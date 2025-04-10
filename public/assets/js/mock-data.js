// Mock data for matches
const mockMatches = [
  {
    id: "match-1",
    homeTeam: "Paris Saint-Germain",
    awayTeam: "Olympique de Marseille",
    sport: "football",
    date: "2025-04-15T20:00:00Z",
    homeOdds: 1.45,
    awayOdds: 6.5,
    drawOdds: 4.2,
    venue: "Parc des Princes",
    popularity: 95,
  },
  {
    id: "match-2",
    homeTeam: "Real Madrid",
    awayTeam: "FC Barcelone",
    sport: "football",
    date: "2025-04-16T20:00:00Z",
    homeOdds: 2.1,
    awayOdds: 3.2,
    drawOdds: 3.5,
    venue: "Santiago Bernabéu",
    popularity: 98,
  },
  {
    id: "match-3",
    homeTeam: "Los Angeles Lakers",
    awayTeam: "Golden State Warriors",
    sport: "basketball",
    date: "2025-04-14T18:30:00Z",
    homeOdds: 1.9,
    awayOdds: 1.95,
    venue: "Crypto.com Arena",
    popularity: 88,
  },
  {
    id: "match-4",
    homeTeam: "Novak Djokovic",
    awayTeam: "Rafael Nadal",
    sport: "tennis",
    date: "2025-04-17T14:00:00Z",
    homeOdds: 1.75,
    awayOdds: 2.1,
    venue: "Roland Garros",
    popularity: 92,
  },
  {
    id: "match-5",
    homeTeam: "Bayern Munich",
    awayTeam: "Borussia Dortmund",
    sport: "football",
    date: "2025-04-18T19:30:00Z",
    homeOdds: 1.65,
    awayOdds: 4.8,
    drawOdds: 3.9,
    venue: "Allianz Arena",
    popularity: 85,
  },
  {
    id: "match-6",
    homeTeam: "Boston Celtics",
    awayTeam: "Miami Heat",
    sport: "basketball",
    date: "2025-04-19T19:00:00Z",
    homeOdds: 1.7,
    awayOdds: 2.2,
    venue: "TD Garden",
    popularity: 80,
  },
  {
    id: "match-7",
    homeTeam: "Carlos Alcaraz",
    awayTeam: "Daniil Medvedev",
    sport: "tennis",
    date: "2025-04-20T13:00:00Z",
    homeOdds: 1.6,
    awayOdds: 2.4,
    venue: "Wimbledon",
    popularity: 78,
  },
  {
    id: "match-8",
    homeTeam: "Manchester City",
    awayTeam: "Liverpool",
    sport: "football",
    date: "2025-04-21T16:00:00Z",
    homeOdds: 1.9,
    awayOdds: 3.8,
    drawOdds: 3.6,
    venue: "Etihad Stadium",
    popularity: 90,
  },
  {
    id: "match-9",
    homeTeam: "Milwaukee Bucks",
    awayTeam: "Philadelphia 76ers",
    sport: "basketball",
    date: "2025-04-22T20:00:00Z",
    homeOdds: 1.85,
    awayOdds: 2.0,
    venue: "Fiserv Forum",
    popularity: 75,
  },
]

// Helper function to format date
function formatDate(dateString) {
  const date = new Date(dateString)
  return new Intl.DateTimeFormat("fr-FR", {
    day: "numeric",
    month: "short",
    hour: "2-digit",
    minute: "2-digit",
  }).format(date)
}

// Helper function to get match details by ID
function getMatchById(matchId) {
  return mockMatches.find((match) => match.id === matchId)
}

// Helper function to get sport icon
function getSportIcon(sport) {
  switch (sport) {
    case "football":
      return "⚽️"
    case "basketball":
      return "🏀"
    case "tennis":
      return "🎾"
    default:
      return "🏆"
  }
}
