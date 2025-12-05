<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حجز - {{ $hotel->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin:0; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; background:#f3f4f6; }
        .page { min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1.5rem; }
        .card { background:#fff; border-radius:1.25rem; box-shadow:0 15px 35px rgba(15,23,42,.12); padding:2rem 1.75rem; max-width:520px; width:100%; }
        h1 { font-size:1.5rem; margin:0 0 .25rem; color:#111827; }
        p { margin:0 0 1.25rem; color:#6b7280; font-size:.9rem; }
        .hotel-name { font-weight:700; color:#111827; }
        .field { margin-bottom:.85rem; }
        label { display:block; margin-bottom:.35rem; font-size:.9rem; color:#374151; }
        input[type=date], input[type=number] {
            width:100%; padding:.6rem .75rem; border-radius:.6rem; border:1px solid #d1d5db; font-size:.9rem; outline:none;
        }
        input:focus { border-color:#2563eb; box-shadow:0 0 0 1px rgba(37,99,235,.15); }
        .btn-primary { width:100%; border:none; border-radius:.8rem; padding:.7rem 1rem; background:#10b981; color:#fff; font-weight:600; cursor:pointer; margin-top:.5rem; }
        .btn-primary:hover { background:#059669; }
        .back-link { margin-top:1rem; font-size:.85rem; text-align:center; }
        .back-link a { color:#2563eb; text-decoration:none; }
        .back-link a:hover { text-decoration:underline; }
        .error-list { background:#fef2f2; color:#b91c1c; border-radius:.75rem; padding:.6rem .8rem; font-size:.8rem; margin-bottom:1rem; }
        .error-list ul { margin:.25rem 0 0; padding-right:1.1rem; }
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        <h1>حجز إقامة</h1>
        <p>
            فندق: <span class="hotel-name">{{ $hotel->name }}</span><br>
            الموقع: {{ $hotel->location }}
        </p>

        @if($errors->any())
            <div class="error-list">
                <strong>حدثت بعض الأخطاء:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store') }}">
            @csrf
            <input type="hidden" name="hotels_chalets_id" value="{{ $hotel->hotels_chalets_id }}">

            <div class="field">
                <label for="check_in_date">تاريخ الوصول</label>
                <input id="check_in_date" type="date" name="check_in_date" value="{{ old('check_in_date') }}" required>
            </div>

            <div class="field">
                <label for="check_out_date">تاريخ المغادرة</label>
                <input id="check_out_date" type="date" name="check_out_date" value="{{ old('check_out_date') }}" required>
            </div>

            <div class="field">
                <label for="number_of_guests">عدد النزلاء</label>
                <input id="number_of_guests" type="number" name="number_of_guests" min="1" value="{{ old('number_of_guests', 1) }}" required>
            </div>

            <div class="field">
                <label for="number_of_rooms">عدد الغرف</label>
                <input id="number_of_rooms" type="number" name="number_of_rooms" min="1" value="{{ old('number_of_rooms', 1) }}" required>
            </div>

            <button type="submit" class="btn-primary">تأكيد الحجز</button>
        </form>

        <div class="back-link">
            <a href="{{ route('home') }}">العودة إلى الصفحة الرئيسية</a>
        </div>
    </div>
</div>
</body>
</html>
