<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user registration for mobile app.
     * User hanya input NIK, nama otomatis dari data penduduk
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16', // NIK harus 16 digit
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah NIK ada di database penduduk
        $penduduk = Penduduk::where('nik', $request->nik)->first();

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'NIK tidak terdaftar dalam database kependudukan desa'
            ], 404);
        }

        // Cek apakah NIK sudah digunakan oleh user lain
        if ($penduduk->hasAccount()) {
            return response()->json([
                'success' => false,
                'message' => 'NIK sudah terdaftar pada akun lain'
            ], 400);
        }

        // Buat user dengan nama otomatis dari data penduduk
        $user = User::create([
            'name' => $penduduk->nama_lengkap, // Ambil nama dari penduduk
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'penduduk_nik' => $request->nik, // Link ke penduduk
            'platform_register' => 'mobile',
            'roles' => 'user',
        ]);

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Load relasi penduduk untuk response
        $user->load('penduduk');

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'no_hp' => $user->no_hp,
                    'roles' => $user->roles,
                    'nik' => $user->penduduk_nik,
                    'penduduk' => [
                        'nama_lengkap' => $penduduk->nama_lengkap,
                        'tempat_lahir' => $penduduk->tempat_lahir,
                        'tanggal_lahir' => $penduduk->tanggal_lahir,
                        'alamat' => $penduduk->alamat ?? '-',
                        'rt' => $penduduk->rt ?? '-',
                        'rw' => $penduduk->rw ?? '-',
                    ]
                ]
            ]
        ], 201);
    }

    /**
     * Handle user login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // Cek apakah user sudah terverifikasi (punya NIK)
        if (!$user->isVerified() && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Akun belum terverifikasi. Silakan verifikasi NIK terlebih dahulu.'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        // Load relasi penduduk
        $user->load('penduduk');

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'no_hp' => $user->no_hp,
                    'roles' => $user->roles,
                    'nik' => $user->penduduk_nik,
                    'is_verified' => $user->isVerified(),
                    'penduduk' => $user->penduduk ? [
                        'nama_lengkap' => $user->penduduk->nama_lengkap,
                        'tempat_lahir' => $user->penduduk->tempat_lahir,
                        'tanggal_lahir' => $user->penduduk->tanggal_lahir,
                    ] : null
                ]
            ]
        ]);
    }

    /**
     * Get the authenticated User with penduduk data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $user->load('penduduk');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'no_hp' => $user->no_hp,
                'roles' => $user->roles,
                'nik' => $user->penduduk_nik,
                'is_verified' => $user->isVerified(),
                'platform_register' => $user->platform_register,
                'penduduk' => $user->penduduk ? [
                    'nik' => $user->penduduk->nik,
                    'nama_lengkap' => $user->penduduk->nama_lengkap,
                    'tempat_lahir' => $user->penduduk->tempat_lahir,
                    'tanggal_lahir' => $user->penduduk->tanggal_lahir,
                    'jenis_kelamin' => $user->penduduk->jenis_kelamin,
                    'agama' => $user->penduduk->agama,
                    'pekerjaan' => $user->penduduk->pekerjaan,
                    'status' => $user->penduduk->status,
                ] : null
            ]
        ]);
    }

    /**
     * Handle user logout.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout'
        ]);
    }

    /**
     * Check NIK availability (optional - untuk pre-validation di Flutter)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkNik(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'NIK harus 16 digit',
                'errors' => $validator->errors()
            ], 422);
        }

        $penduduk = Penduduk::where('nik', $request->nik)->first();

        if (!$penduduk) {
            return response()->json([
                'success' => false,
                'message' => 'NIK tidak ditemukan dalam database kependudukan'
            ], 404);
        }

        if ($penduduk->hasAccount()) {
            return response()->json([
                'success' => false,
                'message' => 'NIK sudah terdaftar pada akun lain'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'NIK valid dan tersedia',
            'data' => [
                'nama_lengkap' => $penduduk->nama_lengkap,
                'tempat_lahir' => $penduduk->tempat_lahir,
                'tanggal_lahir' => $penduduk->tanggal_lahir->format('d-m-Y'),
            ]
        ]);
    }
}
