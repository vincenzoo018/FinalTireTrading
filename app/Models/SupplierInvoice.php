<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierInvoice extends Model
{
    protected $primaryKey = 'invoice_id';
    
    protected $fillable = [
        'invoice_number',
        'transaction_id',
        'invoice_date',
        'due_date',
        'subtotal',
        'tax',
        'delivery_fee',
        'total_amount',
        'status',
        'notes'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];

    // Relationship to transaction
    public function transaction()
    {
        return $this->belongsTo(SuppTransOrder::class, 'transaction_id', 'transaction_id');
    }

    // Auto-generate invoice number
    public static function generateInvoiceNumber()
    {
        $year = date('Y');
        $lastInvoice = self::whereYear('invoice_date', $year)
                           ->orderBy('invoice_id', 'desc')
                           ->first();
        
        if ($lastInvoice) {
            // Extract number from last invoice (INV-2025-0001)
            $lastNumber = intval(substr($lastInvoice->invoice_number, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'INV-' . $year . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
