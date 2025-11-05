# MonBlog - Application avec Laravel

## Pourquoi Fortify pour l'authentification ?

✨ **3 raisons principales** :

1. **Simplicité d'implémentation**
   - Configuration minimale
   - Installation en une ligne : `composer require laravel/fortify`
   - Documentation claire et complète

2. **Flexible et léger**
   - Backend-only (pas de frontend imposé)
   - S'intègre avec n'importe quel framework frontend
   - Pas de dépendances JavaScript

3. **Complet et sécurisé**
   - Toutes les fonctionnalités essentielles incluses
   - Sécurité par défaut

## Installation rapide

```bash
npm install
composer require laravel/fortify
cp .env.example .env
php artisan key:generate
npm install
php artisan storage:link
php artisan migrate
php artisan db:seed
php artisan serve
```
# Commandes utiles

## Exécute les migrations pour créer les tables
php artisan migrate

## Réinitialise toutes les migrations et les réexécute
php artisan migrate:fresh

## Remplit la base de données avec les seeders
php artisan db:seed

## Réinitialise la BDD et exécute les seeders
php artisan migrate:fresh --seed

## Démarre le serveur de développement
php artisan serve

## Créez le lien symbolique pour le stockage public pour les photos de profil
php artisan storage:link


# Documentation des Routes

### Routes Publiques
| Méthode | URI | Action | Description |
|---------|-----|--------|-------------|
| GET | `/articles` | index | Liste tous les articles |
| GET | `/articles/{article}` | show | Affiche un article |
| GET | `/articles/{article}/edit` | edit | Formulaire d'édition |
| PUT/PATCH | `/articles/{article}` | update | Met à jour un article |
| DELETE | `/articles/{article}` | destroy | Supprime un article |

### Routes Authentifiées (`auth`)
| Méthode | URI | Action | Description |
|---------|-----|--------|-------------|
| GET | `/articles/create` | create | Formulaire de création |
| POST | `/articles` | store | Crée un article |
| POST | `/articles/{article}/like` | like | Like/Unlike un article |
| POST | `/articles/{article}/comments` | store | Ajoute un commentaire |
| DELETE | `/comments/{comment}` | destroy | Supprime un commentaire |
| GET | `/profile` | show | Affiche le profil de l'utilisateur |
| POST | `/logout` | logout | Déconnexion |

### Routes Invités (`guest`)
| Méthode | URI | Action | Description |
|---------|-----|--------|-------------|
| GET | `/login` | showLoginForm | Page de connexion |
| POST | `/login` | login | Connexion |
| GET | `/register` | showRegistrationForm | Page d'inscription |
| POST | `/register` | register | Inscription |


> **Note** : La route `/` est redirigée vers `/articles`

## Test de l'Authentification

### Comptes de test disponibles

# Compte utilisateur standard

> **Email** => user@example.com
> 
> **Password** => password
