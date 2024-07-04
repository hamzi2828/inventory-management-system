<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>General Sales Report (Products Wise)</title>
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
                <h1 style="margin: 0">General Sales Report (Products Wise)</h1>
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
        <th align="center">Quantity</th>
        <th align="center">Net Price</th>
    </tr>
    </thead>
    <tbody>
    @php
        $totalQty = 0;
        $totalPrice = 0;
    @endphp
    @if(count ($sales) > 0)
        @foreach($sales as $sale)
            @php
                $totalDiscount = 0;
                $sale_ids = explode (',', $sale -> sale_ids);
                $totalQty += $sale -> quantity;
                $net_prices = explode (',', $sale -> net_prices);
                $netPrice = 0;

                if (count ($sale_ids) > 0) {
                    foreach ($sale_ids as $key => $sale_id) {
                        $saleInfo = \App\Models\Sale::where(['id' => $sale_id]) -> withCount('sold_products') -> first();

                        if ($saleInfo -> flat_discount > 0 || $saleInfo -> percentage_discount > 0) {
                            $discountValue = ($saleInfo -> total - $saleInfo -> net);
                            $perProductDiscount = $discountValue / $saleInfo -> sold_products_count;
                            $netPrice += ($net_prices[$key] - $perProductDiscount);
                        }
                        else
                            $netPrice += $net_prices[$key];

                    }
                }
                $totalPrice += $netPrice;
            @endphp
            <tr>
                <td align="center">
                    {{ $loop -> iteration }}
                </td>
                <td align="left">
                    {{ $sale -> product -> productTitle() }}
                </td>
                <td align="center">
                    {{ number_format ($sale -> quantity) }}
                </td>
                <td align="center">
                    {{ number_format ($netPrice, 2) }}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2" align="left"></td>
        <td align="center">
            <strong>{{ number_format ($totalQty) }}</strong>
        </td>
        <td align="center">
            <strong>{{ number_format ($totalPrice, 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
