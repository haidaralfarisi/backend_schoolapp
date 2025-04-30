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

                <div class="row">
                    <div class="col-lg-7">
                        <h5 class="mb-3">
                            Selamat Datang di <br> {{ @$userSchool->school->school_name }}
                        </h5>
                        @forelse ($teacherClasses as $ts)
                            <div class="card border shadow-sm bg-card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $ts->class_name }}</h5>
                                    @php
                                        $data_siswa = DB::table('students')->where('class_id', $ts->class_id)->get();
                                    @endphp
                                    <p class="card-text">Jumlah {{ $data_siswa->count() }} Siswa</p>
                                    <a href="{{ route('guru.students.index', $ts->class_id) }}"
                                        class="btn btn-primary">Lihat Siswa</a>
                                    <a href="{{ route('guru.lsplans.index', $ts->class_id) }}"
                                        class="btn btn-success">Lihat Lesson Plan</a>
                                </div>
                            </div>
                        @empty
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Data Kelas Kosong</h5>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <div class="col-lg-5">
                        <div class="card bg-dark shadow-sm rounded-3 border">
                            <div class="card-body p-2 scrollX">
                                @forelse ($photos as $photo)
                                    @php
                                        $guru = DB::table('users')->where('id', $photo->user_id)->first();
                                    @endphp
                                    <div class="p-3 bg-dark rounded-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="me-2">
                                                <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-pill border" height="50"
                                                    alt="">
                                            </div>
                                            <div>
                                                <div class="text-white fw-bold">{{ $guru->fullname }}</div>
                                                <div class="text-white">{{ $photo->class_id }}</div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <img src="{{ old('image', $photo->image ? asset('storage/' . $photo->image) : asset('default.png')) }}"
                                                alt="User Photo" class="rounded-3 mt-2" width="100%">
                                        </div>
                                    </div>
                                @empty
                                    tidak ada photo yang di post
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @include('partials.footer') --}}
        </div>
    </div>
@endsection
