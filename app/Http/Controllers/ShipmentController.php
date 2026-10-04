<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShipmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Zones
    |--------------------------------------------------------------------------
    */

    private function zones(): array
    {
        return [
            [
                'id' => 'sw',
                'name' => 'SW - South West',
            ],
            [
                'id' => 'se',
                'name' => 'SE - South East',
            ],
            [
                'id' => 'ss',
                'name' => 'SS - South South',
            ],
            [
                'id' => 'nc',
                'name' => 'NC - North Central',
            ],
            [
                'id' => 'ne',
                'name' => 'NE - North East',
            ],
            [
                'id' => 'nw',
                'name' => 'NW - North West',
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Stores
    |--------------------------------------------------------------------------
    */

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
    | Products
    |--------------------------------------------------------------------------
    */
    private function products(): array
{
    return [

        [
            'id' => 'pk1',
            'name' => 'CAT I Patient Kit',
            'cases' => true,
        ],

        [
            'id' => 'paediatric',
            'name' => 'Paediatric Bundle (RHZE 168 + RH 336)',
            'cases' => true,
        ],

        [
            'id' => '3hp',
            'name' => '3HP (Isoniazid / Rifapentin 300mg/300mg)',
            'cases' => true,
        ],

        [
            'id' => '3rh',
            'name' => '3RH Child (Rifampicin / Isoniazid 75mg/50mg)',
            'cases' => true,
        ],

        [
            'id' => 'bpalm',
            'name' => 'BPaLM Regimen',
            'cases' => true,
        ],

        [
            'id' => 'bpal',
            'name' => 'BPAL Regimen',
            'cases' => true,
        ],

        [
            'id' => 'drtb',
            'name' => 'Prediatric DR-TB Regimen',
            'cases' => true,
        ],


        /*
        |--------------------------------------------------------------------------
        | PRODUCTS BELOW USE THE ORIGINAL DATABASE IDs
        |--------------------------------------------------------------------------
        */

        [
            'id' => 'Moxifloxacin400mg',
            'name' => 'Moxifloxacin 400mg tab',
            'cases' => false,
        ],

        [
            'id' => 'Bedaquiline100mg',
            'name' => 'Bedaquiline 100mg tabs',
            'cases' => false,
        ],

        [
            'id' => 'Linezolid600mg',
            'name' => 'Linezolid 600mg tabs',
            'cases' => false,
        ],

        [
            'id' => 'Pretomanid200mg',
            'name' => 'Pretomanid 200mg',
            'cases' => false,
        ],

        [
            'id' => 'Delamanid50mg',
            'name' => 'Delamanid 50mg tab',
            'cases' => false,
        ],

        [
            'id' => 'Pyridoxine50mg',
            'name' => 'Pyridoxine 50mg tab',
            'cases' => false,
        ],

        [
            'id' => 'R75mgH50mgZ150mg',
            'name' => 'R75mgH50mgZ150mg',
            'cases' => false,
        ],

        [
            'id' => 'R75mgH50mg',
            'name' => 'R75mgH50mg',
            'cases' => false,
        ],

        [
            'id' => 'Ethambutol100mg',
            'name' => 'Ethambutol 100mg',
            'cases' => false,
        ],

        [
            'id' => 'GeneXpertMTBRIF',
            'name' => 'GeneXpert MTB/RIF Ultra cartridge',
            'cases' => false,
        ],

        [
            'id' => 'SputumContainers',
            'name' => 'Sputum containers',
            'cases' => false,
        ],

        [
            'id' => 'TruenatMTBPlus',
            'name' => 'Truenat MTB Plus',
            'cases' => false,
        ],

        [
            'id' => 'UniversalCartridge',
            'name' => 'Universal Cartridge Based Sample Prep Kit',
            'cases' => false,
        ],

        [
            'id' => 'MTBSamplePreTreatment',
            'name' => 'MTB Sample Pre-treatment pack',
            'cases' => false,
        ],

        [
            'id' => 'MTBRIFDx',
            'name' => 'MTB RIF Dx',
            'cases' => false,
        ],

        [
            'id' => 'PositiveControlChip',
            'name' => 'Positive Control Chip',
            'cases' => false,
        ],

        [
            'id' => 'LoopampMTBCDetectionKit',
            'name' => 'Loopamp MTBC Detection Kit',
            'cases' => false,
        ],

        [
            'id' => 'LoopampPUREDNAExtractionKit',
            'name' => 'Loopamp PURE DNA Extraction Kit',
            'cases' => false,
        ],

        [
            'id' => 'Pipette60forTBLAMP',
            'name' => 'Pipette-60 set for TB-LAMP',
            'cases' => false,
        ],

        [
            'id' => 'MB_ADULT',
            'name' => 'MB Adult',
            'cases' => false,
        ],

        [
            'id' => 'MB_CHILD',
            'name' => 'MB Child',
            'cases' => false,
        ],

        [
            'id' => 'Clarithromycin500mg',
            'name' => 'Clarithromycin 500mg',
            'cases' => false,
        ],

        [
            'id' => 'Clarithromycin250mg',
            'name' => 'Clarithromycin 250mg',
            'cases' => false,
        ],

        [
            'id' => 'Rifampicin300mg',
            'name' => 'Rifampicin 300mg',
            'cases' => false,
        ],

        [
            'id' => 'Rifampicin150mg',
            'name' => 'Rifampicin 150mg',
            'cases' => false,
        ],

        [
            'id' => 'Levofloxacin250mg',
            'name' => 'Levofloxacin 250mg',
            'cases' => false,
        ],

        [
            'id' => 'Consummable_Kit',
            'name' => 'Consummable Kit',
            'cases' => false,
        ],

        [
            'id' => 'Determine',
            'name' => 'Determine',
            'cases' => false,
        ],

    ];
}

    private function products1(): array
    {
        return [
            [
                'id' => 'pk1',
                'name' => 'CAT I Patient Kit',
                'cases' => true,
            ],

            [
                'id' => 'paediatric',
                'name' => 'Paediatric Bundle (RHZE 168 + RH 336)',
                'cases' => true,
            ],

            [
                'id' => '3hp',
                'name' => '3HP (Isoniazid / Rifapentin 300mg/300mg)',
                'cases' => true,
            ],

            [
                'id' => '3rh',
                'name' => '3RH Child (Rifampicin / Isoniazid 75mg/50mg)',
                'cases' => true,
            ],

            [
                'id' => 'bpalm',
                'name' => 'BPaLM Regimen',
                'cases' => true,
            ],

            [
                'id' => 'bpal',
                'name' => 'BPAL Regimen',
                'cases' => true,
            ],

            [
                'id' => 'drtb',
                'name' => 'Prediatric DR-TB Regimen',
                'cases' => true,
            ],

            [
                'id' => 'moxifloxacin',
                'name' => 'Moxifloxacin 400mg tab',
                'cases' => false,
            ],

            [
                'id' => 'bedaquiline',
                'name' => 'Bedaquiline 100mg tabs',
                'cases' => false,
            ],

            [
                'id' => 'linezolid',
                'name' => 'Linezolid 600mg tabs',
                'cases' => false,
            ],

            [
                'id' => 'pretomanid',
                'name' => 'Pretomanid 200mg',
                'cases' => false,
            ],

            [
                'id' => 'delamanid',
                'name' => 'Delamanid 50mg tab',
                'cases' => false,
            ],

            [
                'id' => 'pyridoxine',
                'name' => 'Pyridoxine 50mg tab',
                'cases' => false,
            ],

            [
                'id' => 'rhze',
                'name' => 'R75mgH50mgZ150mg',
                'cases' => false,
            ],

            [
                'id' => 'rh',
                'name' => 'R75mgH50mg',
                'cases' => false,
            ],

            [
                'id' => 'ethambutol',
                'name' => 'Ethambutol 100mg',
                'cases' => false,
            ],

            [
                'id' => 'genexpert',
                'name' => 'GeneXpert MTB/RIF Ultra cartridge',
                'cases' => false,
            ],

            [
                'id' => 'sputum',
                'name' => 'Sputum containers',
                'cases' => false,
            ],

            [
                'id' => 'truenat',
                'name' => 'Truenat MTB Plus',
                'cases' => false,
            ],

            [
                'id' => 'sample_prep',
                'name' => 'Universal Cartridge Based Sample Prep Kit',
                'cases' => false,
            ],

            [
                'id' => 'pre_treatment',
                'name' => 'MTB Sample Pre-treatment pack',
                'cases' => false,
            ],

            [
                'id' => 'mtb_rif_dx',
                'name' => 'MTB RIF Dx',
                'cases' => false,
            ],

            [
                'id' => 'positive_control',
                'name' => 'Positive Control Chip',
                'cases' => false,
            ],

            [
                'id' => 'loopamp',
                'name' => 'Loopamp MTBC Detection Kit',
                'cases' => false,
            ],

            [
                'id' => 'loopamp_pure',
                'name' => 'Loopamp PURE DNA Extraction Kit',
                'cases' => false,
            ],

            [
                'id' => 'pipette',
                'name' => 'Pipette-60 set for TB-LAMP',
                'cases' => false,
            ],

            [
                'id' => 'mb_adult',
                'name' => 'MB Adult',
                'cases' => false,
            ],

            [
                'id' => 'mb_child',
                'name' => 'MB Child',
                'cases' => false,
            ],

            [
                'id' => 'clarithromycin_500',
                'name' => 'Clarithromycin 500mg',
                'cases' => false,
            ],

            [
                'id' => 'clarithromycin_250',
                'name' => 'Clarithromycin 250mg',
                'cases' => false,
            ],

            [
                'id' => 'rifampicin_300',
                'name' => 'Rifampicin 300mg',
                'cases' => false,
            ],

            [
                'id' => 'rifampicin_150',
                'name' => 'Rifampicin 150mg',
                'cases' => false,
            ],

            [
                'id' => 'levofloxacin',
                'name' => 'Levofloxacin 250mg',
                'cases' => false,
            ],

            [
                'id' => 'consummable',
                'name' => 'Consummable Kit',
                'cases' => false,
            ],

            [
                'id' => 'determine',
                'name' => 'Determine',
                'cases' => false,
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE 1
    |--------------------------------------------------------------------------
    |
    | "Who are you?"
    |
    | This page does not query inventory.
    |
    */

    public function whoAreYou()
    {
        /*
        | Remove any old shipment preload when starting again.
        */

        session()->forget('shipment_setup');

        return view('shipments.who-are-you', [
            'zones' => $this->zones(),
            'states' => $this->states(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE 1 -> PAGE 2 PRELOAD
    |--------------------------------------------------------------------------
    |
    | This is the important part.
    |
    | We use ONE request to gather the information needed by page 2.
    |
    */

    public function setup()
{
    return view('shipments.setup', [
        'zones' => $this->zones(),
        'states' => $this->states(),
        'stores' => $this->stores(),
    ]);
}

    public function processSetup(Request $request)
    {
        $data = $request->validate([
            'sender_type' => [
                'required',
                'in:national,zonal,state',
            ],

            'sender_id' => [
                'required',
                'string',
            ],
        ]);


        $senderType = $data['sender_type'];

        $selectedLocation = strtolower(
            trim($data['sender_id'])
        );


        /*
        |--------------------------------------------------------------------------
        | Resolve sender
        |--------------------------------------------------------------------------
        */

        $senderId = null;

        $senderName = null;

        $senderZone = null;

        $senderState = null;


        /*
        |--------------------------------------------------------------------------
        | NATIONAL
        |--------------------------------------------------------------------------
        */

        if ($senderType === 'national') {

            if ($selectedLocation !== 'fcms_national_store') {
                abort(422, 'Invalid national store.');
            }

            $senderId =
                'fcms_national_store';

            $senderName =
                'National Store';
        }


        /*
        |--------------------------------------------------------------------------
        | ZONAL
        |--------------------------------------------------------------------------
        */

        if ($senderType === 'zonal') {

            $zone = collect(
                $this->zones()
            )->firstWhere(
                'id',
                $selectedLocation
            );


            if (!$zone) {
                abort(422, 'Invalid zone.');
            }


            $senderZone =
                $zone['id'];

            $senderId =
                $senderZone . '_zonal_store';

            $senderName =
                $zone['name'] . ' Store';
        }


        /*
        |--------------------------------------------------------------------------
        | STATE
        |--------------------------------------------------------------------------
        */

        if ($senderType === 'state') {

            $stateInfo = collect(
                $this->states()
            )->firstWhere(
                'state',
                $selectedLocation
            );


            if (!$stateInfo) {
                abort(422, 'Invalid state.');
            }


            $senderState =
                $stateInfo['state'];

            $senderZone =
                $stateInfo['zone'];

            $senderId =
                $senderState . '_state_store';

            $senderName =
                Str::title($senderState)
                . ' State Store';
        }


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        |
        | Products are application data.
        | No DB request required here.
        |
        */

        $products =
            $this->products();


        /*
        |--------------------------------------------------------------------------
        | PRELOAD INVENTORY + BATCHES
        |--------------------------------------------------------------------------
        |
        | ONE database query.
        |
        | inventory.current_quantity tells us how much the sender
        | currently has available.
        |
        | product_batches gives us batch_no and expiry_date.
        |
        */

        $inventory = DB::table(
            'inventory as i'
        )

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

            ->orderBy(
                'i.product_id'
            )

            ->orderBy(
                'pb.expiry_date'
            )

            ->get();


        /*
        |--------------------------------------------------------------------------
        | Group batches by product
        |--------------------------------------------------------------------------
        */

        $batches = [];


        foreach ($inventory as $row) {

            $productId =
                (string) $row->product_id;


            if (!isset(
                $batches[$productId]
            )) {
                $batches[$productId] = [];
            }


            $batches[$productId][] = [

                'batch_id' =>
                    $row->batch_id,

                'batch_no' =>
                    $row->batch_no,

                'expiry_date' =>
                    $row->expiry_date,

                'available_quantity' =>
                    (float) $row->current_quantity,

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | PRELOAD DESTINATION FACILITIES
        |--------------------------------------------------------------------------
        |
        | We DO NOT load all Nigerian facilities.
        |
        | If the sender is a state store:
        |     load only facilities in that state.
        |
        | If the sender is a zonal store:
        |     load only facilities in that zone.
        |
        | National does not need facilities at this stage.
        |
        */

        $facilities = collect();


        if ($senderType === 'state') {

            $facilities =
                DB::table('facilities_info')

                    ->whereRaw(
                        'LOWER(TRIM(state)) = LOWER(?)',
                        [$senderState]
                    )

                    ->whereNotNull('id')

                    ->whereNotNull('lga')

                    ->whereRaw(
                        "TRIM(lga) <> ''"
                    )

                    ->select([
                        'id',
                        'zone',
                        'state',
                        'lga',
                        'name',
                        'facility_type',
                    ])

                    ->orderBy('lga')
                    ->orderBy('name')

                    ->get();
        }


        if ($senderType === 'zonal') {

            $facilities =
                DB::table('facilities_info')

                    ->whereRaw(
                        'LOWER(TRIM(zone)) = LOWER(?)',
                        [$senderZone]
                    )

                    ->whereNotNull('id')

                    ->whereNotNull('state')

                    ->whereNotNull('lga')

                    ->whereRaw(
                        "TRIM(lga) <> ''"
                    )

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
        }


        /*
        |--------------------------------------------------------------------------
        | Destination state stores
        |--------------------------------------------------------------------------
        |
        | Used by National/Zonal shipment flows.
        |
        */

        $stateStores = [];


        if (
            $senderType === 'national' ||
            $senderType === 'zonal'
        ) {

            $allowedStates =
                collect($this->states());


            if ($senderType === 'zonal') {

                $allowedStates =
                    $allowedStates->where(
                        'zone',
                        $senderZone
                    );
            }


            foreach (
                $allowedStates as $state
            ) {

                $stateStores[] = [

                    'id' =>
                        $state['state']
                        . '_state_store',

                    'state' =>
                        $state['state'],

                    'zone' =>
                        $state['zone'],

                    'name' =>
                        Str::title(
                            $state['state']
                        )
                        . ' State Store',
                ];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Destination zonal stores
        |--------------------------------------------------------------------------
        */

        $zonalStores =
            collect($this->stores())
                ->where(
                    'type',
                    'zonal'
                )
                ->values()
                ->all();


        /*
        |--------------------------------------------------------------------------
        | Determine return receiver
        |--------------------------------------------------------------------------
        */

        $returnReceiver = null;


        if ($senderType === 'zonal') {

            $returnReceiver = [

                'id' =>
                    'fcms_national_store',

                'type' =>
                    'national',

                'name' =>
                    'National Store',

            ];
        }


        if ($senderType === 'state') {

            $zonalStore =
                collect(
                    $this->stores()
                )->firstWhere(
                    'zone',
                    $senderZone
                );


            if ($zonalStore) {

                $returnReceiver = [

                    'id' =>
                        $zonalStore['id'],

                    'type' =>
                        'zonal',

                    'name' =>
                        $zonalStore['name'],

                ];
            }
        }


        if ($senderType === 'national') {

            $returnReceiver = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Build shipment setup
        |--------------------------------------------------------------------------
        */

        $setup = [

            /*
            | Sender
            */

            'sender_type' =>
                $senderType,

            'sender_id' =>
                $senderId,

            'sender_name' =>
                $senderName,

            'sender_zone' =>
                $senderZone,

            'sender_state' =>
                $senderState,


            /*
            | Date
            |
            | The user can change this on page 2.
            */

            'shipment_date' =>
                now()->format('Y-m-d'),


            /*
            | Static data
            */

            'zones' =>
                $this->zones(),

            'states' =>
                $this->states(),

            'stores' =>
                $this->stores(),

            'products' =>
                $products,


            /*
            | Stock / batches
            */

            'batches' =>
                $batches,


            /*
            | Destination data
            */

            'facilities' =>
                $facilities->values()->all(),

            'state_stores' =>
                $stateStores,

            'zonal_stores' =>
                $zonalStores,

            'return_receiver' =>
                $returnReceiver,


            /*
            | Useful information for debugging / refreshing later.
            */

            'loaded_at' =>
                now()->toIso8601String(),

        ];


        /*
        |--------------------------------------------------------------------------
        | Save preload information in session
        |--------------------------------------------------------------------------
        */

        session([
            'shipment_setup' => $setup,
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


    /*
    |--------------------------------------------------------------------------
    | PAGE 2
    |--------------------------------------------------------------------------
    |
    | No database query here.
    |
    | Everything required for the first version of the page was
    | gathered by setup().
    |
    */

    public function create()
    {
        $setup =
            session('shipment_setup');


        /*
        |--------------------------------------------------------------------------
        | User came directly to page 2
        |--------------------------------------------------------------------------
        */

        if (!$setup) {

            return redirect()->route(
                'shipments.who'
            );
        }


        return view(
            'shipments.create',
            [
                'setup' => $setup,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE / SUBMIT SHIPMENT
    |--------------------------------------------------------------------------
    |
    | For now we validate the shipment.
    |
    | We will connect this to the real stock movement after the
    | new shipment UI is confirmed.
    |
    */

    public function store(Request $request)
    {
        $data = $request->validate([

            'shipment_date' => [
                'required',
                'date',
            ],

            'sender_type' => [
                'required',
                'in:national,zonal,state',
            ],

            'sender_id' => [
                'required',
                'string',
            ],

            'shipment_type' => [
                'required',
                'in:supply,transfer,return',
            ],

            'receiver_type' => [
                'required',
                'string',
            ],

            'receiver_id' => [
                'required',
                'string',
            ],

            'receiver_name' => [
                'required',
                'string',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.product_id' => [
                'required',
                'string',
            ],

            'items.*.quantity' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'items.*.batch_id' => [
                'nullable',
                'string',
            ],

            'items.*.cases' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        |
        | We are NOT changing inventory yet.
        |
        | Next step will:
        |
        | 1. Create shipment/order.
        | 2. Create shipment/order items.
        | 3. Validate batch stock again on the server.
        | 4. Deduct/reserve sender stock.
        | 5. Create pending incoming stock.
        |
        */


        return response()->json([

            'success' =>
                true,

            'message' =>
                'Shipment validated successfully.',

            'shipment' =>
                $data,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Helper: stores by type
    |--------------------------------------------------------------------------
    */

    private function storesByType(
        string $type
    ): array {

        return collect(
            $this->stores()
        )
            ->where(
                'type',
                $type
            )
            ->values()
            ->all();
    }


    /*
    |--------------------------------------------------------------------------
    | Helper: zone from zonal store
    |--------------------------------------------------------------------------
    */

    private function zoneFromStore(
        string $storeId
    ): ?string {

        $store =
            collect(
                $this->stores()
            )->firstWhere(
                'id',
                $storeId
            );


        return $store['zone'] ?? null;
    }


    /*
    |--------------------------------------------------------------------------
    | Helper: state from state store
    |--------------------------------------------------------------------------
    */

    private function stateFromStore(
        string $storeId
    ): ?string {

        if (
            !Str::endsWith(
                $storeId,
                '_state_store'
            )
        ) {
            return null;
        }


        return Str::beforeLast(
            $storeId,
            '_state_store'
        );
    }



    /*
|--------------------------------------------------------------------------
| PENDING INCOMING SHIPMENTS
|--------------------------------------------------------------------------
*/

public function pending(Request $request)
{
    $user = $request->user();

    abort_unless($user, 401);

    if (!in_array($user->role, [
        'national',
        'zone',
        'state'
    ], true)) {
        abort(403);
    }

    if (!$user->store_id) {
        abort(403, 'Your account is not connected to a store.');
    }

    $storeId = $user->store_id;

    $shipments = DB::table('orders as o')
        ->leftJoin(
            'orderItems as oi',
            'oi.order_id',
            '=',
            'o.id'
        )
        ->where(
            'o.receiver_facility_id',
            $storeId
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
        ->groupBy(
            'o.id',
            'o.sender_facility_id',
            'o.receiver_facility_id',
            'o.order_type',
            'o.status',
            'o.sent_date',
            'o.created_by'
        )
        ->orderByDesc('o.sent_date')
        ->get();

    $shipments = $shipments->map(function ($shipment) {

        $shipment->sender_name =
            $this->shipmentStoreName(
                $shipment->sender_facility_id
            );

        return $shipment;
    });

    return view(
        'shipments.pending',
        [
            'shipments' => $shipments,

            'storeName' =>
                $this->shipmentStoreName(
                    $storeId
                ),
        ]
    );
}



}