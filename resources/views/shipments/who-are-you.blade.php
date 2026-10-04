<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>Shipment Source</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #fff;
            color: #14213d;
        }

        .page {
            min-height: 100vh;
            padding: 24px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .back {
            border: 1px solid #dce3ee;
            background: #fff;
            padding: 10px 22px;
            border-radius: 6px;
            cursor: pointer;
        }

        .title {
            font-weight: 600;
            font-size: 17px;
        }

        .spacer {
            width: 90px;
        }

        .card {
            max-width: 700px;
            margin: 80px auto 0;
            border: 1px solid #e1e6ef;
            border-radius: 10px;
            padding: 35px;
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .description {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .option {
            border: 1px solid #dce3ee;
            border-radius: 8px;
            padding: 25px 15px;
            cursor: pointer;
            text-align: center;
            transition: .15s;
        }

        .option:hover {
            border-color: #137333;
        }

        .option.selected {
            border-color: #137333;
            background: #f0fdf4;
        }

        .icon {
            font-size: 28px;
            margin-bottom: 12px;
        }

        .option-title {
            font-weight: 600;
        }

        .location {
            margin-top: 25px;
            display: none;
        }

        .location label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            color: #475569;
        }

        .location select {
            width: 100%;
            height: 44px;
            border: 1px solid #dce3ee;
            border-radius: 6px;
            padding: 0 12px;
        }

        .continue {
            margin-top: 25px;
            width: 100%;
            height: 45px;
            border: 0;
            border-radius: 6px;
            background: #137333;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }

        .continue:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

    </style>

</head>

<body>

<div class="page">

    <div class="topbar">

        <button
            class="back"
            onclick="history.back()"
        >
            ← &nbsp; Back
        </button>

        <div class="title">
            Select shipment source
        </div>

        <div class="spacer"></div>

    </div>


    <div class="card">

        <div class="card-title">
            Who are you?
        </div>

        <div class="description">
            Select the store you are sending products from.
        </div>


        <form
            method="POST"
            action="{{ route('shipments.setup') }}"
            id="setupForm"
        >

            @csrf


            <input
                type="hidden"
                name="sender_type"
                id="sender_type"
            >

            <input
                type="hidden"
                name="sender_id"
                id="sender_id"
            >


            <div class="options">

                <div
                    class="option"
                    data-type="national"
                >

                    <div class="icon">
                        🏢
                    </div>

                    <div class="option-title">
                        National Store
                    </div>

                </div>


                <div
                    class="option"
                    data-type="zonal"
                >

                    <div class="icon">
                        🏬
                    </div>

                    <div class="option-title">
                        Zonal Store
                    </div>

                </div>


                <div
                    class="option"
                    data-type="state"
                >

                    <div class="icon">
                        🏥
                    </div>

                    <div class="option-title">
                        State Store
                    </div>

                </div>

            </div>


            <div
                class="location"
                id="locationBox"
            >

                <label id="locationLabel">
                    Location
                </label>

                <select id="locationSelect">

                    <option value="">
                        Select location
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="continue"
                id="continueButton"
                disabled
            >
                Continue →
            </button>

        </form>

    </div>

</div>


<script>

const zones =
    @json($zones);

const states =
    @json($states);


const options =
    document.querySelectorAll('.option');

const senderType =
    document.getElementById('sender_type');

const senderId =
    document.getElementById('sender_id');

const locationBox =
    document.getElementById('locationBox');

const locationLabel =
    document.getElementById('locationLabel');

const locationSelect =
    document.getElementById('locationSelect');

const continueButton =
    document.getElementById('continueButton');


options.forEach(option => {

    option.addEventListener(
        'click',
        function()
        {

            options.forEach(
                item =>
                    item.classList.remove('selected')
            );


            this.classList.add('selected');


            const type =
                this.dataset.type;


            senderType.value =
                type;


            locationSelect.innerHTML =
                `<option value="">
                    Select location
                </option>`;


            /*
            |--------------------------------------------------------------------------
            | National
            |--------------------------------------------------------------------------
            */

            if (type === 'national') {

                locationBox.style.display =
                    'none';

                senderId.value =
                    'fcms_national_store';

                continueButton.disabled =
                    false;

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Zonal
            |--------------------------------------------------------------------------
            */

            if (type === 'zonal') {

                locationBox.style.display =
                    'block';

                locationLabel.textContent =
                    'Zone';


                zones.forEach(zone => {

                    locationSelect.insertAdjacentHTML(
                        'beforeend',
                        `
                        <option value="${zone.id}">
                            ${zone.name}
                        </option>
                        `
                    );

                });

            }


            /*
            |--------------------------------------------------------------------------
            | State
            |--------------------------------------------------------------------------
            */

            if (type === 'state') {

                locationBox.style.display =
                    'block';

                locationLabel.textContent =
                    'State';


                states.forEach(state => {

                    locationSelect.insertAdjacentHTML(
                        'beforeend',
                        `
                        <option value="${state.state}">
                            ${capitalize(state.state)}
                        </option>
                        `
                    );

                });

            }


            continueButton.disabled =
                true;
        }
    );

});


locationSelect.addEventListener(
    'change',
    function()
    {

        senderId.value =
            this.value;

        continueButton.disabled =
            !this.value;

    }
);


function capitalize(value)
{
    return value.charAt(0).toUpperCase()
        + value.slice(1);
}

</script>

</body>

</html>