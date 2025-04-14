<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\TimeLog;
use App\Traits\WithNotifications;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;

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
    public $showModal = false;
    public $isEditing = false;
    public $timeLogId = null;

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->hours = 0.25;
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
        $this->hours = 0.25;
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

    public function save()
    {
        $this->validate();

        \Log::info('Saving time log with data:', [
            'user_id' => Auth::id(),
            'date' => $this->date,
            'service_id' => $this->service_id,
            'hours' => $this->hours,
            'location' => $this->location,
            'notes' => $this->notes,
        ]);

        try {
            if ($this->isEditing) {
                $timeLog = TimeLog::find($this->timeLogId);
                $timeLog->update([
                    'date' => $this->date,
                    'service_id' => $this->service_id,
                    'hours' => (float) $this->hours,
                    'rate' => Service::find($this->service_id)->rate,
                    'location' => $this->location,
                    'notes' => $this->notes,
                ]);
                $this->showNotification('Time log updated successfully.');
            } else {
                $timeLog = TimeLog::create([
                    'user_id' => Auth::id(),
                    'date' => $this->date,
                    'service_id' => $this->service_id,
                    'hours' => (float) $this->hours,
                    'rate' => Service::find($this->service_id)->rate,
                    'location' => $this->location,
                    'notes' => $this->notes,
                ]);
                $this->showNotification('Time log created successfully.');
            }
        } catch (\Exception $e) {
            \Log::error('Error saving time log: ' . $e->getMessage());
            $this->showNotification('Error saving time log: ' . $e->getMessage(), 'error');
            return;
        }

        $this->reset(['showModal', 'date', 'service_id', 'hours', 'location', 'notes', 'timeLogId', 'isEditing']);
        $this->date = now()->format('Y-m-d');
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
