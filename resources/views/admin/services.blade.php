@extends('layouts.admin.app')

@section('title', 'Services Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Services Management</h1>
        <button class="btn-add-supplier">
            <i class="fas fa-plus"></i>
            Add Service
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search services...">
            </div>

            <div class="filter-wrapper">
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
                        <th><input type="checkbox" class="checkbox-all"></th>
                        <th class="sortable">ID <i class="fas fa-sort"></i></th>
                        <th>Image</th>
                        <th class="sortable">Service Name <i class="fas fa-sort"></i></th>
                        <th>Description</th>
                        <th>Assigned Employee</th>
                        <th>Price</th>
                        <th>Status</th>

                        <th class="actions-header">Actions <i class="fas fa-info-circle tooltip-icon"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td><input type="checkbox" class="row-checkbox"></td>
                            <td>{{ $service->service_id }}</td>
                            <td>
                                @if($service->image)
                                    <img src="{{ asset($service->image) }}" alt="Service Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                @else
                                    <img src="{{ asset('images/default-service.png') }}" alt="Default Service Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                @endif
                            </td>
                            <td>{{ $service->service_name }}</td>
                            <td>{{ $service->description ?? 'N/A' }}</td>
                            <td>{{ $service->employee->employee_name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($service->service_price, 2) }}</td>
                            <td><span class="payment-badge status-active">Active</span></td>

                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <button class="btn-action btn-view" title="View Service" 
                                            onclick="viewService({{ $service->service_id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit" title="Edit Service" 
                                            onclick="editService({{ $service->service_id }}, '{{ addslashes($service->service_name) }}', {{ $service->service_price }}, '{{ addslashes($service->description ?? '') }}', {{ $service->employee_id ?? 'null' }}, '{{ $service->image ?? '' }}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-delete-action" title="Delete Service" 
                                            onclick="deleteService({{ $service->service_id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>1-{{ count($services) }}</strong> of <strong>{{ count($services) }}</strong>
            </div>

            <div class="pagination">
                <button class="page-btn page-prev" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn page-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Service Modal -->
<div id="addServiceModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <h2>Add New Service</h2>
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="service_name">Service Name *</label>
                <input type="text" name="service_name" required placeholder="Enter service name">
            </div>
            <div class="form-group">
                <label for="service_price">Service Price *</label>
                <input type="number" name="service_price" step="0.01" required placeholder="Enter price">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" placeholder="Enter description (optional)"></textarea>
            </div>
            <div class="form-group">
                <label for="employee_id">Assigned Employee *</label>
                <select name="employee_id" required>
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->employee_id }}">{{ $employee->name ?? 'Employee #' . $employee->employee_id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image">Service Image</label>
                <input type="file" name="image" id="serviceImageInput" accept="image/*">
                <div id="serviceImagePreview" style="margin-top:10px;">
                    <!-- Image preview will appear here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Service</button>
            </div>
        </form>
    </div>
</div>

<!-- View Service Modal -->
<div id="viewServiceModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <div class="modal-header-view">
            <h2><i class="fas fa-eye"></i> Service Details</h2>
            <button class="modal-close-btn" onclick="closeViewServiceModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-section">
                <div class="view-image-container" id="viewServiceImage">
                    <!-- Image will be inserted here -->
                </div>
                <div class="view-details">
                    <div class="detail-row">
                        <span class="detail-label">Service ID:</span>
                        <span class="detail-value" id="view_service_id"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Service Name:</span>
                        <span class="detail-value" id="view_service_name"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Price:</span>
                        <span class="detail-value" id="view_service_price"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Assigned Employee:</span>
                        <span class="detail-value" id="view_employee_name"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value"><span class="badge-success">Active</span></span>
                    </div>
                    <div class="detail-row full-width">
                        <span class="detail-label">Description:</span>
                        <span class="detail-value" id="view_description"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Created At:</span>
                        <span class="detail-value" id="view_created_at"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Updated At:</span>
                        <span class="detail-value" id="view_updated_at"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeViewServiceModal()" class="btn btn-secondary">Close</button>
            <button type="button" onclick="editFromView()" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Service
            </button>
        </div>
    </div>
</div>

