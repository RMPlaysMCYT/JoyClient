<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class ApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.server.url', 'http://localhost:8000/api');
        Log::info('ApiService initialized with base URL: ' . $this->baseUrl);
    }

    protected function createErrorResponse($message, $status = 500)
    {
        return new Response(new GuzzleResponse(
            $status, 
            ['Content-Type' => 'application/json'], 
            json_encode(['message' => $message, 'success' => false])
        ));
    }

    public function get($endpoint)
    {
        $token = Session::get('api_token');

        if (!$token) {
            Log::error('No API token found in session for GET request');
            return $this->createErrorResponse('Unauthenticated', 401);
        }

        Log::info('Making GET request to: ' . $this->baseUrl . $endpoint);
        Log::info('Token: ' . substr($token, 0, 20) . '...');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->timeout(30)->get($this->baseUrl . $endpoint);

            Log::info('GET response status: ' . $response->status());

            if ($response->status() == 401) {
                Log::warning('API returned 401 - clearing session');
                Session::forget(['api_token', 'user']);
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('GET request failed: ' . $e->getMessage());
            return $this->createErrorResponse('API connection failed: ' . $e->getMessage());
        }
    }

    public function post($endpoint, $data = [])
    {
        $token = Session::get('api_token');

        if (!$token) {
            Log::error('No API token found in session for POST request');
            return $this->createErrorResponse('Unauthenticated', 401);
        }

        Log::info('Making POST request to: ' . $this->baseUrl . $endpoint);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->baseUrl . $endpoint, $data);

            Log::info('POST response status: ' . $response->status());

            if ($response->status() == 401) {
                Log::warning('API returned 401 - clearing session');
                Session::forget(['api_token', 'user']);
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('POST request failed: ' . $e->getMessage());
            return $this->createErrorResponse('API connection failed: ' . $e->getMessage());
        }
    }

    public function put($endpoint, $data = [])
    {
        $token = Session::get('api_token');

        if (!$token) {
            Log::error('No API token found in session for PUT request');
            return $this->createErrorResponse('Unauthenticated', 401);
        }

        Log::info('Making PUT request to: ' . $this->baseUrl . $endpoint);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout(30)->put($this->baseUrl . $endpoint, $data);

            Log::info('PUT response status: ' . $response->status());

            if ($response->status() == 401) {
                Log::warning('API returned 401 - clearing session');
                Session::forget(['api_token', 'user']);
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('PUT request failed: ' . $e->getMessage());
            return $this->createErrorResponse('API connection failed: ' . $e->getMessage());
        }
    }

    public function delete($endpoint)
    {
        $token = Session::get('api_token');

        if (!$token) {
            Log::error('No API token found in session for DELETE request');
            return $this->createErrorResponse('Unauthenticated', 401);
        }

        Log::info('Making DELETE request to: ' . $this->baseUrl . $endpoint);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->timeout(30)->delete($this->baseUrl . $endpoint);

            Log::info('DELETE response status: ' . $response->status());

            if ($response->status() == 401) {
                Log::warning('API returned 401 - clearing session');
                Session::forget(['api_token', 'user']);
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('DELETE request failed: ' . $e->getMessage());
            return $this->createErrorResponse('API connection failed: ' . $e->getMessage());
        }
    }

    // Authentication methods
    public function login($credentials)
    {
        Log::info('API Login attempt', ['username' => $credentials['username'] ?? 'unknown']);

        try {
            $response = Http::post($this->baseUrl . '/login', $credentials);

            Log::info('Login API response status: ' . $response->status());
            $data = $response->json() ?? [];

            if ($response->successful()) {
                if (isset($data['token'])) {
                    Session::put('api_token', $data['token']);
                    Log::info('Token stored in session');
                }

                if (isset($data['user'])) {
                    Session::put('user', $data['user']);
                    Log::info('User data stored in session');
                }
            }

            return $data;
        } catch (\Exception $e) {
            Log::error('Login API exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage()
            ];
        }
    }

    public function register($data)
    {
        $logData = $data;
        unset($logData['password']);
        unset($logData['password_confirmation']);
        Log::info('API Register payload:', $logData);

        try {
            $response = Http::post($this->baseUrl . '/register', $data);

            Log::info('Register API response status: ' . $response->status());

            $body = $response->body();
            Log::info('Register API raw response: ' . $body);
            
            $responseData = $response->json();

            // Handle non-JSON response (likely an error page)
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Register API returned invalid JSON: ' . json_last_error_msg());
                return [
                    'success' => false,
                    'message' => 'Server returned an invalid response. Please try again later.'
                ];
            }

            if ($response->successful()) {
                // Ensure success checks align with actual data presence
                if (!isset($responseData['success'])) {
                    // Check if we actually got a user/token, otherwise it's not a success
                    $responseData['success'] = isset($responseData['user']);
                }

                if (isset($responseData['token'])) {
                    Session::put('api_token', $responseData['token']);
                }

                if (isset($responseData['user'])) {
                    Session::put('user', $responseData['user']);
                }
            }

            return $responseData;
        } catch (\Exception $e) {
            Log::error('Register API exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ];
        }
    }

    // Profile methods - These should return HTTP responses
    public function profile()
    {
        return $this->get('/profile');
    }

    public function updateProfile($data)
    {
        return $this->put('/profile', $data);
    }

    public function changePassword($data)
    {
        return $this->put('/change-password', $data);
    }

    // Helper methods
    public function isAuthenticated()
    {
        $hasToken = Session::has('api_token');
        $hasUser = Session::has('user');

        return $hasToken && $hasUser;
    }
    public function logout()
    {
        $token = Session::get('api_token');

        if ($token) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ])->post($this->baseUrl . '/logout');
            } catch (\Exception $e) {
            }
        }

        // Clear local session regardless of server response
        Session::forget(['api_token', 'user']);
        Session::flush();

        return true;
    }
}
