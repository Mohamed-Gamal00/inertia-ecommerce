<?php

namespace App\Observers;

use App\Models\Company;
use Illuminate\Support\Str;

class CompanyObserver
{
    /**
     * Handle the Company "creating" event.
     */
    public function creating(Company $company): void
    {
        // Auto-generate store slug if not provided
        if (empty($company->store_slug) && !empty($company->name)) {
            $slug = Str::slug($company->name);
            $count = 1;
            
            // Ensure uniqueness
            while (Company::where('store_slug', $slug)->exists()) {
                $slug = Str::slug($company->name) . '-' . $count;
                $count++;
            }
            
            $company->store_slug = $slug;
        }
    }

    /**
     * Handle the Company "updating" event.
     */
    public function updating(Company $company): void
    {
        // Ensure store_slug is unique when updating
        if ($company->isDirty('store_slug')) {
            $slug = $company->store_slug;
            $count = 1;
            
            while (Company::where('store_slug', $slug)->where('id', '!=', $company->id)->exists()) {
                $slug = $company->store_slug . '-' . $count;
                $count++;
            }
            
            $company->store_slug = $slug;
        }
    }
}
