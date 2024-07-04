<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Issuance ID# {{ $issuance -> id }}</title>
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
                <h1 style="margin: 0">Stock Transfer Invoice</h1>
                <hr>
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Transfer From: </strong>
                {{ $issuance -> issuance_from_branch -> name }}
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Transfer To: </strong>
                {{ $issuance -> issuance_to_branch -> name }}
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Transfer Date:</strong>
                {{ $issuance -> created_at }}
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Stock Received:</strong>
                {{ $issuance -> received == '1' ? 'Yes' : 'No' }}
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
        <th align="center">Amount</th>
    </tr>
    </thead>
    <tbody>
        @php $net = 0; @endphp
        @if(count ($issuance -> products) > 0)
            @foreach($issuance -> products as $product)
                @php
                    $tp_unit = $product -> product -> tp_unit;
                    $net = $net + ($tp_unit * $product -> quantity);
                @endphp
                <tr>
                    <td align="center" width="2%">{{ $loop -> iteration }}</td>
                    <td align="left">{{ $product -> product -> productTitle() }}</td>
                    <td align="center">{{ $product -> quantity }}</td>
                    <td align="center">{{ number_format ($tp_unit, 2) }}</td>
                    <td align="center">{{ number_format (($tp_unit * $product -> quantity), 2) }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4"></td>
            <td align="center">
                <strong>{{ number_format ($net, 2) }}</strong>
            </td>
        </tr>
    </tfoot>
</table>
</body>
</html>
