<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberStatusHistoryController extends Controller
{
    public function index()
    {
        $histories = MemberStatusHistory::with(['member', 'user'])->latest()->paginate(10);
        return view('approval.index', compact('histories'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,0',
            'note' => 'required|string|max:500',
        ]);

        $member = Member::findOrFail($id);
        $oldStatus = $member->is_active;
        $newStatus = (bool)$request->status;

        $member->is_active = $newStatus;
        $member->save();

        MemberStatusHistory::create([
            'member_id' => $member->id,
            'note' => $request->note,
            'changed_by' => Auth::id(),
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);

        $actionText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Member berhasil {$actionText}.");
    }
}
