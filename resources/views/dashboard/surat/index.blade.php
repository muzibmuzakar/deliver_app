@extends('dashboard.layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h5 class="card-title fw-semibold">List Surat</h5>
                    <a class="btn btn-primary" href='{{ route('surat.create') }}'>Tambah</a>
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
                                    <h6 class="fw-semibold mb-0">Kurir</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Seksi</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Status</h6>
                                </th>
                                <th class="border-bottom-0">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($surats as $surat)
                                <tr>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $no++ }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $surat->no_resi }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-1">{{ $surat->kepada }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $surat->alamat }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $surat->kurir->name ?? '-' }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $surat->seksi->nama ?? '-' }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        @php
                                            $badgeClass = match ($surat->status) {
                                                0 => 'bg-info',
                                                1 => 'bg-warning',
                                                2 => 'bg-success',
                                                default => 'bg-dark',
                                            };

                                            $modal = match ($surat->status) {
                                                0 => '',
                                                1 => '',
                                                2 => ' data-bs-toggle=modal',
                                                default => '',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}" {{ $modal }}
                                            data-bs-target="#modalBukti{{ $surat->id }}">{{ $surat->status_text }}</span>
                                        <div class="modal fade" id="modalBukti{{ $surat->id }}" tabindex="-1"
                                            aria-labelledby="modalBuktiLabel{{ $surat->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Bukti Pengiriman</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if ($surat->bukti_pengiriman)
                                                            <img style="max-height: 500px;" src="{{ asset('storage/' . $surat->bukti_pengiriman) }}"
                                                                alt="Bukti Pengiriman" class="img-fluid">
                                                        @else
                                                            <p>Tidak ada bukti pengiriman.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex gap-1">
                                            {{-- Tombol Show --}}
                                            {{-- <a href="{{ route('surat.edit', $surat->id) }}" class="btn btn-sm btn-success">
                                                <i class="ti ti-eye"></i>
                                            </a> --}}

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('surat.edit', $surat->id) }}" class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('surat.destroy', $surat->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
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
