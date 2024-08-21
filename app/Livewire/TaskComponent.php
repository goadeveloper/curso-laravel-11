<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class TaskComponent extends Component
{
    public $tasks = [];
    public $title, $description, $task, $task_id;
    public $modal = false, $update = false;

    public function mount()
    {
        $this->tasks = $this->getTasks();
    }

    private function getTasks()
    {
        return Task::where('user_id', auth()->user()->id)->get();
    }

    public function render()
    {
        return view('livewire.task-component');
    }

    public function renderAllTasks()
    {
        $this->tasks = $this->getTasks();
    }

    private function clearFields()
    {
        $this->title = '';
        $this->description = '';
        $this->update = false;
    }

    public function openCreateModal()
    {
        $this->clearFields();
        $this->modal = true;
    }

    public function closeCreateModal()
    {
        $this->modal = false;
    }

    public function createOrUpdateTask()
    {
        if($this->update)
        {
            $this->task = Task::find($this->task_id);
            $this->task->title = $this->title;
            $this->task->description = $this->description;
        } else {
            $this->task = new Task();
            $this->task->title = $this->title;
            $this->task->description = $this->description;
            $this->task->user_id = auth()->user()->id;
        }
        $this->task->save();
        $this->clearFields();
        $this->closeCreateModal();
        $this->tasks = $this->getTasks();
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
        $this->tasks = $this->getTasks();
    }

    public function updateTask(Task $task)
    {
        $this->title = $task->title;
        $this->description = $task->description;
        $this->task_id = $task->id;
        $this->modal = true;
        $this->update = true;
    }

    public function recoverAllTasks()
    {
        $user = User::find(auth()->user()->id);
        $user->tasks()->restore();
        $this->tasks = $this->getTasks()->sortByDesc('created_at');
    }
}
