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
                        Manage Your Delight
                    </h3>

                    <!-- ADD BUTTON -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDelightModal">
                        <i class="fas fa-plus"></i> Add Delight
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
                            <th>Description</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($delights->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="py-4">
                                        <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                        <p class="mt-2 text-muted">Tidak ada data Delight</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($delights as $index => $delight)
                                <tr>
                                    <td class="text-center">{{ $delights->firstItem() + $index }}</td>
                                    {{-- <td class="text-center">{{ $loop->iteration }}</td> --}}
                                    <td>{{ $delight->title }}</td>
                                    <td>{{ $delight->description }}</td>
                                    <td>
                                        @if ($delight->file)
                                            <a href="{{ asset('storage/' . $delight->file) }}" target="_blank"
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
                                                        data-bs-target="#editDelightModal{{ $delight->id }}">
                                                        <i class="fas fa-edit text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('superadmin.delight.destroy', $delight->id) }}"
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
                                <div class="modal fade" id="editDelightModal{{ $delight->id }}" tabindex="-1"
                                    aria-labelledby="editDelightModalLabel{{ $delight->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h5 class="modal-title" id="editDelightModalLabel{{ $delight->id }}">
                                                    Edit Data Delight
                                                </h5>

                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('superadmin.delight.update', $delight->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Title -->
                                                    <div class="mb-3">
                                                        <label for="title" class="form-label">Title</label>
                                                        <input type="text" class="form-control" id="title"
                                                            name="title" value="{{ $delight->title }}" required>
                                                    </div>

                                                    <!-- Desc -->
                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Description</label>
                                                        <textarea type="text" class="form-control" id="description" name="description" required>{{ $delight->description }}</textarea>
                                                    </div>

                                                    <!-- File PDF -->
                                                    <div class="mb-3">
                                                        <label for="file" class="form-label fw-bold">File
                                                            PDF</label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="file"
                                                                name="file">
                                                        </div>
                                                        @if ($delight->file)
                                                            <div class="mt-2 p-2 border rounded bg-light">
                                                                <p class="mb-1"><strong>File PDF saat ini:</strong>
                                                                </p>
                                                                <a href="{{ asset('storage/' . $delight->file) }}"
                                                                    target="_blank" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-eye"></i> Lihat PDF
                                                                </a>
                                                            </div>
                                                        @endif
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
                    {{ $delights->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD SCHOOL INFO -->
    <div class="modal fade" id="addDelightModal" tabindex="-1" aria-labelledby="addDelightModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDelightModalLabel">Add New Delight</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.delight.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" placeholder="Title" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" placeholder="Description" id="description" name="description" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="file" class="form-control" id="file" name="file" required>
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

                        $.each(data, function(index, classitem) {
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
