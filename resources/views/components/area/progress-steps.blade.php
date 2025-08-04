<div class="mb-10">
    <div class="flex justify-between items-center relative px-20">
        <!-- Línea de progreso base -->
        <div class="absolute left-24 right-24 h-1 top-1/2 -translate-y-1/2 bg-white/20 z-0 rounded-full"></div>
        
        <!-- Línea de progreso activa -->
        <div id="progress-bar"
             class="absolute left-24 h-1 top-1/2 -translate-y-1/2 bg-gradient-to-r from-blue-500 to-purple-500 z-0 transition-all duration-500 max-w-[calc(100%-12rem)] rounded-full shadow-lg"
             style="width: 0">
        </div>
        
        <!-- Paso 1: Perfil de Negocio -->
        <div class="step-indicator relative z-10 flex flex-col items-center group cursor-pointer" data-step="1">
            <div class="w-12 h-12 rounded-full glass border-4 border-blue-500 flex items-center justify-center text-blue-400 shadow-lg transform transition-all duration-300 group-hover:scale-110 backdrop-blur-xl bg-blue-500/20">
                <i class="fas fa-building text-xl"></i>
            </div>
            <span class="mt-2 font-medium text-sm text-blue-400">Profile</span>
        </div>
        
        <!-- Paso 2: Áreas de Servicio -->
        <div class="step-indicator relative z-10 flex flex-col items-center group cursor-pointer" data-step="2">
            <div class="w-12 h-12 rounded-full glass border-4 border-slate-600 flex items-center justify-center text-slate-500 shadow-lg transform transition-all duration-300 group-hover:scale-105 backdrop-blur-xl bg-slate-600/20">
                <i class="fas fa-map-marked-alt text-xl"></i>
            </div>
            <span class="mt-2 font-medium text-sm text-slate-500">Areas</span>
        </div>
        
        <!-- Paso 3: Flota -->
        <div class="step-indicator relative z-10 flex flex-col items-center group cursor-pointer" data-step="3">
            <div class="w-12 h-12 rounded-full glass border-4 border-slate-600 flex items-center justify-center text-slate-500 shadow-lg transform transition-all duration-300 group-hover:scale-105 backdrop-blur-xl bg-slate-600/20">
                <i class="fas fa-car text-xl"></i>
            </div>
            <span class="mt-2 font-medium text-sm text-slate-500">Fleet</span>
        </div>
    </div>
</div>
