<?php

namespace Tests\Feature;

use Tests\TestCase;

class ValidParenthesesTokenTest extends TestCase
{
    private function generateRandomString($length = 10)
    {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }

    /**
     * Test valid token with balanced parentheses.
     */
    public function test_001()
    {
        $alias = $this->generateRandomString();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer {}'
        ])->postJson('/api/v1/short-urls', [
            "url" => "https://www.example.com/mi-prueba-técnica-con-url-larga-para-acortar-y-pasar-el-test",
            "alias" => $alias,
            "description" => "Prueba técnica"
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test invalid token with unbalanced parentheses.
     */
    public function test_002()
    {
        $alias = $this->generateRandomString();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer {]'
        ])->postJson('/api/v1/short-urls', [
            "url" => "https://www.example.com/mi-prueba-técnica-con-url-larga-para-acortar-y-pasar-el-test",
            "alias" => $alias,
            "description" => "Prueba técnica"
        ]);

        $response->assertStatus(401)
            ->assertJson(['error' => 'Invalid token']);
    }

    /**
     * Test missing token.
     */
    public function test_003()
    {
        $alias = $this->generateRandomString();

        $response = $this->postJson('/api/v1/short-urls', [
            "url" => "https://www.example.com/mi-prueba-técnica-con-url-larga-para-acortar-y-pasar-el-test",
            "alias" => $alias,
            "description" => "Prueba técnica"
        ]);

        $response->assertStatus(401)
            ->assertJson(['error' => 'Invalid token']);
    }

    /**
     * Test token with no parentheses.
     */
    public function test_004()
    {
        $alias = $this->generateRandomString();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer noparentheses'
        ])->postJson('/api/v1/short-urls', [
            "url" => "https://www.example.com/mi-prueba-técnica-con-url-larga-para-acortar-y-pasar-el-test",
            "alias" => $alias,
            "description" => "Prueba técnica"
        ]);

        $response->assertStatus(401)
            ->assertJson(['error' => 'Invalid token']);
    }
}
