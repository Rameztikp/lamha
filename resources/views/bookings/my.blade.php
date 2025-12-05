@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">حجوزاتي</h4>
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الفندق</th>
                                        <th>الشاليه</th>
                                        <th>تاريخ الوصول</th>
                                        <th>تاريخ المغادرة</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $index => $booking)
                                        <tr>
                                            <td>{{ $bookings->firstItem() + $index }}</td>
                                            <td>{{ $booking->hotel->name ?? 'غير محدد' }}</td>
                                            <td>{{ $booking->chalet->name ?? 'غير محدد' }}</td>
                                            <td>{{ $booking->check_in_date->format('Y-m-d') }}</td>
                                            <td>{{ $booking->check_out_date->format('Y-m-d') }}</td>
                                            <td>
                                                <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $booking->status === 'confirmed' ? 'مؤكد' : 'قيد المراجعة' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#bookingDetails{{ $booking->id }}">
                                                    التفاصيل
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Booking Details Modal -->
                                        <div class="modal fade" id="bookingDetails{{ $booking->id }}" tabindex="-1" aria-labelledby="bookingDetailsLabel{{ $booking->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="bookingDetailsLabel{{ $booking->id }}">تفاصيل الحجز</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <strong>رقم الحجز:</strong> {{ $booking->booking_number }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>الفندق:</strong> {{ $booking->hotel->name ?? 'غير محدد' }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>الشاليه:</strong> {{ $booking->chalet->name ?? 'غير محدد' }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>تاريخ الوصول:</strong> {{ $booking->check_in_date->format('Y-m-d') }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>تاريخ المغادرة:</strong> {{ $booking->check_out_date->format('Y-m-d') }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>عدد الليالي:</strong> {{ $booking->number_of_nights }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>السعر الإجمالي:</strong> {{ number_format($booking->total_price, 2) }} ر.س
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>الحالة:</strong>
                                                            <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : 'bg-warning' }}">
                                                                {{ $booking->status === 'confirmed' ? 'مؤكد' : 'قيد المراجعة' }}
                                                            </span>
                                                        </div>
                                                        @if($booking->notes)
                                                            <div class="mb-3">
                                                                <strong>ملاحظات:</strong> {{ $booking->notes }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center" role="alert">
                            لا توجد حجوزات لعرضها.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
