<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vn = fake('vi_VN');

        $topics = [
            'Lập trình PHP cơ bản',
            'Laravel từ cơ bản đến nâng cao',
            'Cơ sở dữ liệu SQLite/MySQL',
            'Lập trình Web với HTML/CSS/JS',
            'Lập trình hướng đối tượng (OOP) trong PHP',
            'Thiết kế Database & ERD',
            'Xây dựng REST API với Laravel',
            'Kỹ năng Git & GitHub cho dự án',
            'Kiểm thử cơ bản cho Web (Testing)',
            'Xây dựng dự án CRUD thực tế',
            'Bảo mật cơ bản trong Web',
            'Tối ưu truy vấn & hiệu năng',
        ];

        $name = $vn->randomElement($topics).' - '.$vn->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.$this->faker->unique()->numberBetween(10, 9999),
            'price' => $this->faker->numberBetween(199000, 3999000),
            'description' => $vn->paragraphs(2, true),
            'image_path' => null,
            'status' => $this->faker->randomElement(['draft', 'published']),
        ];
    }
}
