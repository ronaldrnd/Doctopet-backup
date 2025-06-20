<div x-data="{ show: false, message: '', type: '' }"
     x-init="
        @if(session()->has('success'))
            $nextTick(() => showNotification('{{ session('success') }}', 'success'));
        @elseif(session()->has('error'))
            $nextTick(() => showNotification('{{ session('error') }}', 'error'));
        @elseif(session()->has('warning'))
            $nextTick(() => showNotification('{{ session('warning') }}', 'warning'));
        @elseif(session()->has('info'))
            $nextTick(() => showNotification('{{ session('info') }}', 'info'));
        @endif

        Livewire.on('notification', (msg, type) => {
            $nextTick(() => showNotification(msg, type));
        });

        function showNotification(msg, mytype) {

            message = msg;
            type = mytype;
            show = true;

            console.log('🔔 Notification affichée:', msg, 'Type:', mytype); // Vérification console

            setTimeout(() => {
                show = false;
                console.log('🔕 Notification masquée');
            }, 4000);
        }
    "
     class="fixed top-[120px] right-5 z-50 transition-all duration-300"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-[-20px]"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-[-20px]"
     x-cloak>

    <div class="px-6 py-3 rounded-lg shadow-lg text-white flex items-center space-x-3 w-full max-w-xs"
         :class="{
            'bg-green-600': type === 'success',
            'bg-red-600': type === 'error',
            'bg-yellow-500': type === 'warning',
            'bg-blue-500': type === 'info',
            'bg-gray-500': !['success', 'error', 'warning', 'info'].includes(type), // Couleur par défaut si type inconnu
         }">
        <span class="text-2xl" x-bind:class="{
            'text-green-200': type === 'success',
            'text-red-200': type === 'error',
            'text-yellow-200': type === 'warning',
            'text-blue-200': type === 'info',
        }">
            <span x-show="type === 'success'">✅</span>
            <span x-show="type === 'error'">❌</span>
            <span x-show="type === 'warning'">⚠️</span>
            <span x-show="type === 'info'">ℹ️</span>
            <span x-show="!['success', 'error', 'warning', 'info'].includes(type)">🔔</span> <!-- Icône par défaut -->
        </span>
        <span class="flex-1 text-sm font-semibold" x-text="message"></span>
    </div>
</div>
