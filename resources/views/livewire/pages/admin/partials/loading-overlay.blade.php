{{-- Khdem b wire:loading bach Livewire yt7ekem f l-visibility --}}
<div wire:loading.delay.shortest class="fixed top-0 left-0 right-0 z-[10000] pointer-events-none">
    <div class="h-[3px] w-full bg-blue-100 overflow-hidden">
        {{-- Anmation khfifa (1s) bach t-tsali zreb --}}
        <div class="h-full bg-blue-600 shadow-[0_0_10px_#2563eb] animate-[progress_1s_infinite_linear] origin-left"></div>
    </div>
</div>

<style>
    @keyframes progress {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
</style>