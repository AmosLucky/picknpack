@extends('layouts.app')

@section('header', 'Transaction Information')

@section('content')

<style>

    .transaction-page {
        padding: 0 36px 40px;
        min-height: calc(100vh - 60px);
        background: #fff;
    }

    .transaction-top {
        height: 70px;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .back-btn {
        justify-self: start;
        height: 40px;
        padding: 0 17px;
        border: 0;
        border-radius: 6px;
        background: #111827;
        color: #fff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-size: 13px;
        font-weight: 600;
    }

    .transaction-title {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table thead th {
        padding: 11px 16px;
        text-align: left;
        color: #315d91;
        font-size: 13px;
        font-weight: 500;
        border-bottom: 1px solid #dce3ed;
    }

    .items-table tbody td {
        padding: 18px 16px;
        border-bottom: 1px solid #e4e9ef;
        font-size: 13px;
        color: #111827;
    }

    .product-name {
        color: #0056a6;
    }

    .status {
        text-transform: lowercase;
    }

    .remarks {
        color: #111827;
        font-weight: 600;
    }

    .item-menu {
        position: relative;
        width: 50px;
    }

    .dots {
        border: 0;
        background: transparent;
        cursor: pointer;
        font-size: 19px;
        color: #111827;
    }

    .item-action-menu {
        display: none;
        position: absolute;
        right: 5px;
        top: 35px;
        z-index: 20;
        width: 125px;
        background: #fff;
        border: 1px solid #dbe3ee;
        border-radius: 6px;
        box-shadow: 0 6px 18px rgba(15,23,42,.12);
    }

    .item-action-menu.open {
        display: block;
    }

    .item-action-menu button {
        width: 100%;
        padding: 11px 12px;
        border: 0;
        background: #fff;
        text-align: left;
        color: #111827;
        cursor: pointer;
        font-size: 13px;
    }

    .item-action-menu button:hover {
        background: #f8fafc;
    }

    .item-action-menu .danger {
        color: #991b1b;
    }

    .cancel-item-form {
        display: none;
    }

    @media(max-width: 900px) {

        .transaction-page {
            padding: 0 18px 30px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .items-table {
            min-width: 950px;
        }

    }

</style>


<div class="transaction-page">

    <div class="transaction-top">

        <a
            href="{{ route('orders.index') }}"
            class="back-btn"
        >
            Back
        </a>

        <div class="transaction-title">
            Transaction Information
        </div>

        <div></div>

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

                    <th>
                        Batch<br>
                        Number
                    </th>

                    <th>
                        Expiry<br>
                        Date
                    </th>

                    <th>
                        Quantity<br>
                        Sent
                    </th>

                    <th>
                        Quantity<br>
                        Received
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Remarks
                    </th>

                    <th style="width:50px;">
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

                        <td>
                            {{ $item->batch_no ?? '—' }}
                        </td>

                        <td>
                            {{ $item->expiry_date
                                ? \Carbon\Carbon::parse(
                                    $item->expiry_date
                                )->format('d/m/Y')
                                : '—'
                            }}
                        </td>

                        <td>
                            {{ number_format(
                                (float) $item->sent_quantity,
                                0
                            ) }}
                        </td>

                        <td>
                            {{ number_format(
                                (float) $item->received_quantity,
                                0
                            ) }}
                        </td>

                        <td class="status">
                            {{ $item->status }}
                        </td>

                        <td class="remarks">
                            {{ $item->receiver_notes ?? 'remarks' }}
                        </td>

                        <td class="item-menu">

                            <button
                                type="button"
                                class="dots"
                                onclick="toggleItemMenu({{ $item->id }})"
                            >
                                •••
                            </button>


                            <div
                                id="item-menu-{{ $item->id }}"
                                class="item-action-menu"
                            >

                                @if(strtolower($item->status) === 'pending')

                                    <button
                                        type="button"
                                        class="danger"
                                        onclick="cancelItem({{ $item->id }})"
                                    >
                                        Cancel item
                                    </button>

                                    <form
                                        id="cancel-item-form-{{ $item->id }}"
                                        class="cancel-item-form"
                                    >
                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>


<script>

function toggleItemMenu(id)
{
    document
        .querySelectorAll('.item-action-menu')
        .forEach(function(menu) {

            if (
                menu.id !==
                'item-menu-' + id
            ) {
                menu.classList.remove(
                    'open'
                );
            }

        });

    document
        .getElementById(
            'item-menu-' + id
        )
        .classList.toggle('open');
}


function cancelItem(id)
{
    alert(
        'Item cancellation will be connected to the order inventory transaction next.'
    );
}


document.addEventListener(
    'click',
    function(event) {

        if (
            !event.target.closest('.item-menu')
        ) {

            document
                .querySelectorAll(
                    '.item-action-menu'
                )
                .forEach(function(menu) {

                    menu.classList.remove(
                        'open'
                    );

                });

        }

    }
);

</script>

@endsection