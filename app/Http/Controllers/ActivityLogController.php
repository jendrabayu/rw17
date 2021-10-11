<?php

namespace App\Http\Controllers;

use App\DataTables\ActivityLogDataTable;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(ActivityLogDataTable $activityLogDataTable)
    {
        return $activityLogDataTable->render('activity-log');
    }
}
