# 📋 ADMIN VIEW MODALS - IMPLEMENTATION GUIDE

## ✅ SERVICES PAGE - FULLY IMPLEMENTED
- View modal with image preview
- All service details displayed
- Edit button to switch to edit mode
- Fallback to table data if AJAX fails

---

## 🔧 QUICK IMPLEMENTATION FOR OTHER PAGES

### **1. PRODUCTS** - Add View Modal
```blade
<div id="viewProductModal" class="modal-overlay" style="display: none;">
    <div class="modal" style="max-width: 700px;">
        <div class="modal-header-view">
            <h2><i class="fas fa-eye"></i> Product Details</h2>
            <button class="modal-close-btn" onclick="closeViewProductModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-section">
                <div class="view-image-container" id="viewProductImage"></div>
                <div class="view-details">
                    <div class="detail-row">
                        <span class="detail-label">Product ID:</span>
                        <span class="detail-value" id="view_product_id"></span>
                    </div>
                    <!-- Add more fields as needed -->
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeViewProductModal()" class="btn btn-secondary">Close</button>
            <button onclick="editProductFromView()" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </button>
        </div>
    </div>
</div>
```

JavaScript:
```javascript
function viewProduct(id) {
    const row = document.querySelector(`button[onclick*="viewProduct(${id})"]`).closest('tr');
    const cells = row.querySelectorAll('td');
    
    document.getElementById('view_product_id').textContent = '#' + id;
    document.getElementById('view_product_name').textContent = cells[3].textContent;
    // Add more fields
    
    document.getElementById('viewProductModal').style.display = 'flex';
    showToast('Product details loaded', 'info');
}
```

---

### **2. INVENTORY** - Stock View Modal
```blade
<div id="viewInventoryModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header-view">
            <h2><i class="fas fa-boxes"></i> Inventory Details</h2>
            <button class="modal-close-btn" onclick="closeViewInventoryModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-details">
                <div class="detail-row">
                    <span class="detail-label">Current Stock:</span>
                    <span class="detail-value" id="view_current_stock" style="font-size: 24px; color: #10b981;"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Product:</span>
                    <span class="detail-value" id="view_product_name"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Min Stock:</span>
                    <span class="detail-value" id="view_min_stock"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" id="view_stock_status"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeViewInventoryModal()" class="btn btn-secondary">Close</button>
            <button onclick="adjustStock()" class="btn btn-primary">
                <i class="fas fa-edit"></i> Adjust Stock
            </button>
        </div>
    </div>
</div>
```

---

### **3. BOOKINGS** - Booking Details Modal
```blade
<div id="viewBookingModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header-view">
            <h2><i class="fas fa-calendar"></i> Booking Details</h2>
            <button class="modal-close-btn" onclick="closeViewBookingModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-details">
                <div class="detail-row">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value" id="view_booking_id"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Customer:</span>
                    <span class="detail-value" id="view_customer"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Service:</span>
                    <span class="detail-value" id="view_service"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date & Time:</span>
                    <span class="detail-value" id="view_datetime"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" id="view_status"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeViewBookingModal()" class="btn btn-secondary">Close</button>
            <button onclick="updateBookingStatus()" class="btn btn-primary">
                <i class="fas fa-check"></i> Update Status
            </button>
        </div>
    </div>
</div>
```

---

### **4. ORDERS** - Order Details Modal
```blade
<div id="viewOrderModal" class="modal-overlay" style="display: none;">
    <div class="modal" style="max-width: 800px;">
        <div class="modal-header-view">
            <h2><i class="fas fa-shopping-cart"></i> Order Details</h2>
            <button class="modal-close-btn" onclick="closeViewOrderModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-details">
                <div class="detail-row">
                    <span class="detail-label">Order ID:</span>
                    <span class="detail-value" id="view_order_id"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total:</span>
                    <span class="detail-value" id="view_total" style="font-size: 20px; color: #10b981;"></span>
                </div>
            </div>
            <div id="order_items_list" style="margin-top: 20px;">
                <!-- Order items will be listed here -->
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeViewOrderModal()" class="btn btn-secondary">Close</button>
            <button onclick="printInvoice()" class="btn btn-info">
                <i class="fas fa-print"></i> Print
            </button>
            <button onclick="updateOrderStatus()" class="btn btn-primary">
                <i class="fas fa-edit"></i> Update Status
            </button>
        </div>
    </div>
</div>
```

