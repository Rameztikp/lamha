@extends('layouts.app')

@section('title', 'الإعدادات الشخصية')

@section('content')
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
                   class="form-control @error('phone') is-invalid @enderror" required>
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
                   class="form-control @error('address') is-invalid @enderror" required>
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
        </div>
    </form>
</div>

@push('styles')
<style>
    .profile-form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        padding: 0.5rem 2rem;
        border-radius: 0.25rem;
    }
    
    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .password-section {
        border-top: 1px solid #eee;
        padding-top: 1.5rem;
        margin-top: 2rem;
    }
    
    .text-muted {
        color: #6c757d !important;
        font-size: 0.875rem;
    }
    
    .alert {
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }
    
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    
    .form-check {
        display: inline-block;
        margin-left: 1.5rem;
    }
    
    .form-check-input {
        margin-left: 0.5rem;
    }
</style>
@endpush
@endsection
