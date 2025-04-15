<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\TimeLog;
use App\Traits\WithNotifications;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use App\Models\Location;

class TimeLogs extends Component
{
    use WithPagination;
    use WithNotifications;

    #[Rule('required|date')]
    public $date = '';

    #[Rule('required|exists:services,id')]
    public $service_id = '';

    #[Rule('required|numeric|min:0.25|max:24')]
    public $hours = '';

    #[Rule('nullable|string|max:255')]
    public $location = '';

    #[Rule('nullable|string')]
    public $notes = '';

    public $sort = 'desc';
    public $isEditing = false;
    public $timeLogId = null;
    public $selectedLocation = '';
    public $savedLocations = [];
    public $showModal = false;

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->hours = 8;
        $this->loadSavedLocations();
    }

    public function loadSavedLocations()
    {
        $this->savedLocations = Location::where('user_id', auth()->id())->get();
    }

    public function updatedSelectedLocation($value)
    {
        if ($value) {
            $this->location = $value;
        }
    }

    public function render()
    {
        $timeLogs = TimeLog::where('user_id', auth()->id())
            ->with('service')
            ->orderBy('date', $this->sort)
            ->paginate(10);

        $services = Service::where('user_id', auth()->id())->get();
        $selectedServiceRate = $this->service_id ? Service::find($this->service_id)->rate : 0;

        return view('livewire.time-logs', [
            'timeLogs' => $timeLogs,
            'services' => $services,
            'selectedServiceRate' => $selectedServiceRate,
        ]);
    }

    public function create()
    {
        $this->reset(['date', 'service_id', 'hours', 'location', 'notes', 'timeLogId', 'isEditing']);
        $this->date = now()->format('Y-m-d');
        $this->hours = 8;
        $this->showModal = true;
    }

    public function edit(TimeLog $timeLog)
    {
        $this->timeLogId = $timeLog->id;
        $this->date = $timeLog->date->format('Y-m-d');
        $this->service_id = $timeLog->service_id;
        $this->hours = $timeLog->hours;
        $this->location = $timeLog->location;
        $this->notes = $timeLog->notes;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $this->validate();

        // Get the service rate
        $service = Service::find($this->service_id);
        if (!$service) {
            $this->addError('service_id', 'Selected service not found');
            return;
        }

        // Save the time log
        $timeLog = TimeLog::updateOrCreate(
            ['id' => $this->timeLogId],
            [
                'user_id' => auth()->id(),
                'date' => $this->date,
                'service_id' => $this->service_id,
                'hours' => $this->hours,
                'rate' => $service->rate,
                'location' => $this->location,
                'notes' => $this->notes,
            ]
        );

        // Save the location if it's new
        if ($this->location && !$this->savedLocations->contains('name', $this->location)) {
            Location::create([
                'user_id' => auth()->id(),
                'name' => $this->location,
            ]);
            $this->loadSavedLocations();
        }

        // Reset only the necessary properties
        $this->reset(['date', 'service_id', 'hours', 'location', 'notes', 'timeLogId', 'isEditing', 'selectedLocation', 'showModal']);
        $this->date = now()->format('Y-m-d');
        $this->hours = 8;
        $this->showNotification('Time log saved successfully!');
    }

    public function delete(TimeLog $timeLog)
    {
        $timeLog->delete();
        $this->showNotification('Time log deleted successfully.');
    }

    public function duplicate($id)
    {
        try {
            $timeLog = TimeLog::findOrFail($id);
            $newTimeLog = $timeLog->replicate();
            $newTimeLog->date = now()->format('Y-m-d');
            $newTimeLog->save();
            $this->showNotification('Time log duplicated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error duplicating time log: ' . $e->getMessage());
            $this->showNotification('Error duplicating time log: ' . $e->getMessage(), 'error');
        }
    }

    public function toggleSort()
    {
        $this->sort = $this->sort === 'desc' ? 'asc' : 'desc';
    }

    public function calculateTotal()
    {
        if (!$this->service_id || !$this->hours) {
            return 0;
        }

        $service = Service::find($this->service_id);
        return $service ? $service->rate * $this->hours : 0;
    }
}
