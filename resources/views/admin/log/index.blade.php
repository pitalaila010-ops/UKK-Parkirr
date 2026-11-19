@extends('layouts.app') 

@section('content') 
<div class="container-fluid">
    <h3 class="mb-3">Log Aktivitas</h3> 
    
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0 align-middle"> 
                <thead> 
                    <tr>
                        <th width="5%">#</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                    </tr> 
                </thead> 
                <tbody> 
                    @forelse($logs as $i => $log) 
                    <tr> 
                        <td>{{ method_exists($logs, 'firstItem') ? $logs->firstItem() + $i : $i + 1 }}</td> 
                        <td><strong>{{ $log->user->name ?? $log->user->nama_lengkap ?? '-' }}</strong></td> 
                        <td>{{ $log->aktivitas }}</td> 
                        <td>{{ \Carbon\Carbon::parse($log->waktu_aktivitas)->format('d-m-Y H:i') }}</td> 
                    </tr> 
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada log aktivitas.</td>
                    </tr>
                    @endforelse 
                </tbody> 
            </table> 
        </div>
    </div>

    <div class="mt-3">
        {{ $logs->links() }} 
    </div>
</div>
@endsection