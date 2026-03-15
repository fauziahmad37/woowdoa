<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Kartu</title>

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

<h2>Laporan Kartu</h2>

<table>

<thead>
<tr>
	<th>No </th>
	<th>NIS</th> 
	<th>Nama Santri</th> 
	<th>Nomor Kartu</th>  
	<th>Terbitan Ke</th>  
	<th>Status</th>   
	<th>Alasan Terbit</th> 
</tr>
</thead>

<tbody>

@foreach($cardreport as $key => $row)

<tr>
	<td>{{ $key+1 }}</td> 
	<td>{{ $row->nis }}</td>
	<td>{{ $row->student->student_name }}</td> 
	<td>{{ $row->card_number }}</td> 
	<td>{{ $row->sequence }}</td> 
	<td>{{ $row->status }}</td>   
	<td>{{ $row->reason }}</td>   
</tr>

@endforeach

</tbody>

</table>

</body>
</html>