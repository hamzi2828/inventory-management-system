<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Analysis Report (Attributes)</title>
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
                <h1 style="margin: 0">Sales Analysis Report (Attributes)</h1>
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
        <th align="left">Attribute</th>
        <th align="center">Sold Quantity</th>
        <th align="center">Revenue</th>
    </tr>
    </thead>
    <tbody>
    @php
        $quantity = 0;
        $revenue = 0;
    @endphp
    @if(count ($sales) > 0)
        @foreach($sales as $sale)
            @php
                $quantity += $sale -> quantity;
                $revenue += ($sale -> net - $sale -> discount);
            @endphp
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td align="left">{{ $sale -> title }}</td>
                <td align="center">
                    {{ number_format ($sale -> quantity) }}
                </td>
                <td align="center">
                    {{ number_format (($sale -> net - $sale -> discount), 2) }}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"></td>
        <td align="center">
            <strong>{{ number_format ($quantity, 2) }}</strong>
        </td>
        <td align="center">
            <strong>{{ number_format ($revenue, 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
