@extends('layouts.app')

@section('title', 'Persetujuan Peminjaman - Dashboard Petugas')
@section('header-title', 'Daftar Pengajuan Peminjaman Alat')

@section('content')

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800 mb-3">Menunggu Verifikasi Persetujuan</h3>
            <form action="{{ route('petugas.peminjaman.index') }}" method="GET" class="flex w-full md:w-80">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam..."
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-gray-800">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 text-sm font-semibold rounded-r-lg transition">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('petugas.peminjaman.index') }}"
                        class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-700 px-3 py-2 text-sm rounded-lg flex items-center transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="py-3 px-4 border-b">#</th>
                        <th class="py-3 px-4 border-b">Peminjam</th>
                        <th class="py-3 px-4 border-b">Tgl Pinjam</th>
                        <th class="py-3 px-4 border-b">Rencana Kembali</th>
                        <th class="py-3 px-4 border-b">Detail Alat</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        <th class="py-3 px-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($peminjamans as $p)
                        <tr class="hover:bg-gray-50 border-b align-top">
                            <td class="py-3 px-4">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4 font-medium">{{ $p->user->name ?? '-' }}</td>
                            <td class="py-3 px-4">{{ $p->tgl_pinjam }}</td>
                            <td class="py-3 px-4">{{ $p->tgl_kembali_plan }}</td>
                            <td class="py-3 px-4">
                                @foreach($p->detailPinjams as $d)
                                    <span class="block">• {{ $d->alat->nama_alat ?? '-' }} (Jumlah: {{ $d->jumlah }})</span>
                                @endforeach
                            </td>
                            <td class="py-3 px-4">
                                @php $colors = ['diajukan'=>'bg-yellow-100 text-yellow-800','dipinjam'=>'bg-blue-100 text-blue-800','dikembalikan'=>'bg-green-100 text-green-800','telat'=>'bg-red-100 text-red-800']; @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $colors[$p->status] ?? 'bg-gray-100' }}">{{ ucfirst($p->status) }}</span>
                            </td>
                            <td class="py-3 px-4 text-center space-y-1">
                                {{-- Setujui & Tolak --}}
                                @if($p->status === 'diajukan')
                                <div class="flex justify-center items-center space-x-1">
                                    <form action="{{ route('petugas.peminjaman.setujui', $p->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Setujui peminjaman ini?')">
                                        @csrf
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded text-xs font-semibold transition shadow-sm">Setujui</button>
                                    </form>
                                    <form action="{{ route('petugas.peminjaman.tolak', $p->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menolak pengajuan peminjaman ini?')">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs font-semibold transition shadow-sm">Tolak</button>
                                    </form>
                                </div>
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
                        <tr><td colspan="7" class="py-6 text-center text-gray-500">Tidak ada pengajuan peminjaman baru.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection