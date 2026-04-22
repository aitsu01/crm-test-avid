<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $latestUsers = User::query()
            ->latest()
            ->take(5)
            ->get(['id', 'name', 'email', 'created_at']);

        $latestProjects = Project::query()
            ->latest()
            ->take(5)
            ->get(['id', 'name', 'description', 'created_at']);

        return Inertia::render('avid/Dashboard', [
            'latestUsers' => $latestUsers,
            'latestProjects' => $latestProjects,
        ])
            ->title('Dashboard')
            ->breadcrumb('Dashboard')
            ->hideTitleBar();
    }
}
