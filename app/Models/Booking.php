<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Booking extends Model
{
    use SoftDeletes;

    protected $table = 'bookings';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * الحقول القابلة للتعبئة
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'hotel_id',
        'hotel_chalet_id',
        'booking_reference',
        'check_in_date',
        'check_out_date',
        'adults',
        'children',
        'special_requests',
        'status',
        'total_price',
        'payment_status',
        'payment_method',
        'transaction_id',
        'cancellation_reason',
        'cancelled_at',
    ];

    /**
     * الحقول التي يجب تحويلها إلى أنواعها المناسبة
     *
     * @var array
     */
    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_price' => 'decimal:2',
        'adults' => 'integer',
        'children' => 'integer',
        'cancelled_at' => 'datetime',
    ];

    /**
     * الحقول التي يجب إخفاؤها عند التحويل إلى مصفوفة أو JSON
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * الحقول الإضافية التي يجب إضافتها للنموذج
     *
     * @var array
     */
    protected $appends = [
        'total_nights',
        'is_past',
        'is_upcoming',
        'is_current',
        'status_label',
        'payment_status_label',
    ];

    /**
     * الحالات المحتملة للحجز
     */
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_NO_SHOW = 'no_show';

    /**
     * حالات الدفع المحتملة
     */
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_REFUNDED = 'refunded';
    const PAYMENT_PARTIALLY_REFUNDED = 'partially_refunded';

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * العلاقة مع الفندق
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * العلاقة مع الشاليه/الغرفة
     */
    public function chalet()
    {
        return $this->belongsTo(HotelChalet::class, 'hotel_chalet_id');
    }

    /**
     * نطاق الاستعلام للحجوزات النشطة (غير الملغاة)
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', self::STATUS_CANCELLED);
    }

    /**
     * نطاق الاستعلام للحجوزات القادمة
     */
    public function scopeUpcoming($query)
    {
        return $query->where('check_in_date', '>', now())
                    ->where('status', self::STATUS_CONFIRMED);
    }

    /**
     * نطاق الاستعلام للحجوزات السابقة
     */
    public function scopePast($query)
    {
        return $query->where('check_out_date', '<', now())
                    ->whereIn('status', [self::STATUS_COMPLETED, self::STATUS_CANCELLED]);
    }

    /**
     * نطاق الاستعلام للحجوزات الحالية
     */
    public function scopeCurrent($query)
    {
        $today = now()->format('Y-m-d');
        return $query->where('check_in_date', '<=', $today)
                    ->where('check_out_date', '>=', $today)
                    ->where('status', self::STATUS_CONFIRMED);
    }

    /**
     * الحصول على عدد الليالي
     */
    public function getTotalNightsAttribute()
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }

    /**
     * التحقق مما إذا كان الحجز في الماضي
     */
    public function getIsPastAttribute()
    {
        return $this->check_out_date->lt(now());
    }

    /**
     * التحقق مما إذا كان الحجز قادم
     */
    public function getIsUpcomingAttribute()
    {
        return $this->check_in_date->gt(now());
    }

    /**
     * التحقق مما إذا كان الحجز حالياً
     */
    public function getIsCurrentAttribute()
    {
        return $this->check_in_date->lte(now()) && $this->check_out_date->gte(now());
    }

    /**
     * الحصول على تسمية حالة الحجز
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_PENDING => 'قيد الانتظار',
            self::STATUS_CONFIRMED => 'مؤكد',
            self::STATUS_CANCELLED => 'ملغي',
            self::STATUS_COMPLETED => 'مكتمل',
            self::STATUS_NO_SHOW => 'لم يحضر',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * الحصول على تسمية حالة الدفع
     */
    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            self::PAYMENT_PENDING => 'قيد الانتظار',
            self::PAYMENT_PAID => 'مدفوع',
            self::PAYMENT_FAILED => 'فشل الدفع',
            self::PAYMENT_REFUNDED => 'تم الاسترداد',
            self::PAYMENT_PARTIALLY_REFUNDED => 'تم استرداد جزئي',
        ];

        return $labels[$this->payment_status] ?? $this->payment_status;
    }

    /**
     * تحديد ما إذا كان يمكن إلغاء الحجز
     */
    public function canBeCancelled()
    {
        return !in_array($this->status, [self::STATUS_CANCELLED, self::STATUS_COMPLETED, self::STATUS_NO_SHOW])
            && $this->check_in_date->gt(now()->addDays(1)); // يمكن الإلغاء قبل 24 ساعة من الوصول
    }

    /**
     * إلغاء الحجز
     */
    public function cancel($reason = null)
    {
        if (!$this->canBeCancelled()) {
            return false;
        }

        $this->update([
            'status' => self::STATUS_CANCELLED,
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
        ]);

        // هنا يمكنك إضافة إرسال إشعارات أو رسائل بريد إلكتروني
        // Notification::send($this->user, new BookingCancelled($this));

        return true;
    }
    }
}
