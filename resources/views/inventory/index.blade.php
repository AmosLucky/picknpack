@extends('layouts.app')

@section('title', 'Inventory')

@section('header', 'Inventory')

@section('content')

<style>

    .inventory-page {
        padding: 6px 0 40px;
    }

    .inventory-summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .inventory-summary-card {
        background: #fff;
        border: 1px solid #dce3ec;
        border-radius: 10px;
        padding: 22px 24px;
        box-shadow: 0 2px 6px rgba(0,0,0,.03);
    }

    .inventory-summary-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .inventory-summary-title {
        font-size: 14px;
        font-weight: 600;
        color: #101828;
    }

    .inventory-summary-icon {
        color: #64748b;
        font-size: 19px;
    }

    .inventory-summary-value {
        font-size: 25px;
        font-weight: 700;
        color: #0b1220;
        line-height: 1;
        margin-bottom: 8px;
    }

    .inventory-summary-sub {
        font-size: 12px;
        color: #6480a3;
    }

    .inventory-summary-sub.warning {
        color: #dc2626;
    }


    /*
    |--------------------------------------------------------------------------
    | Main Card
    |--------------------------------------------------------------------------
    */

    .inventory-card {
        background: #fff;
        border: 1px solid #dce3ec;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,.03);
    }

    .inventory-card-header {
        padding: 24px 24px 18px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
    }

    .inventory-heading h1 {
        margin: 0;
        font-size: 23px;
        font-weight: 700;
        color: #080f1c;
    }

    .inventory-heading p {
        margin: 4px 0 0;
        font-size: 13px;
        color: #64748b;
    }

    .inventory-store {
        margin-top: 7px;
        font-size: 12px;
        color: #64748b;
    }

    .inventory-store strong {
        color: #334155;
    }


    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    .inventory-filters {
        display: flex;
        align-items: flex-end;
        gap: 9px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-size: 11px;
        font-weight: 600;
        color: #334155;
    }

    .inventory-select {
        height: 38px;
        min-width: 132px;
        border: 1px solid #d7dee8;
        border-radius: 7px;
        background: #fff;
        color: #111827;
        padding: 0 12px;
        font-size: 13px;
        outline: none;
    }

    .inventory-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79,70,229,.08);
    }

    .apply-button {
        height: 38px;
        border: none;
        border-radius: 7px;
        padding: 0 18px;
        background: #111b32;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .apply-button:hover {
        background: #18233d;
    }


    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    .inventory-table-wrap {
        padding: 0 24px 24px;
        overflow-x: auto;
    }

    .inventory-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border: 1px solid #dce3ec;
        border-radius: 8px;
        overflow: hidden;
        min-width: 760px;
    }

    .inventory-table thead th {
        background: #f3f5f8;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        padding: 15px 12px;
        border-bottom: 1px solid #dce3ec;
        white-space: nowrap;
    }

    .inventory-table tbody td {
        padding: 17px 12px;
        border-bottom: 1px solid #e2e8f0;
        color: #111827;
        font-size: 13px;
        vertical-align: middle;
    }

    .inventory-table tbody tr:last-child td {
        border-bottom: none;
    }

    .inventory-table tbody tr.product-row:hover {
        background: #fafbfc;
    }

    .serial-col {
        width: 70px;
        text-align: center;
    }

    .expand-col {
        width: 45px;
        text-align: center;
    }

    .product-name {
        color: #064fe8;
        font-weight: 600;
        cursor: pointer;
    }

    .product-name:hover {
        text-decoration: underline;
    }

    .quantity-cell {
        font-weight: 600;
        text-align: right;
    }

    .batch-count {
        text-align: center;
    }


    /*
    |--------------------------------------------------------------------------
    | Expand button
    |--------------------------------------------------------------------------
    */

    .expand-button {
        border: none;
        background: transparent;
        cursor: pointer;
        width: 28px;
        height: 28px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        font-size: 14px;
    }

    .expand-button:hover {
        background: #edf1f6;
    }

    .expand-button .arrow {
        transition: transform .15s ease;
    }

    .expand-button.open .arrow {
        transform: rotate(90deg);
    }


    /*
    |--------------------------------------------------------------------------
    | Expiry badge
    |--------------------------------------------------------------------------
    */

    .expiry-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 9px;
        border-radius: 999px;
        border: 1px solid #dbe3ed;
        background: #fff;
        color: #334155;
        font-size: 11px;
        white-space: nowrap;
    }

    .expiry-badge.warning {
        color: #dc2626;
        border-color: #fecaca;
        background: #fef2f2;
        font-weight: 700;
    }

    .expiry-badge.expired {
        color: #b91c1c;
        border-color: #fca5a5;
        background: #fee2e2;
        font-weight: 700;
    }


    /*
    |--------------------------------------------------------------------------
    | Red product row
    |--------------------------------------------------------------------------
    */

    .product-row.expiring td {
        color: #dc2626;
    }

    .product-row.expiring .product-name {
        color: #dc2626;
    }

    .product-row.expiring .quantity-cell {
        color: #dc2626;
    }


    /*
    |--------------------------------------------------------------------------
    | Batch Details
    |--------------------------------------------------------------------------
    */

    .batch-row {
        display: none;
    }

    .batch-row.show {
        display: table-row;
    }

    .batch-container {
        background: #fafbfc;
        padding: 15px 20px 15px 70px !important;
    }

    .batch-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .batch-table th {
        text-align: left;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .03em;
        color: #64748b;
        padding: 8px 10px;
        border-bottom: 1px solid #e2e8f0;
    }

    .batch-table td {
        padding: 9px 10px !important;
        border-bottom: 1px solid #edf1f5 !important;
        font-size: 12px !important;
        color: #475569 !important;
    }

    .batch-table tr:last-child td {
        border-bottom: none !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Quarter details
    |--------------------------------------------------------------------------
    */

    .quarter-summary {
        display: flex;
        gap: 18px;
        margin-top: 6px;
        font-size: 11px;
        color: #64748b;
    }

    .quarter-summary span strong {
        color: #334155;
    }


    /*
    |--------------------------------------------------------------------------
    | Empty
    |--------------------------------------------------------------------------
    */

    .inventory-empty {
        padding: 50px 20px;
        text-align: center;
        color: #64748b;
    }

    .inventory-empty-title {
        font-size: 16px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 5px;
    }


    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 900px) {

        .inventory-summary {
            grid-template-columns: 1fr;
        }

        .inventory-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .inventory-filters {
            width: 100%;
        }

    }

