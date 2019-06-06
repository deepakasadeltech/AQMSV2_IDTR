<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Models\Call;
use Carbon\Carbon;
use App\Models\ParentDepartment;

class DoctorReportRepository
{
    public function getSettings()
    {
        return Setting::first();
    }

    public function doctorreports()
    {
        return DoctorReport::all();
    }

    
}
