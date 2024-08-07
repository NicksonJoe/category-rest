<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public const FIELD_NAME = 'name';
    public const FIELD_CATEGORY_ID = 'category_id';

    public $timestamps = false;

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_CATEGORY_ID,
    ];

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function childrenCategories(): HasMany
    {
        return $this->hasMany(Category::class)->with('categories');
    }

    public static function boot(): void
    {
        parent::boot();
    }
}