<!-- Edit Service Modal -->
<div id="editServiceModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <h2><i class="fas fa-edit"></i> Edit Service</h2>
        <form id="editServiceForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_service_id" name="service_id">
            
            <div class="form-group">
                <label for="edit_service_name">Service Name *</label>
                <input type="text" id="edit_service_name" name="service_name" required placeholder="Enter service name">
            </div>
            
            <div class="form-group">
                <label for="edit_service_price">Service Price *</label>
                <input type="number" id="edit_service_price" name="service_price" step="0.01" required placeholder="Enter price">
            </div>
            
            <div class="form-group">
                <label for="edit_description">Description</label>
                <textarea id="edit_description" name="description" placeholder="Enter description (optional)"></textarea>
            </div>
            
            <div class="form-group">
                <label for="edit_employee_id">Assigned Employee *</label>
                <select id="edit_employee_id" name="employee_id" required>
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->employee_id }}">{{ $employee->name ?? 'Employee #' . $employee->employee_id }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="edit_image">Service Image</label>
                <div id="currentImagePreview" style="margin-bottom: 10px;">
                    <!-- Current image will be shown here -->
                </div>
                <input type="file" name="image" id="editServiceImageInput" accept="image/*">
                <div id="editServiceImagePreview" style="margin-top:10px;">
                    <!-- New image preview will appear here -->
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Service</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Styles -->
<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modal {
        background: white;
        padding: 30px;
        border-radius: 8px;
        width: 500px;
        max-width: 90%;
    }

    .modal h2 {
        margin-top: 0;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        margin-top: 5px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn.btn-primary {
        background-color: #1d4ed8;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
    }

    .btn.btn-secondary {
        background-color: #e5e7eb;
        color: black;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
    }

    /* View Modal Styles */
    .modal-header-view {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f5f9;
    }

    .modal-header-view h2 {
        margin: 0;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header-view h2 i {
        color: #3b82f6;
    }

    .modal-close-btn {
        background: none;
        border: none;
        font-size: 20px;
        color: #64748b;
        cursor: pointer;
        padding: 5px;
        transition: all 0.2s;
    }

    .modal-close-btn:hover {
        color: #ef4444;
        transform: rotate(90deg);
    }

    .modal-body-view {
        padding: 10px 0;
    }

    .view-section {
        display: flex;
        gap: 20px;
    }

    .view-image-container {
        flex-shrink: 0;
        width: 150px;
        height: 150px;
        border-radius: 12px;
        overflow: hidden;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e2e8f0;
    }

    .view-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .view-details {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .detail-row {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .detail-row.full-width {
        grid-column: span 2;
    }

    .detail-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 15px;
        color: #1e293b;
        font-weight: 500;
    }

    .badge-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    @media (max-width: 768px) {
        .view-section {
            flex-direction: column;
        }
        .view-details {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Modal Script -->
<script>
    const modal = document.getElementById("addServiceModal");
    const editModal = document.getElementById("editServiceModal");

    document.querySelector(".btn-add-supplier").addEventListener("click", () => {
        modal.style.display = "flex";
    });

    function closeModal() {
        modal.style.display = "none";
    }

    function closeEditModal() {
        editModal.style.display = "none";
        // Clear the form
        document.getElementById('editServiceForm').reset();
        document.getElementById('currentImagePreview').innerHTML = '';
        document.getElementById('editServiceImagePreview').innerHTML = '';
    }

    // Edit Service Function
    function editService(id, name, price, description, employeeId, imagePath) {
        // Show the edit modal
        editModal.style.display = "flex";
        
        // Set form action
        document.getElementById('editServiceForm').action = `/admin/services/${id}`;
        
        // Populate form fields
        document.getElementById('edit_service_id').value = id;
        document.getElementById('edit_service_name').value = name;
        document.getElementById('edit_service_price').value = price;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_employee_id').value = employeeId || '';
        
        // Show current image if exists
        const currentImageDiv = document.getElementById('currentImagePreview');
        if (imagePath) {
            currentImageDiv.innerHTML = `
                <div style="margin-bottom: 5px;">
                    <small style="color: #666;">Current Image:</small>
                </div>
                <img src="${imagePath.startsWith('/') ? imagePath : '/' + imagePath}" 
                     style="max-width: 100px; max-height: 100px; border-radius: 8px; border: 2px solid #e5e7eb;">
            `;
        } else {
            currentImageDiv.innerHTML = '<small style="color: #999;">No current image</small>';
        }
        
        showToast('Service loaded for editing', 'info');
    }

    // View Service Function
    function viewService(id) {
        // Fetch service data via AJAX or use passed data
        fetch(`/admin/services/${id}`)
            .then(response => response.json())
            .then(data => {
                // Populate view modal
                document.getElementById('view_service_id').textContent = '#' + data.service_id;
                document.getElementById('view_service_name').textContent = data.service_name;
                document.getElementById('view_service_price').textContent = '₱' + parseFloat(data.service_price).toLocaleString('en-US', {minimumFractionDigits: 2});
                document.getElementById('view_employee_name').textContent = data.employee?.employee_name || 'Not Assigned';
                document.getElementById('view_description').textContent = data.description || 'No description available';
                document.getElementById('view_created_at').textContent = new Date(data.created_at).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'});
                document.getElementById('view_updated_at').textContent = new Date(data.updated_at).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'});
                
                // Set image
                const imageContainer = document.getElementById('viewServiceImage');
                if (data.image) {
                    imageContainer.innerHTML = `<img src="${data.image}" alt="${data.service_name}">`;
                } else {
                    imageContainer.innerHTML = `<i class="fas fa-image" style="font-size: 48px; color: #cbd5e1;"></i>`;
                }
                
                // Store data for edit
                window.currentServiceData = data;
                
                // Show modal
                document.getElementById('viewServiceModal').style.display = 'flex';
                showToast('Service details loaded', 'success');
            })
            .catch(error => {
                // Fallback: Use data from the page
                const row = document.querySelector(`button[onclick*="viewService(${id})"]`).closest('tr');
                const cells = row.querySelectorAll('td');
                
                document.getElementById('view_service_id').textContent = '#' + id;
                document.getElementById('view_service_name').textContent = cells[3].textContent;
                document.getElementById('view_service_price').textContent = cells[6].textContent;
                document.getElementById('view_employee_name').textContent = cells[5].textContent;
                document.getElementById('view_description').textContent = cells[4].textContent;
                document.getElementById('view_created_at').textContent = 'N/A';
                document.getElementById('view_updated_at').textContent = 'N/A';
                
                // Set image from table
                const img = cells[2].querySelector('img');
                const imageContainer = document.getElementById('viewServiceImage');
                if (img) {
                    imageContainer.innerHTML = `<img src="${img.src}" alt="Service">`;
                } else {
                    imageContainer.innerHTML = `<i class="fas fa-image" style="font-size: 48px; color: #cbd5e1;"></i>`;
                }
                
                document.getElementById('viewServiceModal').style.display = 'flex';
                showToast('Service details loaded', 'info');
            });
    }

    function closeViewServiceModal() {
        document.getElementById('viewServiceModal').style.display = 'none';
    }

    function editFromView() {
        closeViewServiceModal();
        if (window.currentServiceData) {
            const data = window.currentServiceData;
            editService(data.service_id, data.service_name, data.service_price, 
                       data.description || '', data.employee_id || null, data.image || '');
        }
    }

    // Delete Service Function
    function deleteService(id) {
        openDeleteModal(`/admin/services/${id}`, () => {
            location.reload();
        });
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            closeModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
        if (event.target === document.getElementById('viewServiceModal')) {
            closeViewServiceModal();
        }
    };

    // Image preview for add service modal
    document.addEventListener('DOMContentLoaded', function () {
        var imageInput = document.getElementById('serviceImageInput');
        if (imageInput) {
            imageInput.addEventListener('change', function(event) {
                const preview = document.getElementById('serviceImagePreview');
                preview.innerHTML = '';
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '100px';
                        img.style.maxHeight = '100px';
                        img.style.borderRadius = '8px';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // Image preview for edit service modal
        var editImageInput = document.getElementById('editServiceImageInput');
        if (editImageInput) {
            editImageInput.addEventListener('change', function(event) {
                const preview = document.getElementById('editServiceImagePreview');
                preview.innerHTML = '';
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '100px';
                        img.style.maxHeight = '100px';
                        img.style.borderRadius = '8px';
                        img.style.border = '2px solid #10b981';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
</script>
@endsection
