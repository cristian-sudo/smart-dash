<?php

namespace App\Livewire;

use App\Models\Client;
use App\Traits\WithNotifications;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component
{
    use WithPagination;
    use WithNotifications;

    public $show = false;
    public $notificationMessage = '';
    public $clientId = null;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $city = '';
    public $state = '';
    public $zip = '';
    public $country = '';
    public $notes = '';

    public function mount()
    {
        $this->show = false;
    }

    public function render()
    {
        $clients = Client::where('user_id', auth()->id())
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.clients', [
            'clients' => $clients,
        ]);
    }

    public function create()
    {
        $this->reset(['clientId', 'name', 'email', 'phone', 'address', 'city', 'state', 'zip', 'country', 'notes']);
        $this->dispatch('open-modal');
    }

    public function edit(Client $client)
    {
        $this->clientId = $client->id;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->address = $client->address;
        $this->city = $client->city;
        $this->state = $client->state;
        $this->zip = $client->zip;
        $this->country = $client->country;
        $this->notes = $client->notes;
        $this->dispatch('open-modal');
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        if ($this->clientId) {
            $client = Client::find($this->clientId);
            $client->update($validated);
            $this->showNotification('Client updated successfully!');
        } else {
            Client::create($validated);
            $this->showNotification('Client created successfully!');
        }

        $this->dispatch('close-modal');
        $this->reset(['clientId', 'name', 'email', 'phone', 'address', 'city', 'state', 'zip', 'country', 'notes']);
    }

    public function delete(Client $client)
    {
        $client->delete();
        $this->showNotification('Client deleted successfully!');
    }
} 