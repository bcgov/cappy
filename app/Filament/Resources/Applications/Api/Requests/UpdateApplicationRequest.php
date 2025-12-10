<?php

namespace App\Filament\Resources\Applications\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'name' => 'required',
			'division' => 'required',
			'business_owner_name' => 'required',
			'business_owner_email' => 'required',
			'technical_contact_name' => 'required',
			'technical_contact_email' => 'required',
			'description' => 'required|string',
			'status' => 'required',
			'hosting_type' => 'required',
			'hosting_details' => 'required',
			'documentation_url' => 'required',
			'repository_url' => 'required',
			'go_live_date' => 'required|date',
			'end_of_life_date' => 'required|date',
			'deleted_at' => 'required',
			'ministry_id' => 'required'
		];
    }
}
