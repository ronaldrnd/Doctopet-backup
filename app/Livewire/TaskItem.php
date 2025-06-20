<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskItem extends Component
{
    public $taskId;
    public $name;
    public $description;
    public $due_date;
    public $priority;
    public $task;

    protected $listeners = ['saveTask','deleteTask']; // Listener pour l'envoi de la question

    public function mount(int $taskId)
    {
        $this->task = Task::findOrFail($taskId);

        if ($this->task->user_id !== Auth::id()) {
            abort(403);
        }

        // Initialisation des propriétés
        $this->taskId = $this->task->id;
        $this->name = $this->task->name;
        $this->description = $this->task->description;
        $this->due_date = $this->task->due_date;
        $this->priority = $this->task->priority;
    }

    #[On('saveTask')]
    public function saveTask()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|in:Urgent,Très prioritaire,Prioritaire',
        ]);

        // Mise à jour de la tâche
        $task = Task::findOrFail($this->taskId);
        $task->update([
            'name' => $this->name,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'priority' => $this->priority,
        ]);

        session()->flash('message', '✅ Tâche mise à jour avec succès.');
    }

    #[On('deleteTask')]
    public function deleteTask()
    {
        $task = Task::findOrFail($this->taskId);
        $task->delete();

        return redirect()->route('task.overview')->with('message', '🗑 Tâche supprimée avec succès.');
    }

    public function render()
    {
        return view('livewire.task-item');
    }
}
