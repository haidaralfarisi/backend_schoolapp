@extends('layouts.app')

@section('content')
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!--  SIDEBAR -->
        @include('partials.sidebar_tusekolah')

        <!--  Main wrapper -->
        <div class="body-wrapper bg-white">

            <!--  NAVBAR -->
            @include('partials.navbar')

            <div class="container-fluid">
                <!-- HEADER & BUTTON -->
                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                        Manage Your Students
                    </h3>

                    <!-- ADD BUTTON -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                        <i class="fas fa-plus"></i> Add Student
                    </a>
                </div>
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30">No</th>
                            <th>Student ID</th>
                            <th>NISN</th>
                            <th>Full Name</th>
                            {{-- <th>User Name</th> --}}
                            {{-- <th>Gender</th> --}}
                            {{-- <th>Place Of Birth</th> --}}
                            {{-- <th>Date Of Birthday</th> --}}
                            {{-- <th>School ID</th> --}}
                            <th>Class ID</th>
                            <th>Entry Year</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($students->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="py-4">
                                        <img src="{{ asset('assets/icons/close.png') }}" alt="No Data" width="40">
                                        <p class="mt-2 text-muted">Tidak ada data Siswa.</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($students as $student)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->nisn }}</td>
                                    <td>{{ $student->fullname }}</td>
                                    {{-- <td>{{ $student->username }}</td> --}}
                                    {{-- <td>{{ $student->gender }}</td> --}}
                                    {{-- <td>{{ $student->pob }}</td> --}}
                                    {{-- <td>{{ $student->dob }}</td> --}}
                                    {{-- <td>{{ $student->school ? $student->school->name_school : 'N/A' }}</td> --}}
                                    <td>{{ $student->class ? $student->class->class_id : 'N/A' }}</td>
                                    <td>{{ $student->entry_year }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Menu
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editStudentModal{{ $student->id }}">
                                                        <i class="fas fa-edit text-primary"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1"
                                    aria-labelledby="editStudentModalLabel{{ $student->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editStudentModalLabel{{ $student->id }}">
                                                    Edit Data Siswa
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('tusekolah.students.update', $student->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Lengkap</label>
                                                        <input type="text" class="form-control" name="fullname"
                                                            value="{{ $student->fullname }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NISN</label>
                                                        <input type="text" class="form-control" name="nisn"
                                                            value="{{ $student->nisn }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Full Name</label>
                                                        <input type="text" class="form-control" name="fullname"
                                                            value="{{ $student->fullname }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" class="form-control" name="username"
                                                            value="{{ $student->username }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="class_id" class="form-label">Class ID</label>
                                                        <select class="form-control" id="class_id" name="class_id"
                                                            required>
                                                            <option value="">-- Pilih Kelas --</option>
                                                            @foreach ($schoolClasses as $class)
                                                                <option value="{{ $class->id }}"
                                                                    {{ old('class_id', $student->class_id ?? '') == $class->id ? 'selected' : '' }}>
                                                                    {{ $class->class_id }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label class="form-label">Gender</label>
                                                        <select class="form-control" name="gender" required>
                                                            <option value="">-- Pilih Gender --</option>
                                                            <option value="Laki-Laki"
                                                                {{ $student->gender == 'Laki-Laki' ? 'selected' : '' }}>
                                                                Laki-Laki</option>
                                                            <option value="Perempuan"
                                                                {{ $student->gender == 'Perempuan' ? 'selected' : '' }}>
                                                                Perempuan</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Date of Birthday</label>
                                                        <input type="date" class="form-control" name="entry_year"
                                                            value="{{ $student->dob }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Place of Born</label>
                                                        <input type="text" class="form-control" name="entry_year"
                                                            value="{{ $student->pob }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Tahun Masuk</label>
                                                        <input type="number" class="form-control" name="entry_year"
                                                            value="{{ $student->entry_year }}" required>
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
    <div class="modal fade" id="addSchoolModal" tabindex="-1" aria-labelledby="addSchoolModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSchoolModalLabel">Add New School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="student_id" name="student_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" required>
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="school_id" class="form-label">Pilih Sekolah</label>
                            <input type="text" class="form-control" name="school_id" readonly value="{{ $school->name_school }}">
                            {{-- <select name="school_id" id="school_id" class="form-control">
                                <option value="">-- Pilih Sekolah --</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name_school }}</option>
                                @endforeach
                            </select> --}}
                        </div>    
                        

                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class ID</label>
                            <select class="form-control" id="class_id" name="class_id" required>
                                <option value="">-- Select Class --</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">-- Pilih Gender --</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pob" class="form-label">Place Of Birth</label>
                            <input type="text" class="form-control" id="pob" name="pob" required>
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date Of Birthday</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <div class="mb-3">
                            <label for="entry_year" class="form-label">Entry Year</label>
                            <input type="number" class="form-control" id="entry_year" name="entry_year" min="2000"
                                max="2100" step="1" placeholder="YYYY" required>
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
        // Ketika School dipilih, ambil daftar kelas berdasarkan school_id
        $('#school_id').change(function() {
            var schoolId = $(this).val();
            $('#class_id').empty().append('<option value="">-- Choose Class --</option>');
            $('#student_id').empty().append('<option value="">-- Choose Student --</option>');

            if (schoolId) {
                $.ajax({
                    url: "{{ route('tusekolah.students.getClasses') }}",
                    type: "GET",
                    data: {
                        school_id: schoolId
                    },
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#class_id').append('<option value="' + value.id +
                                '">' + value.class_id + '</option>');
                        });
                    }
                });
            }
        });
    });
</script> --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var selectedSchoolId = $('#school_id').val();
        var selectedClassId = "{{ $student->class_id ?? '' }}";

        // Fungsi untuk mengambil data kelas berdasarkan school_id
        function loadClasses(school_id, selectedClassId = '') {
            if (school_id) {
                $.ajax({
                    url: "{{ route('tusekolah.students.getClasses') }}",
                    type: "GET",
                    data: {
                        school_id: school_id
                    },
                    success: function(data) {
                        $('#class_id').empty().append(
                            '<option value="">-- Pilih Kelas --</option>');
                        $.each(data, function(key, value) {
                            $('#class_id').append('<option value="' + value.id + '" ' +
                                (value.id == selectedClassId ? 'selected' : '') + '>' +
                                value.class_id + '</option>');
                        });
                    }
                });
            } else {
                $('#class_id').empty().append('<option value="">-- Pilih Kelas --</option>');
            }
        }

        // Panggil fungsi saat halaman dimuat jika ada school_id
        if (selectedSchoolId) {
            loadClasses(selectedSchoolId, selectedClassId);
        }

        // Panggil fungsi saat dropdown school_id berubah
        $('#school_id').change(function() {
            var school_id = $(this).val();
            loadClasses(school_id);
        });
    });
</script>
