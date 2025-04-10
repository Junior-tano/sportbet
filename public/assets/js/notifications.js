// Système de notifications
let notifications = []

// Initialiser les notifications depuis localStorage
function initNotifications() {
  const savedNotifications = localStorage.getItem("notifications")
  if (savedNotifications) {
    try {
      notifications = JSON.parse(savedNotifications)
    } catch (e) {
      console.error("Erreur lors de la lecture des notifications:", e)
      notifications = []
    }
  }

  renderNotificationCount()
}

// Ajouter une notification
function addNotification(message, type = "info") {
  const notification = {
    id: Date.now(),
    message,
    type,
    date: new Date().toISOString(),
    read: false,
  }

  notifications.unshift(notification)

  // Limiter à 20 notifications
  if (notifications.length > 20) {
    notifications = notifications.slice(0, 20)
  }

  // Sauvegarder dans localStorage
  localStorage.setItem("notifications", JSON.stringify(notifications))

  // Mettre à jour le compteur
  renderNotificationCount()

  return notification
}

// Marquer une notification comme lue
function markNotificationAsRead(id) {
  const notification = notifications.find((n) => n.id === id)
  if (notification) {
    notification.read = true
    localStorage.setItem("notifications", JSON.stringify(notifications))
    renderNotificationCount()
  }
}

// Marquer toutes les notifications comme lues
function markAllNotificationsAsRead() {
  notifications.forEach((notification) => {
    notification.read = true
  })
  localStorage.setItem("notifications", JSON.stringify(notifications))
  renderNotificationCount()
}

// Supprimer une notification
function deleteNotification(id) {
  notifications = notifications.filter((n) => n.id !== id)
  localStorage.setItem("notifications", JSON.stringify(notifications))
  renderNotificationCount()
}

// Afficher le nombre de notifications non lues
function renderNotificationCount() {
  const unreadCount = notifications.filter((n) => !n.read).length
  const notifCountElements = document.querySelectorAll(".notification-count")

  notifCountElements.forEach((element) => {
    if (unreadCount > 0) {
      element.textContent = unreadCount
      element.classList.remove("hidden")
    } else {
      element.classList.add("hidden")
    }
  })
}

