<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب - لامحة</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin:0; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; background:#f3f4f6; }
        .page { min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1.5rem; }
        .card { background:#fff; border-radius:1.25rem; box-shadow:0 15px 35px rgba(15,23,42,.12); padding:2rem 1.75rem; max-width:520px; width:100%; }
        h1 { font-size:1.6rem; margin:0 0 .25rem; color:#111827; }
        p { margin:0 0 1.5rem; color:#6b7280; font-size:.9rem; }
        .grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:.75rem .9rem; }
        .field { margin-bottom:.9rem; }
        label { display:block; margin-bottom:.35rem; font-size:.9rem; color:#374151; }
        input[type=text], input[type=email], input[type=password] {
            width:100%; padding:.6rem .75rem; border-radius:.6rem; border:1px solid #d1d5db; font-size:.9rem; outline:none;
        }
        input:focus { border-color:#2563eb; box-shadow:0 0 0 1px rgba(37,99,235,.15); }
        .gender-row { display:flex; gap:1rem; align-items:center; font-size:.85rem; color:#4b5563; }
        .btn-primary { width:100%; border:none; border-radius:.8rem; padding:.7rem 1rem; background:#2563eb; color:#fff; font-weight:600; cursor:pointer; margin-top:.5rem; }
        .btn-primary:hover { background:#1d4ed8; }
        .link { margin-top:1rem; font-size:.85rem; color:#6b7280; }
        .link a { color:#2563eb; text-decoration:none; }
        .link a:hover { text-decoration:underline; }
        .status { font-size:.8rem; margin-bottom:.75rem; color:#059669; }
        .error-list { background:#fef2f2; color:#b91c1c; border-radius:.75rem; padding:.6rem .8rem; font-size:.8rem; margin-bottom:1rem; }
        .error-list ul { margin:.25rem 0 0; padding-right:1.1rem; }
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        <h1>إنشاء حساب جديد</h1>
        <p>قم بتعبئة البيانات التالية لإنشاء حسابك في منصة لامحة.</p>

        @if(session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif

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

        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="grid">
                <div class="field">
                    <label for="name">الاسم الكامل</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="field">
                    <label for="email">البريد الإلكتروني</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="field">
                    <label for="phone">رقم الهاتف</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required>
                </div>
                <div class="field">
                    <label for="address">العنوان</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" required>
                </div>
            </div>

            <div class="field">
                <label>الجنس</label>
                <div class="gender-row">
                    <label><input type="radio" name="gender" value="male" {{ old('gender')=='male' ? 'checked' : '' }}> ذكر</label>
                    <label><input type="radio" name="gender" value="female" {{ old('gender')=='female' ? 'checked' : '' }}> أنثى</label>
                </div>
            </div>

            <div class="grid">
                <div class="field">
                    <label for="password">كلمة المرور</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <div class="field">
                    <label for="password_confirmation">تأكيد كلمة المرور</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="btn-primary">إنشاء الحساب</button>
        </form>

        <div class="link">
            تمتلك حساباً بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a>
        </div>
    </div>
</div>
</body>
</html>
