<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Santri</title>
    <style>
        body{
            font-family: sans-serif;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:20px;
        }

        table, th, td{
            border:1px solid #000;
        }

        th, td{
            padding:8px;
            text-align:center;
        }

        th{
            background:#f2f2f2;
        }
    </style>
</head>

<body>

<h2 style="text-align:center;">Laporan Transaksi Santri</h2>

<table>
<thead>
<tr>
<th>No</th>
<th>Kode Transaksi</th>
<th>Santri</th>
<th>Merchant</th>
<th>Total</th>
<th>Status</th>
<th>Tanggal Bayar</th>
</tr>
</thead>

<tbody>

@foreach($transactions as $index => $trx)

<tr>
<td>{{ $index + 1 }}</td>
<td>{{ $trx->transaction_code }}</td>
<td>{{ $trx->student->student_name ?? '-' }}</td>
<td>{{ $trx->merchant->merchant_name ?? '-' }}</td>
<td>Rp {{ number_format($trx->total_amount,0,',','.') }}</td>
<td>{{ $trx->status }}</td>
<td>{{ $trx->paid_at }}</td>
</tr>

@endforeach

</tbody>

</table>

</body>
</html>