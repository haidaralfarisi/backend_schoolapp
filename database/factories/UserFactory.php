<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => $this->faker->unique()->numerify('##########'), // 10 digit angka untuk NIP
            'fullname' => $this->faker->name(), // Ganti dari 'name' ke 'fullname'
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Hash password agar aman
            'level' => $this->faker->randomElement(['GURU', 'TUKEUANGAN', 'ORANGTUA', 'KEUANGANPUSAT']), // Level random
            'photo' => null, // Bisa diubah menjadi URL dummy jika perlu
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
