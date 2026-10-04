<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendingShipmentController extends Controller
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
    | Pending incoming shipments
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

        $shipments = DB::table('orders as o')
            ->leftJoin(
                'orderItems as oi',
                'oi.order_id',
                '=',
                'o.id'
            )
            ->where(
                'o.receiver_facility_id',
                $user->store_id
            )
            ->whereRaw(
                'LOWER(o.status) = ?',
                ['pending']
            )
            ->select([
                'o.id',
                'o.sender_facility_id',
                'o.receiver_facility_id',
                'o.order_type',
                'o.status',
                'o.sent_date',
                'o.created_by',
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
                'o.created_by',
            ])
            ->orderByDesc('o.sent_date')
            ->get();

        $shipments = $shipments->map(function ($shipment) {

            $shipment->sender_name =
                $this->storeName(
                    $shipment->sender_facility_id
                );

            return $shipment;
        });

        return view(
            'shipments.pending',
            [
                'shipments' => $shipments,
                'storeName' => $this->storeName(
                    $user->store_id
                ),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Pending shipment details
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
        | Make sure this shipment belongs to the logged-in user's store
        |--------------------------------------------------------------------------
        */

        $shipment = DB::table('orders')
            ->where('id', $order)
            ->where(
                'receiver_facility_id',
                $user->store_id
            )
            ->whereRaw(
                'LOWER(status) = ?',
                ['pending']
            )
            ->first();

        abort_unless($shipment, 404);

        /*
        |--------------------------------------------------------------------------
        | Shipment items
        |--------------------------------------------------------------------------
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

                'pb.batch_no',
                'pb.expiry_date',
            ])
            ->orderBy('oi.id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Add product names
        |--------------------------------------------------------------------------
        */

        $productNames = $this->products();

        $items = $items->map(function ($item) use ($productNames) {

            $item->product_name =
                $productNames[$item->product_id]
                ?? $item->product_id;

            return $item;
        });

        return view(
            'shipments.pending-show',
            [
                'shipment' => $shipment,
                'items' => $items,

                'senderName' =>
                    $this->storeName(
                        $shipment->sender_facility_id
                    ),

                'receiverName' =>
                    $this->storeName(
                        $shipment->receiver_facility_id
                    ),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Confirm received shipment
    |--------------------------------------------------------------------------
    */

    public function confirm(
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

        $data = $request->validate([
            'date_received' => [
                'required',
                'date',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.id' => [
                'required',
                'integer',
            ],

            'items.*.received_quantity' => [
                'required',
                'numeric',
                'min:0',
            ],

            'items.*.remarks' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $order,
            $user,
            $data
        ) {

            /*
            |--------------------------------------------------------------------------
            | Lock the order
            |--------------------------------------------------------------------------
            */

            $shipment = DB::table('orders')
                ->where('id', $order)
                ->where(
                    'receiver_facility_id',
                    $user->store_id
                )
                ->whereRaw(
                    'LOWER(status) = ?',
                    ['pending']
                )
                ->lockForUpdate()
                ->first();

            abort_unless(
                $shipment,
                404,
                'Pending shipment not found.'
            );

            /*
            |--------------------------------------------------------------------------
            | Confirm each item
            |--------------------------------------------------------------------------
            */

            foreach ($data['items'] as $submittedItem) {

                $item = DB::table('orderItems')
                    ->where(
                        'id',
                        $submittedItem['id']
                    )
                    ->where(
                        'order_id',
                        $order
                    )
                    ->lockForUpdate()
                    ->first();

                if (!$item) {
                    continue;
                }

                $receivedQuantity =
                    (float) $submittedItem[
                        'received_quantity'
                    ];

                /*
                |--------------------------------------------------------------------------
                | Update order item
                |--------------------------------------------------------------------------
                */

                DB::table('orderItems')
                    ->where('id', $item->id)
                    ->update([
                        'received_quantity' =>
                            $receivedQuantity,

                        'status' => 'received',

                        'receiver_notes' =>
                            $submittedItem['remarks']
                            ?? null,

                        'updated_at' => now(),
                    ]);

                /*
                |--------------------------------------------------------------------------
                | Add received stock to receiver inventory
                |--------------------------------------------------------------------------
                */

                if ($receivedQuantity <= 0) {
                    continue;
                }

                $inventory = DB::table('inventory')
                    ->where(
                        'inventory_id',
                        $user->store_id
                    )
                    ->where(
                        'product_id',
                        $item->product_id
                    )
                    ->where(
                        'batch_id',
                        $item->batch_id
                    )
                    ->lockForUpdate()
                    ->first();

                if ($inventory) {

                    DB::table('inventory')
                        ->where(
                            'id',
                            $inventory->id
                        )
                        ->update([
                            'current_quantity' =>
                                (float) $inventory->current_quantity
                                + $receivedQuantity,

                            'last_updated' => now(),
                        ]);

                } else {

                    DB::table('inventory')
                        ->insert([
                            'inventory_id' =>
                                $user->store_id,

                            'product_id' =>
                                $item->product_id,

                            'batch_id' =>
                                $item->batch_id,

                            'current_quantity' =>
                                $receivedQuantity,

                            'last_updated' =>
                                now(),
                        ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Record inventory transaction
                |--------------------------------------------------------------------------
                */

                DB::table('inventory_transactions')
                    ->insert([
                        'initiator_id' =>
                            $shipment->sender_facility_id,

                        'counterpart_id' =>
                            $user->store_id,

                        'product_id' =>
                            $item->product_id,

                        'order_id' =>
                            $order,

                        'batch_id' =>
                            $item->batch_id,

                        'transaction_type' =>
                            $shipment->order_type,

                        'quantity_change' =>
                            $receivedQuantity,

                        'transaction_date' =>
                            $data['date_received'],

                        'user_id' =>
                            $user->store_id,

                        'notes' =>
                            $submittedItem['remarks']
                            ?? null,

                        'created_at' =>
                            now(),
                    ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Mark order received
            |--------------------------------------------------------------------------
            */

            DB::table('orders')
                ->where('id', $order)
                ->update([
                    'status' => 'received',

                    'confirmed_date' =>
                        $data['date_received'],

                    'updated_at' => now(),
                ]);
        });

        return redirect()
            ->route('shipments.pending')
            ->with(
                'success',
                'Shipment received successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Store name
    |--------------------------------------------------------------------------
    */

    private function storeName(
        ?string $storeId
    ): string {

        if (!$storeId) {
            return 'Unknown';
        }

        if (
            $storeId === 'fcms_national_store'
        ) {
            return 'FCMS National Store';
        }

        if (
            str_ends_with(
                $storeId,
                '_zonal_store'
            )
        ) {

            $zone = str_replace(
                '_zonal_store',
                '',
                $storeId
            );

            return ucwords(
                str_replace(
                    '_',
                    ' ',
                    $zone
                )
            ) . ' Zonal Store';
        }

        if (
            str_ends_with(
                $storeId,
                '_state_store'
            )
        ) {

            $state = str_replace(
                '_state_store',
                '',
                $storeId
            );

            return ucwords($state)
                . ' State Store';
        }

        return ucwords(
            str_replace(
                '_',
                ' ',
                $storeId
            )
        );
    }
}