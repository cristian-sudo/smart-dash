<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;

class Services extends Component
{
    use WithPagination;

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|numeric|min:0')]
    public $rate = '';

    #[Rule('nullable|string')]
    public $description = '';

    public $editingId = null;
    public $showModal = false;
    public $notificationMessage = '';
    public $show = false;

    public function mount()
    {
        $this->rate = 0;
    }

    public function create()
    {
        $this->reset(['name', 'rate', 'description', 'editingId']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $service = Service::find($id);
        $this->editingId = $id;
        $this->name = $service->name;
        $this->rate = $service->rate;
        $this->description = $service->description;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'rate', 'description', 'editingId']);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => auth()->id(),
            'name' => $this->name,
            'rate' => $this->rate,
            'description' => $this->description,
        ];

        if ($this->editingId) {
            Service::find($this->editingId)->update($data);
            $this->notificationMessage = 'Service updated successfully.';
        } else {
            Service::create($data);
            $this->notificationMessage = 'Service created successfully.';
        }

        $this->show = true;
        $this->closeModal();
    }

    public function delete($id)
    {
        Service::find($id)->delete();
        $this->notificationMessage = 'Service deleted successfully.';
        $this->show = true;
    }

    public function render()
    {
        $services = Service::where('user_id', Auth::id())
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.services', [
            'services' => $services,
        ]);
    }
} 