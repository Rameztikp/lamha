<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelChalet extends Model
{
    /**
     * اسم الجدول في قاعدة البيانات
     *
     * @var string
     */
    protected $table = 'hotels_chalets';

    /**
     * الحقول القابلة للتعبئة
     *
     * @var array
     */
    protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'price_per_night',
        'capacity',
        'room_size',
        'beds',
        'bathrooms',
        'has_breakfast',
        'is_available',
        'max_adults',
        'max_children',
        'amenities',
        'main_image',
        'gallery'
    ];

    /**
     * الحقول التي يجب تحويلها إلى أنواعها المناسبة
     *
     * @var array
     */
    protected $casts = [
        'amenities' => 'array',
        'gallery' => 'array',
        'price_per_night' => 'decimal:2',
        'has_breakfast' => 'boolean',
        'is_available' => 'boolean',
        'room_size' => 'integer',
        'beds' => 'integer',
        'bathrooms' => 'integer',
        'max_adults' => 'integer',
        'max_children' => 'integer',
        'capacity' => 'integer',
    ];

    /**
     * العلاقة مع جدول الفنادق
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * نطاق الاستعلام للشاليهات المتاحة
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * الحصول على سعر الليلة مع التنسيق
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price_per_night, 2) . ' ر.س';
    }

    /**
     * الحصول على حجم الغرفة مع الوحدة
     */
    public function getRoomSizeWithUnitAttribute()
    {
        return $this->room_size ? $this->room_size . ' م²' : 'غير محدد';
    }

    /**
     * الحصول على الصورة الرئيسية مع رابط كامل
     */
    public function getMainImageUrlAttribute()
    {
        return $this->main_image ? asset('storage/' . $this->main_image) : asset('images/default-chalet.jpg');
    }

    /**
     * الحقول التي يجب إخفاؤها عند تحويل النموذج إلى مصفوفة أو JSON
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
