# Guide de Déploiement

## 📚 Table des matières

1. [Déploiement local](#déploiement-local)
2. [Déploiement via GitHub Actions](#déploiement-via-github-actions)
3. [Déploiement avec Docker](#déploiement-avec-docker)
4. [Vérification du déploiement](#vérification-du-déploiement)
5. [Rollback](#rollback)
6. [Monitoring](#monitoring)

---

## 🚀 Déploiement local

### Méthode 1 : Script de déploiement

Le script `scripts/deploy.sh` automatise le déploiement complet.

#### Prérequis

```bash
# Vérifier que rsync est installé
rsync --version

# Vérifier que PHP et Composer sont disponibles
php --version
composer --version
```

#### Exécution

```bash
# Rendre le script exécutable
chmod +x scripts/deploy.sh

# Exécuter le déploiement
./scripts/deploy.sh
```

#### Résultat

Le script crée un dossier `deploy/` contenant :
- L'application Laravel complète
- Les dépendances de production installées
- L'environnement configuré
- Les caches générés

### Méthode 2 : Déploiement manuel

Si vous préférez un contrôle plus granulaire :

```bash
# 1. Créer le dossier de déploiement
mkdir -p deploy

# 2. Copier les fichiers
rsync -av --delete \
    --exclude='.git' \
    --exclude='.github' \
    --exclude='node_modules' \
    --exclude='tests' \
    --exclude='phpunit.xml' \
    . deploy/

# 3. Installer les dépendances
cd deploy
composer install --no-dev --optimize-autoloader

# 4. Configurer l'environnement
cp .env .env.production
sed -i 's/APP_ENV=local/APP_ENV=production/' .env.production
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env.production

# 5. Créer les dossiers nécessaires
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p bootstrap/cache

# 6. Définir les permissions
chmod -R 775 storage bootstrap/cache

# 7. Générer la clé d'application
php artisan key:generate --force

# 8. Optimiser l'application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Migrer la base de données (si nécessaire)
php artisan migrate --force
```

---

## 🔄 Déploiement via GitHub Actions

### Configuration

Le workflow est défini dans `.github/workflows/gitops-ci-cd.yml`.

### Déclenchement automatique

Le déploiement se déclenche automatiquement quand vous :

1. Poussez du code vers la branche `main`
2. Créez une Pull Request vers `main`

### Étapes du workflow

```yaml
1. Checkout du code
   ↓
2. Setup PHP 8.2
   ↓
3. Installation des dépendances
   ↓
4. Exécution des tests
   ↓
5. Si tests OK → Déploiement
   ↓
6. Copie des fichiers
   ↓
7. Installation des dépendances de production
   ↓
8. Optimisation de l'application
```

### Suivi du déploiement

#### Sur GitHub

1. Allez dans l'onglet **Actions**
2. Sélectionnez le workflow **Laravel GitOps CI/CD**
3. Cliquez sur le dernier run
4. Consultez les logs détaillés

#### Logs disponibles

- **Setup PHP** : Configuration de l'environnement
- **Install Dependencies** : Installation de Composer
- **Execute tests** : Résultats des tests
- **Deploy Application** : Logs du déploiement

### Secrets GitHub (optionnel)

Si vous avez besoin de secrets (API keys, etc.) :

1. Allez dans **Settings > Secrets and variables > Actions**
2. Cliquez sur **New repository secret**
3. Ajoutez vos secrets
4. Utilisez-les dans le workflow : `${{ secrets.MON_SECRET }}`

---

## 🐳 Déploiement avec Docker

### Prérequis

```bash
# Vérifier Docker
docker --version

# Vérifier Docker Compose
docker-compose --version
```

### Déploiement

#### 1. Construire l'image

```bash
# Construire l'image Docker
docker build -t laravel-gitops:latest .

# Vérifier l'image
docker images | grep laravel-gitops
```

#### 2. Lancer les conteneurs

```bash
# Démarrer tous les services
docker-compose up -d

# Vérifier les conteneurs
docker-compose ps
```

#### 3. Initialiser l'application

```bash
# Installer les dépendances
docker-compose exec app composer install

# Générer la clé
docker-compose exec app php artisan key:generate

# Exécuter les migrations
docker-compose exec app php artisan migrate
```

#### 4. Accéder à l'application

```
http://localhost:8000
```

### Commandes Docker utiles

```bash
# Afficher les logs
docker-compose logs -f app

# Exécuter une commande
docker-compose exec app php artisan tinker

# Arrêter les conteneurs
docker-compose down

# Supprimer les volumes
docker-compose down -v

# Redémarrer
docker-compose restart app
```

### Déploiement en production avec Docker

Pour un déploiement en production :

```bash
# 1. Construire l'image
docker build -t laravel-gitops:v1.0.0 .

# 2. Pousser vers un registre (Docker Hub, etc.)
docker push votre-registre/laravel-gitops:v1.0.0

# 3. Sur le serveur de production
docker pull votre-registre/laravel-gitops:v1.0.0
docker run -d -p 80:80 \
  -e APP_ENV=production \
  -e APP_DEBUG=false \
  votre-registre/laravel-gitops:v1.0.0
```

---

## ✅ Vérification du déploiement

### 1. Vérifier les fichiers

```bash
# Vérifier que le dossier deploy existe
ls -la deploy/

# Vérifier les fichiers clés
ls -la deploy/app/
ls -la deploy/storage/
ls -la deploy/bootstrap/cache/
```

### 2. Vérifier la configuration

```bash
# Vérifier le fichier .env
cat deploy/.env.production

# Vérifier les permissions
ls -la deploy/storage/
ls -la deploy/bootstrap/cache/
```

### 3. Vérifier l'application

```bash
# Vérifier que l'application démarre
cd deploy
php artisan tinker

# Exécuter une commande simple
>>> Post::count()
=> 0

# Quitter
>>> exit
```

### 4. Vérifier la base de données

```bash
# Vérifier les migrations
php deploy/artisan migrate:status

# Vérifier les tables
php deploy/artisan tinker
>>> Schema::getTables()
```

### 5. Vérifier les performances

```bash
# Vérifier les caches
ls -la deploy/bootstrap/cache/

# Vérifier les logs
tail -f deploy/storage/logs/laravel.log
```

### 6. Test fonctionnel

```bash
# Démarrer le serveur
cd deploy
php artisan serve --port=8001

# Tester l'application
curl http://127.0.0.1:8001/posts

# Vérifier la réponse HTML
# Vous devriez voir la page d'accueil
```

---

## 🔄 Rollback

### Rollback via Git

Si un déploiement échoue, vous pouvez revenir à la version précédente :

```bash
# Voir l'historique
git log --oneline

# Revenir à un commit précédent
git revert <commit-hash>

# Pousser le changement
git push origin main

# GitHub Actions redéploiera automatiquement
```

### Rollback manuel

Si vous avez besoin de revenir rapidement :

```bash
# Sauvegarder la version actuelle
mv deploy deploy-backup-$(date +%s)

# Restaurer une version précédente
# (à partir de votre système de sauvegarde)
cp -r deploy-old deploy

# Vérifier que tout fonctionne
cd deploy
php artisan tinker
```

### Sauvegarde et récupération

```bash
# Créer une sauvegarde avant déploiement
tar -czf deploy-backup-$(date +%Y%m%d-%H%M%S).tar.gz deploy/

# Lister les sauvegardes
ls -la deploy-backup-*.tar.gz

# Restaurer une sauvegarde
tar -xzf deploy-backup-20251017-162000.tar.gz
```

---

## 📊 Monitoring

### Logs de l'application

```bash
# Afficher les logs en temps réel
tail -f deploy/storage/logs/laravel.log

# Afficher les dernières 100 lignes
tail -100 deploy/storage/logs/laravel.log

# Rechercher les erreurs
grep -i error deploy/storage/logs/laravel.log
```

### Vérification de la santé

```bash
# Créer un endpoint de santé (optionnel)
# Route::get('/health', function () {
#     return response()->json(['status' => 'ok']);
# });

# Tester l'endpoint
curl http://127.0.0.1:8000/health
```

### Monitoring des performances

```bash
# Vérifier l'utilisation du disque
du -sh deploy/

# Vérifier l'utilisation de la mémoire
free -h

# Vérifier les processus PHP
ps aux | grep php
```

### Alertes et notifications

Pour un monitoring avancé, vous pouvez configurer :

1. **GitHub Actions Notifications** : Recevoir des emails en cas d'échec
2. **Slack Integration** : Notifier Slack des déploiements
3. **Email Alerts** : Configurer des alertes par email

---

## 📋 Checklist de déploiement

Avant de déployer en production :

- [ ] Tous les tests passent
- [ ] Le code a été revu
- [ ] Les migrations sont prêtes
- [ ] Les variables d'environnement sont configurées
- [ ] Les permissions des dossiers sont correctes
- [ ] Les sauvegardes sont à jour
- [ ] Un plan de rollback est en place
- [ ] Les logs sont configurés
- [ ] Le monitoring est en place
- [ ] L'équipe est notifiée

---

## 🆘 Dépannage

### Le déploiement échoue

```bash
# Vérifier les logs GitHub Actions
# Actions > Workflow > Détails

# Vérifier les logs locaux
tail -f deploy/storage/logs/laravel.log

# Vérifier les permissions
chmod -R 775 deploy/storage deploy/bootstrap/cache
```

### L'application ne démarre pas

```bash
# Vérifier la configuration
php deploy/artisan config:cache

# Vérifier les migrations
php deploy/artisan migrate:status

# Vérifier les erreurs
php deploy/artisan tinker
```

### Erreur de base de données

```bash
# Vérifier le fichier de base de données
ls -la deploy/database/database.sqlite

# Recréer la base de données
rm deploy/database/database.sqlite
touch deploy/database/database.sqlite
php deploy/artisan migrate --force
```

### Erreur de permissions

```bash
# Corriger les permissions
chmod -R 775 deploy/storage
chmod -R 775 deploy/bootstrap/cache

# Sur Linux/macOS
chown -R www-data:www-data deploy/storage
chown -R www-data:www-data deploy/bootstrap/cache
```
