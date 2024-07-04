<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reference No# {{ $stock -> invoice_no }}</title>
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
                <h1 style="margin: 0">Adjustment Increase Invoice</h1>
                <hr>
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Reference No:</strong>
                {{ $stock -> invoice_no }}
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Stock Date:</strong>
                {{ $stock -> stock_date }}
            </td>
        </tr>
        </tbody>
    </table>
</header>

<table width="100%" border="1">
    <thead>
    <tr>
        <th align="center">Sr.No</th>
        <th align="left">Product</th>
        <th align="center">Quantity</th>
        <th align="center">Cost/Unit</th>
        <th align="center">Sale/Unit</th>
        <th align="center">Price</th>
        <th align="center">Discount</th>
        <th align="center">S.Tax</th>
        <th align="center">Total</th>
    </tr>
    </thead>
    <tbody>
    @php
        $price = 0;
        $net = 0;
        $totalQty = 0;
    @endphp
    @if(count ($stock -> products) > 0)
        @foreach($stock -> products as $product)
            @php
                $price = $price + $product -> stock_price;
                $net = $net + $product -> net_price;
                $totalQty = $totalQty + $product -> quantity;
            @endphp
            <tr>
                <td align="center" width="2%">{{ $loop -> iteration }}</td>
                <td align="left">{{ $product -> product -> productTitle() }}</td>
                <td align="center">{{ $product -> quantity }}</td>
                <td align="center">{{ number_format ($product -> tp_unit, 2) }}</td>
                <td align="center">{{ number_format ($product -> sale_unit, 2) }}</td>
                <td align="center">{{ number_format ($product -> stock_price, 2) }}</td>
                <td align="center">{{ number_format ($product -> discount, 2) }}</td>
                <td align="center">{{ number_format ($product -> sale_tax, 2) }}</td>
                <td align="center">{{ number_format ($product -> net_price, 2) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"></td>
        <td align="center">{{ number_format ($totalQty) }}</td>
        <td colspan="2"></td>
        <td align="center">
            <strong>{{ number_format ($price, 2) }}</strong>
        </td>
        <td colspan="2"></td>
        <td align="center">
            <strong>{{ number_format ($net, 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>

@if(!empty(trim ($stock -> description)))
    <table width="100%" border="0">
        <tbody>
        <tr>
            <td>
                <strong><u>Remarks</u></strong>
            </td>
        </tr>
        <tr>
            <td>
                {{ $stock -> description }}
            </td>
        </tr>
        </tbody>
    </table>
@endif

</body>
</html>
