<?php

namespace Tests\Feature;

use App\Models\Personalpolicia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolPoliciaTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_allows_access_for_authorized_user()
    {

                // Crea un usuario con un rol diferente
                $user = Personalpolicia::factory()->create(['rol_personal_policias' => 'policia']); // Asumiendo que tienes un rol 'usuario'

                // Realiza la solicitud con autenticación
                $response = $this->actingAs($user)->get('/api/quejasugerenciasubcircuitofechas/?fechainicio=2023-01-01&fechafin=2023-01-31');

                // Verifica que el acceso sea denegado
                $response->assertStatus(200); // Verifica que el estado sea 403 (Prohibido)

    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_denies_access_for_unauthorized_user()
    {
// Crea un usuario con un rol específico
$user = Personalpolicia::factory()->create(['rol_personal_policias' => 'administrador']); // Asumiendo que tienes una columna 'role'

// Realiza la solicitud con autenticación
$response = $this->actingAs($user)->get('/api/quejasugerenciasubcircuitofechas/?fechainicio=2023-01-01&fechafin=2023-01-31');

// Verifica que el acceso sea permitido
$response->assertStatus(403); // Verifica que el estado sea 200 (OK)
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_denies_access_for_guest_user()
    {
        // Realiza la solicitud sin autenticación
        $response = $this->get('/api/quejasugerenciasubcircuitofechas/?fechainicio=2023-01-01&fechafin=2023-01-31');

        // Verifica que el acceso sea denegado
        $response->assertStatus(401); // Verifica que el estado sea 401 (No autorizado)
    }
}
