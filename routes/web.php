<?php

// routes/web.php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Mekanik\DashboardController as MekanikDashboard;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Customer\HistoryController as CustomerHistoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================
// GUEST ROUTES (Belum Login)
// ============================================
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// ============================================
// AUTHENTICATED ROUTES (Sudah Login)
// ============================================
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // ========================================
    // ADMIN ROUTES (Role: admin)
    // ========================================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/chart-data', [AdminDashboard::class, 'chartData'])->name('chart-data');

        // User Management (Customers)
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
            Route::get('/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
        });

        // Mekanik Management
        Route::prefix('mekaniks')->name('mekaniks.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\MekanikController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\MekanikController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\MekanikController::class, 'store'])->name('store');
            Route::get('/{mekanik}', [App\Http\Controllers\Admin\MekanikController::class, 'show'])->name('show');
            Route::get('/{mekanik}/edit', [App\Http\Controllers\Admin\MekanikController::class, 'edit'])->name('edit');
            Route::put('/{mekanik}', [App\Http\Controllers\Admin\MekanikController::class, 'update'])->name('update');
            Route::delete('/{mekanik}', [App\Http\Controllers\Admin\MekanikController::class, 'destroy'])->name('destroy');
        });

        // Jenis Service Management
        Route::prefix('jenis-services')->name('jenis-services.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\JenisServiceController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\JenisServiceController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\JenisServiceController::class, 'store'])->name('store');
            Route::get('/{jenisService}', [App\Http\Controllers\Admin\JenisServiceController::class, 'show'])->name('show');
            Route::get('/{jenisService}/edit', [App\Http\Controllers\Admin\JenisServiceController::class, 'edit'])->name('edit');
            Route::put('/{jenisService}', [App\Http\Controllers\Admin\JenisServiceController::class, 'update'])->name('update');
            Route::delete('/{jenisService}', [App\Http\Controllers\Admin\JenisServiceController::class, 'destroy'])->name('destroy');
            Route::post('/{jenisService}/toggle-active', [App\Http\Controllers\Admin\JenisServiceController::class, 'toggleActive'])->name('admin.jenis-services.toggle-active');
        });

        // Booking Management (Admin)
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('index');
            Route::get('/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('show');
            Route::put('/{booking}/status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('update-status');
            Route::delete('/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('destroy');
        });

        // Sparepart Management
        Route::prefix('spareparts')->name('spareparts.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\SparepartController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\SparepartController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\SparepartController::class, 'store'])->name('store');
            Route::get('/{sparepart}', [App\Http\Controllers\Admin\SparepartController::class, 'show'])->name('show');
            Route::get('/{sparepart}/edit', [App\Http\Controllers\Admin\SparepartController::class, 'edit'])->name('edit');
            Route::put('/{sparepart}', [App\Http\Controllers\Admin\SparepartController::class, 'update'])->name('update');
            Route::delete('/{sparepart}', [App\Http\Controllers\Admin\SparepartController::class, 'destroy'])->name('destroy');
        });

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/bookings', [App\Http\Controllers\Admin\ReportController::class, 'bookings'])->name('bookings');
            Route::get('/payments', [App\Http\Controllers\Admin\ReportController::class, 'payments'])->name('payments');
            Route::get('/services', [App\Http\Controllers\Admin\ReportController::class, 'services'])->name('services');
            Route::get('/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('export');
        });
    });

    // ========================================
    // MEKANIK ROUTES (Role: mekanik)
    // ========================================
    Route::middleware('mekanik')->prefix('mekanik')->name('mekanik.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Mekanik\DashboardController::class, 'index'])->name('dashboard');

        // Task Management
        Route::prefix('tasks')->name('tasks.')->group(function () {
            Route::get('/', [App\Http\Controllers\Mekanik\TaskController::class, 'index'])->name('index');
            Route::get('/today', [App\Http\Controllers\Mekanik\TaskController::class, 'today'])->name('today');
            Route::get('/completed', [App\Http\Controllers\Mekanik\TaskController::class, 'completed'])->name('completed');
            Route::post('/{booking}/update-status', [App\Http\Controllers\Mekanik\TaskController::class, 'updateStatus'])->name('update-status');
            Route::post('/{booking}/start', [App\Http\Controllers\Mekanik\TaskController::class, 'start'])->name('start');
        });

        // Service Management
        Route::prefix('services')->name('services.')->group(function () {
            Route::get('/{booking}/detail', [App\Http\Controllers\Mekanik\ServiceController::class, 'detail'])->name('detail');
            Route::post('/{booking}/start', [App\Http\Controllers\Mekanik\ServiceController::class, 'start'])->name('start');
            Route::post('/{booking}/complete', [App\Http\Controllers\Mekanik\ServiceController::class, 'complete'])->name('complete');
            Route::get('/{booking}/invoice', [App\Http\Controllers\Mekanik\ServiceController::class, 'invoice'])->name('invoice');
        });

        // Schedule Management
        Route::prefix('schedule')->name('schedule.')->group(function () {
            Route::get('/', [App\Http\Controllers\Mekanik\ScheduleController::class, 'index'])->name('index');
            Route::get('/calendar', [App\Http\Controllers\Mekanik\ScheduleController::class, 'calendar'])->name('calendar');
            Route::get('/{date}', [App\Http\Controllers\Mekanik\ScheduleController::class, 'byDate'])->name('by-date');
        });
    });

    // ========================================
    // CUSTOMER ROUTES (Role: customer)
    // ========================================
    Route::middleware('customer')->prefix('customer')->name('customer.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');

        // Booking Management
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [CustomerBookingController::class, 'index'])->name('index');
            Route::get('/create', [CustomerBookingController::class, 'create'])->name('create');
            Route::post('/', [CustomerBookingController::class, 'store'])->name('store');
            Route::get('/{booking}', [CustomerBookingController::class, 'show'])->name('show');
            Route::post('/{booking}/cancel', [CustomerBookingController::class, 'cancel'])->name('cancel');
        });

        // Payment Management
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [CustomerPaymentController::class, 'index'])->name('index');
            Route::get('/{booking}', [CustomerPaymentController::class, 'create'])->name('create');
            Route::post('/{booking}/process', [CustomerPaymentController::class, 'process'])->name('process');
            Route::get('/{booking}/show', [CustomerPaymentController::class, 'show'])->name('show');
            Route::post('/{booking}/callback', [CustomerPaymentController::class, 'callback'])->name('callback');
        });

        // Service History
        Route::prefix('history')->name('history.')->group(function () {
            Route::get('/', [CustomerHistoryController::class, 'index'])->name('index');
            Route::get('/{booking}', [CustomerHistoryController::class, 'show'])->name('show');
            Route::get('/{booking}/invoice', [CustomerHistoryController::class, 'downloadInvoice'])->name('invoice');
        });

        // Profile Management
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [App\Http\Controllers\Customer\ProfileController::class, 'index'])->name('index');
            Route::put('/', [App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('update');
            Route::put('/change-password', [App\Http\Controllers\Customer\ProfileController::class, 'changePassword'])->name('change-password');
        });
    });

    // ========================================
    // DEFAULT REDIRECT AFTER LOGIN
    // ========================================
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isMekanik()) {
            return redirect()->route('mekanik.dashboard');
        }
        return redirect()->route('customer.dashboard');
    })->name('dashboard');

    // Redirect root to dashboard for authenticated users
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    });
});

// ============================================
// WEBHOOKS & API ROUTES (No auth required)
// ============================================
Route::prefix('api')->name('api.')->group(function () {
    // Midtrans Payment Notification Webhook
    Route::post('/payment/notification', [CustomerPaymentController::class, 'notification'])
        ->name('payment.notification');
});

// ============================================
// FALLBACK ROUTE (Handle 404)
// ============================================
Route::fallback(function () {
    return view('errors.404');
});
