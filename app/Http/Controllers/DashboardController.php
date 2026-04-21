<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('avid/Dashboard')
            ->title('Dashboard')
            ->breadcrumb('Dashboard')
            ->hideTitleBar();
    }
}
