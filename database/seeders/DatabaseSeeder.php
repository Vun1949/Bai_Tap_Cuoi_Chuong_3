<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $courses = Course::factory(12)->create();

        foreach ($courses as $course) {
            Lesson::factory(random_int(3, 10))->create([
                'course_id' => $course->id,
            ]);
        }

        $students = Student::factory(40)->create();

        // tạo đăng ký ngẫu nhiên, tránh trùng khóa (course_id, student_id)
        foreach ($students as $student) {
            $pick = $courses->random(random_int(1, 4));

            foreach ($pick as $course) {
                Enrollment::firstOrCreate([
                    'course_id' => $course->id,
                    'student_id' => $student->id,
                ], [
                    'enrolled_at' => now()->subDays(random_int(0, 60)),
                ]);
            }
        }
    }
}
