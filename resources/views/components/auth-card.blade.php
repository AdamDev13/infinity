<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-10 sm:pb-10 bg-gray-100">
    <div>
        {{ $logo }}
    </div>
    
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
    @if ($bottom ?? false)
    <div class="mt-2">
        {{ $bottom }}
    <div>
    @endif
</div>