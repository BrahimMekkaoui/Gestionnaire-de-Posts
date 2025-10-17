# Exigences Fonctionnelles et Non-Fonctionnelles

## 📋 Exigences Fonctionnelles (EF)

### EF1 : Gestion des Posts (CRUD)

| Critère | Description |
|---------|-------------|
| **ID** | EF1 |
| **Titre** | Gestion complète des Posts |
| **Description** | L'application doit permettre de créer, lire, modifier et supprimer des posts |
| **Acteurs** | Utilisateur final |
| **Préconditions** | L'application est démarrée |
| **Étapes** | 1. Afficher la liste des posts<br>2. Créer un nouveau post<br>3. Consulter un post<br>4. Modifier un post<br>5. Supprimer un post |
| **Résultat attendu** | Les opérations CRUD fonctionnent correctement |
| **Priorité** | Critique |
| **Statut** | À implémenter |

### EF2 : Validation des données

| Critère | Description |
|---------|-------------|
| **ID** | EF2 |
| **Titre** | Validation des données de saisie |
| **Description** | L'application doit valider les données saisies par l'utilisateur |
| **Acteurs** | Utilisateur final |
| **Préconditions** | L'utilisateur remplit le formulaire |
| **Étapes** | 1. Saisir des données invalides<br>2. Soumettre le formulaire<br>3. Afficher les messages d'erreur |
| **Résultat attendu** | Les erreurs de validation sont affichées |
| **Priorité** | Haute |
| **Statut** | À implémenter |

### EF3 : Interface utilisateur

| Critère | Description |
|---------|-------------|
| **ID** | EF3 |
| **Titre** | Interface utilisateur intuitive |
| **Description** | L'interface doit être simple, claire et facile à utiliser |
| **Acteurs** | Utilisateur final |
| **Préconditions** | L'application est démarrée |
| **Étapes** | 1. Naviguer dans l'interface<br>2. Utiliser les formulaires |
| **Résultat attendu** | L'interface est ergonomique et responsive |
| **Priorité** | Moyenne |
| **Statut** | À implémenter |

---

## ⚙️ Exigences Non-Fonctionnelles (ENF)

### ENF1 : Performance

| Critère | Description |
|---------|-------------|
| **ID** | ENF1 |
| **Titre** | Performance de l'application |
| **Description** | L'application doit répondre rapidement aux requêtes utilisateur |
| **Mesure** | Temps de réponse < 500ms pour les opérations courantes |
| **Priorité** | Haute |
| **Statut** | À valider |

### ENF2 : Sécurité

| Critère | Description |
|---------|-------------|
| **ID** | ENF2 |
| **Titre** | Sécurité de l'application |
| **Description** | L'application doit implémenter les bonnes pratiques de sécurité |
| **Mesure** | Protection CSRF, validation des entrées, échappement des sorties |
| **Priorité** | Critique |
| **Statut** | À implémenter |

### ENF3 : Disponibilité

| Critère | Description |
|---------|-------------|
| **ID** | ENF3 |
| **Titre** | Disponibilité de l'application |
| **Description** | L'application doit être disponible 24/7 |
| **Mesure** | Uptime > 99% |
| **Priorité** | Haute |
| **Statut** | À valider |

### ENF4 : Maintenabilité

| Critère | Description |
|---------|-------------|
| **ID** | ENF4 |
| **Titre** | Maintenabilité du code |
| **Description** | Le code doit être bien structuré et documenté |
| **Mesure** | Respect des standards de codage, documentation complète |
| **Priorité** | Moyenne |
| **Statut** | À implémenter |

### ENF5 : Scalabilité

| Critère | Description |
|---------|-------------|
| **ID** | ENF5 |
| **Titre** | Scalabilité de l'application |
| **Description** | L'application doit pouvoir supporter une augmentation du nombre d'utilisateurs |
| **Mesure** | Architecture modulaire, utilisation de caches |
| **Priorité** | Moyenne |
| **Statut** | À valider |

### ENF6 : Compatibilité

| Critère | Description |
|---------|-------------|
| **ID** | ENF6 |
| **Titre** | Compatibilité des navigateurs |
| **Description** | L'application doit fonctionner sur les navigateurs modernes |
| **Mesure** | Chrome, Firefox, Safari, Edge (dernières versions) |
| **Priorité** | Moyenne |
| **Statut** | À valider |

### ENF7 : Testabilité

| Critère | Description |
|---------|-------------|
| **ID** | ENF7 |
| **Titre** | Couverture de tests |
| **Description** | L'application doit avoir une couverture de tests adéquate |
| **Mesure** | Couverture de tests > 70% |
| **Priorité** | Haute |
| **Statut** | À implémenter |

### ENF8 : DevOps et CI/CD

| Critère | Description |
|---------|-------------|
| **ID** | ENF8 |
| **Titre** | Pipeline CI/CD automatisé |
| **Description** | La chaîne d'intégration et de déploiement continu doit être automatisée |
| **Mesure** | Tests automatisés, déploiement automatisé, monitoring |
| **Priorité** | Critique |
| **Statut** | À implémenter |

---

## 📊 Matrice de traçabilité

| EF/ENF | Composant | Priorité | Statut |
|--------|-----------|----------|--------|
| EF1 | PostController, Post Model | Critique | À implémenter |
| EF2 | Validation Laravel | Haute | À implémenter |
| EF3 | Vues Blade, Bootstrap | Moyenne | À implémenter |
| ENF1 | Optimisation requêtes | Haute | À valider |
| ENF2 | CSRF, Validation | Critique | À implémenter |
| ENF3 | Infrastructure | Haute | À valider |
| ENF4 | Documentation, Code | Moyenne | À implémenter |
| ENF5 | Architecture | Moyenne | À valider |
| ENF6 | Frontend | Moyenne | À valider |
| ENF7 | Tests | Haute | À implémenter |
| ENF8 | GitHub Actions | Critique | À implémenter |
