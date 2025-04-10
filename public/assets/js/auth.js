// Authentication management for SportBet
document.addEventListener("DOMContentLoaded", function() {
  // Configuration pour les requêtes AJAX
  window.setupCSRFToken = function() {
    // Récupérer le token CSRF depuis les meta tags
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Configurer les en-têtes par défaut pour axios ou fetch
    if (window.axios) {
      window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    }
    
    return token;
  };
  
  // Initialiser le token CSRF
  window.csrfToken = window.setupCSRFToken();

  // Définir la fonction pour vérifier si l'utilisateur est authentifié
  window.isUserLoggedIn = function() {
    // D'abord vérifier si l'état d'authentification est exposé par le serveur
    if (window.APP_STATE && typeof window.APP_STATE.isAuthenticated !== 'undefined') {
      return window.APP_STATE.isAuthenticated;
    }
    
    // Fallback: Vérifie si l'élément avec classe 'auth-user' existe dans le header
    return document.querySelector('.auth-user') !== null;
  };

  // Redirection vers la page de connexion pour les utilisateurs non authentifiés
  window.toggleAuth = function() {
    if (!window.isUserLoggedIn()) {
      window.location.href = '/login';
      return false;
    }
    return true;
  };

  // Vérifier que les éléments nécessitant l'authentification sont protégés
  const protectedButtons = document.querySelectorAll('.requires-auth');
  protectedButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      if (!window.isUserLoggedIn()) {
        e.preventDefault();
        window.toggleAuth();
        return false;
      }
    });
  });
  
  // Gérer les boutons "login-to-bet"
  const loginToBetButtons = document.querySelectorAll('.login-to-bet');
  loginToBetButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      window.location.href = '/login';
    });
  });
  
  // Ajouter la classe requires-auth à tous les boutons de pari
  const betButtons = document.querySelectorAll('.bet-button');
  betButtons.forEach(button => {
    button.classList.add('requires-auth');
  });
  
  // Afficher un message d'avertissement dans la console si un utilisateur non connecté tente d'utiliser les fonctionnalités protégées
  console.log("État d'authentification :", window.isUserLoggedIn() ? "Connecté" : "Non connecté");
  if (!window.isUserLoggedIn()) {
    console.log("Vous devez être connecté pour parier. Certaines fonctionnalités sont désactivées.");
  }
}); 