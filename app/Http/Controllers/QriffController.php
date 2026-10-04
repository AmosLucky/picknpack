<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class QriffController extends Controller
{
    // QRIFF controller v12 - template UUID/name mapping + text-safe fields

    /*
    |--------------------------------------------------------------------------
    | QRIFF PRODUCTS
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | Replace the IDs below with the product IDs already used by your
    | existing application.
    |
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
             * Continue the remaining 28 products here
             * using the product IDs already existing in your project.
             */

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
    | QRIFF PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
         * If your states are stored differently, change this query.
         */

        $states = DB::table('facilities_info')
            ->whereNotNull('state')
            ->where('state', '!=', '')
            ->distinct()
            ->orderBy('state')
            ->pluck('state');


        /*
         * Adjust these values if your application uses another
         * quarter naming convention.
         */

        $quarters = [
            'Q1_26',
            'Q2_26',
            'Q3_26',
            'Q4_26',

            'Q1_27',
            'Q2_27',
            'Q3_27',
            'Q4_27',
        ];


        return view('qriff.index', compact(
            'states',
            'quarters'
        ));
    }



public function record(Request $request)
{
    $states = DB::table('facilities_info')
        ->whereNotNull('state')
        ->whereRaw("TRIM(state) <> ''")
        ->distinct()
        ->orderBy('state')
        ->pluck('state');

    $quarters = [
        'Q1_26',
        'Q2_26',
        'Q3_26',
        'Q4_26',
        'Q1_27',
        'Q2_27',
        'Q3_27',
        'Q4_27',
    ];

    $products = $this->products();

    /*
     * State should normally come from the logged-in user's
     * state/profile. For now we accept it from the request.
     */
    $state = trim((string) $request->input('state'));

    $quarter = trim((string) $request->input('quarter'));

    $lga = trim((string) $request->input('lga'));

    $productId = trim((string) $request->input('product_id'));

    $lgas = collect();

    if ($state !== '') {
        $lgas = DB::table('facilities_info')
            ->whereRaw(
                'LOWER(TRIM(state)) = LOWER(?)',
                [$state]
            )
            ->whereNotNull('lga')
            ->whereRaw("TRIM(lga) <> ''")
            ->distinct()
            ->orderBy('lga')
            ->pluck('lga');
    }

    /*
     * If the user has not selected LGA/product yet,
     * just show the selection page.
     */
    if (
        $quarter === '' ||
        $lga === '' ||
        $productId === ''
    ) {
        return view('qriff.record-select', [
            'states' => $states,
            'quarters' => $quarters,
            'products' => $products,
            'state' => $state,
            'quarter' => $quarter,
            'lga' => $lga,
            'productId' => $productId,
            'lgas' => $lgas,
        ]);
    }

    /*
     * Make sure the selected product exists.
     */
    $product = collect($products)
        ->firstWhere('id', $productId);

    if (!$product) {
        return back()->with(
            'error',
            'The selected product is invalid.'
        );
    }

    /*
     * Get facilities belonging to the selected state + LGA.
     */
    $facilities = DB::table('facilities_info')
        ->whereRaw(
            'LOWER(TRIM(state)) = LOWER(?)',
            [$state]
        )
        ->whereRaw(
            'LOWER(TRIM(lga)) = LOWER(?)',
            [$lga]
        )
        ->whereNotNull('id')
        ->orderBy('name')
        ->get();

    /*
     * Get existing QRIFF records for ONLY this:
     *
     * quarter + product + facilities
     */
    $facilityIds = $facilities
        ->pluck('id')
        ->filter()
        ->values()
        ->toArray();

    $qriffRecords = DB::table('qriff')
        ->where('quarter', $quarter)
        ->where('product_id', $productId)
        ->whereIn('facility_id', $facilityIds)
        ->get()
        ->keyBy('facility_id');

    /*
     * Attach existing QRIFF values to each facility.
     */
    $rows = $facilities->map(function ($facility) use ($qriffRecords) {

        $record = $qriffRecords->get($facility->id);

        return [
            'facility_id' => $facility->id,

            'facility_name' =>
                $facility->name,

            'lga' =>
                $facility->lga,

            'opening' =>
                $record->opening ?? 0,

            'received' =>
                $record->received ?? 0,

            'issued' =>
                $record->issued ?? 0,

            'physical' =>
                $record->physical ?? 0,

            'cases' =>
                $record->cases ?? 0,

            'remarks' =>
                $record->remarks ?? '',
        ];
    });

    return view('qriff.record', [
        'state' => $state,
        'quarter' => $quarter,
        'lga' => $lga,
        'product' => $product,
        'rows' => $rows,
        'products' => $products,
    ]);
}



