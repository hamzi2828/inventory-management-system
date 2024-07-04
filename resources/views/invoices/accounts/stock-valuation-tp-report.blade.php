<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock Valuation Report (TP Wise)</title>
    <style>
        @page {
            size   : auto;
            margin : 15px;
        }
        
        body {
            position   : relative;
            margin     : 0 auto;
            color      : #001028;
            background : #FFFFFF;
            font-size  : 10px;
        }
        
        table {
            width           : 100%;
            border-collapse : collapse;
            border-spacing  : 0;
            margin-bottom   : 10px;
        }
        
        table th {
            padding       : 8px 10px;
            color         : #5D6975;
            background    : #F5F5F5;
            border-bottom : 1px solid #C1CED9;
            white-space   : nowrap;
            font-weight   : normal;
            font-size     : 1.1em;
        }
        
        table td {
            padding : 8px 10px;
        }
        
        #header td {
            background : #FFFFFF;
            padding    : 0;
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
                <h1 style="margin: 0">Stock Valuation Report (TP Wise)</h1>
                <hr>
            </td>
        </tr>
        </tbody>
    </table>
</header>

<table width="100%" border="1">
    <thead>
    <tr>
        <th>#</th>
        <th align="left">Product</th>
        <th align="left">Available Quantity</th>
        <th align="left">Stock Value (TP Wise)</th>
    </tr>
    </thead>
    <tbody>
    @php
        $net = 0;
        $totalQty = 0;
    @endphp
    @if(count ($products) > 0)
        @foreach($products as $product)
            @php
                $value = ($product -> stock_value_tp_wise() * $product -> available_quantity());
                $net += $value;
                $availableQty = $product -> available_quantity();
                $totalQty += $availableQty;
            @endphp
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td align="left">{{ $product -> productTitle() }}</td>
                <td align="left">{{ $availableQty }}</td>
                <td align="left">{{ number_format ($value, 2) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"></td>
        <td>
            <strong>{{ number_format ($totalQty) }}</strong>
        </td>
        <td>
            <strong>{{ number_format ($net, 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
