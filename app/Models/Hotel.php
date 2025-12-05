<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Hotel extends Model
{
    protected $table = 'hotels';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'location',
        'phone_number',
        'email',
        'rating',
        'slug',
        'image',
        'is_active'
    ];
    
    /**
     * الحقول التي يجب تحويلها إلى أنواعها المناسبة
     *
     * @var array
     */
    protected $casts = [
        'rating' => 'decimal:1',
        'is_active' => 'boolean',
    ];
    
    /**
     * الحقول الإضافية التي يجب إضافتها للنموذج
     *
     * @var array
     */
    protected $appends = [
        'rating_stars',
        'image_url'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($hotel) {
            if (empty($hotel->slug)) {
                $hotel->slug = Str::slug($hotel->name);
            }
        });
    }

    /**
     * العلاقة مع جدول الشاليهات والغرف
     */
    public function chalets()
    {
        return $this->hasMany(HotelChalet::class);
    }

    /**
     * نطاق الاستعلام للفنادق النشطة
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * الحصول على التقييم مع النجوم
     */
    public function getRatingStarsAttribute()
    {
        if (!$this->rating) {
            return 'لا يوجد تقييم';
        }
        return str_repeat('⭐', (int) $this->rating);
    }

    /**
     * الحصول على رابط الصورة الكامل
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-hotel.jpg');
    }
}
