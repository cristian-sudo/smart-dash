<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Traits\WithNotifications;

class Companies extends Component
{
    use WithNotifications;
    use WithPagination;

    public $sort = 'desc';
    public $showModal = false;
    public $editingId = null;
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

    public function mount()
    {
        $this->sort = request('sort', 'desc');
    }

    public function toggleSort()
    {
        $this->sort = $this->sort === 'desc' ? 'asc' : 'desc';
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['editingId', 'companyForm']);
        $this->dispatch('open-modal');
    }

    public function editCompany($id = null)
    {
        if ($id) {
            $company = Company::where('user_id', Auth::id())->findOrFail($id);
            $this->companyForm = $company->toArray();
            $this->editingId = $id;
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
            $this->editingId = null;
        }
        $this->showModal = true;
    }

    public function save()
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

        if ($this->editingId) {
            $company = $user->companies()->findOrFail($this->editingId);
            $company->update($this->companyForm);
            $this->showNotification('Company updated successfully');
        } else {
            $user->companies()->create($this->companyForm);
            $this->showNotification('Company created successfully');
        }

        $this->dispatch('close-modal');
        $this->reset(['editingId', 'companyForm']);
    }

    public function delete($id)
    {
        $company = Company::where('user_id', Auth::id())->findOrFail($id);
        $company->delete();
        $this->showNotification('Company deleted successfully');
    }

    public function render()
    {
        $companies = Company::where('user_id', Auth::id())
            ->orderBy('created_at', $this->sort)
            ->paginate(10);

        return view('livewire.companies', [
            'companies' => $companies,
        ]);
    }
} 