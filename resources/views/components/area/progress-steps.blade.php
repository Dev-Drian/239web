<div class="mb-10">
    <div class="flex justify-between items-center relative px-20">
        <!-- Línea de progreso base -->
        <div class="absolute left-24 right-24 h-1 top-1/2 -translate-y-1/2 bg-gray-200 z-0"></div>
        
        <!-- Línea de progreso activa -->
        <div id="progress-bar" 
             class="absolute left-24 h-1 top-1/2 -translate-y-1/2 bg-blue-600 z-0 transition-all duration-500 max-w-[calc(100%-12rem)]" 
             style="width: 0">
        </div>
        
        <!-- Paso 1: Perfil de Negocio -->
        <div class="step-indicator relative z-10 flex flex-col items-center group cursor-pointer" data-step="1">
            <div class="w-12 h-12 rounded-full bg-white border-4 border-blue-600 flex items-center justify-center text-blue-600 shadow-md transform transition-all duration-300 group-hover:scale-110">
                <i class="fas fa-building text-xl"></i>
            </div>
            <span class="mt-2 font-medium text-sm text-blue-600">Profile</span>
        </div>
        
        <!-- Paso 2: Áreas de Servicio -->
        <div class="step-indicator relative z-10 flex flex-col items-center group cursor-pointer" data-step="2">
            <div class="w-12 h-12 rounded-full bg-white border-4 border-gray-300 flex items-center justify-center text-gray-400 shadow-md transform transition-all duration-300 group-hover:scale-105">
                <i class="fas fa-map-marked-alt text-xl"></i>
            </div>
            <span class="mt-2 font-medium text-sm text-gray-500">Areas</span>
        </div>
        
        <!-- Paso 3: Flota -->
        <div class="step-indicator relative z-10 flex flex-col items-center group cursor-pointer" data-step="3">
            <div class="w-12 h-12 rounded-full bg-white border-4 border-gray-300 flex items-center justify-center text-gray-400 shadow-md transform transition-all duration-300 group-hover:scale-105">
                <i class="fas fa-car text-xl"></i>
            </div>
            <span class="mt-2 font-medium text-sm text-gray-500">Fleet</span>
        </div>
    </div>
</div>