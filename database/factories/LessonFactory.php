<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vn = fake('vi_VN');

        $lessonTitles = [
            'Giới thiệu khóa học và mục tiêu',
            'Cài đặt môi trường và cấu hình dự án',
            'Tạo migration và cấu trúc bảng dữ liệu',
            'Eloquent ORM và cách làm việc với Model',
            'Relationship: hasMany / belongsTo / belongsToMany',
            'Form Request và Validation',
            'Upload file và lưu trữ ảnh',
            'Phân trang và tìm kiếm nâng cao',
            'Soft Delete và khôi phục dữ liệu',
            'Tối ưu truy vấn và tránh N+1',
        ];

        return [
            'course_id' => null,
            'title' => $vn->randomElement($lessonTitles),
            'content' => $vn->paragraphs(3, true),
            'video_url' => $this->faker->boolean(60) ? $this->faker->url() : null,
            'order' => $this->faker->numberBetween(1, 20),
        ];
    }
}
