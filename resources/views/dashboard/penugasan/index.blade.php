@extends('dashboard.layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">List Penugasan</h5>
                </div>

                <div class="table-responsive">
                    <table id="tableSurat" class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Resi</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Kepada</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Alamat</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Seksi</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Status</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($surats as $surat)
                                <tr>
                                    @php
                                        $status = match ($surat->status) {
                                            0 => 'Di Tugaskan',
                                            1 => 'Dalam Pengiriman',
                                            2 => 'Terkirim',
                                            default => '-',
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
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $no++ }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <a href="{{ route('penugasan.show', $surat->id) }}" style="color: #5A6A85;">
                                            <p class="mb-0 fw-semibold">{{ $surat->no_resi }}</p>
                                        </a>
                                    </td>
                                    <td class="border-bottom-0">
                                        <a href="{{ route('penugasan.show', $surat->id) }}" style="color: #5A6A85;">
                                            <p class="fw-semibold mb-1">{{ $surat->kepada }}</p>
                                        </a>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ \Illuminate\Support\Str::limit($surat->alamat, 20) }}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $surat->seksi->nama ?? '-' }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        {{ $status }}
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex gap-1">
                                            {{-- Tombol Kirim --}}
                                            <button class="btn btn-sm btn-warning {{ $action_kirim }}" data-bs-toggle="modal"
                                                data-bs-target="#modalKirim{{ $surat->id }}">
                                                Kirim
                                            </button>

                                            {{-- Tombol Selesai --}}
                                            <button class="btn btn-sm btn-success {{ $action_selesai }}" data-bs-toggle="modal"
                                                data-bs-target="#modalSelesai{{ $surat->id }}">
                                                Selesai
                                            </button>
                                        </div>

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
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
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
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="bukti_pengiriman" class="form-label">Upload Foto
                                                                    Bukti Pengiriman</label>
                                                                <input type="file" name="bukti_pengiriman"
                                                                    class="form-control" accept="image/*" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Selesai</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tableSurat').DataTable({
                responsive: true,
                layout: {
                    topStart: {
                        buttons: [{
                            extend: 'excelHtml5',
                            text: 'Export ke Excel',
                            filename: 'Daftar_Surat',
                        }]
                    }
                }
            });
        });
    </script>
@endsection

