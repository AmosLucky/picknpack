<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

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

        .title {
            font-size: 17px;
            font-weight: 600;
        }

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
        }

        .hidden {
            display: none !important;
        }

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
                180px
                130px
                60px;

            padding: 14px 16px;
            background: #fff;
            border-bottom: 1px solid #e1e6ef;
            font-size: 13px;
            font-weight: 600;
        }

        .item-row {
            display: grid;
            grid-template-columns:
                60px
                minmax(250px, 1fr)
                150px
                180px
                130px
                60px;

            gap: 0;
            padding: 12px 16px;
            border-bottom: 1px solid #edf0f5;
            align-items: center;
        }

        .item-row select,
        .item-row input {
            height: 40px;
            width: calc(100% - 12px);
            border: 1px solid #dce3ee;
            border-radius: 6px;
            padding: 0 10px;
        }

        .serial {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-btn {
            width: 34px;
            height: 34px;
            border: 1px solid #fecaca;
            background: #fff;
            color: #dc2626;
            border-radius: 6px;
            cursor: pointer;
        }

        .empty-message {
            text-align: center;
            padding: 28px;
            color: #64748b;
            font-size: 14px;
        }

        .footer {
            margin-top: 22px;
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

        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            display: none;
        }

        .alert.error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert.success {
            background: #dcfce7;
            color: #166534;
        }

        @media (max-width: 900px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }

            .items-header,
            .item-row {
                min-width: 900px;
            }

            .items-section {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

<div class="shipment-page">

    <div class="topbar">

        <button
            type="button"
            class="back-btn"
            onclick="history.back()"
        >
            ← &nbsp; Back
        </button>

        <div class="title">
            Select product, delivery type & receiver
        </div>

        <div style="width:100px"></div>

    </div>


    <div id="alert"
         class="alert">
    </div>


    {{-- ========================================================= --}}
    {{-- TEMPORARY SENDER SELECTION --}}
    {{-- ========================================================= --}}

    <div class="setup-card">

        <div class="section-title">
            Shipment source
        </div>

        <div class="form-grid">

            <div class="field">

                <label>
                    Who are you?
                </label>

                <select id="sender_type">

                    <option value="">
                        Select type
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


            <div class="field hidden"
                 id="sender_location_field">

                <label id="sender_location_label">
                    Location
                </label>

                <select id="sender_location">
                    <option value="">
                        Select
                    </option>
                </select>

            </div>


            <div class="field hidden"
                 id="shipment_type_field">

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


            <div class="field hidden"
                 id="destination_filter_field">

                <label id="destination_filter_label">
                    Destination
                </label>

                <select id="destination_filter">

                    <option value="">
                        Select
                    </option>

                </select>

            </div>

        </div>


        <div class="receiver-box hidden"
             id="receiver_box">

            <div class="form-grid">

                <div class="field"
                     id="receiver_field">

                    <label>
                        Receiver
                    </label>

                    <select id="receiver">

                        <option value="">
                            Select a receiver
                        </option>

                    </select>

                </div>

            </div>

            <div
                id="fixed_receiver"
                class="fixed-receiver hidden">
            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PRODUCTS --}}
    {{-- ========================================================= --}}

    <div class="items-section">

        <div class="items-header">

            <div>S/N</div>
            <div>Product Name</div>
            <div>Mode</div>
            <div>Batch Selection</div>
            <div>Quantity</div>
            <div></div>

        </div>


        <div id="items_container">

            <div class="empty-message"
                 id="empty_message">

                Add or remove items to be sent

            </div>

        </div>

    </div>


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
            style="float:right"
            disabled
        >
            ⊕ &nbsp; Add
        </button>

    </div>

</div>


<script>

const zones = @json($zones);
const states = @json($states);
const stores = @json($stores);
const products = @json($products);

const csrfToken =
    document.querySelector('meta[name="csrf-token"]').getAttribute('content');


const senderType =
    document.getElementById('sender_type');

const senderLocation =
    document.getElementById('sender_location');

const senderLocationField =
    document.getElementById('sender_location_field');

const senderLocationLabel =
    document.getElementById('sender_location_label');

const shipmentType =
    document.getElementById('shipment_type');

const shipmentTypeField =
    document.getElementById('shipment_type_field');

const destinationFilter =
    document.getElementById('destination_filter');

const destinationFilterField =
    document.getElementById('destination_filter_field');

const destinationFilterLabel =
    document.getElementById('destination_filter_label');

const receiver =
    document.getElementById('receiver');

const receiverBox =
    document.getElementById('receiver_box');

const receiverField =
    document.getElementById('receiver_field');

