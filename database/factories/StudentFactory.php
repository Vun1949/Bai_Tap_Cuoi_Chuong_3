<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vn = fake('vi_VN');
        $name = $vn->name();

        $domains = ['gmail.com', 'eaut.edu.vn'];
        $base = Str::of($name)->lower()->ascii()->replaceMatches('/[^a-z0-9\s]/', '')->replace(' ', '');
        $username = (string) $base;
        if ($username === '') {
            $username = 'sinhvien';
        }

        $email = $username.$this->faker->unique()->numberBetween(10, 9999).'@'.$vn->randomElement($domains);

        return [
            'name' => $name,
            'email' => $email,
        ];
    }
}
