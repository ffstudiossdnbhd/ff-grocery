@extends('layouts.app')

@section('title', 'Log Aktiviti')

@section('content')
<style>
    @media (min-width: 769px) {
        .log-aktiviti-admin .custom-table td[data-label='Pengguna'] {
            vertical-align: middle;
        }

        .log-aktiviti-user {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            gap: 0.3rem;
            min-width: max-content;
        }

        .log-aktiviti-user-name {
            display: block;
            line-height: 1.15;
        }

        .log-aktiviti-role-pill {
            align-self: flex-start;
            margin-top: 0;
        }
    }
</style>
<div class="page-header">
    <div class="page-title">
        <h1>Log Aktiviti Sistem</h1>
        <p>Jejak dan audit semua tindakan penting oleh pengguna sistem</p>
    </div>
</div>

<div class="card mobile-admin-table log-aktiviti-admin" style="padding: 0;">
    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 180px;">Tarikh & Masa</th>
                    <th style="width: 200px;">Pengguna</th>
                    <th>Aktiviti</th>
                    <th>Perubahan Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td data-label="Tarikh & Masa">
                        <span class="log-aktiviti-date">{{ $log->created_at->format('d/m/Y H:i:s') }}</span>
                    </td>
                    <td data-label="Pengguna">
                        @if($log->user)
                            @php
                                $roleName = $log->user->roles->first()?->name ?? 'Tiada Peranan';
                                $roleBadgeClass = match ($roleName) {
                                    'Stocker' => 'badge-success',
                                    'Tracker' => 'badge-primary',
                                    'Superadmin' => 'badge-danger',
                                    default => 'badge-secondary',
                                };
                            @endphp
                            <div class="log-aktiviti-user">
                                <strong class="log-aktiviti-user-name">{{ $log->user->name }}</strong>
                                <span class="badge {{ $roleBadgeClass }} user-role-pill log-aktiviti-role-pill">{{ $roleName }}</span>
                            </div>
                        @else
                            <span class="log-aktiviti-user-empty">Sistem / Pengguna Dipadam</span>
                        @endif
                    </td>
                    <td data-label="Aktiviti">
                        <span class="log-aktiviti-text">{{ $log->aktiviti }}</span>
                    </td>
                    <td data-label="Perubahan Data">
                        @if($log->data_lama || $log->data_baru)
                            <details class="log-aktiviti-details">
                                <summary class="log-aktiviti-summary">Lihat Butiran Perubahan</summary>
                                <div class="log-aktiviti-details-panel">
                                    @if($log->data_lama)
                                        <div class="log-aktiviti-details-block">
                                            <strong class="log-aktiviti-details-label log-aktiviti-details-label-danger">SEBELUM:</strong>
                                            <pre class="log-aktiviti-details-pre">{{ json_encode($log->data_lama, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    @endif
                                    @if($log->data_baru)
                                        <div class="log-aktiviti-details-block">
                                            <strong class="log-aktiviti-details-label log-aktiviti-details-label-success">SELEPAS:</strong>
                                            <pre class="log-aktiviti-details-pre">{{ json_encode($log->data_baru, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    @endif
                                </div>
                            </details>
                        @else
                            <span class="log-aktiviti-empty">Tiada data perubahan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                        Tiada sebarang log aktiviti direkodkan lagi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="padding: 1.5rem;">
        {{ $logs->links() }}
    </div>
</div>
@endsection
