<x-app-layout>
    @php
    setlocale(LC_TIME, "spanish");	
    $tema=0;
    $fecha=0;
    @endphp 

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @livewire('evento-detalle', ['evento'=>$evento])
    </div>

</x-app-layout>
