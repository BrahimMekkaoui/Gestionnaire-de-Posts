<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_display_all_posts()
    {
        // Créer quelques posts
        Post::factory(3)->create();

        // Faire une requête GET
        $response = $this->get('/posts');

        // Vérifier que la réponse est OK
        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }

    #[Test]
    public function it_can_create_a_post()
    {
        // Faire une requête POST
        $response = $this->post('/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
        ]);

        // Vérifier que le post a été créé
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
        ]);

        // Vérifier la redirection
        $response->assertRedirect('/posts');
    }

    #[Test]
    public function it_can_show_a_post()
    {
        // Créer un post
        $post = Post::factory()->create();

        // Faire une requête GET
        $response = $this->get("/posts/{$post->id}");

        // Vérifier que la réponse est OK
        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
    }

    #[Test]
    public function it_can_update_a_post()
    {
        // Créer un post
        $post = Post::factory()->create();

        // Faire une requête PUT
        $response = $this->put("/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);

        // Vérifier que le post a été mis à jour
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);

        // Vérifier la redirection
        $response->assertRedirect('/posts');
    }

    #[Test]
    public function it_can_delete_a_post()
    {
        // Créer un post
        $post = Post::factory()->create();

        // Faire une requête DELETE
        $response = $this->delete("/posts/{$post->id}");

        // Vérifier que le post a été supprimé
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);

        // Vérifier la redirection
        $response->assertRedirect('/posts');
    }

    #[Test]
    public function it_validates_required_fields()
    {
        // Faire une requête POST sans données
        $response = $this->post('/posts', []);

        // Vérifier que la validation a échoué
        $response->assertSessionHasErrors(['title', 'content']);
    }

    #[Test]
    public function it_validates_title_max_length()
    {
        // Créer un titre trop long
        $longTitle = str_repeat('a', 256);

        // Faire une requête POST
        $response = $this->post('/posts', [
            'title' => $longTitle,
            'content' => 'Valid content',
        ]);

        // Vérifier que la validation a échoué
        $response->assertSessionHasErrors('title');
    }
}
