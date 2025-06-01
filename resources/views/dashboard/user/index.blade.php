@extends('dashboard.layout')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">List User</h5>
                    <a class="btn btn-primary" href='{{ route('users.create') }}'>Tambah</a>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Email</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Role</h6>
                                </th>
                                <th class="border-bottom-0">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $no++ }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-semibold">{{ $user->name }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-normal mb-1">{{ $user->email }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-normal mb-1">{{ $user->role }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex gap-2">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
@endsection
