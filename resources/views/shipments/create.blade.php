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

    <title>Create Shipment</title>


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


        .shipment-page {
            width: 100%;
            min-height: 100vh;
            padding: 18px 24px;
        }


        /* ---------------------------------------------------------
           TOP BAR
        --------------------------------------------------------- */

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }


        .back-btn {
            border: 1px solid #dce3ee;
            background: #fff;
            border-radius: 6px;
            padding: 10px 22px;
            cursor: pointer;
            color: #14213d;
        }


        .back-btn:hover {
            background: #f8fafc;
        }


        .title {
            font-size: 17px;
            font-weight: 600;
        }


        .top-spacer {
            width: 100px;
        }


        /* ---------------------------------------------------------
           ALERT
        --------------------------------------------------------- */

        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            display: none;
        }


        .alert.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }


        .alert.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }


        /* ---------------------------------------------------------
           SETUP / SHIPMENT DETAILS
        --------------------------------------------------------- */

        .setup-card {
            border: 1px solid #e1e6ef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 18px;
        }


        .section-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 16px;
        }


        .form-grid {
            display: grid;
            grid-template-columns:
                1fr
                1fr
                1fr
                1fr;
            gap: 12px;
        }


        .field label {
            display: block;
            font-size: 13px;
            margin-bottom: 7px;
            color: #475569;
        }


        .field select,
        .field input {
            width: 100%;
            height: 42px;
            border: 1px solid #dce3ee;
            border-radius: 6px;
            padding: 0 12px;
            background: #fff;
            color: #14213d;
            outline: none;
        }


        .field select:focus,
        .field input:focus {
            border-color: #94a3b8;
        }


        .field input[type="date"] {
            cursor: pointer;
        }


        .readonly-box {
            width: 100%;
            min-height: 42px;
            border: 1px solid #dce3ee;
            border-radius: 6px;
            padding: 11px 12px;
            background: #f8fafc;
            color: #14213d;
            font-size: 14px;
        }


        /* ---------------------------------------------------------
           RECEIVER
        --------------------------------------------------------- */

        .receiver-box {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid #edf0f5;
        }


        .fixed-receiver {
            background: #f4f7fb;
            border: 1px solid #dce3ee;
            border-radius: 6px;
            padding: 12px;
            font-size: 14px;
        }


        .receiver-help {
            margin-top: 7px;
            color: #64748b;
            font-size: 12px;
        }


        /* ---------------------------------------------------------
           ITEMS
        --------------------------------------------------------- */

        .items-section {
            border: 1px solid #e1e6ef;
            border-radius: 8px;
            overflow: hidden;
        }


        .items-header {
            display: grid;

            grid-template-columns:
                60px
                minmax(250px, 1fr)
                150px
                260px
                130px
                60px;

            padding: 14px 16px;

            background: #fff;

            border-bottom:
                1px solid #e1e6ef;

            font-size: 13px;

            font-weight: 600;
        }


        .item-row {
            display: grid;

            grid-template-columns:
                60px
                minmax(250px, 1fr)
                150px
                260px
                130px
                60px;

            gap: 0;

            padding: 12px 16px;

            border-bottom:
                1px solid #edf0f5;

            align-items: center;
        }


        .item-row:last-child {
            border-bottom: 0;
        }


        .item-row select,
        .item-row input {
            height: 40px;

            width:
                calc(100% - 12px);

            border:
                1px solid #dce3ee;

            border-radius: 6px;

            padding:
                0 10px;

            background: #fff;

            color: #14213d;

            outline: none;
        }


        .item-row select:focus,
        .item-row input:focus {
            border-color: #94a3b8;
        }


        .serial {
            width: 30px;
            height: 30px;

            border-radius: 50%;

            background: #f1f5f9;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 13px;
        }


        .remove-btn {
            width: 34px;
            height: 34px;

            border:
                1px solid #fecaca;

            background: #fff;

            color: #dc2626;

            border-radius: 6px;

            cursor: pointer;
        }


        .remove-btn:hover {
            background: #fef2f2;
        }


        .empty-message {
            text-align: center;

            padding: 28px;

            color: #64748b;

            font-size: 14px;
        }


        .batch-info {
            margin-top: 4px;

            font-size: 11px;

            color: #64748b;

            white-space: nowrap;
        }


        .stock-warning {
            margin-top: 4px;

            font-size: 11px;

            color: #dc2626;

            display: none;
        }


        /* ---------------------------------------------------------
           FOOTER
        --------------------------------------------------------- */

        .footer {
            margin-top: 22px;

            display: flex;

            justify-content:
                space-between;

            align-items: center;
        }


        .send-btn {
            border: 0;

            background: #137333;

            color: #fff;

            padding: 12px 24px;

            border-radius: 6px;

            cursor: pointer;

            font-weight: 600;
        }


        .send-btn:hover:not(:disabled) {
            background: #0f5f2a;
        }


        .send-btn:disabled {
            opacity: .5;

            cursor: not-allowed;
        }


        .add-btn {
            border: 0;

            background: #111827;

            color: white;

            padding: 10px 18px;

            border-radius: 6px;

            cursor: pointer;
        }


        .add-btn:hover:not(:disabled) {
            background: #1f2937;
        }


        .add-btn:disabled {
            opacity: .5;

            cursor: not-allowed;
        }


        /* ---------------------------------------------------------
           LOADING
        --------------------------------------------------------- */

        .loading {
            display: inline-block;

            width: 14px;
            height: 14px;

            border:
                2px solid rgba(255,255,255,.4);

            border-top-color:
                #fff;

            border-radius: 50%;

            animation:
                spin .7s linear infinite;

            vertical-align: middle;

            margin-right: 7px;
        }


        @keyframes spin {

            to {
                transform: rotate(360deg);
            }

        }


        /* ---------------------------------------------------------
           RESPONSIVE
        --------------------------------------------------------- */

        @media (max-width: 1100px) {

            .form-grid {
                grid-template-columns:
                    1fr 1fr;
            }


            .items-section {
                overflow-x: auto;
            }


            .items-header,
            .item-row {
                min-width: 1050px;
            }

        }


        @media (max-width: 650px) {

            .shipment-page {
                padding: 12px;
            }


            .topbar {
                gap: 15px;
            }


            .title {
                text-align: center;
                font-size: 15px;
            }


            .top-spacer {
                width: 70px;
            }


            .form-grid {
                grid-template-columns:
                    1fr;
            }

        }

    </style>

