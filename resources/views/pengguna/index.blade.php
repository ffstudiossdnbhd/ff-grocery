@extends('layouts.app')

@section('title', 'Pengurusan Pengguna')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Pengurusan Pengguna</h1>
        <p>Uruskan akaun Stocker dan Tracker yang dibenarkan mengakses sistem</p>
    </div>
    <a href="{{ route('pengguna.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-user-plus"></i>
        <span>Tambah Pengguna</span>
    </a>
</div>

<div class="card mobile-admin-table pengurusan-pengguna-admin" style="padding: 0;">
    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nama Penuh</th>
                    <th>Alamat E-mel</th>
                    <th>Peranan (Role)</th>
                    <th>Tarikh Didaftarkan</th>
                    <th style="text-align: right;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td data-label="Nama Penuh"><strong>{{ $user->name }}</strong></td>
                        <td data-label="Alamat E-mel"><span class="pengguna-email">{{ $user->email }}</span></td>
                    <td data-label="Peranan (Role)">
                        @php
                            $role = $user->roles->first();
                        @endphp
                        @if($role?->name === 'Stocker')
                            <span class="badge badge-success user-role-pill">{{ $role->name }}</span>
                        @elseif($role?->name === 'Tracker')
                            <span class="badge badge-primary user-role-pill">{{ $role->name }}</span>
                        @else
                            <span class="badge badge-secondary user-role-pill">Tiada Peranan</span>
                        @endif
                    </td>
                    <td data-label="Tarikh Didaftarkan">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td data-label="Tindakan">
                        <div class="pengguna-actions" style="display: inline-flex; gap: 8px;">
                            <a href="{{ route('pengguna.edit', $user->id) }}" class="btn btn-secondary btn-sm" title="Edit Pengguna">
                                <i class="fa-solid fa-user-gear"></i>
                            </a>
                            <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Adakah anda pasti mahu memadam akaun ini?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Padam Pengguna" style="background-color: transparent; color: var(--color-danger); border: 1px solid rgba(239, 68, 68, 0.2);">
                                    <i class="fa-solid fa-user-minus"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                        Tiada akaun pengguna dijumpai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="padding: 1.5rem;">
        {{ $users->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailEls = document.querySelectorAll('.pengguna-email');

        const updateEmailSizing = () => {
            emailEls.forEach((el) => {
                el.classList.toggle('pengguna-email--compact', el.scrollWidth > el.clientWidth + 1);
            });
        };

        updateEmailSizing();
        window.addEventListener('resize', updateEmailSizing);
    });
</script>
@endsection
