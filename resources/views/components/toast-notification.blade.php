 <div class="absolute inset-x-0 bottom-10 z-50 max-w-2xl">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="mx-auto mb-4 max-w-3xl bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>