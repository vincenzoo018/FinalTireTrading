# 8PLY Tire Trading - Design System Guide

## 🎨 Quick Reference for Developers

---

## Color System

### Admin Panel Colors
```css
Primary:        #4f46e5 (Indigo)
Primary Light:  #818cf8
Secondary:      #0ea5e9 (Sky Blue)
Dark:           #1e293b
Light:          #f8fafc
Gray:           #64748b
Success:        #10b981
Warning:        #f59e0b
Danger:         #ef4444
```

### Customer Portal Colors
```css
Primary:        #3498db (Blue)
Secondary:      #2c3e50 (Dark Blue)
Accent:         #e74c3c (Red)
Success:        #27ae60 (Green)
Warning:        #f39c12 (Orange)
```

---

## Typography

### Font Families
- **Admin**: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
- **Customer**: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif

### Font Sizes
```css
Headings:
  h1: 2rem (32px)
  h2: 1.75rem (28px)
  h3: 1.5rem (24px)
  h4: 1.25rem (20px)

Body:
  Base: 1rem (16px)
  Small: 0.875rem (14px)
  Tiny: 0.75rem (12px)
```

---

## Spacing System

```css
xs:  0.25rem (4px)
sm:  0.5rem (8px)
md:  1rem (16px)
lg:  1.5rem (24px)
xl:  2rem (32px)
2xl: 2.5rem (40px)
3xl: 3rem (48px)
```

---

## Border Radius

```css
Small:   4px
Medium:  8px
Large:   12px
XLarge:  16px
Round:   50%
```

---

## Shadows

```css
Small:  0 2px 8px rgba(0, 0, 0, 0.05)
Medium: 0 4px 20px rgba(0, 0, 0, 0.08)
Large:  0 8px 30px rgba(0, 0, 0, 0.12)
XLarge: 0 20px 60px rgba(0, 0, 0, 0.1)
```

---

## Components

### Buttons

#### Primary Button
```html
<button class="btn btn-primary">
    <i class="fas fa-icon"></i> Button Text
</button>
```

#### Success Button
```html
<button class="btn btn-success">
    <i class="fas fa-check"></i> Success
</button>
```

#### Warning Button
```html
<button class="btn btn-warning">
    <i class="fas fa-exclamation"></i> Warning
</button>
```

#### Danger Button
```html
<button class="btn btn-danger">
    <i class="fas fa-trash"></i> Delete
</button>
```

---

### Cards

#### Basic Card
```html
<div class="card">
    <div class="card-header">
        <h3>Card Title</h3>
    </div>
    <div class="card-body">
        Card content here
    </div>
</div>
```

#### Stat Card
```html
<div class="stat-card">
    <div class="stat-icon" style="background: #4f46e5;">
        <i class="fas fa-users"></i>
    </div>
    <div class="stat-info">
        <h3>1,254</h3>
        <p>Total Users</p>
    </div>
</div>
```

---

### Badges

#### Status Badges
```html
<span class="payment-badge status-completed">Completed</span>
<span class="payment-badge status-pending">Pending</span>
<span class="payment-badge status-cancelled">Cancelled</span>
<span class="payment-badge status-processing">Processing</span>
```

#### Stock Badges
```html
<span class="stock-badge stock-high">100</span>
<span class="stock-badge stock-medium">50</span>
<span class="stock-badge stock-low">10</span>
<span class="stock-badge stock-out">0</span>
```

---

### Tables

```html
<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Data 1</td>
                <td>Data 2</td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn action-btn-edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn action-btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

---

## Animation Classes

### Fade Animations
```css
.fade-in          /* Fade in from transparent */
.fade-in-up       /* Fade in from bottom */
.fade-in-down     /* Fade in from top */
```

### Slide Animations
```css
.slide-in         /* Slide in from left */
.slide-in-left    /* Slide in from left */
.slide-in-right   /* Slide in from right */
```

### Special Effects
```css
.pulse            /* Pulsing animation */
.bounce           /* Bouncing animation */
.rotate           /* Rotating animation */
.float            /* Floating animation */
```

---

## Responsive Breakpoints

```css
/* Mobile First Approach */

/* Small devices (phones, less than 576px) */
@media (max-width: 576px) { }

/* Medium devices (tablets, 576px to 768px) */
@media (min-width: 576px) and (max-width: 768px) { }

/* Large devices (desktops, 768px to 992px) */
@media (min-width: 768px) and (max-width: 992px) { }

