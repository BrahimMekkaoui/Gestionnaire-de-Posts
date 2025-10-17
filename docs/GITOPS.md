# Guide GitOps - Mise en place d'une chaîne DevOps

## 📚 Table des matières

1. [Qu'est-ce que GitOps ?](#quest-ce-que-gitops)
2. [Principes de GitOps](#principes-de-gitops)
3. [Architecture de notre implémentation](#architecture-de-notre-implémentation)
4. [Flux de travail](#flux-de-travail)
5. [Configuration GitHub Actions](#configuration-github-actions)
6. [Déploiement local](#déploiement-local)
7. [Bonnes pratiques](#bonnes-pratiques)

---

## 🤔 Qu'est-ce que GitOps ?

**GitOps** est une approche de gestion d'infrastructure et de déploiement qui utilise Git comme source unique de vérité. Au lieu de déployer manuellement ou via des scripts, toutes les modifications sont versionnées dans Git et déployées automatiquement.

### Caractéristiques principales

- **Git comme source unique de vérité** : Tout ce qui est en production est décrit dans Git
- **Automatisation** : Les changements sont déployés automatiquement via des pipelines CI/CD
- **Traçabilité** : Chaque changement est enregistré dans l'historique Git
- **Reproductibilité** : On peut recréer l'état de production à tout moment
- **Sécurité** : Les changements sont revus et approuvés avant déploiement

---

## 🎯 Principes de GitOps

### 1. Déclaratif

L'état désiré du système est déclaré dans Git, pas impératif.

```yaml
# ❌ Approche impérative (ancienne)
docker run -d -p 8000:80 laravel-app

# ✅ Approche déclarative (GitOps)
# Défini dans docker-compose.yml ou Dockerfile
version: '3.8'
services:
  app:
    image: laravel-app:latest
    ports:
      - "8000:80"
```

### 2. Versionné et immuable

Tous les changements sont versionnés dans Git avec un historique complet.

```bash
# Chaque commit représente un changement
git log --oneline

# On peut revenir à n'importe quel état antérieur
git checkout <commit-hash>
```

### 3. Automatiquement appliqué

Les changements sont automatiquement déployés via des pipelines.

```yaml
# Défini dans .github/workflows/gitops-ci-cd.yml
on:
  push:
    branches: [ main ]
```

### 4. Continuellement observé

Le système est continuellement observé pour détecter les dérives.

```bash
# Vérifier l'état du déploiement
php artisan config:cache
php artisan route:cache
```

---

## 🏗️ Architecture de notre implémentation

### Diagramme du flux

```
┌─────────────────────────────────────────────────────────────────┐
│                        Développeur                              │
│                                                                 │
│  1. Modifie le code localement                                 │
│  2. Commit et push vers GitHub                                 │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                      GitHub Repository                          │
│                                                                 │
│  - Code source                                                 │
│  - Configuration (docker-compose.yml, Dockerfile)              │
│  - Workflows (.github/workflows/)                              │
│  - Documentation                                               │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                    GitHub Actions (CI/CD)                       │
│                                                                 │
│  1. Déclenché par push sur main                                │
│  2. Exécute les tests (php artisan test)                       │
│  3. Si succès → Exécute le déploiement                         │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                    Déploiement Local (./deploy/)                │
│                                                                 │
│  - Application déployée                                        │
│  - Dépendances installées                                      │
│  - Configuration optimisée                                     │
│  - Prête à être servie                                         │
└─────────────────────────────────────────────────────────────────┘
```

### Composants clés

1. **Repository GitHub** : Source unique de vérité
2. **GitHub Actions** : Moteur d'automatisation
3. **Scripts de déploiement** : Logique de déploiement
4. **Dossier ./deploy/** : Environnement de production simulé

---

## 🔄 Flux de travail

### Étape 1 : Développement local

```bash
# Créer une branche de feature
git checkout -b feature/nouvelle-fonctionnalite

# Faire des modifications
# ... éditer les fichiers ...

# Tester localement
php artisan test

# Commiter les changements
git add .
git commit -m "Ajouter nouvelle fonctionnalité"
```

### Étape 2 : Push vers GitHub

```bash
# Pousser la branche
git push origin feature/nouvelle-fonctionnalite

# Créer une Pull Request sur GitHub
# Demander une revue de code
# Discuter des changements
```

### Étape 3 : Revue et approbation

```
Sur GitHub :
1. Les tests s'exécutent automatiquement
2. Les reviewers examinent le code
3. Si approuvé → Fusionner dans main
```

### Étape 4 : Déploiement automatique

```
Quand on push vers main :
1. GitHub Actions déclenche le workflow
2. Les tests s'exécutent
3. Si succès → Déploiement automatique
4. L'application est mise à jour dans ./deploy/
```

### Étape 5 : Vérification

```bash
# Vérifier que le déploiement a réussi
ls -la deploy/

# Vérifier les logs
cat deploy/storage/logs/laravel.log

# Tester l'application
php deploy/artisan tinker
```

---

## ⚙️ Configuration GitHub Actions

### Fichier de workflow

Le fichier `.github/workflows/gitops-ci-cd.yml` définit le pipeline :

```yaml
name: Laravel GitOps CI/CD

on:
  push:
    branches: [ main ]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      # 1. Checkout du code
      - uses: actions/checkout@v3
      
      # 2. Setup PHP
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      
      # 3. Installation des dépendances
      - name: Install Dependencies
        run: composer install
      
      # 4. Exécution des tests
      - name: Execute tests
        run: php artisan test

  deploy:
    needs: test
    if: github.ref == 'refs/heads/main'
    runs-on: ubuntu-latest
    steps:
      # Déploiement automatique
      - name: Deploy Application
        run: ./scripts/deploy.sh
```

### Déclencheurs du workflow

Le workflow se déclenche sur :

```yaml
on:
  push:
    branches: [ main ]  # Uniquement sur main
  pull_request:
    branches: [ main ]  # Aussi sur les PR
```

---

## 🚀 Déploiement local

### Script de déploiement

Le script `scripts/deploy.sh` automatise le déploiement :

```bash
#!/bin/bash

# 1. Créer le dossier de déploiement
mkdir -p deploy

# 2. Copier les fichiers (sauf les fichiers inutiles)
rsync -av --exclude='.git' --exclude='node_modules' . deploy/

# 3. Installer les dépendances de production
cd deploy
composer install --no-dev --optimize-autoloader

# 4. Configurer l'environnement
cp .env .env.production
sed -i 's/APP_ENV=local/APP_ENV=production/' .env.production

# 5. Créer les dossiers nécessaires
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage bootstrap/cache

# 6. Optimiser l'application
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Exécution manuelle

```bash
# Rendre le script exécutable
chmod +x scripts/deploy.sh

# Exécuter le déploiement
./scripts/deploy.sh

# Vérifier le résultat
ls -la deploy/
```

---

## ✅ Bonnes pratiques GitOps

### 1. Toujours tester avant de merger

```bash
# Exécuter les tests localement
php artisan test

# Vérifier le code
php artisan lint

# Vérifier les dépendances
composer audit
```

### 2. Utiliser des branches de feature

```bash
# Créer une branche pour chaque feature
git checkout -b feature/ma-feature

# Faire les modifications
# Tester
# Commiter

# Créer une PR pour la revue
git push origin feature/ma-feature
```

### 3. Écrire des messages de commit clairs

```bash
# ✅ Bon message
git commit -m "Ajouter validation du formulaire de création de post"

# ❌ Mauvais message
git commit -m "Fix bug"
```

### 4. Documenter les changements

```bash
# Ajouter une description dans la PR
# Expliquer pourquoi le changement est nécessaire
# Lister les fichiers modifiés
```

### 5. Monitorer les déploiements

```bash
# Vérifier les logs du workflow
# Sur GitHub : Actions > Workflow > Détails

# Vérifier les logs de l'application
tail -f deploy/storage/logs/laravel.log
```

### 6. Maintenir la reproductibilité

```bash
# Versionner les dépendances
composer.lock  # Toujours commiter ce fichier

# Documenter les étapes de déploiement
# Garder les scripts à jour
```

### 7. Sécurité

```bash
# Ne pas commiter les secrets
# Utiliser GitHub Secrets pour les variables sensibles

# Vérifier les dépendances vulnérables
composer audit

# Mettre à jour régulièrement
composer update
```

---

## 📊 Exemple complet : Déployer une nouvelle feature

### Scénario : Ajouter un champ "author" au modèle Post

#### 1. Créer une branche

```bash
git checkout -b feature/add-author-field
```

#### 2. Faire les modifications

```bash
# Créer une migration
php artisan make:migration add_author_to_posts_table

# Modifier la migration
# Ajouter le champ author

# Mettre à jour le modèle Post
# Ajouter 'author' à $fillable

# Mettre à jour les vues
# Ajouter le champ author dans les formulaires
```

#### 3. Tester localement

```bash
# Exécuter les migrations
php artisan migrate

# Exécuter les tests
php artisan test

# Tester manuellement
php artisan serve
```

#### 4. Commiter et pousser

```bash
git add .
git commit -m "Ajouter champ author au modèle Post"
git push origin feature/add-author-field
```

#### 5. Créer une Pull Request

```
Sur GitHub :
1. Cliquer sur "Compare & pull request"
2. Ajouter une description
3. Demander une revue
```

#### 6. Revue et approbation

```
Les tests s'exécutent automatiquement
Si tout est OK → Approuver et merger
```

#### 7. Déploiement automatique

```
GitHub Actions déclenche le workflow :
1. Tests s'exécutent
2. Si succès → Déploiement automatique
3. L'application est mise à jour dans ./deploy/
```

#### 8. Vérification

```bash
# Vérifier que le déploiement a réussi
ls -la deploy/

# Vérifier les migrations
php deploy/artisan migrate:status

# Tester la nouvelle feature
php deploy/artisan tinker
```

---

## 🎓 Résumé

GitOps est une approche puissante pour automatiser le déploiement et gérer l'infrastructure. Dans ce projet :

- ✅ Git est la source unique de vérité
- ✅ Tous les changements sont versionnés
- ✅ Les tests s'exécutent automatiquement
- ✅ Le déploiement est automatisé
- ✅ Tout est reproductible et traçable

Cette approche garantit une qualité élevée, une traçabilité complète et une automatisation efficace.