// Afficher la liste des notifications
function renderNotifications() {
  const notificationList = document.getElementById("notification-list")
  if (!notificationList) return

  if (notifications.length === 0) {
    notificationList.innerHTML = `
      <div class="p-4 text-center">
        <i class="fas fa-bell-slash text-[#334155] text-2xl mb-2"></i>
        <p class="text-[#b3b3b3]">Aucune notification</p>
      </div>
    `
    return
  }

  notificationList.innerHTML = `
    <div class="p-2 border-b border-[#334155] flex justify-between items-center">
      <h3 class="font-medium">Notifications</h3>
      <button id="mark-all-read" class="text-xs text-[#10b981] hover:underline">Tout marquer comme lu</button>
    </div>
    <div class="max-h-80 overflow-y-auto">
      ${notifications
        .map(
          (notification) => `
        <div class="p-3 border-b border-[#334155] ${notification.read ? "" : "bg-[#1a2332]"}" data-notification-id="${notification.id}">
          <div class="flex justify-between">
            <div class="flex items-start gap-2">
              <div class="mt-1">
                ${getNotificationIcon(notification.type)}
              </div>
              <div>
                <p class="${notification.read ? "text-[#b3b3b3]" : "text-[#f2f2f2]"}">${notification.message}</p>
                <p class="text-xs text-[#b3b3b3] mt-1">${formatNotificationDate(notification.date)}</p>
              </div>
            </div>
            <button class="delete-notification text-[#b3b3b3] hover:text-red-400">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
      `,
        )
        .join("")}
    </div>
  `

  // Ajouter des écouteurs d'événements
  document.getElementById("mark-all-read").addEventListener("click", () => {
    markAllNotificationsAsRead()
    renderNotifications()
  })

  document.querySelectorAll(".delete-notification").forEach((button) => {
    button.addEventListener("click", function (e) {
      e.stopPropagation()
      const notificationId = Number.parseInt(
        this.closest("[data-notification-id]").getAttribute("data-notification-id"),
      )
      deleteNotification(notificationId)
      renderNotifications()
    })
  })

  document.querySelectorAll("[data-notification-id]").forEach((item) => {
    item.addEventListener("click", function () {
      const notificationId = Number.parseInt(this.getAttribute("data-notification-id"))
      markNotificationAsRead(notificationId)
      renderNotifications()
    })
  })
}

// Obtenir l'icône pour le type de notification
function getNotificationIcon(type) {
  switch (type) {
    case "success":
      return '<i class="fas fa-check-circle text-green-500"></i>'
    case "warning":
      return '<i class="fas fa-exclamation-triangle text-yellow-500"></i>'
    case "error":
      return '<i class="fas fa-times-circle text-red-500"></i>'
    default:
      return '<i class="fas fa-info-circle text-blue-500"></i>'
  }
}

// Formater la date de notification
function formatNotificationDate(dateString) {
  const date = new Date(dateString)
  const now = new Date()
  const diffMs = now - date
  const diffSec = Math.floor(diffMs / 1000)
  const diffMin = Math.floor(diffSec / 60)
  const diffHour = Math.floor(diffMin / 60)
  const diffDay = Math.floor(diffHour / 24)

  if (diffSec < 60) {
    return "À l'instant"
  } else if (diffMin < 60) {
    return `Il y a ${diffMin} minute${diffMin > 1 ? "s" : ""}`
  } else if (diffHour < 24) {
    return `Il y a ${diffHour} heure${diffHour > 1 ? "s" : ""}`
  } else if (diffDay < 7) {
    return `Il y a ${diffDay} jour${diffDay > 1 ? "s" : ""}`
  } else {
    return date.toLocaleDateString()
  }
}

// Ajouter une notification pour un pari placé
function notifyBetPlaced(bet) {
  const match = typeof window.mockMatches !== "undefined" ? window.mockMatches.find((m) => m.id === bet.matchId) : null

  let message = `Pari placé sur ${bet.team} pour ${bet.amount} XOF`
  if (match) {
    message = `Pari placé sur ${bet.team} pour le match ${match.homeTeam} vs ${match.awayTeam}`
  }

  addNotification(message, "info")
}

// Ajouter une notification pour un résultat de pari
function notifyBetResult(bet) {
  const match = typeof window.mockMatches !== "undefined" ? window.mockMatches.find((m) => m.id === bet.matchId) : null

  const matchInfo = match ? `${match.homeTeam} vs ${match.awayTeam}` : "un match"
  let message = ""
  let type = ""

  if (bet.status === "won") {
    message = `Vous avez gagné ${(bet.amount * bet.odds).toFixed(2)} XOF sur votre pari pour ${matchInfo}!`
    type = "success"
  } else {
    message = `Vous avez perdu votre pari de ${bet.amount} XOF sur ${matchInfo}.`
    type = "error"
  }

  addNotification(message, type)
}

// Initialiser les notifications au chargement du DOM
document.addEventListener("DOMContentLoaded", () => {
  initNotifications()

  // Ajouter des écouteurs d'événements pour le bouton de notifications
  const notificationButtons = document.querySelectorAll(".notification-button")
  const notificationPanel = document.getElementById("notification-panel")

  if (notificationButtons.length > 0 && notificationPanel) {
    notificationButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        e.stopPropagation()
        notificationPanel.classList.toggle("hidden")
        renderNotifications()
      })
    })

    // Fermer le panneau lorsqu'on clique ailleurs
    document.addEventListener("click", (e) => {
      if (
        !notificationPanel.contains(e.target) &&
        !Array.from(notificationButtons).some((btn) => btn.contains(e.target))
      ) {
        notificationPanel.classList.add("hidden")
      }
    })
  }
})

// Rendre les fonctions disponibles globalement
window.addNotification = addNotification
window.notifyBetPlaced = notifyBetPlaced
window.notifyBetResult = notifyBetResult
window.renderNotifications = renderNotifications
