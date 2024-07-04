<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Available Stock Report (Category Wise)</title>
    <style>
        @page {
            size: auto;
        }

        body {
            position: relative;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 10px;
        }

        table th {
            padding: 8px 10px;
            color: #5D6975;
            background: #F5F5F5;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
            font-size: 1.1em;
        }

        table td {
            padding: 8px 10px;
        }

        #header td {
            background: #FFFFFF;
            padding: 0;
        }
    </style>
</head>
<body>

<header>
    {!! $pdf_header !!}
    <table width="100%" id="header">
        <tbody>
        <tr>
            <td align="center" width="100%">
                <h1 style="margin: 0">Available Stock Report (Category Wise)</h1>
                <hr>
            </td>
        </tr>
        </tbody>
    </table>
</header>

<table width="100%" border="1">
    <thead>
    <tr>
        <th align="center">#</th>
        <th align="left">Product</th>
        <th align="left">Barcode</th>
        <th align="left">Available Quantity</th>
    </tr>
    </thead>
    <tbody>
    @php $quantity = 0 @endphp
    @if(count ($products) > 0)
        <tr>
            <td></td>
            <td colspan="3" class="font-medium-5 fw-bolder text-danger">
                <strong>{{ $searchedCategory ?-> title }}</strong>
            </td>
        </tr>
        @foreach($products as $product)
            @php $quantity += $product -> available_quantity() @endphp
            <tr>
                <td>{{ $loop -> iteration }}</td>
                <td>{{ $product -> productTitleWithoutBarcode() }}</td>
                <td>{{ $product -> barcode }}</td>
                <td>{{ $product -> available_quantity() }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" class="text-end">
            Total Available Quantity:
        </td>
        <td>
            <strong>{{ number_format ($quantity) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
