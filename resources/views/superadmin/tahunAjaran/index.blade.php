@extends('layouts.app')

@section('content')
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!--  SIDEBAR -->
        @include('partials.sidebar_superadmin')

        <!--  Main wrapper -->
        <div class="body-wrapper bg-white">

            <!--  NAVBAR -->
            @include('partials.navbar')

            <div class="container-fluid">
                <!-- HEADER & BUTTON -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        Manage Your School Years
                        {{-- <span>
                                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-custom-class="tooltip-success"
                                        data-bs-title="Traffic Overview"></iconify-icon>
                                </span> --}}
                    </h3>

                    <!-- ADD BUTTON -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchoolYearModal">
                        <i class="fas fa-plus"></i> Add School Year
                    </a>

                </div>

                <!-- SUCCESS MESSAGE -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- ERROR MESSAGE -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30">No</th>
                            <th>Tahun Ajaran</th>
                            <th>Title</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tahunAjarans->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="py-4">
                                        <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                        <p class="mt-2 text-muted">Tidak ada data Tahun Ajaran</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($tahunAjarans as $tahunAjaran)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $tahunAjaran->tahun_ajaran_id }}</td>
                                    <td>{{ $tahunAjaran->title }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Menu
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editThajaranModal{{ $tahunAjaran->id }}">
                                                        <i class="fas fa-edit text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('superadmin.thajaran.destroy', $tahunAjaran->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus Tahun Ajaran ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editThajaranModal{{ $tahunAjaran->id }}" tabindex="-1"
                                    aria-labelledby="editThajaranModalLabel{{ $tahunAjaran->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editThajaranModalLabel{{ $tahunAjaran->id }}">
                                                    Edit Data School Year
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('superadmin.thajaran.update', $tahunAjaran->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <h4 class="mb-3">Tahun Ajaran</h4>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Dari Tahun</label>
                                                            <input type="text" name="dari_tahun"
                                                                class="form-control yearpicker"
                                                                value="{{ substr($tahunAjaran->tahun_ajaran_id, 2, 4) }}"
                                                                required>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Ke Tahun</label>
                                                            <input type="text" name="ke_tahun"
                                                                class="form-control yearpicker"
                                                                value="{{ substr($tahunAjaran->tahun_ajaran_id, 6, 4) }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </tbody>

                </table>
                {{-- {{ $users->links() }} --}}
            </div>
        </div>
    </div>

    <!-- MODAL ADD SCHOOL -->
    <div class="modal fade" id="addSchoolYearModal" tabindex="-1" aria-labelledby="addSchoolYearModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSchoolYearModalLabel">Add New School Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.thajaran.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <h4 class="mb-3">Tahun Ajaran</h4>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dari Tahun</label>
                                <input type="text" name="dari_tahun" class="form-control yearpicker" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ke Tahun</label>
                                <input type="text" name="ke_tahun" class="form-control yearpicker" required>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
@endsection
