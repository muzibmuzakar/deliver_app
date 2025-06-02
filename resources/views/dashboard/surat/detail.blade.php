@extends('dashboard.layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">{{ $surat->no_resi }}</h5>
                </div>
                <form action="{{ route('surat.update', $surat->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="kepada" class="form-label">Kepada</label>
                        <p>{{ $surat->kepada }}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="alamat" class="form-label">Alamat</label>
                        <p class="mb-0 fw-normal">{{ $surat->alamat }}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="kurir" class="form-label">Kurir</label>
                        <p class="mb-0 fw-normal">{{ $surat->kurir->name ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="seksi" class="form-label">Seksi</label>
                        <p class="mb-0 fw-normal">{{ $surat->seksi->nama ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label><br>
                        @php
                            $badgeClass = match ($surat->status) {
                                0 => 'bg-info',
                                1 => 'bg-warning',
                                2 => 'bg-success',
                                default => 'bg-dark',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $surat->status_text }}</span>
                    </div>

                    <div class="col-md-6">
                        <label for="seksi" class="form-label">Bukti Pengiriman</label><br>
                        @if ($surat->bukti_pengiriman)
                            <img style="max-height: 200px;" src="{{ asset('storage/' . $surat->bukti_pengiriman) }}"
                                alt="Bukti Pengiriman" class="img-fluid">
                        @else
                            <p>Belum ada bukti pengiriman.</p>
                        @endif
                    </div>

                    <div class="col-12">
                        <a href="{{ route('surat.edit', $surat->id) }}" class="btn btn-primary">Update</a>
                        <a href="{{ route('surat.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
