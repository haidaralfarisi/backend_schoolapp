@extends('layouts.app')

@section('content')
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!--  SIDEBAR -->
        @include('partials.sidebar_guru')

        <!--  Main wrapper -->
        <div class="body-wrapper bg-white">

            <!--  NAVBAR -->
            @include('partials.navbar')

            <div class="container-fluid">

                <!-- Breadcrumbs -->
                <div class="d-flex align-items-center mb-3">
                    <i class="fa-solid fa-house text-primary me-3"></i>
                    <i class="fa-solid fa-chevron-left text-primary me-3"></i>
                    <a href="#" onclick="window.location.href='{{ route('guru.classes.index') }}'"
                        class="text-decoration-none text-primary me-3">Classes</a>
                </div>
                <!-- Breadcrumbs -->

                <!-- HEADER & BUTTON -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        This is Your Students
                        {{-- <span>
                                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-custom-class="tooltip-success"
                                        data-bs-title="Traffic Overview"></iconify-icon>
                                </span> --}}
                    </h3>



                    <!-- ADD BUTTON -->
                    {{-- <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addSchoolModal">
                                <i class="fas fa-plus"></i> Add Student
                            </a> --}}

                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30">No</th>
                            <th>Student ID</th>
                            <th>NISN</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Gender</th>
                            <th>Place Of Birth</th>
                            <th>Date Of Birthday</th>
                            {{-- <th>School ID</th>
                                        <th>Class ID</th> --}}
                            <th>Entry Year</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if ($students->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="py-4">
                                        <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                        <p class="mt-2 text-muted">Tidak ada data Siswa.</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($students as $student)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->nisn }}</td>
                                    <td>{{ $student->fullname }}</td>
                                    <td>{{ $student->username }}</td>
                                    <td>{{ $student->gender }}</td>
                                    <td>{{ $student->pob }}</td>
                                    <td>{{ $student->dob }}</td>
                                    <td>{{ $student->entry_year }}</td>
                                   
                                    {{-- <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Menu
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editStudentModal{{ $student->id }}">
                                                        <i class="fas fa-edit text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td> --}}
                                </tr>

                                <!-- Modal Edit -->
                                {{-- <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1"
                                    aria-labelledby="editStudentModalLabel{{ $student->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editStudentModalLabel{{ $student->id }}">
                                                    Edit Data Siswa
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('students.update', $student->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Lengkap</label>
                                                        <input type="text" class="form-control" name="fullname"
                                                            value="{{ $student->fullname }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" class="form-control" name="username"
                                                            value="{{ $student->username }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tahun Masuk</label>
                                                        <input type="number" class="form-control" name="entry_year"
                                                            value="{{ $student->entry_year }}" required>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            @endforeach
                        @endif
                    </tbody>

                </table>
                {{-- {{ $users->links() }} --}}
            </div>
        </div>
    </div>

    <!-- MODAL ADD SCHOOL -->
    <div class="modal fade" id="addSchoolModal" tabindex="-1" aria-labelledby="addSchoolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSchoolModalLabel">Add New School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="schoolName" class="form-label">School Name</label>
                            <input type="text" class="form-control" id="schoolName" name="schoolName" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="established" class="form-label">Established Year</label>
                            <input type="number" class="form-control" id="established" name="established" required>
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
