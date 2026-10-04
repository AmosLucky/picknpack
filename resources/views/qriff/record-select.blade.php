<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Select QRIFF Data</title>

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

        .overlay {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .modal {
            width: 100%;
            max-width: 515px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 15px 50px rgba(0,0,0,.18);
            padding: 28px 36px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 20px;
        }

        .close {
            border: none;
            background: transparent;
            font-size: 22px;
            cursor: pointer;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        select {
            width: 100%;
            height: 42px;
            border: 1px solid #d5dbe5;
            border-radius: 7px;
            padding: 0 12px;
            margin-bottom: 18px;
            background: white;
            font-size: 14px;
        }

        .buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        button {
            border: none;
            border-radius: 7px;
            padding: 11px 20px;
            cursor: pointer;
            font-weight: 600;
        }

        .cancel {
            background: #e52b2b;
            color: white;
        }

        .record {
            background: #111a2e;
            color: white;
        }

        .error {
            color: #d22;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 12px;
        }
    </style>
</head>

<body>

<div class="overlay">

    <div class="modal">

        <div class="modal-header">

            <h2>Select Data to Record</h2>

            <button
                type="button"
                class="close"
                onclick="history.back()"
            >
                ×
            </button>

        </div>

        <form
            method="GET"
            action="{{ route('qriff.record') }}"
        >

            {{-- State --}}
            <label>State</label>

            <select
                name="state"
                id="state"
                required
                onchange="this.form.submit()"
            >
                <option value="">
                    Select State
                </option>

                @foreach($states as $item)
                    <option
                        value="{{ $item }}"
                        @selected(
                            strtolower($state) === strtolower($item)
                        )
                    >
                        {{ ucwords($item) }}
                    </option>
                @endforeach
            </select>


            {{-- Quarter --}}
            <label>Quarter</label>

            <select
                name="quarter"
                required
            >
                <option value="">
                    Select Quarter
                </option>

                @foreach($quarters as $item)
                    <option
                        value="{{ $item }}"
                        @selected($quarter === $item)
                    >
                        {{ strtolower($item) }}
                    </option>
                @endforeach
            </select>


            {{-- Data type --}}
            <label>Data Type</label>

            <select name="data_type">

                <option value="qriff">
                    QRIFF Data
                </option>

            </select>


            {{-- LGA --}}
            <label>
                Please select one LGA from the options below:
            </label>

            <select
                name="lga"
                required
            >

                <option value="">
                    Select LGA
                </option>

                @foreach($lgas as $item)

                    <option
                        value="{{ $item }}"
                        @selected(
                            strtolower($lga) === strtolower($item)
                        )
                    >
                        {{ $item }}
                    </option>

                @endforeach

            </select>


            {{-- Product --}}
            <label>
                Please select one product from the options below:
            </label>

            <select
                name="product_id"
                required
            >

                <option value="">
                    Select Product
                </option>

                @foreach($products as $product)

                    <option
                        value="{{ $product['id'] }}"
                        @selected(
                            $productId === $product['id']
                        )
                    >
                        {{ $product['name'] }}
                    </option>

                @endforeach

            </select>


            @if ($errors->any())

                <div class="error">

                    {{ $errors->first() }}

                </div>

            @endif


            <div class="buttons">

                <button
                    type="button"
                    class="cancel"
                    onclick="history.back()"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="record"
                >
                    RECORD
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>