</head>


<body>


<div class="shipment-page">


    {{-- =========================================================
         TOP BAR
    ========================================================== --}}

    <div class="topbar">

        <button
            type="button"
            class="back-btn"
            onclick="window.location.href='{{ route('shipments.setup') }}'"
        >
            ← &nbsp; Back
        </button>


        <div class="title">
            Select product, delivery type & receiver
        </div>


        <div class="top-spacer"></div>

    </div>



    {{-- =========================================================
         ALERT
    ========================================================== --}}

    <div
        id="alert"
        class="alert"
    ></div>



    {{-- =========================================================
         SHIPMENT DETAILS
    ========================================================== --}}

    <div class="setup-card">

        <div class="section-title">
            Shipment details
        </div>


        <div class="form-grid">


            {{-- DATE --}}

            <div class="field">

                <label>
                    Shipment date
                </label>

                <input
                    type="date"
                    id="shipment_date"
                    value="{{ $setup['shipment_date'] ?? date('Y-m-d') }}"
                >

            </div>



            {{-- WHO ARE YOU --}}

            <div class="field">

                <label>
                    Shipment source
                </label>

                <div class="readonly-box">

                    {{ $setup['sender_name'] ?? 'Shipment Store' }}

                </div>

            </div>



            {{-- DELIVERY TYPE --}}

            <div class="field">

                <label>
                    Delivery type
                </label>

                <select id="shipment_type">

                    <option value="">
                        Select type
                    </option>

                    <option value="supply">
                        Supply
                    </option>

                    <option value="transfer">
                        Transfer
                    </option>

                    <option value="return">
                        Return
                    </option>

                </select>

            </div>



            {{-- DESTINATION FILTER --}}

            <div
                class="field"
                id="destination_filter_field"
            >

                <label id="destination_filter_label">
                    Destination
                </label>

                <select
                    id="destination_filter"
                >

                    <option value="">
                        Select
                    </option>

                </select>

            </div>


        </div>



        {{-- =====================================================
             RECEIVER
        ====================================================== --}}

        <div
            class="receiver-box"
            id="receiver_box"
        >

            <div class="form-grid">


                <div
                    class="field"
                    id="receiver_field"
                >

                    <label>
                        Receiver
                    </label>

                    <select
                        id="receiver"
                    >

                        <option value="">
                            Select a receiver
                        </option>

                    </select>


                    <div
                        class="receiver-help"
                        id="receiver_help"
                    >
                        Select a delivery type first.
                    </div>

                </div>


            </div>


            <div
                id="fixed_receiver"
                class="fixed-receiver"
                style="display:none"
            ></div>

        </div>

    </div>



    {{-- =========================================================
         PRODUCTS
    ========================================================== --}}

    <div class="items-section">


        <div class="items-header">

            <div>
                S/N
            </div>

            <div>
                Product Name
            </div>

            <div>
                Mode
            </div>

            <div>
                Batch Selection
            </div>

            <div>
                Quantity
            </div>

            <div></div>

        </div>



        <div id="items_container">

            <div
                class="empty-message"
                id="empty_message"
            >
                Add or remove items to be sent
            </div>

        </div>

    </div>



    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <div class="footer">


        <button
            type="button"
            class="send-btn"
            id="send_button"
            disabled
        >
            🚚 &nbsp; Send Products
        </button>


        <button
            type="button"
            class="add-btn"
            id="add_button"
            disabled
        >
            ⊕ &nbsp; Add
        </button>


    </div>


</div>



<script>


/*
|--------------------------------------------------------------------------
| PRELOADED DATA
|--------------------------------------------------------------------------
|
| IMPORTANT:
|
| There are NO AJAX calls for:
|
| - receivers
| - states
| - LGAs
| - facilities
| - batches
|
| They were already gathered by ShipmentController::setup().
|
*/


const setup =
    @json($setup);


const products =
    setup.products || [];


const batches =
    setup.batches || [];


const facilities =
    setup.facilities || [];


const states =
    setup.states || [];


const zones =
    setup.zones || [];


const stateStores =
    setup.state_stores || [];


const zonalStores =
    setup.zonal_stores || [];


const senderType =
    setup.sender_type || '';


const senderId =
    setup.sender_id || '';


const senderZone =
    setup.sender_zone || '';


const senderState =
    setup.sender_state || '';



/*
|--------------------------------------------------------------------------
| DOM
|--------------------------------------------------------------------------
*/


const shipmentDate =
    document.getElementById(
        'shipment_date'
    );


const shipmentType =
    document.getElementById(
        'shipment_type'
    );


const destinationFilter =
    document.getElementById(
        'destination_filter'
    );


const destinationFilterField =
    document.getElementById(
        'destination_filter_field'
    );


const destinationFilterLabel =
    document.getElementById(
        'destination_filter_label'
    );


const receiver =
    document.getElementById(
        'receiver'
    );


const receiverBox =
    document.getElementById(
        'receiver_box'
    );


const receiverHelp =
    document.getElementById(
        'receiver_help'
    );


const fixedReceiver =
    document.getElementById(
        'fixed_receiver'
    );


const addButton =
    document.getElementById(
        'add_button'
    );


const sendButton =
    document.getElementById(
        'send_button'
    );


const itemsContainer =
    document.getElementById(
        'items_container'
    );


const alertBox =
    document.getElementById(
        'alert'
    );



/*
|--------------------------------------------------------------------------
| State
|--------------------------------------------------------------------------
*/


let items = [];


let currentReceiver = null;



/*
|--------------------------------------------------------------------------
| ALERT
|--------------------------------------------------------------------------
*/


function showAlert(
    message,
    type = 'error'
) {

    alertBox.textContent =
        message;

    alertBox.className =
        'alert ' + type;

    alertBox.style.display =
        'block';

}


function hideAlert()
{
    alertBox.style.display =
        'none';
}



/*
|--------------------------------------------------------------------------
| Escape HTML
|--------------------------------------------------------------------------
*/


