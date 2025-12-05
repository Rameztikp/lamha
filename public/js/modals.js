// وظائف النوافذ المنبثقة
function openModal(modalId) {
    closeAllModals(); // إغلاق أي نوافذ مفتوحة
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // منع التمرير عند فتح النافذة
        
        // إذا كانت نافذة الحجوزات، قم بتحميل الحجوزات
        if (modalId === 'myBookingsModal') {
            loadUserBookings();
        }
    }
}

// إغلاق النافذة المنبثقة
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // إعادة تفعيل التمرير
    }
}

// إغلاق جميع النوافذ المنبثقة
function closeAllModals() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.style.display = 'none';
    });
    document.body.style.overflow = 'auto'; // إعادة تفعيل التمرير
}

// إغلاق النافذة عند النقر خارجها
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        closeAllModals();
    }
}

// فتح نافذة الحجوزات
function openMyBookingsModal() {
    openModal('myBookingsModal');
}

// تحميل حجوزات المستخدم
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

// تهيئة الأحداث عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    // إضافة مستمعات الأحداث لأزرار فتح النوافذ
    const loginButtons = document.querySelectorAll('[data-modal="loginModal"]');
    loginButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            openModal('loginModal');
        });
    });

    // إضافة مستمعات الأحداث لأزرار الإغلاق
    const closeButtons = document.querySelectorAll('.close');
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('.modal');
            if (modal) {
                closeModal(modal.id);
            }
        });
    });
});
