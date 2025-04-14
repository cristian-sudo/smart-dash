<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $logo;
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
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
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

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Delete the user's logo.
     */
    public function deleteLogo(): void
    {
        $user = Auth::user();
        
        if ($user->logo && Storage::disk('public')->exists($user->logo)) {
            Storage::disk('public')->delete($user->logo);
            $user->logo = null;
            $user->save();
        }
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your profile information')">
        <div class="p-4 sm:p-8 bg-gray-50 dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Profile Information</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update your account's profile information.</p>
                    </header>

                    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />
                        </div>

                        <div>
                            <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="username" />
                        </div>

                        <div class="flex items-center gap-4">
                            <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                        </div>
                    </form>
                </section>
            </div>
        </div>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
