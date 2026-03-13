<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Reconcile</title>

<style>
body{
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
}

table{
    width:100%;
    border-collapse: collapse;
    margin-top:20px;
}

th, td{
    border:1px solid #000;
    padding:6px;
    text-align:left;
}

th{
    background:#f2f2f2;
}
</style>

</head>

<body>

<h2>Laporan Reconcile</h2>

<table>

<thead>
<tr>
<th>No</th>
<th>Merchant</th>
<th>Student</th>
<th>Transaction Code</th>
<th>Card Number</th>
<th>Total</th>
<th>Ledger</th>
<th>Status</th>
<th>Paid At</th>
</tr>
</thead>

<tbody>

@foreach($reconcile as $key => $row)

<tr>
<td>{{ $key+1 }}</td>
<td>{{ $row->merchant_name }}</td>
<td>{{ $row->student_name }}</td>
<td>{{ $row->transaction_code }}</td>
<td>{{ $row->card_number }}</td>
<td>{{ number_format($row->total_amount,0,',','.') }}</td>
<td>{{ number_format($row->ledger_amount,0,',','.') }}</td>
<td>{{ $row->status }}</td>
<td>{{ $row->paid_at }}</td>
</tr>

@endforeach

</tbody>

</table>

</body>
</html>