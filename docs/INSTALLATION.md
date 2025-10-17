# Guide d'Installation - Projet Laravel GitOps

## 📋 Table des matières

1. [Prérequis](#prérequis)
2. [Installation locale](#installation-locale)
3. [Configuration de la base de données](#configuration-de-la-base-de-données)
4. [Lancement de l'application](#lancement-de-l-application)
5. [Vérification de l'installation](#vérification-de-l-installation)
6. [Installation avec Docker](#installation-avec-docker)
7. [Dépannage](#dépannage)

---

## 🔧 Prérequis

### Système d'exploitation
- Windows, macOS ou Linux
- Terminal/PowerShell/Bash

### Logiciels requis
- **PHP 8.2+** avec les extensions suivantes :
  - `pdo`
  - `pdo_sqlite`
  - `mbstring`
  - `zip`
  - `curl`
  - `gd`
  - `fileinfo`
  
- **Composer** (gestionnaire de dépendances PHP)
  - Télécharger depuis : https://getcomposer.org/download/

- **Git** (contrôle de version)
  - Télécharger depuis : https://git-scm.com/download

- **Node.js** et **npm** (optionnel, pour les assets)
  - Télécharger depuis : https://nodejs.org/

### Vérification des prérequis

```bash
# Vérifier PHP
php --version

# Vérifier Composer
composer --version

# Vérifier Git
git --version

# Vérifier Node.js et npm (optionnel)
node --version
npm --version
```

---

## 💻 Installation locale

### Étape 1 : Cloner le dépôt

```bash
git clone https://github.com/votre-utilisateur/laravel-gitops-demo.git
cd laravel-gitops-demo
```

### Étape 2 : Installer les dépendances PHP

```bash
composer install
```

Cette commande installe toutes les dépendances PHP définies dans `composer.json`.

### Étape 3 : Installer les dépendances JavaScript (optionnel)

```bash
npm install
```

### Étape 4 : Configurer le fichier d'environnement

```bash
# Copier le fichier d'exemple
cp .env.example .env

# Générer une clé d'application
php artisan key:generate
```

Le fichier `.env` contient toutes les variables de configuration de l'application.

### Étape 5 : Vérifier la configuration

Ouvrez le fichier `.env` et vérifiez les paramètres suivants :

```env
APP_NAME="Laravel GitOps Demo"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

---

## 🗄️ Configuration de la base de données

### Créer la base de données SQLite

```bash
# Créer le fichier de base de données
touch database/database.sqlite

# Exécuter les migrations
php artisan migrate
```

### Vérifier la base de données

```bash
# Afficher l'état des migrations
php artisan migrate:status
```

Vous devriez voir une liste des migrations avec leur statut "Ran".

---

## 🚀 Lancement de l'application

### Démarrer le serveur de développement

```bash
php artisan serve
```

Par défaut, le serveur démarre sur `http://127.0.0.1:8000`.

Pour utiliser un port différent :

```bash
php artisan serve --port=8080
```

### Accéder à l'application

Ouvrez votre navigateur et accédez à :
```
http://127.0.0.1:8000
```

Vous devriez voir la page d'accueil avec la liste des posts (vide au démarrage).

---

## ✅ Vérification de l'installation

### 1. Vérifier que l'application est accessible

```bash
curl http://127.0.0.1:8000
```

### 2. Tester les opérations CRUD

#### Créer un post
- Cliquez sur "New Post"
- Remplissez le formulaire
- Cliquez sur "Create Post"

#### Afficher les posts
- La page d'accueil affiche la liste des posts

#### Modifier un post
- Cliquez sur "Edit" sur un post
- Modifiez les données
- Cliquez sur "Update Post"

#### Supprimer un post
- Cliquez sur "Delete" sur un post
- Confirmez la suppression

### 3. Exécuter les tests

```bash
php artisan test
```

Tous les tests doivent passer avec succès.

---

## 🐳 Installation avec Docker

### Prérequis Docker

- **Docker** : https://www.docker.com/products/docker-desktop
- **Docker Compose** : Inclus avec Docker Desktop

### Étapes d'installation

#### 1. Cloner le dépôt

```bash
git clone https://github.com/votre-utilisateur/laravel-gitops-demo.git
cd laravel-gitops-demo
```

#### 2. Construire et démarrer les conteneurs

```bash
docker-compose up -d
```

Cette commande :
- Construit l'image Docker
- Démarre les conteneurs (application, base de données, etc.)
- Configure les services

#### 3. Installer les dépendances

```bash
# Installer les dépendances PHP
docker-compose exec app composer install

# Installer les dépendances JavaScript
docker-compose exec app npm install
```

#### 4. Configurer l'application

```bash
# Copier le fichier d'environnement
docker-compose exec app cp .env.example .env

# Générer la clé d'application
docker-compose exec app php artisan key:generate

# Exécuter les migrations
docker-compose exec app php artisan migrate
```

#### 5. Accéder à l'application

Ouvrez votre navigateur et accédez à :
```
http://localhost:8000
```

### Commandes Docker utiles

```bash
# Afficher les logs
docker-compose logs -f app

# Arrêter les conteneurs
docker-compose down

# Redémarrer les conteneurs
docker-compose restart

# Exécuter une commande dans le conteneur
docker-compose exec app php artisan tinker
```

---

## 🔍 Dépannage

### Problème : "PHP command not found"

**Solution** : Assurez-vous que PHP est installé et ajouté au PATH système.

```bash
# Vérifier l'installation
php --version

# Ajouter PHP au PATH (Windows)
# Allez dans Paramètres > Variables d'environnement > Ajouter le chemin PHP
```

### Problème : "Composer command not found"

**Solution** : Installez Composer ou ajoutez-le au PATH.

```bash
# Télécharger Composer
# https://getcomposer.org/download/

# Vérifier l'installation
composer --version
```

### Problème : "SQLSTATE[HY000]: General error: 1 unable to open database file"

**Solution** : Créez le fichier de base de données SQLite.

```bash
touch database/database.sqlite
chmod 666 database/database.sqlite
php artisan migrate
```

### Problème : "The APP_KEY environment variable is not set"

**Solution** : Générez une clé d'application.

```bash
php artisan key:generate
```

### Problème : "Class 'PDO' not found"

**Solution** : Activez l'extension PDO dans PHP.

```bash
# Vérifier les extensions PHP
php -m

# Modifier php.ini pour activer PDO
# Décommenter la ligne : extension=pdo
```

### Problème : Port 8000 déjà utilisé

**Solution** : Utilisez un port différent.

```bash
php artisan serve --port=8080
```

### Problème : Permissions insuffisantes sur les dossiers

**Solution** : Modifiez les permissions des dossiers.

```bash
# Linux/macOS
chmod -R 775 storage bootstrap/cache

# Windows (PowerShell)
icacls "storage" /grant:r "%username%:F" /t
icacls "bootstrap\cache" /grant:r "%username%:F" /t
```

---

## 📞 Support

Si vous rencontrez des problèmes :

1. Consultez la [documentation Laravel](https://laravel.com/docs)
2. Vérifiez les logs : `storage/logs/laravel.log`
3. Ouvrez une issue sur GitHub : [Issues](https://github.com/votre-utilisateur/laravel-gitops-demo/issues)
