<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplianceTest extends TestCase
{
    public function test_store()
    {
        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json'
        ])->postJson('/api/marks',
            [
                'name'        => "Electrolux",
            ]
        );

        $response->assertCreated();
        $response = json_decode($response->getContent());

        $response = $this->withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json'
        ])->postJson('/api/appliances',
            [
                'name'        => "Geladeira Frost Free",
                'description' => "Este produto é totalmente versátil. Tudo para ser personalizado para comportar o que você preferir.",
                'voltage'     => 110,
                'mark_id'     => $response->id,
            ]
        );

        $response->assertStatus(201)
            ->assertJsonMissing(
                [
                    'name',
                    'description',
                    'voltage',
                    'mark_id',
                    'id',
                ]
            );
    }

    public function test_update()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->getJson('/api/appliances');

        $response->assertOk();
        $response = json_decode($response->getContent());

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/appliances/' . $response->data[0]->id,
            [
                'name' => "Geladeira Frost Free 220v",
            ]
        );

        $response->assertStatus(200)
            ->assertJson([
                'name' => "Geladeira Frost Free 220v",
            ]);
    }

    public function test_get()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->getJson('/api/appliances');

        $response->assertStatus(200)
            ->assertJsonMissing(
                [
                    'name',
                    'description',
                    'voltage',
                    'mark_id',
                    'id',
                ]
            );
    }

    public function test_get_id()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->getJson('/api/appliances');

        $response->assertOk();
        $response = json_decode($response->getContent());

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->getJson('/api/appliances/' . $response->data[0]->id);

        $response->assertStatus(200)
            ->assertJsonMissing(
                [
                    'name',
                    'description',
                    'voltage',
                    'mark_id',
                    'id',
                ]
            );
    }

    public function test_delete()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->getJson('/api/appliances');

        $response->assertOk();
        $response = json_decode($response->getContent());

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->deleteJson('/api/appliances/' . $response->data[0]->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Registro excluído com sucesso'
            ]);
    }
}
