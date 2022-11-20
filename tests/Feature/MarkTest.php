<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarkTest extends TestCase
{
    public function test_store()
    {
        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json'
        ])->postJson('/api/marks',
            [
                'name'        => "Brastemp",
            ]
        );

        $response->assertStatus(201)
            ->assertJsonMissing(
                [
                    'name',
                    'id',
                ]
            );
    }

    public function test_update()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->getJson('/api/marks');

        $response->assertOk();
        $response = json_decode($response->getContent());

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/marks/' . $response->data[0]->id,
            [
                'name' => "Fischer",
            ]
        );

        $response->assertStatus(200)
            ->assertJson([
                'name' => "Fischer",
            ]);
    }

    public function test_get()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->getJson('/api/marks');

        $response->assertStatus(200)
            ->assertJsonMissing(
                [
                    'name',
                    'id',
                ]
            );
    }

    public function test_get_id()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->getJson('/api/marks');

        $response->assertOk();
        $response = json_decode($response->getContent());

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->getJson('/api/marks/' . $response->data[0]->id);

        $response->assertStatus(200)
            ->assertJsonMissing(
                [
                    'name',
                    'id',
                ]
            );
    }

    public function test_delete()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->getJson('/api/marks');

        $response->assertOk();
        $response = json_decode($response->getContent());

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->deleteJson('/api/marks/2' . $response->data[0]->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Registro excluído com sucesso'
            ]);
    }
}
