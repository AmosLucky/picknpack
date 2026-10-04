<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $product['name'] }} QRIFF Data
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #172033;
        }

        .topbar {
            height: 74px;
            background: white;
            border-bottom: 1px solid #dce2ea;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 18px;
        }

        .topbar h1 {
            font-size: 18px;
            margin: 0;
            font-weight: 700;
        }

        .top-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 17px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: white;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-dark {
            background: #111a2e;
            color: white;
            border-color: #111a2e;
        }

        .container {
            padding: 18px;
        }

        .card {
            background: white;
            border: 1px solid #dce2ea;
            border-radius: 9px;
            padding: 16px;
            overflow-x: auto;
        }

        .tools {
            display: flex;
            gap: 14px;
            align-items: center;
            margin-bottom: 12px;
        }

        .pin {
            border: 1px solid #d6dde7;
            background: white;
            border-radius: 6px;
            padding: 8px 16px;
            cursor: pointer;
            font-weight: 600;
        }

        .toggle {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 14px;
        }

        .toggle input {
            width: 18px;
            height: 18px;
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid #dce2ea;
            border-radius: 8px;
        }

        table {
            width: 100%;
            min-width: 1150px;
            border-collapse: collapse;
        }

        th {
            background: #f1f5f5;
            text-align: left;
            padding: 12px 14px;
            border-bottom: 1px solid #ccd4dd;
            font-size: 14px;
            white-space: nowrap;
        }

        td {
            padding: 9px 14px;
            border-bottom: 1px solid #e2e6eb;
            font-size: 14px;
            white-space: nowrap;
        }

        td input {
            width: 100px;
            height: 36px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            padding: 7px;
            font-size: 14px;
        }

        td input:focus {
            outline: 2px solid #c9d7ea;
            border-color: #7187a5;
        }

        td input.remarks {
            width: 180px;
        }

        .calculated {
            background: #f8fafc;
            font-weight: 600;
        }

        .success {
            background: #e8f7ee;
            border: 1px solid #a9dfbc;
            color: #176b35;
            padding: 12px 15px;
            border-radius: 7px;
            margin-bottom: 15px;
        }

        .error {
            background: #fff0f0;
            border: 1px solid #efb0b0;
            color: #9d2222;
            padding: 12px 15px;
            border-radius: 7px;
            margin-bottom: 15px;
        }

    </style>

</head>

<body>

<div class="topbar">

    <div class="top-buttons">

        <button
            class="btn"
            onclick="history.back()"
        >
            Back
        </button>

        <button
            class="btn"
            onclick="window.location.href='{{ url('/') }}'"
        >
            Home
        </button>

    </div>


    <h1>
        {{ $product['name'] }}
        QRIFF Data for
        {{ strtolower($quarter) }}
    </h1>


    <div class="top-buttons">

        <button
            class="btn"
            type="button"
            onclick="toggleFilters()"
        >
            Filter Table
        </button>

        <button
            class="btn btn-dark"
            type="submit"
            form="qriffForm"
        >
            Save QRIFF
        </button>

    </div>

</div>


