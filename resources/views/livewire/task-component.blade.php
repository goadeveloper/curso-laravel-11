<div class="w-full overflow-x-auto">
    <div class="flex py-2 justify-between">
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" wire:click='openCreateModal'>
            Nueva Tarea
        </button>
        <button class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700" wire:click='recoverAllTasks' wire:confirm='¿Desea recuperar todas las tareas eliminadas?'>
            Recuperar Tareas Borradas
        </button>
    </div>
    <table wire:poll='renderAllTasks' class="w-full text-left border border-collapse rounded sm:border-separate border-slate-200" cellspacing="0">
      <tbody>
        <tr>
          <th scope="col" class="h-12 px-6 text-sm font-medium border-l first:border-l-0 stroke-slate-700 text-slate-700 bg-slate-100">Título</th>
          <th scope="col" class="h-12 px-6 text-sm font-medium border-l first:border-l-0 stroke-slate-700 text-slate-700 bg-slate-100">Descripción</th>
          <th scope="col" class="h-12 px-6 text-sm font-medium border-l first:border-l-0 stroke-slate-700 text-slate-700 bg-slate-100">Acciones</th>
        </tr>
        @foreach ($tasks as $task)
            <tr>
                <td class="h-12 px-6 text-sm transition duration-300 border-t border-l first:border-l-0 border-slate-200 stroke-slate-500 text-slate-500 ">
                    {{ $task->title }}
                </td>
                <td class="h-12 px-6 text-sm transition duration-300 border-t border-l first:border-l-0 border-slate-200 stroke-slate-500 text-slate-500 ">
                    {{ $task->description }}
                </td>
                <td class="h-12 px-6 text-sm transition duration-300 border-t border-l first:border-l-0 border-slate-200 stroke-slate-500 text-slate-500 ">
                    <button wire:click='updateTask({{ $task }})' class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-400">
                        Editar
                    </button>
                    <button wire:click='deleteTask({{ $task }})' wire:confirm='¿Desea eliminar esta tarea?' class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-400">
                        Eliminar
                    </button>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
    
    @if ($modal)    
        <div class="fixed top-0 left-0 z-20 flex items-center justify-center w-screen h-screen bg-slate-300/20 backdrop-blur-sm" aria-labelledby="header-1a content-1a" aria-modal="true" tabindex="-1" role="dialog">
            <!-- Modal -->
            <div class="flex max-h-[90vh] w-11/12 max-w-2xl flex-col gap-6 overflow-hidden rounded bg-white p-6 text-slate-500 shadow-xl shadow-slate-700/10" id="modal" role="document">
                <!-- Modal header -->
                <header id="header-1a" class="flex items-center gap-4">
                    <h3 class="flex-1 text-xl font-medium text-slate-700">
                        Crear/Editar Tareas
                    </h3>
                </header>
                <!-- Modal body -->
                <div id="content-1a" class="flex-1 overflow-auto">
                    <form>
                        @csrf
                        <div class="relative my-6">
                            <input wire:model='title' type="text" name="title" placeholder="Título" class="relative w-full h-10 px-4 text-sm placeholder-transparent transition-all border-b outline-none focus-visible:outline-none peer border-slate-200 text-slate-500 autofill:bg-white invalid:border-pink-500 invalid:text-pink-500 focus:border-emerald-500 focus:outline-none invalid:focus:border-pink-500 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-400" />
                            <label for="title" class="cursor-text peer-focus:cursor-default peer-autofill:-top-2 absolute left-2 -top-2 z-[1] px-2 text-xs text-slate-400 transition-all before:absolute before:top-0 before:left-0 before:z-[-1] before:block before:h-full before:w-full before:bg-white before:transition-all peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-sm peer-required:after:text-pink-500 peer-required:after:content-['\00a0*'] peer-invalid:text-pink-500 peer-focus:-top-2 peer-focus:text-xs peer-focus:text-emerald-500 peer-invalid:peer-focus:text-pink-500 peer-disabled:cursor-not-allowed peer-disabled:text-slate-400 peer-disabled:before:bg-transparent">
                                Título
                            </label>
                        </div>

                        <div class="relative">
                            <textarea wire:model='description' type="text" name="description" rows="3" placeholder="Descripción" class="relative w-full px-4 py-2 text-sm placeholder-transparent transition-all border-b outline-none focus-visible:outline-none peer border-slate-200 text-slate-500 autofill:bg-white invalid:border-pink-500 invalid:text-pink-500 focus:border-emerald-500 focus:outline-none invalid:focus:border-pink-500 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-400"></textarea>
                            <label for="description" class="cursor-text peer-focus:cursor-default absolute left-2 -top-2 z-[1] px-2 text-xs text-slate-400 transition-all before:absolute before:top-0 before:left-0 before:z-[-1] before:block before:h-full before:w-full before:bg-white before:transition-all peer-placeholder-shown:top-2.5 peer-placeholder-shown:text-sm peer-required:after:text-pink-500 peer-required:after:content-['\00a0*'] peer-invalid:text-pink-500 peer-focus:-top-2 peer-focus:text-xs peer-focus:text-emerald-500 peer-invalid:peer-focus:text-pink-500 peer-disabled:cursor-not-allowed peer-disabled:text-slate-400 peer-disabled:before:bg-transparent">
                                Descripción
                            </label>
                        </div>
                        
                    </form>
                </div>
                <!-- Modal actions -->
                <div class="flex justify-start gap-2">
                    <button wire:click.prevent='createOrUpdateTask' class="inline-flex items-center justify-center h-10 gap-2 px-5 text-sm font-medium tracking-wide text-white transition duration-300 rounded whitespace-nowrap bg-emerald-500 hover:bg-emerald-600 focus:bg-emerald-700 focus-visible:outline-none disabled:cursor-not-allowed disabled:border-emerald-300 disabled:bg-emerald-300 disabled:shadow-none">
                        <span>
                            @if ($update)
                                Editar Tarea
                            @else
                                Crear Tarea
                            @endif
                        </span>
                    </button>
                    <button class="inline-flex items-center justify-center h-10 gap-2 px-5 text-sm font-medium tracking-wide transition duration-300 rounded justify-self-center whitespace-nowrap text-emerald-500 hover:bg-emerald-100 hover:text-emerald-600 focus:bg-emerald-200 focus:text-emerald-700 focus-visible:outline-none disabled:cursor-not-allowed disabled:text-emerald-300 disabled:shadow-none disabled:hover:bg-transparent" wire:click='closeCreateModal'>
                        <span>Cancelar</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
  </div>
