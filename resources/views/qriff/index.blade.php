@extends('layouts.app')

@section('title', 'QRIFF')

@section('header', 'QRIFF')

@section('content')

<div class="page-heading">

    <h1>QRIFF</h1>

    <p>
        Quarterly facility reporting.
    </p>

</div>

<div class="dashboard-card">

<div class="container">

    <h3 class="mb-4">QRIFF Data Management</h3>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif

    {{-- Error message --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {!! session('error') !!}
        </div>
    @endif

    {{-- Validation errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following:</strong>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="row">

        {{-- ========================= --}}
        {{-- DOWNLOAD --}}
        {{-- ========================= --}}

        <div class="col-md-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <strong>Download QRIFF Data</strong>
                </div>

                <div class="card-body">

                    <p class="text-muted">
                        Select a state and quarter to download the
                        QRIFF workbook for that state.
                    </p>

                    <form action="{{ route('qriff.download') }}" method="GET">

                        <div class="mb-3">

                            <label for="download_state" class="form-label">
                                State
                            </label>

                            <select
                                name="state"
                                id="download_state"
                                class="form-control"
                                required
                            >
                                <option value="">Select State</option>

                                @foreach($states as $state)
                                    <option value="{{ $state }}">
                                        {{ $state }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        <div class="mb-3">

                            <label for="download_quarter" class="form-label">
                                Quarter
                            </label>

                            <select
                                name="quarter"
                                id="download_quarter"
                                class="form-control"
                                required
                            >
                                <option value="">Select Quarter</option>

                                @foreach($quarters as $quarter)
                                    <option value="{{ $quarter }}">
                                        {{ $quarter }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        <button type="submit" class="btn btn-primary">

                            Download Excel

                        </button>

                    </form>

                </div>

            </div>

        </div>


        {{-- ========================= --}}
        {{-- UPLOAD --}}
        {{-- ========================= --}}

        <div class="col-md-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <strong>Upload QRIFF Data</strong>
                </div>

                <div class="card-body">

                    <p class="text-muted">
                        Select the state and quarter, then upload the
                        QRIFF Excel workbook.
                    </p>

                    <form
                        action="{{ route('qriff.upload') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        <div class="mb-3">

                            <label for="upload_state" class="form-label">
                                State
                            </label>

                            <select
                                name="state"
                                id="upload_state"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    Select State
                                </option>

                                @foreach($states as $state)
                                    <option value="{{ $state }}">
                                        {{ $state }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        <div class="mb-3">

                            <label for="upload_quarter" class="form-label">
                                Quarter
                            </label>

                            <select
                                name="quarter"
                                id="upload_quarter"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    Select Quarter
                                </option>

                                @foreach($quarters as $quarter)
                                    <option value="{{ $quarter }}">
                                        {{ $quarter }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        <div class="mb-3">

                            <label for="file" class="form-label">
                                QRIFF Excel File
                            </label>

                            <input
                                type="file"
                                name="file"
                                id="file"
                                class="form-control"
                                accept=".xlsx,.xls"
                                required
                            >

                        </div>


                        <button type="submit" class="btn btn-success">

                            Upload Excel

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

@endsection
```
