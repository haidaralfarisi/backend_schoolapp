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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        Manage Your E-report
                        {{-- <span>
                                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-custom-class="tooltip-success"
                                        data-bs-title="Traffic Overview"></iconify-icon>
                                </span> --}}
                    </h3>

                    <!-- ADD BUTTON -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEreportModal">
                        <i class="fas fa-plus"></i> Add E-Reports
                    </a>

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

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30">No</th>
                            <th>School ID</th>
                            <th>Class ID</th>
                            <th>Student ID</th>
                            {{-- <th>User ID</th> --}}
                            <th>Tahun Ajaran</th>
                            <th>Report File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($ereports->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="py-4">
                                        <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                        <p class="mt-2 text-muted">Tidak ada data E-reports</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($ereports as $ereport)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $ereport->school->school_name }}</td>
                                    <td>{{ $ereport->classModel->class_name }}</td>
                                    <td>{{ $ereport->student->fullname }}</td>
                                    {{-- <td>{{ $ereport->user->fullname}}</td> --}}
                                    <td>{{ $ereport->tahunAjarans->title }}</td>
                                    <td>
                                        @if ($ereport->report_file)
                                            <a href="{{ asset('storage/' . $ereport->report_file) }}" target="_blank"
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
                                                        data-bs-target="#editEreportModal{{ $ereport->id }}">
                                                        <i class="fas fa-edit text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('guru.ereports.destroy', $ereport->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                                <div class="modal fade" id="editEreportModal{{ $ereport->id }}" tabindex="-1"
                                    aria-labelledby="editEreportModalLabel{{ $ereport->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editEreportModalLabel{{ $ereport->id }}">
                                                    Edit Data E-report
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('guru.ereports.update', $ereport->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="hidden" name="school_id"
                                                        value="{{ $ereport->school_id }}">
                                                    <input type="hidden" name="class_id" value="{{ $ereport->class_id }}">
                                                    <input type="hidden" name="user_id" value="{{ $ereport->user_id }}">

                                                    <div class="mb-3">
                                                        <label for="student_id" class="form-label">Student</label>
                                                        <select name="student_id" class="form-control" required>
                                                            <option value="">- Pilih Siswa -</option>
                                                            @foreach ($students as $student)
                                                                <option value="{{ $student->student_id }}"
                                                                    {{ $student->student_id == $ereport->student_id ? 'selected' : '' }}>
                                                                    {{ $student->fullname }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                                                        <select name="tahun_ajaran_id" class="form-control" required>
                                                            <option value="">- Pilih Tahun Ajaran -</option>
                                                            @foreach ($tahunAjarans as $tahunAjaran)
                                                                <option value="{{ $tahunAjaran->tahun_ajaran_id }}"
                                                                    {{ $tahunAjaran->tahun_ajaran_id == $ereport->tahun_ajaran_id ? 'selected' : '' }}>
                                                                    {{ $tahunAjaran->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="report_file" class="form-label fw-bold">E-Report
                                                            File</label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="report_file"
                                                                name="report_file">
                                                        </div>
                                                        @if ($ereport->report_file)
                                                            <div class="mt-2 p-2 border rounded bg-light">
                                                                <p class="mb-1"><strong>File PDF saat ini:</strong>
                                                                </p>
                                                                <a href="{{ asset('storage/' . $ereport->report_file) }}"
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

    <!-- MODAL ADD SCHOOL -->
    <div class="modal fade" id="addEreportModal" tabindex="-1" aria-labelledby="addEreportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEreportModalLabel">Add New E-Reports</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>{{ $teacherClass->school->school_name }}</h3>
                    <p>{{ $teacherClass->class_id }}</p>

                    <form action="{{ route('guru.ereports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="school_id" value="{{ $teacherClass->school->school_id ?? '' }}">
                        <input type="hidden" name="class_id" value="{{ $teacherClass->class_id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID</label>
                            <select name="student_id" class="form-control" required>
                                <option value="">- Pilih Siswa - </option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->student_id }}">{{ $student->fullname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran ID</label>
                            <select name="tahun_ajaran_id" class="form-control" required>
                                <option value="">- Pilih Tahun Ajaran -</option>
                                @foreach ($tahunAjarans as $tahunAjaran)
                                    <option value="{{ $tahunAjaran->tahun_ajaran_id }}">{{ $tahunAjaran->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="report_file" class="form-label">Report File</label>
                            <input type="file" class="form-control" id="report_file" name="report_file" required>
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
