<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gradient-to-tr from-gray-100 to-gray-200 border-b-4 border-b-red-600 shadow-md overflow-hidden sm:rounded-xl">
        {{ $slot }}
    </div>

    <div class="text-xxs mt-3 text-gray-500">&copy; 2021 - {{ Carbon\Carbon::now()->translatedFormat('Y') }} Content Management System by RhiezProject</div>

</div>
