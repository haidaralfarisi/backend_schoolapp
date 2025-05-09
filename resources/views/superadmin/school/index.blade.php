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
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        Manage Your Schools
                    </h3>

                    <!-- ADD BUTTON -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                        <i class="fas fa-plus"></i> Add School
                    </button>

                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th width="30">No</th>
                            <th>School ID</th>
                            <th>School Name</th>
                            <th>Region</th>
                            <th>Email</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            {{-- <th>Address</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($schools->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="py-4">
                                        <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                        <p class="mt-2 text-muted">Tidak ada data sekolah.</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                        @foreach ($schools as $index => $school)
                                <tr>
                                    <td class="text-center">{{ $schools->firstItem() + $index }}</td>
                            {{-- @foreach ($schools as $school)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td> --}}
                                    <td>{{ $school->school_id }}</td>
                                    <td>{{ $school->school_name }}</td>
                                    <td>{{ $school->region }}</td>
                                    <td>{{ $school->email }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.kelas.index', $school->school_id) }}">
                                            <i class="fas fa-school text-info"></i> Class
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('superadmin.students.index', $school->school_id) }}">
                                            <i class="fas fa-user-graduate text-info"></i> Student
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('superadmin.lsplans.index', $school->school_id) }}">
                                            <i class="fas fa-book text-info"></i> Lesson Plan
                                        </a>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Menu
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $school->id }}">
                                                        <i class="fas fa-edit text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('superadmin.schools.destroy', $school->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this school?');">
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


                                <div class="modal fade" id="editModal{{ $school->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3 border-0 rounded-4">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editModalLabel">Edit Data School</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editFacilitasForm"
                                                    action="{{ route('superadmin.schools.update', ['school_id' => $school->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- School ID -->
                                                    <div class="mb-3">
                                                        <label for="school_id" class="form-label">School ID</label>
                                                        <input type="text" class="form-control" id="school_id"
                                                            name="school_id" value="{{ $school->school_id }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="school_name" class="form-label">School Name</label>
                                                        <input type="text" class="form-control" id="school_name"
                                                            name="school_name" value="{{ $school->school_name }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="region" class="form-label">Region</label>
                                                        <input type="text" class="form-control" id="region"
                                                            name="region" value="{{ $school->region }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="address" class="form-label">Address</label>
                                                        <textarea class="form-control" id="address" name="address" required>{{ $school->address }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="text" class="form-control" id="email"
                                                            name="email" value="{{ $school->email }}" required>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $schools->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD SCHOOL -->
    <div class="modal fade" id="addSchoolModal" tabindex="-1" aria-labelledby="addVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSchoolModalLabel">Add New School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.schools.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="school_name" class="form-label">School Name</label>
                            <input type="text" placeholder="School Name" class="form-control" id="school_name" name="school_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="school_id" class="form-label">School ID</label>
                            <input type="text" placeholder="School ID" class="form-control" id="school_id" name="school_id" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" placeholder="Email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="region" class="form-label">Region</label>
                            <input type="text" placeholder="Region" class="form-control" id="region" name="region" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" placeholder="Address" id="address" name="address" rows="3" required></textarea>
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
