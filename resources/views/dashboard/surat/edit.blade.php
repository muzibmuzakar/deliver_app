@extends('dashboard.layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">Edit Surat</h5>
                </div>
                <form action="{{ route('surat.update', $surat->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="kepada" class="form-label">Kepada</label>
                        <input type="text" class="form-control" id="kepada" name="kepada" value="{{ old('kepada', $surat->kepada) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $surat->alamat) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="kurir" class="form-label">Kurir</label>
                        <select class="form-select" id="kurir" name="kurir" required>
                            <option disabled value="">-- Pilih Kurir --</option>
                            @foreach ($kurirs as $kurir)
                                <option value="{{ $kurir->id }}" {{ old('kurir', $surat->kurir_id) == $kurir->id ? 'selected' : '' }}>
                                    {{ $kurir->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="seksi" class="form-label">Seksi</label>
                        <select class="form-select" id="seksi" name="seksi" required>
                            <option disabled value="">-- Pilih Seksi --</option>
                            @foreach ($seksis as $seksi)
                                <option value="{{ $seksi->id }}" {{ old('seksi', $surat->seksi_id) == $seksi->id ? 'selected' : '' }}>
                                    {{ $seksi->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="0" {{ $surat->status == 0 ? 'selected' : '' }}>Belum Diantar</option>
                            <option value="1" {{ $surat->status == 1 ? 'selected' : '' }}>Sedang Diantar</option>
                            <option value="2" {{ $surat->status == 2 ? 'selected' : '' }}>Sudah Diterima</option>
                            <option value="3" {{ $surat->status == 3 ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('surat.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
