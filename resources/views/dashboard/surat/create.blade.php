@extends('dashboard.layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">Form Surat</h5>
                </div>
                <form action="{{ route('surat.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label for="kepada" class="form-label">Kepada</label>
                        <input type="text" class="form-control" id="kepada" name="kepada" required>
                    </div>

                    <div class="col-md-6">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="kurir" class="form-label">Kurir</label>
                        <select class="form-select" id="kurir" name="kurir" required>
                            <option selected disabled value="">-- Pilih Kurir --</option>
                            @foreach ($kurirs as $kurir)
                                <option value="{{ $kurir->id }}">{{ $kurir->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="seksi" class="form-label">Seksi</label>
                        <select class="form-select" id="seksi" name="seksi" required>
                            <option selected disabled value="">-- Pilih Seksi --</option>
                            @foreach ($seksis as $seksi)
                                <option value="{{ $seksi->id }}">{{ $seksi->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
