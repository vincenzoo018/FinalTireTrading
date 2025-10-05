<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockAdjustment;
use App\Models\StockProd;
use App\Models\Inventory;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification;

class AdminStockAdjustmentController extends Controller
{
    /**
     * Notify requesting employee's user via email about status change.
     */
    protected function notifyRequester(StockAdjustment $adjustment, string $newStatus, ?string $notes = null): void
    {
        try {
            $requester = $adjustment->requestedBy; // Employee
            if (!$requester) {
                return;
            }
            $user = \App\Models\User::where('user_id', $requester->user_id)->first();
            if (!$user || empty($user->email)) {
                // Create in-app notification even if email missing
                Notification::create([
                    'user_id' => $requester->user_id,
                    'title' => "Stock Adjustment {$newStatus}",
                    'message' => "Your request #{$adjustment->stock_adjustment_id} has been {$newStatus}.",
                    'link' => route('admin.stockadjustments.index'),
                ]);
                return;
            }

            $subject = "Stock Adjustment #{$adjustment->stock_adjustment_id} {$newStatus}";
            $message = "Hello {$user->fname},\n\n" .
                "Your stock adjustment request (ID: {$adjustment->stock_adjustment_id}) has been {$newStatus}.\n" .
                "Product: " . ($adjustment->stockProd->product->product_name ?? 'N/A') . "\n" .
                "Type: {$adjustment->adjustment_type}\n" .
                "Quantity: {$adjustment->adjust_count}\n" .
                (!empty($notes) ? ("Notes: {$notes}\n") : '') .
                "\nThank you.";

            Mail::raw($message, function ($mail) use ($user, $subject) {
                $mail->to($user->email)->subject($subject);
            });

            // Create in-app notification
            Notification::create([
                'user_id' => $user->user_id,
                'title' => $subject,
                'message' => $message,
                'link' => route('admin.stockadjustments.index'),
            ]);
        } catch (\Throwable $e) {
            // Silently ignore email errors
        }
    }
    /**
     * Display a listing of pending stock adjustments for admin approval.
     */
    public function index()
    {
        // Only allow admins (role_id == 1)
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Access denied. Admin privileges required.']);
        }

        // Get all stock adjustments with relationships for admin review (pending first by default)
        $adjustments = StockAdjustment::with([
            'stockProd.product.inventory',
            'requestedBy',
            'reviewedBy'
        ])->orderByRaw("FIELD(status, 'pending','approved','rejected')")
          ->orderBy('created_at', 'desc')
          ->paginate(10);

        // Get all employees for the dropdown
        $employees = Employee::with('role')->get();

