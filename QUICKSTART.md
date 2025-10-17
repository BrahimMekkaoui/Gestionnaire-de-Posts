# 🚀 Démarrage rapide - Laravel GitOps

Bienvenue ! Ce guide vous permettra de démarrer en **5 minutes**.

## ⚡ Installation ultra-rapide (5 min)

### 1️⃣ Cloner le projet

```bash
git clone https://github.com/votre-utilisateur/laravel-gitops-demo.git
cd laravel-gitops-demo
```

### 2️⃣ Installer les dépendances

```bash
composer install
```

### 3️⃣ Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Initialiser la base de données

```bash
touch database/database.sqlite
php artisan migrate
```

### 5️⃣ Démarrer l'application

```bash
php artisan serve
```

**Accédez à** : http://127.0.0.1:8000

---

## 🐳 Avec Docker (2 min)

```bash
docker-compose up -d
```

**Accédez à** : http://localhost:8000

---

## 🧪 Exécuter les tests

```bash
php artisan test
```

**Résultat attendu** :
```
Tests:    11 passed (27 assertions)
Duration: 1.51s
```

---

## 📚 Documentation

| Besoin | Lien |
|--------|------|
| 📖 Guide complet | [README.md](README.md) |
| 📋 Installation détaillée | [docs/INSTALLATION.md](docs/INSTALLATION.md) |
| 🔄 Comprendre GitOps | [docs/GITOPS.md](docs/GITOPS.md) |
| 🚀 Déployer | [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md) |
| 🧪 Tester | [docs/TESTING.md](docs/TESTING.md) |
| ⚙️ Configuration | [docs/ENVIRONMENT.md](docs/ENVIRONMENT.md) |

---

## 🎯 Prochaines étapes

### 1. Créer un post

1. Allez à http://127.0.0.1:8000/posts
2. Cliquez sur "Create New Post"
3. Remplissez le formulaire
4. Cliquez sur "Create Post"

### 2. Modifier un post

1. Cliquez sur "Edit" sur un post
2. Modifiez les données
3. Cliquez sur "Update Post"

### 3. Supprimer un post

1. Cliquez sur "Delete" sur un post
2. Confirmez la suppression

### 4. Exécuter les tests

```bash
php artisan test
```

### 5. Déployer localement

```bash
chmod +x scripts/deploy.sh
./scripts/deploy.sh
```

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

### Erreur : Port 8000 déjà utilisé

```bash
php artisan serve --port=8080
```

### Plus de solutions

Voir [docs/INSTALLATION.md](docs/INSTALLATION.md#dépannage)

---

## 📊 Fonctionnalités

✅ Application CRUD complète  
✅ Tests automatisés (11 tests)  
✅ CI/CD avec GitHub Actions  
✅ Déploiement GitOps  
✅ Configuration Docker  
✅ Documentation complète  

---

## 🎓 Concepts clés

### GitOps

Git est la source unique de vérité. Tous les changements sont versionnés et déployés automatiquement.

### CI/CD

Les tests s'exécutent automatiquement à chaque push, et le déploiement se fait automatiquement si les tests passent.

### Infrastructure as Code

Toute l'infrastructure est définie dans du code (Dockerfile, scripts, configuration).

---

## 📞 Besoin d'aide ?

- 📖 Consultez la [documentation complète](docs/README.md)
- 🐛 Vérifiez les [logs](storage/logs/laravel.log)
- 💬 Ouvrez une [issue](https://github.com/votre-utilisateur/laravel-gitops-demo/issues)

---

## 🎉 Vous êtes prêt !

L'application est maintenant en cours d'exécution. Explorez-la et amusez-vous !

**Prochaine étape** : [Lire la documentation complète](README.md)

---

**Besoin d'une aide plus détaillée ?** → [Guide d'installation complet](docs/INSTALLATION.md)
