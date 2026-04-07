# MINI PROJECT – QUẢN LÝ KHÓA HỌC (Course Management System)

## 1) Giới thiệu

Đây là mini project theo yêu cầu Chương 3: **quản lý khóa học – bài học – đăng ký học**, áp dụng:

- Form & Request
- Validation (FormRequest)
- Controller (MVC)
- Eloquent ORM (relationship nhiều bảng)
- Soft Delete
- Tối ưu truy vấn (tránh N+1) + eager loading

## 2) Công nghệ sử dụng

- **Laravel 12** (PHP Framework)
- **PHP 8.2** (chạy bằng `C:\xampp\php\php.exe`)
- **SQLite** (database file: `database/database.sqlite`)
- **Blade Template** + **Bootstrap 5** (UI)

## 3) Cài đặt & chạy project (từ A đến Z – Windows)

### 3.1. Yêu cầu môi trường

- Cài PHP 8.2 (đã có sẵn trong XAMPP): `C:\xampp\php\php.exe`
- Cài Composer

### 3.2. Cài dependencies

Mở PowerShell tại thư mục dự án, chạy:

```powershell
& "C:\xampp\php\php.exe" -v
composer -V
composer install
```

### 3.3. Tạo file cấu hình môi trường `.env`

```powershell
copy .env.example .env
& "C:\xampp\php\php.exe" artisan key:generate
```

Lưu ý DB đang dùng SQLite (mặc định đã cấu hình):

- `.env`: `DB_CONNECTION=sqlite`
- File DB: `database/database.sqlite`

### 3.4. Tạo bảng và seed dữ liệu mẫu

```powershell
& "C:\xampp\php\php.exe" artisan migrate:fresh --seed
```

### 3.5. Bật hiển thị ảnh upload (storage link)

```powershell
& "C:\xampp\php\php.exe" artisan storage:link
```

### 3.6. Chạy web server

```powershell
& "C:\xampp\php\php.exe" artisan serve --host=127.0.0.1 --port=8000
```

Mở trình duyệt: `http://127.0.0.1:8000` (tự chuyển sang `/dashboard`)

## 4) Cấu trúc dự án (MVC + Eloquent ORM)

### 4.1. Mô hình kiến trúc

- **MVC**
  - **Model**: `app/Models/*` (Eloquent ORM)
  - **View**: `resources/views/*` (Blade)
  - **Controller**: `app/Http/Controllers/*Controller.php`
- **ORM (Eloquent)**
  - Dùng relationship: `hasMany`, `belongsTo`, `belongsToMany`
  - Không dùng SQL thuần cho nghiệp vụ CRUD

### 4.2. Các file/thư mục chính

- **Models**
  - `app/Models/Course.php`
  - `app/Models/Lesson.php`
  - `app/Models/Student.php`
  - `app/Models/Enrollment.php`
- **Controllers**
  - `app/Http/Controllers/DashboardController.php`
  - `app/Http/Controllers/CourseController.php`
  - `app/Http/Controllers/LessonController.php`
  - `app/Http/Controllers/EnrollmentController.php`
- **FormRequest (Validation)**
  - `app/Http/Requests/CourseRequest.php`
  - `app/Http/Requests/LessonRequest.php`
  - `app/Http/Requests/EnrollmentRequest.php`
- **Migrations**
  - `database/migrations/*create_courses_table.php`
  - `database/migrations/*create_lessons_table.php`
  - `database/migrations/*create_students_table.php`
  - `database/migrations/*create_enrollments_table.php`
- **Views (Blade)**
  - Layout: `resources/views/layouts/master.blade.php`
  - Sidebar component: `resources/views/components/sidebar.blade.php`
  - Dashboard: `resources/views/dashboard/index.blade.php`
  - Courses: `resources/views/courses/*`
  - Lessons: `resources/views/lessons/*`
  - Enrollments: `resources/views/enrollments/*`

## 5) Mô tả chức năng & màn hình

### 5.1. Dashboard (`/dashboard`)

Hiển thị:

- Tổng số khóa học
- Tổng số học viên
- Tổng doanh thu
- Khóa học nhiều học viên nhất
- 5 khóa học mới
- Bảng thống kê: doanh thu theo khóa + tổng học viên theo khóa

### 5.2. Courses

- **Danh sách** (`/courses`)
  - Hiển thị: tên, giá, trạng thái, ảnh, số bài học, số học viên
  - Phân trang (paginate)
  - Tìm kiếm nâng cao: tên / giá / trạng thái
  - Lọc & sắp xếp: giá / số học viên / ngày tạo
- **Thêm mới** (`/courses/create`)
  - Validate: `name` required, `price > 0`, `status` hợp lệ
  - Upload ảnh
  - Slug: tự sinh nếu bỏ trống
- **Cập nhật** (`/courses/{course}/edit`)
  - Hiển thị dữ liệu cũ để sửa
  - Đổi ảnh (xóa ảnh cũ trên disk public nếu upload mới)
- **Xóa (Soft Delete)** (`DELETE /courses/{course}`)
- **Thùng rác & khôi phục**
  - Danh sách khóa học đã xóa: `/courses-trash`
  - Khôi phục: `POST /courses/{id}/restore`

### 5.3. Lessons (theo từng khóa học)

- Danh sách bài học của khóa: `/courses/{course}/lessons`
  - Sắp xếp theo `order`
- Thêm/Sửa/Xóa:
  - `/courses/{course}/lessons/create`
  - `/courses/{course}/lessons/{lesson}/edit`

### 5.4. Enrollments

- Danh sách đăng ký: `/enrollments`
  - Lọc theo khóa học
  - Hiển thị tổng số học viên (distinct)
- Đăng ký khóa học: `/enrollments/create`
  - Chọn khóa học + nhập tên/email
  - Email đã tồn tại thì dùng lại student; chưa có thì tạo mới
  - Chống đăng ký trùng theo cặp `(course_id, student_id)`

## 6) Tối ưu truy vấn (Optimization) & N+1

- Danh sách courses dùng eager loading + count:
  - `with(['lessons','enrollments'])`
  - `withCount(['lessons','enrollments'])` để có `lessons_count`, `enrollments_count`
- Danh sách enrollments:
  - `Enrollment::with(['course','student'])` để tránh N+1 khi hiển thị tên khóa học/học viên

**N+1 query**:

- Xảy ra khi lấy 1 danh sách \(N\) bản ghi, rồi trong vòng lặp lại query thêm quan hệ cho từng dòng ⇒ tổng query \(1 + N\).
- Cách xử lý: dùng `with()` / `withCount()` để load trước quan hệ.

## 7) Scope

Trong `app/Models/Course.php`:

- `scopePublished()` – lọc khóa học published
- `scopePriceBetween($min, $max)` – lọc theo khoảng giá

