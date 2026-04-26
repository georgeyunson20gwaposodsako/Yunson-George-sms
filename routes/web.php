<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\ApplicantController; // Linked for the new status features

// --- PUBLIC ROUTES ---

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit');


// --- APPLICANT / STUDENT ROUTES (With Status & Notification Logic) ---

Route::middleware(['auth'])->group(function () {
    
    // This route now checks if the user has an existing application to show the Bell/Status screen
    Route::get('/applicant/form', function () {
        $user = auth()->user();
        
        // Find the applicant profile linked to this user
        $applicant = \App\Models\Applicant::where('user_id', $user->id)->first();
        
        // Find their latest application status (Pending, Approved, or Declined)
        $application = $applicant 
            ? \App\Models\Application::where('applicant_id', $applicant->id)->latest()->first() 
            : null;

        return view('applicant.form', compact('application'));
    })->name('applicant.form');

    // Safe Web Route for form submission (Prevents the "Silent Refresh" bug)
    Route::post('/submit-application', [ApplicantController::class, 'store'])->name('submit.application');
});


// --- ADMIN ROUTES ---

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/applicants', [AdminController::class, 'applicants'])->name('applicants');
    Route::get('/applicants/{id}', [AdminController::class, 'showApplicant'])->name('applicants.show');
    Route::post('/approve/{id}', [AdminController::class, 'approve'])->name('approve');
    Route::post('/reject/{id}', [AdminController::class, 'reject'])->name('reject');
    Route::get('/secretaries', [AdminController::class, 'secretaries'])->name('secretaries');
    Route::post('/secretaries', [AdminController::class, 'storeSecretary'])->name('secretaries.store');
    Route::delete('/secretaries/{id}', [AdminController::class, 'deleteSecretary'])->name('secretaries.delete');
});


// --- SECRETARY ROUTES ---

Route::middleware(['auth', 'role:secretary'])->prefix('secretary')->name('secretary.')->group(function () {
    Route::get('/dashboard', [SecretaryController::class, 'dashboard'])->name('dashboard');
    Route::get('/applicants', [SecretaryController::class, 'index'])->name('applicants');
    Route::get('/applicants/create', [SecretaryController::class, 'create'])->name('applicants.create');
    Route::post('/applicants', [SecretaryController::class, 'store'])->name('applicants.store');
    Route::get('/applicants/{id}/edit', [SecretaryController::class, 'edit'])->name('applicants.edit');
    Route::put('/applicants/{id}', [SecretaryController::class, 'update'])->name('applicants.update');
    Route::delete('/applicants/{id}', [SecretaryController::class, 'destroy'])->name('applicants.delete');
    Route::get('/upload/{id}', [SecretaryController::class, 'showUpload'])->name('upload');
    Route::post('/upload/{id}', [SecretaryController::class, 'upload'])->name('upload.save');
});