</style>


<div class="inventory-page">


    {{-- ============================================================= --}}
    {{-- SUMMARY --}}
    {{-- ============================================================= --}}

    <div class="inventory-summary">

        <div class="inventory-summary-card">

            <div class="inventory-summary-top">

                <div class="inventory-summary-title">
                    Total Products
                </div>

                <div class="inventory-summary-icon">
                    ◇
                </div>

            </div>

            <div class="inventory-summary-value">
                {{ number_format($totalProducts) }}
            </div>

            <div class="inventory-summary-sub">
                {{ number_format($totalQuantity, 0) }}
                total units
            </div>

        </div>


        <div class="inventory-summary-card">

            <div class="inventory-summary-top">

                <div class="inventory-summary-title">
                    Nearing Expiry
                </div>

                <div class="inventory-summary-icon">
                    ◷
                </div>

            </div>

            <div class="inventory-summary-value">
                {{ number_format($nearingExpiry) }}
            </div>

            <div class="inventory-summary-sub warning">
                Expiring in 3 months
            </div>

        </div>

    </div>



    {{-- ============================================================= --}}
    {{-- INVENTORY CARD --}}
    {{-- ============================================================= --}}

    <div class="inventory-card">


        <div class="inventory-card-header">


            {{-- Heading --}}

            <div class="inventory-heading">

                <h1>
                    Inventory Overview
                </h1>

                <p>
                    An overview of all products in your inventory.
                    Click a product name to see details.
                </p>

                <div class="inventory-store">

                    Inventory:
                    <strong>
                        {{ $storeName }}
                    </strong>

                </div>

            </div>



            {{-- Filters --}}

            <form
                method="GET"
                action="{{ route('inventory.index') }}"
                class="inventory-filters"
            >


                <div class="filter-group">

                    <label for="view_type">
                        View Type
                    </label>

                    <select
                        name="view_type"
                        id="view_type"
                        class="inventory-select"
                    >

                        <option
                            value="current"
                            {{ $viewType === 'current' ? 'selected' : '' }}
                        >
                            Current (Live)
                        </option>

                        <option
                            value="quarter"
                            {{ $viewType === 'quarter' ? 'selected' : '' }}
                        >
                            Quarter
                        </option>

                    </select>

                </div>



                <div
                    class="filter-group"
                    id="quarter-filter"
                    style="{{ $viewType === 'quarter' ? '' : 'display:none;' }}"
                >

                    <label for="quarter">
                        Quarter
                    </label>

                    <select
                        name="quarter"
                        id="quarter"
                        class="inventory-select"
                    >

                        @if(empty($quarters))

                            <option value="">
                                No quarters
                            </option>

                        @else

                            @foreach($quarters as $quarter)

                                <option
                                    value="{{ $quarter }}"
                                    {{ $selectedQuarter === $quarter ? 'selected' : '' }}
                                >
                                    {{ strtoupper(str_replace('_', ' ', $quarter)) }}
                                </option>

                            @endforeach

                        @endif

                    </select>

                </div>



                <button
                    type="submit"
                    class="apply-button"
                >
                    Apply
                </button>

            </form>

        </div>



        {{-- ========================================================= --}}
        {{-- TABLE --}}
        {{-- ========================================================= --}}

        <div class="inventory-table-wrap">

            @if($products->isEmpty())

                <div class="inventory-empty">

                    <div class="inventory-empty-title">
                        No inventory found
                    </div>

                    <div>
                        There is currently no inventory assigned
                        to {{ $storeName }}.
                    </div>

                </div>

            @else

                <table class="inventory-table">

                    <thead>

                        <tr>

                            <th class="expand-col"></th>

                            <th class="serial-col">
                                S/N
                            </th>

                            <th>
                                Item Name
                            </th>

                            <th style="text-align:center;">
                                Total Batches
                            </th>

                            <th style="text-align:right;">
                                Total Quantity
                            </th>

                            <th>
                                Closest Expiry
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach($products as $index => $product)

                            {{-- ================================================= --}}
                            {{-- PRODUCT ROW --}}
                            {{-- ================================================= --}}

                            <tr
                                class="product-row {{ $product['expiry_warning'] ? 'expiring' : '' }}"
                                data-product-row="{{ $index }}"
                            >

                                <td class="expand-col">

                                    <button
                                        type="button"
                                        class="expand-button"
                                        data-toggle="{{ $index }}"
                                        aria-label="Show batches"
                                    >

                                        <span class="arrow">
                                            ›
                                        </span>

                                    </button>

                                </td>


                                <td class="serial-col">

                                    {{ $index + 1 }}

                                </td>


                                <td>

                                    <span
                                        class="product-name"
                                        data-toggle="{{ $index }}"
                                    >
                                        {{ $product['name'] }}
                                    </span>


                                    @if(
                                        $viewType === 'quarter'
                                        && $product['opening'] !== null
                                    )

                                        <div class="quarter-summary">

                                            <span>
                                                Opening:
                                                <strong>
                                                    {{ number_format($product['opening'], 0) }}
                                                </strong>
                                            </span>

                                            <span>
                                                Received:
                                                <strong>
                                                    {{ number_format($product['received'], 0) }}
                                                </strong>
                                            </span>

                                            <span>
                                                Issued:
                                                <strong>
                                                    {{ number_format($product['issued'], 0) }}
                                                </strong>
                                            </span>

                                        </div>

                                    @endif

                                </td>


                                <td class="batch-count">

                                    {{ number_format($product['total_batches']) }}

                                </td>


                                <td class="quantity-cell">

                                    {{ number_format($product['quantity'], 0) }}

                                </td>


                                <td>

                                    @if($product['closest_expiry'])

                                        <span
                                            class="expiry-badge
                                                {{ $product['expiry_expired'] ? 'expired' : '' }}
                                                {{ !$product['expiry_expired'] && $product['expiry_warning'] ? 'warning' : '' }}"
                                        >

                                            {{ \Carbon\Carbon::parse($product['closest_expiry'])->format('n/j/Y') }}

                                        </span>

                                    @else

                                        <span class="expiry-badge">
                                            No expiry
                                        </span>

                                    @endif

                                </td>

                            </tr>



                            {{-- ================================================= --}}
                            {{-- BATCH ROW --}}
                            {{-- ================================================= --}}

                            <tr
                                class="batch-row"
                                id="batch-row-{{ $index }}"
                            >

                                <td
                                    colspan="6"
                                    class="batch-container"
                                >

                                    @if(empty($product['batches']))

                                        <div style="
                                            color:#64748b;
                                            font-size:12px;
                                        ">
                                            No batch information available.
                                        </div>

                                    @else

                                        <table class="batch-table">

                                            <thead>

                                                <tr>

                                                    <th>
                                                        Batch
                                                    </th>

                                                    <th>
                                                        Current Quantity
                                                    </th>

                                                    <th>
                                                        Batch Quantity
                                                    </th>

                                                    <th>
                                                        Expiry
                                                    </th>

                                                </tr>

                                            </thead>


                                            <tbody>

                                                @foreach($product['batches'] as $batch)

                                                    <tr>

                                                        <td>

                                                            {{ $batch['batch_no'] ?: 'No batch number' }}

                                                        </td>


                                                        <td>

                                                            {{ number_format($batch['quantity'], 0) }}

                                                        </td>


                                                        <td>

                                                            {{ number_format($batch['batch_quantity'], 0) }}

                                                        </td>


                                                        <td>

                                                            @if($batch['expiry_date'])

                                                                <span
                                                                    class="
                                                                        expiry-badge
                                                                        {{ $batch['expired'] ? 'expired' : '' }}
                                                                        {{ !$batch['expired'] && $batch['expiry_warning'] ? 'warning' : '' }}
                                                                    "
                                                                >

                                                                    {{ \Carbon\Carbon::parse($batch['expiry_date'])->format('n/j/Y') }}

                                                                </span>

                                                            @else

                                                                <span class="expiry-badge">
                                                                    No expiry
                                                                </span>

                                                            @endif

                                                        </td>

                                                    </tr>

                                                @endforeach

                                            </tbody>

                                        </table>

                                    @endif

                                </td>

                            </tr>

                        @endforeach


                    </tbody>

                </table>

            @endif

        </div>

    </div>

