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
                <!-- HEADER & BUTTON -->
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        This is your data Classes
                    </h3>

                    <!-- ADD BUTTON -->
                    {{-- <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal">
                        <i class="fas fa-plus"></i> Add Class
                    </a> --}}
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

                <div class="accordion" id="accordionExample">
                    @forelse ($data_kelas as $school_name => $kelas_list)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ Str::slug($school_name) }}">
                                <button class="accordion-button collapsed fw-bold fs-5" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ Str::slug($school_name) }}"
                                    aria-expanded="false" aria-controls="collapse{{ Str::slug($school_name) }}">
                                    {{ $school_name }}
                                </button>
                            </h2>
                            <div id="collapse{{ Str::slug($school_name) }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ Str::slug($school_name) }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @if ($kelas_list->isEmpty())
                                        <p class="text-center text-muted">Tidak ada data kelas.</p>
                                    @else
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="30">No</th>
                                                    <th>Class ID</th>
                                                    <th>Class Name</th>
                                                    <th>Grade</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kelas_list as $class)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ $class->class_id }}</td>
                                                        <td>{{ $class->class_name }}</td>
                                                        <td>{{ $class->grade }}</td>
                                                        <td>
                                                            <a
                                                                href="{{ route('guru.students.index', $class->student_id) }}">
                                                                <i class="fas fa-user-graduate text-info"></i> Student
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('guru.lsplans.index', $class->class_id) }}">
                                                                <i class="fas fa-book text-info"></i> Lesson Plan
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary btn-sm dropdown-toggle"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                    Menu
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item" href="#"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editClassModal{{ $class->id }}">
                                                                            <i class="fas fa-edit text-primary"></i> Edit
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('tusekolah.classes.destroy', $class->class_id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="dropdown-item text-danger">
                                                                                <i class="fas fa-trash-alt"></i> Delete
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="editClassModal{{ $class->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editClassModalLabel{{ $class->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editClassModalLabel">Edit
                                                                        Class</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="editClassForm"
                                                                        action="{{ route('tusekolah.classes.update', ['id' => $class->id]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')

                                                                        <!-- Class ID (Readonly jika tidak boleh diubah) -->
                                                                        <div class="mb-3">
                                                                            <label for="class_id" class="form-label">Class
                                                                                ID</label>
                                                                            <input type="text" class="form-control"
                                                                                id="class_id" name="class_id"
                                                                                value="{{ old('class_id', $class->class_id) }}"
                                                                                required>
                                                                        </div>

                                                                        <!-- Class Name -->
                                                                        <div class="mb-3">
                                                                            <label for="class_name"
                                                                                class="form-label">Class
                                                                                Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="class_name" name="class_name"
                                                                                value="{{ old('class_name', $class->class_name) }}"
                                                                                required>
                                                                        </div>

                                                                        <!-- School ID (Dropdown) -->
                                                                        <div class="mb-3">
                                                                            <label for="school_id"
                                                                                class="form-label">School</label>
                                                                            <select class="form-control" name="school_id"
                                                                                required>
                                                                                @foreach ($schools as $school)
                                                                                    <option
                                                                                        value="{{ $school->school_id }}"
                                                                                        {{ old('school_id', $class->school_id) == $school->school_id ? 'selected' : '' }}>
                                                                                        {{ $school->school_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>


                                                                        <!-- Grade -->
                                                                        <div class="mb-3">
                                                                            <label for="grade"
                                                                                class="form-label">Grade</label>
                                                                            <input type="number" class="form-control"
                                                                                id="grade" name="grade"
                                                                                value="{{ old('grade', $class->grade) }}"
                                                                                required>
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Save
                                                                                Changes</button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center">
                            <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                            <h4 class="mt-2">Tidak ada data Kelas.</h4>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClassModalLabel">Add New Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class Id</label>
                            <input type="text" class="form-control" id="class_id" name="class_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="class_name" class="form-label">Class Name</label>
                            <input type="text" class="form-control" id="class_name" name="class_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="school_id" class="form-label">School ID</label>
                            <select name="school_id" id="school_id" class="form-control" required>
                                <option value="">-- Choose School --</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->school_id }}">{{ $school->school_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <input type="number" class="form-control" id="grade" name="grade" required>
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
