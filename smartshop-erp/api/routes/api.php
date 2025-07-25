<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::prefix('v1')->group(function () {

    // Authentication routes
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
        Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum');
    });

    // Public product routes
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/featured', [ProductController::class, 'featured']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::get('/{id}/related', [ProductController::class, 'related']);
    });

    // Public category routes
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{id}', [CategoryController::class, 'show']);
        Route::get('/{id}/products', [CategoryController::class, 'products']);
    });

    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {

        // User profile routes
        Route::prefix('user')->group(function () {
            Route::get('/profile', [UserController::class, 'profile']);
            Route::put('/profile', [UserController::class, 'updateProfile']);
            Route::post('/change-password', [UserController::class, 'changePassword']);
        });

        // Order routes
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::post('/', [OrderController::class, 'store']);
            Route::get('/{id}', [OrderController::class, 'show']);
            Route::post('/{id}/cancel', [OrderController::class, 'cancel']);
        });

        // Affiliate routes
        Route::prefix('affiliate')->group(function () {
            Route::get('/profile', [AffiliateController::class, 'profile']);
            Route::post('/register', [AffiliateController::class, 'register']);
            Route::get('/commissions', [AffiliateController::class, 'commissions']);
            Route::post('/payouts', [AffiliateController::class, 'requestPayout']);
        });

        // Admin routes (require admin role)
        Route::middleware('role:Super Admin|Store Manager')->prefix('admin')->group(function () {

            // Dashboard
            Route::get('/dashboard/stats', [AdminController::class, 'dashboardStats']);

            // Product management
            Route::prefix('products')->group(function () {
                Route::post('/', [ProductController::class, 'store']);
                Route::put('/{id}', [ProductController::class, 'update']);
                Route::delete('/{id}', [ProductController::class, 'destroy']);
            });

            // Order management
            Route::prefix('orders')->group(function () {
                Route::get('/', [AdminController::class, 'orders']);
                Route::put('/{id}/status', [AdminController::class, 'updateOrderStatus']);
            });

            // User management
            Route::prefix('users')->group(function () {
                Route::get('/', [AdminController::class, 'users']);
                Route::post('/', [AdminController::class, 'createUser']);
                Route::put('/{id}', [AdminController::class, 'updateUser']);
                Route::delete('/{id}', [AdminController::class, 'deleteUser']);
            });

            // Affiliate management
            Route::prefix('affiliates')->group(function () {
                Route::get('/', [AdminController::class, 'affiliates']);
                Route::put('/{id}', [AdminController::class, 'updateAffiliate']);
            });

            // Reports
            Route::prefix('reports')->group(function () {
                Route::get('/sales', [AdminController::class, 'salesReport']);
                Route::get('/products', [AdminController::class, 'productsReport']);
                Route::get('/affiliates', [AdminController::class, 'affiliatesReport']);
            });
        });
    });

    // File upload route
    Route::post('/upload', function (Request $request) {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');

            return response()->json([
                'success' => true,
                'data' => [
                    'url' => asset('storage/' . $path),
                    'path' => $path
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ], 400);
    })->middleware('auth:sanctum');
});

// Health check route
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});
