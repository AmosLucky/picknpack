@extends('layouts.app')

@section('header', 'Pending Incoming Items')

@section('content')

<style>
    .pending-page {
        padding: 0 36px 40px;
        background: #fff;
        min-height: calc(100vh - 60px);
    }

    .pending-top {
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

    .pending-title {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .pending-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
    }

    .pending-table thead th {
        padding: 16px 16px;
        text-align: left;
        color: #315d91;
        font-size: 13px;
        font-weight: 500;
        border-bottom: 1px solid #dce3ed;
    }

    .pending-table tbody td {
        padding: 17px 16px;
        color: #0f172a;
        font-size: 13px;
        border-bottom: 1px solid #edf1f5;
    }

    .view-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 64px;
        height: 40px;
        padding: 0 15px;
        border-radius: 6px;
        background: #111827;
        color: #fff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .view-btn:hover {
        background: #1f2937;
    }

    .empty {
        text-align: center;
        padding: 80px 20px;
        color: #64748b;
        font-size: 14px;
    }

    .success-message {
        margin: 12px 0;
        padding: 12px 15px;
        border-radius: 6px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        font-size: 13px;
    }
</style>

<div class="pending-page">

    <div class="pending-top">

        <a
            href="{{ route('dashboard') }}"
            class="back-btn"
        >
            ← &nbsp; back
        </a>

        <div class="pending-title">
            Pending Incoming Items
        </div>

        <div></div>

    </div>


    @if(session('success'))

        <div class="success-message">
            {{ session('success') }}
        </div>

    @endif


    @if($shipments->isEmpty())

        <div class="empty">
            No pending incoming shipments.
        </div>

    @else

        <table class="pending-table">

            <thead>
                <tr>
                    <th style="width:70px;">
                        s/n
                    </th>

                    <th>
                        Date Sent
                    </th>

                    <th>
                        Number of items
                    </th>

                    <th>
                        Sender
                    </th>

                    <th style="width:120px;">
                        View
                    </th>
                </tr>
            </thead>

            <tbody>

                @foreach($shipments as $index => $shipment)

                    <tr>

                        <td>
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $shipment->sent_date
                                ? \Carbon\Carbon::parse($shipment->sent_date)
                                    ->format('n/j/Y, g:i:s A')
                                : '—'
                            }}
                        </td>

                        <td>
                            {{ $shipment->item_count }}
                        </td>

                        <td>
                            {{ $shipment->sender_name }}
                        </td>

                        <td>

                            <a
                                href="{{ route(
                                    'shipments.pending.show',
                                    $shipment->id
                                ) }}"
                                class="view-btn"
                            >
                                View
                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @endif

</div>

@endsection