function escapeHtml(value)
{
    return String(value ?? '')
        .replaceAll(
            '&',
            '&amp;'
        )
        .replaceAll(
            '<',
            '&lt;'
        )
        .replaceAll(
            '>',
            '&gt;'
        )
        .replaceAll(
            '"',
            '&quot;'
        )
        .replaceAll(
            "'",
            '&#039;'
        );
}



/*
|--------------------------------------------------------------------------
| Capitalize
|--------------------------------------------------------------------------
*/


function capitalize(value)
{
    if (!value) {
        return '';
    }

    return value
        .charAt(0)
        .toUpperCase()
        + value.slice(1);
}



/*
|--------------------------------------------------------------------------
| Format date
|--------------------------------------------------------------------------
*/


function formatDate(value)
{
    if (!value) {
        return '';
    }


    const date =
        new Date(value);


    if (
        Number.isNaN(
            date.getTime()
        )
    ) {
        return value;
    }


    return date.toLocaleDateString(
        'en-GB'
    );
}



/*
|--------------------------------------------------------------------------
| Reset select
|--------------------------------------------------------------------------
*/


function resetSelect(
    select,
    placeholder
) {

    select.innerHTML =
        `<option value="">
            ${escapeHtml(placeholder)}
        </option>`;

}



/*
|--------------------------------------------------------------------------
| Find batches for product
|--------------------------------------------------------------------------
*/


function getProductBatches(
    productId
) {

    if (!productId) {
        return [];
    }


    return batches[productId] || [];

}



/*
|--------------------------------------------------------------------------
| Render batch options
|--------------------------------------------------------------------------
*/


function renderBatchOptions(
    select,
    productId,
    selectedBatchId = ''
) {

    select.innerHTML =
        `<option value="">
            Select Batch
        </option>`;


    const productBatches =
        getProductBatches(
            productId
        );


    if (!productBatches.length) {

        select.innerHTML =
            `<option value="">
                No stock available
            </option>`;

        return;

    }


    productBatches.forEach(
        batch => {

            const available =
                Number(
                    batch.available_quantity || 0
                );


            const expiry =
                batch.expiry_date
                    ? formatDate(
                        batch.expiry_date
                    )
                    : 'No expiry';


            const option =
                document.createElement(
                    'option'
                );


            option.value =
                batch.batch_id;


            option.dataset.available =
                available;


            option.textContent =
                `${batch.batch_no || 'No batch'} — Exp: ${expiry} — Available: ${available}`;


            if (
                String(
                    selectedBatchId
                ) === String(
                    batch.batch_id
                )
            ) {

                option.selected =
                    true;

            }


            select.appendChild(
                option
            );

        }
    );

}



/*
|--------------------------------------------------------------------------
| Find batch
|--------------------------------------------------------------------------
*/


function findBatch(
    productId,
    batchId
) {

    const productBatches =
        getProductBatches(
            productId
        );


    return productBatches.find(
        batch =>
            String(
                batch.batch_id
            ) === String(
                batchId
            )
    ) || null;

}



/*
|--------------------------------------------------------------------------
| Get state facilities
|--------------------------------------------------------------------------
*/


function getStateFacilities(
    state
) {

    return facilities.filter(
        facility =>
            String(
                facility.state || ''
            ).trim().toLowerCase()
            ===
            String(
                state || ''
            ).trim().toLowerCase()
    );

}



/*
|--------------------------------------------------------------------------
| Get LGA list
|--------------------------------------------------------------------------
*/


function getLGAs(
    state
) {

    const stateFacilities =
        getStateFacilities(
            state
        );


    return [
        ...new Set(
            stateFacilities
                .map(
                    facility =>
                        facility.lga
                )
                .filter(
                    lga =>
                        lga &&
                        String(lga).trim()
                )
        )
    ].sort(
        (a, b) =>
            String(a)
                .localeCompare(
                    String(b)
                )
    );

}



/*
|--------------------------------------------------------------------------
| Get facilities for LGA
|--------------------------------------------------------------------------
*/


function getLgaFacilities(
    state,
    lga
) {

    return getStateFacilities(
        state
    ).filter(
        facility =>
            String(
                facility.lga || ''
            ).trim().toLowerCase()
            ===
            String(
                lga || ''
            ).trim().toLowerCase()
    );

}



/*
|--------------------------------------------------------------------------
| Get state store
|--------------------------------------------------------------------------
*/


function getStateStore(
    state
) {

    return stateStores.find(
        item =>
            String(
                item.state
            ).toLowerCase()
            ===
            String(
                state
            ).toLowerCase()
    ) || null;

}



/*
|--------------------------------------------------------------------------
| Get zonal store
|--------------------------------------------------------------------------
*/


function getZonalStore(
    zone
) {

    return zonalStores.find(
        item =>
            String(
                item.zone || ''
            ).toLowerCase()
            ===
            String(
                zone || ''
            ).toLowerCase()
    ) || null;

}



/*
|--------------------------------------------------------------------------
| Set receiver
|--------------------------------------------------------------------------
*/


function setCurrentReceiver(
    id,
    type,
    name
) {

    if (!id) {

        currentReceiver =
            null;

        addButton.disabled =
            true;

        return;
    }


    currentReceiver = {

        id: id,

        type: type,

        name: name

    };


    addButton.disabled =
        false;


    receiverHelp.textContent =
        `Receiver: ${name}`;

}



/*
|--------------------------------------------------------------------------
| Clear receiver
|--------------------------------------------------------------------------
*/


function clearReceiver()
{

    currentReceiver =
        null;

    addButton.disabled =
        true;

    resetSelect(
        receiver,
        'Select a receiver'
    );

    receiverHelp.textContent =
        'Select a destination.';

}



/*
|--------------------------------------------------------------------------
| Shipment type changed
|--------------------------------------------------------------------------
*/


