<div>
    <x-jet-danger-button wire:click="$set('open', true)">
        Abrir Modal
    </x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name='title'>
            TITULO
        </x-slot>
 
        <x-slot name='content'>
            CONTENIDO
        </x-slot>

        <x-slot name='footer'>
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button wire:click="save">
                Reservar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>


