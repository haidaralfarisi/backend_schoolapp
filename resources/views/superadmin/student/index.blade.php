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
                <!-- Breadcrumbs -->
                <div class="d-flex align-items-center mb-3">
                    <i class="fa-solid fa-house text-primary me-3"></i>
                    <i class="fa-solid fa-chevron-left text-primary me-3"></i>
                    <a href="#" onclick="window.location.href='{{ route('superadmin.schools.index') }}'"
                        class="text-decoration-none text-primary me-3">School</a>
                </div>
                <!-- Breadcrumbs -->

                <!-- HEADER & BUTTON -->
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        Manage Your Students
                        <span class="badge bg-primary">{{ $school->school_id }}</span>
                    </h3>

                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <form action="{{ route('students.search', $school->school_id) }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Cari siswa..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>

                        <!-- ADD BUTTON -->
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal">
                            <i class="fas fa-plus"></i> Add Student
                        </a>

                        <!-- Import Button -->
                        <a href="#" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#importStudentsModal">
                            <i class="fas fa-file-import"></i> Import Students
                        </a>
                    </div>
                </div>
                {{-- 
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif --}}

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div>
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th width="30">No</th>
                                <th>Student ID</th>
                                <th>School ID</th>
                                {{-- <th>Class ID</th> --}}
                                {{-- <th>NISN</th> --}}
                                <th>NIS</th>
                                <th>Full Name</th>
                                {{-- <th>User Name</th> --}}
                                <th>Gender</th>
                                {{-- <th>Place Of Born</th> --}}
                                <th>Parent</th>
                                <th>Entry Year</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $index => $student)
                                <tr>
                                    <td class="text-center">{{ $students->firstItem() + $index }}</td>
                                    {{-- @foreach ($students as $student)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td> --}}
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->school->school_name ?? '-' }}</td> <!-- Menampilkan nama sekolah -->
                                    {{-- <td>{{ $student->class_id }}</td> --}}
                                    {{-- <td>{{ $student->nisn }}</td> --}}
                                    <td>{{ $student->nis }}</td>
                                    <td>{{ $student->fullname }}</td>
                                    {{-- <td>{{ $student->username }}</td> --}}
                                    <td>{{ $student->gender }}</td>
                                    {{-- <td>{{ $student->pob }}</td> --}}
                                    {{-- <td>{{ $student->dob }}</td> --}}
                                    <td>{{ $student->user_id ?? '-' }}</td>
                                    <td>{{ $student->entry_year }}</td>

                                    <td class="text-center">
                                        @if ($student->image)
                                            <img src="{{ asset('storage/' . $student->image) }}" alt="photo"
                                                width="50" height="50" class="rounded-circle">
                                        @else
                                            <span>No Photo</span>
                                        @endif
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
                                                        data-bs-target="#editStudentModal{{ $student->id }}">
                                                        <i class="fas fa-edit text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('superadmin.students.destroy', $student->student_id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this student?');">
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

                                <!-- Modal Untuk Edit Student-->
                                {{-- Modal harus di dalam foreach dan harus meletakkan {{ $user->id }} agar bisa di panggil sesuai id yang
                                        di inginkan --}}
                                <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1"
                                    aria-labelledby="editStudentModalLabel{{ $student->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editStudentModalLabel">Edit
                                                    Data Student</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editStudentForm"
                                                    action="{{ route('superadmin.students.update', ['student_id' => $student->student_id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Student ID -->
                                                    <div class="mb-3">
                                                        <label for="student" class="form-label">Student
                                                            ID</label>
                                                        <input type="text" class="form-control bg-light" id="student"
                                                            name="student" value="{{ $student->student_id }}" readonly
                                                            required>
                                                    </div>

                                                    <!-- NISN -->
                                                    <div class="mb-3">
                                                        <label for="nisn" class="form-label">NISN</label>
                                                        <input type="text" class="form-control" id="nisn"
                                                            name="nisn" value="{{ $student->nisn }}" required>
                                                    </div>

                                                    <!-- NIS -->
                                                    <div class="mb-3">
                                                        <label for="nis" class="form-label">NIS</label>
                                                        <input type="text" class="form-control" id="nis"
                                                            name="nis" value="{{ $student->nis }}" required>
                                                    </div>

                                                    <!-- Fullname -->
                                                    <div class="mb-3">
                                                        <label for="fullname" class="form-label">Full Name</label>
                                                        <input type="text" class="form-control" id="fullname"
                                                            name="fullname" value="{{ $student->fullname }}" required>
                                                    </div>

                                                    <!-- School ID -->
                                                    <div class="mb-3">
                                                        <label for="school_name" class="form-label">School</label>
                                                        <input type="text" value="{{ $school->school_name }}"
                                                            class="form-control bg-light" id="school_name" readonly>
                                                    </div>

                                                    <input type="hidden" name="school_id"
                                                        value="{{ $school->school_id }}">


                                                    <!-- Class ID -->
                                                    <div class="mb-3">
                                                        <label for="class_id" class="form-label">Class
                                                            ID</label>
                                                        <input type="text" class="form-control" id="class_id"
                                                            name="class_id" value="{{ $student->class_id }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="gender" class="form-label">Gender</label>
                                                        <select class="form-select" id="gender" name="gender"
                                                            required>
                                                            <option value="">-- Choose Gender --</option>
                                                            <option value="Male"
                                                                {{ $student->gender == 'Male' ? 'selected' : '' }}>Male
                                                            </option>
                                                            <option value="Female"
                                                                {{ $student->gender == 'Female' ? 'selected' : '' }}>
                                                                Female</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="pob" class="form-label">Place Of birth</label>
                                                        <input type="text" class="form-control" id="pob"
                                                            name="pob" value="{{ $student->pob }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Day Of birth</label>
                                                        <input type="year" class="form-control" id="dob"
                                                            name="dob" value="{{ $student->dob }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="entry_year" class="form-label">Entry Year</label>
                                                        <input type="number" class="form-control" id="entry_year"
                                                            name="entry_year" value="{{ $student->entry_year }}"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="image" class="form-label">Foto Siswa</label>

                                                        {{-- Tampilkan gambar saat ini jika ada --}}
                                                        @if ($student->image)
                                                            <div class="mb-2">
                                                                <img src="{{ asset('storage/' . $student->image) }}"
                                                                    alt="Foto Siswa" style="max-height: 150px;">
                                                            </div>
                                                        @endif

                                                        <input type="file" class="form-control" id="image"
                                                            name="image" accept="image/*">
                                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti
                                                            foto.</small>
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
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $students->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD Class -->
    <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClassModalLabel">Add New Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.students.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID</label>
                            <input type="text" class="form-control bg-light" id="student_id" name="student_id"
                                readonly required>
                        </div> --}}
                        <div class="mb-3">
                            <label for="school_id" class="form-label">School ID</label>
                            <input type="text" value="{{ $school->school_id }}" class="form-control bg-light"
                                id="school_id" name="school_id" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class Id</label>
                            <select name="class_id" id="class_id" class="form-control" value="{{ old('class_id') }}"
                                required>
                                <option value="">-- Choose Class --</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn"
                                value="{{ old('nisn') }}" required>
                            @if ($errors->has('nisn'))
                                <div class="text-danger">{{ $errors->first('nisn') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" class="form-control" id="nis" name="nis"
                                value="{{ old('nis') }}" required>
                            @if ($errors->has('nis'))
                                <div class="text-danger">{{ $errors->first('nis') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                value="{{ old('fullname') }}" required>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="username" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username') }}" required>
                            @if ($errors->has('username'))
                                <div class="text-danger">{{ $errors->first('username') }}</div>
                            @endif
                        </div> --}}

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">-- Choose Gender --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pob" class="form-label">Place of Birth</label>
                            <input type="text" class="form-control" id="pob" name="pob"
                                value="{{ old('entry_year') }}"required>
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob"
                                value="{{ old('dob') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="entry_year" class="form-label">Entry Year</label>
                            <input type="number" class="form-control" id="entry_year" name="entry_year"
                                value="{{ old('entry_year') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
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


    <!-- Modal Upload Excel -->
    <div class="modal fade" id="importStudentsModal" tabindex="-1" aria-labelledby="importStudentsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importStudentsModalLabel">
                        <i class="fas fa-file-excel"></i> Import Students from Excel
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-2 mb-3">
                        <a href="{{ route('students.template') }}" class="btn btn-info text-white">
                            <i class="fas fa-download"></i> Download Template
                        </a>
                    </div>
                    <form id="importStudentsForm" action="{{ route('superadmin.students.import') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold">Upload Excel File</label>
                            <input type="file" class="form-control" name="file" id="file"
                                accept=".xls, .xlsx" required>
                            <small class="text-muted">Only .xls or .xlsx files allowed.</small>
                        </div>
                        <div id="uploadProgress" class="progress d-none">
                            <div id="uploadBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                style="width: 0%">0%</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
@endsection
