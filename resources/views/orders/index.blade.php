@extends('layouts.app')

@section('header', 'Orders')

@section('content')

<style>

    .orders-page {
        padding: 0 36px 40px;
        min-height: calc(100vh - 60px);
        background: #fff;
    }

    .orders-title {
        text-align: center;
        font-size: 15px;
        font-weight: 500;
        color: #111827;
        margin: 4px 0 18px;
    }

    .orders-filters {
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        gap: 10px;
        margin-bottom: 22px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-size: 12px;
        font-weight: 600;
        color: #111827;
    }

    .filter-select,
    .filter-date {
        height: 40px;
        min-width: 145px;
        border: 1px solid #dbe3ee;
        border-radius: 6px;
        background: #fff;
        padding: 0 12px;
        font-size: 13px;
        color: #111827;
        outline: none;
    }

    .filter-select {
        min-width: 115px;
    }

    .load-btn {
        height: 40px;
        padding: 0 20px;
        border: 1px solid #dbe3ee;
        border-radius: 6px;
        background: #fff;
        color: #111827;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .load-btn:hover {
        background: #f8fafc;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead th {
        padding: 14px 16px;
        text-align: left;
        font-size: 13px;
        font-weight: 500;
        color: #315d91;
        border-bottom: 1px solid #dce3ed;
    }

    .orders-table tbody td {
        padding: 17px 16px;
        font-size: 13px;
        color: #111827;
        border-bottom: 1px solid #e6ebf1;
        vertical-align: middle;
    }

    .receiver {
        color: #0056a6;
    }

    .type-pill,
    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 70px;
        height: 28px;
        padding: 0 12px;
        border-radius: 6px;
        font-size: 12px;
        border: 1px solid #dbe3ee;
    }

    .type-pill {
        background: #dcfce7;
        border-color: #bbf7d0;
        color: #166534;
    }

    .status-pill {
        background: #fff;
        color: #111827;
    }

    .status-pending {
        color: #111827;
    }

    .status-completed,
    .status-received {
        color: #111827;
    }

    .status-cancelled {
        color: #991b1b;
        border-color: #fecaca;
        background: #fef2f2;
    }

    .menu-cell {
        position: relative;
        width: 65px;
    }

    .menu-button {
        width: 32px;
        height: 32px;
        border: 0;
        background: transparent;
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
        color: #111827;
    }

    .action-menu {
        display: none;
        position: absolute;
        right: 8px;
        top: 42px;
        z-index: 20;
        width: 145px;
        background: #fff;
        border: 1px solid #dbe3ee;
        border-radius: 6px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, .12);
        overflow: hidden;
    }

    .action-menu.open {
        display: block;
    }

    .action-menu a,
    .action-menu button {
        display: block;
        width: 100%;
        padding: 11px 13px;
        border: 0;
        background: #fff;
        color: #111827;
        text-align: left;
        text-decoration: none;
        font-size: 13px;
        cursor: pointer;
    }

    .action-menu a:hover,
    .action-menu button:hover {
        background: #f8fafc;
    }

    .action-menu .danger {
        color: #991b1b;
    }

    .empty {
        padding: 80px 20px;
        text-align: center;
        color: #64748b;
        font-size: 14px;
    }

    .success-message {
        margin-bottom: 15px;
        padding: 12px 15px;
        border-radius: 6px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        font-size: 13px;
    }

    .cancel-form {
        display: none;
    }

    @media(max-width: 900px) {

        .orders-page {
            padding: 0 18px 30px;
        }

        .orders-filters {
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .orders-table {
            min-width: 850px;
        }

        .table-wrap {
            overflow-x: auto;
        }
    }

</style>


<div class="orders-page">

    <div class="orders-title">
        Inventory Activity
    </div>


    @if(session('success'))

        <div class="success-message">
            {{ session('success') }}
        </div>

    @endif


    <form
        method="GET"
        action="{{ route('orders.index') }}"
        class="orders-filters"
    >

        <div class="filter-group">

            <label>
                Transaction Type
            </label>

            <select
                name="type"
                class="filter-select"
            >

                <option
                    value="all"
                    {{ $type === 'all' ? 'selected' : '' }}
                >
                    All
                </option>

                <option
                    value="Supply"
                    {{ $type === 'Supply' ? 'selected' : '' }}
                >
                    Supply
                </option>

                <option
                    value="Transfer"
                    {{ $type === 'Transfer' ? 'selected' : '' }}
                >
                    Transfer
                </option>

                <option
                    value="Return"
                    {{ $type === 'Return' ? 'selected' : '' }}
                >
                    Return
                </option>

            </select>

        </div>


        <div class="filter-group">

            <label>
                Start Date
            </label>

            <input
                type="date"
                name="start_date"
                class="filter-date"
                value="{{ $startDate }}"
            >

        </div>


        <div class="filter-group">

            <label>
                End Date
            </label>

            <input
                type="date"
                name="end_date"
                class="filter-date"
                value="{{ $endDate }}"
            >

        </div>


        <button
            type="submit"
            class="load-btn"
        >
            ◉
            Load
        </button>

    </form>


    @if($orders->isEmpty())

        <div class="empty">
            No transactions found for the selected filters.
        </div>

    @else

        <div class="table-wrap">

            <table class="orders-table">

                <thead>

                    <tr>

                        <th style="width:60px;">
                            s/n
                        </th>

                        <th>
                            Receiver
                        </th>

                        <th>
                            Date sent
                        </th>

                        <th>
                            Type
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Number of items
                        </th>

                        <th style="width:65px;">
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($orders as $index => $order)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td class="receiver">
                                {{ $order->receiver_name }}
                            </td>

                            <td>
                                {{ $order->sent_date
                                    ? \Carbon\Carbon::parse(
                                        $order->sent_date
                                    )->format('n/j/Y')
                                    : '—'
                                }}
                            </td>

                            <td>

                                <span class="type-pill">
                                    {{ $order->order_type }}
                                </span>

                            </td>

                            <td>

                                <span class="status-pill status-{{ strtolower($order->status) }}">
                                    {{ ucfirst($order->status) }}
                                </span>

                            </td>

                            <td>
                                {{ $order->item_count }}
                            </td>

                            <td class="menu-cell">

                                <button
                                    type="button"
                                    class="menu-button"
                                    onclick="toggleOrderMenu({{ $order->id }})"
                                >
                                    •••
                                </button>


                                <div
                                    id="order-menu-{{ $order->id }}"
                                    class="action-menu"
                                >

                                    <a
                                        href="{{ route(
                                            'orders.show',
                                            $order->id
                                        ) }}"
                                    >
                                        View items
                                    </a>


                                    @if(strtolower($order->status) === 'pending')

                                        <button
                                            type="button"
                                            class="danger"
                                            onclick="cancelOrder({{ $order->id }})"
                                        >
                                            Cancel
                                        </button>

                                        <form
                                            id="cancel-form-{{ $order->id }}"
                                            class="cancel-form"
                                            method="POST"
                                            action="{{ route(
                                                'orders.cancel',
                                                $order->id
                                            ) }}"
                                        >

                                            @csrf

                                            <input
                                                type="hidden"
                                                name="reason"
                                                value="Cancelled by sender"
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

    @endif

</div>


<script>

function toggleOrderMenu(id)
{
    document
        .querySelectorAll('.action-menu')
        .forEach(function(menu) {

            if (menu.id !== 'order-menu-' + id) {
                menu.classList.remove('open');
            }

        });

    const menu =
        document.getElementById(
            'order-menu-' + id
        );

    menu.classList.toggle('open');
}


function cancelOrder(id)
{
    const confirmed =
        confirm(
            'Are you sure you want to cancel this order?'
        );

    if (!confirmed) {
        return;
    }

    document
        .getElementById(
            'cancel-form-' + id
        )
        .submit();
}


document.addEventListener(
    'click',
    function(event) {

        if (
            !event.target.closest('.menu-cell')
        ) {

            document
                .querySelectorAll('.action-menu')
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