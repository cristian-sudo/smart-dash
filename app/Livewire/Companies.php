<?php

namespace App\Livewire;

use App\Models\Company;
use App\Traits\WithNotifications;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Companies extends Component
{
    use WithPagination;
    use WithNotifications;
    use WithFileUploads;

    public $show = false;
    public $notificationMessage = '';
    public $companyId = null;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $website = '';
    public $tax_number = '';
    public $registration_number = '';
    public $logo = null;
    public $color = '#3B82F6';
    public $editingId = null;
    public $showModal = false;
    public $is_default = false;
    public $removeLogo = false;

    public function mount()
    {
        $this->show = false;
    }

    public function render()
    {
        $companies = Company::where('user_id', auth()->id())
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.companies', [
            'companies' => $companies,
        ]);
    }

    public function create()
    {
        $this->reset([
            'companyId', 
            'name', 
            'email', 
            'phone', 
            'address', 
            'website',
            'tax_number',
            'registration_number',
            'logo',
            'is_default',
            'removeLogo'
        ]);
        $this->dispatch('open-modal');
    }

    public function edit(Company $company)
    {
        $this->companyId = $company->id;
        $this->name = $company->name;
        $this->email = $company->email;
        $this->phone = $company->phone;
        $this->address = $company->address;
        $this->website = $company->website;
        $this->tax_number = $company->tax_number;
        $this->registration_number = $company->registration_number;
        $this->logo = $company->logo;
        $this->color = $company->color;
        $this->is_default = $company->is_default;
        $this->removeLogo = false;
        $this->dispatch('open-modal');
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'tax_number' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'is_default' => 'boolean',
            'color' => 'required|string|max:7',
        ];

        // Only validate logo as image if it's a new upload
        if ($this->logo instanceof \Illuminate\Http\UploadedFile) {
            $rules['logo'] = 'image|max:1024';
        } else {
            $rules['logo'] = 'nullable';
        }

        $validated = $this->validate($rules);

        $validated['user_id'] = auth()->id();
        $validated['color'] = $this->color;

        if ($this->companyId) {
            $company = Company::find($this->companyId);
            
            // Handle logo
            if ($this->removeLogo) {
                // Remove existing logo
                if ($company->logo && \Storage::disk('public')->exists($company->logo)) {
                    \Storage::disk('public')->delete($company->logo);
                }
                $validated['logo'] = null;
            } elseif ($this->logo instanceof \Illuminate\Http\UploadedFile) {
                // Upload new logo
                if ($company->logo && \Storage::disk('public')->exists($company->logo)) {
                    \Storage::disk('public')->delete($company->logo);
                }
                $path = $this->logo->store('company-logos', 'public');
                $validated['logo'] = $path;
            } else {
                // Keep existing logo
                unset($validated['logo']);
            }
            
            $company->update($validated);
            $this->showNotification('Company updated successfully!');
        } else {
            if ($this->logo) {
                $path = $this->logo->store('company-logos', 'public');
                $validated['logo'] = $path;
            }
            Company::create($validated);
            $this->showNotification('Company created successfully!');
        }

        $this->dispatch('close-modal');
        $this->reset([
            'companyId', 
            'name', 
            'email', 
            'phone', 
            'address', 
            'website',
            'tax_number',
            'registration_number',
            'logo',
            'is_default',
            'removeLogo'
        ]);
    }

    public function delete(Company $company)
    {
        $company->delete();
        $this->showNotification('Company deleted successfully!');
    }

    public function removeLogo()
    {
        if ($this->companyId) {
            $company = Company::find($this->companyId);
            if ($company->logo && \Storage::disk('public')->exists($company->logo)) {
                \Storage::disk('public')->delete($company->logo);
            }
            $company->update(['logo' => null]);
            $this->logo = null;
            $this->showNotification('Logo removed successfully!');
        }
    }
} 