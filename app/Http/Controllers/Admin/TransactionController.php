<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Only allow authenticated admins (role_id == 1 or 2)
        if (!Auth::check() || !in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->route('auth.login')->withErrors(['auth' => 'Please login as an admin to view transactions.']);
        }

        // TODO: Fetch transactions from the database and pass to the view
        // $transactions = Transaction::with('supplier')->latest()->paginate(15);
        // return view('admin.transactions', compact('transactions'));

        // For now, just return the view (static data in Blade)
        return view('admin.transactions');
    }
}
