// Simplified auth management with toggle
let isLoggedIn = true // Changé à true par défaut pour que l'utilisateur soit connecté

// Initialize auth state from localStorage
function initAuth() {
  const savedState = localStorage.getItem("isLoggedIn")
  if (savedState === "true") {
    isLoggedIn = true
  } else if (savedState === "false") {
    isLoggedIn = false
  } else {
    // Si aucun état n'est sauvegardé, on définit l'utilisateur comme connecté par défaut
    localStorage.setItem("isLoggedIn", "true")
  }
  updateAuthUI()
}

// Toggle login state
function toggleAuth() {
  isLoggedIn = !isLoggedIn

  // Save to localStorage for persistence
  localStorage.setItem("isLoggedIn", isLoggedIn.toString())

  // Update UI
  updateAuthUI()

  // Refresh the page to update all components
  location.reload()
}

// Update UI based on auth state
function updateAuthUI() {
  const userSectionDesktop = document.getElementById("user-section")
  const userSectionMobile = document.getElementById("mobile-user-section")

  if (!userSectionDesktop || !userSectionMobile) return

  if (isLoggedIn) {
    // Desktop
    userSectionDesktop.innerHTML = `
      <div class="flex items-center gap-2 bg-[#334155] px-3 py-2 rounded-md">
        <i class="fas fa-user text-[#10b981]"></i>
        <span>Utilisateur</span>
      </div>
      <button id="auth-toggle-btn" class="border border-[#10b981] text-[#10b981] px-4 py-2 rounded-md hover:bg-[#10b981] hover:text-white">
        Déconnexion
      </button>
    `

    // Mobile
    userSectionMobile.innerHTML = `
      <div class="px-3 py-2 flex items-center gap-2 bg-[#334155] rounded-md">
        <i class="fas fa-user text-[#10b981]"></i>
        <span>Utilisateur</span>
      </div>
      <button id="mobile-auth-toggle-btn" class="w-full border border-[#10b981] text-[#10b981] px-4 py-2 rounded-md hover:bg-[#10b981] hover:text-white">
        Déconnexion
      </button>
    `
  } else {
    // Desktop
    userSectionDesktop.innerHTML = `
      <button id="auth-toggle-btn" class="bg-[#10b981] text-white px-4 py-2 rounded-md hover:bg-[#10b981]/90">
        Connexion
      </button>
    `

    // Mobile
    userSectionMobile.innerHTML = `
      <button id="mobile-auth-toggle-btn" class="w-full bg-[#10b981] text-white px-4 py-2 rounded-md hover:bg-[#10b981]/90">
        Connexion
      </button>
    `
  }

  // Add event listeners to toggle buttons
  const authToggleBtn = document.getElementById("auth-toggle-btn")
  const mobileAuthToggleBtn = document.getElementById("mobile-auth-toggle-btn")

  if (authToggleBtn) {
    authToggleBtn.addEventListener("click", toggleAuth)
  }

  if (mobileAuthToggleBtn) {
    mobileAuthToggleBtn.addEventListener("click", toggleAuth)
  }
}

// Function to check if user is logged in
function isUserLoggedIn() {
  return isLoggedIn
}

// Initialize auth when DOM is loaded
document.addEventListener("DOMContentLoaded", initAuth)

// Make functions globally available
window.isUserLoggedIn = isUserLoggedIn
window.toggleAuth = toggleAuth
