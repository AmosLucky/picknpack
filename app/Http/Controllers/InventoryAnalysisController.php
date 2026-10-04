<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryAnalysisController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Products
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
    | Zones
    |--------------------------------------------------------------------------
    */

    private function zones(): array
    {
        return [
            [
                'id' => 'nc',
                'name' => 'NC Zonal Store',
            ],
            [
                'id' => 'ne',
                'name' => 'NE Zonal Store',
            ],
            [
                'id' => 'nw',
                'name' => 'NW Zonal Store',
            ],
            [
                'id' => 'se',
                'name' => 'SE Zonal Store',
            ],
            [
                'id' => 'ss',
                'name' => 'SS Zonal Store',
            ],
            [
                'id' => 'sw',
                'name' => 'SW Zonal Store',
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
            ['state' => 'benue', 'zone' => 'nc'],
            ['state' => 'kogi', 'zone' => 'nc'],
            ['state' => 'kwara', 'zone' => 'nc'],
            ['state' => 'nasarawa', 'zone' => 'nc'],
            ['state' => 'niger', 'zone' => 'nc'],
            ['state' => 'plateau', 'zone' => 'nc'],
            ['state' => 'fct', 'zone' => 'nc'],

            ['state' => 'adamawa', 'zone' => 'ne'],
            ['state' => 'bauchi', 'zone' => 'ne'],
            ['state' => 'borno', 'zone' => 'ne'],
            ['state' => 'gombe', 'zone' => 'ne'],
            ['state' => 'taraba', 'zone' => 'ne'],
            ['state' => 'yobe', 'zone' => 'ne'],

            ['state' => 'kaduna', 'zone' => 'nw'],
            ['state' => 'kano', 'zone' => 'nw'],
            ['state' => 'katsina', 'zone' => 'nw'],
            ['state' => 'kebbi', 'zone' => 'nw'],
            ['state' => 'sokoto', 'zone' => 'nw'],
            ['state' => 'zamfara', 'zone' => 'nw'],
            ['state' => 'jigawa', 'zone' => 'nw'],

            ['state' => 'abia', 'zone' => 'se'],
            ['state' => 'anambra', 'zone' => 'se'],
            ['state' => 'ebonyi', 'zone' => 'se'],
            ['state' => 'enugu', 'zone' => 'se'],
            ['state' => 'imo', 'zone' => 'se'],

            ['state' => 'akwaibom', 'zone' => 'ss'],
            ['state' => 'bayelsa', 'zone' => 'ss'],
            ['state' => 'crossriver', 'zone' => 'ss'],
            ['state' => 'delta', 'zone' => 'ss'],
            ['state' => 'edo', 'zone' => 'ss'],
            ['state' => 'rivers', 'zone' => 'ss'],

            ['state' => 'ekiti', 'zone' => 'sw'],
            ['state' => 'lagos', 'zone' => 'sw'],
            ['state' => 'ogun', 'zone' => 'sw'],
            ['state' => 'ondo', 'zone' => 'sw'],
            ['state' => 'osun', 'zone' => 'sw'],
            ['state' => 'oyo', 'zone' => 'sw'],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Main page
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


        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $inventoryType = $request->input(
            'inventory_type',
            'current'
        );

        $aggregation = $request->input(
            'aggregation',
            'combine'
        );

        $scope = $request->input(
            'scope',
            'all'
        );

        $quarter = $request->input(
            'quarter'
        );

        $search = trim(
            $request->input(
                'search',
                ''
            )
        );

        $selectedProducts =
            $request->input(
                'products',
                []
            );

        if (!is_array($selectedProducts)) {
            $selectedProducts = [];
        }


        /*
        |--------------------------------------------------------------------------
        | Validate filters
        |--------------------------------------------------------------------------
        */

        if (!in_array($inventoryType, [
            'current',
            'history',
        ], true)) {
            $inventoryType = 'current';
        }

        if (!in_array($aggregation, [
            'combine',
            'individual',
        ], true)) {
            $aggregation = 'combine';
        }


        /*
        |--------------------------------------------------------------------------
        | Product catalogue
        |--------------------------------------------------------------------------
        */

        $products = $this->products();


        /*
        |--------------------------------------------------------------------------
        | Quarters
        |--------------------------------------------------------------------------
        */

        $quarters = DB::table(
            'product_quarterly_summary'
        )
            ->whereNotNull('quarter')
            ->distinct()
            ->pluck('quarter')
            ->filter()
            ->sortDesc()
            ->values();


        if (!$quarter && $quarters->isNotEmpty()) {
            $quarter = $quarters->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Product selection
        |--------------------------------------------------------------------------
        */

        if (empty($selectedProducts)) {

            $selectedProducts =
                array_keys($products);

        } else {

            $selectedProducts =
                array_values(
                    array_intersect(
                        $selectedProducts,
                        array_keys($products)
                    )
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Preload inventory locations
        |--------------------------------------------------------------------------
        */

        $stores = $this->storeCatalog();


        /*
        |--------------------------------------------------------------------------
        | Determine which stores we need
        |--------------------------------------------------------------------------
        */

        $allowedStoreIds =
            $this->storeIdsForScope(
                $scope,
                $stores
            );


        /*
        |--------------------------------------------------------------------------
        | Get analysis data
        |--------------------------------------------------------------------------
        */

        $rows = [];

        if ($inventoryType === 'current') {

            $rows = $this->currentAnalysis(
                $allowedStoreIds,
                $selectedProducts,
                $aggregation,
                $scope,
                $stores
            );

        } else {

            $rows = $this->historyAnalysis(
                $allowedStoreIds,
                $selectedProducts,
                $aggregation,
                $scope,
                $stores,
                $quarter
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Search products / stores
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $needle =
                Str::lower($search);

            $rows = collect($rows)
                ->filter(function ($row) use ($needle) {

                    return Str::contains(
                        Str::lower(
                            $row['name']
                        ),
                        $needle
                    );

                })
                ->values()
                ->all();
        }


        return view(
            'inventory.analysis',
            [
                'rows' => $rows,
                'products' => $products,
                'quarters' => $quarters,
                'stores' => $stores,
                'zones' => $this->zones(),
                'states' => $this->states(),

                'inventoryType' => $inventoryType,
                'aggregation' => $aggregation,
                'scope' => $scope,
                'quarter' => $quarter,
                'selectedProducts' => $selectedProducts,
                'search' => $search,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Current inventory
    |--------------------------------------------------------------------------
    */

    private function currentAnalysis(
        array $storeIds,
        array $selectedProducts,
        string $aggregation,
        string $scope,
        array $stores
    ): array {

        if (empty($storeIds)) {
            return [];
        }


        /*
        |--------------------------------------------------------------------------
        | One inventory query
        |--------------------------------------------------------------------------
        */

        $inventory = DB::table(
            'inventory as i'
        )
            ->whereIn(
                'i.inventory_id',
                $storeIds
            )
            ->whereIn(
                'i.product_id',
                $selectedProducts
            )
            ->select([
                'i.inventory_id',
                'i.product_id',
            ])
            ->selectRaw(
                'SUM(i.current_quantity) as quantity'
            )
            ->groupBy([
                'i.inventory_id',
                'i.product_id',
            ])
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Latest quarterly data
        |--------------------------------------------------------------------------
        */

        $latestQuarter =
            DB::table(
                'product_quarterly_summary'
            )
                ->whereIn(
                    'facility_id',
                    $storeIds
                )
                ->whereIn(
                    'product_id',
                    $selectedProducts
                )
                ->orderByDesc('quarter')
                ->get()
                ->groupBy(
                    fn ($row) =>
                        $row->facility_id
                        . '|'
                        . $row->product_id
                )
                ->map(
                    fn ($items) =>
                        $items->first()
                );


        /*
        |--------------------------------------------------------------------------
        | Combine
        |--------------------------------------------------------------------------
        */

        if ($aggregation === 'combine') {

            $grouped = [];

            foreach ($inventory as $row) {

                $productId =
                    $row->product_id;

                if (!isset($grouped[$productId])) {

                    $grouped[$productId] = [
                        'name' =>
                            $this->products()[
                                $productId
                            ] ?? $productId,

                        'product_id' =>
                            $productId,

                        'store' =>
                            'Combined',

                        'opening' => 0,
                        'received' => 0,
                        'issued' => 0,
                        'quantity' => 0,
                        'losses' => 0,
                    ];
                }


                $grouped[$productId][
                    'quantity'
                ] += (float) $row->quantity;


                $key =
                    $row->inventory_id
                    . '|'
                    . $productId;


                if ($latestQuarter->has($key)) {

                    $q =
                        $latestQuarter->get($key);

                    $grouped[$productId]['opening']
                        += (float) $q->opening;

                    $grouped[$productId]['received']
                        += (float) $q->received;

                    $grouped[$productId]['issued']
                        += (float) $q->issued;
                }
            }

            return array_values($grouped);
        }


        /*
        |--------------------------------------------------------------------------
        | Individual
        |--------------------------------------------------------------------------
        */

        $result = [];

        foreach ($inventory as $row) {

            $store =
                $stores[$row->inventory_id]
                ?? null;

            $key =
                $row->inventory_id
                . '|'
                . $row->product_id;

            $q =
                $latestQuarter->get($key);


            $result[] = [
                'name' =>
                    $this->products()[
                        $row->product_id
                    ] ?? $row->product_id,

                'product_id' =>
                    $row->product_id,

                'store' =>
                    $store['name']
                    ?? $row->inventory_id,

                'store_id' =>
                    $row->inventory_id,

                'zone' =>
                    $store['zone']
                    ?? null,

                'state' =>
                    $store['state']
                    ?? null,

                'opening' =>
                    $q
                    ? (float) $q->opening
                    : 0,

                'received' =>
                    $q
                    ? (float) $q->received
                    : 0,

                'issued' =>
                    $q
                    ? (float) $q->issued
                    : 0,

                'quantity' =>
                    (float) $row->quantity,

                'losses' => 0,
            ];
        }


        return $result;
    }


    /*
    |--------------------------------------------------------------------------
    | Historical analysis
    |--------------------------------------------------------------------------
    */

    private function historyAnalysis(
        array $storeIds,
        array $selectedProducts,
        string $aggregation,
        string $scope,
        array $stores,
        ?string $quarter
    ): array {

        if (
            empty($storeIds) ||
            !$quarter
        ) {
            return [];
        }


        $summary = DB::table(
            'product_quarterly_summary'
        )
            ->where(
                'quarter',
                $quarter
            )
            ->whereIn(
                'facility_id',
                $storeIds
            )
            ->whereIn(
                'product_id',
                $selectedProducts
            )
            ->select([
                'facility_id',
                'product_id',
            ])
            ->selectRaw(
                'SUM(opening) as opening'
            )
            ->selectRaw(
                'SUM(received) as received'
            )
            ->selectRaw(
                'SUM(issued) as issued'
            )
            ->groupBy([
                'facility_id',
                'product_id',
            ])
            ->get();


        $productNames =
            $this->products();


        if ($aggregation === 'combine') {

            $grouped = [];

            foreach ($summary as $row) {

                $productId =
                    $row->product_id;

                if (!isset($grouped[$productId])) {

                    $grouped[$productId] = [
                        'name' =>
                            $productNames[
                                $productId
                            ] ?? $productId,

                        'product_id' =>
                            $productId,

                        'store' =>
                            'Combined',

                        'opening' => 0,
                        'received' => 0,
                        'issued' => 0,
                        'quantity' => 0,
                        'losses' => 0,
                    ];
                }


                $opening =
                    (float) $row->opening;

                $received =
                    (float) $row->received;

                $issued =
                    (float) $row->issued;


                $grouped[$productId]['opening']
                    += $opening;

                $grouped[$productId]['received']
                    += $received;

                $grouped[$productId]['issued']
                    += $issued;

                $grouped[$productId]['quantity']
                    += (
                        $opening
                        + $received
                        - $issued
                    );
            }


            return array_values(
                $grouped
            );
        }


        $result = [];

        foreach ($summary as $row) {

            $store =
                $stores[
                    $row->facility_id
                ] ?? null;


            $opening =
                (float) $row->opening;

            $received =
                (float) $row->received;

            $issued =
                (float) $row->issued;


            $result[] = [

                'name' =>
                    $productNames[
                        $row->product_id
                    ] ?? $row->product_id,

                'product_id' =>
                    $row->product_id,

                'store' =>
                    $store['name']
                    ?? $row->facility_id,

                'store_id' =>
                    $row->facility_id,

                'zone' =>
                    $store['zone']
                    ?? null,

                'state' =>
                    $store['state']
                    ?? null,

                'opening' =>
                    $opening,

                'received' =>
                    $received,

                'issued' =>
                    $issued,

                'quantity' =>
                    $opening
                    + $received
                    - $issued,

                'losses' => 0,
            ];
        }


        return $result;
    }


    /*
    |--------------------------------------------------------------------------
    | Store catalog
    |--------------------------------------------------------------------------
    */

    private function storeCatalog(): array
    {
        $stores = [];


        $stores[
            'fcms_national_store'
        ] = [
            'id' =>
                'fcms_national_store',

            'name' =>
                'FCMS National Store',

            'type' =>
                'national',

            'zone' =>
                null,

            'state' =>
                null,
        ];


        foreach (
            $this->zones()
            as $zone
        ) {

            $id =
                $zone['id']
                . '_zonal_store';


            $stores[$id] = [
                'id' =>
                    $id,

                'name' =>
                    $zone['name'],

                'type' =>
                    'zonal',

                'zone' =>
                    $zone['id'],

                'state' =>
                    null,
            ];
        }


        foreach (
            $this->states()
            as $state
        ) {

            $id =
                $state['state']
                . '_state_store';


            $stores[$id] = [
                'id' =>
                    $id,

                'name' =>
                    Str::title(
                        $state['state']
                    )
                    . ' State Store',

                'type' =>
                    'state',

                'zone' =>
                    $state['zone'],

                'state' =>
                    $state['state'],
            ];
        }


        return $stores;
    }


    /*
    |--------------------------------------------------------------------------
    | Scope → store IDs
    |--------------------------------------------------------------------------
    */

    private function storeIdsForScope(
        string $scope,
        array $stores
    ): array {

        if ($scope === 'all') {
            return array_keys($stores);
        }


        if ($scope === 'national') {

            return [
                'fcms_national_store',
            ];
        }


        if (
            str_ends_with(
                $scope,
                '_zone'
            )
        ) {

            $zone =
                str_replace(
                    '_zone',
                    '',
                    $scope
                );


            return collect($stores)
                ->filter(
                    fn ($store) =>
                        $store['zone']
                        === $zone
                )
                ->keys()
                ->values()
                ->all();
        }


        if (
            str_ends_with(
                $scope,
                '_state'
            )
        ) {

            $state =
                str_replace(
                    '_state',
                    '',
                    $scope
                );


            return collect($stores)
                ->filter(
                    fn ($store) =>
                        $store['state']
                        === $state
                )
                ->keys()
                ->values()
                ->all();
        }


        return array_keys($stores);
    }
}