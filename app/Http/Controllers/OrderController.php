<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Product names
    |--------------------------------------------------------------------------
    */

    private function products(): array
    {
        return [
            'pk1' => 'CAT I Patient Kit',
            'paediatric' => 'Paediatric Bundle (RHZE 168 + RH 336)',
            '3hp' => '3HP (Isoniazid / Rifapentin 300mg/300mg)',
            '3rh' => '3RH Child (Rifampicin / Isoniazid 75mg/50mg)',
            'bpalm' => 'BPaLM Regimen',
            'bpal' => 'BPAL Regimen',
            'drtb' => 'Prediatric DR-TB Regimen',

            'Moxifloxacin400mg' => 'Moxifloxacin 400mg tab',
            'Bedaquiline100mg' => 'Bedaquiline 100mg tabs',
            'Linezolid600mg' => 'Linezolid 600mg tabs',
            'Pretomanid200mg' => 'Pretomanid 200mg',
            'Delamanid50mg' => 'Delamanid 50mg tab',
            'Pyridoxine50mg' => 'Pyridoxine 50mg tab',
            'R75mgH50mgZ150mg' => 'R75mgH50mgZ150mg',
            'R75mgH50mg' => 'R75mgH50mg',
            'Ethambutol100mg' => 'Ethambutol 100mg',

            'GeneXpertMTBRIF' => 'GeneXpert MTB/RIF Ultra cartridge',
            'SputumContainers' => 'Sputum containers',
            'TruenatMTBPlus' => 'Truenat MTB Plus',
            'UniversalCartridge' => 'Universal Cartridge Based Sample Prep Kit',
            'MTBSamplePreTreatment' => 'MTB Sample Pre-treatment pack',
            'MTBRIFDx' => 'MTB RIF Dx',
            'PositiveControlChip' => 'Positive Control Chip',
            'LoopampMTBCDetectionKit' => 'Loopamp MTBC Detection Kit',
            'LoopampPUREDNAExtractionKit' => 'Loopamp PURE DNA Extraction Kit',
            'Pipette60forTBLAMP' => 'Pipette-60 set for TB-LAMP',

            'MB_ADULT' => 'MB Adult',
            'MB_CHILD' => 'MB Child',
            'Clarithromycin500mg' => 'Clarithromycin 500mg',
            'Clarithromycin250mg' => 'Clarithromycin 250mg',
            'Rifampicin300mg' => 'Rifampicin 300mg',
            'Rifampicin150mg' => 'Rifampicin 150mg',
            'Levofloxacin250mg' => 'Levofloxacin 250mg',
            'Consummable_Kit' => 'Consummable Kit',
            'Determine' => 'Determine',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Orders / Inventory Activity
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $user = $request->user();

        abort_unless($user, 401);

        abort_unless(
            in_array($user->role, [
                'national',
                'zone',
                'state',
            ], true),
            403
        );

        abort_unless(
            $user->store_id,
            403,
            'Your account is not connected to a store.'
        );

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $type = $request->input(
            'type',
            'all'
        );

        $startDate = $request->input(
            'start_date',
            now()->startOfYear()->format('Y-m-d')
        );

        $endDate = $request->input(
            'end_date',
            now()->format('Y-m-d')
        );

        if (!in_array($type, [
            'all',
            'Supply',
            'Transfer',
            'Return',
        ], true)) {
            $type = 'all';
        }


        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        |
        | The Orders page represents transactions initiated by
        | the logged-in store.
        |
        */

        $query = DB::table('orders as o')
            ->leftJoin(
                'orderItems as oi',
                'oi.order_id',
                '=',
                'o.id'
            )
            ->where(
                'o.sender_facility_id',
                $user->store_id
            )
            ->whereDate(
                'o.sent_date',
                '>=',
                $startDate
            )
            ->whereDate(
                'o.sent_date',
                '<=',
                $endDate
            );

        /*
        |--------------------------------------------------------------------------
        | Transaction type
        |--------------------------------------------------------------------------
        */

        if ($type !== 'all') {
            $query->where(
                'o.order_type',
                $type
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Get order list
        |--------------------------------------------------------------------------
        */

        $orders = $query
            ->select([
                'o.id',
                'o.sender_facility_id',
                'o.receiver_facility_id',
                'o.order_type',
                'o.status',
                'o.sent_date',
                'o.confirmed_date',
                'o.cancelled_date',
                'o.cancellation_reason',
            ])
            ->selectRaw(
                'COUNT(oi.id) as item_count'
            )
            ->groupBy([
                'o.id',
                'o.sender_facility_id',
                'o.receiver_facility_id',
                'o.order_type',
                'o.status',
                'o.sent_date',
                'o.confirmed_date',
                'o.cancelled_date',
                'o.cancellation_reason',
            ])
            ->orderByDesc(
                'o.sent_date'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Resolve receiver names
        |--------------------------------------------------------------------------
        */

        $orders = $orders->map(
            function ($order) {

                $order->receiver_name =
                    $this->resolveLocationName(
                        $order->receiver_facility_id
                    );

                return $order;
            }
        );


        return view(
            'orders.index',
            [
                'orders' => $orders,
                'type' => $type,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Transaction Information
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request,
        int $order
    ) {
        $user = $request->user();

        abort_unless($user, 401);

        abort_unless(
            $user->store_id,
            403,
            'Your account is not connected to a store.'
        );


        /*
        |--------------------------------------------------------------------------
        | Get order
        |--------------------------------------------------------------------------
        */

        $transaction = DB::table('orders')
            ->where(
                'id',
                $order
            )
            ->where(
                'sender_facility_id',
                $user->store_id
            )
            ->first();

        abort_unless(
            $transaction,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Get items
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | PostgreSQL table is "orderItems".
        |
        */

        $items = DB::table('orderItems as oi')
            ->leftJoin(
                'product_batches as pb',
                'pb.id',
                '=',
                'oi.batch_id'
            )
            ->where(
                'oi.order_id',
                $order
            )
            ->select([
                'oi.id',
                'oi.order_id',
                'oi.product_id',
                'oi.batch_id',
                'oi.sent_quantity',
                'oi.received_quantity',
                'oi.status',
                'oi.receiver_notes',
                'oi.cancelled_date',
                'oi.cancellation_reason',

                'pb.batch_no',
                'pb.expiry_date',
            ])
            ->orderBy(
                'oi.id'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Product names
        |--------------------------------------------------------------------------
        */

        $productNames =
            $this->products();


        $items = $items->map(
            function ($item) use ($productNames) {

                $item->product_name =
                    $productNames[
                        $item->product_id
                    ]
                    ?? $item->product_id;

                return $item;
            }
        );


        return view(
            'orders.show',
            [
                'transaction' => $transaction,
                'items' => $items,

                'receiverName' =>
                    $this->resolveLocationName(
                        $transaction->receiver_facility_id
                    ),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Cancel Order
    |--------------------------------------------------------------------------
    */

    public function cancel(
        Request $request,
        int $order
    ) {
        $user = $request->user();

        abort_unless($user, 401);

        $data = $request->validate([
            'reason' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        DB::transaction(
            function () use (
                $user,
                $order,
                $data
            ) {

                $transaction = DB::table('orders')
                    ->where(
                        'id',
                        $order
                    )
                    ->where(
                        'sender_facility_id',
                        $user->store_id
                    )
                    ->whereRaw(
                        'LOWER(status) = ?',
                        ['pending']
                    )
                    ->lockForUpdate()
                    ->first();

                abort_unless(
                    $transaction,
                    404
                );


                /*
                |--------------------------------------------------------------------------
                | Cancel order
                |--------------------------------------------------------------------------
                */

                DB::table('orders')
                    ->where(
                        'id',
                        $order
                    )
                    ->update([
                        'status' =>
                            'cancelled',

                        'cancelled_date' =>
                            now(),

                        'cancellation_reason' =>
                            $data['reason']
                            ?? null,

                        'updated_at' =>
                            now(),
                    ]);


                /*
                |--------------------------------------------------------------------------
                | Cancel all pending items
                |--------------------------------------------------------------------------
                */

                DB::table('orderItems')
                    ->where(
                        'order_id',
                        $order
                    )
                    ->whereRaw(
                        'LOWER(status) = ?',
                        ['pending']
                    )
                    ->update([
                        'status' =>
                            'cancelled',

                        'cancelled_date' =>
                            now(),

                        'cancellation_reason' =>
                            $data['reason']
                            ?? null,

                        'updated_at' =>
                            now(),
                    ]);
            }
        );


        return redirect()
            ->route('orders.index')
            ->with(
                'success',
                'Order cancelled successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve location name
    |--------------------------------------------------------------------------
    */

    private function resolveLocationName(
        ?string $locationId
    ): string {

        if (!$locationId) {
            return 'Unknown';
        }


        /*
        |--------------------------------------------------------------------------
        | National
        |--------------------------------------------------------------------------
        */

        if (
            $locationId ===
            'fcms_national_store'
        ) {
            return 'FCMS National Store';
        }


        /*
        |--------------------------------------------------------------------------
        | Zonal store
        |--------------------------------------------------------------------------
        */

        if (
            str_ends_with(
                $locationId,
                '_zonal_store'
            )
        ) {

            $zone = str_replace(
                '_zonal_store',
                '',
                $locationId
            );

            return $zone === 'se'
                ? 'se Zonal Store'
                : $zone . ' Zonal Store';
        }


        /*
        |--------------------------------------------------------------------------
        | State store
        |--------------------------------------------------------------------------
        */

        if (
            str_ends_with(
                $locationId,
                '_state_store'
            )
        ) {

            $state = str_replace(
                '_state_store',
                '',
                $locationId
            );

            return $state . ' State Store';
        }


        /*
        |--------------------------------------------------------------------------
        | Facility
        |--------------------------------------------------------------------------
        */

        $facility = DB::table(
            'facilities_info'
        )
            ->where(
                'id',
                $locationId
            )
            ->first([
                'name',
                'state',
                'facility_type',
            ]);

        if ($facility) {
            return $facility->name;
        }


        return $locationId;
    }
}