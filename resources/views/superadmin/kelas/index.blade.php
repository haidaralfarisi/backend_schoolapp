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
                        Manage Your Class
                        <span class="badge bg-primary">{{ $schools->school_id }}</span>
                        {{-- <span>
                                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-custom-class="tooltip-success"
                                        data-bs-title="Traffic Overview"></iconify-icon>
                                </span> --}}
                    </h3>

                    <!-- ADD BUTTON -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal">
                        <i class="fas fa-plus"></i> Add Class
                    </a>

                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class>
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th width="30">No</th>
                                <th>Class ID</th>
                                <th>School ID</th>
                                <th>Class Name</th>
                                <th>Grade</th>
                                <th>Created at</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $class)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $class->class_id }}</td>
                                    <td>{{ $class->school_id }}</td>
                                    <td>{{ $class->class_name }}</td>
                                    <td>{{ $class->grade }}</td>
                                    <td>{{ $class->created_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Menu
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editClassModal{{ $class->id }}">
                                                        <i class="fas fa-edit text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('superadmin.kelas.destroy', $class->class_id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
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

                                <!-- Modal Untuk Edit User-->
                                {{-- Modal harus di dalam foreach dan harus meletakkan {{ $user->id }} agar bisa di panggil sesuai id yang
                                        di inginkan --}}
                                <div class="modal fade" id="editClassModal{{ $class->id }}" tabindex="-1"
                                    aria-labelledby="editClassModalLabel{{ $class->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editClassModalLabel">Edit
                                                    Class</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editClassForm"
                                                    action="{{ route('superadmin.kelas.update', ['class_id' => $class->class_id]) }}"
                                                    method="POST">
                                                    <h3 class="mb-3">{{ $schools->school_name }}</h3>

                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Class ID (Readonly jika tidak boleh diubah) -->
                                                    <div class="mb-3">
                                                        <label for="class_id" class="form-label">Class
                                                            ID</label>
                                                        <input type="text" class="form-control" id="class_id"
                                                            name="class_id" value="{{ $class->class_id }}" required>
                                                    </div>

                                                    <!-- Class Name -->
                                                    <div class="mb-3">
                                                        <label for="class_name" class="form-label">Class
                                                            Name</label>
                                                        <input type="text" class="form-control" id="class_name"
                                                            name="class_name" value="{{ $class->class_name }}" required>
                                                    </div>

                                                    <!-- School ID (Dropdown) -->
                                                    <div class="mb-3">
                                                        <label for="school_id" class="form-label">School</label>
                                                        <input type="text" class="form-control bg-light" id="school_id"
                                                            name="school_id" value="{{ $schools->school_id }}" readonly
                                                            required>
                                                    </div>


                                                    <!-- Grade -->
                                                    <div class="mb-3">
                                                        <label for="grade" class="form-label">Grade</label>
                                                        <input type="text" class="form-control" id="grade"
                                                            name="grade" value="{{ $class->grade }}" required>
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
                    {{-- {{ $users->links() }} --}}
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
                    <form action="{{ route('superadmin.kelas.store') }}" method="POST">
                        @csrf
                        <h3 class="mb-3">{{ $schools->school_name }}</h3>
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
                            <input type="text" value="{{ $schools->school_id }}" class="form-control bg-light"
                                id="school_id" name="school_id" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <input type="text" class="form-control" id="grade" name="grade" required>
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
