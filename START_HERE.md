# 🎯 COMMENCEZ ICI - Projet Laravel GitOps

Bienvenue ! Ce fichier vous guide à travers le projet.

---

## ⚡ 5 minutes pour démarrer

###  Installation locale

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

**Accédez à** : http://127.0.0.1:8000


---

## 📚 Où aller selon vos besoins

### 🚀 Je veux démarrer rapidement
→ Lire : [QUICKSTART.md](QUICKSTART.md)

### 📖 Je veux comprendre le projet
→ Lire : [README.md](README.md)


---

## 🎯 Flux recommandé

### Pour un développeur

1. [QUICKSTART.md](QUICKSTART.md) - Démarrage rapide
2. [README.md](README.md) - Vue d'ensemble
3. Commencer à développer !

### Pour un DevOps

1. [.github/workflows/gitops-ci-cd.yml](.github/workflows/gitops-ci-cd.yml) - Workflow
2. [scripts/deploy.sh](scripts/deploy.sh) - Script de déploiement

### Pour un testeur

1. [tests/](tests/) - Fichiers de test
2. Exécuter : `php artisan test`

---

## 🚀 Commandes essentielles

```bash
# Installation
composer install
php artisan migrate

# Développement
php artisan serve

# Tests
php artisan test

# Déploiement
chmod +x scripts/deploy.sh
./scripts/deploy.sh

# Docker
docker-compose up -d
```

---

## 📊 Statistiques du projet

- ✅ 11 tests (100% passants)
- ✅ 50+ fichiers
- ✅ 3000+ lignes de documentation
- ✅ Application CRUD complète
- ✅ CI/CD automatisée

---

## 🆘 Problèmes courants

### Erreur : "APP_KEY environment variable is not set"
```bash
php artisan key:generate
```

### Erreur : "Unable to open database file"
```bash
touch database/database.sqlite
php artisan migrate
```

### Port 8000 déjà utilisé
```bash
php artisan serve --port=8080
```


---

## ✨ Prochaines étapes

1. ✅ Installer l'application
2. ✅ Exécuter les tests
3. ✅ Créer un post
5. ✅ Pousser sur GitHub
6. ✅ Tester le pipeline CI/CD

---

## 🎉 Vous êtes prêt !

L'application est prête à être utilisée. Commencez par :

**[QUICKSTART.md](QUICKSTART.md)** → Installation en 5 minutes

ou

**[README.md](README.md)** → Vue d'ensemble complète

---

**Bonne chance ! 🚀**
