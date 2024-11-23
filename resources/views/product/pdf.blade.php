<!DOCTYPE html>
<html>

<head>
    <title>Product PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Product List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Unit</th>
                <th>Type</th>
                <th>Information</th>
                <th>Quantity</th>
                <th>Producer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $products)
            <tr>
                <td>{{ $products->id }}</td>
                <td>{{ $products->product_name }}</td>
                <td>{{ $products->unit }}</td>
                <td>{{ $products->type }}</td>
                <td>{{ $products->information }}</td>
                <td>{{ $products->qty }}</td>
                <td>{{ $products->producer }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>