<div class="container">

    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="error">
            {{ session('error') }}
        </div>

    @endif


    @if($errors->any())

        <div class="error">

            {{ $errors->first() }}

        </div>

    @endif


    <div class="card">

        <div class="tools">

            <button
                type="button"
                class="pin"
                onclick="toggleNames()"
            >
                Pin Facility Name
            </button>

            <label class="toggle">

                <input
                    type="checkbox"
                    id="hideLga"
                    onchange="toggleLga()"
                >

                Hide LGA

            </label>


            <label class="toggle">

                <input
                    type="checkbox"
                    id="hideSn"
                    onchange="toggleSn()"
                >

                Hide s/n

            </label>

        </div>


        <form
            method="POST"
            action="{{ route('qriff.record.store') }}"
            id="qriffForm"
        >

            @csrf

            <input
                type="hidden"
                name="state"
                value="{{ $state }}"
            >

            <input
                type="hidden"
                name="quarter"
                value="{{ $quarter }}"
            >

            <input
                type="hidden"
                name="lga"
                value="{{ $lga }}"
            >

            <input
                type="hidden"
                name="product_id"
                value="{{ $product['id'] }}"
            >


            <div class="table-wrap">

                <table id="qriffTable">

                    <thead>

                        <tr>

                            <th class="sn-column">
                                s/n
                            </th>

                            <th class="name-column">
                                Name
                            </th>

                            <th class="lga-column">
                                LGA
                            </th>

                            <th>
                                Opening<br>Balance
                            </th>

                            <th>
                                Quantity<br>Received
                            </th>

                            <th>
                                Quantity<br>Issued
                            </th>

                            <th>
                                Physical<br>Balance
                            </th>

                            <th>
                                Closing<br>Stock
                            </th>

                            <th>
                                Losses/Adj
                            </th>

                            <th>
                                cases
                            </th>

                            <th>
                                Remarks
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($rows as $index => $row)

                            <tr>

                                <td class="sn-column">
                                    {{ $index + 1 }}
                                </td>


                                <td class="name-column">
                                    {{ $row['facility_name'] }}
                                </td>


                                <td class="lga-column">
                                    {{ $row['lga'] }}
                                </td>


                                <td>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="rows[{{ $index }}][opening]"
                                        value="{{ $row['opening'] }}"
                                        class="opening"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="rows[{{ $index }}][received]"
                                        value="{{ $row['received'] }}"
                                        class="received"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="rows[{{ $index }}][issued]"
                                        value="{{ $row['issued'] }}"
                                        class="issued"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="rows[{{ $index }}][physical]"
                                        value="{{ $row['physical'] }}"
                                        class="physical"
                                    >

                                </td>


                                <td class="calculated closing">
                                    0
                                </td>


                                <td class="calculated loss">
                                    0
                                </td>


                                <td>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="rows[{{ $index }}][cases]"
                                        value="{{ $row['cases'] }}"
                                    >

                                </td>


                                <td>

                                    <input
                                        type="text"
                                        class="remarks"
                                        name="rows[{{ $index }}][remarks]"
                                        value="{{ $row['remarks'] }}"
                                    >

                                </td>


                                <input
                                    type="hidden"
                                    name="rows[{{ $index }}][facility_id]"
                                    value="{{ $row['facility_id'] }}"
                                >

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </form>

    </div>

</div>


<script>

function calculateRow(row)
{
    const opening =
        parseFloat(
            row.querySelector('.opening')?.value
        ) || 0;

    const received =
        parseFloat(
            row.querySelector('.received')?.value
        ) || 0;

    const issued =
        parseFloat(
            row.querySelector('.issued')?.value
        ) || 0;

    const physical =
        parseFloat(
            row.querySelector('.physical')?.value
        ) || 0;


    /*
     * Closing stock:
     *
     * Opening + Received - Issued
     */
    const closing =
        opening +
        received -
        issued;


    /*
     * Difference between expected closing
     * and physical balance.
     */
    const loss =
        closing -
        physical;


    row.querySelector('.closing').textContent =
        closing.toLocaleString();


    row.querySelector('.loss').textContent =
        loss.toLocaleString();
}


function calculateAll()
{
    document
        .querySelectorAll('#qriffTable tbody tr')
        .forEach(row => {

            calculateRow(row);

        });
}


document
    .querySelectorAll(
        '.opening, .received, .issued, .physical'
    )
    .forEach(input => {

        input.addEventListener(
            'input',
            function () {

                calculateRow(
                    this.closest('tr')
                );

            }
        );

    });


function toggleLga()
{
    const checked =
        document.getElementById('hideLga').checked;

    document
        .querySelectorAll('.lga-column')
        .forEach(cell => {

            cell.style.display =
                checked ? 'none' : '';

        });
}


function toggleSn()
{
    const checked =
        document.getElementById('hideSn').checked;

    document
        .querySelectorAll('.sn-column')
        .forEach(cell => {

            cell.style.display =
                checked ? 'none' : '';

        });
}


function toggleNames()
{
    const table =
        document.getElementById('qriffTable');

    if (table) {

        table.querySelector(
            '.name-column'
        )?.scrollIntoView({
            behavior: 'smooth',
            inline: 'start'
        });

    }
}


function toggleFilters()
{
    alert(
        'Filter controls can be added here.'
    );
}


calculateAll();

</script>

</body>

</html>