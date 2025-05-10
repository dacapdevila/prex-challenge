<?php

namespace Tests\Feature\FormRequest;

use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\Rules\Password;
use Tests\TestCase;

class RegisterRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_request_has_rules()
    {
        $request = new RegisterRequest;
        $rules = $request->rules();

        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('email', $rules);
        $this->assertArrayHasKey('password', $rules);

        $this->assertContains('required', $rules['name']);
        $this->assertContains('string', $rules['name']);

        $this->assertContains('required', $rules['email']);
        $this->assertContains('email', $rules['email']);

        $this->assertContains('required', $rules['password']);
        $this->assertContains('string', $rules['password']);

        $this->assertTrue(collect($rules['password'])->contains(function ($rule) {
            return $rule instanceof Password;
        }));
    }
}
