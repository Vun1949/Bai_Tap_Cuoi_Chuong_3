<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'image_path',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (Course $course) {
            if (blank($course->slug) && filled($course->name)) {
                $course->slug = Str::slug($course->name);
            }
        });
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withPivot(['id', 'enrolled_at', 'created_at', 'updated_at'])
            ->withTimestamps();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePriceBetween($query, ?float $min, ?float $max)
    {
        return $query
            ->when($min !== null, fn ($q) => $q->where('price', '>=', $min))
            ->when($max !== null, fn ($q) => $q->where('price', '<=', $max));
    }
}
