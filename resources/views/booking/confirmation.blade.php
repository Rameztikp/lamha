<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تأكيد الحجز - {{ $booking->booking_reference }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin:0; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; background:#f3f4f6; }
        .page { min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1.5rem; }
        .card { background:#fff; border-radius:1.25rem; box-shadow:0 15px 35px rgba(15,23,42,.12); padding:2rem 1.75rem; max-width:520px; width:100%; }
        h1 { font-size:1.5rem; margin:0 0 .25rem; color:#111827; }
        p { margin:0 0 1.25rem; color:#6b7280; font-size:.9rem; }
        .hotel-name { font-weight:700; color:#111827; }
        .booking-details { background:#f9fafb; border-radius:.75rem; padding:1rem; margin:1rem 0; }
        .detail-row { display:flex; justify-content:space-between; margin-bottom:.5rem; font-size:.9rem; }
        .detail-label { color:#6b7280; }
        .detail-value { color:#111827; font-weight:500; }
        .reference { background:#10b981; color:#fff; padding:.5rem 1rem; border-radius:.5rem; font-weight:600; text-align:center; margin:1rem 0; }
        .btn-primary { width:100%; border:none; border-radius:.8rem; padding:.7rem 1rem; background:#10b981; color:#fff; font-weight:600; cursor:pointer; margin-top:.5rem; }
        .btn-primary:hover { background:#059669; }
        .back-link { margin-top:1rem; font-size:.85rem; text-align:center; }
        .back-link a { color:#2563eb; text-decoration:none; }
        .back-link a:hover { text-decoration:underline; }
        .success-message { background:#d1fae5; color:#065f46; border-radius:.75rem; padding:.6rem .8rem; font-size:.9rem; margin-bottom:1rem; text-align:center; }
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        <h1>تم تأكيد الحجز بنجاح!</h1>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="reference">
            رقم الحجز: {{ $booking->booking_reference }}
        </div>

        <div class="booking-details">
            <div class="detail-row">
                <span class="detail-label">الفندق:</span>
                <span class="detail-value">{{ $booking->hotel->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">نوع الغرفة:</span>
                <span class="detail-value">{{ $booking->chalet->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">تاريخ الوصول:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">تاريخ المغادرة:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">عدد البالغين:</span>
                <span class="detail-value">{{ $booking->adults }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">عدد الأطفال:</span>
                <span class="detail-value">{{ $booking->children }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">إجمالي السعر:</span>
                <span class="detail-value">{{ number_format($booking->total_price, 2) }} ريال</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">حالة الحجز:</span>
                <span class="detail-value">{{ $booking->status_label }}</span>
            </div>
        </div>

        <p style="text-align:center; color:#6b7280; font-size:.85rem;">
            سيتم التواصل معك قريباً لتأكيد الحجز وإتمام عملية الدفع.
        </p>

        <a href="{{ route('bookings.my') }}" class="btn-primary" style="display:block; text-align:center; text-decoration:none;">عرض حجوزاتي</a>

        <div class="back-link">
            <a href="{{ route('home') }}">العودة إلى الصفحة الرئيسية</a>
        </div>
    </div>
</div>
</body>
</html>
