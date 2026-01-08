<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class DashboardController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index(Request $request)
    {
        // Get user from session
        $user = session('user');

        // Check if user is suspended
        if ($user && isset($user['is_suspended']) && $user['is_suspended']) {
            $suspendedUntil = $user['suspended_until'] ?? null;

            if (!$suspendedUntil || strtotime($suspendedUntil) > time()) {
                return view('dashboard')
                    ->with('error', 'Your account is suspended.')
                    ->with('suspension_note', $user['suspension_note'] ?? '')
                    ->with('suspended_until', $suspendedUntil);
            }
        }
        $items = [];
        $response = $this->apiService->get('/items');

        // if ($response->successful()) {
        //     $items = $response->json();

        //     // Filter for current user if not admin
        //     if ($user && $user['role'] !== 'admin') {
        //         $items = array_filter($items, function ($item) use ($user) {
        //             return isset($item['user_id']) && $item['user_id'] == $user['id'];
        //         });
        //     }
        // }

        return view('dashboard', compact('items', 'user'));
    }

    public function profile()
    {
        $response = $this->apiService->profile();

        if ($response->successful()) {
            $profile = $response->json();
            return view('auth.profile', compact('profile'));
        }

        return redirect()->route('dashboard')->with('error', 'Failed to load profile');
    }
}
