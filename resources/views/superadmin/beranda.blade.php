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
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <a href="{{ route('superadmin.schools.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">🏫</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">Total Sekolah</h5>
                                        <p class="fs-4 fw-bold mb-0">{{ $schoolCounts }} Sekolah</p>
                                        <small class="text-dark-50">Data aktif di sistem 💡</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>



                    <div class="col-md-4">
                        <a href="{{ route('superadmin.schools.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">📚</span> {{-- Emoji untuk kelas --}}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">Jumlah Kelas</h5>
                                        <p class="fs-4 fw-bold mb-0">{{ $classCounts }} Kelas</p>
                                        <small class="text-dark-50">Unit belajar aktif 🎒</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="{{ route('superadmin.schools.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">📝</span> {{-- Emoji untuk Lesson Plan --}}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">Jumlah Lesson Plan</h5>
                                        <p class="fs-4 fw-bold mb-0">{{ $lscounts }} Lesson Plan</p>
                                        <small class="text-dark-50">Rencana pembelajaran aktif 📘</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


                <div class="row mb-4">
                    <div class="col-md-3">
                        <a href="{{ route('superadmin.users.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">👥</span> {{-- Emoji User --}}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">Total User</h5>
                                        <p class="fs-4 fw-bold text-primary mb-0">{{ $userCount }}</p>
                                        <small class="text-dark-50">User terdaftar 🧾</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-md-3">
                        <a href="{{ route('superadmin.users.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">👨‍🏫</span> {{-- Emoji Guru --}}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">Jumlah Guru</h5>
                                        <p class="fs-4 fw-bold text-dark mb-0">{{ $guruCount }}</p>
                                        <small class="text-dark-50">Guru aktif 📖</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-md-3">
                        <a href="{{ route('superadmin.schools.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #a1ffce 0%, #faffd1 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">🧑‍🎓</span> {{-- Emoji Siswa --}}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">Jumlah Siswa</h5>
                                        <p class="fs-4 fw-bold text-info mb-0">{{ $siswaCount }}</p>
                                        <small class="text-dark-50">Data siswa terdaftar 📚</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-md-3">
                        <a href="{{ route('superadmin.parent.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #c2e9fb 0%, #a1c4fd 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">👨‍👩‍👧‍👦</span> {{-- Emoji Parents --}}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">Jumlah Wali</h5>
                                        <p class="fs-4 fw-bold text-dark mb-0">{{ $orangtuaCount }}</p>
                                        <small class="text-dark-50">Wali siswa aktif 👪</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                    {{-- <div class="col-md-3">
                        <div class="card border shadow-sm bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-dark">Photo</h5>
                                <p class="fs-4 fw-bold text-warning mb-0">{{ $photoCounts }}</p>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-md-3">
                        <a href="{{ route('superadmin.photos.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">📸</span> {{-- Emoji Photo --}}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">Jumlah Foto</h5>
                                        <p class="fs-4 fw-bold text-dark mb-0">{{ $photoCounts }}</p>
                                        <small class="text-dark-50">Foto kegiatan 🖼️</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('superadmin.videos.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #fddb92 0%, #d1fdff 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">🎬</span> {{-- Emoji Video --}}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">Jumlah Video</h5>
                                        <p class="fs-4 fw-bold text-dark mb-0">{{ $videoCounts }}</p>
                                        <small class="text-dark-50">Video kegiatan 📺</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('superadmin.videos.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #fddb92 0%, #d1fdff 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">📰</span> {{-- Emoji Video --}}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">School Info</h5>
                                        <p class="fs-4 fw-bold text-dark mb-0">{{ $schoolinfoCounts }}</p>
                                        <small class="text-dark-50">School Info ❗</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('superadmin.delight.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 text-dark mb-4 hover-card"
                                style="background: linear-gradient(135deg, #fddb92 0%, #d1fdff 100%);">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <span style="font-size: 2rem;">📗</span> {{-- Emoji Video --}}
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 fw-semibold">Jumlah Delight</h5>
                                        <p class="fs-4 fw-bold text-dark mb-0">{{ $delightCounts }}</p>
                                        <small class="text-dark-50">Delight 📖</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
@endsection
