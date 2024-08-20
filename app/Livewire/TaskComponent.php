<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class TaskComponent extends Component
{
    public $tasks = [];
    public $title, $description, $task_id;
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
            $task = Task::find($this->task_id);
            $task->title = $this->title;
            $task->description = $this->description;
            $task->save();
        } else {
            $newTask = new Task();
            $newTask->title = $this->title;
            $newTask->description = $this->description;
            $newTask->user_id = auth()->user()->id;
            $newTask->save();
        }
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
}