/* Extra large devices (large desktops, 992px and up) */
@media (min-width: 992px) { }
```

---

## Icons

### Font Awesome Icons Used

#### Admin Panel
```
Dashboard:    fa-tachometer-alt
Products:     fa-box
Inventory:    fa-warehouse
Orders:       fa-shopping-cart
Sales:        fa-chart-line
Customers:    fa-users
Services:     fa-concierge-bell
Booking:      fa-calendar-alt
Suppliers:    fa-truck
Employee:     fa-user-tie
```

#### Customer Portal
```
Home:         fa-home
Products:     fa-tire
Services:     fa-tools
Booking:      fa-calendar-check
Cart:         fa-shopping-cart
User:         fa-user
Phone:        fa-phone
Email:        fa-envelope
Location:     fa-map-marker-alt
```

---

## Best Practices

### DO's ✅
- Use consistent spacing from the spacing system
- Apply hover effects to all interactive elements
- Use semantic HTML elements
- Add loading states for async operations
- Implement proper error handling
- Use icons to enhance understanding
- Test on multiple devices
- Ensure keyboard accessibility

### DON'Ts ❌
- Don't use inline styles (use CSS classes)
- Don't mix color schemes
- Don't forget mobile responsiveness
- Don't ignore accessibility
- Don't use too many animations
- Don't hardcode values
- Don't skip error states
- Don't forget loading indicators

---

## Common Patterns

### Loading State
```html
<button class="btn btn-primary" disabled>
    <i class="fas fa-spinner fa-spin"></i> Loading...
</button>
```

### Empty State
```html
<div class="alert alert-info text-center">
    <i class="fas fa-info-circle"></i>
    No data available
</div>
```

### Success Message
```html
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    Operation completed successfully!
</div>
```

### Error Message
```html
<div class="alert alert-danger">
    <i class="fas fa-exclamation-triangle"></i>
    An error occurred. Please try again.
</div>
```

---

## Form Elements

### Input Field
```html
<div class="mb-3">
    <label for="input" class="form-label">Label</label>
    <input type="text" class="form-control" id="input" placeholder="Enter text">
</div>
```

### Select Dropdown
```html
<div class="mb-3">
    <label for="select" class="form-label">Select Option</label>
    <select class="form-control" id="select">
        <option>Option 1</option>
        <option>Option 2</option>
    </select>
</div>
```

### Textarea
```html
<div class="mb-3">
    <label for="textarea" class="form-label">Description</label>
    <textarea class="form-control" id="textarea" rows="3"></textarea>
</div>
```

---

## Grid System

### Admin Dashboard Grid
```html
<div class="stats-grid">
    <!-- 4 columns on desktop, 2 on tablet, 1 on mobile -->
    <div class="stat-card">...</div>
    <div class="stat-card">...</div>
    <div class="stat-card">...</div>
    <div class="stat-card">...</div>
</div>
```

### Content Grid
```html
<div class="content-grid">
    <!-- 2 columns on desktop, 1 on mobile -->
    <div class="content-card">...</div>
    <div class="content-card">...</div>
</div>
```

---

## Performance Tips

1. **Use CSS Transforms**: Prefer `transform` over `top/left` for animations
2. **GPU Acceleration**: Use `transform: translateZ(0)` for smooth animations
3. **Debounce Events**: Debounce scroll and resize events
4. **Lazy Load Images**: Load images only when needed
5. **Minimize Repaints**: Batch DOM updates
6. **Use CSS Variables**: For dynamic theming
7. **Optimize Selectors**: Keep CSS selectors simple

---

## Accessibility Checklist

- [ ] All images have alt text
- [ ] Forms have proper labels
- [ ] Color contrast meets WCAG AA standards
- [ ] Keyboard navigation works
- [ ] Focus indicators are visible
- [ ] ARIA labels where needed
- [ ] Semantic HTML structure
- [ ] Skip to content link
- [ ] Reduced motion support
- [ ] Screen reader tested

---

## Browser Support

### Minimum Versions
- Chrome: 90+
- Firefox: 88+
- Safari: 14+
- Edge: 90+
- Mobile Safari: 14+
- Chrome Mobile: 90+

---

## Quick Start

### Adding a New Page

1. **Create the view file** in `resources/views/`
2. **Extend the layout**: `@extends('layouts.admin.app')` or `@extends('layouts.customer.app')`
3. **Add content**: Use `@section('content')` ... `@endsection`
4. **Use existing components**: Cards, tables, buttons from this guide
5. **Test responsiveness**: Check on mobile, tablet, desktop

### Example:
```blade
@extends('layouts.admin.app')

@section('title', 'Page Title')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Page Title</h1>
        <button class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Your content here -->
        </div>
    </div>
</div>
@endsection
```

---

## Support & Resources

- **Font Awesome Icons**: https://fontawesome.com/icons
- **Bootstrap Docs**: https://getbootstrap.com/docs/5.3/
- **CSS Tricks**: https://css-tricks.com/
- **MDN Web Docs**: https://developer.mozilla.org/

---

**Created**: October 8, 2025  
**Version**: 1.0  
**Maintained by**: Development Team
