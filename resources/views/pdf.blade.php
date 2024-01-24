<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style type="text/css">
        body {
            font-family: 'Calibri'
        }
        .header {
            text-align: center;
        }

        .body {
            margin: 40px 0;
        }
        .body table {
            border-collapse: collapse;
        }
        .body table tr th, .body table tr td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>REKAP PEMBELIAN BARANG</p>
        <p>PERIODE {{ date('d-m-Y', strtotime($max)) }} S.D {{ date('d-m-Y', strtotime($min)) }}</p>
    </div>

    <hr>
    <div class="body">
        <table style="width: 100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Pembelian</th>
                    <th>Tanggal</th>
                    <th>Kode Barang</th>
                    <th>Satuan</th>
                    <th>QTY</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $total = 0;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nomor_pembelian }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                        <td>{{ $item->kode_brang }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp.{{ number_format($item->subtotal) }}</td>
                    </tr>
                    @php
                        $total += $item->subtotal;
                    @endphp
                @endforeach
                
                <tr>
                    <td colspan="6"><b>Total</b></td>
                    <td>Rp.{{ number_format($total) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>