shipmentType.addEventListener(
    'change',
    function()
    {

        hideAlert();

        clearReceiver();


        resetSelect(
            destinationFilter,
            'Select'
        );


        fixedReceiver.style.display =
            'none';


        destinationFilterField
            .style
            .display =
            'block';


        /*
        |--------------------------------------------------------------------------
        | No type selected
        |--------------------------------------------------------------------------
        */

        if (!this.value) {

            destinationFilterLabel
                .textContent =
                'Destination';

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | NATIONAL
        |--------------------------------------------------------------------------
        */

        if (
            senderType ===
            'national'
        ) {

            handleNationalRouting(
                this.value
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ZONAL
        |--------------------------------------------------------------------------
        */

        if (
            senderType ===
            'zonal'
        ) {

            handleZonalRouting(
                this.value
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | STATE
        |--------------------------------------------------------------------------
        */

        if (
            senderType ===
            'state'
        ) {

            handleStateRouting(
                this.value
            );

            return;
        }

    }
);



/*
|--------------------------------------------------------------------------
| NATIONAL ROUTING
|--------------------------------------------------------------------------
|
| National:
|
| Supply   -> Zonal Store
| Transfer -> Zonal Store
| Return   -> National
|
*/

function handleNationalRouting(type)
{
    clearReceiver();

    /*
    |--------------------------------------------------------------------------
    | National cannot transfer
    |--------------------------------------------------------------------------
    */

    if (type === 'transfer') {

        destinationFilterField.style.display = 'none';

        fixedReceiver.style.display = 'block';

        fixedReceiver.innerHTML = `
            <strong>Not available:</strong>
            National Store cannot make a transfer.
        `;

        showAlert(
            'National Store can only supply to zonal stores.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | National cannot return
    |--------------------------------------------------------------------------
    */

    if (type === 'return') {

        destinationFilterField.style.display = 'none';

        fixedReceiver.style.display = 'block';

        fixedReceiver.innerHTML = `
            <strong>Not available:</strong>
            National Store cannot return stock.
        `;

        showAlert(
            'National Store cannot make a return.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | National Supply → Zonal Stores
    |--------------------------------------------------------------------------
    */

    if (type === 'supply') {

        destinationFilterField.style.display = 'block';

        destinationFilterLabel.textContent = 'Zone';

        resetSelect(
            destinationFilter,
            'Select zone'
        );


        zones.forEach(zone => {

            const store =
                getZonalStore(zone.id);

            if (!store) {
                return;
            }


            const option =
                document.createElement('option');


            option.value =
                store.id;

            option.textContent =
                store.name;


            destinationFilter.appendChild(
                option
            );

        });


        destinationFilter.onchange =
            function()
            {

                clearReceiver();


                const selected =
                    zonalStores.find(
                        store =>
                            store.id ===
                            this.value
                    );


                if (!selected) {
                    return;
                }


                resetSelect(
                    receiver,
                    'Select a receiver'
                );


                receiver.insertAdjacentHTML(
                    'beforeend',
                    `
                    <option value="${escapeHtml(selected.id)}">
                        ${escapeHtml(selected.name)}
                    </option>
                    `
                );


                receiver.value =
                    selected.id;


                setCurrentReceiver(
                    selected.id,
                    'zonal',
                    selected.name
                );

            };

    }

}


function handleNationalRouting1(
    type
) {

    clearReceiver();


    if (type === 'return') {

        destinationFilterField
            .style
            .display =
            'none';


        fixedReceiver.style.display =
            'block';


        fixedReceiver.innerHTML =
            `
            <strong>Receiver:</strong>
            National Store
            `;


        setCurrentReceiver(
            'fcms_national_store',
            'national',
            'National Store'
        );


        return;
    }


    destinationFilterField
        .style
        .display =
        'block';


    destinationFilterLabel
        .textContent =
        'Zone';


    resetSelect(
        destinationFilter,
        'Select zone'
    );


    zones.forEach(
        zone => {

            const store =
                getZonalStore(
                    zone.id
                );


            if (!store) {
                return;
            }


            const option =
                document.createElement(
                    'option'
                );


            option.value =
                store.id;


            option.textContent =
                store.name;


            destinationFilter
                .appendChild(
                    option
                );

        }
    );


    destinationFilter.onchange =
        function()
        {

            clearReceiver();


            const selected =
                zonalStores.find(
                    store =>
                        store.id ===
                        this.value
                );


            if (!selected) {
                return;
            }


            resetSelect(
                receiver,
                'Select a receiver'
            );


            receiver.insertAdjacentHTML(
                'beforeend',
                `
                <option value="${escapeHtml(selected.id)}">
                    ${escapeHtml(selected.name)}
                </option>
                `
            );


            receiver.value =
                selected.id;


            setCurrentReceiver(
                selected.id,
                'zonal',
                selected.name
            );

        };

}



/*
|--------------------------------------------------------------------------
| ZONAL ROUTING
|--------------------------------------------------------------------------
|
| Zonal:
|
| Supply   -> State Store
| Transfer -> State Store
| Return   -> National Store
|
*/

function handleZonalRouting(type)
{
    clearReceiver();


    /*
    |--------------------------------------------------------------------------
    | ZONAL → NATIONAL RETURN
    |--------------------------------------------------------------------------
    */

    if (type === 'return') {

        destinationFilterField.style.display =
            'none';


        fixedReceiver.style.display =
            'block';


        fixedReceiver.innerHTML = `
            <strong>Receiver:</strong>
            National Store
        `;


        setCurrentReceiver(
            'fcms_national_store',
            'national',
            'National Store'
        );


        return;
    }


    /*
    |--------------------------------------------------------------------------
    | ZONAL → STATE SUPPLY
    |--------------------------------------------------------------------------
    */

    if (type === 'supply') {

        destinationFilterField.style.display =
            'block';


        destinationFilterLabel.textContent =
            'State';


        resetSelect(
            destinationFilter,
            'Select state'
        );


        /*
        | Only states belonging to
        | this zone.
        */

        const allowedStates =
            states.filter(
                item =>
                    String(item.zone)
                        .toLowerCase()
                    ===
                    String(senderZone)
                        .toLowerCase()
            );


        allowedStates.forEach(
            state => {

                const store =
                    getStateStore(
                        state.state
                    );


                if (!store) {
                    return;
                }


                const option =
                    document.createElement(
                        'option'
                    );


                option.value =
                    store.id;


                option.textContent =
                    store.name;


                destinationFilter.appendChild(
                    option
                );

            }
        );


        destinationFilter.onchange =
            function()
            {

                clearReceiver();


                const selected =
                    stateStores.find(
                        store =>
                            store.id ===
                            this.value
                    );


                if (!selected) {
                    return;
                }


                resetSelect(
                    receiver,
                    'Select a receiver'
                );


                receiver.insertAdjacentHTML(
                    'beforeend',
                    `
                    <option value="${escapeHtml(selected.id)}">
                        ${escapeHtml(selected.name)}
                    </option>
                    `
                );


                receiver.value =
                    selected.id;


                setCurrentReceiver(
                    selected.id,
                    'state',
                    selected.name
                );

            };


        return;
    }


    /*
    |--------------------------------------------------------------------------
    | ZONAL TRANSFER → OTHER ZONAL STORE
    |--------------------------------------------------------------------------
    */

    if (type === 'transfer') {

        destinationFilterField.style.display =
            'block';


        destinationFilterLabel.textContent =
            'Transfer to Zone';


        resetSelect(
            destinationFilter,
            'Select zone'
        );


        /*
        | Show ALL zones except
        | the current sender zone.
        */

        zones.forEach(
            zone => {

                if (
                    String(zone.id)
                        .toLowerCase()
                    ===
                    String(senderZone)
                        .toLowerCase()
                ) {

                    return;
                }


                const store =
                    getZonalStore(
                        zone.id
                    );


                if (!store) {
                    return;
                }


                const option =
                    document.createElement(
                        'option'
                    );


                option.value =
                    store.id;


                option.textContent =
                    store.name;


                destinationFilter.appendChild(
                    option
                );

            }
        );


        destinationFilter.onchange =
            function()
            {

                clearReceiver();


                const selected =
                    zonalStores.find(
                        store =>
                            store.id ===
                            this.value
                    );


                if (!selected) {
                    return;
                }


                resetSelect(
                    receiver,
                    'Select a receiver'
                );


                receiver.insertAdjacentHTML(
                    'beforeend',
                    `
                    <option value="${escapeHtml(selected.id)}">
                        ${escapeHtml(selected.name)}
                    </option>
                    `
                );


                receiver.value =
                    selected.id;


                setCurrentReceiver(
                    selected.id,
                    'zonal',
                    selected.name
                );

            };


        return;
    }

}


function handleZonalRouting1(
    type
) {

    clearReceiver();


    if (type === 'return') {

        destinationFilterField
            .style
            .display =
            'none';


        fixedReceiver.style.display =
            'block';


        fixedReceiver.innerHTML =
            `
            <strong>Receiver:</strong>
            National Store
            `;


        setCurrentReceiver(
            'fcms_national_store',
            'national',
            'National Store'
        );


        return;
    }


    destinationFilterField
        .style
        .display =
        'block';


    destinationFilterLabel
        .textContent =
        'State';


    resetSelect(
        destinationFilter,
        'Select state'
    );


    const allowedStates =
        states.filter(
            item =>
                item.zone ===
                senderZone
        );


    allowedStates.forEach(
        state => {

            const store =
                getStateStore(
                    state.state
                );


            if (!store) {
                return;
            }


            const option =
                document.createElement(
                    'option'
                );


            option.value =
                store.id;


            option.textContent =
                store.name;


            destinationFilter
                .appendChild(
                    option
                );

        }
    );


    destinationFilter.onchange =
        function()
        {

            clearReceiver();


            const selected =
                stateStores.find(
                    store =>
                        store.id ===
                        this.value
                );


            if (!selected) {
                return;
            }


            resetSelect(
                receiver,
                'Select a receiver'
            );


            receiver.insertAdjacentHTML(
                'beforeend',
                `
                <option value="${escapeHtml(selected.id)}">
                    ${escapeHtml(selected.name)}
                </option>
                `
            );


            receiver.value =
                selected.id;


            setCurrentReceiver(
                selected.id,
                'state',
                selected.name
            );

        };

}



/*
|--------------------------------------------------------------------------
| STATE ROUTING
|--------------------------------------------------------------------------
|
| State:
|
| Supply   -> LGA -> Facility
| Transfer -> LGA -> Facility
| Return   -> Zonal Store
|
*/

function handleStateRouting(type)
{
    clearReceiver();


    /*
    |--------------------------------------------------------------------------
    | STATE → ZONAL RETURN
    |--------------------------------------------------------------------------
    */

    if (type === 'return') {

        destinationFilterField.style.display =
            'none';


        const zonalStore =
            getZonalStore(
                senderZone
            );


        if (!zonalStore) {

            showAlert(
                'Unable to determine the zonal store for this state.'
            );

            return;
        }


        fixedReceiver.style.display =
            'block';


        fixedReceiver.innerHTML = `
            <strong>Receiver:</strong>
            ${escapeHtml(zonalStore.name)}
        `;


        setCurrentReceiver(
            zonalStore.id,
            'zonal',
            zonalStore.name
        );


        return;
    }


    /*
    |--------------------------------------------------------------------------
    | STATE TRANSFER → OTHER STATE
    |--------------------------------------------------------------------------
    */

    if (type === 'transfer') {

        destinationFilterField.style.display =
            'block';


        destinationFilterLabel.textContent =
            'Transfer to State';


        resetSelect(
            destinationFilter,
            'Select state'
        );


        /*
        | Show every state except
        | the current state.
        */

        states.forEach(
            state => {

                if (
                    String(state.state)
                        .toLowerCase()
                    ===
                    String(senderState)
                        .toLowerCase()
                ) {

                    return;
                }


                const store =
                    getStateStore(
                        state.state
                    );


                if (!store) {
                    return;
                }


                const option =
                    document.createElement(
                        'option'
                    );


                option.value =
                    store.id;


                option.textContent =
                    store.name;


                destinationFilter.appendChild(
                    option
                );

            }
        );


        destinationFilter.onchange =
            function()
            {

                clearReceiver();


                const selected =
                    stateStores.find(
                        store =>
                            store.id ===
                            this.value
                    );


                if (!selected) {
                    return;
                }


                resetSelect(
                    receiver,
                    'Select a receiver'
                );


                receiver.insertAdjacentHTML(
                    'beforeend',
                    `
                    <option value="${escapeHtml(selected.id)}">
                        ${escapeHtml(selected.name)}
                    </option>
                    `
                );


                receiver.value =
                    selected.id;


                setCurrentReceiver(
                    selected.id,
                    'state',
                    selected.name
                );

            };


        return;
    }


    /*
    |--------------------------------------------------------------------------
    | STATE SUPPLY → LGA → FACILITY
    |--------------------------------------------------------------------------
    */

    if (type === 'supply') {

        destinationFilterField.style.display =
            'block';


        destinationFilterLabel.textContent =
            'LGA';


        resetSelect(
            destinationFilter,
            'Select LGA'
        );


        const lgas =
            getLGAs(
                senderState
            );


        if (!lgas.length) {

            showAlert(
                `No LGAs were found for ${capitalize(senderState)}.`
            );

            return;
        }


        lgas.forEach(
            lga => {

                const option =
                    document.createElement(
                        'option'
                    );


                option.value =
                    lga;


                option.textContent =
                    lga;


                destinationFilter.appendChild(
                    option
                );

            }
        );


        destinationFilter.onchange =
            function()
            {

                clearReceiver();


                const lga =
                    this.value;


                if (!lga) {
                    return;
                }


                const lgaFacilities =
                    getLgaFacilities(
                        senderState,
                        lga
                    );


                resetSelect(
                    receiver,
                    'Select facility'
                );


                lgaFacilities.forEach(
                    facility => {

                        const option =
                            document.createElement(
                                'option'
                            );


                        option.value =
                            facility.id;


                        option.textContent =
                            facility.name;


                        receiver.appendChild(
                            option
                        );

                    }
                );


                receiverHelp.textContent =
                    lgaFacilities.length
                        ? `Select the facility in ${lga}.`
                        : `No facilities found in ${lga}.`;

            };


        return;
    }

}


function handleStateRouting1(
    type
) {

    clearReceiver();


    /*
    |--------------------------------------------------------------------------
    | Return to zonal store
    |--------------------------------------------------------------------------
    */

    if (type === 'return') {

        destinationFilterField
            .style
            .display =
            'none';


        const zonalStore =
            getZonalStore(
                senderZone
            );


        if (!zonalStore) {

            showAlert(
                'Unable to determine the zonal store for this state.'
            );

            return;
        }


        fixedReceiver.style.display =
            'block';


        fixedReceiver.innerHTML =
            `
            <strong>Receiver:</strong>
            ${escapeHtml(zonalStore.name)}
            `;


        setCurrentReceiver(
            zonalStore.id,
            'zonal',
            zonalStore.name
        );


        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Supply / Transfer to facility
    |--------------------------------------------------------------------------
    */

    destinationFilterField
        .style
        .display =
        'block';


    destinationFilterLabel
        .textContent =
        'LGA';


    resetSelect(
        destinationFilter,
        'Select LGA'
    );


    const lgas =
        getLGAs(
            senderState
        );


    if (!lgas.length) {

        showAlert(
            `No LGAs were found for ${capitalize(senderState)}.`
        );

        return;
    }


    lgas.forEach(
        lga => {

            const option =
                document.createElement(
                    'option'
                );


            option.value =
                lga;


            option.textContent =
                lga;


            destinationFilter
                .appendChild(
                    option
                );

        }
    );


    destinationFilter.onchange =
        function()
        {

            clearReceiver();


            const lga =
                this.value;


            if (!lga) {
                return;
            }


            const lgaFacilities =
                getLgaFacilities(
                    senderState,
                    lga
                );


            resetSelect(
                receiver,
                'Select facility'
            );


            lgaFacilities.forEach(
                facility => {

                    const option =
                        document.createElement(
                            'option'
                        );


                    option.value =
                        facility.id;


                    option.textContent =
                        facility.name;


                    receiver.appendChild(
                        option
                    );

                }
            );


            receiverHelp.textContent =
                lgaFacilities.length
                    ? `Select the facility in ${lga}.`
                    : `No facilities found in ${lga}.`;

        };

}



/*
|--------------------------------------------------------------------------
| Receiver changed
|--------------------------------------------------------------------------
*/


receiver.addEventListener(
    'change',
    function()
    {

        const selected =
            this.options[
                this.selectedIndex
            ];


        if (
            !this.value ||
            !selected
        ) {

            clearReceiver();

            return;
        }


        let receiverType =
            'facility';


        if (
            this.value.includes(
                '_state_store'
            )
        ) {

            receiverType =
                'state';

        }


        if (
            this.value.includes(
                '_zonal_store'
            )
        ) {

            receiverType =
                'zonal';

        }


        if (
            this.value ===
            'fcms_national_store'
        ) {

            receiverType =
                'national';

        }


        setCurrentReceiver(
            this.value,
            receiverType,
            selected.textContent.trim()
        );

    }
);



/*
|--------------------------------------------------------------------------
| ADD BUTTON
|--------------------------------------------------------------------------
*/


addButton.addEventListener(
    'click',
    function()
    {

        if (!currentReceiver) {

            showAlert(
                'Please select a receiver first.'
            );

            return;
        }


        hideAlert();


        items.push({

            product_id: '',

            mode: 'manual',

            batch_id: '',

            quantity: 0,

            cases: 0

        });


        renderItems();

    }
);



/*
|--------------------------------------------------------------------------
| RENDER ITEMS
|--------------------------------------------------------------------------
*/


function renderItems()
{

    if (!items.length) {

        itemsContainer.innerHTML =
            `
            <div class="empty-message">
                Add or remove items to be sent
            </div>
            `;


        sendButton.disabled =
            true;


        return;
    }


    itemsContainer.innerHTML =
        '';


    items.forEach(
        (item, index) => {

            const row =
                document.createElement(
                    'div'
                );


            row.className =
                'item-row';


            row.innerHTML =
                `

                <div>

                    <div class="serial">
                        ${index + 1}
                    </div>

                </div>


                <div>

                    <select
                        data-index="${index}"
                        class="product-select"
                    >

                        <option value="">
                            Select a product
                        </option>

                        ${products
                            .map(
                                product =>
                                    `
                                    <option
                                        value="${escapeHtml(product.id)}"
                                        ${item.product_id === product.id
                                            ? 'selected'
                                            : ''}
                                    >
                                        ${escapeHtml(product.name)}
                                    </option>
                                    `
                            )
                            .join('')}

                    </select>

                </div>


                <div>

                    <select
                        data-index="${index}"
                        class="mode-select"
                    >

                        <option
                            value="manual"
                            ${item.mode === 'manual'
                                ? 'selected'
                                : ''}
                        >
                            Manual
                        </option>

                        <option
                            value="auto"
                            ${item.mode === 'auto'
                                ? 'selected'
                                : ''}
                        >
                            Auto
                        </option>

                    </select>

                </div>


                <div>

                    <select
                        data-index="${index}"
                        class="batch-select"
                    >

                        <option value="">
                            Select Batch
                        </option>

                    </select>


                    <div
                        class="batch-info"
                        data-info-index="${index}"
                    ></div>


                    <div
                        class="stock-warning"
                        data-warning-index="${index}"
                    ></div>

                </div>


                <div>

                    <input
                        type="number"
                        min="0"
                        step="any"
                        value="${item.quantity || 0}"
                        data-index="${index}"
                        class="quantity-input"
                        placeholder="0"
                    >

                </div>


                <div>

                    <button
                        type="button"
                        class="remove-btn"
                        data-index="${index}"
                    >
                        −
                    </button>

                </div>

                `;


            itemsContainer.appendChild(
                row
            );


            /*
            |--------------------------------------------------------------------------
            | Populate existing batch selection
            |--------------------------------------------------------------------------
            */

            const batchSelect =
                row.querySelector(
                    '.batch-select'
                );


            renderBatchOptions(
                batchSelect,
                item.product_id,
                item.batch_id
            );


            updateBatchInfo(
                index
            );

        }
    );


    attachRowListeners();


    validateItems();

}



/*
|--------------------------------------------------------------------------
| ROW LISTENERS
|--------------------------------------------------------------------------
*/


function attachRowListeners()
{

    /*
    |--------------------------------------------------------------------------
    | Product
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.product-select'
        )
        .forEach(
            select => {

                select.addEventListener(
                    'change',
                    function()
                    {

                        const index =
                            Number(
                                this.dataset.index
                            );


                        items[index]
                            .product_id =
                            this.value;


                        /*
                        | Reset batch whenever
                        | product changes.
                        */

                        items[index]
                            .batch_id =
                            '';


                        items[index]
                            .quantity =
                            0;


                        const row =
                            this.closest(
                                '.item-row'
                            );


                        const batchSelect =
                            row.querySelector(
                                '.batch-select'
                            );


                        const quantityInput =
                            row.querySelector(
                                '.quantity-input'
                            );


                        renderBatchOptions(
                            batchSelect,
                            this.value
                        );


                        quantityInput.value =
                            '0';


                        updateBatchInfo(
                            index
                        );


                        validateItems();

                    }
                );

            }
        );



    /*
    |--------------------------------------------------------------------------
    | Mode
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.mode-select'
        )
        .forEach(
            select => {

                select.addEventListener(
                    'change',
                    function()
                    {

                        const index =
                            Number(
                                this.dataset.index
                            );


                        items[index]
                            .mode =
                            this.value;


                        /*
                        | Auto mode:
                        |
                        | For now select the first
                        | available batch.
                        |
                        | Later we can implement
                        | proper FEFO rules.
                        */

                        if (
                            this.value ===
                            'auto'
                        ) {

                            autoSelectBatch(
                                index
                            );

                        }

                    }
                );

            }
        );



    /*
    |--------------------------------------------------------------------------
    | Batch
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.batch-select'
        )
        .forEach(
            select => {

                select.addEventListener(
                    'change',
                    function()
                    {

                        const index =
                            Number(
                                this.dataset.index
                            );


                        items[index]
                            .batch_id =
                            this.value;


                        /*
                        | Reset quantity when
                        | changing batch.
                        */

                        items[index]
                            .quantity =
                            0;


                        const row =
                            this.closest(
                                '.item-row'
                            );


                        const quantityInput =
                            row.querySelector(
                                '.quantity-input'
                            );


                        quantityInput.value =
                            '0';


                        updateBatchInfo(
                            index
                        );


                        validateItems();

                    }
                );

            }
        );



    /*
    |--------------------------------------------------------------------------
    | Quantity
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.quantity-input'
        )
        .forEach(
            input => {

                input.addEventListener(
                    'input',
                    function()
                    {

                        const index =
                            Number(
                                this.dataset.index
                            );


                        let quantity =
                            Number(
                                this.value
                            );


                        if (
                            Number.isNaN(
                                quantity
                            )
                        ) {

                            quantity =
                                0;

                        }


                        const item =
                            items[index];


                        const batch =
                            findBatch(
                                item.product_id,
                                item.batch_id
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Check available quantity
                        |--------------------------------------------------------------------------
                        */

                        if (
                            batch &&
                            quantity >
                            Number(
                                batch.available_quantity
                            )
                        ) {

                            quantity =
                                Number(
                                    batch.available_quantity
                                );


                            this.value =
                                quantity;


                            showStockWarning(
                                index,
                                `Only ${quantity} is available in this batch.`
                            );

                        }
                        else {

                            hideStockWarning(
                                index
                            );

                        }


                        item.quantity =
                            quantity;


                        validateItems();

                    }
                );

            }
        );



    /*
    |--------------------------------------------------------------------------
    | Remove
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.remove-btn'
        )
        .forEach(
            button => {

                button.addEventListener(
                    'click',
                    function()
                    {

                        items.splice(
                            Number(
                                this.dataset.index
                            ),
                            1
                        );


                        renderItems();

                    }
                );

            }
        );

}



/*
|--------------------------------------------------------------------------
| AUTO SELECT BATCH
|--------------------------------------------------------------------------
*/


