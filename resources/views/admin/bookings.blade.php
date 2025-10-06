@extends('layouts.admin.app')

@section('title', 'Bookings Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Bookings Management</h1>
        <button class="btn-add-supplier" onclick="openBookingModal()">
            <i class="fas fa-plus"></i>
            New Booking
        </button>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #3498db;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3>156</h3>
                <p>Today's Bookings</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #2ecc71;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>1,245</h3>
                <p>Completed</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f39c12;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>89</h3>
                <p>Pending</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search bookings...">
            </div>

            <div class="filter-wrapper">
                <select class="btn-filter" style="padding-right: 2rem;">
                    <option>All Status</option>
                    <option>Pending</option>
                    <option>Confirmed</option>
                    <option>Completed</option>
                    <option>Cancelled</option>
                </select>
                <button class="btn-filter">
                    <i class="fas fa-filter"></i>
                    Filters
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="checkbox-all">
                        </th>
                        <th class="sortable">
                            Booking ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Customer Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Service</th>
                        <th>Booking Date</th>
                        <th>Booking Time</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th class="actions-header">
                            Actions
                            <i class="fas fa-info-circle tooltip-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td><input type="checkbox" class="row-checkbox"></td>
                            <td class="supplier-id">{{ $booking->booking_id }}</td>
                            <td class="supplier-name">{{ $booking->user->full_name ?? ($booking->user->fname ?? 'N/A') }}</td>
                            <td>{{ $booking->service->service_name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                            <td><span class="time-badge">{{ $booking->booking_time }}</span></td>
                            <td>{{ $booking->payment_method }}</td>
                            <td>
                                <span class="payment-badge status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td class="actions-cell">
                                @if($booking->status === 'pending')
                                    <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" style="display:inline" onsubmit="return confirm('Approve this booking?')">
                                        @csrf
                                        <button class="btn-icon btn-view" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" style="display:inline" onsubmit="return confirm('Reject this booking?')">
                                        @csrf
                                        <button class="btn-icon btn-edit" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @elseif($booking->status === 'confirmed')
                                    <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" style="display:inline" onsubmit="return confirm('Mark this booking as completed?')">
                                        @csrf
                                        <button class="btn-icon btn-view" title="Complete">
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn-icon btn-view" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>1-10</strong> of <strong>1,490</strong>
            </div>

            <div class="pagination">
                <button class="page-btn page-prev" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">4</button>
                <button class="page-btn">5</button>
                <button class="page-btn page-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- New Booking Modal -->
<div class="modal-overlay" id="bookingModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Create New Booking</h2>
            <p class="required-text">Fields marked with an asterisk <span class="asterisk">(*)</span> are required.</p>
        </div>

        <form id="bookingForm">
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Customer Name <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-input" placeholder="Search or enter customer name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Service <span class="required">*</span>
                        </label>
                        <select class="form-select" required>
                            <option value="">Select service</option>
                            <option value="haircut">Hair Cut & Styling</option>
                            <option value="coloring">Hair Coloring</option>
                            <option value="rebonding">Hair Rebonding</option>
                            <option value="facial">Facial Treatment</option>
                            <option value="manicure">Manicure & Pedicure</option>
                            <option value="makeup">Makeup Services</option>
                            <option value="spa">Spa Treatment</option>
                            <option value="massage">Body Massage</option>
                            <option value="eyelash">Eyelash Extension</option>
                            <option value="blowout">Brazilian Blowout</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Booking Date <span class="required">*</span>
                        </label>
                        <input type="date" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Booking Time <span class="required">*</span>
                        </label>
                        <input type="time" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Payment Method <span class="required">*</span>
                        </label>
                        <select class="form-select" required>
                            <option value="">Select payment method</option>
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                            <option value="credit">Credit Card</option>
                            <option value="debit">Debit Card</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Status <span class="required">*</span>
                        </label>
                        <select class="form-select" required>
                            <option value="">Select status</option>
                            <option value="pending" selected>Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Contact Number <span class="required">*</span>
                        </label>
                        <input type="tel" class="form-input" placeholder="+63 XXX XXX XXXX" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Email Address
                        </label>
                        <input type="email" class="form-input" placeholder="customer@example.com">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">
                            Special Requests / Notes
                        </label>
                        <textarea class="form-textarea" placeholder="Any special requests or notes for this booking (optional)"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeBookingModal()">Cancel</button>
                <button type="submit" class="btn-save">Save Booking</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Modal Styles */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.modal-overlay.active {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 0.75rem;
    width: 100%;
    max-width: 900px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.modal-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.modal-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.modal-header p {
    font-size: 0.875rem;
    color: #64748b;
}

.modal-header .required-text {
    color: #64748b;
}

.modal-header .asterisk {
    color: #ef4444;
}

.modal-body {
    padding: 2rem;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #334155;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.form-label .required {
    color: #ef4444;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: #1e293b;
    background: white;
    transition: all 0.2s;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input::placeholder {
    color: #94a3b8;
}

.form-select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.25rem;
    padding-right: 2.5rem;
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
    font-family: inherit;
}

.input-with-icon {
    position: relative;
}

.input-with-icon .input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.875rem;
}

.input-with-icon .form-input {
    padding-left: 2.5rem;
}

.modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.btn-cancel {
    padding: 0.75rem 1.5rem;
    border: 1px solid #cbd5e1;
    background: white;
    color: #475569;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #f8fafc;
    border-color: #94a3b8;
}

.btn-save {
    padding: 0.75rem 1.5rem;
    border: none;
    background: #1e40af;
    color: white;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-save:hover {
    background: #1e3a8a;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function openBookingModal() {
    document.getElementById('bookingModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('bookingForm').reset();
}

// Close modal when clicking outside
document.getElementById('bookingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBookingModal();
    }
});

// Handle form submission
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // You can add your AJAX submission here
    alert('Booking saved successfully!');
    closeBookingModal();
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBookingModal();
    }
});
</script>
@endsection
