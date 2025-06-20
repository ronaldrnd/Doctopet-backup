<div x-data="{ currentMode: '{{ $currentMode }}' }" class="content-wrapper pb-24">
    @if(\Illuminate\Support\Facades\Auth::check())


    <div x-show="currentMode == 'pro'" class="transition-all duration-300">
        <livewire:dashboard-pro />
    </div>

    <div x-show="currentMode == 'client'" class="transition-all duration-300">
        <livewire:dashboard-client />
    </div>

<script>
    Livewire.on('modeSwitched', (newMode) => {
        console.log('Mode switched to:', newMode);
        currentMode = newMode;
        window.location.reload(); // Forces the page to reload
    });
</script>
    @endif
</div>
