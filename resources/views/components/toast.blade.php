@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="fixed top-5 right-5 bg-green-500 text-white py-2 px-4 rounded-xl text-sm">
        <p>{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="fixed top-5 right-5 bg-red-500 text-white py-2 px-4 rounded-xl text-sm">
        <p>{{ session('error') }}</p>
    </div>
@endif
