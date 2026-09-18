<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Peminjaman</title>

    <!-- Memuat Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen font-sans antialiased">

    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- PANEL KIRI - BRANDING -->
        <div class="hidden md:flex md:w-1/2 relative bg-gradient-to-br from-indigo-600 via-blue-600 to-blue-800 items-center justify-center p-12 overflow-hidden">

            <!-- Dekorasi lingkaran blur -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-32 -right-16 w-96 h-96 bg-indigo-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 text-white max-w-md">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-white/15 backdrop-blur-sm mb-8 ring-1 ring-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h1 class="text-4xl font-bold leading-tight mb-4">Sistem Peminjaman<br>Alat Laboratorium</h1>
                <p class="text-blue-100 text-base leading-relaxed mb-10">
                    Kelola peminjaman, pengembalian, dan inventaris alat laboratorium dalam satu platform terintegrasi.
                </p>

                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-sm text-blue-50">Pantau stok alat secara real-time</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-sm text-blue-50">Perhitungan denda otomatis</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-sm text-blue-50">Riwayat transaksi lengkap & tercatat</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PANEL KANAN - FORM LOGIN -->
        <div class="flex-1 flex items-center justify-center bg-gray-50 p-6 sm:p-12">
            <div class="w-full max-w-sm">

                <!-- Logo mobile (muncul hanya di layar kecil) -->
                <div class="md:hidden flex items-center gap-2 mb-8">
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-bold text-gray-800">Sistem Peminjaman</span>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-1">Selamat datang kembali</h2>
                <p class="text-gray-500 text-sm mb-8">Masukkan kredensial Anda untuk mengakses panel.</p>

                @if($errors->any())
                    <div class="mb-5 flex items-start gap-2 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="nama@email.com"
                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                        </div>
                        <input
                            type="password"
                            name="password"
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    <button type="submit"
                        class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold text-sm py-3 rounded-lg transition shadow-sm">
                        Masuk ke Sistem
                    </button>
                </form>

                <p class="text-center text-gray-400 text-xs mt-10">
                    &copy; {{ date('Y') }} Sistem Peminjaman Alat Laboratorium
                </p>
            </div>
        </div>

    </div>

</body>
</html>