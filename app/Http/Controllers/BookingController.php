<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\HotelChalet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function myBookings()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('status', 'الرجاء تسجيل الدخول لعرض حجوزاتك.');
        }

        $bookings = Auth::user()->bookings()
            ->with(['hotel', 'chalet'])
            ->latest()
            ->paginate(10);

        return view('bookings.my', compact('bookings'));
    }
    public function create($hotelId, $chaletId = null)
    {
        $hotel = Hotel::with('chalets')->findOrFail($hotelId);
        
        if (!Auth::check()) {
            return redirect()->route('login')->with('status', 'الرجاء تسجيل الدخول أولاً لإتمام الحجز.');
        }

        $user = Auth::user();
        $selectedChalet = null;
        
        if ($chaletId) {
            $selectedChalet = $hotel->chalets()->findOrFail($chaletId);
        }

        return view('booking.form', [
            'hotel' => $hotel,
            'selectedChalet' => $selectedChalet,
            'chalets' => $hotel->chalets()->where('is_available', true)->get(),
            'user' => $user,
            'minDate' => now()->format('Y-m-d'),
            'maxDate' => now()->addYear()->format('Y-m-d')
        ]);
    }

    public function store(Request $request)
    {
        \Log::info('Booking request started', ['data' => $request->all()]);

        try {
            // التحقق من تسجيل الدخول
            if (!Auth::check()) {
                \Log::warning('User not authenticated for booking');
                return response()->json(['error' => 'الرجاء تسجيل الدخول أولاً لإتمام الحجز.'], 401);
            }

            // التحقق من صحة البيانات
            $data = $request->validate([
                'hotel_id' => 'required|exists:hotels,id',
                'hotel_chalet_id' => 'required|exists:hotels_chalets,id',
                'check_in_date' => 'required|date|after_or_equal:today',
                'check_out_date' => 'required|date|after:check_in_date',
                'adults' => 'required|integer|min:1',
                'children' => 'nullable|integer|min:0',
                'special_requests' => 'nullable|string|max:1000'
            ]);

            \Log::info('Validation passed', $data);

            // التحقق من توفر الشاليه
            $isAvailable = !Booking::where('hotel_chalet_id', $data['hotel_chalet_id'])
                ->where(function($query) use ($data) {
                    $query->whereBetween('check_in_date', [$data['check_in_date'], $data['check_out_date']])
                          ->orWhereBetween('check_out_date', [$data['check_in_date'], $data['check_out_date']]);
                })
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();

            if (!$isAvailable) {
                \Log::warning('Chalet not available', $data);
                return response()->json([
                    'error' => 'عذراً، الشاليه غير متاح في التواريخ المحددة'
                ], 422);
            }

            // الحصول على سعر الليلة
            $hotelChalet = \App\Models\HotelChalet::findOrFail($data['hotel_chalet_id']);
            $checkIn = new \Carbon\Carbon($data['check_in_date']);
            $checkOut = new \Carbon\Carbon($data['check_out_date']);
            $totalNights = $checkIn->diffInDays($checkOut);
            $totalPrice = $hotelChalet->price_per_night * $totalNights;

            // إنشاء الحجز
            $booking = new Booking();
            $booking->user_id = Auth::id();
            $booking->hotel_id = $data['hotel_id'];
            $booking->hotel_chalet_id = $data['hotel_chalet_id'];
            $booking->booking_reference = 'BK-' . strtoupper(\Illuminate\Support\Str::random(8));
            $booking->check_in_date = $data['check_in_date'];
            $booking->check_out_date = $data['check_out_date'];
            $booking->adults = $data['adults'];
            $booking->children = $data['children'] ?? 0;
            $booking->special_requests = $data['special_requests'] ?? null;
            $booking->status = 'pending';
            $booking->total_price = $totalPrice;
            $booking->save();

            \Log::info('Booking created successfully', ['booking_id' => $booking->id]);

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال طلب الحجز بنجاح',
                'booking_reference' => $booking->booking_reference
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'error' => 'خطأ في التحقق من صحة البيانات',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Booking error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'حدث خطأ أثناء معالجة طلبك: ' . $e->getMessage()
            ], 500);
        }

        $data = $request->validate([
            'hotel_id' => ['required', 'integer', 'exists:hotels,id'],
            'hotel_chalet_id' => ['required', 'integer', 'exists:hotels_chalets,id'],
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['nullable', 'integer', 'min:0'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ], [
            'hotel_id.required' => 'معرّف الفندق مطلوب.',
            'hotel_chalet_id.required' => 'نوع الغرفة مطلوب.',
            'check_in_date.required' => 'تاريخ الوصول مطلوب.',
            'check_in_date.after_or_equal' => 'تاريخ الوصول يجب أن يكون اليوم أو بعده.',
            'check_out_date.required' => 'تاريخ المغادرة مطلوب.',
            'check_out_date.after' => 'تاريخ المغادرة يجب أن يكون بعد تاريخ الوصول.',
            'adults.required' => 'عدد البالغين مطلوب.',
            'adults.min' => 'يجب أن يكون عدد البالغين على الأقل 1.',
            'children.min' => 'عدد الأطفال لا يمكن أن يكون سالباً.',
        ]);
        $user = Auth::user();

        // التحقق من توفر الشاليه في التواريخ المحددة
        $isAvailable = !Booking::where('hotel_chalet_id', $data['hotel_chalet_id'])
            ->where(function($query) use ($data) {
                $query->whereBetween('check_in_date', [$data['check_in_date'], $data['check_out_date']])
                      ->orWhereBetween('check_out_date', [$data['check_in_date'], $data['check_out_date']])
                      ->orWhere(function($q) use ($data) {
                          $q->where('check_in_date', '<=', $data['check_in_date'])
                            ->where('check_out_date', '>=', $data['check_out_date']);
                      });
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if (!$isAvailable) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'عذراً، الشاليه غير متاح في التواريخ المحددة. يرجى اختيار تواريخ أخرى.'], 422);
            }
            return back()->withInput()
                ->with('error', 'عذراً، الشاليه غير متاح في التواريخ المحددة. يرجى اختيار تواريخ أخرى.');
        }

        $hotelChalet = HotelChalet::findOrFail($data['hotel_chalet_id']);
        $totalNights = Carbon::parse($data['check_in_date'])->diffInDays($data['check_out_date']);
        $totalPrice = $hotelChalet->price_per_night * $totalNights;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'hotel_id' => $data['hotel_id'],
            'hotel_chalet_id' => $data['hotel_chalet_id'],
            'booking_reference' => 'BK-' . strtoupper(Str::random(8)),
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
            'adults' => $data['adults'],
            'children' => $data['children'] ?? 0,
            'special_requests' => $data['special_requests'] ?? null,
            'status' => 'pending',
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
        ]);

        // هنا يمكنك إضافة إرسال إشعارات أو رسائل بريد إلكتروني
        // Notification::send($user, new BookingConfirmation($booking));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال طلب الحجز بنجاح! سنتواصل معك قريباً.',
                'booking_reference' => $booking->booking_reference
            ]);
        }

        return redirect()->route('booking.confirmation', $booking->booking_reference)
            ->with('success', 'تم تأكيد حجزك بنجاح! رقم الحجز: ' . $booking->booking_reference);
    }

    public function confirmation($reference)
    {
        $booking = Booking::where('booking_reference', $reference)
            ->with(['hotel', 'chalet'])
            ->firstOrFail();

        return view('booking.confirmation', compact('booking'));
    }
}
