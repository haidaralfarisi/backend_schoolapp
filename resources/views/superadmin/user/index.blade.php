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
                        Manage Your Users
                        {{-- <span>
                                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-custom-class="tooltip-success"
                                        data-bs-title="Traffic Overview"></iconify-icon>
                                </span> --}}
                    </h3>

                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <!-- FORM SEARCH -->
                        <form action="{{ route('users.search') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Cari user..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary ms-2"><i
                                    class="fas fa-search"></i></button>
                        </form>

                        <!-- ADD BUTTON -->
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="fas fa-plus"></i> Add User
                        </a>
                    </div>

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
                                <th>NIP</th>
                                <th>Full Name</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>Photo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td class="text-center">{{ $users->firstItem() + $index }}</td>
                                    {{-- <td class="text-center">{{ $loop->iteration }}</td> --}}
                                    <td>{{ $user->nip }}</td>
                                    <td>{{ $user->fullname }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @switch($user->level)
                                            @case('SUPERADMIN')
                                                <div class="d-flex align-items-center justify-content-center bg-danger px-2 py-1 rounded-3"
                                                    style="font-size: 0.75rem;">
                                                    <span class="text-white text-center">SUPERADMIN</span>
                                                </div>
                                            @break

                                            @case('GURU')
                                                <div class="d-flex align-items-center justify-content-center bg-info px-2 py-1 rounded-3"
                                                    style="font-size: 0.75rem;">
                                                    <span class="text-white text-center">GURU</span>
                                                </div>
                                            @break

                                            @case('TUSEKOLAH')
                                                <div class="d-flex align-items-center justify-content-center bg-danger px-2 py-1 rounded-3"
                                                    style="font-size: 0.75rem;">
                                                    <span class="text-white text-center">TU SEKOLAH</span>
                                                </div>
                                            @break

                                            @default
                                                <span class="badge bg-secondary">{{ $user->level }}</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        @if ($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="photo" width="50"
                                                height="50" class="rounded-circle">
                                        @else
                                            <span>No Photo</span>
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
                                                        data-bs-target="#editUserModal{{ $user->id }}">
                                                        <i class="fas fa-edit text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('superadmin.users.destroy', $user->id) }}"
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
                                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editUserForm"
                                                    action="{{ route('superadmin.users.update', ['id' => $user->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label for="fullname" class="form-label">Full Nama</label>
                                                        <input type="text" class="form-control" id="fullname"
                                                            name="fullname" value="{{ old('fullname', $user->fullname) }}"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="username" class="form-label">User Name</label>
                                                        <input type="text" class="form-control" id="username"
                                                            name="username" value="{{ old('username', $user->username) }}"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email"
                                                            name="email" value="{{ old('email', $user->email) }}"
                                                            required>
                                                    </div>

                                                    <div class="mb-3 position-relative">
                                                        <label for="level" class="form-label">Level</label>
                                                        <div class="position-relative">
                                                            <select class="form-control pe-5" id="level"
                                                                name="level" required>
                                                                <option value="SUPERADMIN"
                                                                    {{ old('level', $user->level) == 'SUPERADMIN' ? 'selected' : '' }}>
                                                                    SUPERADMIN</option>
                                                                <option value="KEUANGAN_PUSAT"
                                                                    {{ old('level', $user->level) == 'KEUANGAN_PUSAT' ? 'selected' : '' }}>
                                                                    KEUANGAN PUSAT</option>
                                                                <option value="TU_SEKOLAH"
                                                                    {{ old('level', $user->level) == 'TU_SEKOLAH' ? 'selected' : '' }}>
                                                                    TU SEKOLAH</option>
                                                                <option value="TU_KEUANGAN"
                                                                    {{ old('level', $user->level) == 'TU_KEUANGAN' ? 'selected' : '' }}>
                                                                    TU KEUANGAN</option>
                                                                <option value="GURU"
                                                                    {{ old('level', $user->level) == 'GURU' ? 'selected' : '' }}>
                                                                    GURU</option>
                                                                <option value="ORANG_TUA"
                                                                    {{ old('level', $user->level) == 'ORANG_TUA' ? 'selected' : '' }}>
                                                                    ORANG TUA</option>
                                                            </select>
                                                            <i class="fas fa-chevron-down position-absolute"
                                                                style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none;"></i>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="photo" class="form-label">Photo</label>
                                                        <input type="file" class="form-control" id="photo"
                                                            name="photo" onchange="previewImage(event)">
                                                        <img id="preview_photo"
                                                            src="{{ old('photo', $user->photo ? asset('storage/' . $user->photo) : asset('default.png')) }}"
                                                            alt="User Photo" class="mt-2" width="150">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="edit_password" class="form-label">Password</label>
                                                        <input type="password" class="form-control" id="edit_password"
                                                            name="password" placeholder="Leave blank if not changing">
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
                    <div class="d-flex justify-content-center">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD SCHOOL -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input placeholder="NIP" type="text" class="form-control" id="nip" name="nip"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input placeholder="Full Name" type="text" class="form-control" id="fullname"
                                name="fullname" required>
                        </div>
                        <div class="mb-3">
                            <label for="Username" class="form-label">User Name</label>
                            <input placeholder="User Name" type="text" class="form-control" id="Username"
                                name="Username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input placeholder="Email" type="text" class="form-control" id="email"
                                name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="" disabled selected>Pilih Level</option>
                                <option value="SUPERADMIN">SUPERADMIN</option>
                                <option value="KEUANGAN_PUSAT">KEUANGAN PUSAT</option>
                                <option value="TU_SEKOLAH">TU SEKOLAH</option>
                                <option value="TU_KEUANGAN">TU KEUANGAN</option>
                                <option value="GURU">GURU</option>
                                <option value="ORANG_TUA">ORANG TUA</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input placeholder="Password" type="password" class="form-control" id="password"
                                name="password" required>
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