const fixedReceiver =
    document.getElementById('fixed_receiver');

const addButton =
    document.getElementById('add_button');

const sendButton =
    document.getElementById('send_button');

const itemsContainer =
    document.getElementById('items_container');

const emptyMessage =
    document.getElementById('empty_message');

const alertBox =
    document.getElementById('alert');


let items = [];



/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function showAlert(message, type = 'error')
{
    alertBox.textContent = message;

    alertBox.className =
        'alert ' + type;

    alertBox.style.display = 'block';
}


function hideAlert()
{
    alertBox.style.display = 'none';
}


function resetSelect(select, placeholder)
{
    select.innerHTML =
        `<option value="">${placeholder}</option>`;
}


function getStateStoreId(state)
{
    return `${state}_state_store`;
}


function getStoreName(storeId)
{
    const store = stores.find(
        item => item.id === storeId
    );

    if (store) {
        return store.name;
    }

    const state = storeId.replace(
        '_state_store',
        ''
    );

    return `${state} State Store`;
}


/*
|--------------------------------------------------------------------------
| Sender type changed
|--------------------------------------------------------------------------
*/

senderType.addEventListener('change', function()
{
    hideAlert();

    const type = this.value;

    resetSelect(
        senderLocation,
        'Select'
    );

    senderLocationField.classList.add('hidden');
    shipmentTypeField.classList.add('hidden');

    destinationFilterField.classList.add('hidden');
    receiverBox.classList.add('hidden');

    if (!type) {
        return;
    }


    if (type === 'national') {

        senderLocationField.classList.remove('hidden');

        senderLocationLabel.textContent =
            'Sender';

        senderLocation.innerHTML = `
            <option value="fcms_national_store">
                National Store
            </option>
        `;

        senderLocation.value =
            'fcms_national_store';

        shipmentTypeField.classList.remove('hidden');

        return;
    }


    if (type === 'zonal') {

        senderLocationField.classList.remove('hidden');

        senderLocationLabel.textContent =
            'Zone';

        zones.forEach(zone => {

            senderLocation.insertAdjacentHTML(
                'beforeend',
                `
                <option value="${zone.id}">
                    ${zone.name}
                </option>
                `
            );

        });

        shipmentTypeField.classList.remove('hidden');

        return;
    }


    if (type === 'state') {

        senderLocationField.classList.remove('hidden');

        senderLocationLabel.textContent =
            'State';

        states.forEach(item => {

            senderLocation.insertAdjacentHTML(
                'beforeend',
                `
                <option value="${item.state}">
                    ${capitalize(item.state)}
                </option>
                `
            );

        });

        shipmentTypeField.classList.remove('hidden');

        return;
    }
});



/*
|--------------------------------------------------------------------------
| Shipment type changed
|--------------------------------------------------------------------------
*/

shipmentType.addEventListener(
    'change',
    loadRouting
);



senderLocation.addEventListener(
    'change',
    loadRouting
);



