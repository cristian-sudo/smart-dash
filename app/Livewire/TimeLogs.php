<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\TimeLog;
use Livewire\Component;
use Livewire\WithPagination;

class TimeLogs extends Component
{
    use WithPagination;

    public $date;
    public $service_id;
    public $hours;
    public $location;
    public $notes;
    public $sort = 'desc';
    public $editingId = null;
    public $showModal = false;
    public $showNotification = false;
    public $notificationMessage = '';

    protected $rules = [
        'date' => 'required|date',
        'service_id' => 'required|exists:services,id',
        'hours' => 'required|numeric|min:0.25|max:24',
        'location' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
    ];

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
    }

    public function render()
    {
        $timeLogs = TimeLog::where('user_id', auth()->id())
            ->with('service')
            ->orderBy('date', $this->sort)
            ->paginate(10);

        $services = Service::all();

        return view('livewire.time-logs', [
            'timeLogs' => $timeLogs,
            'services' => $services,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $timeLog = TimeLog::findOrFail($this->editingId);
            $timeLog->update([
                'date' => $this->date,
                'service_id' => $this->service_id,
                'hours' => $this->hours,
                'location' => $this->location,
                'notes' => $this->notes,
            ]);
            $this->showNotification('Time log updated successfully.');
        } else {
            TimeLog::create([
                'user_id' => auth()->id(),
                'date' => $this->date,
                'service_id' => $this->service_id,
                'hours' => $this->hours,
                'location' => $this->location,
                'notes' => $this->notes,
            ]);
            $this->showNotification('Time log created successfully.');
        }

        $this->reset(['date', 'service_id', 'hours', 'location', 'notes', 'editingId', 'showModal']);
    }

    public function edit($id)
    {
        $timeLog = TimeLog::findOrFail($id);
        $this->editingId = $id;
        $this->date = $timeLog->date->format('Y-m-d');
        $this->service_id = $timeLog->service_id;
        $this->hours = $timeLog->hours;
        $this->location = $timeLog->location;
        $this->notes = $timeLog->notes;
        $this->showModal = true;
    }

    public function delete($id)
    {
        $timeLog = TimeLog::findOrFail($id);
        $timeLog->delete();
        $this->showNotification('Time log deleted successfully.');
    }

    public function duplicate($id)
    {
        $timeLog = TimeLog::findOrFail($id);
        $newTimeLog = $timeLog->replicate();
        $newTimeLog->date = now()->format('Y-m-d');
        $newTimeLog->save();
        $this->showNotification('Time log duplicated successfully.');
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
        return $service ? $service->price_per_hour * $this->hours : 0;
    }

    private function showNotification($message)
    {
        $this->notificationMessage = $message;
        $this->showNotification = true;
    }
}
