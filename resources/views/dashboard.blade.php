@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')

<div class="page-heading">

    <h1>Dashboard</h1>

    <p>
        Welcome to PICKnPACK inventory and distribution management.
    </p>

</div>


<!-- ==========================================================
     SHIPMENT MANAGEMENT
=========================================================== -->

<div class="dashboard-card mb-4">

    <div class="mb-4">

        <h4 class="mb-1">
            Shipment Management
        </h4>

        <p class="text-muted mb-0">
            Create new shipment or confirm pending incoming stock.
        </p>

    </div>


    <div class="row g-4">

        <!-- Create shipment -->

        <div class="col-md-6 col-xl-4">

            <div class="border rounded-3 p-4 h-100">

                <div class="d-flex align-items-center mb-3">

                    <div class="rounded-circle bg-primary-subtle text-primary
                                d-flex align-items-center justify-content-center"
                         style="width:50px;height:50px;">

                        <i class="bi bi-truck fs-4"></i>

                    </div>

                    <h5 class="mb-0 ms-3">
                        Create New Shipment
                    </h5>

                </div>


                <p class="text-muted">
                    Record incoming or outgoing shipment.
                </p>


                <a
                    href="{{ route('shipments.setup') }}"
                    class="btn btn-light border"
                >
                    Create Shipment

                    <i class="bi bi-arrow-right ms-2"></i>
                </a>

            </div>

        </div>


        <!-- Pending confirmation -->

        <div class="col-md-6 col-xl-4">

            <div class="border rounded-3 p-4 h-100">

                <div class="d-flex align-items-center mb-3">

                    <div class="rounded-circle bg-info-subtle text-info
                                d-flex align-items-center justify-content-center"
                         style="width:50px;height:50px;">

                        <i class="bi bi-list-check fs-4"></i>

                    </div>

                    <h5 class="mb-0 ms-3">
                        Pending Confirmation
                    </h5>

                </div>


                <p class="text-muted">
                    Review and confirm received shipment.
                </p>


                <a
                    href="{{ route('shipments.pending') }}"
                    class="btn btn-light border"
                >
                    View Pending {{ $pendingIncomingCount }}

                    <i class="bi bi-arrow-right ms-2"></i>
                </a>

            </div>

        </div>

    </div>

</div>



<!-- ==========================================================
     DATA MANAGEMENT
=========================================================== -->

<div class="dashboard-card">

    <div class="mb-4">

        <h4 class="mb-1">
            Data Management
        </h4>

        <p class="text-muted mb-0">
            Quick actions for managing your inventory data.
        </p>

    </div>


    <div class="row g-4">

        <!-- Download -->

        <div class="col-md-6 col-xl-4">

            <div class="border rounded-3 p-4 h-100">

                <div class="d-flex align-items-center mb-3">

                    <div class="rounded-circle bg-primary-subtle text-primary
                                d-flex align-items-center justify-content-center"
                         style="width:50px;height:50px;">

                        <i class="bi bi-download fs-4"></i>

                    </div>

                    <h5 class="mb-0 ms-3">
                        Download Template
                    </h5>

                </div>


                <p class="text-muted">
                    Get the Excel template for bulk data uploads.
                </p>


                <a
                    href="{{ route('qriff.index') }}"
                    class="btn btn-light border"
                >
                    Download

                    <i class="bi bi-arrow-right ms-2"></i>
                </a>

            </div>

        </div>


        <!-- Upload -->

        <div class="col-md-6 col-xl-4">

            <div class="border rounded-3 p-4 h-100">

                <div class="d-flex align-items-center mb-3">

                    <div class="rounded-circle bg-warning-subtle text-warning
                                d-flex align-items-center justify-content-center"
                         style="width:50px;height:50px;">

                        <i class="bi bi-upload fs-4"></i>

                    </div>

                    <h5 class="mb-0 ms-3">
                        Upload Data
                    </h5>

                </div>


                <p class="text-muted">
                    Bulk upload QRIFF data using the Excel template.
                </p>


                <a
                    href="{{ route('qriff.index') }}"
                    class="btn btn-light border"
                >
                    Upload File

                    <i class="bi bi-arrow-right ms-2"></i>
                </a>

            </div>

        </div>


        <!-- Online -->

        <div class="col-md-6 col-xl-4">

            <div class="border rounded-3 p-4 h-100">

                <div class="d-flex align-items-center mb-3">

                    <div class="rounded-circle bg-success-subtle text-success
                                d-flex align-items-center justify-content-center"
                         style="width:50px;height:50px;">

                        <i class="bi bi-circle fs-4"></i>

                    </div>

                    <h5 class="mb-0 ms-3">
                        Record Data Online
                    </h5>

                </div>


                <p class="text-muted">
                    Directly enter new case, QRIFF, or inventory information.
                </p>


                <a
                    href="{{ route('qriff.record') }}"
                    class="btn btn-light border"
                >
                    Record Data

                    <i class="bi bi-arrow-right ms-2"></i>
                </a>

            </div>

        </div>

    </div>

</div>

@endsection