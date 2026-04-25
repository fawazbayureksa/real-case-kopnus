<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('member')->latest()->paginate(10);
        $members = Member::where('is_active', true)->get();
        return view('transaction.index', compact('transactions', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:member,id',
            'reference_id' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1',
        ]);

        // Check if member is active
        $member = Member::find($request->member_id);
        if (!$member || !$member->is_active) {
            return redirect()->back()->with('error', 'Transaksi gagal: Member tidak aktif atau tidak ditemukan.');
        }

        // Idempotency check
        $existing = Transaction::where('reference_id', $request->reference_id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Transaksi gagal: Reference ID sudah digunakan');
        }

        Transaction::create([
            'member_id' => $request->member_id,
            'reference_id' => $request->reference_id,
            'amount' => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil.');
    }
}
