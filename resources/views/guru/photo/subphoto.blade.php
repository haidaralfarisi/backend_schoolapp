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

                <!-- Breadcrumbs -->
                <div class="d-flex align-items-center mb-3">
                    <i class="fa-solid fa-house text-primary me-3"></i>
                    <i class="fa-solid fa-chevron-left text-primary me-3"></i>
                    <a href="#" onclick="window.location.href='{{ route('guru.photos.index') }}'"
                        class="text-decoration-none text-primary me-3">Photos</a>
                </div>
                <!-- Breadcrumbs -->

                <!-- HEADER & BUTTON -->
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        Manage your Data Photos
                    </h3>

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

                {{-- Data --}}
                <form action="{{ route('guru.subphoto.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="photo_id" value="{{ $photo->id }}">
                    <div class="mb-3">
                        <label for="">Upload Photo (Max:20 images only)</label>
                        <input type="file" multiple name="images[]" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>

                <div class="card bg-white p-3 shadow rounded-3">
                    <div class="card-body">
                        <div class="mb-3 fw-bold">Data Sub Photo</div>
                        @foreach ($subphoto as $sub)
                            <div class="me-2 mb-2 border rounded-3 position-relative">
                                <img src="{{ asset('storage/subphoto/' . $sub->image) }}" alt="Sub Photo" height="150"
                                    class="rounded-3">
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                                    <form action="{{ route('guru.subphoto.destroy', $sub->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus Photo ini?');">
                                        @csrf
                                        <input type="hidden" name="dsubphoto_id" value="{{ $sub->id }}">
                                        <button type="submit" class="btn btn-trasparent">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
@endsection
