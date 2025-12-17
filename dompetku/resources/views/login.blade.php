<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DompetKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-indigo-600">Dompet<span class="text-slate-800">Ku</span></h1>
                    <p class="text-slate-500 mt-2">Silakan login untuk mengelola keuangan</p>
                </div>

                {{-- Alert jika login gagal --}}
                @if (session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                                placeholder="admin@dompetku.com">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                                placeholder="••••••••">
                        </div>

                        <button type="submit" 
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-indigo-200">
                            Masuk Sekarang
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-slate-500 italic">Default login: admin@dompetku.com / admin</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>