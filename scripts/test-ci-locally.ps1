# Script pour tester le workflow CI localement
# Simule les étapes du workflow GitHub Actions

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Test du workflow CI en local" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# 1. Installer les dépendances Composer
Write-Host "[1/7] Installation des dépendances Composer..." -ForegroundColor Yellow
composer install -q --no-ansi --no-interaction --no-progress --prefer-dist
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Échec de l'installation Composer" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Dépendances Composer installées" -ForegroundColor Green
Write-Host ""

# 2. Vérifier le formatage du code avec Pint
Write-Host "[2/7] Vérification du formatage (Pint)..." -ForegroundColor Yellow
vendor/bin/pint -v --test
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Échec de la vérification Pint" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Code correctement formaté" -ForegroundColor Green
Write-Host ""

# 3. Préparer la base de données SQLite
Write-Host "[3/7] Préparation de la base de données..." -ForegroundColor Yellow
if (Test-Path database/database.sqlite) {
    Remove-Item database/database.sqlite
}
New-Item -ItemType File -Path database/database.sqlite -Force | Out-Null
php artisan migrate:fresh --seed --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Échec de la migration/seed" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Base de données prête" -ForegroundColor Green
Write-Host ""

# 4. Installer les dépendances NPM
Write-Host "[4/7] Installation des dépendances NPM..." -ForegroundColor Yellow
npm ci --silent
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Échec de l'installation NPM" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Dépendances NPM installées" -ForegroundColor Green
Write-Host ""

# 5. Linter le frontend (ESLint)
Write-Host "[5/7] Lint du frontend (ESLint)..." -ForegroundColor Yellow
npm run lint
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Échec du linting" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Frontend linté avec succès" -ForegroundColor Green
Write-Host ""

# 6. Compiler les assets (Vite)
Write-Host "[6/7] Compilation des assets (Vite)..." -ForegroundColor Yellow
npm run build
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Échec de la compilation" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Assets compilés" -ForegroundColor Green
Write-Host ""

# 7. Exécuter les tests
Write-Host "[7/7] Exécution des tests..." -ForegroundColor Yellow
php artisan test
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Échec des tests" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Tous les tests passent" -ForegroundColor Green
Write-Host ""

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "✅ Workflow CI validé localement !" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