public function storeRecord(Request $request)
{
    $validated = $request->validate([
        'state' => [
            'required',
            'string',
        ],

        'quarter' => [
            'required',
            'string',
        ],

        'lga' => [
            'required',
            'string',
        ],

        'product_id' => [
            'required',
            'string',
        ],

        'rows' => [
            'required',
            'array',
        ],

        'rows.*.facility_id' => [
            'required',
            'string',
        ],

        'rows.*.opening' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'rows.*.received' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'rows.*.issued' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'rows.*.physical' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'rows.*.cases' => [
            'nullable',
            'numeric',
            'min:0',
        ],

        'rows.*.remarks' => [
            'nullable',
            'string',
        ],
    ]);

    /*
     * Confirm the product exists.
     */
    $product = collect($this->products())
        ->firstWhere(
            'id',
            $validated['product_id']
        );

    if (!$product) {
        return back()->with(
            'error',
            'Invalid product selected.'
        );
    }

    /*
     * Confirm the facilities actually belong to
     * the selected state + LGA.
     */
    $facilityIds = DB::table('facilities_info')
        ->whereRaw(
            'LOWER(TRIM(state)) = LOWER(?)',
            [$validated['state']]
        )
        ->whereRaw(
            'LOWER(TRIM(lga)) = LOWER(?)',
            [$validated['lga']]
        )
        ->pluck('id')
        ->toArray();

    $allowedFacilities = array_flip($facilityIds);

    $saved = 0;

    DB::transaction(function () use (
        $validated,
        $allowedFacilities,
        &$saved
    ) {

        foreach ($validated['rows'] as $row) {

            $facilityId = trim(
                (string) $row['facility_id']
            );

            /*
             * Never allow someone to submit an arbitrary
             * facility ID outside the selected LGA.
             */
            if (!isset($allowedFacilities[$facilityId])) {
                continue;
            }

            $data = [
                'facility_id' => $facilityId,

                'product_id' =>
                    $validated['product_id'],

                'quarter' =>
                    $validated['quarter'],

                'opening' =>
                    $row['opening'] ?? 0,

                'received' =>
                    $row['received'] ?? 0,

                'issued' =>
                    $row['issued'] ?? 0,

                'physical' =>
                    $row['physical'] ?? 0,

                'cases' =>
                    $row['cases'] ?? 0,

                'remarks' =>
                    trim((string) ($row['remarks'] ?? '')),
            ];

            /*
             * Find the existing QRIFF record.
             */
            $existing = DB::table('qriff')
                ->where('facility_id', $facilityId)
                ->where(
                    'product_id',
                    $validated['product_id']
                )
                ->where(
                    'quarter',
                    $validated['quarter']
                )
                ->first();

            if ($existing) {

                DB::table('qriff')
                    ->where('id', $existing->id)
                    ->update([
                        'opening' =>
                            $data['opening'],

                        'received' =>
                            $data['received'],

                        'issued' =>
                            $data['issued'],

                        'physical' =>
                            $data['physical'],

                        'cases' =>
                            $data['cases'],

                        'remarks' =>
                            $data['remarks'],
                    ]);

            } else {

                /*
                 * qriff.id is NOT NULL in your database,
                 * so generate the UUID ourselves.
                 */
                $data['id'] =
                    (string) Str::uuid();

                DB::table('qriff')
                    ->insert($data);
            }

            $saved++;
        }
    });

    return redirect()
        ->route('qriff.record', [
            'state' =>
                $validated['state'],

            'quarter' =>
                $validated['quarter'],

            'lga' =>
                $validated['lga'],

            'product_id' =>
                $validated['product_id'],
        ])
        ->with(
            'success',
            $saved . ' QRIFF record(s) saved successfully.'
        );
}


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD
    |--------------------------------------------------------------------------
    */


    
    public function download(Request $request)
    {
        @ini_set('max_execution_time', '0');
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');
        @set_time_limit(0);

        $request->validate([
            'state' => ['required', 'string'],
            'quarter' => ['required', 'string'],
        ]);

        $state = trim($request->state);
        $quarter = trim($request->quarter);

        // Give large Excel exports enough time.
        @ini_set('max_execution_time', '0');
        @set_time_limit(0);

        $facilities = DB::table('facilities_info')
            ->whereRaw('LOWER(TRIM(state)) = LOWER(?)', [$state])
            ->whereNotNull('id')
            ->whereNotNull('lga')
            ->whereRaw("TRIM(lga) <> ''")
            ->orderBy('lga')
            ->orderBy('name')
            ->get();

        if ($facilities->isEmpty()) {
            return back()->with('error', 'No facilities were found for ' . $state);
        }

        $facilityIds = $facilities->pluck('id')->filter()->values()->toArray();

        $qriffRecords = DB::table('qriff')
            ->where('quarter', $quarter)
            ->whereIn('facility_id', $facilityIds)
            ->get();

        $qriff = [];
        foreach ($qriffRecords as $record) {
            $qriff[$record->facility_id][$record->product_id] = $record;
        }

        /*
         * IMPORTANT:
         * Use the supplied ORIGINAL QRIFF workbook as the formatting master.
         * Do not use a previously generated/downloaded workbook as the template.
         *
         * For Enugu, storage/app/qriff_templates/enugu.xlsx must be the clean
         * Q1_25/Q1_26-style template with the correct Facility Name column.
         */
        $templatePath = $this->qriffTemplatePath($state);

        if (!$templatePath || !is_file($templatePath)) {
            return back()->with(
                'error',
                'QRIFF template not found. Put the supplied templates in storage/app/qriff_templates/.'
            );
        }

        try {
            $spreadsheet = IOFactory::load($templatePath);
        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'The QRIFF template could not be opened: ' . $e->getMessage()
            );
        }

        if ($spreadsheet->getSheetCount() === 0) {
            return back()->with('error', 'The QRIFF template contains no worksheets.');
        }

        /*
         * Keep ONLY the first clean template sheet.
         *
         * This prevents existing template tabs (ado-ekiti, ANINRI, etc.)
         * from colliding with the new DB-generated tabs and prevents _2 names.
         */
        $templateSheets = $spreadsheet->getAllSheets();
        $styleSource = $templateSheets[0];
        $templateByLga = [];
        $templateMaxRows = [];
        $templateFacilityNames = [];
        foreach ($templateSheets as $templateSheet) {
            $templateByLga[$this->normalizeLgaName($templateSheet->getTitle())] = $templateSheet;
            $templateMaxRows[spl_object_hash($templateSheet)] = $templateSheet->getHighestRow();

            // The supplied workbook already contains the authoritative facility
            // names and hidden facility UUIDs. Keep that mapping as a fallback
            // in case an imported facilities_info.name is blank/0.
            $maxTemplateRow = $templateSheet->getHighestRow();
            for ($tr = 4; $tr <= $maxTemplateRow; $tr++) {
                $templateFacilityId = trim((string) $templateSheet->getCell('GC' . $tr)->getValue());
                $templateFacilityName = trim((string) $templateSheet->getCell('B' . $tr)->getValue());
                if ($templateFacilityId !== '' && $templateFacilityName !== '') {
                    $templateFacilityNames[$templateFacilityId] = $templateFacilityName;
                }
            }
        }
        $fallbackTemplate = $styleSource;

        $groups = $facilities->groupBy(function ($facility) {
            return trim((string) $facility->lga);
        });

        $generatedSheets = [];
        $temporaryCounter = 1;

        foreach ($groups as $lga => $lgaFacilities) {
            $baseName = Str::limit($this->cleanSheetName($lga), 31, '');

            if ($baseName === '') {
                $baseName = 'LGA';
            }

            $sourceSheet = $templateByLga[$this->normalizeLgaName($lga)] ?? $fallbackTemplate;
            $sourceTitle = $sourceSheet->getTitle();

            $sheet = $spreadsheet->duplicateWorksheetByTitle($sourceTitle);
            // Original template sheets still exist, so use a temporary unique title.
            $sheet->setTitle('__QRIFF_NEW_' . $temporaryCounter++);

            $targetLastRow = 3 + $lgaFacilities->count();
            $templateMaxRow = $templateMaxRows[spl_object_hash($sourceSheet)] ?? 4;

            /*
             * Extend the supplied row style when an LGA has more facilities
             * than the template contains.
             */
            if ($targetLastRow > $templateMaxRow) {
                $styleRow4 = $styleSource->getStyle('A4:GC4');
                $styleRow5 = $templateMaxRow >= 5
                    ? $styleSource->getStyle('A5:GC5')
                    : $styleRow4;

                for ($r = $templateMaxRow + 1; $r <= $targetLastRow; $r++) {
                    $sourceStyle = (($r - 4) % 2 === 0)
                        ? $styleRow4
                        : $styleRow5;

                    $sheet->duplicateStyle(
                        $sourceStyle,
                        'A' . $r . ':GC' . $r
                    );
                }
            }

            /*
             * Title.
             */
            $sheet->setCellValue(
                'A1',
                'QRIFF Data for ' . $state . ' - ' . $lga . ' - QUARTER: ' . $quarter
            );

            // Keep rows 2-3 exactly as supplied by the original template.

            $sheet->setCellValue('GC2', 'Facility ID');
            $sheet->setCellValue('GC3', 'Hidden ID');
            $sheet->getColumnDimension('GC')->setVisible(false);

            /*
             * Write every facility row. B contains the actual facility name;
             * GC contains the UUID used by upload.
             */
            $row = 4;
            $serial = 1;

            foreach ($lgaFacilities as $facility) {
                $sheet->setCellValue('A' . $row, $serial);

                // IMPORTANT: Facility Name must come from the original QRIFF
                // template mapping (UUID -> name) whenever possible. Do NOT let
                // a numeric value from facilities_info overwrite column B.
                $facilityIdKey = trim((string) $facility->id);
                $templateName = trim((string) ($templateFacilityNames[$facilityIdKey] ?? ''));
                $dbName = trim((string) ($facility->name ?? ''));

                if ($templateName !== '' && $templateName !== '0') {
                    $facilityName = $templateName;
                } elseif ($dbName !== '' && $dbName !== '0') {
                    $facilityName = $dbName;
                } else {
                    $facilityName = '';
                }

               $sheet->setCellValueExplicit(
    'GC' . $row,
    (string) $facility->id,
    \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
);


// ============================================================
// TEMPORARY DEBUG: CHECK AMA EKE HC BPaLM RECORD
// ============================================================
if (strtolower(trim($facility->name)) === 'amaeke hc') {

    $debugRecord = $qriff[$facility->id]['bpalm'] ?? null;

    // if (!$debugRecord) {
    //     dd([
    //         'error' => 'BPaLM record not found',
    //         'facility' => $facility->name,
    //         'facility_id' => $facility->id,
    //         'row' => $row,
    //     ]);
    // }

    // BPaLM is product #5.
    // Its columns are:
    // AA = Opening
    // AB = Received
    // AC = Issued
    // AD = Physical
    // AE = Cases
    // AF = Remarks

    $sheet->setCellValue('AA' . $row, (float) $debugRecord->opening);
    $sheet->setCellValue('AB' . $row, (float) $debugRecord->received);
    $sheet->setCellValue('AC' . $row, (float) $debugRecord->issued);
    $sheet->setCellValue('AD' . $row, (float) $debugRecord->physical);
    $sheet->setCellValue('AE' . $row, (float) $debugRecord->cases);
    $sheet->setCellValue('AF' . $row, (string) $debugRecord->remarks);

   
}

// Continue normal Excel generation
$column = 3;

                

                foreach ($this->products() as $product) {
                    $record = $qriff[$facility->id][$product['id']] ?? null;

                    if (
    strtolower(trim($facility->name)) === 'amaeke hc' &&
    $product['id'] === 'bpalm'
) {
    // dd([
    //     'facility' => $facility->name,
    //     'row' => $row,

    //     'product_id' => $product['id'],
    //     'product_name' => $product['name'] ?? null,

    //     'column_start_number' => $column,
    //     'column_start_letter' => $this->columnLetter($column),

    //     'record' => [
    //         'opening' => $record?->opening,
    //         'received' => $record?->received,
    //         'issued' => $record?->issued,
    //         'physical' => $record?->physical,
    //         'cases' => $record?->cases,
    //         'remarks' => $record?->remarks,
    //     ],
    // ]);
}

                    $sheet->setCellValue(
                        $this->columnLetter($column) . $row,
                        $record->opening ?? 0
                    );

                    $sheet->setCellValue(
                        $this->columnLetter($column + 1) . $row,
                        $record->received ?? 0
                    );

                    $sheet->setCellValue(
                        $this->columnLetter($column + 2) . $row,
                        $record->issued ?? 0
                    );

                    $sheet->setCellValue(
                        $this->columnLetter($column + 3) . $row,
                        $record->physical ?? 0
                    );

                    $offset = 4;

                    if ($product['cases']) {
                        $sheet->setCellValue(
                            $this->columnLetter($column + $offset) . $row,
                            $record->cases ?? 0
                        );
                        $offset++;
                    }

                    // Remarks are free text. Never force a numeric 0 into
                    // the Remarks column; preserve real strings exactly.
                    $remarks = $record->remarks ?? '';
                    if ($remarks === null || $remarks === 0 || $remarks === '0') {
                        $remarks = '';
                    }
                    $remarks = (string) $remarks;

                    $sheet->setCellValueExplicit(
                        $this->columnLetter($column + $offset) . $row,
                        $remarks,
                        \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
                    );

                    $column += $product['cases'] ? 6 : 5;
                }

                /*
                 * FINAL PASS:
                 * Write the facility name again AFTER all product cells.
                 * This guarantees that B can never be overwritten by product data.
                 */
                $finalFacilityName = trim((string) ($templateFacilityNames[$facilityIdKey] ?? ''));

                if ($finalFacilityName === '' || $finalFacilityName === '0') {
                    $finalFacilityName = trim((string) ($facility->name ?? ''));
                }

                if ($finalFacilityName === '0') {
                    $finalFacilityName = '';
                }

                $sheet->setCellValue('B' . $row, $finalFacilityName);

                /*
                 * FINAL REMARKS PASS:
                 * Re-write every Remarks cell as text after all numeric cells.
                 */
                $remarkColumn = 3;

                foreach ($this->products() as $remarkProduct) {
                    $remarkRecord =
                        $qriff[$facility->id][$remarkProduct['id']]
                        ?? null;

                    $remarkValue = $remarkRecord->remarks ?? '';

                    if ($remarkValue === null || $remarkValue === 0 || $remarkValue === '0') {
                        $remarkValue = '';
                    }

                    $remarkColumnOffset = $remarkProduct['cases'] ? 5 : 4;

                    $sheet->setCellValue(
                        $this->columnLetter($remarkColumn + $remarkColumnOffset) . $row,
                        (string) $remarkValue
                    );

                    $remarkColumn += $remarkProduct['cases'] ? 6 : 5;
                }

                $row++;
                $serial++;
            }

            $sheet->freezePane('C4');
            $generatedSheets[] = ['sheet' => $sheet, 'name' => $lga];
        }

        // Remove every original template sheet. Only generated LGA sheets remain.
        foreach ($templateSheets as $originalSheet) {
            $index = $spreadsheet->getIndex($originalSheet);
            $spreadsheet->removeSheetByIndex($index);
        }

        // Now the original names are gone, so assign the real LGA names.
        $usedNames = [];
        foreach ($generatedSheets as $item) {
            $sheet = $item['sheet'];
            $baseName = Str::limit($this->cleanSheetName($item['name']), 31, '');
            if ($baseName === '') $baseName = 'LGA';
            $sheetName = $baseName;
            $suffix = 2;
            while (isset($usedNames[strtolower($sheetName)])) {
                $suffixText = '_' . $suffix++;
                $sheetName = Str::limit($baseName, 31 - strlen($suffixText), '') . $suffixText;
            }
            $usedNames[strtolower($sheetName)] = true;
            $sheet->setTitle($sheetName);
        }

        if ($spreadsheet->getSheetCount() === 0) {
            return back()->with('error', 'No QRIFF worksheets could be created.');
        }

        $spreadsheet->setActiveSheetIndex(0);

        $filename =
            strtolower(str_replace(' ', '_', $state))
            . '_'
            . strtolower($quarter)
            . '_QRIFF_data.xlsx';

        $writer = new Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);

        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $filename,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
        );
    }

 

    // public function download(Request $request)
    // {
    //     @ini_set('max_execution_time', '0');
    //     @set_time_limit(0);
    //     @ini_set('max_execution_time', '0');
    //     @set_time_limit(0);

    //     $request->validate([
    //         'state' => ['required', 'string'],
    //         'quarter' => ['required', 'string'],
    //     ]);

    //     $state = trim($request->state);
    //     $quarter = trim($request->quarter);

    //     // Give large Excel exports enough time.
    //     @ini_set('max_execution_time', '0');
    //     @set_time_limit(0);

    //     $facilities = DB::table('facilities_info')
    //         ->whereRaw('LOWER(TRIM(state)) = LOWER(?)', [$state])
    //         ->whereNotNull('id')
    //         ->whereNotNull('lga')
    //         ->whereRaw("TRIM(lga) <> ''")
    //         ->orderBy('lga')
    //         ->orderBy('name')
    //         ->get();

    //     if ($facilities->isEmpty()) {
    //         return back()->with('error', 'No facilities were found for ' . $state);
    //     }

    //     $facilityIds = $facilities->pluck('id')->filter()->values()->toArray();

    //     $qriffRecords = DB::table('qriff')
    //         ->where('quarter', $quarter)
    //         ->whereIn('facility_id', $facilityIds)
    //         ->get();

    //     $qriff = [];
    //     foreach ($qriffRecords as $record) {
    //         $qriff[$record->facility_id][$record->product_id] = $record;
    //     }

    //     /*
    //      * IMPORTANT:
    //      * Use the supplied ORIGINAL QRIFF workbook as the formatting master.
    //      * Do not use a previously generated/downloaded workbook as the template.
    //      *
    //      * For Enugu, storage/app/qriff_templates/enugu.xlsx must be the clean
    //      * Q1_25/Q1_26-style template with the correct Facility Name column.
    //      */
    //     $templatePath = $this->qriffTemplatePath($state);

    //     if (!$templatePath || !is_file($templatePath)) {
    //         return back()->with(
    //             'error',
    //             'QRIFF template not found. Put the supplied templates in storage/app/qriff_templates/.'
    //         );
    //     }

    //     try {
    //         $spreadsheet = IOFactory::load($templatePath);
    //     } catch (\Throwable $e) {
    //         return back()->with(
    //             'error',
    //             'The QRIFF template could not be opened: ' . $e->getMessage()
    //         );
    //     }

    //     if ($spreadsheet->getSheetCount() === 0) {
    //         return back()->with('error', 'The QRIFF template contains no worksheets.');
    //     }

    //     /*
    //      * Keep ONLY the first clean template sheet.
    //      *
    //      * This prevents existing template tabs (ado-ekiti, ANINRI, etc.)
    //      * from colliding with the new DB-generated tabs and prevents _2 names.
    //      */
    //     $templateSheets = $spreadsheet->getAllSheets();
    //     $styleSource = $templateSheets[0];
    //     $templateByLga = [];
    //     $templateMaxRows = [];
    //     $templateFacilityNames = [];
    //     foreach ($templateSheets as $templateSheet) {
    //         $templateByLga[$this->normalizeLgaName($templateSheet->getTitle())] = $templateSheet;
    //         $templateMaxRows[spl_object_hash($templateSheet)] = $templateSheet->getHighestRow();

    //         // The supplied workbook already contains the authoritative facility
    //         // names and hidden facility UUIDs. Keep that mapping as a fallback
    //         // in case an imported facilities_info.name is blank/0.
    //         $maxTemplateRow = $templateSheet->getHighestRow();
    //         for ($tr = 4; $tr <= $maxTemplateRow; $tr++) {
    //             $templateFacilityId = trim((string) $templateSheet->getCell('GC' . $tr)->getValue());
    //             $templateFacilityName = trim((string) $templateSheet->getCell('B' . $tr)->getValue());
    //             if ($templateFacilityId !== '' && $templateFacilityName !== '') {
    //                 $templateFacilityNames[$templateFacilityId] = $templateFacilityName;
    //             }
    //         }
    //     }
    //     $fallbackTemplate = $styleSource;

    //     $groups = $facilities->groupBy(function ($facility) {
    //         return trim((string) $facility->lga);
    //     });

    //     $generatedSheets = [];
    //     $temporaryCounter = 1;

    //     foreach ($groups as $lga => $lgaFacilities) {
    //         $baseName = Str::limit($this->cleanSheetName($lga), 31, '');

    //         if ($baseName === '') {
    //             $baseName = 'LGA';
    //         }

    //         $sourceSheet = $templateByLga[$this->normalizeLgaName($lga)] ?? $fallbackTemplate;
    //         $sourceTitle = $sourceSheet->getTitle();

    //         $sheet = $spreadsheet->duplicateWorksheetByTitle($sourceTitle);
    //         // Original template sheets still exist, so use a temporary unique title.
    //         $sheet->setTitle('__QRIFF_NEW_' . $temporaryCounter++);

    //         $targetLastRow = 3 + $lgaFacilities->count();
    //         $templateMaxRow = $templateMaxRows[spl_object_hash($sourceSheet)] ?? 4;

    //         /*
    //          * Extend the supplied row style when an LGA has more facilities
    //          * than the template contains.
    //          */
    //         if ($targetLastRow > $templateMaxRow) {
    //             $styleRow4 = $styleSource->getStyle('A4:GC4');
    //             $styleRow5 = $templateMaxRow >= 5
    //                 ? $styleSource->getStyle('A5:GC5')
    //                 : $styleRow4;

    //             for ($r = $templateMaxRow + 1; $r <= $targetLastRow; $r++) {
    //                 $sourceStyle = (($r - 4) % 2 === 0)
    //                     ? $styleRow4
    //                     : $styleRow5;

    //                 $sheet->duplicateStyle(
    //                     $sourceStyle,
    //                     'A' . $r . ':GC' . $r
    //                 );
    //             }
    //         }

    //         /*
    //          * Title.
    //          */
    //         $sheet->setCellValue(
    //             'A1',
    //             'QRIFF Data for ' . $state . ' - ' . $lga . ' - QUARTER: ' . $quarter
    //         );

    //         // Keep rows 2-3 exactly as supplied by the original template.

    //         $sheet->setCellValue('GC2', 'Facility ID');
    //         $sheet->setCellValue('GC3', 'Hidden ID');
    //         $sheet->getColumnDimension('GC')->setVisible(false);

    //         /*
    //          * Write every facility row. B contains the actual facility name;
    //          * GC contains the UUID used by upload.
    //          */
    //         $row = 4;
    //         $serial = 1;

    //         foreach ($lgaFacilities as $facility) {
    //             $sheet->setCellValue('A' . $row, $serial);

    //             // IMPORTANT: Facility Name must come from the original QRIFF
    //             // template mapping (UUID -> name) whenever possible. Do NOT let
    //             // a numeric value from facilities_info overwrite column B.
    //             $facilityIdKey = trim((string) $facility->id);
    //             $templateName = trim((string) ($templateFacilityNames[$facilityIdKey] ?? ''));
    //             $dbName = trim((string) ($facility->name ?? ''));

    //             if ($templateName !== '' && $templateName !== '0') {
    //                 $facilityName = $templateName;
    //             } elseif ($dbName !== '' && $dbName !== '0') {
    //                 $facilityName = $dbName;
    //             } else {
    //                 $facilityName = '';
    //             }

    //             $sheet->setCellValueExplicit(
    //                 'B' . $row,
    //                 $facilityName,
    //                 \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
    //             );

    //             $sheet->setCellValueExplicit(
    //                 'GC' . $row,
    //                 (string) $facility->id,
    //                 \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
    //             );

    //             $column = 3;

                

    //             foreach ($this->products() as $product) {
    //                 $record = $qriff[$facility->id][$product['id']] ?? null;

    //                 $sheet->setCellValue(
    //                     $this->columnLetter($column) . $row,
    //                     $record->opening ?? 0
    //                 );

    //                 $sheet->setCellValue(
    //                     $this->columnLetter($column + 1) . $row,
    //                     $record->received ?? 0
    //                 );

    //                 $sheet->setCellValue(
    //                     $this->columnLetter($column + 2) . $row,
    //                     $record->issued ?? 0
    //                 );

    //                 $sheet->setCellValue(
    //                     $this->columnLetter($column + 3) . $row,
    //                     $record->physical ?? 0
    //                 );

    //                 $offset = 4;

    //                 if ($product['cases']) {
    //                     $sheet->setCellValue(
    //                         $this->columnLetter($column + $offset) . $row,
    //                         $record->cases ?? 0
    //                     );
    //                     $offset++;
    //                 }

    //                 // Remarks are free text. Never force a numeric 0 into
    //                 // the Remarks column; preserve real strings exactly.
    //                 $remarks = $record->remarks ?? '';
    //                 if ($remarks === null || $remarks === 0 || $remarks === '0') {
    //                     $remarks = '';
    //                 }
    //                 $remarks = (string) $remarks;

    //                 $sheet->setCellValueExplicit(
    //                     $this->columnLetter($column + $offset) . $row,
    //                     $remarks,
    //                     \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
    //                 );

    //                 $column += $product['cases'] ? 6 : 5;
    //             }

    //             /*
    //              * FINAL PASS:
    //              * Write the facility name again AFTER all product cells.
    //              * This guarantees that B can never be overwritten by product data.
    //              */
    //             $finalFacilityName = trim((string) ($templateFacilityNames[$facilityIdKey] ?? ''));

    //             if ($finalFacilityName === '' || $finalFacilityName === '0') {
    //                 $finalFacilityName = trim((string) ($facility->name ?? ''));
    //             }

    //             if ($finalFacilityName === '0') {
    //                 $finalFacilityName = '';
    //             }

    //             $sheet->setCellValue('B' . $row, $finalFacilityName);

    //             /*
    //              * FINAL REMARKS PASS:
    //              * Re-write every Remarks cell as text after all numeric cells.
    //              */
    //             $remarkColumn = 3;

    //             foreach ($this->products() as $remarkProduct) {
    //                 $remarkRecord =
    //                     $qriff[$facility->id][$remarkProduct['id']]
    //                     ?? null;

    //                 $remarkValue = $remarkRecord->remarks ?? '';

    //                 if ($remarkValue === null || $remarkValue === 0 || $remarkValue === '0') {
    //                     $remarkValue = '';
    //                 }

    //                 $remarkColumnOffset = $remarkProduct['cases'] ? 5 : 4;

    //                 $sheet->setCellValue(
    //                     $this->columnLetter($remarkColumn + $remarkColumnOffset) . $row,
    //                     (string) $remarkValue
    //                 );

    //                 $remarkColumn += $remarkProduct['cases'] ? 6 : 5;
    //             }

    //             $row++;
    //             $serial++;
    //         }

    //         $sheet->freezePane('C4');
    //         $generatedSheets[] = ['sheet' => $sheet, 'name' => $lga];
    //     }

    //     // Remove every original template sheet. Only generated LGA sheets remain.
    //     foreach ($templateSheets as $originalSheet) {
    //         $index = $spreadsheet->getIndex($originalSheet);
    //         $spreadsheet->removeSheetByIndex($index);
    //     }

    //     // Now the original names are gone, so assign the real LGA names.
    //     $usedNames = [];
    //     foreach ($generatedSheets as $item) {
    //         $sheet = $item['sheet'];
    //         $baseName = Str::limit($this->cleanSheetName($item['name']), 31, '');
    //         if ($baseName === '') $baseName = 'LGA';
    //         $sheetName = $baseName;
    //         $suffix = 2;
    //         while (isset($usedNames[strtolower($sheetName)])) {
    //             $suffixText = '_' . $suffix++;
    //             $sheetName = Str::limit($baseName, 31 - strlen($suffixText), '') . $suffixText;
    //         }
    //         $usedNames[strtolower($sheetName)] = true;
    //         $sheet->setTitle($sheetName);
    //     }

    //     if ($spreadsheet->getSheetCount() === 0) {
    //         return back()->with('error', 'No QRIFF worksheets could be created.');
    //     }

    //     $spreadsheet->setActiveSheetIndex(0);

    //     $filename =
    //         strtolower(str_replace(' ', '_', $state))
    //         . '_'
    //         . strtolower($quarter)
    //         . '_QRIFF_data.xlsx';

    //     $writer = new Xlsx($spreadsheet);
    //     $writer->setPreCalculateFormulas(false);

    //     return response()->streamDownload(
    //         function () use ($writer) {
    //             $writer->save('php://output');
    //         },
    //         $filename,
    //         [
    //             'Content-Type' =>
    //                 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         ]
    //     );
    // }

    public function upload(Request $request)
    {
        @ini_set('max_execution_time', '0');
        @set_time_limit(0);
        /*
         * Large QRIFF workbooks can contain 300+ facilities x 35 products.
         * Do not let PHP stop this controller at the default 60 seconds.
         */
        @ini_set('max_execution_time', '0');
        @set_time_limit(0);

        $request->validate([
            'state' => ['required', 'string'],
            'quarter' => ['required', 'string'],
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls',
                'max:20480',
            ],
        ]);

        $state = trim($request->state);
        $quarter = trim($request->quarter);

        try {
            $spreadsheet = IOFactory::load(
                $request->file('file')->getRealPath()
            );
        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'The Excel file could not be read: ' . $e->getMessage()
            );
        }

        $facilitiesProcessed = 0;
        $recordsCreated = 0;
        $recordsUpdated = 0;
        $rowsSkipped = 0;
        $errors = [];

        /*
         * Load facilities once.
         */
        $facilities = DB::table('facilities_info')
            ->whereRaw('LOWER(TRIM(state)) = LOWER(?)', [$state])
            ->whereNotNull('id')
            ->whereNotNull('lga')
            ->whereRaw("TRIM(lga) <> ''")
            ->get()
            ->keyBy('id');

        /*
         * Load the selected quarter's QRIFF rows once.
         *
         * The previous version did a SELECT for every facility/product pair,
         * which can mean 11,235+ queries for Enugu alone.
         */
        $existingRecords = DB::table('qriff')
            ->where('quarter', $quarter)
            ->whereIn('facility_id', $facilities->keys()->all())
            ->get();

        $existing = [];

        foreach ($existingRecords as $record) {
            $existing[$record->facility_id][$record->product_id] = $record;
        }

        /*
         * Prevent the same facility from being processed twice if a workbook
         * contains duplicate tabs/rows.
         */
        $processedFacilityIds = [];

        foreach ($spreadsheet->getWorksheetIterator() as $sheet) {
            $sheetName = $sheet->getTitle();
            $highestRow = $sheet->getHighestRow();

            if ($highestRow < 4) {
                continue;
            }

            for ($row = 4; $row <= $highestRow; $row++) {
                $facilityId = trim(
                    (string) $sheet->getCell('GC' . $row)->getValue()
                );

                if ($facilityId === '') {
                    continue;
                }

                if (isset($processedFacilityIds[$facilityId])) {
                    continue;
                }

                if (!isset($facilities[$facilityId])) {
                    $rowsSkipped++;
                    $errors[] =
                        $sheetName . ' row ' . $row .
                        ': facility ID not found in selected state.';
                    continue;
                }

                $facility = $facilities[$facilityId];
                $incoming = [];

                $column = 3;

                foreach ($this->products() as $product) {
                    try {
                        $opening = $this->numberOrNull(
                            $sheet->getCell(
                                $this->columnLetter($column) . $row
                            )->getValue()
                        );

                        $received = $this->numberOrNull(
                            $sheet->getCell(
                                $this->columnLetter($column + 1) . $row
                            )->getValue()
                        );

                        $issued = $this->numberOrNull(
                            $sheet->getCell(
                                $this->columnLetter($column + 2) . $row
                            )->getValue()
                        );

                        $physical = $this->numberOrNull(
                            $sheet->getCell(
                                $this->columnLetter($column + 3) . $row
                            )->getValue()
                        );

                        $offset = 4;
                        $cases = 0;

                        if ($product['cases']) {
                            $cases = $this->numberOrNull(
                                $sheet->getCell(
                                    $this->columnLetter($column + 4) . $row
                                )->getValue()
                            );
                            $cases = $cases ?? 0;
                            $offset++;
                        }

                        $remarks = $sheet->getCell(
                            $this->columnLetter($column + $offset) . $row
                        )->getValue();

                        // Remarks are text, not numeric inventory fields.
                        if ($remarks === null || $remarks === 0 || $remarks === '0') {
                            $remarks = '';
                        } else {
                            $remarks = trim((string) $remarks);
                        }

                        $incoming[$product['id']] = [
                            'facility_id' => $facilityId,
                            'product_id' => $product['id'],
                            'quarter' => $quarter,
                            'opening' => $opening ?? 0,
                            'received' => $received ?? 0,
                            'issued' => $issued ?? 0,
                            'physical' => $physical ?? 0,
                            'cases' => $cases,
                            'remarks' => $remarks,
                        ];
                    } catch (\Throwable $e) {
                        $errors[] =
                            $sheetName . ' row ' . $row .
                            ' product ' . $product['name'] .
                            ': ' . $e->getMessage();
                    }

                    $column += $product['cases'] ? 6 : 5;
                }

                /*
                 * Insert all missing products for this facility in one batch.
                 */
                $toInsert = [];
                $toUpdate = [];

                foreach ($incoming as $productId => $data) {
                    $old = $existing[$facilityId][$productId] ?? null;

                    if (!$old) {
                        $data['id'] = (string) Str::uuid();
                        $toInsert[] = $data;
                        continue;
                    }

                    $changed =
                        $old->opening != $data['opening'] ||
                        $old->received != $data['received'] ||
                        $old->issued != $data['issued'] ||
                        $old->physical != $data['physical'] ||
                        $old->cases != $data['cases'] ||
                        $old->remarks != $data['remarks'];

                    if ($changed) {
                        $toUpdate[$productId] = [
                            'id' => $old->id,
                            'opening' => $data['opening'],
                            'received' => $data['received'],
                            'issued' => $data['issued'],
                            'physical' => $data['physical'],
                            'cases' => $data['cases'],
                            'remarks' => $data['remarks'],
                        ];
                    }
                }

                /*
                 * One INSERT statement for all missing products of this
                 * facility, rather than 35 INSERT statements.
                 */
                if (!empty($toInsert)) {
                    foreach (array_chunk($toInsert, 500) as $chunk) {
                        DB::table('qriff')->insert($chunk);
                        $recordsCreated += count($chunk);
                    }
                }

                /*
                 * Update changed rows. This is at most 35 UPDATE statements
                 * for a facility, but only changed rows are touched.
                 *
                 * No qriff_history insert is performed here; that audit table
                 * was not part of the confirmed current schema.
                 */
                foreach ($toUpdate as $update) {
                    DB::table('qriff')
                        ->where('id', $update['id'])
                        ->update([
                            'opening' => $update['opening'],
                            'received' => $update['received'],
                            'issued' => $update['issued'],
                            'physical' => $update['physical'],
                            'cases' => $update['cases'],
                            'remarks' => $update['remarks'],
                        ]);

                    $recordsUpdated++;
                }

                $processedFacilityIds[$facilityId] = true;
                $facilitiesProcessed++;
            }
        }

        $message =
            'Upload completed.<br>' .
            'Facilities processed: ' . $facilitiesProcessed . '<br>' .
            'Records created: ' . $recordsCreated . '<br>' .
            'Records updated: ' . $recordsUpdated . '<br>' .
            'Rows skipped: ' . $rowsSkipped;

        if (!empty($errors)) {
            $message .=
                '<br><br><strong>Errors:</strong><br>' .
                implode('<br>', array_slice($errors, 0, 20));
        }

        return back()->with('success', $message);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /*
    |-------------------------------------------------------------------------- 
    | QRIFF TEMPLATE HELPERS
    |-------------------------------------------------------------------------- 
    */

    private function qriffTemplatePath(string $state): ?string
    {
        $key = strtolower(
            preg_replace('/[^a-z]/', '', $state)
        );

        $templates = [
            'enugu' =>
                storage_path(
                    'app/qriff_templates/enugu.xlsx'
                ),

            'osun' =>
                storage_path(
                    'app/qriff_templates/osun.xlsx'
                ),

            'crossriver' =>
                storage_path(
                    'app/qriff_templates/crossriver.xlsx'
                ),
        ];

        /*
         * For states without a supplied template, use Enugu as the
         * structural fallback. The sheet data is still replaced with
         * the selected state's facilities.
         */
        return $templates[$key]
            ?? $templates['enugu']
            ?? null;
    }


    private function normalizeLgaName(string $name): string
    {
        return strtolower(
            preg_replace(
                '/[^a-z0-9]/',
                '',
                trim($name)
            )
        );
    }


    private function columnLetter($column)
{
    $column = (int) $column;

    $letter = '';

    while ($column > 0) {
        $remainder = ($column - 1) % 26;
        $letter = chr(65 + $remainder) . $letter;
        $column = (int) floor(($column - 1) / 26);
    }

    return $letter;
}


    private function columnLetter1(int $column): string
    {
        $letter = '';

        while ($column > 0) {

            $modulo = ($column - 1) % 26;

            $letter =
                chr(65 + $modulo) .
                $letter;

            $column =
                intdiv($column - $modulo, 26) - 1;
        }

        return $letter;
    }


    private function numberOrNull($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        return null;
    }


    private function cleanSheetName(string $name): string
    {
        return preg_replace(
            '/[\\\\\/\?\*\[\]\:]/',
            '',
            $name
        );
    }
}