</div>



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | Product expand/collapse
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '[data-toggle]'
            )
            .forEach(
                function (element) {

                    element.addEventListener(
                        'click',
                        function () {

                            const index =
                                this.dataset.toggle;

                            const row =
                                document.getElementById(
                                    'batch-row-' + index
                                );

                            if (!row) {
                                return;
                            }


                            const button =
                                document.querySelector(
                                    `.expand-button[data-toggle="${index}"]`
                                );


                            if (
                                row.classList.contains(
                                    'show'
                                )
                            ) {

                                row.classList.remove(
                                    'show'
                                );

                                if (button) {
                                    button.classList.remove(
                                        'open'
                                    );
                                }

                            } else {

                                row.classList.add(
                                    'show'
                                );

                                if (button) {
                                    button.classList.add(
                                        'open'
                                    );
                                }

                            }

                        }
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | View type
        |--------------------------------------------------------------------------
        */

        const viewType =
            document.getElementById(
                'view_type'
            );

        const quarterFilter =
            document.getElementById(
                'quarter-filter'
            );


        if (
            viewType
            && quarterFilter
        ) {

            viewType.addEventListener(
                'change',
                function () {

                    if (
                        this.value === 'quarter'
                    ) {

                        quarterFilter.style.display =
                            'flex';

                    } else {

                        quarterFilter.style.display =
                            'none';

                    }

                }
            );

        }

    }
);

</script>

@endsection