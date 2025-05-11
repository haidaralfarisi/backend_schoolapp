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
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3 flex-wrap">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        Manage Your Parents Students
                    </h3>
                
                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <!-- FORM SEARCH -->
                        <form action="{{ route('parents.search') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Cari orangtua..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary ms-2"><i class="fas fa-search"></i></button>
                        </form>
                
                        <!-- ADD BUTTON -->
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addParentModal">
                            <i class="fas fa-plus"></i> Add Parents
                        </a>

                        <!-- Import Button -->
                        <a href="#" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#importParentsModal">
                            <i class="fas fa-file-import"></i> Import Parents
                        </a>
                    </div>
                </div>
                

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th width="30">No</th>
                                {{-- <th>NIP</th> --}}
                                <th>Full Name</th>
                                {{-- <th>Email</th> --}}
                                <th>User Name</th>
                                <th>Level</th>
                                {{-- <th>Student</th> --}}
                                {{-- <th>Photo</th> --}}
                                <th width="300">Assign Student</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parents as $index => $parent)
                                <tr>
                                    <td class="text-center">{{ $parents->firstItem() + $index }}</td>
                                    {{-- <td>{{ $user->nip }}</td> --}}
                                    <td>{{ $parent->fullname }}</td>
                                    {{-- <td>{{ $user->email }}</td> --}}
                                    <td>{{ $parent->username }}</td>
                                    <td>{{ $parent->level }}</td>
                                    <td>
                                        <div class="d-flex align-items-center flex-wrap">
                                            @foreach ($parent->students as $student)
                                                <div class="d-flex align-items-center bg-info p-2 rounded-3 mb-2">
                                                    <span class="text-white me-2">{{ $student->student_id }} -
                                                        {{ $student->fullname }}</span>
                                                    <!-- Form hanya untuk menghapus hubungan student dengan parent -->
                                                    <form
                                                        action="{{ route('parents.removeStudent', [$parent->id, $student->id]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini dari orangtua?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn bg-transparent btn-sm p-0 rounded-2">
                                                            <i class="fa-solid fa-delete-left text-warning fa-xl"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <button class="btn btn-success rounded-3" data-bs-toggle="modal"
                                                data-bs-target="#editparentModal{{ $parent->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <a class="btn btn-info rounded-3" href="#"
                                                data-bs-target="#assignParentModal{{ $parent->id }}"
                                                data-bs-toggle="modal">
                                                <i class="fa-solid fa-square-plus"></i>
                                            </a>

                                            <form action="{{ route('superadmin.parent.destroy', $parent->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger rounded-3">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    <div class="modal fade" id="assignParentModal{{ $parent->id }}" tabindex="-1"
                                        aria-labelledby="editParentModalLabel{{ $parent->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content p-3 border-0 rounded-4">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editParentModalLabel">Edit Anak dari
                                                        {{ $parent->fullname }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ route('parents.updateStudents', parameters: $parent->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('POST')

                                                        <!-- Full Name Orangtua (readonly) -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Orangtua</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $parent->fullname }}" readonly>
                                                        </div>

                                                        <!-- Select Multiple Student ID -->
                                                        <div id="studentDropdowns">
                                                            @foreach ($parent->students as $student)
                                                                <div class="input-group mb-2 student-select-row">
                                                                    <select name="student_ids[]" class="form-select select2">
                                                                        <option value="">-- Pilih Siswa --</option>
                                                                        @foreach ($students as $s)
                                                                            <option value="{{ $s->id }}" {{ $s->id == $student->id ? 'selected' : '' }}>
                                                                                {{ $s->student_id }} - {{ $s->fullname }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <button type="button" class="btn btn-danger ms-2 remove-row"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                            @endforeach
                                                        
                                                            {{-- Row kosong untuk tambah baru --}}
                                                            <div class="input-group mb-2 student-select-row">
                                                                <select name="student_ids[]" class="form-select select2">
                                                                    <option value="">-- Pilih Siswa --</option>
                                                                    @foreach ($students as $student)
                                                                        <option value="{{ $student->id }}">
                                                                            {{ $student->student_id }} - {{ $student->fullname }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <button type="button" class="btn btn-danger ms-2 remove-row"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                        </div>
                                                        

                                                        <!-- Tombol tambah -->
                                                        <button type="button" class="btn btn-secondary mt-2"
                                                            id="addDropdown"><i class="fa fa-plus"></i> Tambah
                                                            Siswa</button>


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

                                </tr>

                                <!-- Modal Untuk Edit User-->
                                {{-- Modal harus di dalam foreach dan harus meletakkan {{ $user->id }} agar bisa di panggil sesuai id yang
                                        di inginkan --}}
                                <div class="modal fade" id="editparentModal{{ $parent->id }}" tabindex="-1"
                                    aria-labelledby="editUserModalLabel{{ $parent->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editparentModalLabel">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editUserForm"
                                                    action="{{ route('superadmin.parent.update', ['id' => $parent->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label for="fullname" class="form-label">FUll Name</label>
                                                        <input type="text" class="form-control" id="fullname"
                                                            name="fullname"
                                                            value="{{ old('fullname', $parent->fullname) }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="username" class="form-label">User Name</label>
                                                        <input type="text" class="form-control" id="username"
                                                            name="username"
                                                            value="{{ old('username', $parent->username) }}" required>
                                                    </div>

                                                    <div class="mb-3 position-relative">
                                                        <label for="level" class="form-label">Level</label>
                                                        <input type="text" class="form-control bg-light"
                                                            id="level" name="level" value="ORANGTUA" readonly>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label for="photo" class="form-label">Photo</label>
                                                        <input type="file" class="form-control" id="photo"
                                                            name="photo" onchange="previewImage(event)">
                                                        <img id="preview_photo"
                                                            src="{{ old('photo', $parent->photo ? asset('storage/' . $parent->photo) : asset('default.png')) }}"
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
                        {{ $parents->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ADD SCHOOL -->
    <div class="modal fade" id="addParentModal" tabindex="-1" aria-labelledby="addParentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addParentModalLabel">Add New Parents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.parent.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input placeholder="Full Name" type="text" class="form-control" id="fullname"
                                name="fullname" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">User Name</label>
                            <input placeholder="Username" type="text" class="form-control" id="username"
                                name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <input type="text" class="form-control bg-light" id="level" name="level"
                                value="ORANGTUA" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo">
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

    <div class="modal fade" id="importParentsModal" tabindex="-1" aria-labelledby="importParentsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importParentsModalLabel">
                        <i class="fas fa-file-excel"></i> Import Parents from Excel
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-2 mb-3">
                        <a href="{{ route('template.parent') }}" class="btn btn-info text-white">
                            <i class="fas fa-download"></i> Download Template
                        </a>
                    </div>
                    <form id="importStudentsForm" action="{{ route('import.parents') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold">Upload Excel File</label>
                            <input type="file" class="form-control" name="file" id="file"
                                accept=".xls, .xlsx" required>
                            <small class="text-muted">Only .xls or .xlsx files allowed.</small>
                        </div>
                        <div id="uploadProgress" class="progress d-none">
                            <div id="uploadBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                style="width: 0%">0%</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- FontAwesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('#assignParentModal').on('shown.bs.modal', function() {
            $('#user_id').select2({
                placeholder: 'Pilih Murid',
                allowClear: true,
                dropdownParent: $('#assignParentModal'),
                ajax: {
                    url: '{{ route('students.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                }
            });
        });
    </script> --}}

    <script>
        document.getElementById('addDropdown').addEventListener('click', function() {
            const container = document.getElementById('studentDropdowns');
            const clone = container.querySelector('.student-select-row').cloneNode(true);
            clone.querySelector('select').selectedIndex = 0;
            container.appendChild(clone);
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                const row = e.target.closest('.student-select-row');
                const rows = document.querySelectorAll('.student-select-row');
                if (rows.length > 1) row.remove();
            }
        });
    </script>
@endsection
