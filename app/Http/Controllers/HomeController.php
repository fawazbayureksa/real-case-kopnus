<?php
namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Total Stats
        $totalMembers = Member::count();
        $totalTransactions = Transaction::count();
        $totalAmount = Transaction::sum('amount');

        // Chart Data (Last 7 days)
        $chartData = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        // Top & Bottom Members by transaction count
        $topMember = Member::withCount('transactions')
            ->orderBy('transactions_count', 'desc')
            ->first();

        $bottomMember = Member::withCount('transactions')
            ->orderBy('transactions_count', 'asc')
            ->first();

        return view('dashboard.home', compact('totalMembers', 'totalTransactions', 'totalAmount', 'chartData', 'topMember', 'bottomMember'));
    }


    public function myProfile()
    {
        return view('dashboard.profile');
    }
}
