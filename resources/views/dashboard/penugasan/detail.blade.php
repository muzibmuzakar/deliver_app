@extends('dashboard.layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">{{ $surat->no_resi }}</h5>
                </div>
                <div class="row g-3">
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

                            $action_kirim = match ($surat->status) {
                                0 => '',
                                1 => 'd-none',
                                2 => 'd-none',
                                default => '-',
                            };

                            $action_selesai = match ($surat->status) {
                                0 => 'd-none',
                                1 => '',
                                2 => 'd-none',
                                default => '-',
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
                        {{-- Tombol Kirim --}}
                        <button class="btn btn-warning {{ $action_kirim }}" data-bs-toggle="modal"
                            data-bs-target="#modalKirim{{ $surat->id }}">
                            Kirim
                        </button>

                        {{-- Tombol Selesai --}}
                        <button class="btn btn-success {{ $action_selesai }}" data-bs-toggle="modal"
                            data-bs-target="#modalSelesai{{ $surat->id }}">
                            Selesai
                        </button>

                        {{-- Modal Kirim --}}
                        <div class="modal fade" id="modalKirim{{ $surat->id }}" tabindex="-1"
                            aria-labelledby="modalKirimLabel{{ $surat->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('penugasan.kirim', $surat->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Kirim</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin memulai pengiriman?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">Ya,
                                                Kirim</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Modal Selesai --}}
                        <div class="modal fade" id="modalSelesai{{ $surat->id }}" tabindex="-1"
                            aria-labelledby="modalSelesaiLabel{{ $surat->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('penugasan.selesai', $surat->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Selesaikan Pengiriman</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="bukti_pengiriman" class="form-label">Upload Foto
                                                    Bukti Pengiriman</label>
                                                <input type="file" name="bukti_pengiriman" class="form-control"
                                                    accept="image/*" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Selesai</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <a href="{{ route('penugasan.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
