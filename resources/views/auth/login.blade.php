<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - لامحة</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin:0; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; background:#f3f4f6; }
        .page { min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1.5rem; }
        .card { background:#fff; border-radius:1.25rem; box-shadow:0 15px 35px rgba(15,23,42,.12); padding:2rem 1.75rem; max-width:420px; width:100%; }
        h1 { font-size:1.6rem; margin:0 0 .25rem; color:#111827; }
        p { margin:0 0 1.5rem; color:#6b7280; font-size:.9rem; }
        .field { margin-bottom:1rem; }
        label { display:block; margin-bottom:.35rem; font-size:.9rem; color:#374151; }
        input[type=email], input[type=password] {
            width:100%; padding:.6rem .75rem; border-radius:.6rem; border:1px solid #d1d5db; font-size:.9rem; outline:none;
        }
        input:focus { border-color:#2563eb; box-shadow:0 0 0 1px rgba(37,99,235,.15); }
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
        <h1>تسجيل الدخول</h1>
        <p>مرحباً بك من جديد في منصة لامحة. الرجاء إدخال بيانات الدخول.</p>

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

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="field">
                <label for="email">البريد الإلكتروني</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="field">
                <label for="password">كلمة المرور</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="field" style="display:flex;align-items:center;gap:.4rem;">
                <input id="remember" type="checkbox" name="remember" style="width:14px;height:14px;">
                <label for="remember" style="margin:0;font-size:.8rem;color:#4b5563;">تذكرني في هذا الجهاز</label>
            </div>
            <button type="submit" class="btn-primary">تسجيل الدخول</button>
        </form>

        <div class="link">
            لا تمتلك حساباً؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a>
        </div>
    </div>
</div>
</body>
</html>
