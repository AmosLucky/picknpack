<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard
     */
    public function index(Request $request)
    {
        $user = $request->user();

        abort_unless($user, 401);

        /*
        |--------------------------------------------------------------------------
        | Pending incoming shipments
        |--------------------------------------------------------------------------
        |
        | Only count shipments where the logged-in user's store
        | is the receiver.
        |
        */

        $pendingIncomingCount = 0;

        if ($user->store_id) {
            $pendingIncomingCount = DB::table('orders')
                ->where(
                    'receiver_facility_id',
                    $user->store_id
                )
                ->whereRaw(
                    'LOWER(status) = ?',
                    ['pending']
                )
                ->count();
        }

        return view('dashboard', [
            'pendingIncomingCount' => $pendingIncomingCount,
        ]);
    }
}