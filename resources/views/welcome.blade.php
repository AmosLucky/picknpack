<div class="container mt-5">

    <h2 class="mb-4">Inventory</h2>

    <table class="table table-bordered table-striped table-hover">

        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Inventory ID</th>
            <th>Product ID</th>
            <th>Batch ID</th>
            <th class="text-end">Quantity</th>
            <th>Last Updated</th>
        </tr>
        </thead>

        <tbody>

        @foreach($inventory as $item)

            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->inventory_id }}</td>
                <td>{{ $item->product_id }}</td>
                <td>{{ $item->batch_id }}</td>
                <td class="text-end">{{ number_format($item->current_quantity, 2) }}</td>
                <td>{{ $item->last_updated }}</td>
            </tr>

        @endforeach

        </tbody>

    </table>

</div>