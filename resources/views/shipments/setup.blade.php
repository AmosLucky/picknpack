@extends('layouts.app')

@section('title', 'Shipment Setup')

@section('header', 'Shipment Management')

@section('content')

<div class="page-heading">

    <h1>Who are you?</h1>

    <p>
        Select the store you are sending products from.
    </p>

</div>


<div class="dashboard-card">

    <form
        method="POST"
        action="{{ route('shipments.setup.store') }}"
        id="setupForm"
    >

        @csrf


        {{-- ==========================================================
             SENDER TYPE
        =========================================================== --}}

        <div class="mb-4">

            <label
                for="sender_type"
                class="form-label fw-semibold"
            >
                Sender Type
            </label>

            <select
                name="sender_type"
                id="sender_type"
                class="form-select"
                required
            >

                <option value="">
                    Select sender type
                </option>

                <option value="national">
                    National Store
                </option>

                <option value="zonal">
                    Zonal Store
                </option>

                <option value="state">
                    State Store
                </option>

            </select>

        </div>


        {{-- ==========================================================
             SENDER / LOCATION
        =========================================================== --}}

        <div class="mb-4">

            <label
                for="sender_id"
                class="form-label fw-semibold"
                id="senderLabel"
            >
                Sender
            </label>

            <select
                name="sender_id"
                id="sender_id"
                class="form-select"
                required
                disabled
            >

                <option value="">
                    Select sender type first
                </option>

            </select>

        </div>


        {{-- ==========================================================
             CONTINUE
        =========================================================== --}}

        <button
            type="submit"
            class="btn btn-primary"
            id="continueButton"
            disabled
        >

            Continue

            <i class="bi bi-arrow-right ms-2"></i>

        </button>

    </form>

</div>


@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DATA FROM CONTROLLER
    |--------------------------------------------------------------------------
    */

    const zones = @json($zones ?? []);

    const states = @json($states ?? []);

    const stores = @json($stores ?? []);


    /*
    |--------------------------------------------------------------------------
    | ELEMENTS
    |--------------------------------------------------------------------------
    */

    const senderType =
        document.getElementById('sender_type');

    const senderId =
        document.getElementById('sender_id');

    const senderLabel =
        document.getElementById('senderLabel');

    const continueButton =
        document.getElementById('continueButton');


    /*
    |--------------------------------------------------------------------------
    | DEBUG
    |--------------------------------------------------------------------------
    */

    console.log('Shipment setup loaded');

    console.log('Zones:', zones);

    console.log('States:', states);

    console.log('Stores:', stores);


    /*
    |--------------------------------------------------------------------------
    | SENDER TYPE CHANGED
    |--------------------------------------------------------------------------
    */

    senderType.addEventListener('change', function () {

        const type = this.value;


        /*
        |--------------------------------------------------------------------------
        | RESET SENDER DROPDOWN
        |--------------------------------------------------------------------------
        */

        senderId.innerHTML = `
            <option value="">
                Select sender
            </option>
        `;

        senderId.disabled = true;

        continueButton.disabled = true;


        /*
        |--------------------------------------------------------------------------
        | NOTHING SELECTED
        |--------------------------------------------------------------------------
        */

        if (!type) {

            senderLabel.textContent =
                'Sender';

            senderId.innerHTML = `
                <option value="">
                    Select sender type first
                </option>
            `;

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | NATIONAL
        |--------------------------------------------------------------------------
        */

        if (type === 'national') {

            senderLabel.textContent =
                'National Store';


            senderId.innerHTML = `
                <option value="fcms_national_store">
                    National Store
                </option>
            `;


            senderId.disabled = false;

            continueButton.disabled = false;

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ZONAL
        |--------------------------------------------------------------------------
        */

        if (type === 'zonal') {

            senderLabel.textContent =
                'Zone';


            if (!zones.length) {

                senderId.innerHTML = `
                    <option value="">
                        No zones available
                    </option>
                `;

                return;
            }


            zones.forEach(function (zone) {

                const option =
                    document.createElement('option');

                option.value =
                    zone.id;

                option.textContent =
                    zone.name;

                senderId.appendChild(option);

            });


            senderId.disabled = false;

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | STATE
        |--------------------------------------------------------------------------
        */

        if (type === 'state') {

            senderLabel.textContent =
                'State';


            if (!states.length) {

                senderId.innerHTML = `
                    <option value="">
                        No states available
                    </option>
                `;

                return;
            }


            states.forEach(function (state) {

                const option =
                    document.createElement('option');

                option.value =
                    state.state;

                option.textContent =
                    capitalize(state.state);

                senderId.appendChild(option);

            });


            senderId.disabled = false;

            return;
        }

    });


    /*
    |--------------------------------------------------------------------------
    | SENDER SELECTED
    |--------------------------------------------------------------------------
    */

    senderId.addEventListener('change', function () {

        continueButton.disabled =
            !this.value;

    });


    /*
    |--------------------------------------------------------------------------
    | CAPITALIZE
    |--------------------------------------------------------------------------
    */

    function capitalize(value) {

        if (!value) {
            return '';
        }

        return value.charAt(0).toUpperCase()
            + value.slice(1);

    }

});

</script>

@endpush