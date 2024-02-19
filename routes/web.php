<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ContributionsController;
use App\Http\Controllers\admin\MembersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\member\ContributionController;
use App\Http\Controllers\member\MemberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [HomeController::class, 'index'])->middleware('auth')->name('dashboard');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/members-list', [MembersController::class, 'index'])->name('admin.members');
    Route::get('/members/{id}', [MembersController::class, 'show'])->name('admin.member.show');
    Route::delete('/member/{userId}', [MembersController::class, 'deleteUser'])->name('admin.deleteMember');
    Route::get('/search', [MembersController::class, 'search'])->name('search');
    Route::get('/admin/profile', [AdminController::class, 'edit'])->name('admin.profile.edit');
    Route::get('/clear-cache', [AdminController::class, 'clearCache'])->name('admin.clearCache');
    Route::get('/contributions', [ContributionsController::class, 'index'])->name('admin.contributions');

});

Route::middleware('auth')->group(function () {

Route::get('/members', [MemberController::class, 'index'])->name('member.members');
Route::get('/search-member', [MemberController::class, 'search'])->name('search.member');

//Member Contributions
Route::get('/my-contributions', [ContributionController::class, 'index'])->name('member.contribution');
Route::get('/new-contribution', [ContributionController::class, 'create'])->name('member.contribute.create');
Route::post('/contribute', [ContributionController::class, 'store'])->name('member.contribute.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
