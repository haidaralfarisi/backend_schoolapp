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
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">

                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        Manage Your Lesson Plan
                        <span class="badge bg-primary">
                            {{ $class->class_id ?? 'No Class' }}
                        </span>
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

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>    
                                <th width="30">No</th>
                                {{-- <th>School ID</th> --}}
                                <th>Class ID</th>
                                <th>User ID</th>
                                <th>Title</th>
                                <th>File PDF</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($lessonplans->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                            <p class="mt-2 text-muted">Tidak ada data Lesson Plan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($lessonplans as $lsplan)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        {{-- <td>{{ $lsplan->school->school_name }}</td> --}}
                                        <td>{{ $lsplan->class_id }}</td>
                                        <td>{{ $lsplan->user->fullname }}</td>
                                        <td>{{ $lsplan->title }}</td>
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
                                                        <form action="{{ route('guru.lsplans.destroy', $lsplan->id) }}"
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

                                    <!-- Modal Untuk Edit lesson plan-->
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
                                                    <form action="{{ route('guru.lsplans.update', $lsplan->id) }}"
                                                        method="POST" enctype="multipart/form-data">


                                                        @csrf
                                                        @method('PUT')

                                                        <!-- School ID (Readonly jika tidak boleh diubah) -->
                                                        <div class="mb-3">
                                                            <label for="school_id" class="form-label">School
                                                                ID</label>
                                                            <input type="text" class="form-control bg-light"
                                                                id="school_id" name="school_id"
                                                                value="{{ $lsplan->school->school_name }}" readonly
                                                                required>
                                                            <input type="hidden" name="school_id"
                                                                value="{{ $lsplan->school_id }}">
                                                        </div>

                                                        <!-- Class ID -->
                                                        <div class="mb-3">
                                                            <label for="class_id" class="form-label">Class</label>
                                                            <input type="text" class="form-control bg-light"
                                                                value="{{ $lsplan->classes->class_name }}" readonly>
                                                            <input type="hidden" name="class_id"
                                                                value="{{ $lsplan->class_id }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="user_id" class="form-label">User</label>
                                                            <input type="text" class="form-control bg-light"
                                                                value="{{ $lsplan->user->fullname }}" readonly>
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $lsplan->user_id }}">
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
                <form action="{{ route('guru.lsplans.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addlsplanModalLabel">Add New Lesson Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- School ID --}}
                        <div class="mb-3">
                            <label for="school_name" class="form-label">School</label>
                            <input type="text" id="school_name"
                                value="{{ $school->school_name ?? 'Unknown School' }}" class="form-control bg-light"
                                readonly>

                            <!-- Hidden input untuk submit school_id -->
                            <input type="hidden" name="school_id" value="{{ $school->school_id ?? '' }}">
                        </div>


                        {{-- Class ID --}}
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class ID</label>
                            <input type="text" name="class_id" id="class_id" value="{{ $class->class_id ?? '' }}"
                                class="form-control bg-light" readonly required>
                        </div>

                        {{-- User ID --}}
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control" id="desc" name="desc" rows="4" required></textarea>
                        </div>

                        {{-- File PDF --}}
                        <div class="mb-3">
                            <label for="file_pdf" class="form-label">File PDF</label>
                            <input type="file" class="form-control" id="file_pdf" name="file_pdf" required>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
@endsection
