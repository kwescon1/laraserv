<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use App\Models\Company;
use App\Models\Enums\RoleEnum;
use App\Models\User;
use App\Services\Image\UploadImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyActivityController extends Controller
{
    private $uploadImageService;

    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Company $company): View
    {
        $this->authorize('viewAny', $company);

        $company->load('activities');

        return view('companies.activities.index', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Company $company): View
    {
        $this->authorize('create', $company);

        $guides = User::where('company_id', $company->id)
            ->where('role_id', RoleEnum::GUIDE)
            ->pluck('name', 'id');

        return view('companies.activities.create', compact('guides', 'company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('create', $company);

        $filename = $this->uploadImageService->uploadImage($request);

        $activity = Activity::create($request->validated() + [
            'company_id' => $company->id,
            'photo' => $path ?? null,
            'photo' => $filename,
        ]);

        $activity->participants()->sync($request->input('guides'));

        return to_route('companies.activities.index', $company);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company, Activity $activity): View
    {
        $this->authorize('update', $company);

        $guides = User::where('company_id', $company->id)
            ->where('role_id', RoleEnum::GUIDE)
            ->pluck('name', 'id');

        return view('companies.activities.edit', compact('guides', 'activity', 'company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityRequest $request, Company $company, Activity $activity): RedirectResponse
    {
        $this->authorize('update', $company);

        $filename = $this->uploadImageService->uploadImage($request);

        $activity->update($request->validated() + [
            'photo' => $filename ?? $activity->photo,
        ]);

        return to_route('companies.activities.index', $company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Activity $activity)
    {
        $this->authorize('delete', $company);

        $activity->delete();

        return to_route('companies.activities.index', $company);
    }
}
