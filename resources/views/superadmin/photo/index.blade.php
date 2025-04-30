@extends('layouts.app')

@section('content')
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('partials.sidebar_superadmin')

        <!--  Main wrapper -->
        <div class="body-wrapper bg-white">

            <!--  NAVBAR -->
            @include('partials.navbar')

            <div class="container-fluid">

                <!-- HEADER & BUTTON -->
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        Managae your Photos
                    </h3>

                    <!-- ADD BUTTON -->
                    {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPhotoModal">
                        <i class="fas fa-plus"></i> Add Photo
                    </button> --}}
                </div>

                <div>
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th width="30">No</th>
                                <th>Title</th>
                                <th>School ID</th>
                                <th>Class ID</th>
                                <th>Student ID</th>
                                <th>Photo</th>
                                <th>Description</th>
                                <th>Photo type</th>
                                <th>Location</th>
                                {{-- <th>Aksi</th> --}}
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
                                @foreach ($photos as $index => $photo)
                                    <tr>
                                        <td class="text-center">{{ $photos->firstItem() + $index }}</td>

                                        {{-- @foreach ($photos as $photo)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td> --}}
                                        <td>{{ $photo->title }}</td>
                                        <td>{{ $photo->school->school_name }}</td>
                                        <td>{{ $photo->class_id }}</td>
                                        <td>{{ $photo->student?->fullname ?? '-' }}</td>

                                        <td>
                                            @if ($photo->image)
                                                <img src="{{ asset('storage/' . $photo->image) }}" alt="photo"
                                                    width="50" height="50" class="rounded-circle">
                                            @else
                                                No Image
                                            @endif
                                        </td>

                                        <td>{{ $photo->description }}</td>

                                        <td>
                                            @if ($photo->photo_type == 'public')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-globe"></i> Public
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-lock"></i> Private
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $photo->location }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $photos->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
@endsection
