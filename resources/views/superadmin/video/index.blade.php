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
                        Manage Your Video
                    </h3>

                    <!-- ADD BUTTON -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVideoModal">
                        <i class="fas fa-plus"></i> Add Video
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
                            <th>Title</th>
                            <th>School ID</th>
                            <th>Class ID</th>
                            <th>Description</th>
                            <th>Url</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($videos->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="py-4">
                                        <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                        <p class="mt-2 text-muted">Tidak ada data Video.</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($videos as $index => $video)
                                <tr>
                                    <td class="text-center">{{ $videos->firstItem() + $index }}</td>
                                    <td class="text-nowrap">{{ $video->title }}</td>
                                    <td class="text-nowrap">{{ $video->school->school_name ?? '-' }}</td>
                                    <td>{{ $video->class_id ?? 'N/A' }}</td>
                                    <td class="text-nowrap">{{ $video->description }}</td>
                                    <td>
                                        <a href="{{ $video->url }}" target="_blank"
                                            class="btn btn-sm btn-danger d-inline-flex align-items-center">
                                            <i class="fab fa-youtube me-2"></i> Tonton Video
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
                                                        data-bs-target="#editVideoModal{{ $video->id }}">
                                                        <i class="fas fa-edit text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('superadmin.videos.destroy', $video->id) }}"
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
                                <div class="modal fade" id="editVideoModal{{ $video->id }}" tabindex="-1"
                                    aria-labelledby="editVideoModalLabel{{ $video->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editVideoModalLabel{{ $video->id }}">
                                                    Edit Data Video
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('superadmin.videos.update', $video->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Title -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Title</label>
                                                        <input type="text" class="form-control" name="title"
                                                            value="{{ $video->title }}" required>
                                                    </div>

                                                    <!-- School ID -->
                                                    <div class="mb-3">
                                                        <label for="school_id" class="form-label">School</label>
                                                        <select class="form-select" id="school_id" name="school_id"
                                                            required>
                                                            <option value="" disabled>Pilih Nama Sekolah</option>
                                                            @foreach ($schools as $school)
                                                                <option value="{{ $school->school_id }}"
                                                                    {{ $video->school_id == $school->school_id ? 'selected' : '' }}>
                                                                    {{ $school->school_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Class ID -->
                                                    <div class="mb-3">
                                                        <label for="class_id" class="form-label">Class</label>
                                                        <select class="form-select" id="class_id" name="class_id" required>
                                                            <option value="" disabled>Pilih Nama Class</option>
                                                            @foreach ($classModel as $class)
                                                                <option value="{{ $class->class_id }}"
                                                                    {{ $video->class_id == $class->class_id ? 'selected' : '' }}>
                                                                    {{ $class->class_id }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Description -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Description</label>
                                                        <textarea class="form-control" name="description" rows="4">{{ old('description', $video->description) }}</textarea>
                                                    </div>

                                                    <!-- URL -->
                                                    <div class="mb-3">
                                                        <label class="form-label">URL</label>
                                                        <input type="text" class="form-control" name="url"
                                                            value="{{ old('url', $video->url) }}" required>
                                                    </div>

                                                    <!-- Modal Footer -->
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

                <div class="d-flex justify-content-center">
                    {{ $videos->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD VIDEO -->
    <div class="modal fade" id="addVideoModal" tabindex="-1" aria-labelledby="addVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVideoModalLabel">Add New Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.videos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="school_id" class="form-label">School</label>
                            <select class="form-control" id="school_id" name="school_id" required>
                                <option value="">-- Select School --</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->school_id }}">{{ $school->school_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select class="form-control" id="class_id" name="class_id" required>
                                <option value="">-- Select Class --</option>
                                @foreach ($classModel as $class)
                                    <option value="{{ $class->class_id }}">{{ $class->class_id }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="text" class="form-control" id="url" name="url" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
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

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('change', '#school_id', function() {
            var schoolId = $(this).val();
            console.log("School ID Selected:", schoolId); // Debugging

            $('#class_id').empty().append('<option value="">-- Pilih Kelas --</option>');

            if (schoolId) {
                $.ajax({
                    url: "{{ route('superadmin.videos.getClasses') }}",
                    type: "GET",
                    data: {
                        school_id: schoolId
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log("Response Data:", data); // Debugging

                        $.each(data, function(index, classItem) {
                            $('#class_id').append('<option value="' + classItem
                                .class_id + '">' + classItem.class_name +
                                '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error("AJAX Error:", xhr.responseText);
                    }
                });
            }
        });
    });
</script> --}}
