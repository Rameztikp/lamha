0<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>لمحة</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&amp;display=swap" rel="stylesheet" />

    <style>
        /* تنسيقات إضافية للنوافذ المنبثقة */
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn:hover {
            opacity: 0.9;
        }
        /* تعريف متغيرات الألوان هنا للمساعدة */
        :root {
            --color-accent-greenish: #3a5a5a; /* الأخضر الرمادي الداكن (اللون الأساسي الجديد) */
            --color-hover-greenish: #5a7777; /* تدرج أفتح قليلاً عند التمرير */
            --color-success: #10b981; /* لون ثابت للبحث/الحجز (أخضر صريح) */
            --color-text: #111827;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Cairo', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f9fafb;
            color: var(--color-text);
        }
        a { text-decoration: none; color: inherit; }

        .top-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 1.5rem 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .nav-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 0.5rem 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 1rem;
            z-index: 100;
            transition: all 0.3s ease;
        }
        .nav-bar:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
        
        /* حجم الشعار المُكبَّر (الشاشات الكبيرة) */
        .logo img {
            height: 70px;
            width: auto;
            max-width: 120px;
            transition: transform 0.3s ease;
        }
        .logo img:hover {
            transform: scale(1.05);
        }
        
        .nav-links {
            display: flex; 
            align-items: center;
            gap: 1rem;
            font-size: 0.95rem;
            flex-grow: 1; 
            justify-content: flex-end;
        }
        .nav-links a {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            color: #374151;
            transition: all 0.3s ease;
            position: relative;
        }
        
        /* لون خلفية الروابط عند التمرير (متناسق مع الأخضر الرمادي) */
        .nav-links a:hover {
            background: linear-gradient(135deg, var(--color-accent-greenish), var(--color-hover-greenish));
            color: #fff;
            transform: translateY(-2px);
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--color-accent-greenish);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-links a:hover::after {
            width: 100%;
        }
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* تحسين خط زر تسجيل الدخول */
        .btn-login {
            padding: 0.5rem 1.2rem;
            border-radius: 0.5rem;
            border: 2px solid var(--color-accent-greenish);
            background: transparent;
            color: var(--color-accent-greenish);
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        .btn-login:hover {
            background: var(--color-accent-greenish);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(58, 90, 90, 0.3);
        }
        
        /* تحسين خط زر إنشاء حساب (الزر الأساسي) */
        .btn-primary {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            background: linear-gradient(135deg, var(--color-accent-greenish), var(--color-hover-greenish));
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        .btn-primary:hover {
            background: var(--color-accent-greenish);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(58, 90, 90, 0.3);
        }

        /* --- تنسيق قائمة الهامبرغر للشاشات الصغيرة --- */

        .hamburger {
            display: none; 
            flex-direction: column;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .hamburger:hover {
            background: rgba(58, 90, 90, 0.1);
        }
        .hamburger span {
            width: 25px;
            height: 3px;
            background: #374151;
            margin: 3px 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        /* تصميم الإغلاق (X) */
        .hamburger.active span:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger.active span:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        @media (max-width: 768px) {
            .nav-bar {
                padding: 0.5rem 1rem;
                position: relative;
            }
            /* حجم الشعار المُكبَّر (الشاشات الصغيرة - الجوال) */
            .logo img {
                height: 55px;
                max-width: 100px;
            }

            .nav-links {
                position: absolute;
                top: 100%; 
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(10px);
                flex-direction: column;
                padding: 1rem 0;
                border-radius: 0 0 1rem 1rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                transform: translateY(-10px);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease-out;
                align-items: stretch;
            }

            .nav-links.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }

            .nav-links a {
                padding: 0.75rem 1.5rem;
                margin: 0 1rem;
                text-align: right;
                border-radius: 0.5rem;
            }
            .nav-links a::after {
                display: none;
            }
            .nav-links a:hover {
                background: #eef2ff;
                color: var(--color-accent-greenish);
                transform: none;
            }
            
            .nav-actions {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
                padding: 1rem 1.5rem;
                border-top: 1px solid #e5e7eb;
            }
            
            .btn-login, .btn-primary {
                width: 100%;
                text-align: center;
                transform: none;
            }

            .hamburger {
                display: flex;
            }
            
        }

        /* --- تطبيق الخلفية على قسم HERO --- */
        .search-bar {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .search-bar input {
            flex: 1;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            padding: 0.5rem 0.9rem;
            font-size: 0.9rem;
            outline: none;
        }
        .search-bar button {
            border-radius: 999px;
            border: none;
            padding: 0.5rem 1.2rem;
            background: var(--color-success); /* تم الإبقاء على الأخضر الصريح للبحث */
            color: #fff;
            font-size: 0.9rem;
            cursor: pointer;
        }
        .search-bar button:hover { background: #059669; }

        .hero {
            /* خصائص الخلفية الجديدة */
            display: flex; 
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            
            min-height: 450px;
            padding: 3rem 1.5rem; 
            max-width: 1200px;
            margin: 0 auto 2rem;
            border-radius: 1rem;
            
            /* تراكب داكن مع الصورة */
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)), url("{{ asset('aden.jpg') }}");
            background-size: cover;
            background-position: center;
            color: #fff; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .hero-text h1 {
            font-size: 2.5rem; 
            color: #fff;
            margin: 0 0 0.4rem;
        }
        .hero-text h2 {
            font-size: 1.6rem;
            color: #fff;
            margin: 0.75rem 0 0.3rem;
        }
        .hero-text p {
            margin: 0.2rem 0;
            color: #e5e7eb; /* لون فاتح للنص العادي */
        }
        .hero-cta {
            margin-top: 1rem;
        }
        .hero-cta .btn-primary {
            font-size: 1rem; 
        }
        
        .hero-image {
            display: none; 
        }

        .section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem 2rem;
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .section-subtitle {
            color: #6b7280;
            margin-bottom: 1.25rem;
            font-size: 0.95rem;
        }

        /* 🚀 تنسيق قسم من نحن الجديد (بطاقات مع أنميشن) */
        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            padding-top: 1rem;
        }
        .about-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            text-align: right;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0; /* يبدأ مختفياً */
            transform: translateY(20px); /* يبدأ من تحت */
            animation: fadeIn 0.8s ease-out forwards; /* تطبيق الأنميشن */
        }
        
        /* 💡 تأخير ظهور البطاقات لتأثير متتابع */
        .about-card:nth-child(2) { animation-delay: 0.2s; }
        .about-card:nth-child(3) { animation-delay: 0.4s; }

        .about-card:hover {
            transform: translateY(-5px); /* رفع البطاقة عند التمرير */
            box-shadow: 0 10px 25px rgba(58, 90, 90, 0.1);
        }
        
        .about-card i {
            font-size: 2.5rem;
            color: var(--color-accent-greenish); /* اللون الأخضر الرمادي */
            margin-bottom: 1rem;
            display: block;
        }
        .about-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-accent-greenish);
            margin-top: 0;
            margin-bottom: 0.75rem;
        }
        .about-card p {
            font-size: 0.95rem;
            color: #4b5563;
        }

        /* 🔑 CSS Keyframes لتأثير الظهور (Fade In and Up) */
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* --- نهاية قسم من نحن الجديد --- */

        .hotels-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
        }
        .hotel-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .hotel-card img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        .hotel-body {
            padding: 0.9rem 1rem 1rem;
        }
        .hotel-body h3 {
            margin: 0 0 0.3rem;
            font-size: 1.05rem;
        }
        .hotel-body p {
            margin: 0.15rem 0;
            font-size: 0.9rem;
            color: #4b5563;
        }
        .hotel-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
            font-size: 0.85rem;
        }
        .stars { color: #f59e0b; }
        .price { font-weight: 700; color: #111827; }
        .hotel-actions {
            padding: 0 1rem 1rem;
        }
        /* زر الحجز */
        .booking-button {
            width: 100%;
            border-radius: 999px;
            border: none;
            padding: 0.55rem 1rem;
            background: var(--color-success); 
            color: #fff;
            font-size: 0.95rem; 
            font-weight: 700; 
            cursor: pointer;
        }
        .booking-button:hover { background: #059669; }

        /* استخدام الأخضر الرمادي #3a5a5a للأيقونات الهادئة */
        .hotel-body p .fa-solid {
            color: var(--color-accent-greenish);
        }

        footer {
            background: #111827;
            color: #e5e7eb;
            margin-top: 2rem;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.75rem 1.5rem 1.25rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }
        .footer-bottom {
            text-align: center;
            padding: 0.75rem 1rem 1.25rem;
            border-top: 1px solid rgba(55,65,81,0.7);
            font-size: 0.8rem;
            color: #9ca3af;
        }
        .footer-links ul { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 0.3rem; }
        .footer-links a { color: #e5e7eb; font-size: 0.9rem; }
        .footer-links a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            .hero {
                min-height: 350px;
                padding: 2rem 1.5rem;
                display: flex;
                flex-direction: column;
            }
            .hero-text h1 {
                font-size: 2rem;
            }
        }

        /* تنسيق النوافذ المنبثقة (Modals) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 25px;
            border: 1px solid #888;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .close {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            color: #6b7280;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover { color: #374151; }
        .modal h1 {
            font-size: 1.6rem;
            margin: 0 0 0.25rem;
            color: #111827;
        }
        .modal p {
            margin: 0 0 1.5rem;
            color: #6b7280;
            font-size: 0.9rem;
        }
        .modal .field {
            margin-bottom: 0.9rem;
        }
        .modal label {
            display: block;
            margin-bottom: 0.35rem;
            font-size: 0.9rem;
            color: #374151;
        }
        .modal input[type=text], .modal input[type=email], .modal input[type=password] {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border-radius: 0.6rem;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
            outline: none;
        }
        .modal input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 1px rgba(37, 99, 235, 0.15);
        }
        .modal .gender-row {
            display: flex;
            gap: 1rem;
            align-items: center;
            font-size: 0.85rem;
            color: #4b5563;
        }
        .modal .btn-primary {
            width: 100%;
            border: none;
            border-radius: 0.8rem;
            padding: 0.7rem 1rem;
            background: #2563eb;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        .modal .btn-primary:hover { background: #1d4ed8; }
        .modal .link {
            margin-top: 1rem;
            font-size: 0.85rem;
            color: #6b7280;
        }
        .modal .link a {
            color: #2563eb;
            text-decoration: none;
        }
        .modal .link a:hover { text-decoration: underline; }
        .modal .status {
            font-size: 0.8rem;
            margin-bottom: 0.75rem;
            color: #059669;
        }
        .modal .error-list {
            background: #fef2f2;
            color: #b91c1c;
            border-radius: 0.75rem;
            padding: 0.6rem 0.8rem;
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }
        .modal .error-list ul {
            margin: 0.25rem 0 0;
            padding-right: 1.1rem;
        }
        .modal .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 0.75rem 0.9rem;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .form-group label {
            font-weight: bold;
            color: #333;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background-color: var(--color-accent-greenish);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--color-hover-greenish);
        }
    </style>
</head>
<body>

<header>
    <div class="top-container">
        <div class="nav-bar">
            <div class="logo">
                <img src="{{ asset('logo.svg') }}" alt="لمحة" onerror="this.style.display='none'">
            </div>
            
            <nav class="nav-links">
                <a href="{{ route('home') }}">الرئيسية</a>
                <a href="#hotels">الفنادق</a>
                <a href="#about">من نحن</a>
                <a href="#contact">تواصل معنا</a>
                
                <div class="nav-actions">
                    @auth
                        <a href="{{ route('profile.settings') }}" class="btn-login" style="display:inline-block;text-decoration:none;margin-left:10px;">إعداداتي</a>
                        <a href="#" onclick="event.preventDefault(); openMyBookingsModal();" class="btn-login" style="display:inline-block;text-decoration:none;margin-left:10px;">حجوزاتي</a>
                        <form method="POST" action="{{ route('logout') }}" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn-login">تسجيل الخروج</button>
                        </form>
                    @else
                        <a href="#" onclick="event.preventDefault(); openModal('loginModal');" class="btn-login" style="display:inline-block;text-decoration:none;cursor:pointer;">تسجيل الدخول</a>
                        <a href="#" onclick="event.preventDefault(); openModal('registerModal');" class="btn-primary" style="display:inline-block;text-decoration:none;cursor:pointer;">إنشاء حساب</a>
                    @endauth
                </div>
            </nav>
            
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <form action="#hotels" method="GET" class="search-bar">
            <input name="search" placeholder="ابحث عن فندق أو شاليه" type="text" />
            <button type="submit">بحث</button>
        </form>
    </div>
</header>

<main>
    <section class="hero">
        <div class="hero-text">
            <h1>مرحباً بك في موقع لمحة</h1>
            <p>اكتشف وجهتك ونحن نهتم بالإقامة.</p>
            <h2>سجّل الآن</h2>
            <p>أنشئ حسابك الآن وسهّل على نفسك إيجاد الفنادق والشاليهات المناسبة لك.</p>
            <div class="hero-cta">
                @guest
                    <a href="#" onclick="event.preventDefault(); openModal('registerModal');" class="btn-primary" style="display:inline-block;text-decoration:none;cursor:pointer;">إنشاء حساب جديد</a>
                @else
                    <span style="font-size:0.9rem;color:#fff;">مرحباً، {{ auth()->user()->name }}</span>
                @endguest
            </div>
        </div>
    </section>

    @if($showProfileSettings)
    <section id="profile-settings" class="section">
        <h2 class="section-title">إعدادات الحساب</h2>
        <p class="section-subtitle">قم بتحديث معلومات حسابك الشخصية.</p>

        <div class="profile-form-container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="from_home" value="1">

                <div class="form-group">
                    <label for="name">الاسم الكامل</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $user->name) }}"
                           class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">رقم الهاتف</label>
                    <input type="text" id="phone" name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">العنوان</label>
                    <input type="text" id="address" name="address"
                           value="{{ old('address', $user->address) }}"
                           class="form-control @error('address') is-invalid @enderror">
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>الجنس</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="male"
                               value="male" {{ old('gender', $user->gender) === 'male' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="male">ذكر</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="female"
                               value="female" {{ old('gender', $user->gender) === 'female' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="female">أنثى</label>
                    </div>
                    @error('gender')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="password-section mt-4">
                    <h5>تغيير كلمة المرور</h5>
                    <p class="text-muted">اترك الحقول فارغة إذا كنت لا تريد تغيير كلمة المرور</p>

                    <div class="form-group">
                        <label for="current_password">كلمة المرور الحالية</label>
                        <input type="password" id="current_password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror">
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password">كلمة المرور الجديدة</label>
                        <input type="password" id="new_password" name="new_password"
                               class="form-control @error('new_password') is-invalid @enderror">
                        @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">تأكيد كلمة المرور الجديدة</label>
                        <input type="password" id="new_password_confirmation"
                               name="new_password_confirmation" class="form-control">
                    </div>
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        حفظ التغييرات
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary" style="margin-left: 10px;">
                        العودة للصفحة الرئيسية
                    </a>
                </div>
            </form>
        </div>
    </section>
    @endif

    <section id="about" class="section">
        <h2 class="section-title">من نحن</h2>
        <p class="section-subtitle">
            نحن نقدم منصة رقمية لاستعراض الفنادق والشاليهات المحلية، مع مجموعة متنوعة من الميزات
            لجعل اختيارك أكثر سهولة وراحة.
        </p>

        <div class="about-grid">
            
            <div class="about-card">
                <i class="fas fa-eye"></i>
                <h3>رؤيتنا (Vision)</h3>
                <p>
                    أن نكون المنصة الرائدة والأكثر ثقة لحجز الإقامات السياحية في اليمن، مما يساهم 
                    في تطوير قطاع الضيافة المحلي.
                </p>
            </div>
            
            <div class="about-card">
                <i class="fas fa-bullhorn"></i>
                <h3>رسالتنا (Mission)</h3>
                <p>
                    توفير تجربة حجز سهلة، شفافة، ومتكاملة، تربط المسافرين مباشرة بأفضل الفنادق 
                    والشاليهات بأسعار تنافسية.
                </p>
            </div>
            
            <div class="about-card">
                <i class="fas fa-handshake"></i>
                <h3>قيمنا (Values)</h3>
                <p>
                    الشفافية في التعامل، الجودة في العروض، والالتزام بتقديم أفضل خدمة عملاء 
                    لضمان رضاكم التام.
                </p>
            </div>
            
        </div>
    </section>
    <section id="hotels" class="section">
        <h2 class="section-title">الفنادق المتاحة</h2>
        <p class="section-subtitle">اختر من بين مجموعة واسعة من الفنادق في عدن والمناطق المجاورة.</p>

        <div class="hotels-grid">
            @forelse($hotels as $hotel)
                <article class="hotel-card" id="hotel-{{ $hotel->id }}">
                    @if($hotel->image)
                        <img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}">
                    @endif
                    <div class="hotel-body">
                        <h3>{{ $hotel->name }}</h3>
                        <p><i class="fa-solid fa-location-dot" style="color:var(--color-accent-greenish);"></i> {{ $hotel->location }}</p>
                        <p><i class="fa-solid fa-phone" style="color:var(--color-accent-greenish);"></i> {{ $hotel->phone_number }}</p>
                        <div class="hotel-meta">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $hotel->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <div class="price">
                                @if($hotel->price && $hotel->price > 0)
                                    {{ number_format($hotel->price, 0) }} ريال
                                @else
                                    السعر عند الاستفسار
                                @endif
                            </div>
                        </div>
                        <a href="#" onclick="event.preventDefault(); openBookingModal();" class="booking-button" style="display:inline-block;text-align:center;text-decoration:none;cursor:pointer;">
                            احجز الآن
                        </a>
                    </div>
                </article>
            @empty
                <p>لا توجد فنادق متاحة حاليًا.</p>
            @endforelse
        </div>
    </section>
</main>

<footer>
    <div class="footer-content">
        <div>
            <h3>عن لمحة</h3>
            <p>نحن نقدم أفضل خدمات اطلاع الفنادق والشاليهات في عدن.</p>
        </div>
        <div class="footer-links">
            <h3>روابط سريعة</h3>
            <ul>
                <li><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                <li><a href="#hotels">الفنادق</a></li>
                <li><a href="#about">من نحن</a></li>
                <li><a href="#contact">اتصل بنا</a></li>
            </ul>
        </div>
        <div id="contact">
            <h3>تواصل معنا</h3>
            <p>البريد الإلكتروني: info@lamha.com</p>
            <p>الهاتف: +966 12 345 6789</p>
            <div class="social-icons" style="display:flex;gap:.5rem;font-size:1.1rem;">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} لمحة. جميع الحقوق محفوظة.</p>
    </div>
</footer>

<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('loginModal')">&times;</span>
        <h1>تسجيل الدخول</h1>
        <p>أدخل بياناتك لتسجيل الدخول إلى حسابك.</p>
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <div class="field">
                <label for="login-email">البريد الإلكتروني</label>
                <input id="login-email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="field">
                <label for="login-password">كلمة المرور</label>
                <input id="login-password" type="password" name="password" required>
            </div>
            <button type="submit" class="btn-primary">تسجيل الدخول</button>
        </form>
        <div class="link">
            <p>ليس لديك حساب؟ <a href="#" onclick="closeModal('loginModal'); openModal('registerModal');">إنشاء حساب جديد</a></p>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('registerModal')">&times;</span>
        <h1>إنشاء حساب جديد</h1>
        <p>املأ البيانات التالية لإنشاء حسابك الجديد.</p>
        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf
            <div class="field">
                <label for="register-name">الاسم الكامل</label>
                <input id="register-name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="field">
                <label for="register-email">البريد الإلكتروني</label>
                <input id="register-email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="field">
                <label for="register-phone">رقم الهاتف</label>
                <input id="register-phone" type="text" name="phone" value="{{ old('phone') }}" required>
            </div>
            <div class="field">
                <label for="register-address">العنوان</label>
                <input id="register-address" type="text" name="address" value="{{ old('address') }}" required>
            </div>
            <div class="field">
                <label for="register-password">كلمة المرور</label>
                <input id="register-password" type="password" name="password" required>
            </div>
            <div class="field">
                <label for="register-password_confirmation">تأكيد كلمة المرور</label>
                <input id="register-password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <div class="field">
                <label>الجنس</label>
                <div class="gender-row">
                    <label><input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}> ذكر</label>
                    <label><input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}> أنثى</label>
                </div>
            </div>
            <button type="submit" class="btn-primary">إنشاء الحساب</button>
        </form>
        <div class="link">
            <p>لديك حساب بالفعل؟ <a href="#" onclick="closeModal('registerModal'); openModal('loginModal');">تسجيل الدخول</a></p>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('bookingModal')">&times;</span>
        <h1>حجز غرفة</h1>
        <p>املأ النموذج التالي لإكمال عملية الحجز.</p>
        
        <!-- رسالة النجاح -->
        <div id="bookingSuccess" class="alert alert-success" style="display: none; margin-bottom: 20px; padding: 15px; background-color: #d4edda; color: #155724; border-radius: 4px;">
            <i class="fas fa-check-circle"></i> تم إرسال طلب الحجز بنجاح! سنتواصل معك قريباً.
        </div>

        <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" class="auth-form" onsubmit="return handleBookingSubmit(event)">
            @csrf
            <input type="hidden" name="hotel_id" value="1">

            <div class="form-group">
                <label for="hotel_chalet_id">نوع الغرفة</label>
                <select id="hotel_chalet_id" name="hotel_chalet_id" required>
                    <option value="">اختر نوع الغرفة</option>
                    @if(isset($hotels) && $hotels->first())
                        @foreach($hotels->first()->chalets as $chalet)
                            <option value="{{ $chalet->id }}">{{ $chalet->name }} - {{ $chalet->price_per_night }} ريال/ليلة</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="check_in_date">تاريخ الوصول</label>
                <input type="date" id="check_in_date" name="check_in_date" required>
            </div>

            <div class="form-group">
                <label for="check_out_date">تاريخ المغادرة</label>
                <input type="date" id="check_out_date" name="check_out_date" required>
            </div>

            <div class="form-group">
                <label for="adults">عدد البالغين</label>
                <input type="number" id="adults" name="adults" min="1" value="1" required>
            </div>

            <div class="form-group">
                <label for="children">عدد الأطفال</label>
                <input type="number" id="children" name="children" min="0" value="0">
            </div>

            <div class="form-group">
                <label for="special_requests">طلبات خاصة (اختياري)</label>
                <textarea id="special_requests" name="special_requests" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">تأكيد الحجز</button>
        </form>
    </div>
</div>

<!-- My Bookings Modal -->
<div id="myBookingsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('myBookingsModal')">&times;</span>
        <h1>حجوزاتي</h1>
        <div id="bookingsList">
            <div class="loading-spinner" style="text-align: center; padding: 20px;">
                <i class="fas fa-spinner fa-spin"></i> جاري تحميل الحجوزات...
            </div>
        </div>
    </div>
</div>

<!-- Booking Confirmation Modal -->
<div id="bookingConfirmationModal" class="modal">
    <div class="modal-content" style="text-align: center; padding: 30px 20px;">
        <div style="font-size: 48px; color: #4CAF50; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2 style="color: #4CAF50; margin-bottom: 15px;">تم تأكيد حجزك بنجاح!</h2>
        <p id="bookingDetails" style="margin-bottom: 20px;">
            شكراً لثقتك بنا. سنقوم بالتواصل معك قريباً لتأكيد التفاصيل النهائية.
        </p>
        <div style="display: flex; justify-content: center; gap: 10px; margin-top: 25px;">
            <button onclick="closeModal('bookingConfirmationModal')" class="btn" style="background: #e0e0e0; color: #333;">إغلاق</button>
            <button onclick="closeModal('bookingConfirmationModal'); openMyBookingsModal()" class="btn btn-primary">عرض الحجوزات</button>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
<script>
    // My Bookings Functions
    async function loadUserBookings() {
        const bookingsList = document.getElementById('bookingsList');
        if (!bookingsList) return;

        try {
            const response = await fetch('{{ route("bookings.my") }}', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error('فشل في تحميل الحجوزات');
            }
            
            const data = await response.json();
            
            if (data.length === 0) {
                bookingsList.innerHTML = `
                    <div style="text-align: center; padding: 20px; color: #666;">
                        <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 15px;"></i>
                        <p>لا توجد لديك أي حجوزات سابقة</p>
                    </div>
                `;
                return;
            }
            
            let html = '<div style="max-height: 500px; overflow-y: auto;">';
            data.forEach(booking => {
                const statusClass = booking.status === 'confirmed' ? 'status-confirmed' : 
                                  booking.status === 'pending' ? 'status-pending' : 'status-cancelled';
                
                html += `
                    <div style="border: 1px solid #eee; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <h3 style="margin: 0;">${booking.hotel_name || 'فندق غير محدد'}</h3>
                            <span class="${statusClass}" style="padding: 3px 10px; border-radius: 12px; font-size: 0.8em;">
                                ${booking.status === 'confirmed' ? 'مؤكد' : booking.status === 'pending' ? 'قيد المراجعة' : 'ملغي'}
                            </span>
                        </div>
                        <div style="color: #666; font-size: 0.9em; margin-bottom: 10px;">
                            <div>من ${booking.check_in_date} إلى ${booking.check_out_date}</div>
                            <div>${booking.guests_count} ضيوف - ${booking.rooms_count} غرفة</div>
                        </div>
                        ${booking.notes ? `<div style="color: #333; margin-bottom: 10px;">
                            <strong>ملاحظات:</strong> ${booking.notes}
                        </div>` : ''}
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="color: #1a73e8; font-weight: bold;">رقم الحجز: #${booking.id}</div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            bookingsList.innerHTML = html;
            
        } catch (error) {
            console.error('Error loading bookings:', error);
            bookingsList.innerHTML = `
                <div style="color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 4px; text-align: center;">
                    <i class="fas fa-exclamation-circle"></i> حدث خطأ أثناء تحميل الحجوزات. يرجى المحاولة مرة أخرى.
                </div>
            `;
        }
    }
    
    // Open My Bookings Modal
    function openMyBookingsModal() {
        closeAllModals();
        const modal = document.getElementById('myBookingsModal');
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            loadUserBookings();
        }
    }

    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function closeAllModals() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.style.display = 'none';
        });
        document.body.style.overflow = 'auto';
    }

    function openBookingModal() {
        closeAllModals();
        const modal = document.getElementById('bookingModal');
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';

        // إذا كان المستخدم مسجل الدخول، قم بملء الحقول تلقائيًا
        @if(auth()->check())
            document.getElementById('customer_phone').value = '{{ auth()->user()->phone }}';
            document.getElementById('customer_phone').readOnly = true;

            // تفعيل حقول التاريخ والضيوف والغرف
            document.getElementById('check_in_date').focus();
        @endif
    }

    // Handle booking form submission with AJAX
    async function handleBookingSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;

        // Disable button and show loading
        submitButton.disabled = true;
        submitButton.textContent = 'جاري الإرسال...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok) {
                // Success
                const successDiv = document.getElementById('bookingSuccess');
                successDiv.style.display = 'block';
                successDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message;

                // Reset form
                form.reset();

                // Hide success message after 5 seconds and close modal
                setTimeout(() => {
                    successDiv.style.display = 'none';
                    closeModal('bookingModal');
                }, 3000);

            } else {
                // Error
                let errorMessage = 'حدث خطأ أثناء إرسال الطلب. يرجى المحاولة مرة أخرى.';
                if (data.error) {
                    errorMessage = data.error;
                }

                const successDiv = document.getElementById('bookingSuccess');
                successDiv.style.display = 'block';
                successDiv.className = 'alert alert-danger';
                successDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + errorMessage;

                // Hide error message after 5 seconds
                setTimeout(() => {
                    successDiv.style.display = 'none';
                    successDiv.className = 'alert alert-success';
                }, 5000);
            }

        } catch (error) {
            console.error('Error:', error);
            const successDiv = document.getElementById('bookingSuccess');
            successDiv.style.display = 'block';
            successDiv.className = 'alert alert-danger';
            successDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.';

            // Hide error message after 5 seconds
            setTimeout(() => {
                successDiv.style.display = 'none';
                successDiv.className = 'alert alert-success';
            }, 5000);
        } finally {
            // Re-enable button
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        }

        return false;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');

        hamburger.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            hamburger.classList.toggle('active');
        });

        // Close menu when clicking on a link
        navLinks.addEventListener('click', function(e) {
            if (e.target.closest('a') && e.target.closest('.nav-links')) {
                // تأكد أن النقر ليس على زر ضمن الـ nav-actions الذي قد يكون داخله
                if (!e.target.closest('.nav-actions')) {
                    navLinks.classList.remove('active');
                    hamburger.classList.remove('active');
                }
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!hamburger.contains(e.target) && !navLinks.contains(e.target) && navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
                hamburger.classList.remove('active');
            }
        });
    });
</script>
<script src="{{ asset('js/modals.js') }}"></script>
<script src="{{ asset('js/profileModal.js') }}"></script>
</body>
</html>