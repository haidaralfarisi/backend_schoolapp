<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
</head>

<body>
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
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                                Traffic Overviews
                                <span>
                                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-custom-class="tooltip-success"
                                        data-bs-title="Traffic Overview"></iconify-icon>
                                </span>
                            </h5>
                            <div id="traffic-overview"></div>
                        </div>
                    </div>
                </div>
                @include('partials.footer')
            </div>
        </div>
    @endsection
</body>

</html>
