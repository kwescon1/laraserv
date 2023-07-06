<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Enums\RoleEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class GuideActivityController extends Controller
{
    public function show()
    {
        abort_if(auth()->user()->role_id !== RoleEnum::GUIDE, Response::HTTP_FORBIDDEN);

        $activities = Activity::where('guide_id', auth()->id())->orderBy('start_time')->get();

        return view('activities.guide-activities', compact('activities'));
    }

    public function export(Activity $activity)
    {
        abort_if(auth()->user()->role_id !== RoleEnum::GUIDE, Response::HTTP_FORBIDDEN);

        $data = $activity->load(['participants' => function ($query) {
            $query->orderByPivot('created_at');
        }]);

        return Pdf::loadView('activities.pdf', ['data' => $data])->download("{$activity->name}.pdf");
    }
}