function autoSelectBatch(
    index
) {

    const item =
        items[index];


    if (!item.product_id) {
        return;
    }


    const availableBatches =
        getProductBatches(
            item.product_id
        );


    if (!availableBatches.length) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | The controller already orders batches
    | by expiry date.
    |
    | Therefore the first one is used here.
    |--------------------------------------------------------------------------
    */

    const batch =
        availableBatches[0];


    item.batch_id =
        batch.batch_id;


    const row =
        document.querySelector(
            `.batch-select[data-index="${index}"]`
        );


    if (row) {

        row.value =
            batch.batch_id;

    }


    updateBatchInfo(
        index
    );


    validateItems();

}



/*
|--------------------------------------------------------------------------
| BATCH INFORMATION
|--------------------------------------------------------------------------
*/


function updateBatchInfo(
    index
) {

    const item =
        items[index];


    const info =
        document.querySelector(
            `[data-info-index="${index}"]`
        );


    if (!info) {
        return;
    }


    if (
        !item.product_id ||
        !item.batch_id
    ) {

        info.textContent =
            '';

        hideStockWarning(
            index
        );

        return;
    }


    const batch =
        findBatch(
            item.product_id,
            item.batch_id
        );


    if (!batch) {

        info.textContent =
            'Batch not found.';

        return;
    }


    const available =
        Number(
            batch.available_quantity || 0
        );


    const expiry =
        batch.expiry_date
            ? formatDate(
                batch.expiry_date
            )
            : 'No expiry';


    info.textContent =
        `Available: ${available} | Expiry: ${expiry}`;


    hideStockWarning(
        index
    );

}



