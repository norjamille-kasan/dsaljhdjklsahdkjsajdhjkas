<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
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

Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('Admin')) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('agent.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/users', function () {
        return view('admin.users');
    })->name('admin.users');

    Route::get('/submission', function () {
        return view('admin.submission');
    })->name('admin.submittions');

    Route::get('/account-setting', function (Request $request) {
        return view('admin.account-setting', [
            'user' => $request->user(),
        ]);
    })->name('admin.account-setting');

    Route::get('/companies', function (Request $request) {
        return view('admin.companies');
    })->name('admin.companies');

    Route::get('/manage-company/{id}', function ($id) {
        return view('admin.manage-company', [
            'company' => \App\Models\Company::find($id),
        ]);
    })->name('admin.manage-company');
});

Route::prefix('agent')->middleware(['auth', 'role:Agent'])->group(function () {
    Route::get('/dashboard', function () {
        return view('agent.dashboard');
    })->name('agent.dashboard');

    Route::get('/start-form', function (Request $request) {
        return view('agent.start-form');
    })->name('agent.start-form');

    Route::get('/account-setting', function (Request $request) {
        return view('agent.account-setting', [
            'user' => $request->user(),
        ]);
    })->name('agent.account-setting');

    Route::get('/submissions', function () {
        return view('agent.submission');
    })->name('agent.submittions');
});


Route::get('/print', function (Request $request) {
    
    return view('report',[
        'submissions' =>\App\Models\Submission::query()
            ->when(auth()->user()->hasRole('Agent'), function ($query) {
                return $query->where('user_id', auth()->user()->id);
            })
            ->when(
                $request->filterCompany
                , function ($query) use($request) {
                return $query->where('company_id',$request->filterCompany);
            })
            ->when(
                $request->filterSegment
                , function ($query) use($request) {
                return $query->where('segment_id',$request->filterSegment);
            })
            ->when(
                $request->filterTask
                , function ($query) use($request) {
                return $query->where('task_id',$request->filterTask);
            })
            ->when(
                $request->filterStartDate
                , function ($query) use($request) {
                return $query->where('created_at','>=',$request->filterStartDate);
            })
            ->when(
                $request->filterEndDate
                , function ($query) use($request) {
                return $query->where('created_at','<=',$request->filterEndDate);
            })
            ->get()
    ]);
});

require __DIR__.'/auth.php';
