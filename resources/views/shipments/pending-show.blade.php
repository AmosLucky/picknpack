@extends('layouts.app')

@section('header', 'Pending Shipment')

@section('content')

<style>
    .receive-page {
        padding: 0 36px 40px;
        background: #fff;
        min-height: calc(100vh - 60px);
    }

    .receive-top {
        height: 72px;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .back-btn {
        justify-self: start;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 40px;
        padding: 0 16px;
        border: 1px solid #dbe3ee;
        border-radius: 6px;
        background: #fff;
        color: #111827;
        text-decoration: none;
        font-size: 13px;
    }

    .page-title {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .instruction {
        border: 1px solid #dce3ed;
        border-radius: 7px;
        padding: 15px 16px;
        margin-bottom: 12px;
    }

    .instruction-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #111827;
    }

    .instruction-text {
        font-size: 13px;
        color: #111827;
    }

    .date-row {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 12px;
    }

    .date-row label {
        font-size: 13px;
        font-weight: 600;
        color: #111827;
    }

    .date-input {
        width: 140px;
        height: 38px;
        border: 1px solid #dbe3ee;
        border-radius: 5px;
        padding: 0 10px;
        font-size: 13px;
        color: #111827;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table thead th {
        padding: 8px 16px;
        text-align: left;
        color: #315d91;
        font-size: 13px;
        font-weight: 500;
        border-bottom: 1px solid #dce3ed;
    }

    .items-table tbody td {
        padding: 17px 16px;
        border-bottom: 1px solid #e3e8ef;
        color: #111827;
        font-size: 13px;
        vertical-align: middle;
    }

    .product-name {
        color: #0056a6;
    }

    .qty-sent {
        font-weight: 500;
    }

    .received-input {
        width: 100px;
        height: 40px;
        border: 1px solid #dbe3ee;
        border-radius: 6px;
        padding: 0 12px;
        font-size: 13px;
        outline: none;
    }

    .received-input:focus {
        border-color: #93c5fd;
    }

    .remarks-input {
        width: 100%;
        min-width: 130px;
        height: 80px;
        border: 1px solid #dbe3ee;
        border-radius: 5px;
        padding: 10px;
        resize: vertical;
        font-size: 13px;
        outline: none;
        box-sizing: border-box;
    }

    .confirm-btn {
        width: 100%;
        height: 40px;
        margin-top: 16px;
        border: 0;
        border-radius: 6px;
        background: #111827;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .confirm-btn:hover {
        background: #1f2937;
    }

    .error-box {
        margin-bottom: 12px;
        padding: 12px 15px;
        border-radius: 6px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        font-size: 13px;
    }

    @media(max-width: 900px) {
        .receive-page {
            padding: 0 18px 30px;
        }

        .items-table {
            min-width: 950px;
        }

        .table-wrap {
            overflow-x: auto;
        }
    }
</style>


<div class="receive-page">

    <div class="receive-top">

        <a
            href="{{ route('shipments.pending') }}"
            class="back-btn"
        >
            ← &nbsp; Back
        </a>

        <div class="page-title">
            Pending Shipment
        </div>

        <div></div>

    </div>


    @if($errors->any())

        <div class="error-box">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    <form
        method="POST"
        action="{{ route(
            'shipments.pending.confirm',
            $shipment->id
        ) }}"
    >

        @csrf


        <div class="date-row">

            <label for="date_received">
                Date Received
            </label>

            <input
                type="date"
                name="date_received"
                id="date_received"
                class="date-input"
                value="{{ old(
                    'date_received',
                    now()->format('Y-m-d')
                ) }}"
                required
            >

        </div>


        <div class="instruction">

            <div class="instruction-title">
                Instruction
            </div>

            <div class="instruction-text">
                Please enter the quantity received in the provided
                box, confirm the batch number and expiry dates
            </div>

        </div>


        <div class="table-wrap">

            <table class="items-table">

                <thead>

                    <tr>

                        <th style="width:55px;">
                            s/n
                        </th>

                        <th style="min-width:250px;">
                            Item name
                        </th>

                        <th style="width:120px;">
                            Quantity<br>
                            Sent
                        </th>

                        <th style="width:125px;">
                            Batch<br>
                            Number
                        </th>

                        <th style="width:125px;">
                            Expiry<br>
                            Date
                        </th>

                        <th style="width:140px;">
                            Quantity<br>
                            Received
                        </th>

                        <th style="width:180px;">
                            Remarks
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($items as $index => $item)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td class="product-name">
                                {{ $item->product_name }}
                            </td>

                            <td class="qty-sent">
                                {{ number_format(
                                    (float) $item->sent_quantity,
                                    0
                                ) }}
                            </td>

                            <td>
                                {{ $item->batch_no ?? '—' }}
                            </td>

                            <td>
                                {{ $item->expiry_date
                                    ? \Carbon\Carbon::parse(
                                        $item->expiry_date
                                    )->format('n/j/Y')
                                    : '—'
                                }}
                            </td>

                            <td>

                                <input
                                    type="number"
                                    name="items[{{ $index }}][received_quantity]"
                                    class="received-input"
                                    min="0"
                                    step="0.01"
                                    value="{{ old(
                                        "items.$index.received_quantity",
                                        $item->received_quantity
                                            ?? $item->sent_quantity
                                    ) }}"
                                    required
                                >

                                <input
                                    type="hidden"
                                    name="items[{{ $index }}][id]"
                                    value="{{ $item->id }}"
                                >

                            </td>

                            <td>

                                <textarea
                                    name="items[{{ $index }}][remarks]"
                                    class="remarks-input"
                                    placeholder=""
                                >{{ old(
                                    "items.$index.remarks",
                                    $item->receiver_notes
                                ) }}</textarea>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        <button
            type="submit"
            class="confirm-btn"
        >
            Confirm
        </button>

    </form>

</div>

@endsection