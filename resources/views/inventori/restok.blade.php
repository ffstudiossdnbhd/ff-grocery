@extends('layouts.app')

@section('title', 'Barangan Perlu Restok')

@section('content')
<style>
    .restok-section-card {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.85), var(--bg-surface));
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.22);
    }

    .restok-section-card .card-header-flex {
        border-color: rgba(255, 255, 255, 0.08);
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
    }

    .restok-section-title {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.15rem;
        line-height: 1.25;
        margin: 0;
    }

    .restok-section-title .restok-status-label {
        font-size: 0.82rem;
        color: var(--text-muted);
        font-weight: 600;
    }

    .restok-section-title-danger { color: var(--color-danger); }
    .restok-section-title-warning { color: var(--color-warning); }

    .restok-table .custom-table th {
        text-transform: uppercase;
        letter-spacing: 0.35px;
    }

    .restok-table .custom-table {
        min-width: 760px;
    }

    .restok-table .custom-table td:nth-child(2),
    .restok-table .custom-table td:nth-child(3),
    .restok-table .custom-table td:nth-child(4),
    .restok-table .custom-table td:nth-child(5),
    .restok-table .custom-table th:nth-child(2),
    .restok-table .custom-table th:nth-child(3),
    .restok-table .custom-table th:nth-child(4),
    .restok-table .custom-table th:nth-child(5) {
        white-space: nowrap;
    }

    .restok-table .custom-table td:last-child,
    .restok-table .custom-table th:last-child {
        text-align: right;
    }

    .restok-table .btn.btn-sm {
        min-height: 36px;
        white-space: nowrap;
    }

    .restok-table .custom-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03);
    }

    .restok-mobile-card {
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        background: var(--bg-surface);
        padding: 1rem;
        gap: 0.7rem;
    }

    .restok-mobile-card .mobile-card-header {
        display: block;
    }

    .restok-mobile-card .item-name-group {
        min-height: auto;
        gap: 0.55rem;
    }

    .restok-mobile-card .item-name-group .item-name {
        line-height: 1.32;
    }

    .restok-mobile-card .item-name-group .badge,
    .restok-mobile-card .item-name-group .kategori-pill {
        align-self: flex-start;
    }

    .restok-mobile-card .item-status {
        min-height: auto;
        font-size: 0.82rem;
        color: var(--text-muted);
        text-align: right;
        font-weight: 600;
    }

    .restok-mobile-card .mobile-card-stats {
        border: none;
        background: transparent;
        padding: 0;
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.25rem;
        align-items: stretch;
    }

    .restok-mobile-card .mobile-card-stats > .stat-box {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: baseline;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .restok-mobile-card .stat-box .stat-label {
        white-space: nowrap;
        line-height: 1.2;
        font-size: 0.66rem;
        letter-spacing: 0.75px;
    }

    .restok-mobile-card .stat-box .stat-val {
        width: auto;
        margin-left: auto;
        justify-content: flex-end;
        text-align: right;
        font-size: 0.84rem;
    }

    .restok-mobile-card .stat-box .stat-val strong {
        font-size: 0.94rem;
    }

    .restok-mobile-card .mobile-card-actions {
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        padding-top: 0.85rem;
        margin-top: 0.1rem;
        justify-content: center;
    }

    .restok-mobile-card .mobile-card-actions .btn {
        width: 100%;
        justify-content: center;
        min-height: 40px;
        border-radius: 12px;
    }

    .restok-mobile-card .unit-label {
        margin-left: 0.2rem;
        white-space: nowrap;
    }

    .restok-bawah-ambang-section .restok-mobile-card .baki-box {
        border-left: none;
        padding-left: 0;
    }

    @media (max-width: 768px) {
        .restok-section-card {
            padding: 1rem;
            margin-bottom: 1.25rem;
        }
    }

    @media (min-width: 769px) and (max-width: 1180px) {
        .restok-table .custom-table {
            min-width: 820px;
        }

        .restok-table .custom-table th,
        .restok-table .custom-table td {
            padding-left: 14px;
            padding-right: 14px;
        }

        .restok-table .btn.btn-sm {
            padding-left: 10px;
            padding-right: 10px;
            font-size: 0.8rem;
        }
    }
</style>
<div class="page-header">
    <div class="page-title">
        <h1>Senarai Perlu Restok</h1>
        <p>Senarai barangan yang telah habis atau di bawah had ambang restok</p>
    </div>
</div>

<!-- Bahagian 1: Habis Stok -->
<div class="card inventori-list-card restok-section-card" style="margin-bottom: 2rem;">
    <div class="card-header-flex">
        <h2 class="restok-section-title restok-section-title-danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span>Habis Stok</span>
            <span class="restok-status-label">{{ $habisStok->count() }} item</span>
        </h2>
    </div>
    
    <div class="table-wrapper desktop-only-view restok-table">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nama/Jenama</th>
                    <th>Kategori</th>
                    <th>Had Ambang</th>
                    <th style="text-align: right;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($habisStok as $item)
                <tr>
                    <td data-label="Nama/Jenama"><strong>{{ $item->nama_item }}</strong></td>
                    <td data-label="Kategori"><x-kategori-pill :kategori="$item->kategoriPreset" /></td>
                    <td data-label="Had Ambang">{{ $item->had_ambang }} unit</td>
                    <td data-label="Tindakan" style="text-align: right;">
                        <a href="{{ route('inventori.edit', $item->id) }}" class="btn btn-secondary btn-sm">
                            <i class="fa-solid fa-plus"></i> Tambah Stok
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Tiada barangan yang kehabisan stok sepenuhnya. Bagus!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- View Mudah Alih / Mobile View -->
    <div class="mobile-only-view">
        @forelse($habisStok as $item)
        <div class="mobile-item-card restok-mobile-card">
            <div class="mobile-card-header">
                <div class="item-name-group">
                    <span class="item-name">{{ $item->nama_item }}</span>
                    <x-kategori-pill :kategori="$item->kategoriPreset" />
                </div>
            </div>
            <div class="mobile-card-stats">
                <div class="stat-box">
                    <span class="stat-label">Baki</span>
                    <span class="stat-val"><strong style="color: var(--color-danger);">0</strong><span class="unit-label">unit</span></span>
                </div>
                <div class="stat-box">
                    <span class="stat-label">Had Ambang</span>
                    <span class="stat-val"><strong>{{ $item->had_ambang }}</strong><span class="unit-label">unit</span></span>
                </div>
            </div>
            <div class="mobile-card-actions">
                <a href="{{ route('inventori.edit', $item->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus"></i> Tambah Stok
                </a>
            </div>
        </div>
        @empty
        <div class="mobile-empty-state">
            Tiada barangan yang kehabisan stok sepenuhnya. Bagus!
        </div>
        @endforelse
    </div>
</div>

<!-- Bahagian 2: Bawah Ambang -->
<div class="card inventori-list-card restok-section-card restok-bawah-ambang-section">
    <div class="card-header-flex">
        <h2 class="restok-section-title restok-section-title-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>Kuantiti Dibawah Had</span>
            <span class="restok-status-label">{{ $bawahAmbang->count() }} item</span>
        </h2>
    </div>
    
    <div class="table-wrapper desktop-only-view restok-table">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nama/Jenama</th>
                    <th>Kategori</th>
                    <th>Baki</th>
                    <th>Had Ambang</th>
                    <th style="text-align: right;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bawahAmbang as $item)
                <tr>
                    <td data-label="Nama/Jenama"><strong>{{ $item->nama_item }}</strong></td>
                    <td data-label="Kategori"><x-kategori-pill :kategori="$item->kategoriPreset" /></td>
                    <td data-label="Baki"><span style="color: var(--color-warning); font-weight: 600;">{{ $item->jumlah_belum_dibuka }}</span> unit</td>
                    <td data-label="Had Ambang">{{ $item->had_ambang }} unit</td>
                    <td data-label="Tindakan" style="text-align: right;">
                        <a href="{{ route('inventori.edit', $item->id) }}" class="btn btn-secondary btn-sm">
                            <i class="fa-solid fa-pen"></i> Kemaskini
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Tiada barangan di bawah had ambang restok.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- View Mudah Alih / Mobile View -->
    <div class="mobile-only-view">
                @forelse($bawahAmbang as $item)
        <div class="mobile-item-card restok-mobile-card">
            <div class="mobile-card-header">
                <div class="item-name-group">
                    <span class="item-name">{{ $item->nama_item }}</span>
                    <x-kategori-pill :kategori="$item->kategoriPreset" />
                </div>
            </div>
            <div class="mobile-card-stats">
                <div class="stat-box">
                    <span class="stat-label">Baki</span>
                    <span class="stat-val"><strong style="color: var(--color-warning);">{{ $item->jumlah_belum_dibuka }}</strong><span class="unit-label">unit</span></span>
                </div>
                <div class="stat-box baki-box">
                    <span class="stat-label">Had Ambang</span>
                    <span class="stat-val"><strong>{{ $item->had_ambang }}</strong><span class="unit-label">unit</span></span>
                </div>
            </div>
            <div class="mobile-card-actions">
                <a href="{{ route('inventori.edit', $item->id) }}" class="btn btn-secondary btn-sm">
                    <i class="fa-solid fa-pen"></i> Kemaskini
                </a>
            </div>
        </div>
        @empty
        <div class="mobile-empty-state">
            Tiada barangan di bawah had ambang restok.
        </div>
        @endforelse
    </div>
</div>
@endsection
