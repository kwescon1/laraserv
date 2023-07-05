<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Enums\RoleEnum;
use Illuminate\Http\Response;

class GuideActivityController extends Controller
{
    public function show()
    {
        abort_if(auth()->user()->role_id !== RoleEnum::GUIDE, Response::HTTP_FORBIDDEN);

        $activities = Activity::where('guide_id', auth()->id())->orderBy('start_time')->get();

        return view('activities.guide-activities', compact('activities'));
    }
}
