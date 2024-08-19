<div>
    <p>El contador es {{ $count }}</p>
    <button class="bg-red-500 hover:bg-red-700 font-bold py-2 px-4 rounded" wire:click='decrement'>
        Disminuir -
    </button>
    <button class="bg-green-500 hover:bg-green-700 font-bold py-2 px-4 rounded" wire:click='increment'>
        Aumentar +
    </button>
</div>
