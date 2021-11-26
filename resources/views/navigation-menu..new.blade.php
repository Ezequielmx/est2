<nav x-data="{ open: false }" class=" border-b border-gray-100" style="background-color: #0f62ac">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-2 pt-2" >
        <div class="nav-men">
            <div style="width: 20%">
                <img src="img/iso_enc.png" alt="" style="height:40px">
            </div>
            <div style="width: 80%">
                <b> Estrella del Plata </b> - Planetario Móvil
            </div>
        </div>
        
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

    </div>
</nav>
