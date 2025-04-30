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
                        Manage Your Lesson Plan
                        <span class="badge bg-primary">{{ $school->school_id }}</span>
                        {{-- <span>
                                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-custom-class="tooltip-success"
                                        data-bs-title="Traffic Overview"></iconify-icon>
                                </span> --}}
                    </h3>

                    <!-- ADD BUTTON -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addlsplanModal">
                        <i class="fas fa-plus"></i> Add Lesson Plan
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
                                <th>School ID</th>
                                <th>Class ID</th>
                                <th>User ID</th>
                                <th>Title</th>
                                <th>Desc</th>
                                <th>File PDF</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($lsplans->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                            <p class="mt-2 text-muted">Tidak ada data Lesson Plan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($lsplans as $lsplan)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $lsplan->school->school_name }}</td>
                                        <td>{{ $lsplan->class_id }}</td>
                                        <td>{{ $lsplan->user->fullname }}</td>
                                        <td>{{ $lsplan->title }}</td>
                                        <td>{{ $lsplan->desc }}</td>
                                        <td>
                                            @if ($lsplan->file_pdf)
                                                <a href="{{ asset('storage/' . $lsplan->file_pdf) }}" target="_blank"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Preview
                                                </a>
                                            @else
                                                <span class="text-muted">No File</span>
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
                                                            data-bs-target="#editlsplanModal{{ $lsplan->id }}">
                                                            <i class="fas fa-edit text-primary"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('superadmin.lsplans.destroy', $lsplan->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus Lesson Plan ini?');">
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
                                    <div class="modal fade" id="editlsplanModal{{ $lsplan->id }}" tabindex="-1"
                                        aria-labelledby="editlsplanModalLabel{{ $lsplan->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editlsplanModalLabel">Edit
                                                        Class</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('superadmin.lsplans.update', $lsplan->id) }}"
                                                        method="POST" enctype="multipart/form-data">

                                                        <h3 class="mb-3">{{ $school->school_name }}</h3>

                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Class ID (Readonly jika tidak boleh diubah) -->
                                                        <div class="mb-3">
                                                            <label for="school_id" class="form-label">School
                                                                ID</label>
                                                            <input type="text" class="form-control bg-light"
                                                                id="school_id" name="school_id"
                                                                value="{{ $lsplan->school_id }}" readonly required>
                                                        </div>

                                                        <!-- Class ID -->
                                                        <div class="mb-3">
                                                            <label for="class_id" class="form-label">Class ID</label>
                                                            <select class="form-select" id="class_id" name="class_id"
                                                                required>
                                                                <option value="">Pilih Class</option>
                                                                @foreach ($classes as $class)
                                                                    <option value="{{ $class->class_id }}"
                                                                        {{ $lsplan->class_id == $class->class_id ? 'selected' : '' }}>
                                                                        {{ $class->class_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- User ID (Dropdown) -->
                                                        <div class="mb-3">
                                                            <label for="user_id" class="form-label">User</label>
                                                            <select class="form-select" id="user_id" name="user_id"
                                                                required>
                                                                <option value="">Pilih User</option>
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}"
                                                                        {{ old('user_id', $lsplan->user_id) == $user->id ? 'selected' : '' }}>
                                                                        {{ $user->fullname }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Title -->
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" value="{{ $lsplan->title }}" required>
                                                        </div>

                                                        <!-- Desc -->
                                                        <div class="mb-3">
                                                            <label for="desc" class="form-label">Description</label>
                                                            <textarea type="text" class="form-control" id="desc" name="desc" required>{{ $lsplan->desc }}</textarea>
                                                        </div>

                                                        <!-- File PDF -->
                                                        <div class="mb-3">
                                                            <label for="file_pdf" class="form-label fw-bold">File
                                                                PDF</label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control" id="file_pdf"
                                                                    name="file_pdf">
                                                            </div>
                                                            @if ($lsplan->file_pdf)
                                                                <div class="mt-2 p-2 border rounded bg-light">
                                                                    <p class="mb-1"><strong>File PDF saat ini:</strong>
                                                                    </p>
                                                                    <a href="{{ asset('storage/' . $lsplan->file_pdf) }}"
                                                                        target="_blank" class="btn btn-sm btn-primary">
                                                                        <i class="fas fa-eye"></i> Lihat PDF
                                                                    </a>
                                                                </div>
                                                            @endif
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
                            @endif
                        </tbody>
                    </table>
                    {{-- {{ $users->links() }} --}}
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD Class -->
    <div class="modal fade" id="addlsplanModal" tabindex="-1" aria-labelledby="addlsplanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addlsplanModalLabel">Add New Lesson Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.lsplans.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h3 class="mb-3">{{ $school->school_name }}</h3>
                        <div class="mb-3">
                            <label for="school_id" class="form-label">School ID</label>
                            <input type="text" value="{{ $school->school_id }}" class="form-control bg-light"
                                id="school_id" name="school_id" readonly required>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="class_id" class="form-label">Class Id</label>
                            <input type="text" class="form-control" id="class_id" name="class_id" required>
                        </div> --}}

                        <div class="mb-3">
                            <label for="class_id" class="form-label">Select Class</label>
                            <select name="class_id" id="class_id" class="form-control" required>
                                <option value="">-- Choose Class ID --</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="user_id" class="form-label">User Id</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" required>
                        </div> --}}

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">-- Choose User ID --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control" id="desc" name="desc" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file_pdf" class="form-label">File PDF</label>
                            <input type="file" class="form-control" id="file_pdf" name="file_pdf" required>
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
