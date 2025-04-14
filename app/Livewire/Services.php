<?php

namespace App\Livewire;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Rule;

class Services extends Component
{
    public $showModal = false;
    public $isEditing = false;
    public $serviceId = null;

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('nullable|string')]
    public $description = '';

    #[Rule('required|numeric|min:0')]
    public $rate = '';

    public function create()
    {
        $this->reset(['name', 'description', 'rate', 'serviceId', 'isEditing']);
        $this->showModal = true;
    }

    public function edit(Service $service)
    {
        $this->serviceId = $service->id;
        $this->name = $service->name;
        $this->description = $service->description;
        $this->rate = $service->rate;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $service = Service::find($this->serviceId);
            $service->update([
                'name' => $this->name,
                'description' => $this->description,
                'rate' => $this->rate,
            ]);
            $this->dispatch('notify', ['message' => 'Service updated successfully.']);
        } else {
            Service::create([
                'user_id' => Auth::id(),
                'name' => $this->name,
                'description' => $this->description,
                'rate' => $this->rate,
            ]);
            $this->dispatch('notify', ['message' => 'Service created successfully.']);
        }

        $this->reset(['showModal', 'name', 'description', 'rate', 'serviceId', 'isEditing']);
    }

    public function delete(Service $service)
    {
        $service->delete();
        $this->dispatch('notify', ['message' => 'Service deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.services', [
            'services' => Service::where('user_id', Auth::id())->get()
        ]);
    }
} 