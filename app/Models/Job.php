<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'career_jobs';

    const STATUS_PUBLISHED = 1;
    const STATUS_PENDING = 0;

    public static function getStatusList(): array
    {
        return [
            self::STATUS_PUBLISHED => __('Published'),
            self::STATUS_PENDING => __('Pending'),
        ];
    }

    protected $fillable = [
        'title',
        'location',
        'department',
        'experience_level',
        'employment_type',
        'posted_at',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'posted_at' => 'date',
        'status' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderByDesc('posted_at')
            ->orderByDesc('id');
    }
}
