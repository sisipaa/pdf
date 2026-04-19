<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Count trips
        $dalamNegeriCount = Trip::where('type', 'dalam_negeri')
            ->where('user_id', $user->id)
            ->count();

        $luarNegeriCount = Trip::where('type', 'luar_negeri')
            ->where('user_id', $user->id)
            ->count();

        // Get all trips for archive
        $trips = Trip::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('dalamNegeriCount', 'luarNegeriCount', 'trips'));
    }
}
