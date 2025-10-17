# Guide des Variables d'Environnement

## 📋 Table des matières

1. [Vue d'ensemble](#vue-densemble)
2. [Variables principales](#variables-principales)
3. [Configuration par environnement](#configuration-par-environnement)
4. [Secrets et sécurité](#secrets-et-sécurité)
5. [Validation des variables](#validation-des-variables)

---

## 🔍 Vue d'ensemble

Les variables d'environnement permettent de configurer l'application sans modifier le code. Elles sont stockées dans les fichiers `.env`.

### Fichiers d'environnement

- `.env.example` : Template pour le développement
- `.env` : Configuration locale (ignorée par Git)
- `.env.testing` : Configuration pour les tests
- `.env.production.example` : Template pour la production

---

## 🔧 Variables principales

### Application

```env
# Nom de l'application
APP_NAME="Laravel GitOps Demo"

# Environnement (local, testing, production)
APP_ENV=local

# Clé de chiffrement
APP_KEY=base64:...

# Mode debug (true en dev, false en prod)
APP_DEBUG=true

# URL de l'application
APP_URL=http://localhost:8000
```

### Base de données

```env
# Type de base de données
DB_CONNECTION=sqlite

# Chemin du fichier SQLite
DB_DATABASE=database/database.sqlite

# Pour MySQL/PostgreSQL
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel_gitops
# DB_USERNAME=root
# DB_PASSWORD=password
```

### Logs

```env
# Canal de log (stack, single, daily, etc.)
LOG_CHANNEL=stack

# Niveau de log (debug, info, notice, warning, error, critical, alert, emergency)
LOG_LEVEL=debug
```

### Cache

```env
# Driver de cache (file, redis, memcached, array)
CACHE_DRIVER=file
```

### Session

```env
# Driver de session (file, cookie, database, array)
SESSION_DRIVER=file

# Durée de vie de la session (en minutes)
SESSION_LIFETIME=120
```

### Queue

```env
# Driver de queue (sync, database, redis, sqs)
QUEUE_CONNECTION=sync
```

### Mail

```env
# Driver de mail (log, smtp, mailgun, etc.)
MAIL_MAILER=log

# Configuration SMTP
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls

# Adresse d'expédition
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Broadcast

```env
# Driver de broadcast (log, pusher, redis)
BROADCAST_DRIVER=log
```

### Filesystem

```env
# Disque de fichiers par défaut
FILESYSTEM_DISK=local
```

---

## 🌍 Configuration par environnement

### Développement local

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

LOG_LEVEL=debug
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
MAIL_MAILER=log
```

### Tests

```env
APP_ENV=testing
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_DATABASE=:memory:

LOG_LEVEL=debug
CACHE_DRIVER=array
SESSION_DRIVER=array
QUEUE_CONNECTION=sync
MAIL_MAILER=array
```

### Production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://example.com

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite

LOG_LEVEL=error
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
MAIL_MAILER=smtp
```

---

## 🔐 Secrets et sécurité

### Bonnes pratiques

1. **Ne jamais commiter les secrets**
   ```bash
   # ✅ Bon - Fichier ignoré par Git
   .env
   
   # ❌ Mauvais - Commiter les secrets
   git add .env
   git commit -m "Add secrets"
   ```

2. **Utiliser des fichiers d'exemple**
   ```bash
   # Créer un template
   cp .env.example .env
   
   # Remplir avec vos valeurs
   # Mais ne pas commiter
   ```

3. **Utiliser GitHub Secrets pour CI/CD**
   ```yaml
   # Dans .github/workflows/gitops-ci-cd.yml
   env:
     APP_KEY: ${{ secrets.APP_KEY }}
     DB_PASSWORD: ${{ secrets.DB_PASSWORD }}
   ```

4. **Changer les clés en production**
   ```bash
   # Générer une nouvelle clé
   php artisan key:generate --force
   ```

5. **Utiliser des variables d'environnement système**
   ```bash
   # Linux/macOS
   export APP_KEY=base64:...
   export DB_PASSWORD=secure_password
   
   # Windows PowerShell
   $env:APP_KEY = "base64:..."
   $env:DB_PASSWORD = "secure_password"
   ```

### Secrets GitHub

Pour les déploiements automatisés :

1. Allez dans **Settings > Secrets and variables > Actions**
2. Cliquez sur **New repository secret**
3. Ajoutez vos secrets :
   - `APP_KEY`
   - `DB_PASSWORD`
   - `MAIL_PASSWORD`
   - etc.

4. Utilisez-les dans le workflow :
   ```yaml
   - name: Deploy
     env:
       APP_KEY: ${{ secrets.APP_KEY }}
       DB_PASSWORD: ${{ secrets.DB_PASSWORD }}
     run: ./scripts/deploy.sh
   ```

---

## ✅ Validation des variables

### Vérifier les variables

```bash
# Afficher toutes les variables
php artisan env

# Vérifier une variable spécifique
php artisan env APP_NAME

# Vérifier la configuration
php artisan config:show
```

### Valider au démarrage

```php
// Dans config/app.php ou un service provider
if (empty(env('APP_KEY'))) {
    throw new Exception('APP_KEY is not set');
}

if (env('APP_ENV') === 'production' && env('APP_DEBUG')) {
    throw new Exception('APP_DEBUG must be false in production');
}
```

### Erreurs courantes

| Erreur | Cause | Solution |
|--------|-------|----------|
| "APP_KEY environment variable is not set" | Clé manquante | `php artisan key:generate` |
| "Unable to open database file" | Chemin BD incorrect | Vérifier `DB_DATABASE` |
| "SQLSTATE[HY000]" | Permissions BD | Vérifier les permissions du dossier |
| "Connection refused" | Serveur BD non disponible | Vérifier `DB_HOST` et `DB_PORT` |

---

## 📝 Checklist de configuration

Avant de déployer :

- [ ] `.env` est configuré correctement
- [ ] `APP_KEY` est généré
- [ ] `APP_DEBUG=false` en production
- [ ] `DB_CONNECTION` est correct
- [ ] `DB_DATABASE` existe et est accessible
- [ ] `MAIL_*` est configuré si nécessaire
- [ ] Les secrets sont dans GitHub Secrets
- [ ] Les fichiers `.env` ne sont pas committés
- [ ] Les permissions des dossiers sont correctes

---

## 🔗 Ressources

- [Laravel Configuration](https://laravel.com/docs/configuration)
- [Environment Variables](https://laravel.com/docs/configuration#environment-configuration)
- [GitHub Secrets](https://docs.github.com/en/actions/security-guides/encrypted-secrets)
