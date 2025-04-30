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
                        Manage User Schools
                    </h3>

                    <!-- ADD BUTTON -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignSchoolModal">
                        <i class="fas fa-plus"></i> Add User School
                    </button>
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

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="30">No</th>
                                <th>Full Name</th>
                                <th>Level</th>
                                <th>School</th>
                                <th width="300">Asign Class</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($user_schools->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <div class="py-4">
                                            <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                            <p class="mt-2 text-muted">Tidak ada data User School.</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                            @foreach ($user_schools as $index => $us)
                                    <tr>
                                        <td class="text-center">{{ $user_schools->firstItem() + $index }}</td>

                                {{-- @foreach ($user_schools as $us)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td> --}}
                                        <td>{{ $us->user->fullname }}</td>
                                        <td>{{ $us->user->level }}</td>
                                        <td>{{ $us->school->school_name }}</td>
                                        <td>
                                            @php
                                                $teacher_class = $teacher_classes[$us->user_id] ?? collect();
                                            @endphp
                                            <div class="d-flex align-items-center flex-wrap">
                                                @foreach ($teacher_class as $ts)
                                                    <div class="d-flex align-items-center bg-info p-2 rounded-3 me-2 mb-2">
                                                        <span class="text-white me-2">{{ $ts->class_name }}</span>
                                                        <form
                                                            action="{{ route('superadmin.manage-teacher.destroy', $ts->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn bg-transparent btn-sm p-0 rounded-2">
                                                                <i class="fa-solid fa-delete-left text-warning fa-xl"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-1">
                                                <button class="btn btn-success rounded-3" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $us->id }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>

                                                <a class="btn btn-info rounded-3" href="#"
                                                    data-bs-target="#addClass{{ $us->id }}" data-bs-toggle="modal">
                                                    <i class="fa-solid fa-square-plus"></i>
                                                </a>

                                                <form
                                                    action="{{ route('superadmin.manage-userschools.destroy', $us->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger rounded-3">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>


                                        </td>
                                    </tr>

                                    <!-- MODAL ASIGN CLASS -->
                                    <div class="modal fade" id="addClass{{ $us->id }}" tabindex="-1"
                                        aria-labelledby="addClassLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content p-3 border-0 rounded-4">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="addClassLabel">Assign Teacher and Class
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('superadmin.manage-teacher.store') }}"
                                                        method="POST">
                                                        @csrf

                                                        <!-- Full Name -->
                                                        <div class="mb-3">
                                                            <label for="user_id" class="form-label">Nama Guru</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $us->user->fullname }}" readonly>

                                                            <!-- Hidden Input untuk Mengirimkan ID ke Backend -->
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $us->user_id }}">
                                                            <input type="hidden" name="school_id"
                                                                value="{{ $us->school->school_id }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="classes">Kelas</label>
                                                            <select name="class_id" id="class_id" class="form-select">
                                                                <option value="">-Pilih-</option>
                                                                @php
                                                                    $data_kelas =
                                                                        $school_classes[$us->school_id] ?? collect();
                                                                @endphp
                                                                @foreach ($data_kelas as $kelas)
                                                                    <option value="{{ $kelas->class_id }}">
                                                                        {{ $kelas->class_name }}</option>
                                                                @endforeach
                                                            </select>
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

                                    <!-- MODAL EDIT -->
                                    <div class="modal fade" id="editModal{{ $us->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content p-3 border-0 rounded-4">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Data User School
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ route('superadmin.manage-userschools.update', $us->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Full Name -->
                                                        <div class="mb-3">
                                                            <label for="user_id" class="form-label">Full Name</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $us->user->fullname }}" readonly>

                                                            <!-- Hidden Input untuk Mengirimkan ID ke Backend -->
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $us->user_id }}">
                                                        </div>


                                                        <!-- School -->
                                                        <div class="mb-3">
                                                            <label for="school_id" class="form-label">School</label>
                                                            <select class="form-select" id="school_id" name="school_id"
                                                                required>
                                                                @foreach ($schools as $school)
                                                                    <option value="{{ $school->school_id }}"
                                                                        {{ $school->school_id == $us->school->school_id ? 'selected' : '' }}>
                                                                        {{ $school->school_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
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
                        {{ $user_schools->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL ASSIGN SCHOOL -->
    <div class="modal fade" id="assignSchoolModal" tabindex="-1" aria-labelledby="assignSchoolModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignSchoolModalLabel">Assign User to School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.manage-userschools.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">-- Choose User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="school_id" class="form-label">Select School</label>
                            <select name="school_id" id="school_id" class="form-control" required>
                                <option value="">-- Choose School --</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->school_id }}">{{ $school->school_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
@endsection