        return view('admin.admin-stockadjustments', compact('adjustments', 'employees'));
    }

    /**
     * Show the form for reviewing a specific adjustment.
     */
    public function show($id)
    {
        // Only allow admins (role_id == 1)
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Access denied. Admin privileges required.']);
        }

        $adjustment = StockAdjustment::with([
            'stockProd.product.inventory',
            'requestedBy',
            'reviewedBy'
        ])->findOrFail($id);

        $employees = Employee::with('role')->get();

        return view('admin.admin-stockadjustment-detail', compact('adjustment', 'employees'));
    }

    /**
     * Approve a stock adjustment and update inventory.
     */
    public function approve(Request $request, $id)
    {
        // Only allow admins (role_id == 1)
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Access denied. Admin privileges required.']);
        }

        $validated = $request->validate([
            'reviewed_by' => 'nullable|exists:employees,employee_id',
            'notes' => 'nullable|string|max:500',
        ]);

        $adjustment = StockAdjustment::findOrFail($id);

        // Get current admin employee
        $currentUser = Auth::user();
        $currentEmployee = Employee::where('user_id', $currentUser->user_id)->first();

        if (!$currentEmployee && in_array($currentUser->role_id, [1, 2])) {
            $currentEmployee = Employee::where('role_id', $currentUser->role_id)->first();
        }

        // Choose reviewer: explicit value or current admin
        $reviewerEmployeeId = $validated['reviewed_by'] ?? ($currentEmployee?->employee_id);

        // Update the adjustment with approval details
        $adjustment->update([
            'reviewed_by' => $reviewerEmployeeId,
            'reviewed_date' => now(),
            'status' => 'approved',
            'admin_notes' => $validated['notes'] ?? null,
        ]);

        // Apply the inventory adjustment
        $stockProd = $adjustment->stockProd;
        $inventory = Inventory::where('product_id', $stockProd->product_id)->first();

        if ($inventory) {
            switch ($adjustment->adjustment_type) {
                case 'increase':
                    $inventory->quantity_on_hand += $adjustment->adjust_count;
                    break;
                case 'decrease':
                    $inventory->quantity_on_hand -= $adjustment->adjust_count;
                    break;
            }
            $inventory->last_updated = now();
            $inventory->save();
        }

        // Notify requester
        $this->notifyRequester($adjustment, 'approved', $validated['notes'] ?? null);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => 'approved',
                'adjustment_id' => $adjustment->stock_adjustment_id,
            ]);
        }

        return redirect()->route('admin.stockadjustments.approvals.index')
            ->with('success', 'Stock adjustment approved and inventory updated successfully.');
    }

    /**
     * Reject a stock adjustment.
     */
    public function reject(Request $request, $id)
    {
        // Only allow admins (role_id == 1)
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Access denied. Admin privileges required.']);
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $adjustment = StockAdjustment::findOrFail($id);

        // Get current admin employee
        $currentUser = Auth::user();
        $currentEmployee = Employee::where('user_id', $currentUser->user_id)->first();

        if (!$currentEmployee && in_array($currentUser->role_id, [1, 2])) {
            $currentEmployee = Employee::where('role_id', $currentUser->role_id)->first();
        }

        // Update the adjustment with rejection details
        $adjustment->update([
            'reviewed_by' => $currentEmployee?->employee_id,
            'reviewed_date' => now(),
            'status' => 'rejected',
            'admin_notes' => $validated['rejection_reason'],
        ]);

        // Notify requester
        $this->notifyRequester($adjustment, 'rejected', $validated['rejection_reason']);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => 'rejected',
                'adjustment_id' => $adjustment->stock_adjustment_id,
            ]);
        }

        return redirect()->route('admin.stockadjustments.approvals.index')
            ->with('success', 'Stock adjustment rejected successfully.');
    }

    /**
     * Get pending adjustments count for dashboard.
     */
    public function getPendingCount()
    {
        $pendingCount = StockAdjustment::where('status', 'pending')->count();
        return response()->json(['count' => $pendingCount]);
    }

    /**
     * Bulk approve multiple adjustments.
     */
    public function bulkApprove(Request $request)
    {
        // Only allow admins (role_id == 1)
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Access denied. Admin privileges required.']);
        }

        // Normalize adjustment_ids to array (accept JSON string or array)
        $idsInput = $request->input('adjustment_ids');
        if (is_string($idsInput)) {
            $decoded = json_decode($idsInput, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $request->merge(['adjustment_ids' => $decoded]);
            }
        }

        $validated = $request->validate([
            'adjustment_ids' => 'required|array',
            'adjustment_ids.*' => 'exists:stock_adjustments,stock_adjustment_id',
            'reviewed_by' => 'nullable|exists:employees,employee_id',
        ]);

        $currentUser = Auth::user();
        $currentEmployee = Employee::where('user_id', $currentUser->user_id)->first();

        if (!$currentEmployee && in_array($currentUser->role_id, [1, 2])) {
            $currentEmployee = Employee::where('role_id', $currentUser->role_id)->first();
        }

        // Determine reviewer id for bulk approval (fallback to current admin)
        $bulkReviewerId = $validated['reviewed_by'] ?? ($currentEmployee?->employee_id);

        $approvedCount = 0;
        foreach ($validated['adjustment_ids'] as $adjustmentId) {
            $adjustment = StockAdjustment::find($adjustmentId);

            if ($adjustment && $adjustment->status === 'pending') {
                $adjustment->update([
                    'reviewed_by' => $bulkReviewerId,
                    'reviewed_date' => now(),
                    'status' => 'approved',
                ]);

                // Apply inventory adjustment
                $stockProd = $adjustment->stockProd;
                $inventory = Inventory::where('product_id', $stockProd->product_id)->first();

                if ($inventory) {
                    switch ($adjustment->adjustment_type) {
                        case 'increase':
                            $inventory->quantity_on_hand += $adjustment->adjust_count;
                            break;
                        case 'decrease':
                            $inventory->quantity_on_hand -= $adjustment->adjust_count;
                            break;
                    }
                    $inventory->last_updated = now();
                    $inventory->save();
                }

                $approvedCount++;
            }
        }

        return redirect()->route('admin.stockadjustments.approvals.index')
            ->with('success', "Successfully approved {$approvedCount} stock adjustments.");
    }
}
