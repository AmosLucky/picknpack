<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShipmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Temporary development hierarchy
    |--------------------------------------------------------------------------
    |
    | Later these values will come from the authenticated user.
    |
    */

    private function zones(): array
    {
        return [
            ['id' => 'sw', 'name' => 'SW - South West'],
            ['id' => 'se', 'name' => 'SE - South East'],
            ['id' => 'ss', 'name' => 'SS - South South'],
            ['id' => 'nc', 'name' => 'NC - North Central'],
            ['id' => 'ne', 'name' => 'NE - North East'],
            ['id' => 'nw', 'name' => 'NW - North West'],
        ];
    }

    private function states(): array
    {
        return [
            ['zone' => 'nc', 'state' => 'benue'],
            ['zone' => 'nc', 'state' => 'fct'],
            ['zone' => 'nc', 'state' => 'kogi'],
            ['zone' => 'nc', 'state' => 'kwara'],
            ['zone' => 'nc', 'state' => 'nasarawa'],
            ['zone' => 'nc', 'state' => 'niger'],
            ['zone' => 'nc', 'state' => 'plateau'],

            ['zone' => 'ne', 'state' => 'adamawa'],
            ['zone' => 'ne', 'state' => 'bauchi'],
            ['zone' => 'ne', 'state' => 'borno'],
            ['zone' => 'ne', 'state' => 'gombe'],
            ['zone' => 'ne', 'state' => 'taraba'],
            ['zone' => 'ne', 'state' => 'yobe'],

            ['zone' => 'nw', 'state' => 'jigawa'],
            ['zone' => 'nw', 'state' => 'kaduna'],
            ['zone' => 'nw', 'state' => 'kano'],
            ['zone' => 'nw', 'state' => 'katsina'],
            ['zone' => 'nw', 'state' => 'kebbi'],
            ['zone' => 'nw', 'state' => 'sokoto'],
            ['zone' => 'nw', 'state' => 'zamfara'],

            ['zone' => 'se', 'state' => 'abia'],
            ['zone' => 'se', 'state' => 'anambra'],
            ['zone' => 'se', 'state' => 'ebonyi'],
            ['zone' => 'se', 'state' => 'enugu'],
            ['zone' => 'se', 'state' => 'imo'],

            ['zone' => 'ss', 'state' => 'akwaibom'],
            ['zone' => 'ss', 'state' => 'bayelsa'],
            ['zone' => 'ss', 'state' => 'crossriver'],
            ['zone' => 'ss', 'state' => 'delta'],
            ['zone' => 'ss', 'state' => 'edo'],
            ['zone' => 'ss', 'state' => 'rivers'],

            ['zone' => 'sw', 'state' => 'ekiti'],
            ['zone' => 'sw', 'state' => 'lagos'],
            ['zone' => 'sw', 'state' => 'ogun'],
            ['zone' => 'sw', 'state' => 'ondo'],
            ['zone' => 'sw', 'state' => 'osun'],
            ['zone' => 'sw', 'state' => 'oyo'],
        ];
    }

    private function stores(): array
    {
        return [
            [
                'id' => 'fcms_national_store',
                'type' => 'national',
                'name' => 'National Store',
            ],

            [
                'id' => 'sw_zonal_store',
                'type' => 'zonal',
                'zone' => 'sw',
                'name' => 'SW Zonal Store',
            ],
            [
                'id' => 'se_zonal_store',
                'type' => 'zonal',
                'zone' => 'se',
                'name' => 'SE Zonal Store',
            ],
            [
                'id' => 'ss_zonal_store',
                'type' => 'zonal',
                'zone' => 'ss',
                'name' => 'SS Zonal Store',
            ],
            [
                'id' => 'nc_zonal_store',
                'type' => 'zonal',
                'zone' => 'nc',
                'name' => 'NC Zonal Store',
            ],
            [
                'id' => 'ne_zonal_store',
                'type' => 'zonal',
                'zone' => 'ne',
                'name' => 'NE Zonal Store',
            ],
            [
                'id' => 'nw_zonal_store',
                'type' => 'zonal',
                'zone' => 'nw',
                'name' => 'NW Zonal Store',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Shipment products
    |--------------------------------------------------------------------------
    */

    private function products(): array
    {
        return [
            ['id' => 'pk1', 'name' => 'CAT I Patient Kit', 'cases' => true],
            ['id' => 'paediatric', 'name' => 'Paediatric Bundle (RHZE 168 + RH 336)', 'cases' => true],
            ['id' => '3hp', 'name' => '3HP (Isoniazid / Rifapentin 300mg/300mg)', 'cases' => true],
            ['id' => '3rh', 'name' => '3RH Child (Rifampicin / Isoniazid 75mg/50mg)', 'cases' => true],
            ['id' => 'bpalm', 'name' => 'BPaLM Regimen', 'cases' => true],
            ['id' => 'bpal', 'name' => 'BPAL Regimen', 'cases' => true],
            ['id' => 'drtb', 'name' => 'Prediatric DR-TB Regimen', 'cases' => true],

            ['id' => 'moxifloxacin', 'name' => 'Moxifloxacin 400mg tab', 'cases' => false],
            ['id' => 'bedaquiline', 'name' => 'Bedaquiline 100mg tabs', 'cases' => false],
            ['id' => 'linezolid', 'name' => 'Linezolid 600mg tabs', 'cases' => false],
            ['id' => 'pretomanid', 'name' => 'Pretomanid 200mg', 'cases' => false],
            ['id' => 'delamanid', 'name' => 'Delamanid 50mg tab', 'cases' => false],
            ['id' => 'pyridoxine', 'name' => 'Pyridoxine 50mg tab', 'cases' => false],
            ['id' => 'rhze', 'name' => 'R75mgH50mgZ150mg', 'cases' => false],
            ['id' => 'rh', 'name' => 'R75mgH50mg', 'cases' => false],
            ['id' => 'ethambutol', 'name' => 'Ethambutol 100mg', 'cases' => false],
            ['id' => 'genexpert', 'name' => 'GeneXpert MTB/RIF Ultra cartridge', 'cases' => false],
            ['id' => 'sputum', 'name' => 'Sputum containers', 'cases' => false],
            ['id' => 'truenat', 'name' => 'Truenat MTB Plus', 'cases' => false],
            ['id' => 'sample_prep', 'name' => 'Universal Cartridge Based Sample Prep Kit', 'cases' => false],
            ['id' => 'pre_treatment', 'name' => 'MTB Sample Pre-treatment pack', 'cases' => false],
            ['id' => 'mtb_rif_dx', 'name' => 'MTB RIF Dx', 'cases' => false],
            ['id' => 'positive_control', 'name' => 'Positive Control Chip', 'cases' => false],
            ['id' => 'loopamp', 'name' => 'Loopamp MTBC Detection Kit', 'cases' => false],
            ['id' => 'loopamp_pure', 'name' => 'Loopamp PURE DNA Extraction Kit', 'cases' => false],
            ['id' => 'pipette', 'name' => 'Pipette-60 set for TB-LAMP', 'cases' => false],
            ['id' => 'mb_adult', 'name' => 'MB Adult', 'cases' => false],
            ['id' => 'mb_child', 'name' => 'MB Child', 'cases' => false],
            ['id' => 'clarithromycin_500', 'name' => 'Clarithromycin 500mg', 'cases' => false],
            ['id' => 'clarithromycin_250', 'name' => 'Clarithromycin 250mg', 'cases' => false],
            ['id' => 'rifampicin_300', 'name' => 'Rifampicin 300mg', 'cases' => false],
            ['id' => 'rifampicin_150', 'name' => 'Rifampicin 150mg', 'cases' => false],
            ['id' => 'levofloxacin', 'name' => 'Levofloxacin 250mg', 'cases' => false],
            ['id' => 'consummable', 'name' => 'Consummable Kit', 'cases' => false],
            ['id' => 'determine', 'name' => 'Determine', 'cases' => false],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Main shipment page
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('shipments.create', [
            'zones' => $this->zones(),
            'states' => $this->states(),
            'stores' => $this->stores(),
            'products' => $this->products(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Get receivers based on sender + shipment type
    |--------------------------------------------------------------------------
    */

    public function receivers(Request $request)
    {
        $request->validate([
            'sender_type' => ['required', 'in:national,zonal,state'],
            'sender_id' => ['required', 'string'],
            'shipment_type' => ['required', 'in:supply,transfer,return'],
            'zone' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
        ]);

        $senderType = $request->sender_type;
        $senderId = $request->sender_id;
        $shipmentType = $request->shipment_type;

        /*
        |--------------------------------------------------------------------------
        | National
        |--------------------------------------------------------------------------
        */

        if ($senderType === 'national') {

            // National can supply/transfer to zonal stores.
            if (in_array($shipmentType, ['supply', 'transfer'], true)) {
                return response()->json([
                    'receiver_type' => 'zonal',
                    'requires_zone' => true,
                    'requires_state' => false,
                    'requires_lga' => false,
                    'receivers' => $this->storesByType('zonal'),
                ]);
            }

            // National receiving returns from zones.
            if ($shipmentType === 'return') {
                return response()->json([
                    'receiver_type' => 'national',
                    'requires_zone' => false,
                    'requires_state' => false,
                    'requires_lga' => false,
                    'receivers' => [],
                    'fixed_receiver' => [
                        'id' => 'fcms_national_store',
                        'name' => 'National Store',
                    ],
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Zonal
        |--------------------------------------------------------------------------
        */

        if ($senderType === 'zonal') {

            $senderZone = $this->zoneFromStore($senderId);

            if (!$senderZone) {
                return response()->json([
                    'message' => 'Invalid zonal store.'
                ], 422);
            }

            if ($shipmentType === 'return') {
                return response()->json([
                    'receiver_type' => 'national',
                    'requires_zone' => false,
                    'requires_state' => false,
                    'requires_lga' => false,
                    'receivers' => [],
                    'fixed_receiver' => [
                        'id' => 'fcms_national_store',
                        'name' => 'National Store',
                    ],
                ]);
            }

            if (in_array($shipmentType, ['supply', 'transfer'], true)) {
                return response()->json([
                    'receiver_type' => 'state',
                    'requires_zone' => false,
                    'requires_state' => true,
                    'requires_lga' => false,
                    'states' => collect($this->states())
                        ->where('zone', $senderZone)
                        ->values(),
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | State
        |--------------------------------------------------------------------------
        */

        if ($senderType === 'state') {

            $state = $this->stateFromStore($senderId);

            if (!$state) {
                return response()->json([
                    'message' => 'Invalid state store.'
                ], 422);
            }

            if ($shipmentType === 'return') {

                $stateInfo = collect($this->states())
                    ->firstWhere('state', $state);

                $zone = $stateInfo['zone'] ?? null;

                $zonalStore = collect($this->stores())
                    ->firstWhere('zone', $zone);

                return response()->json([
                    'receiver_type' => 'zonal',
                    'requires_zone' => false,
                    'requires_state' => false,
                    'requires_lga' => false,
                    'receivers' => [],
                    'fixed_receiver' => $zonalStore
                        ? [
                            'id' => $zonalStore['id'],
                            'name' => $zonalStore['name'],
                        ]
                        : null,
                ]);
            }

            if (in_array($shipmentType, ['supply', 'transfer'], true)) {

                return response()->json([
                    'receiver_type' => 'facility',
                    'requires_zone' => false,
                    'requires_state' => false,
                    'requires_lga' => true,
                    'state' => $state,
                ]);
            }
        }

        return response()->json([
            'message' => 'No shipment route is configured for this combination.'
        ], 422);
    }

    /*
    |--------------------------------------------------------------------------
    | LGA list for a state
    |--------------------------------------------------------------------------
    */

    public function lgas(Request $request)
    {
        $request->validate([
            'state' => ['required', 'string'],
        ]);

        $lgas = DB::table('facilities_info')
            ->whereRaw('LOWER(TRIM(state)) = LOWER(?)', [trim($request->state)])
            ->whereNotNull('lga')
            ->whereRaw("TRIM(lga) <> ''")
            ->select('lga')
            ->distinct()
            ->orderBy('lga')
            ->pluck('lga');

        return response()->json($lgas);
    }

    /*
    |--------------------------------------------------------------------------
    | Facilities for selected state + LGA
    |--------------------------------------------------------------------------
    */

    public function facilities(Request $request)
    {
        $request->validate([
            'state' => ['required', 'string'],
            'lga' => ['required', 'string'],
        ]);

        $facilities = DB::table('facilities_info')
            ->whereRaw('LOWER(TRIM(state)) = LOWER(?)', [trim($request->state)])
            ->whereRaw('LOWER(TRIM(lga)) = LOWER(?)', [trim($request->lga)])
            ->whereNotNull('id')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'lga',
                'facility_type',
            ]);

        return response()->json($facilities);
    }

    /*
    |--------------------------------------------------------------------------
    | Store shipment
    |--------------------------------------------------------------------------
    |
    | For now this validates the shipment and returns it.
    |
    | We will connect this to shipments + shipment_items + inventory
    | after we confirm the routing UI.
    |
    */

    public function store(Request $request)
    {
        $data = $request->validate([
            'shipment_date' => ['required', 'date'],
            'sender_type' => ['required', 'in:national,zonal,state'],
            'sender_id' => ['required', 'string'],
            'shipment_type' => ['required', 'in:supply,transfer,return'],

            'receiver_type' => ['required', 'string'],
            'receiver_id' => ['required', 'string'],
            'receiver_name' => ['required', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'string'],
            'items.*.quantity' => ['required', 'numeric', 'gt:0'],
            'items.*.batch_id' => ['nullable', 'string'],
            'items.*.cases' => ['nullable', 'numeric', 'min:0'],
        ]);

        /*
         * We deliberately stop here for this first stage.
         *
         * Next stage:
         * 1. Create shipment number.
         * 2. Insert shipments.
         * 3. Insert shipment_items.
         * 4. Reserve/deduct sender stock.
         * 5. Create pending incoming record.
         */

        return response()->json([
            'success' => true,
            'message' => 'Shipment validated successfully.',
            'shipment' => $data,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function storesByType(string $type): array
    {
        return collect($this->stores())
            ->where('type', $type)
            ->values()
            ->all();
    }

    private function zoneFromStore(string $storeId): ?string
    {
        return collect($this->stores())
            ->firstWhere('id', $storeId)['zone'] ?? null;
    }

    private function stateFromStore(string $storeId): ?string
    {
        if (!Str::endsWith($storeId, '_state_store')) {
            return null;
        }

        return Str::beforeLast($storeId, '_state_store');
    }




    public function whoAreYou()
{
    return view('shipments.who-are-you', [
        'zones' => $this->zones(),
        'states' => $this->states(),
    ]);
}




public function setup(Request $request)
{
    $data = $request->validate([
        'sender_type' => [
            'required',
            'in:national,zonal,state'
        ],

        'sender_id' => [
            'required',
            'string'
        ],
    ]);

    $senderType = $data['sender_type'];
    $senderId   = $data['sender_id'];

    /*
    |--------------------------------------------------------------------------
    | Validate sender
    |--------------------------------------------------------------------------
    */

    if ($senderType === 'national') {

        $senderId = 'fcms_national_store';

    } elseif ($senderType === 'zonal') {

        $zone = $data['sender_id'];

        $validZone = collect($this->zones())
            ->firstWhere('id', $zone);

        if (!$validZone) {
            return back()
                ->withErrors([
                    'sender_id' => 'Invalid zonal location.'
                ]);
        }

        $senderId = $zone . '_zonal_store';

    } elseif ($senderType === 'state') {

        $state = strtolower(
            trim($data['sender_id'])
        );

        $validState = collect($this->states())
            ->firstWhere('state', $state);

        if (!$validState) {
            return back()
                ->withErrors([
                    'sender_id' => 'Invalid state.'
                ]);
        }

        $senderId = $state . '_state_store';
    }


    /*
    |--------------------------------------------------------------------------
    | PRELOAD PRODUCTS
    |--------------------------------------------------------------------------
    */

    $products = $this->products();


    /*
    |--------------------------------------------------------------------------
    | PRELOAD SENDER INVENTORY + BATCHES
    |--------------------------------------------------------------------------
    |
    | ONE database query.
    |
    | This is important because the DB is on another server.
    |
    */

    $inventory = DB::table('inventory as i')

        ->leftJoin(
            'product_batches as pb',
            'pb.id',
            '=',
            'i.batch_id'
        )

        ->where(
            'i.inventory_id',
            $senderId
        )

        ->where(
            'i.current_quantity',
            '>',
            0
        )

        ->select([
            'i.product_id',
            'i.batch_id',
            'i.current_quantity',

            'pb.batch_no',
            'pb.expiry_date',
            'pb.quantity as batch_quantity',
        ])

        ->orderBy('i.product_id')
        ->orderBy('pb.expiry_date')

        ->get();


    /*
    |--------------------------------------------------------------------------
    | Group batches by product
    |--------------------------------------------------------------------------
    */

    $batches = [];

    foreach ($inventory as $row) {

        if (!isset($batches[$row->product_id])) {
            $batches[$row->product_id] = [];
        }

        $batches[$row->product_id][] = [
            'batch_id' => $row->batch_id,

            'batch_no' => $row->batch_no,

            'expiry_date' => $row->expiry_date,

            'available_quantity' =>
                (float) $row->current_quantity,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | PRELOAD FACILITY DATA
    |--------------------------------------------------------------------------
    |
    | We get the complete facility directory once.
    |
    */

    $facilities = DB::table('facilities_info')

        ->whereNotNull('id')

        ->whereNotNull('state')

        ->whereNotNull('lga')

        ->whereRaw("TRIM(lga) <> ''")

        ->select([
            'id',
            'zone',
            'state',
            'lga',
            'name',
            'facility_type',
        ])

        ->orderBy('state')
        ->orderBy('lga')
        ->orderBy('name')

        ->get();


    /*
    |--------------------------------------------------------------------------
    | PRELOAD STATES
    |--------------------------------------------------------------------------
    */

    $states = collect($this->states())
        ->values()
        ->all();


    /*
    |--------------------------------------------------------------------------
    | PRELOAD ZONES
    |--------------------------------------------------------------------------
    */

    $zones = $this->zones();


    /*
    |--------------------------------------------------------------------------
    | Store everything in session
    |--------------------------------------------------------------------------
    |
    | Page 2 will NOT need to query PostgreSQL just to populate
    | dropdowns.
    |
    */

    session([
        'shipment_setup' => [

            'sender_type' => $senderType,

            'sender_id' => $senderId,

            'products' => $products,

            'batches' => $batches,

            'facilities' =>
                $facilities->toArray(),

            'states' => $states,

            'zones' => $zones,

            'loaded_at' => now()->toIso8601String(),
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | Move to page 2
    |--------------------------------------------------------------------------
    */

    return redirect()->route(
        'shipments.create'
    );
}


}