async function loadRouting()
{
    hideAlert();

    destinationFilterField.classList.add('hidden');
    receiverBox.classList.add('hidden');

    resetSelect(
        destinationFilter,
        'Select'
    );

    resetSelect(
        receiver,
        'Select a receiver'
    );

    fixedReceiver.classList.add('hidden');

    const type =
        senderType.value;

    const location =
        senderLocation.value;

    const delivery =
        shipmentType.value;


    if (!type || !location || !delivery) {
        return;
    }


    let senderId = location;

    if (type === 'zonal') {
        senderId = `${location}_zonal_store`;
    }

    if (type === 'state') {
        senderId = `${location}_state_store`;
    }


    const params = new URLSearchParams({

        sender_type: type,

        sender_id: senderId,

        shipment_type: delivery,

    });


    const response =
        await fetch(
            `{{ route('shipments.receivers') }}?${params.toString()}`
        );


    const data =
        await response.json();


    if (!response.ok) {

        showAlert(
            data.message ||
            'Unable to determine shipment route.'
        );

        return;
    }


    window.currentRouting = {
        senderType: type,
        senderId: senderId,
        shipmentType: delivery,
        data: data
    };


    /*
    |--------------------------------------------------------------------------
    | Fixed receiver
    |--------------------------------------------------------------------------
    */

    if (data.fixed_receiver) {

        receiverBox.classList.remove('hidden');

        receiverField.classList.add('hidden');

        fixedReceiver.classList.remove('hidden');

        fixedReceiver.innerHTML = `
            <strong>Receiver:</strong>
            ${escapeHtml(data.fixed_receiver.name)}
        `;

        window.currentReceiver = {
            id: data.fixed_receiver.id,
            type: data.receiver_type,
            name: data.fixed_receiver.name
        };

        enableAdd();

        return;
    }


    receiverField.classList.remove('hidden');

    receiverBox.classList.remove('hidden');


    /*
    |--------------------------------------------------------------------------
    | Zonal destinations
    |--------------------------------------------------------------------------
    */

    if (data.receiver_type === 'zonal') {

        destinationFilterField.classList.remove('hidden');

        destinationFilterLabel.textContent =
            'Zone';

        data.receivers.forEach(store => {

            destinationFilter.insertAdjacentHTML(
                'beforeend',
                `
                <option value="${store.id}">
                    ${escapeHtml(store.name)}
                </option>
                `
            );

        });

        destinationFilter.onchange = function() {

            const selected =
                data.receivers.find(
                    item => item.id === this.value
                );

            resetSelect(
                receiver,
                'Select a receiver'
            );

            if (selected) {

                receiver.insertAdjacentHTML(
                    'beforeend',
                    `
                    <option value="${selected.id}">
                        ${escapeHtml(selected.name)}
                    </option>
                    `
                );

                receiver.value =
                    selected.id;

                setCurrentReceiver(
                    selected.id,
                    data.receiver_type,
                    selected.name
                );
            }
        };

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | State destinations
    |--------------------------------------------------------------------------
    */

    if (data.receiver_type === 'state') {

        destinationFilterField.classList.remove('hidden');

        destinationFilterLabel.textContent =
            'State';

        data.states.forEach(state => {

            destinationFilter.insertAdjacentHTML(
                'beforeend',
                `
                <option value="${state.state}">
                    ${capitalize(state.state)}
                </option>
                `
            );

        });

        destinationFilter.onchange =
            function()
            {
                const state =
                    this.value;

                if (!state) {
                    return;
                }

                resetSelect(
                    receiver,
                    'Select a receiver'
                );

                receiver.insertAdjacentHTML(
                    'beforeend',
                    `
                    <option value="${getStateStoreId(state)}">
                        ${capitalize(state)} State Store
                    </option>
                    `
                );

                receiver.value =
                    getStateStoreId(state);

                setCurrentReceiver(
                    getStateStoreId(state),
                    'state',
                    `${capitalize(state)} State Store`
                );
            };

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Facility destination
    |--------------------------------------------------------------------------
    */

    if (data.receiver_type === 'facility') {

        destinationFilterField.classList.remove('hidden');

        destinationFilterLabel.textContent =
            'LGA';

        await loadLGAs(
            data.state
        );

        return;
    }
}



/*
|--------------------------------------------------------------------------
| Load LGAs
|--------------------------------------------------------------------------
*/

async function loadLGAs(state)
{
    const response =
        await fetch(
            `{{ route('shipments.lgas') }}?state=${encodeURIComponent(state)}`
        );

    const lgas =
        await response.json();


    lgas.forEach(lga => {

        destinationFilter.insertAdjacentHTML(
            'beforeend',
            `
            <option value="${escapeHtml(lga)}">
                ${escapeHtml(lga)}
            </option>
            `
        );

    });


    destinationFilter.onchange =
        async function()
        {
            if (!this.value) {
                return;
            }

            await loadFacilities(
                state,
                this.value
            );
        };
}



/*
|--------------------------------------------------------------------------
| Load facilities
|--------------------------------------------------------------------------
*/

async function loadFacilities(
    state,
    lga
)
{
    const response =
        await fetch(
            `{{ route('shipments.facilities') }}?state=${encodeURIComponent(state)}&lga=${encodeURIComponent(lga)}`
        );


    const facilities =
        await response.json();


    resetSelect(
        receiver,
        'Select a receiver'
    );


    facilities.forEach(facility => {

        receiver.insertAdjacentHTML(
            'beforeend',
            `
            <option value="${facility.id}">
                ${escapeHtml(facility.name)}
            </option>
            `
        );

    });


    receiver.onchange =
        function()
        {
            const selected =
                facilities.find(
                    item => item.id === this.value
                );

            if (!selected) {
                return;
            }

            setCurrentReceiver(
                selected.id,
                'facility',
                selected.name
            );
        };
}



/*
|--------------------------------------------------------------------------
| Receiver selection
|--------------------------------------------------------------------------
*/

receiver.addEventListener(
    'change',
    function()
    {
        if (!this.value) {
            return;
        }

        const option =
            this.options[
                this.selectedIndex
            ];

        setCurrentReceiver(
            this.value,
            window.currentRouting?.data?.receiver_type || '',
            option.textContent.trim()
        );
    }
);


function setCurrentReceiver(
    id,
    type,
    name
)
{
    window.currentReceiver = {
        id,
        type,
        name
    };

    enableAdd();
}



/*
|--------------------------------------------------------------------------
| Add product row
|--------------------------------------------------------------------------
*/

addButton.addEventListener(
    'click',
    function()
    {
        addProductRow();
    }
);


function enableAdd()
{
    addButton.disabled =
        !window.currentReceiver;
}


function addProductRow()
{
    if (!window.currentReceiver) {
        showAlert(
            'Please select a receiver first.'
        );

        return;
    }

    hideAlert();

    const item = {
        product_id: '',
        mode: 'manual',
        batch_id: '',
        quantity: 0,
        cases: 0
    };

    items.push(item);

    renderItems();
}



/*
|--------------------------------------------------------------------------
| Render product rows
|--------------------------------------------------------------------------
*/

function renderItems()
{
    if (!items.length) {

        itemsContainer.innerHTML =
            `<div class="empty-message">
                Add or remove items to be sent
            </div>`;

        sendButton.disabled =
            true;

        return;
    }


    itemsContainer.innerHTML = '';


    items.forEach(
        (item, index) =>
        {

            const row =
                document.createElement('div');

            row.className =
                'item-row';


            row.innerHTML = `

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

                        ${products.map(product => `
                            <option
                                value="${product.id}"
                                ${item.product_id === product.id ? 'selected' : ''}
                            >
                                ${escapeHtml(product.name)}
                            </option>
                        `).join('')}

                    </select>
                </div>

                <div>
                    <select
                        data-index="${index}"
                        class="mode-select"
                    >
                        <option
                            value="manual"
                            ${item.mode === 'manual' ? 'selected' : ''}
                        >
                            Manual
                        </option>

                        <option
                            value="auto"
                            ${item.mode === 'auto' ? 'selected' : ''}
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
                </div>

                <div>
                    <input
                        type="number"
                        min="0"
                        step="any"
                        value="${item.quantity}"
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


            itemsContainer.appendChild(row);
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Product changes
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.product-select'
    ).forEach(select => {

        select.addEventListener(
            'change',
            function()
            {
                items[
                    Number(this.dataset.index)
                ].product_id = this.value;

                validateItems();
            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Mode changes
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.mode-select'
    ).forEach(select => {

        select.addEventListener(
            'change',
            function()
            {
                items[
                    Number(this.dataset.index)
                ].mode = this.value;
            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Quantity
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.quantity-input'
    ).forEach(input => {

        input.addEventListener(
            'input',
            function()
            {
                items[
                    Number(this.dataset.index)
                ].quantity =
                    Number(this.value);

                validateItems();
            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Remove
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.remove-btn'
    ).forEach(button => {

        button.addEventListener(
            'click',
            function()
            {
                items.splice(
                    Number(this.dataset.index),
                    1
                );

                renderItems();
            }
        );

    });


    validateItems();
}



/*
|--------------------------------------------------------------------------
| Validate product rows
|--------------------------------------------------------------------------
*/

function validateItems()
{
    const valid =
        items.length > 0 &&
        items.every(item =>
            item.product_id &&
            Number(item.quantity) > 0
        );

    sendButton.disabled =
        !valid;
}



/*
|--------------------------------------------------------------------------
| Send shipment
|--------------------------------------------------------------------------
*/

sendButton.addEventListener(
    'click',
    async function()
    {
        if (!window.currentReceiver) {

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


        const shipmentDate =
            new Date()
                .toISOString()
                .substring(0, 10);


        const payload = {

            shipment_date:
                shipmentDate,

            sender_type:
                window.currentRouting.senderType,

            sender_id:
                window.currentRouting.senderId,

            shipment_type:
                window.currentRouting.shipmentType,

            receiver_type:
                window.currentReceiver.type,

            receiver_id:
                window.currentReceiver.id,

            receiver_name:
                window.currentReceiver.name,

            items: items.map(item => ({
                product_id:
                    item.product_id,

                quantity:
                    item.quantity,

                batch_id:
                    item.batch_id || null,

                cases:
                    item.cases || 0
            }))
        };


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
                            csrfToken
                    },

                    body:
                        JSON.stringify(payload)
                }
            );


        const data =
            await response.json();


        if (!response.ok) {

            showAlert(
                data.message ||
                'Unable to create shipment.'
            );

            return;
        }


        showAlert(
            data.message,
            'success'
        );


        items = [];

        renderItems();
    }
);



function capitalize(value)
{
    if (!value) {
        return '';
    }

    return value.charAt(0).toUpperCase()
        + value.slice(1);
}


function escapeHtml(value)
{
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

</script>

</body>
</html>