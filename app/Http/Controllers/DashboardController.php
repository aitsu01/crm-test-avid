<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::query()->count();
        $totalProjects = Project::query()->count();
        $totalTasks = Task::query()->count();

        $latestUsers = User::query()
            ->latest()
            ->take(5)
            ->get(['id', 'name', 'email', 'created_at']);

        $latestProjects = Project::query()
            ->latest()
            ->take(5)
            ->get(['id', 'name', 'description', 'created_at']);

        $latestTasks = Task::query()
            ->latest()
            ->take(5)
            ->get(['id', 'name', 'description', 'created_at']);

        return Inertia::render('avid/Dashboard', [
            'totalUsers' => $totalUsers,
            'totalProjects' => $totalProjects,
            'totalTasks' => $totalTasks,
            'latestUsers' => $latestUsers,
            'latestProjects' => $latestProjects,
            'latestTasks' => $latestTasks,
        ])
            ->title('Dashboard')
            ->breadcrumb('Dashboard')
            ->hideTitleBar();
    }
}