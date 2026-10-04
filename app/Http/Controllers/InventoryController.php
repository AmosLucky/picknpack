<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INVENTORY PRODUCTS
    |--------------------------------------------------------------------------
    |
    | These are the actual product IDs used by the inventory database.
    |
    */

    private function products(): array
    {
        return [

            [
                'id' => 'pk1',
                'name' => 'CAT I Patient Kit',
            ],

            [
                'id' => 'paediatric',
                'name' => 'Paediatric Bundle (RHZE 168 + RH 336)',
            ],

            [
                'id' => '3hp',
                'name' => '3HP (Isoniazid / Rifapentin 300mg/300mg)',
            ],

            [
                'id' => '3rh',
                'name' => '3RH Child (Rifampicin / Isoniazid 75mg/50mg)',
            ],

            [
                'id' => 'bpalm',
                'name' => 'BPaLM Regimen',
            ],

            [
                'id' => 'bpal',
                'name' => 'BPAL Regimen',
            ],

            [
                'id' => 'drtb',
                'name' => 'Prediatric DR-TB Regimen',
            ],

            [
                'id' => 'Moxifloxacin400mg',
                'name' => 'Moxifloxacin 400mg tab',
            ],

            [
                'id' => 'Bedaquiline100mg',
                'name' => 'Bedaquiline 100mg tabs',
            ],

            [
                'id' => 'Linezolid600mg',
                'name' => 'Linezolid 600mg tabs',
            ],

            [
                'id' => 'Pretomanid200mg',
                'name' => 'Pretomanid 200mg',
            ],

            [
                'id' => 'Delamanid50mg',
                'name' => 'Delamanid 50mg tab',
            ],

            [
                'id' => 'Pyridoxine50mg',
                'name' => 'Pyridoxine 50mg tab',
            ],

            [
                'id' => 'R75mgH50mgZ150mg',
                'name' => 'R75mgH50mgZ150mg',
            ],

            [
                'id' => 'R75mgH50mg',
                'name' => 'R75mgH50mg',
            ],

            [
                'id' => 'Ethambutol100mg',
                'name' => 'Ethambutol 100mg',
            ],

            [
                'id' => 'GeneXpertMTBRIF',
                'name' => 'GeneXpert MTB/RIF Ultra cartridge',
            ],

            [
                'id' => 'SputumContainers',
                'name' => 'Sputum containers',
            ],

            [
                'id' => 'TruenatMTBPlus',
                'name' => 'Truenat MTB Plus',
            ],

            [
                'id' => 'UniversalCartridge',
                'name' => 'Universal Cartridge Based Sample Prep Kit',
            ],

            [
                'id' => 'MTBSamplePreTreatment',
                'name' => 'MTB Sample Pre-treatment pack',
            ],

            [
                'id' => 'MTBRIFDx',
                'name' => 'MTB RIF Dx',
            ],

            [
                'id' => 'PositiveControlChip',
                'name' => 'Positive Control Chip',
            ],

            [
                'id' => 'LoopampMTBCDetectionKit',
                'name' => 'Loopamp MTBC Detection Kit',
            ],

            [
                'id' => 'LoopampPUREDNAExtractionKit',
                'name' => 'Loopamp PURE DNA Extraction Kit',
            ],

            [
                'id' => 'Pipette60forTBLAMP',
                'name' => 'Pipette-60 set for TB-LAMP',
            ],

            [
                'id' => 'MB_ADULT',
                'name' => 'MB Adult',
            ],

            [
                'id' => 'MB_CHILD',
                'name' => 'MB Child',
            ],

            [
                'id' => 'Clarithromycin500mg',
                'name' => 'Clarithromycin 500mg',
            ],

            [
                'id' => 'Clarithromycin250mg',
                'name' => 'Clarithromycin 250mg',
            ],

            [
                'id' => 'Rifampicin300mg',
                'name' => 'Rifampicin 300mg',
            ],

            [
                'id' => 'Rifampicin150mg',
                'name' => 'Rifampicin 150mg',
            ],

            [
                'id' => 'Levofloxacin250mg',
                'name' => 'Levofloxacin 250mg',
            ],

            [
                'id' => 'Consummable_Kit',
                'name' => 'Consummable Kit',
            ],

            [
                'id' => 'Determine',
                'name' => 'Determine',
            ],

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Logged-in user
        |--------------------------------------------------------------------------
        */

        $user = $request->user();

        if (!$user) {
            abort(401);
        }


        /*
        |--------------------------------------------------------------------------
        | Only our three inventory roles
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $user->role,
            ['national', 'zone', 'state'],
            true
        )) {
            abort(
                403,
                'You are not authorised to view inventory.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Store belonging to logged-in user
        |--------------------------------------------------------------------------
        */

        $storeId = trim(
            (string) $user->store_id
        );


        if ($storeId === '') {
            abort(
                403,
                'No inventory store is assigned to your account.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | View type
        |--------------------------------------------------------------------------
        */

        $viewType = strtolower(
            trim(
                (string) $request->get(
                    'view_type',
                    'current'
                )
            )
        );


        if (!in_array(
            $viewType,
            ['current', 'quarter'],
            true
        )) {
            $viewType = 'current';
        }


        /*
        |--------------------------------------------------------------------------
        | Available quarters for this store
        |--------------------------------------------------------------------------
        |
        | We only show quarters that actually exist for this store.
        |
        */

        $quartersRaw = DB::table(
            'product_quarterly_summary'
        )
            ->where(
                'facility_id',
                $storeId
            )
            ->whereNotNull('quarter')
            ->where(
                'quarter',
                '!=',
                ''
            )
            ->distinct()
            ->pluck('quarter')
            ->map(
                fn ($quarter) => strtolower(
                    trim((string) $quarter)
                )
            )
            ->filter()
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Sort quarters chronologically
        |--------------------------------------------------------------------------
        */

        $quarters = $quartersRaw
            ->sortBy(
                function ($quarter) {

                    if (
                        preg_match(
                            '/q([1-4])[_-]?(\d{2,4})/i',
                            $quarter,
                            $matches
                        )
                    ) {

                        $q = (int) $matches[1];

                        $year = (int) $matches[2];

                        if ($year < 100) {
                            $year += 2000;
                        }

                        return ($year * 10) + $q;
                    }

                    return 999999;
                }
            )
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | Selected quarter
        |--------------------------------------------------------------------------
        */

        $selectedQuarter = strtolower(
            trim(
                (string) $request->get(
                    'quarter',
                    ''
                )
            )
        );


        /*
        |--------------------------------------------------------------------------
        | If quarter view but no quarter supplied,
        | select the newest available quarter.
        |--------------------------------------------------------------------------
        */

        if (
            $viewType === 'quarter'
            && $selectedQuarter === ''
            && !empty($quarters)
        ) {
            $selectedQuarter =
                $quarters[count($quarters) - 1];
        }


        /*
        |--------------------------------------------------------------------------
        | Load live inventory
        |--------------------------------------------------------------------------
        |
        | This is ALWAYS loaded because:
        |
        | - batch information comes from inventory
        | - expiry information comes from product_batches
        | - current view needs it
        | - quarter view can still display batch/expiry information
        |
        */

        $inventoryRows = DB::table(
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
                $storeId
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
        | Group inventory by product
        |--------------------------------------------------------------------------
        */

        $inventoryByProduct = $inventoryRows
            ->groupBy(
                fn ($row) => (string) $row->product_id
            );


        /*
        |--------------------------------------------------------------------------
        | Quarterly data
        |--------------------------------------------------------------------------
        */

        $quarterlyByProduct = collect();


        if (
            $viewType === 'quarter'
            && $selectedQuarter !== ''
        ) {

            $quarterlyByProduct = DB::table(
                'product_quarterly_summary'
            )
                ->where(
                    'facility_id',
                    $storeId
                )
                ->where(
                    'quarter',
                    $selectedQuarter
                )
                ->get()
                ->keyBy(
                    fn ($row) =>
                        (string) $row->product_id
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Product names
        |--------------------------------------------------------------------------
        */

        $productDefinitions = collect(
            $this->products()
        )->keyBy('id');


        /*
        |--------------------------------------------------------------------------
        | Build table data
        |--------------------------------------------------------------------------
        */

        $tableProducts = collect();


        /*
        |--------------------------------------------------------------------------
        | Use products from inventory + quarterly records
        |--------------------------------------------------------------------------
        */

        $productIds = collect(
            $inventoryByProduct->keys()
        );


        if (
            $viewType === 'quarter'
            && $quarterlyByProduct->isNotEmpty()
        ) {

            $productIds = $productIds
                ->merge(
                    $quarterlyByProduct->keys()
                )
                ->unique()
                ->values();
        }


        foreach ($productIds as $productId) {

            $productId = (string) $productId;

            $batches = $inventoryByProduct
                ->get(
                    $productId,
                    collect()
                );


            /*
            |--------------------------------------------------------------------------
            | Product name
            |--------------------------------------------------------------------------
            */

            $productName =
                $productDefinitions
                    ->get($productId)['name']
                    ?? $productId;


            /*
            |--------------------------------------------------------------------------
            | Live quantity
            |--------------------------------------------------------------------------
            */

            $liveQuantity = $batches->sum(
                fn ($batch) =>
                    (float) $batch->current_quantity
            );


            /*
            |--------------------------------------------------------------------------
            | Quarterly quantity
            |--------------------------------------------------------------------------
            */

            $quarterRecord =
                $quarterlyByProduct->get(
                    $productId
                );


            $quarterQuantity = null;

            if ($quarterRecord) {

                $quarterQuantity =
                    (float) ($quarterRecord->opening ?? 0)
                    + (float) ($quarterRecord->received ?? 0)
                    - (float) ($quarterRecord->issued ?? 0);
            }


            /*
            |--------------------------------------------------------------------------
            | Display quantity
            |--------------------------------------------------------------------------
            */

            $displayQuantity =
                $viewType === 'quarter'
                    ? ($quarterQuantity ?? 0)
                    : $liveQuantity;


            /*
            |--------------------------------------------------------------------------
            | Closest expiry
            |--------------------------------------------------------------------------
            */

            $closestExpiry = null;


            foreach ($batches as $batch) {

                if (
                    empty($batch->expiry_date)
                ) {
                    continue;
                }


                try {

                    $expiry =
                        Carbon::parse(
                            $batch->expiry_date
                        );

                } catch (\Throwable $e) {

                    continue;
                }


                if (
                    $closestExpiry === null
                    || $expiry->lt(
                        $closestExpiry
                    )
                ) {
                    $closestExpiry = $expiry;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Expiry warning
            |--------------------------------------------------------------------------
            |
            | Red if:
            |
            | 1. Already expired
            | OR
            | 2. Expires within 3 months
            |
            */

            $expiryWarning = false;
            $expiryExpired = false;


            if ($closestExpiry) {

                $expiryExpired =
                    $closestExpiry->isPast();

                $expiryWarning =
                    $expiryExpired
                    ||
                    $closestExpiry->lte(
                        now()->addMonths(3)
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Prepare batches for Blade
            |--------------------------------------------------------------------------
            */

            $batchData = $batches
                ->map(
                    function ($batch) {

                        $expiry = null;

                        if (
                            !empty(
                                $batch->expiry_date
                            )
                        ) {

                            try {

                                $expiry =
                                    Carbon::parse(
                                        $batch->expiry_date
                                    );

                            } catch (
                                \Throwable $e
                            ) {

                                $expiry = null;
                            }
                        }


                        $expired =
                            $expiry
                            ? $expiry->isPast()
                            : false;


                        $warning =
                            $expiry
                            ? (
                                $expired
                                ||
                                $expiry->lte(
                                    now()->addMonths(3)
                                )
                            )
                            : false;


                        return [
                            'batch_id' =>
                                $batch->batch_id,

                            'batch_no' =>
                                $batch->batch_no,

                            'quantity' =>
                                (float)
                                $batch->current_quantity,

                            'batch_quantity' =>
                                (float)
                                ($batch->batch_quantity ?? 0),

                            'expiry_date' =>
                                $expiry
                                ? $expiry->format(
                                    'Y-m-d'
                                )
                                : null,

                            'expiry_warning' =>
                                $warning,

                            'expired' =>
                                $expired,
                        ];
                    }
                )
                ->values()
                ->all();


            /*
            |--------------------------------------------------------------------------
            | Add product
            |--------------------------------------------------------------------------
            */

            $tableProducts->push([

                'id' =>
                    $productId,

                'name' =>
                    $productName,

                'total_batches' =>
                    $batches->count(),

                'live_quantity' =>
                    $liveQuantity,

                'quarter_quantity' =>
                    $quarterQuantity,

                'quantity' =>
                    $displayQuantity,

                'closest_expiry' =>
                    $closestExpiry
                    ? $closestExpiry->format(
                        'Y-m-d'
                    )
                    : null,

                'expiry_warning' =>
                    $expiryWarning,

                'expiry_expired' =>
                    $expiryExpired,

                'batches' =>
                    $batchData,

                'opening' =>
                    $quarterRecord
                    ? (float)
                        ($quarterRecord->opening ?? 0)
                    : null,

                'received' =>
                    $quarterRecord
                    ? (float)
                        ($quarterRecord->received ?? 0)
                    : null,

                'issued' =>
                    $quarterRecord
                    ? (float)
                        ($quarterRecord->issued ?? 0)
                    : null,

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Sort products alphabetically
        |--------------------------------------------------------------------------
        */

        $tableProducts = $tableProducts
            ->sortBy(
                fn ($product) =>
                    strtolower(
                        $product['name']
                    )
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $totalProducts =
            $tableProducts->count();


        $totalQuantity =
            $tableProducts->sum(
                fn ($product) =>
                    (float) $product['quantity']
            );


        /*
        |--------------------------------------------------------------------------
        | Nearing expiry count
        |--------------------------------------------------------------------------
        |
        | Count PRODUCTS with at least one
        | batch expiring within 3 months.
        |
        */

        $nearingExpiry =
            $tableProducts->filter(
                fn ($product) =>
                    $product['expiry_warning'] === true
            )->count();


        /*
        |--------------------------------------------------------------------------
        | Store name
        |--------------------------------------------------------------------------
        */

        $storeName = $this->storeName(
            $storeId,
            $user
        );


        /*
        |--------------------------------------------------------------------------
        | Return page
        |--------------------------------------------------------------------------
        */

        return view(
            'inventory.index',
            [
                'user' => $user,

                'storeId' => $storeId,

                'storeName' => $storeName,

                'viewType' => $viewType,

                'quarters' => $quarters,

                'selectedQuarter' =>
                    $selectedQuarter,

                'products' =>
                    $tableProducts,

                'totalProducts' =>
                    $totalProducts,

                'totalQuantity' =>
                    $totalQuantity,

                'nearingExpiry' =>
                    $nearingExpiry,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE NAME
    |--------------------------------------------------------------------------
    */

    private function storeName(
        string $storeId,
        $user
    ): string {

        if (
            $storeId ===
            'fcms_national_store'
        ) {
            return 'National Store';
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

            return strtoupper($zone)
                . ' Zonal Store';
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

            return ucwords(
                str_replace(
                    '_',
                    ' ',
                    $state
                )
            ) . ' State Store';
        }


        /*
        |--------------------------------------------------------------------------
        | Facility / other inventory
        |--------------------------------------------------------------------------
        */

        return $user->name
            ?: $storeId;
    }
}