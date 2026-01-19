<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center font-sans">

    <div class="w-full max-w-md px-4">

        @if (session('error'))
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-600 px-4 py-3">
            {{ session('error') }}
        </div>
        @endif

        <div class="rounded-2xl bg-white shadow-xl border border-slate-200 p-8">

            <div class="text-center mb-6">
                <h1 class="text-2xl font-semibold text-slate-800">
                    Admin Login
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Sign in to your dashboard
                </p>
            </div>

            <form action="{{ route('admin.auth') }}" method="post" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-slate-600 mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="w-full rounded-xl bg-white border border-slate-300 px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="admin@example.com">

                    @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-slate-600 mb-1">
                        Password
                    </label>
                    <input
                    
                        @keydown.space.prevent
                        type="password"
                        name="password"
                        class="w-full rounded-xl bg-white border border-slate-300 px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="••••••••">
                    @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-blue-600 py-3 font-medium text-white hover:bg-blue-700 transition">
                    Sign In
                </button>
            </form>

        </div>


    </div>

</body>

</html>