/*
|--------------------------------------------------------------------------
| STOCK WARNING
|--------------------------------------------------------------------------
*/


function showStockWarning(
    index,
    message
) {

    const warning =
        document.querySelector(
            `[data-warning-index="${index}"]`
        );


    if (!warning) {
        return;
    }


    warning.textContent =
        message;


    warning.style.display =
        'block';

}


function hideStockWarning(
    index
) {

    const warning =
        document.querySelector(
            `[data-warning-index="${index}"]`
        );


    if (!warning) {
        return;
    }


    warning.textContent =
        '';


    warning.style.display =
        'none';

}



/*
|--------------------------------------------------------------------------
| VALIDATE ITEMS
|--------------------------------------------------------------------------
*/


function validateItems()
{

    if (!currentReceiver) {

        sendButton.disabled =
            true;

        return;
    }


    if (!shipmentType.value) {

        sendButton.disabled =
            true;

        return;
    }


    if (!shipmentDate.value) {

        sendButton.disabled =
            true;

        return;
    }


    if (!items.length) {

        sendButton.disabled =
            true;

        return;
    }


    const valid =
        items.every(
            item => {

                if (
                    !item.product_id
                ) {
                    return false;
                }


                if (
                    !item.batch_id
                ) {
                    return false;
                }


                if (
                    Number(
                        item.quantity
                    ) <= 0
                ) {
                    return false;
                }


                const batch =
                    findBatch(
                        item.product_id,
                        item.batch_id
                    );


                if (!batch) {
                    return false;
                }


                if (
                    Number(
                        item.quantity
                    ) >
                    Number(
                        batch.available_quantity
                    )
                ) {
                    return false;
                }


                return true;

            }
        );


    sendButton.disabled =
        !valid;

}



