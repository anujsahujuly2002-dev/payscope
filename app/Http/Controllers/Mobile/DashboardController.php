<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\DashboardRepository;

class DashboardController extends Controller
{
    //

    private $dashboardRepo;
    public function __construct(DashboardRepository $dashboardRepo) {
        $this->dashboardRepo = $dashboardRepo;
    }

    public function logout() {
        $response = $this->dashboardRepo->logout('mobile-api');
        return response()->json($response);
    }

}
