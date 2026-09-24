@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Peminjaman')
@section('header-title', 'Ringkasan Aktivitas Sistem')

@section('content')

    <!-- Alert Selamat Datang -->
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm">
        Selamat datang,
        <strong class="font-semibold">{{ auth()->user()->name }}</strong>.
        Anda login sebagai hak akses
        <span class="uppercase font-bold text-emerald-900">{{ auth()->user()->role }}</span>.
    </div>

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <i class="fa-solid fa-screwdriver-wrench text-blue-500 text-lg"></i>
            <div class="text-xl font-semibold text-gray-900 mt-2">{{ $totalAlat }}</div>
            <div class="text-xs text-gray-500">Total Alat</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <i class="fa-solid fa-clock text-amber-500 text-lg"></i>
            <div class="text-xl font-semibold text-gray-900 mt-2">{{ $sedangDipinjam }}</div>
            <div class="text-xs text-gray-500">Sedang Dipinjam</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <i class="fa-solid fa-hourglass-half text-red-500 text-lg"></i>
            <div class="text-xl font-semibold text-gray-900 mt-2">{{ $perluPersetujuan }}</div>
            <div class="text-xs text-gray-500">Perlu Persetujuan</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <i class="fa-solid fa-users text-emerald-500 text-lg"></i>
            <div class="text-xl font-semibold text-gray-900 mt-2">{{ $totalUser }}</div>
            <div class="text-xs text-gray-500">Total User</div>
        </div>
    </div>

    <!-- Log Aktivitas -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">

        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">
                Log Aktivitas Terbaru
            </h3>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($logs as $log)
                <div class="flex items-baseline gap-3 px-6 py-3 text-sm hover:bg-gray-50 transition">
                    <span class="text-gray-400 text-xs w-28 shrink-0">{{ $log->created_at }}</span>
                    <span class="font-medium text-gray-900 w-36 shrink-0">{{ $log->user->name ?? 'Sistem' }}</span>
                    <span class="text-gray-600">{{ $log->aktivitas }}</span>
                </div>
            @empty
                <div class="px-6 py-6 text-center text-gray-500 text-sm">
                    Belum ada log aktivitas.
                </div>
            @endforelse
        </div>

    </div>

@endsection