/*
|--------------------------------------------------------------------------
| SEND SHIPMENT
|--------------------------------------------------------------------------
*/


sendButton.addEventListener(
    'click',
    async function()
    {

        hideAlert();


        /*
        |--------------------------------------------------------------------------
        | Final client validation
        |--------------------------------------------------------------------------
        */

        if (!shipmentDate.value) {

            showAlert(
                'Please select the shipment date.'
            );

            return;
        }


        if (!shipmentType.value) {

            showAlert(
                'Please select the delivery type.'
            );

            return;
        }


        if (!currentReceiver) {

            showAlert(
                'Please select a receiver.'
            );

            return;
        }


        if (!items.length) {

            showAlert(
                'Add at least one product.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Validate every item again
        |--------------------------------------------------------------------------
        */

        for (
            let index = 0;
            index < items.length;
            index++
        ) {

            const item =
                items[index];


            if (!item.product_id) {

                showAlert(
                    `Please select a product for item ${index + 1}.`
                );

                return;
            }


            if (!item.batch_id) {

                showAlert(
                    `Please select a batch for item ${index + 1}.`
                );

                return;
            }


            if (
                Number(
                    item.quantity
                ) <= 0
            ) {

                showAlert(
                    `Please enter a quantity for item ${index + 1}.`
                );

                return;
            }


            const batch =
                findBatch(
                    item.product_id,
                    item.batch_id
                );


            if (!batch) {

                showAlert(
                    `The selected batch for item ${index + 1} is no longer available.`
                );

                return;
            }


            if (
                Number(
                    item.quantity
                ) >
                Number(
                    batch.available_quantity
                )
            ) {

                showAlert(
                    `Item ${index + 1} exceeds available batch stock.`
                );

                return;
            }

        }



        /*
        |--------------------------------------------------------------------------
        | Payload
        |--------------------------------------------------------------------------
        */

        const payload = {

            shipment_date:
                shipmentDate.value,


            sender_type:
                senderType,


            sender_id:
                senderId,


            shipment_type:
                shipmentType.value,


            receiver_type:
                currentReceiver.type,


            receiver_id:
                currentReceiver.id,


            receiver_name:
                currentReceiver.name,


            items:
                items.map(
                    item => ({

                        product_id:
                            item.product_id,

                        quantity:
                            item.quantity,

                        batch_id:
                            item.batch_id,

                        cases:
                            item.cases || 0

                    })
                )

        };



        /*
        |--------------------------------------------------------------------------
        | Disable button while submitting
        |--------------------------------------------------------------------------
        */

        sendButton.disabled =
            true;


        sendButton.innerHTML =
            `
            <span class="loading"></span>
            Sending...
            `;



        try {

            const response =
                await fetch(
                    '{{ route('shipments.store') }}',
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .getAttribute(
                                        'content'
                                    )

                        },


                        body:
                            JSON.stringify(
                                payload
                            )

                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Unable to create shipment.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            showAlert(
                data.message ||
                'Shipment validated successfully.',
                'success'
            );


            /*
            | Clear products.
            */

            items = [];


            renderItems();


        }
        catch (error) {

            showAlert(
                error.message ||
                'Unable to create shipment.'
            );

        }
        finally {

            sendButton.innerHTML =
                '🚚 &nbsp; Send Products';


            validateItems();

        }

    }
);



/*
|--------------------------------------------------------------------------
| INITIAL STATE
|--------------------------------------------------------------------------
*/

shipmentType.value =
    '';


destinationFilterField
    .style
    .display =
    'block';


receiverBox
    .style
    .display =
    'block';


clearReceiver();


renderItems();



/*
|--------------------------------------------------------------------------
| Debug information
|--------------------------------------------------------------------------
|
| You can temporarily uncomment these while testing.
|
| console.log('Shipment setup:', setup);
| console.log('Sender:', senderId);
| console.log('Batches:', batches);
| console.log('Facilities:', facilities);
|
|--------------------------------------------------------------------------
*/

</script>


</body>

</html>