<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Article;
use App\Models\User;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase; // Refresh the database before and after each test

    public function testIndex()
    {
        $response = $this->get(route('admin.article.index'));

        // Check if it's a redirection (status code 302)
        if ($response->status() == 302) {
            // If it's a redirect, assert that it redirects to the expected location (e.g., login or another page)
            $response->assertRedirect();
            // Add more assertions as needed for the redirection
        } else {
            // If it's not a redirect (status code 200), assert the expected content
            $response->assertStatus(200);
            $response->assertViewHas('article'); // Check if the view has the expected variable
        }
    }

    public function testCreate()
    {
        // Visit the create route
        $response = $this->get(route('admin.article.create'));

        // Check if it's a redirection (status code 302)
        if ($response->status() == 302) {
            // If it's a redirect, assert that it redirects to the expected location (e.g., a login page or the form creation page)
            $response->assertRedirect();
            // Add more assertions as needed for the redirection
        } else {
            // If it's not a redirect (status code 200), assert the expected content
            $response->assertStatus(200);
            // Add assertions for the expected content on the form creation page
        }
    }

    public function testUpdate()
    {
        // Create a test article
        $article = Article::factory()->create();

        // Simulate updating the article with new data
        $updatedData = [
            'title' => $article['title'],
            'content' => $article['content'],
        ];
        // Send a PUT request to the update route with the updated data
        $response = $this->put(route('admin.article.update', ['article' => $article->id]), $updatedData);

       // Assert that the response is successful (status code 200)
       $response->assertStatus(200);

        // Assert the JSON structure of the response
        $response->assertJson([
            'success' => true,
            'code' => 200,
            'message' => 'Data has been modified successfully',
            'data' => [
                'url' => route('admin.article.index'),
            ],
        ]);

       // Assert the redirection URL
       $responseJson = $response->json();
       $this->assertEquals(route('admin.article.index'), $responseJson['data']['url']);

    }


    // You can add more tests for form submissions and database interactions for create and update actions.
}
