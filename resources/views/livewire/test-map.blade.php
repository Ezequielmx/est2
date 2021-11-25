<div>
    <label for="ubicacion" class="form-label">Ubicacion:</label>
    <input type="text" class="form-control" placeholder="ubicacion" name="ubicacion" required wire:model="ubicacion">

    <x-jet-danger-button wire:click="render">
        Ver
    </x-jet-secondary-button>
    <iframe
	  width="100%"
	  height="100px"
	  frameborder="0" style="border:0"
      src="https://maps.google.com/maps?q={{ $ubicacion }}&ie=UTF8&output=embed">
	</iframe>
</div>
