<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use App\Http\Requests\ClientLoginRequest;
use App\Http\Requests\ClientRegisterRequest;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function showLogin()
    {
        // Redirect to dashboard if already logged in
        if ($this->apiService->isAuthenticated()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(ClientLoginRequest $request)
    {
        \Log::info('=== LOGIN CONTROLLER ===');
        \Log::info('Login attempt for username: ' . $request->username);

        $response = $this->apiService->login($request->validated());

        \Log::info('Login response from ApiService:', $response);

        // Check for success in different formats
        $isSuccess = false;
        $errorMessage = 'Login failed';

        // Format 1: success flag
        if (isset($response['success']) && $response['success'] === true) {
            $isSuccess = true;
        }

        // Format 2: token present
        elseif (isset($response['token'])) {
            $isSuccess = true;
        }

        // Format 3: status field
        elseif (isset($response['status']) && $response['status'] === 'success') {
            $isSuccess = true;
        }

        if ($isSuccess) {
            \Log::info('Login successful');

            // Verify session is set
            \Log::info('Post-login session check:', [
                'has_token' => session()->has('api_token'),
                'has_user' => session()->has('user'),
                'user' => session('user')
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Successfully logged in!');
        }

        // If we get here, login failed
        $errorMessage = $response['message'] ?? 'Login failed. Please check your credentials.';

        \Log::error('Login failed: ' . $errorMessage);

        return back()->withErrors(['message' => $errorMessage])
            ->withInput($request->except('password'));
    }

    public function showRegister()
    {
        // Redirect to dashboard if already logged in
        if ($this->apiService->isAuthenticated()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(ClientRegisterRequest $request)
    {
        $response = $this->apiService->register($request->validated());

        if (isset($response['success']) && $response['success'] === true) {
            return redirect()->route('dashboard')
                ->with('success', 'Registration successful! Welcome!');
        }

        // Handle validation errors from server
        if (isset($response['errors'])) {
            return back()->withErrors($response['errors'])->withInput();
        }

        return back()->withErrors([
            'message' => $response['message'] ?? 'Registration failed'
        ])->withInput($request->except('password', 'password_confirmation'));
    }

    public function showProfile()
    {
        if (!$this->apiService->isAuthenticated()) {
            return redirect()->route('login');
        }

        $response = $this->apiService->profile();

        if ($response->successful()) {
            $profile = $response->json();

            // Safe fallback if 'user' key is missing
            $user = $profile['user'] ?? $profile;

            // Optional: Fetch item counts for dashboard widgets
            $itemCount = 0;
            // ... (Your item count logic here) ...

            return view('auth.profile', compact('user', 'itemCount'));
        }

        return back()->with('error', 'Failed to load profile.');
    }
    public function updateProfile(Request $request)
    {
        // 1. Client-Side Validation (Fast feedback)
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'nullable|string',
        ]);
        $data = $request->only(['name', 'username', 'email', 'phone_number']);

        // 3. Send to API
        $response = $this->apiService->updateProfile($data);

        // 4. Handle Success
        if ($response->successful()) {
            $responseData = $response->json();

            // Update local session so the UI refreshes immediately
            if (isset($responseData['user'])) {
                session(['user' => $responseData['user']]);
            }

            return back()->with('success', 'Profile details updated!');
        }

        // 5. Handle Errors
        return back()->withErrors($response->json()['errors'] ?? ['message' => 'Update failed'])
            ->withInput();
    }

    public function showChangePassword()
    {
        if (!$this->apiService->isAuthenticated()) {
            return redirect()->route('login');
        }

        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        // 1. Client-Side Validation
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed', // expects password_confirmation field
        ]);

        // 2. Prepare Data
        $data = $request->only(['current_password', 'password', 'password_confirmation']);

        // 3. Send to API (Assume ApiService hits /change-password endpoint)
        $response = $this->apiService->changePassword($data);

        if ($response->successful()) {
            $responseData = $response->json();

            // CRITICAL: Update the session token because the old one is likely dead
            if (isset($responseData['token'])) {
                session(['api_token' => $responseData['token']]);
            }

            return back()->with('success', 'Password changed successfully!');
        }

        return back()->withErrors($response->json()['errors'] ?? ['message' => 'Password change failed']);
    }

    public function logout(Request $request)
    {
        // Call server logout API
        $this->apiService->logout();

        // Clear local session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
