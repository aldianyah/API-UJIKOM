<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Petugas - Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-56 bg-gray-900 text-white min-h-screen p-4 flex flex-col space-y-2">
        <h2 class="text-lg font-bold px-4 py-2 border-b border-gray-800">Panel Petugas</h2>
        <nav class="flex-1 space-y-1 mt-2">
            <a href="{{ route('petugas.peminjaman.index') }}" class="block px-4 py-2 rounded-lg bg-gray-800 text-white">Kelola Peminjaman</a>
        </nav>
        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white text-sm">Logout</button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Kelola Peminjaman</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="py-3 px-4 border-b">#</th>
                            <th class="py-3 px-4 border-b">Peminjam</th>
                            <th class="py-3 px-4 border-b">Tgl Pinjam</th>
                            <th class="py-3 px-4 border-b">Tgl Kembali Plan</th>
                            <th class="py-3 px-4 border-b">Alat</th>
                            <th class="py-3 px-4 border-b">Status</th>
                            <th class="py-3 px-4 border-b text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($peminjamans as $p)
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 font-medium">{{ $p->user->name ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $p->tgl_pinjam }}</td>
                                <td class="py-3 px-4">{{ $p->tgl_kembali_plan }}</td>
                                <td class="py-3 px-4">
                                    @foreach($p->detailPinjam as $d)
                                        <span class="block">{{ $d->alat->nama_alat ?? '-' }} ({{ $d->jumlah }})</span>
                                    @endforeach
                                </td>
                                <td class="py-3 px-4">
                                    @php $colors = ['diajukan'=>'bg-yellow-100 text-yellow-800','dipinjam'=>'bg-blue-100 text-blue-800','dikembalikan'=>'bg-green-100 text-green-800','telat'=>'bg-red-100 text-red-800']; @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $colors[$p->status] ?? 'bg-gray-100' }}">{{ ucfirst($p->status) }}</span>
                                </td>
                                <td class="py-3 px-4 text-center space-y-1">
                                    {{-- Setujui --}}
                                    @if($p->status === 'diajukan')
                                    <form action="{{ route('petugas.peminjaman.setujui', $p->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Setujui peminjaman ini?')">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">Setujui</button>
                                    </form>
                                    @endif

                                    {{-- Form Pengembalian --}}
                                    @if($p->status === 'dipinjam' || $p->status === 'telat')
                                    <details class="inline-block text-left">
                                        <summary class="cursor-pointer bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600 list-none">Kembalikan</summary>
                                        <div class="absolute z-10 bg-white border border-gray-200 rounded-lg shadow-lg p-4 mt-1 w-64">
                                            <form action="{{ route('petugas.pengembalian.proses', $p->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-2">
                                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Kondisi Kembali</label>
                                                    <input type="text" name="kondisi_kembali" required placeholder="Baik / Rusak / dll"
                                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Denda (Rp)</label>
                                                    <input type="number" name="denda" min="0" value="0"
                                                        class="w-full border border-gray-300 rounded px-2 py-1 text-xs">
                                                </div>
                                                <button type="submit" class="w-full bg-green-600 text-white py-1 rounded text-xs hover:bg-green-700">Proses Pengembalian</button>
                                            </form>
                                        </div>
                                    </details>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-4 text-center text-gray-500">Belum ada data peminjaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>