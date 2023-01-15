<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AdminDashboard\AdminDashboardRepository;
use App\Http\Repositories\StaffDashboard\StaffDashboardRepository;
use App\Http\Resources\Dashboard\AdminDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $adminDashboard, $staffDashboard;

    public function __construct(AdminDashboardRepository $adminDashboard, StaffDashboardRepository $staffDashboard)
    {
        $this->adminDashboard = $adminDashboard;
        $this->staffDashboard = $staffDashboard;
    }
    public function admin()
    {
        $dashboard = $this->adminDashboard->all();

        return new AdminDetail($dashboard);
    }

    public function staff()
    {
        $dashboard = $this->staffDashboard->all();

        return new AdminDetail($dashboard);
    }
}
