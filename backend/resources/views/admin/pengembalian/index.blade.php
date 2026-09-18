@extends('layouts.app')

@section('title', 'Kelola Pengembalian - Panel Admin')
@section('header-title', 'Tampilan Pengembalian')

@section('content')

@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
        {{ session('error') }}
    </div>
@endif

<!-- TABEL RIWAYAT PENGEMBALIAN -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-gray-800">Riwayat Pengembalian Alat</h2>

        <div class="flex gap-2">
            <form method="GET" action="{{ route('admin.pengembalian.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari peminjam / kondisi..."
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-56 focus:outline-none focus:ring-2 focus:ring-gray-800">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Peminjam</th>
                    <th class="px-4 py-3">Tgl Kembali</th>
                    <th class="px-4 py-3">Kondisi Alat</th>
                    <th class="px-4 py-3">Denda</th>
                    <th class="px-4 py-3">Petugas Verifikasi</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pengembalians as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $item->peminjaman->user->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                {{ $item->kondisi_kembali }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-semibold text-red-600">
                            Rp {{ number_format($item->denda, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $item->petugas->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('admin.pengembalian.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                            Belum ada data pengembalian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pengembalians->links() }}
    </div>
</div>

<!-- FORM PROSES PENGEMBALIAN BARU -->
<div class="max-w-xl bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Proses Pengembalian Baru</h2>

    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.pengembalian.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Pilih Transaksi Peminjaman (Aktif)</label>
            <select name="peminjaman_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Peminjam & Tanggal Rencana --</option>
                @foreach($peminjamans as $p)
                    <option value="{{ $p->id }}" {{ old('peminjaman_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->user->name }} (Rencana Kembali: {{ $p->tgl_kembali_plan }}) - Status:
                        {{ ucfirst($p->status) }}
                    </option>
                @endforeach
            </select>
            @error('peminjaman_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Pengembalian Aktual</label>
            <input type="date" name="tgl_kembali" value="{{ old('tgl_kembali', date('Y-m-d')) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('tgl_kembali') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Kondisi Alat Saat Kembali</label>
            <input type="text" name="kondisi_kembali" value="{{ old('kondisi_kembali', 'Baik') }}" required
                placeholder="Contoh: Baik / Ada yang lecet / Rusak"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('kondisi_kembali') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Denda Tambahan (Opsional, misal: Alat
                Rusak/Hilang)</label>
            <input type="number" name="denda_tambahan" value="{{ old('denda_tambahan', 0) }}" min="0" placeholder="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-xs text-gray-500 mt-1">*Denda keterlambatan hari akan dihitung otomatis oleh sistem jika
                melewati tanggal rencana kembali.</p>
            @error('denda_tambahan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.pengembalian.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm font-semibold transition">Batal</a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Proses
                Pengembalian</button>
        </div>
    </form>
</div>

@endsection