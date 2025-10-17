<?php

namespace Tests\Unit;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_post()
    {
        // Arrange
        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post content.'
        ];

        // Act
        $post = Post::create($postData);

        // Assert
        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Test Post', $post->title);
        $this->assertEquals('This is a test post content.', $post->content);
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content.'
        ]);
    }

    /** @test */
    public function it_requires_title_and_content()
    {
        $this->expectException('Illuminate\Database\QueryException');
        
        // Try to create a post without required fields
        Post::create([]);
    }
}
