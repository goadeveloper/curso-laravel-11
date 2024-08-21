<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use function Laravel\Prompts\form;


//php artisan make:command DeleteTaskPending

class DeleteTaskPending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deletetask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eliminar todas las tareas pendientes de eliminar de la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Task::where('deleted_at', '!=', null)
            ->where('deleted_at', '<=', now()->subDays(7))
            ->forceDelete();
        $this->info('Tareas de la semana pasada, eliminadas');
    }
}
