# Guide de Test - Projet Laravel GitOps

## 📚 Table des matières

1. [Types de tests](#types-de-tests)
2. [Exécution des tests](#exécution-des-tests)
3. [Tests unitaires](#tests-unitaires)
4. [Tests de feature](#tests-de-feature)
5. [Couverture de code](#couverture-de-code)
6. [Bonnes pratiques](#bonnes-pratiques)
7. [Dépannage](#dépannage)

---

## 🧪 Types de tests

### 1. Tests unitaires

Testent les composants individuels isolément.

**Fichiers** : `tests/Unit/`

**Exemple** : Tester que le modèle Post peut être créé

```php
public function it_can_create_a_post()
{
    $post = Post::create([
        'title' => 'Test',
        'content' => 'Content'
    ]);
    
    $this->assertInstanceOf(Post::class, $post);
}
```

### 2. Tests de feature

Testent les routes, contrôleurs et flux complets.

**Fichiers** : `tests/Feature/`

**Exemple** : Tester que la route /posts affiche tous les posts

```php
public function it_can_display_all_posts()
{
    Post::factory(3)->create();
    
    $response = $this->get('/posts');
    
    $response->assertStatus(200);
}
```

### 3. Tests d'intégration

Testent l'interaction entre plusieurs composants.

**Exemple** : Tester le flux complet de création d'un post

```php
public function it_can_create_and_display_a_post()
{
    $response = $this->post('/posts', [
        'title' => 'Test',
        'content' => 'Content'
    ]);
    
    $this->assertDatabaseHas('posts', [
        'title' => 'Test'
    ]);
}
```

---

## 🚀 Exécution des tests

### Tous les tests

```bash
php artisan test
```

### Tests spécifiques

```bash
# Tests unitaires uniquement
php artisan test --filter Unit

# Tests de feature uniquement
php artisan test --filter Feature

# Un fichier de test spécifique
php artisan test tests/Unit/PostTest.php

# Une méthode de test spécifique
php artisan test --filter it_can_create_a_post
```

### Avec options

```bash
# Afficher les détails
php artisan test --verbose

# Arrêter au premier échec
php artisan test --stop-on-failure

# Afficher les tests lents
php artisan test --slow=500

# Rapport de couverture
php artisan test --coverage

# Rapport de couverture en HTML
php artisan test --coverage --coverage-html=coverage
```

### Exécution parallèle

```bash
# Exécuter les tests en parallèle (plus rapide)
php artisan test --parallel
```

---

## 🔬 Tests unitaires

### Structure d'un test unitaire

```php
<?php

namespace Tests\Unit;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;  // Réinitialise la BD après chaque test

    /** @test */
    public function it_can_create_a_post()
    {
        // Arrange (Préparer)
        $postData = [
            'title' => 'Test Post',
            'content' => 'Test content'
        ];

        // Act (Agir)
        $post = Post::create($postData);

        // Assert (Vérifier)
        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Test Post', $post->title);
    }
}
```

### Assertions courantes

```php
// Vérifier l'égalité
$this->assertEquals('expected', $actual);
$this->assertNotEquals('expected', $actual);

// Vérifier le type
$this->assertInstanceOf(Post::class, $post);

// Vérifier les valeurs booléennes
$this->assertTrue($condition);
$this->assertFalse($condition);

// Vérifier les collections
$this->assertCount(3, $posts);
$this->assertEmpty($posts);
$this->assertNotEmpty($posts);

// Vérifier la base de données
$this->assertDatabaseHas('posts', ['title' => 'Test']);
$this->assertDatabaseMissing('posts', ['title' => 'Deleted']);
```

### Exemple complet

```php
class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_title_and_content()
    {
        $this->expectException('Illuminate\Database\QueryException');
        
        Post::create([]);
    }

    /** @test */
    public function it_can_update_a_post()
    {
        $post = Post::factory()->create();
        
        $post->update([
            'title' => 'Updated Title'
        ]);
        
        $this->assertEquals('Updated Title', $post->fresh()->title);
    }

    /** @test */
    public function it_can_delete_a_post()
    {
        $post = Post::factory()->create();
        $id = $post->id;
        
        $post->delete();
        
        $this->assertDatabaseMissing('posts', ['id' => $id]);
    }
}
```

---

## 🌐 Tests de feature

### Structure d'un test de feature

```php
<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_all_posts()
    {
        // Arrange
        Post::factory(3)->create();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }
}
```

### Assertions courantes pour les routes

```php
// Vérifier le statut HTTP
$response->assertStatus(200);
$response->assertOk();
$response->assertNotFound();
$response->assertForbidden();

// Vérifier la vue
$response->assertViewIs('posts.index');
$response->assertViewHas('posts');

// Vérifier les redirections
$response->assertRedirect('/posts');
$response->assertRedirectToRoute('posts.index');

// Vérifier le contenu
$response->assertSee('Post Title');
$response->assertDontSee('Deleted');

// Vérifier les erreurs de validation
$response->assertSessionHasErrors(['title', 'content']);
$response->assertSessionHasNoErrors();

// Vérifier les messages de session
$response->assertSessionHas('success');
$response->assertSessionMissing('error');
```

### Exemple complet

```php
class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_post()
    {
        $response = $this->post('/posts', [
            'title' => 'Test Post',
            'content' => 'Test content'
        ]);

        $response->assertRedirect('/posts');
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post'
        ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->post('/posts', []);

        $response->assertSessionHasErrors(['title', 'content']);
    }

    /** @test */
    public function it_can_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->delete("/posts/{$post->id}");

        $response->assertRedirect('/posts');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
```

---

## 📊 Couverture de code

### Générer un rapport de couverture

```bash
# Rapport de couverture en ligne de commande
php artisan test --coverage

# Rapport de couverture en HTML
php artisan test --coverage --coverage-html=coverage

# Rapport de couverture en Clover XML
php artisan test --coverage --coverage-clover=coverage.xml
```

### Interpréter le rapport

```
File                                  | % Stmt | % Bran | % Func | % Line |
---------------------------------------------------------------------------
app/Models/Post.php                   |  95.5  |  90.0  |  100   |  95.5  |
app/Http/Controllers/PostController   |  88.2  |  75.0  |  85.7  |  88.2  |
---------------------------------------------------------------------------
TOTAL                                 |  91.8  |  82.5  |  92.8  |  91.8  |
```

### Objectifs de couverture

- **Critique** : > 90%
- **Bon** : > 80%
- **Acceptable** : > 70%
- **Insuffisant** : < 70%

---

## ✅ Bonnes pratiques

### 1. Nommer les tests clairement

```php
// ✅ Bon
public function it_can_create_a_post()
public function it_validates_title_is_required()
public function it_returns_404_for_nonexistent_post()

// ❌ Mauvais
public function test1()
public function testPost()
public function test()
```

### 2. Utiliser le pattern AAA (Arrange-Act-Assert)

```php
public function it_can_update_a_post()
{
    // Arrange - Préparer les données
    $post = Post::factory()->create();
    
    // Act - Exécuter l'action
    $post->update(['title' => 'Updated']);
    
    // Assert - Vérifier le résultat
    $this->assertEquals('Updated', $post->fresh()->title);
}
```

### 3. Tester un seul comportement par test

```php
// ✅ Bon - Un test par comportement
public function it_can_create_a_post() { ... }
public function it_validates_title_is_required() { ... }

// ❌ Mauvais - Plusieurs comportements
public function it_can_create_and_update_a_post() { ... }
```

### 4. Utiliser les factories

```php
// ✅ Bon - Utiliser les factories
$post = Post::factory()->create();
$posts = Post::factory(5)->create();

// ❌ Mauvais - Créer manuellement
$post = new Post();
$post->title = 'Test';
$post->save();
```

### 5. Isoler les tests

```php
// ✅ Bon - Chaque test est indépendant
class PostTest extends TestCase
{
    use RefreshDatabase;  // Réinitialise la BD
    
    public function it_can_create_a_post() { ... }
    public function it_can_delete_a_post() { ... }
}

// ❌ Mauvais - Tests dépendants
public function it_creates_then_deletes_a_post() { ... }
```

### 6. Tester les cas d'erreur

```php
public function it_validates_title_max_length()
{
    $response = $this->post('/posts', [
        'title' => str_repeat('a', 256),
        'content' => 'Valid'
    ]);
    
    $response->assertSessionHasErrors('title');
}
```

---

## 🔍 Dépannage

### Les tests ne s'exécutent pas

```bash
# Vérifier que PHPUnit est installé
composer show phpunit/phpunit

# Vérifier la configuration phpunit.xml
cat phpunit.xml

# Exécuter avec verbosité
php artisan test --verbose
```

### Erreur : "Class not found"

```bash
# Regénérer l'autoloader
composer dump-autoload

# Vérifier que le fichier existe
ls tests/Unit/PostTest.php
```

### Erreur : "Database error"

```bash
# Vérifier la configuration .env.testing
cat .env.testing

# Vérifier que RefreshDatabase est utilisé
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
}
```

### Les tests sont lents

```bash
# Exécuter en parallèle
php artisan test --parallel

# Identifier les tests lents
php artisan test --slow=500

# Optimiser les factories
Post::factory(100)->create();  // Lent
Post::factory(100)->create();  // Utiliser createMany
```

### Erreur : "Undefined variable"

```php
// ✅ Bon - Utiliser compact()
$response = $this->get('/posts');
$response->assertViewHas('posts');

// ❌ Mauvais - Oublier de passer la variable
$response->assertViewHas('posts');  // posts n'est pas défini
```

---

## 📈 Métriques de test

### Objectifs recommandés

| Métrique | Objectif |
|----------|----------|
| Couverture de code | > 80% |
| Nombre de tests | > 50 |
| Temps d'exécution | < 30s |
| Taux de réussite | 100% |

### Suivi des tests

```bash
# Afficher les statistiques
php artisan test --verbose

# Exporter les résultats
php artisan test --log-junit=test-results.xml
```

---

## 🎓 Ressources

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Testing Best Practices](https://laravel.com/docs/testing#best-practices)
