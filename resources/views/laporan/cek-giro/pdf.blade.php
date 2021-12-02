<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('dashboard.laporan.cek_giro') }}</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 11px;
            border-left: 0;
            margin-bottom: 1em;
        }

        table td,
        table th,
        table tfoot {
            border: 1px solid black;
            padding: 3px;
            border-left: 0px solid;
            border-right: 0px solid;
        }

        /* table tr:nth-child(even) {
            background-color: #F2F2F2;
        } */

        table th,
        table tfoot {
            padding-top: 8px;
            padding-bottom: 8px;
            text-align: left;
            /* background-color: #158CBA; */
            color: black;
        }

        p,
        h4 {
            line-height: 8px;
        }

        small {
            font-size: 12px;
        }

        .garis {
            height: 3px;
            border-top: 3px solid black;
            border-bottom: 1px solid black;
        }

    </style>
</head>

<body>
    <div>
        <center>
            <h3 style="margin-bottom: 0px">{{ $toko->nama }}</h3>
            <p>{{ $toko->deskripsi }}</p>
            <p>{{ $toko->alamat . ', ' . $toko->kota }}</p>
            <p>Email: {{ $toko->email }} | Website: {{ $toko->website ? $toko->website : '-' }}</p>
            <p>{{ $toko->telp1 . ' / ' . $toko->telp2 }}</p>
        </center>

        {{-- <hr style="margin-bottom: 15px"> --}}
        <div class="garis"></div>

        <center>
            <h4>{{ trans('dashboard.laporan.cek_giro') }}</h4>
            <p><small>{{ date('d F Y') }}</small></p>
        </center>

        <table style="margin-top: 1em;">
            <thead>
                <tr>
                    <th width="15">No.</th>
                    <th>No Cek/Giro</th>
                    <th>Tgl Cek/Giro</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>No Ref</th>
                    <th>Nama Ref</th>
                    <th>Bank</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($item->pembelian)
                                {{ $item->pembelian->pembelian_pembayaran[0]->no_cek_giro }}
                            @else
                                {{ $item->penjualan->penjualan_pembayaran[0]->no_cek_giro }}
                            @endif
                        </td>
                        <td>
                            @if ($item->pembelian)
                                {{ $item->pembelian->pembelian_pembayaran[0]->tgl_cek_giro->format('d F Y') }}
                            @else
                                {{ $item->penjualan->penjualan_pembayaran[0]->tgl_cek_giro->format('d F Y') }}
                            @endif
                        </td>
                        <td>{{ strtoupper($item->jenis_cek) }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            @if ($item->pembelian)
                                {{ $item->pembelian->kode }}
                            @else
                                {{ $item->penjualan->kode }}
                            @endif
                        </td>
                        <td>
                            @if ($item->penjualan)
                                {{ $item->penjualan->pelanggan->nama_pelanggan }}
                            @else
                                {{ $item->pembelian->supplier ? $item->pembelian->supplier->nama_supplier : 'Tanpa Supplier' }}
                            @endif
                        </td>
                        <td>
                            @if ($item->pembelian)
                                {{ $item->pembelian->pembelian_pembayaran[0]->bank ? $item->pembelian->pembelian_pembayaran[0]->bank->nama : '-' }}
                            @else
                                {{ $item->penjualan->penjualan_pembayaran[0]->bank ? $item->penjualan->penjualan_pembayaran[0]->bank->nama : '-' }}
                            @endif
                        </td>
                        <td>
                            {{ $item->pembelian ? $item->pembelian->matauang->kode : $item->penjualan->matauang->kode }}

                            @if ($item->pembelian)
                                {{ number_format($item->pembelian->pembelian_pembayaran[0]->bayar) }}
                            @else
                                {{ number_format($item->penjualan->penjualan_pembayaran[0]->bayar) }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>

</html>
