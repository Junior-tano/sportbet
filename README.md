# SportBet - Plateforme de Paris Sportifs

SportBet est une application web moderne de paris sportifs développée avec Laravel et JavaScript. Elle permet aux utilisateurs de consulter des matchs sportifs à venir, de placer des paris et de suivre leurs résultats dans une interface élégante et responsive.

## Fonctionnalités principales

- **Consultation des matchs** : Affichage des matchs à venir avec filtrage par sport
- **Paris sportifs** : Possibilité de parier sur les matchs avec différentes cotes
- **Authentification** : Système complet d'authentification avec Laravel Breeze
- **Tableau de bord** : Interface de suivi des paris et des matchs pour les utilisateurs connectés
- **API RESTful** : API pour récupérer les données des matchs et gérer les paris
- **Responsive design** : Interface adaptée à tous les appareils (mobile, tablette, desktop)

## Technologies utilisées

- **Backend** : Laravel 10.x
- **Frontend** : HTML, CSS, JavaScript, TailwindCSS
- **Base de données** : MySQL
- **Authentification** : Laravel Breeze
- **Bibliothèques JS** : AlpineJS, Chart.js, Axios

## Installation

### Prérequis

- PHP 8.1 ou supérieur
- Composer
- MySQL ou MariaDB
- Serveur web (Apache, Nginx) ou serveur de développement PHP

### Étapes d'installation

1. Cloner le dépôt
   ```bash
   git clone https://github.com/votre-username/sportbet.git
   cd sportbet
   ```

2. Installer les dépendances
   ```bash
   composer install
   ```

3. Configurer l'environnement
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configurer la base de données dans le fichier `.env`
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sportbet
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Exécuter les migrations et les seeders
   ```bash
   php artisan migrate --seed
   ```

6. Démarrer le serveur de développement
   ```bash
   php artisan serve
   ```

7. Accéder à l'application via `http://localhost:8000`

## Commandes utiles

### Commandes de base Laravel

```bash
# Démarrer le serveur de développement
php artisan serve

# Lister toutes les routes disponibles
php artisan route:list

# Créer un contrôleur
php artisan make:controller NomController

# Créer un modèle avec migration
php artisan make:model Nom -m

# Créer un middleware
php artisan make:middleware NomMiddleware

# Exécuter les migrations
php artisan migrate

# Annuler les migrations
php artisan migrate:rollback

# Rafraîchir les migrations (rollback + migrate)
php artisan migrate:refresh

# Exécuter les seeders
php artisan db:seed

# Rafraîchir les migrations et exécuter les seeders
php artisan migrate:refresh --seed
```

### Commandes pour la maintenance

```bash
# Nettoyer les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear  # Exécute toutes les commandes clear ci-dessus

# Générer des clés pour l'application
php artisan key:generate

# Mettre l'application en mode maintenance
php artisan down

# Remettre l'application en ligne
php artisan up

# Lister les tâches planifiées
php artisan schedule:list

# Exécuter les tâches planifiées
php artisan schedule:run
```

### Commandes spécifiques au projet

```bash
# Installer Laravel Breeze pour l'authentification
composer require laravel/breeze --dev
php artisan breeze:install blade

# Créer un utilisateur admin via Tinker
php artisan tinker
>>> $user = App\Models\User::find(1); // Ou create un nouveau
>>> $user->role = 'admin';
>>> $user->save();
>>> exit;

# Générer des matchs de démonstration
php artisan db:seed --class=MatchesTableSeeder
```

## Structure du projet

```
sportbet/
├── app/                  # Code source de l'application
│   ├── Http/             # Contrôleurs, Middleware, etc.
│   ├── Models/           # Modèles Eloquent
│   └── Providers/        # Service providers
├── config/               # Fichiers de configuration
├── database/             # Migrations et seeders
├── public/               # Fichiers publics
│   ├── assets/           # CSS, JS et images
│   └── index.php         # Point d'entrée
├── resources/            # Vues et assets non compilés
│   ├── views/            # Templates Blade
│   │   └── sportsbet2/   # Templates spécifiques à l'application
├── routes/               # Définitions des routes
│   ├── api.php           # Routes API
│   └── web.php           # Routes web
└── README.md             # Ce fichier
```

## Routes principales

### Routes Web

- `/` - Page d'accueil
- `/matches` - Liste des matchs disponibles
- `/matches/{id}` - Détails d'un match spécifique
- `/my-bets` - Liste des paris de l'utilisateur (authentification requise)
- `/dashboard` - Tableau de bord de l'utilisateur (authentification requise)
- `/login` - Page de connexion
- `/register` - Page d'inscription

### Routes API

- `GET /api/matches` - Récupérer tous les matchs
- `GET /api/matches/{id}` - Récupérer un match spécifique
- `GET /api/sports` - Récupérer tous les sports
- `GET /api/teams` - Récupérer toutes les équipes
- `GET /api/bets` - Récupérer les paris de l'utilisateur connecté
- `POST /api/bets` - Créer un nouveau pari

## Authentification

L'application utilise Laravel Breeze pour l'authentification. Les fonctionnalités incluent :

- Inscription d'utilisateur
- Connexion/déconnexion
- Réinitialisation de mot de passe
- Vérification d'email
- Protection des routes sensibles

Pour accéder aux fonctionnalités de paris, l'utilisateur doit être connecté. L'état d'authentification est disponible côté JavaScript via la variable globale `APP_STATE.isAuthenticated`.

## Administration

Pour accéder au panel d'administration, un utilisateur doit avoir le rôle 'admin'. Vous pouvez définir un administrateur en modifiant le champ 'role' d'un utilisateur dans la base de données :

```sql
UPDATE users SET role = 'admin' WHERE email = 'admin@example.com';
```

## Développement

### Styles et JavaScript

Les assets sont gérés principalement via CDN (TailwindCSS, Alpine.js, etc.) pour simplifier le développement.

Les scripts JavaScript spécifiques à l'application se trouvent dans le dossier `public/assets/js/` :
- `auth.js` - Gestion de l'authentification
- `matches.js` - Gestion de l'affichage des matchs et du filtrage
- `bets.js` - Gestion des paris
- `ui.js` - Composants d'interface utilisateur

### Extensions et personnalisation

Pour ajouter de nouveaux sports ou types de paris :
1. Créer les migrations nécessaires
2. Mettre à jour les modèles correspondants
3. Ajouter les données via les seeders
4. Mettre à jour l'interface utilisateur pour refléter les nouvelles options

## Dépannage

### Problèmes courants

- **Erreur de route** : Exécutez `php artisan route:clear` et `php artisan cache:clear`
- **Problèmes d'authentification** : Vérifiez les configurations dans `config/auth.php`
- **Problèmes de base de données** : Vérifiez votre configuration `.env` et assurez-vous que les migrations sont à jour

## Licence

Ce projet est sous licence [MIT](LICENSE).

## Crédits

Développé par [Votre Nom] pour [Entreprise/Projet].

---

Pour toute question ou support, veuillez créer une issue sur le dépôt GitHub.
