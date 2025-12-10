<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    /**
     * List all applications.
     */
    public function index()
    {
        return response()->json(Application::with('ministry')->get());
    }

    /**
     * Show a single application.
     */
    public function show(Application $application)
    {
        return response()->json($application->load('ministry'));
    }

    /**
     * Create a new application.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'ministry_id' => 'required|exists:ministries,id',
            'division' => 'nullable|string|max:255',
            'business_owner_name' => 'nullable|string|max:255',
            'business_owner_email' => 'nullable|email|max:255',
            'technical_contact_name' => 'nullable|string|max:255',
            'technical_contact_email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(array_keys(Application::getStatusOptions()))],
            'hosting_type' => ['nullable', Rule::in(array_keys(Application::getHostingTypeOptions()))],
            'hosting_details' => 'nullable|string',
            'documentation_url' => 'nullable|url',
            'repository_url' => 'nullable|url',
            'go_live_date' => 'nullable|date',
            'end_of_life_date' => 'nullable|date',
        ]);

        $application = Application::create($data);

        return response()->json($application, 201);
    }

    /**
     * Update an existing application.
     */
    public function update(Request $request, Application $application)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'ministry_id' => 'sometimes|required|exists:ministries,id',
            'division' => 'nullable|string|max:255',
            'business_owner_name' => 'nullable|string|max:255',
            'business_owner_email' => 'nullable|email|max:255',
            'technical_contact_name' => 'nullable|string|max:255',
            'technical_contact_email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'status' => ['sometimes', 'required', Rule::in(array_keys(Application::getStatusOptions()))],
            'hosting_type' => ['nullable', Rule::in(array_keys(Application::getHostingTypeOptions()))],
            'hosting_details' => 'nullable|string',
            'documentation_url' => 'nullable|url',
            'repository_url' => 'nullable|url',
            'go_live_date' => 'nullable|date',
            'end_of_life_date' => 'nullable|date',
        ]);

        $application->update($data);

        return response()->json($application);
    }

    /**
     * Delete an application (soft delete).
     */
    public function destroy(Application $application)
    {
        $application->delete();

        return response()->json(null, 204);
    }
}
