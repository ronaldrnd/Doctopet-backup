<?php
namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TasksOverview extends Component
{
    public $tasks, $name, $description, $due_date, $priority;

    public function mount() {
        $this->tasks = Task::where('user_id', Auth::id())->orderBy('is_completed')->orderByDesc('priority')->orderBy('due_date')->get();
    }

    public function addTask() {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|in:Urgent,Très prioritaire,Prioritaire',
        ]);


        Task::create([
            'user_id' => Auth::id(), // Relie la tâche au vétérinaire connecté
            'name' => $this->name,
            'description' => $this->description ?? "",
            'due_date' => $this->due_date,
            'priority' => $this->priority,
        ]);

        $this->reset(['name', 'description', 'due_date', 'priority']);
        $this->mount();
    }

    public function toggleComplete($taskId) {
        $task = Task::where('user_id', Auth::id())->find($taskId);
        if ($task) {
            $task->is_completed = !$task->is_completed;
            $task->save();
            $this->mount();
        }
    }

    public function deleteTask($taskId) {
        Task::where('user_id', Auth::id())->find($taskId)?->delete();
        $this->mount();
    }

    public function render() {
        return view('livewire.tasks-overview');
    }
}
