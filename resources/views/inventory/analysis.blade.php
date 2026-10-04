@extends('layouts.app')

@section('header', 'Inventory Analysis')

@section('content')

<style>

    .analysis-page {
        padding: 18px 30px 50px;
        min-height: calc(100vh - 60px);
        background: #f8fafc;
    }

    .analysis-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .analysis-title {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .analysis-subtitle {
        margin-top: 4px;
        color: #64748b;
        font-size: 13px;
    }

    .settings-btn {
        border: 0;
        background: #111827;
        color: #fff;
        border-radius: 6px;
        padding: 10px 17px;
        font-weight: 600;
        cursor: pointer;
    }

    .toolbar {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 15px;
    }

    .search-box {
        flex: 1;
        position: relative;
    }

    .search-box input {
        width: 100%;
        height: 42px;
        border: 1px solid #d9e1eb;
        border-radius: 7px;
        background: #fff;
        padding: 0 15px 0 40px;
        outline: none;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 11px;
        color: #64748b;
    }

    .active-filter {
        padding: 10px 14px;
        border-radius: 6px;
        background: #eef2ff;
        color: #3730a3;
        font-size: 12px;
        font-weight: 600;
    }

    .table-card {
        background: #fff;
        border: 1px solid #dce3eb;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 7px rgba(15,23,42,.04);
    }

    .analysis-table {
        width: 100%;
        border-collapse: collapse;
    }

    .analysis-table thead th {
        padding: 14px 13px;
        background: #f1f5f9;
        border-bottom: 1px solid #dce3eb;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
    }

    .analysis-table tbody td {
        padding: 14px 13px;
        border-bottom: 1px solid #e5eaf0;
        color: #111827;
        font-size: 13px;
    }

    .analysis-table tbody tr:hover {
        background: #f8fafc;
    }

    .product-name {
        color: #0056a6;
        font-weight: 500;
    }

    .store-name {
        color: #111827;
        font-weight: 600;
    }

    .number {
        text-align: right;
        white-space: nowrap;
    }

    .zero {
        color: #64748b;
    }

    .negative {
        color: #dc2626;
        font-weight: 600;
    }

    .drawer-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,.62);
        z-index: 1000;
    }

    .drawer-overlay.open {
        display: block;
    }

    .settings-drawer {
        position: absolute;
        top: 0;
        right: 0;
        width: 390px;
        max-width: 94vw;
        height: 100%;
        background: #fff;
        padding: 25px;
        overflow-y: auto;
        box-shadow: -8px 0 30px rgba(0,0,0,.15);
    }

    .drawer-title {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
    }

    .close-drawer {
        border: 0;
        background: transparent;
        font-size: 23px;
        cursor: pointer;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
    }

    .form-control,
    .form-select {
        width: 100%;
        height: 42px;
        border: 1px solid #d8e0e9;
        border-radius: 6px;
        padding: 0 11px;
        background: #fff;
        outline: none;
        margin-bottom: 18px;
    }

    .segmented {
        display: flex;
        border: 1px solid #d9e1eb;
        border-radius: 7px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .segmented label {
        flex: 1;
        padding: 10px;
        text-align: center;
        cursor: pointer;
        font-size: 13px;
    }

    .segmented input {
        display: none;
    }

    .segmented label.active {
        background: #111827;
        color: #fff;
    }

    .product-select {
        height: 160px !important;
        padding: 8px !important;
    }

    .drawer-actions {
        display: flex;
        gap: 10px;
        margin-top: 5px;
    }

    .btn-primary {
        border: 0;
        background: #111827;
        color: #fff;
        border-radius: 6px;
        padding: 10px 18px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-secondary {
        border: 1px solid #d9e1eb;
        background: #fff;
        color: #111827;
        border-radius: 6px;
        padding: 10px 18px;
        cursor: pointer;
    }

    .loading-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(255,255,255,.78);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 12px;
    }

    .loading-overlay.active {
        display: flex;
    }

    .spinner {
        width: 42px;
        height: 42px;
        border: 4px solid #dbe3ed;
        border-top-color: #111827;
        border-radius: 50%;
        animation: spin .8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .loading-text {
        font-size: 13px;
        color: #334155;
        font-weight: 600;
    }

    .empty-state {
        padding: 80px 20px;
        text-align: center;
        color: #64748b;
    }

    @media(max-width: 800px) {

        .analysis-page {
            padding: 15px;
        }

        .analysis-table {
            min-width: 900px;
        }

        .table-scroll {
            overflow-x: auto;
        }

        .settings-drawer {
            width: 360px;
        }
    }

</style>


<div class="analysis-page">

    <div class="analysis-header">

        <div>
            <h1 class="analysis-title">
                Inventory Analysis
            </h1>

            <div class="analysis-subtitle">
                Compare stock across national, zonal and state stores.
            </div>
        </div>

        <button
            type="button"
            class="settings-btn"
            onclick="openSettings()"
        >
            ⚙ Settings
        </button>

    </div>


    <form
        method="GET"
        action="{{ route('analytics.inventory') }}"
        id="searchForm"
    >

        <input
            type="hidden"
            name="inventory_type"
            value="{{ $inventoryType }}"
        >

        <input
            type="hidden"
            name="aggregation"
            value="{{ $aggregation }}"
        >

        <input
            type="hidden"
            name="scope"
            value="{{ $scope }}"
        >

        <input
            type="hidden"
            name="quarter"
            value="{{ $quarter }}"
        >

        @foreach($selectedProducts as $product)

            <input
                type="hidden"
                name="products[]"
                value="{{ $product }}"
            >

        @endforeach


        <div class="toolbar">

            <div class="search-box">

                <span class="search-icon">
                    🔎
                </span>

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search product or store..."
                >

            </div>


            <div class="active-filter">

                {{ ucfirst($inventoryType) }}

                ·

                {{ ucfirst($aggregation) }}

                @if($scope !== 'all')
                    · {{ strtoupper($scope) }}
                @endif

            </div>

        </div>

    </form>


    <div class="table-card">

        @if(empty($rows))

            <div class="empty-state">

                No inventory data found for the selected filters.

            </div>

        @else

            <div class="table-scroll">

                <table class="analysis-table">

                    <thead>

                        <tr>

                            <th style="width:55px;">
                                s/n
                            </th>

                            @if($aggregation === 'individual')

                                <th>
                                    Store
                                </th>

                            @endif

                            <th>
                                Product Name
                            </th>

                            <th class="number">
                                Opening Balance
                            </th>

                            <th class="number">
                                Quantity Received
                            </th>

                            <th class="number">
                                Quantity Issued
                            </th>

                            <th class="number">
                                Physical Balance
                            </th>

                            <th class="number">
                                Losses / Adjustments
                            </th>

                            <th>
                                Remarks
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($rows as $index => $row)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>


                                @if($aggregation === 'individual')

                                    <td class="store-name">

                                        {{ $row['store'] }}

                                        @if(!empty($row['state']))

                                            <div style="
                                                font-size:11px;
                                                color:#64748b;
                                                margin-top:3px;
                                            ">
                                                {{ ucfirst($row['state']) }}
                                            </div>

                                        @endif

                                    </td>

                                @endif


                                <td class="product-name">

                                    {{ $row['name'] }}

                                </td>


                                <td class="number">

                                    {{ number_format(
                                        $row['opening']
                                    ) }}

                                </td>


                                <td class="number">

                                    {{ number_format(
                                        $row['received']
                                    ) }}

                                </td>


                                <td class="number">

                                    {{ number_format(
                                        $row['issued']
                                    ) }}

                                </td>


                                <td class="number
                                    {{ $row['quantity'] < 0
                                        ? 'negative'
                                        : ''
                                    }}"
                                >

                                    {{ number_format(
                                        $row['quantity']
                                    ) }}

                                </td>


                                <td class="number">

                                    {{ number_format(
                                        $row['losses']
                                    ) }}

                                </td>


                                <td>
                                    —
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

</div>


{{-- SETTINGS DRAWER --}}

<div
    class="drawer-overlay"
    id="settingsOverlay"
>

    <div class="settings-drawer">

        <div class="drawer-title">

            <span>
                Inventory Settings
            </span>

            <button
                class="close-drawer"
                type="button"
                onclick="closeSettings()"
            >
                ×
            </button>

        </div>


        <form
            method="GET"
            action="{{ route('analytics.inventory') }}"
            id="settingsForm"
        >

            {{-- INVENTORY TYPE --}}

            <label class="form-label">
                Select inventory type
            </label>

            <div class="segmented">

                <label
                    class="{{ $inventoryType === 'current'
                        ? 'active'
                        : ''
                    }}"
                >

                    <input
                        type="radio"
                        name="inventory_type"
                        value="current"
                        {{ $inventoryType === 'current'
                            ? 'checked'
                            : ''
                        }}
                        onchange="toggleHistory(this)"
                    >

                    Current

                </label>


                <label
                    class="{{ $inventoryType === 'history'
                        ? 'active'
                        : ''
                    }}"
                >

                    <input
                        type="radio"
                        name="inventory_type"
                        value="history"
                        {{ $inventoryType === 'history'
                            ? 'checked'
                            : ''
                        }}
                        onchange="toggleHistory(this)"
                    >

                    History

                </label>

            </div>


            {{-- QUARTER --}}

            <div id="quarterField"
                style="{{ $inventoryType === 'history'
                    ? ''
                    : 'display:none;'
                }}"
            >

                <label class="form-label">
                    Select quarter
                </label>

                <select
                    name="quarter"
                    class="form-select"
                >

                    @foreach($quarters as $q)

                        <option
                            value="{{ $q }}"
                            {{ $quarter === $q
                                ? 'selected'
                                : ''
                            }}
                        >
                            {{ $q }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- AGGREGATION --}}

            <label class="form-label">
                Select aggregation type
            </label>

            <select
                name="aggregation"
                class="form-select"
            >

                <option
                    value="combine"
                    {{ $aggregation === 'combine'
                        ? 'selected'
                        : ''
                    }}
                >
                    Combine
                </option>

                <option
                    value="individual"
                    {{ $aggregation === 'individual'
                        ? 'selected'
                        : ''
                    }}
                >
                    Individual
                </option>

            </select>


            {{-- INVENTORY SCOPE --}}

            <label class="form-label">
                Select inventory
            </label>

            <select
                name="scope"
                class="form-select"
                id="scopeSelect"
            >

                <option
                    value="all"
                    {{ $scope === 'all'
                        ? 'selected'
                        : ''
                    }}
                >
                    All Stores
                </option>

                <option
                    value="national"
                    {{ $scope === 'national'
                        ? 'selected'
                        : ''
                    }}
                >
                    National Warehouse Only
                </option>

                <option value="nc_zone"
                    {{ $scope === 'nc_zone'
                        ? 'selected'
                        : ''
                    }}
                >
                    NC Warehouse Only
                </option>

                <option value="ne_zone"
                    {{ $scope === 'ne_zone'
                        ? 'selected'
                        : ''
                    }}
                >
                    NE Warehouse Only
                </option>

                <option value="nw_zone"
                    {{ $scope === 'nw_zone'
                        ? 'selected'
                        : ''
                    }}
                >
                    NW Warehouse Only
                </option>

                <option value="se_zone"
                    {{ $scope === 'se_zone'
                        ? 'selected'
                        : ''
                    }}
                >
                    SE Warehouse Only
                </option>

                <option value="ss_zone"
                    {{ $scope === 'ss_zone'
                        ? 'selected'
                        : ''
                    }}
                >
                    SS Warehouse Only
                </option>

                <option value="sw_zone"
                    {{ $scope === 'sw_zone'
                        ? 'selected'
                        : ''
                    }}
                >
                    SW Warehouse Only
                </option>

                <optgroup label="State Stores">

                    @foreach($states as $state)

                        <option
                            value="{{ $state['state'] }}_state"
                            {{ $scope === $state['state'].'_state'
                                ? 'selected'
                                : ''
                            }}
                        >
                            {{ Str::title($state['state']) }}
                            State Store
                        </option>

                    @endforeach

                </optgroup>

            </select>


            {{-- PRODUCTS --}}

            <label class="form-label">
                Select Products
            </label>

            <select
                name="products[]"
                class="form-select product-select"
                multiple
            >

                @foreach($products as $id => $name)

                    <option
                        value="{{ $id }}"
                        {{ in_array(
                            $id,
                            $selectedProducts,
                            true
                        )
                            ? 'selected'
                            : ''
                        }}
                    >
                        {{ $name }}
                    </option>

                @endforeach

            </select>


            <div style="
                font-size:11px;
                color:#64748b;
                margin-top:-10px;
                margin-bottom:18px;
            ">
                Hold Ctrl / Cmd to select multiple products.
            </div>


            <div class="drawer-actions">

                <button
                    type="button"
                    class="btn-secondary"
                    onclick="closeSettings()"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn-primary"
                    onclick="showLoader()"
                >
                    Load Data
                </button>

            </div>

        </form>

    </div>

</div>


{{-- LOADING --}}

<div
    class="loading-overlay"
    id="loadingOverlay"
>

    <div class="spinner"></div>

    <div class="loading-text">
        Loading inventory analysis...
    </div>

</div>


<script>

function openSettings()
{
    document
        .getElementById('settingsOverlay')
        .classList.add('open');
}


function closeSettings()
{
    document
        .getElementById('settingsOverlay')
        .classList.remove('open');
}


function showLoader()
{
    document
        .getElementById('loadingOverlay')
        .classList.add('active');
}


function toggleHistory(input)
{
    const field =
        document.getElementById(
            'quarterField'
        );

    if (input.value === 'history') {
        field.style.display = '';
    } else {
        field.style.display = 'none';
    }


    document
        .querySelectorAll(
            '.segmented label'
        )
        .forEach(function(label) {

            label.classList.remove(
                'active'
            );

        });

    input.parentElement.classList.add(
        'active'
    );
}


document
    .getElementById('settingsOverlay')
    .addEventListener(
        'click',
        function(event) {

            if (
                event.target === this
            ) {
                closeSettings();
            }

        }
    );


document
    .getElementById('searchForm')
    ?.addEventListener(
        'submit',
        showLoader
    );

</script>

@endsection