<?php

use App\Livewire\Ejd\EjdForm;
use App\Livewire\OfferLetter\OfferLetterForm;
use App\Models\EjdSubmission;
use App\Models\OfferLetterSubmission;
use App\Models\JobSelection;
use App\Models\TaskSelection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// EJD Form Routes
Route::get('/ejd', EjdForm::class)->name('ejd.form');

// Offer Letter Routes
Route::get('/offer-letter', OfferLetterForm::class)->name('offer-letter.form');

// Privacy Policy
Route::view('/privacy', 'privacy')->name('privacy');

// Analytics Dashboard (hardcoded auth)
Route::match(['get', 'post'], '/analytics', function (Request $request) {
    $authUser = 'ejdadmin';
    $authPass = 'R2w-smart-2026!';

    // Logout
    if ($request->query('logout')) {
        $request->session()->forget('analytics_auth');
        return redirect('/analytics');
    }

    // Handle login POST
    if ($request->isMethod('post')) {
        if ($request->input('user') === $authUser && $request->input('pass') === $authPass) {
            $request->session()->put('analytics_auth', true);
            return redirect('/analytics');
        }
        return response(view('analytics-login', ['error' => 'Invalid credentials.']), 401);
    }

    // Check session
    if (! $request->session()->get('analytics_auth')) {
        return view('analytics-login', ['error' => null]);
    }

    // Gather data
    $thirtyDaysAgo = now()->subDays(30);

    return view('analytics', [
        'ejdTotal'    => EjdSubmission::count(),
        'ejdLast30'   => EjdSubmission::where('created_at', '>=', $thirtyDaysAgo)->count(),
        'offerTotal'  => OfferLetterSubmission::count(),
        'offerLast30' => OfferLetterSubmission::where('created_at', '>=', $thirtyDaysAgo)->count(),
        'jobSelTotal' => JobSelection::count(),
        'jobSelLast30'=> JobSelection::where('selected_at', '>=', $thirtyDaysAgo)->count(),
        'taskSelTotal'=> TaskSelection::count(),
        'taskSelLast30'=> TaskSelection::where('selected_at', '>=', $thirtyDaysAgo)->count(),
        'topJobs'     => DB::table('ejd_job_selections')
                            ->join('ejd_jobs', 'ejd_jobs.id', '=', 'ejd_job_selections.job_id')
                            ->select('ejd_job_selections.job_id', 'ejd_jobs.name as title', DB::raw('COUNT(*) as total'))
                            ->groupBy('ejd_job_selections.job_id', 'ejd_jobs.name')
                            ->orderByDesc('total')
                            ->limit(10)
                            ->get(),
        'topTasks'    => DB::table('ejd_task_selections')
                            ->join('ejd_tasks', 'ejd_tasks.id', '=', 'ejd_task_selections.task_id')
                            ->select('ejd_task_selections.task_id', 'ejd_tasks.name', DB::raw('COUNT(*) as total'))
                            ->groupBy('ejd_task_selections.task_id', 'ejd_tasks.name')
                            ->orderByDesc('total')
                            ->limit(10)
                            ->get(),
        'offerByType' => DB::table('ejd_offer_letter_submissions')
                            ->select('template_type', 'language', DB::raw('COUNT(*) as total'))
                            ->groupBy('template_type', 'language')
                            ->orderByDesc('total')
                            ->get(),
        'recentEjd'   => EjdSubmission::latest()->limit(10)->get(),
    ]);
});
