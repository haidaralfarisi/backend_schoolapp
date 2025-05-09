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

                @if ($data_kelas->isEmpty())
                    <div class="alert alert-danger">
                        @if (!$userSchool)
                        Anda belum memiliki relasi ke sekolah manapun. Silakan hubungi admin untuk mengatur relasi.
                        @else
                            Tidak ada relasi ke <code>teacher_class</code>.
                        @endif
                    </div>
                @endif

                {{-- @if (!$hasRelasi)
                    <div class="alert alert-warning">
                        Tidak ada relasi ke <code>teacher_class</code>.
                    </div>
                @endif --}}

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="30">No</th>
                                <th>Class ID</th>
                                <th>Class Name</th>
                                <th>Grade</th>
                                <th></th>
                                <th></th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data_kelas->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <div class="py-4">
                                            <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                            <p class="mt-2 text-muted">Tidak ada data Class</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @if (!$hasRelasi)
                                    <div class="alert alert-warning">
                                        Tidak ada relasi ke <code>teacher_class</code>.
                                    </div>
                                @endif
                                @foreach ($data_kelas as $kelas)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $kelas->class_id }}</td>
                                        <td>{{ $kelas->class_name }}</td>
                                        <td>{{ $kelas->grade }}</td>
                                        <td>
                                            <a href="{{ route('guru.students.index', $kelas->class_id) }}">
                                                <i class="fas fa-user-graduate text-info"></i> Student
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('guru.lsplans.index', $kelas->class_id) }}">
                                                <i class="fas fa-book text-info"></i> Lesson Plan
                                            </a>
                                        </td>
                                        {{-- <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Menu
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#editClassModal{{ $kelas->id }}">
                                                            <i class="fas fa-edit text-primary"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('tusekolah.classes.destroy', $kelas->class_id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                    {{-- <div class="d-flex justify-content-center">
                        {{ $kelas->links('pagination::bootstrap-5') }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
@endsection
