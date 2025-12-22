<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
         'id' => $this->id,
         'name' => $this->name,
         'description' => $this->description,
         'average_daily_users' => $this->average_daily_users,
         'annual_cost' => $this->annual_cost,
         'cost_function' => $this->cost_function,
         'cost_per_unit' => $this->cost_per_unit,
         'license_summary' => $this->license_summary,
         'annual_vendor_cost' => $this->annual_vendor_cost,
         'initial_deployment' => $this->initial_deployment,
         'end_of_support' => $this->end_of_support,
         'end_of_life' => $this->end_of_life,
         'disposition_deadline' => $this->disposition_deadline,
         'disposition_decision' => $this->disposition_decision,
         'dependencies' => ApplicationResource::collection($this->whenLoaded('dependencies')),
         'integrations' => ApplicationResource::collection($this->whenLoaded('integrations')),
         'components' => ApplicationResource::collection($this->whenLoaded('components')),
         'application_users' => ApplicationUserTypeResource::collection($this->whenLoaded('application_users')),
         'application_versions' => ApplicationVersionResource::collection($this->whenLoaded('application_versions')),
         'staffing' => STOB50Resource::collection($this->whenLoaded('staffing')),
         'subject_matter_experts' => SubjectMatterExpertResource::collection($this->whenLoaded('subject_matter_experts')),
         'business_areas' => BusinessAreaResource::collection($this->whenLoaded('business_areas')),
         'documentation' => DocumentationResource::collection($this->whenLoaded('documentation')),
         'vendor_support' => STOB60Resource::collection($this->whenLoaded('vendor_support')),
         'vendors' => VendorResource::collection($this->whenLoaded('vendors')),
 
       ];
    }
}
