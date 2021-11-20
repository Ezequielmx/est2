<div>
    <label for="direccion" class="form-label">Direccion:</label>
    <input type="text" class="form-control" placeholder="direccion" name="direccion" required wire:model.defer="direccion">

    <x-jet-danger-button wire:click="render">
        Ver
    </x-jet-secondary-button>
    <iframe
	  width="450"
	  height="250"
	  frameborder="0" style="border:0"
	  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBF4E4xSn_YB3mYUTLP54iHedi4Mng4SDA&q={{ $direccion }}">
	</iframe>
</div>
