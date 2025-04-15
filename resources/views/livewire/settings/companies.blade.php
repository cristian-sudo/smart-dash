<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $companies = [];
    public $editingCompany = null;
    public $companyForm = [
        'name' => '',
        'address' => '',
        'phone' => '',
        'email' => '',
        'website' => '',
        'tax_number' => '',
        'registration_number' => '',
        'logo' => null,
        'is_default' => false,
    ];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->loadCompanies();
    }

    /**
     * Load the user's companies.
     */
    public function loadCompanies(): void
    {
        $this->companies = Auth::user()->companies()->get();
    }

    /**
     * Start editing a company.
     */
    public function editCompany($id = null): void
    {
        if ($id) {
            $company = Auth::user()->companies()->findOrFail($id);
            $this->companyForm = $company->toArray();
            $this->editingCompany = $id;
        } else {
            $this->companyForm = [
                'name' => '',
                'address' => '',
                'phone' => '',
                'email' => '',
                'website' => '',
                'tax_number' => '',
                'registration_number' => '',
                'logo' => null,
                'is_default' => false,
            ];
            $this->editingCompany = null;
        }
    }

    /**
     * Save a company.
     */
    public function saveCompany(): void
    {
        $validated = $this->validate([
            'companyForm.name' => ['required', 'string', 'max:255'],
            'companyForm.address' => ['nullable', 'string'],
            'companyForm.phone' => ['nullable', 'string', 'max:255'],
            'companyForm.email' => ['nullable', 'email', 'max:255'],
            'companyForm.website' => ['nullable', 'url', 'max:255'],
            'companyForm.tax_number' => ['nullable', 'string', 'max:255'],
            'companyForm.registration_number' => ['nullable', 'string', 'max:255'],
            'companyForm.logo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,gif'],
            'companyForm.is_default' => ['boolean'],
        ]);

        $user = Auth::user();

        if ($this->companyForm['is_default']) {
            $user->companies()->update(['is_default' => false]);
        }

        if ($this->editingCompany) {
            $company = $user->companies()->findOrFail($this->editingCompany);
            
            if ($this->companyForm['logo']) {
                if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                    Storage::disk('public')->delete($company->logo);
                }
                $path = $this->companyForm['logo']->store('logos', 'public');
                $this->companyForm['logo'] = $path;
            } else {
                unset($this->companyForm['logo']);
            }

            $company->update($this->companyForm);
        } else {
            if ($this->companyForm['logo']) {
                $path = $this->companyForm['logo']->store('logos', 'public');
                $this->companyForm['logo'] = $path;
            }

            $user->companies()->create($this->companyForm);
        }

        $this->loadCompanies();
        $this->editCompany();
    }

    /**
     * Delete a company.
     */
    public function deleteCompany($id): void
    {
        $company = Auth::user()->companies()->findOrFail($id);
        
        if ($company->logo && Storage::disk('public')->exists($company->logo)) {
            Storage::disk('public')->delete($company->logo);
        }
        
        $company->delete();
        $this->loadCompanies();
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Companies')" :subheading="__('Manage your company information')">
        <div class="p-4 sm:p-8 bg-gray-50 dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <div class="mt-6">
                    <button wire:click="editCompany" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add New Company
                    </button>
                </div>

                <div class="mt-6 space-y-6">
                    @foreach($companies as $company)
                        <div class="p-4 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $company->name }}</h3>
                                    @if($company->is_default)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100">
                                            Default
                                        </span>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <button wire:click="editCompany({{ $company->id }})" class="p-1 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-900">
                                        <x-icons.edit class="w-5 h-5" />
                                    </button>
                                    <button wire:click="deleteCompany({{ $company->id }})" class="p-1 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 rounded-full hover:bg-red-50 dark:hover:bg-red-900">
                                        <x-icons.trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($editingCompany !== null)
                    <div class="mt-6">
                        <form wire:submit="saveCompany" class="space-y-6">
                            <div>
                                <flux:label for="company_name" :value="__('Company Name')" />
                                <flux:input id="company_name" wire:model="companyForm.name" type="text" required />
                            </div>

                            <div>
                                <flux:label for="company_address" :value="__('Address')" />
                                <flux:input id="company_address" wire:model="companyForm.address" type="text" />
                            </div>

                            <div>
                                <flux:label for="company_phone" :value="__('Phone')" />
                                <flux:input id="company_phone" wire:model="companyForm.phone" type="text" />
                            </div>

                            <div>
                                <flux:label for="company_email" :value="__('Email')" />
                                <flux:input id="company_email" wire:model="companyForm.email" type="email" />
                            </div>

                            <div>
                                <flux:label for="company_website" :value="__('Website')" />
                                <flux:input id="company_website" wire:model="companyForm.website" type="url" />
                            </div>

                            <div>
                                <flux:label for="company_tax_number" :value="__('Tax Number')" />
                                <flux:input id="company_tax_number" wire:model="companyForm.tax_number" type="text" />
                            </div>

                            <div>
                                <flux:label for="company_registration_number" :value="__('Registration Number')" />
                                <flux:input id="company_registration_number" wire:model="companyForm.registration_number" type="text" />
                            </div>

                            <div>
                                <flux:label for="company_logo" :value="__('Company Logo')" />
                                @if($companyForm['logo'] && !is_string($companyForm['logo']))
                                    <div class="mt-2">
                                        <img src="{{ $companyForm['logo']->temporaryUrl() }}" alt="Company Logo" class="h-20 w-auto">
                                    </div>
                                @elseif(isset($companyForm['logo']) && is_string($companyForm['logo']))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $companyForm['logo']) }}" alt="Company Logo" class="h-20 w-auto">
                                    </div>
                                @endif
                                <input type="file" id="company_logo" name="company_logo" class="mt-1 block w-full text-sm
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-gray-100 file:text-gray-700
                                    hover:file:bg-gray-200
                                    dark:file:bg-gray-700 dark:file:text-gray-200
                                    dark:hover:file:bg-gray-600
                                    text-gray-900 dark:text-gray-100"
                                    wire:model="companyForm.logo"
                                    accept="image/*" />
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="companyForm.is_default" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Set as default company</span>
                                </label>
                            </div>

                            <div class="flex items-center gap-4">
                                <flux:button variant="primary" type="submit" class="w-full">{{ __('Save Company') }}</flux:button>
                                <flux:button variant="secondary" wire:click="editCompany" class="w-full">{{ __('Cancel') }}</flux:button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </x-settings.layout>
</section>