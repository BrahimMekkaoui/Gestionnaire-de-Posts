# Documentation du Projet Laravel GitOps

Bienvenue dans la documentation complète du projet **Mise en place d'une chaîne DevOps (GitOps) pour une application PHP/Laravel**.

## 📚 Table des matières

### 1. **[Fiche Projet](./fiche_projet.md)**
   - Description générale du projet
   - Objectifs et contraintes
   - Équipe et calendrier
   - Risques identifiés

### 2. **[Installation](./INSTALLATION.md)**
   - Prérequis système
   - Installation locale étape par étape
   - Configuration de la base de données
   - Installation avec Docker
   - Dépannage courant

### 3. **[Work Breakdown Structure (WBS)](./wbs.md)**
   - Structure hiérarchique du projet
   - Phases et tâches
   - Durées estimées
   - Livrables par phase

### 4. **[Exigences](./exigences.md)**
   - Exigences fonctionnelles (EF)
   - Exigences non-fonctionnelles (ENF)
   - Matrice de traçabilité
   - Critères SMART

### 5. **[Planning](./planning.md)**
   - Calendrier prévisionnel (6 semaines)
   - Diagramme de Gantt
   - Allocation des ressources
   - Jalons clés

### 6. **[GitOps](./GITOPS.md)**
   - Concepts et principes de GitOps
   - Architecture de l'implémentation
   - Flux de travail complet
   - Bonnes pratiques
   - Exemple pratique

### 7. **[Déploiement](./DEPLOYMENT.md)**
   - Déploiement local
   - Déploiement via GitHub Actions
   - Déploiement avec Docker
   - Vérification et monitoring
   - Rollback et récupération

---

## 🎯 Guide rapide

### Pour commencer rapidement

```bash
# 1. Cloner le projet
git clone https://github.com/votre-utilisateur/laravel-gitops-demo.git
cd laravel-gitops-demo

# 2. Installer les dépendances
composer install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Initialiser la base de données
touch database/database.sqlite
php artisan migrate

# 5. Démarrer l'application
php artisan serve
```

Accédez à l'application : http://127.0.0.1:8000

### Pour déployer

```bash
# Déploiement local
chmod +x scripts/deploy.sh
./scripts/deploy.sh

# Déploiement avec Docker
docker-compose up -d
```

---

## 📁 Structure du projet

```
laravel-gitops-demo/
├── app/                          # Code source Laravel
│   ├── Http/Controllers/
│   │   └── PostController.php    # Contrôleur CRUD
│   └── Models/
│       └── Post.php              # Modèle Post
├── database/
│   ├── migrations/               # Migrations de base de données
│   └── factories/                # Factories pour les tests
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php     # Layout principal
│       └── posts/                # Vues des posts
├── routes/
│   └── web.php                   # Routes web
├── tests/
│   ├── Unit/
│   │   └── PostTest.php          # Tests unitaires
│   └── Feature/
│       └── PostTest.php          # Tests de feature
├── .github/
│   └── workflows/
│       └── gitops-ci-cd.yml      # Workflow GitHub Actions
├── scripts/
│   └── deploy.sh                 # Script de déploiement
├── docker/
│   ├── nginx.conf                # Configuration Nginx
│   ├── supervisord.conf          # Configuration Supervisor
│   └── php.ini                   # Configuration PHP
├── docs/                         # Documentation
│   ├── fiche_projet.md
│   ├── wbs.md
│   ├── exigences.md
│   ├── planning.md
│   ├── INSTALLATION.md
│   ├── GITOPS.md
│   ├── DEPLOYMENT.md
│   └── README.md
├── Dockerfile                    # Configuration Docker
├── docker-compose.yml            # Orchestration Docker
└── README.md                     # README principal
```

---

## 🔄 Flux de travail GitOps

```
Développement local
    ↓
Commit et push vers GitHub
    ↓
GitHub Actions déclenche le workflow
    ↓
Tests s'exécutent
    ↓
Si succès → Déploiement automatique
    ↓
Application mise à jour dans ./deploy/
```

---

## 📊 Exigences clés

### Fonctionnelles
- ✅ CRUD complet pour les Posts
- ✅ Validation des données
- ✅ Interface utilisateur intuitive

### Non-fonctionnelles
- ✅ Performance (< 500ms)
- ✅ Sécurité (CSRF, validation)
- ✅ Testabilité (> 70% couverture)
- ✅ CI/CD automatisé
- ✅ Déploiement GitOps

---

## 🧪 Tests

### Exécuter les tests

```bash
# Tous les tests
php artisan test

# Tests unitaires uniquement
php artisan test --filter Unit

# Tests de feature uniquement
php artisan test --filter Feature

# Avec rapport de couverture
php artisan test --coverage
```

### Types de tests

1. **Tests unitaires** : Testent les modèles isolément
2. **Tests de feature** : Testent les routes et contrôleurs
3. **Tests d'intégration** : Testent le flux complet

---

## 🚀 Déploiement

### Environnements

- **Local** : `php artisan serve`
- **Staging** : Via GitHub Actions (branche staging)
- **Production** : Via GitHub Actions (branche main)

### Processus de déploiement

1. Développement sur une branche de feature
2. Création d'une Pull Request
3. Tests automatiques
4. Revue de code
5. Fusion dans main
6. Déploiement automatique

---

## 📞 Support et ressources

### Documentation externe
- [Laravel Documentation](https://laravel.com/docs)
- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [Docker Documentation](https://docs.docker.com/)

### Fichiers d'aide
- **README.md** : Vue d'ensemble du projet
- **INSTALLATION.md** : Guide d'installation détaillé
- **GITOPS.md** : Explication de GitOps
- **DEPLOYMENT.md** : Guide de déploiement

### Signaler un problème
1. Consultez la section Dépannage dans INSTALLATION.md
2. Vérifiez les logs : `storage/logs/laravel.log`
3. Ouvrez une issue sur GitHub

---

## 📝 Licence

Ce projet est open-source et disponible sous la [licence MIT](../LICENSE).

---

## 👥 Contributeurs

- [Votre Nom] - Développeur/DevOps

---

## 📅 Historique des versions

| Version | Date | Description |
|---------|------|-------------|
| 1.0.0 | 2025-10-17 | Version initiale |

---

**Dernière mise à jour** : 17 octobre 2025
