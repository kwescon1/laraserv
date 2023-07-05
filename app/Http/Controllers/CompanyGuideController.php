<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuideRequest;
use App\Http\Requests\UpdateGuideRequest;
use App\Mail\RegistrationInvite;
use App\Models\Company;
use App\Models\Enums\RoleEnum;
use App\Models\User;
use App\Models\UserInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CompanyGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company): View
    {
        $this->authorize('viewAny', $company);

        $guides = $company->users()->where('role_id', RoleEnum::GUIDE)->get();

        return view('companies.guides.index', compact('company', 'guides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Company $company): View
    {
        $this->authorize('create', $company);

        return view('companies.guides.create', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuideRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('create', $company);

        $data = $request->validated();

        $invitation = UserInvitation::create([
            'email' => $request->input('email'),
            'token' => Str::uuid(),
            'company_id' => $company->id,
            'role_id' => RoleEnum::GUIDE,
        ]);

        Mail::to($request->input('email'))->send(new RegistrationInvite($invitation));

        return to_route('companies.guides.index', $company);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company, User $guide): View
    {
        $this->authorize('update', $company);

        return view('companies.guides.edit', compact('company', 'guide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuideRequest $request, Company $company, User $guide): RedirectResponse
    {
        $this->authorize('update', $company);

        $guide->update($request->validated());

        return to_route('companies.guides.index', $company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, User $guide): RedirectResponse
    {
        $this->authorize('delete', $company);

        $guide->delete();

        return to_route('companies.guides.index', $company);
    }
}