---

### **5. SALES** - Sale Details Modal
```blade
<div id="viewSaleModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header-view">
            <h2><i class="fas fa-receipt"></i> Sale Details</h2>
            <button class="modal-close-btn" onclick="closeViewSaleModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-details">
                <div class="detail-row">
                    <span class="detail-label">Sale ID:</span>
                    <span class="detail-value" id="view_sale_id"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value" id="view_amount" style="font-size: 24px; color: #10b981;"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeViewSaleModal()" class="btn btn-secondary">Close</button>
            <button onclick="printReceipt()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Receipt
            </button>
        </div>
    </div>
</div>
```

---

### **6. CUSTOMERS** - Customer Profile Modal
```blade
<div id="viewCustomerModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header-view">
            <h2><i class="fas fa-user"></i> Customer Profile</h2>
            <button class="modal-close-btn" onclick="closeViewCustomerModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-section">
                <div class="view-image-container">
                    <i class="fas fa-user-circle" style="font-size: 64px; color: #cbd5e1;"></i>
                </div>
                <div class="view-details">
                    <div class="detail-row">
                        <span class="detail-label">Name:</span>
                        <span class="detail-value" id="view_name"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value" id="view_email"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Orders:</span>
                        <span class="detail-value" id="view_orders"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeViewCustomerModal()" class="btn btn-secondary">Close</button>
            <button onclick="viewCustomerOrders()" class="btn btn-primary">
                <i class="fas fa-list"></i> View Orders
            </button>
        </div>
    </div>
</div>
```

---

## 🎨 Generic JavaScript Functions

```javascript
// Generic view function for all modals
function viewDetails(modalId, data) {
    Object.keys(data).forEach(key => {
        const element = document.getElementById(`view_${key}`);
        if (element) {
            element.textContent = data[key];
        }
    });
    document.getElementById(modalId).style.display = 'flex';
    showToast('Details loaded', 'info');
}

// Close any modal by clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.style.display = 'none';
    }
});

// Example usage for each page:
function viewInventory(id) {
    const row = event.target.closest('tr');
    const cells = row.querySelectorAll('td');
    
    viewDetails('viewInventoryModal', {
        current_stock: cells[3].textContent,
        product_name: cells[2].textContent,
        min_stock: '10',
        stock_status: cells[4].textContent
    });
}

function viewBooking(id) {
    const row = event.target.closest('tr');
    const cells = row.querySelectorAll('td');
    
    viewDetails('viewBookingModal', {
        booking_id: '#' + id,
        customer: cells[2].textContent,
        service: cells[3].textContent,
        datetime: cells[4].textContent + ' ' + cells[5].textContent,
        status: cells[6].textContent
    });
}

function viewOrder(id) {
    const row = event.target.closest('tr');
    const cells = row.querySelectorAll('td');
    
    viewDetails('viewOrderModal', {
        order_id: '#' + id,
        total: cells[5].textContent
    });
    
    // Load order items
    document.getElementById('order_items_list').innerHTML = 'Loading items...';
}

function viewSale(id) {
    const row = event.target.closest('tr');
    const cells = row.querySelectorAll('td');
    
    viewDetails('viewSaleModal', {
        sale_id: '#' + id,
        amount: cells[4].textContent
    });
}

function viewCustomer(id) {
    const row = event.target.closest('tr');
    const cells = row.querySelectorAll('td');
    
    viewDetails('viewCustomerModal', {
        name: cells[2].textContent,
        email: cells[3].textContent,
        orders: cells[5].textContent
    });
}
```

---

## ✅ Features

- **Consistent Design** - All modals follow same pattern
- **Image Support** - Where applicable
- **Edit Integration** - View modals link to edit
- **Print Options** - For orders, sales, invoices
- **Responsive** - Works on all screen sizes
- **Fallback Data** - Uses table data if AJAX fails

---

## 🚀 Implementation Steps

1. Copy the modal HTML for your page
2. Add the JavaScript function
3. Update action buttons to call view function
4. Style is already in admin layout

**All modals work with existing toast system and delete modals!**
