@extends('layouts.app')

@section('content')
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('partials.sidebar_guru')

        <!--  Main wrapper -->
        <div class="body-wrapper bg-white">

            <!--  NAVBAR -->
            @include('partials.navbar')

            <div class="container-fluid">

                <!-- HEADER & BUTTON -->
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        Manage your Data Photos
                        {{-- <span class="badge bg-primary">
                            {{ $class->class_id ?? 'No Class' }}
                        </span> --}}
                    </h3>

                    <!-- ADD BUTTON -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPhotoModal">
                        <i class="fas fa-plus"></i> Add Photo
                    </button>
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

                @if (is_null($userSchool))
                    <div class="alert alert-danger">
                        Anda belum memiliki relasi ke sekolah manapun. Silakan hubungi admin untuk mengatur relasi.
                    </div>
                @else
                    {{-- Tampilkan konten jika userSchool tidak null --}}
                    <h2>Daftar Foto</h2>

                    @if ($photos->isEmpty())
                        <p>Belum ada foto yang diunggah.</p>
                    @else
                        {{-- Loop foto --}}
                        @foreach ($photos as $photo)
                            <div>
                                <h3>{{ $photo->title }}</h3>
                                <img src="{{ asset('storage/' . $photo->image) }}" width="200">
                                <p>{{ $photo->description }}</p>
                            </div>
                        @endforeach
                    @endif
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="30">No</th>
                                <th>Title</th>
                                <th>Class</th>
                                <th>Photo</th>
                                <th>Photo type</th>
                                <th>Sub Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($photos->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <div class="py-4">
                                            <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                            <p class="mt-2 text-muted">Tidak ada data Photo.</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($photos as $photo)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $photo->title }}</td>
                                        <td>{{ $photo->classes->class_name }}</td>
                                        <td>
                                            @if ($photo->image)
                                                <img src="{{ asset('storage/' . $photo->image) }}" alt="photo"
                                                    width="50" height="30" class="rounded">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>
                                            @if ($photo->photo_type == 'public')
                                                <span class="badge rounded-pill bg-success px-3 py-2">
                                                    🌍 Public
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-danger px-3 py-2">
                                                    🔒 Private
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('guru.subphoto.index', $photo->id) }}"
                                                class="btn btn-primary btn-sm">Upload</a>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-warning btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Menu
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#editImageModal{{ $photo->id }}">
                                                            <i class="fas fa-edit text-primary"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('guru.photos.destroy', $photo->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus Photo ini?');">
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
                                    <div class="modal fade" id="editImageModal{{ $photo->id }}" tabindex="-1"
                                        aria-labelledby="editImageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content p-3 border-0 rounded-4">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editImageModalLabel">Edit Data Photo
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editFacilitasForm"
                                                        action="{{ route('guru.photos.update', ['id' => $photo->id]) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <input type="hidden" name="user_id" value="{{ $photo->user_id }}">
                                                        <input type="hidden" name="school_id"
                                                            value="{{ $photo->school_id }}">
                                                        <input type="hidden" name="class_id"
                                                            value="{{ $photo->class_id }}">

                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" value="{{ old('title', $photo->title) }}"
                                                                required>
                                                        </div>

                                                        <!-- Desc -->
                                                        <div class="mb-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea type="text" class="form-control" id="description" name="description" required>{{ $photo->description }}</textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="image" class="form-label">Photo</label>
                                                            <input type="file" class="form-control" name="image">

                                                            <img id="preview_photo"
                                                                src="{{ old('image', $photo->image ? asset('storage/' . $photo->image) : asset('default.png')) }}"
                                                                alt="User Photo" class="mt-2" width="150">
                                                        </div>

                                                        <!-- Photo Type -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Photo Type</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="photo_type" id="public" value="public"
                                                                    {{ $photo->photo_type == 'public' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="photo_public">
                                                                    🌍 Public
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="photo_type" id="private" value="private"
                                                                    {{ $photo->photo_type == 'private' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="photo_private">
                                                                    🔒 Private
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="location" class="form-label">lokasi</label>
                                                            <input type="text" class="form-control" id="location"
                                                                name="location"
                                                                value="{{ old('location', $photo->location) }}" required>
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
                    {{-- {{ $users->links() }} --}}
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD PHOTO -->
    <div class="modal fade" id="addPhotoModal" tabindex="-1" aria-labelledby="addPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPhotoModalLabel">Add New Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if ($userSchool)
                    <div class="modal-body">
                        <form action="{{ route('guru.photos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="user_id" value="{{ $userSchool->user_id }}">
                            <input type="hidden" name="school_id" value="{{ $userSchool->school_id }}">

                            <div class="mb-3">
                                <label for="class_id" class="form-label">Select Class</label>
                                <select name="class_id" id="class_id" class="form-control" required>
                                    <option value="">-- Choose Class --</option>
                                    @foreach ($teacherClass as $tc)
                                        <option value="{{ $tc->class_id }}">{{ $tc->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Photo Type</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="photo_type" id="public"
                                            value="public" checked>
                                        <label class="form-check-label" for="public">
                                            🌍 Public
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="photo_type" id="private"
                                            value="private">
                                        <label class="form-check-label" for="private">
                                            🔒 Private
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            </form>
                    </div>
                @else
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            Anda belum memiliki relasi ke sekolah manapun, sehingga tidak dapat mengunggah foto.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>

    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
@endsection

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
{{-- <script>
    $(document).ready(function () {
        // Ketika School dipilih, ambil daftar kelas berdasarkan school_id
        $('#school_id').change(function () {
            var schoolId = $(this).val();
            $('#class_id').empty().append('<option value="">-- Choose Class --</option>');
            $('#student_id').empty().append('<option value="">-- Choose Student --</option>');

            if (schoolId) {
                $.ajax({
                    url: "{{ route('superadmin.photos.getClasses') }}",
                    type: "GET",
                    data: { school_id: schoolId },
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#class_id').append('<option value="' + value.id + '">' + value.class_id + '</option>');
                        });
                    }
                });
            }
        });

        // Ketika Class dipilih, ambil daftar siswa berdasarkan class_id
        $('#class_id').change(function () {
            var classId = $(this).val();
            $('#student_id').empty().append('<option value="">-- Choose Student --</option>');

            if (classId) {
                $.ajax({
                    url: "{{ route('superadmin.photos.getStudents') }}",
                    type: "GET",
                    data: { class_id: classId },
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#student_id').append('<option value="' + value.id + '">' + value.student_id + '</option>');
                        });
                    }
                });
            }
        });
    });
</script> --}}
