<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('dashboard.laporan.stok_barang') }}</title>

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
            <h4>{{ trans('dashboard.laporan.stok_barang') }}</h4>
            <p><small>{{ date('d F Y') }}</small></p>
        </center>

        <table style="margin-bottom: 1em;">
            <thead>
                <tr>
                    <th width="15">No.</th>
                    <th>Barang</th>
                    <th>Gudang</th>
                    <th>Tipe</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $grandtotal_beli = 0;
                    $total_qty_beli = 0;
                    $total_harga_beli = 0;

                    $grandtotal_retur_beli = 0;
                    $total_qty_retur_beli = 0;
                    $total_harga_retur_beli = 0;

                    $grandtotal_jual = 0;
                    $total_qty_jual = 0;
                    $total_harga_jual = 0;

                    $grandtotal_retur_jual = 0;
                    $total_qty_retur_jual = 0;
                    $total_harga_retur_jual = 0;

                    $grandtotal_adjustment_plus = 0;
                    $total_qty_adjustment_plus = 0;
                    $total_harga_adjustment_plus = 0;

                    $grandtotal_adjustment_minus = 0;
                    $total_qty_adjustment_minus = 0;
                    $total_harga_adjustment_minus = 0;

                    $no = 1;
                @endphp
                @if (count($laporan) > 0)
                    @foreach ($laporan['stok_beli'] as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}

                            </td>
                            <td>{{ $item->pembelian->gudang->nama }}</td>
                            <td>Purch</td>
                            <td> {{ $item->qty }}</td>
                            <td>
                                {{ number_format($item->harga) }}
                            </td>
                            <td>
                                {{ number_format($item->gross) }}
                            </td>
                        </tr>
                        @php
                            $grandtotal_beli += $item->gross;
                            $total_qty_beli += $item->qty;
                            $total_harga_beli += $item->harga;
                        @endphp
                    @endforeach

                    @foreach ($laporan['stok_retur_beli'] as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}
                            </td>
                            <td>{{ $item->retur_pembelian->gudang->nama }}</td>
                            <td>Return Purch</td>
                            <td>-{{ $item->qty_retur }}</td>
                            <td>
                                {{ number_format($item->harga) }}
                            </td>
                            <td>-
                                {{ number_format($item->gross) }}
                            </td>
                        </tr>
                        @php
                            $grandtotal_retur_beli += $item->gross;
                            $total_qty_retur_beli += $item->qty_retur;
                            $total_harga_retur_beli += $item->harga;
                        @endphp
                    @endforeach

                    @foreach ($laporan['stok_jual'] as $item)
                        @php
                            $grandtotal_jual += $item->gross;
                            $total_qty_jual += $item->qty;
                            $total_harga_jual += $item->harga;
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}
                            </td>
                            <td>{{ $item->penjualan->gudang->nama }}</td>
                            <td>Sale</td>
                            <td>-{{ $item->qty }}</td>
                            <td>{{ number_format($item->harga) }}</td>
                            <td>{{ number_format($item->gross) }}</td>
                        </tr>
                    @endforeach

                    @foreach ($laporan['stok_retur_jual'] as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}
                            </td>
                            <td>{{ $item->retur_penjualan->gudang->nama }}</td>
                            <td>Return Sale</td>
                            <td> {{ $item->qty_retur }}</td>
                            <td>{{ number_format($item->harga) }}</td>
                            <td>{{ number_format($item->gross) }}</td>
                        </tr>
                        @php
                            $grandtotal_retur_jual += $item->gross;
                            $total_qty_retur_jual += $item->qty_retur;
                            $total_harga_retur_jual += $item->harga;
                        @endphp
                    @endforeach

                    @foreach ($laporan['stok_adjustment_plus'] as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}
                            </td>
                            <td>{{ $item->adjustment_plus->gudang->nama }}</td>
                            <td>Adj Plus</td>
                            <td> {{ $item->qty }}</td>
                            <td>{{ number_format($item->harga) }}</td>
                            <td>{{ number_format($item->subtotal) }}</td>
                        </tr>
                        @php
                            $grandtotal_adjustment_plus += $item->subtotal;
                            $total_qty_adjustment_plus += $item->qty;
                            $total_harga_adjustment_plus += $item->harga;
                        @endphp
                    @endforeach

                    @foreach ($laporan['stok_adjustment_minus'] as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}
                            </td>
                            <td>{{ $item->adjustment_minus->gudang->nama }}</td>
                            <td>Adj Min</td>
                            <td>-{{ $item->qty }}</td>
                            <td>{{ number_format($item->barang->harga_beli) }} </td>
                            <td>-{{ number_format($item->barang->harga_beli * $item->qty) }}</td>
                        </tr>
                        @php
                            $grandtotal_adjustment_minus += $item->barang->harga_beli * $item->qty;
                            $total_qty_adjustment_minus += $item->qty;
                            $total_harga_adjustment_minus += $item->barang->harga_beli;
                        @endphp
                    @endforeach
                @endif
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="4">Total</th>
                    <th>
                        {{ $total_qty_beli + $total_qty_adjustment_plus + $total_qty_retur_jual - $total_qty_jual - $total_qty_retur_beli - $total_qty_adjustment_minus }}
                    </th>
                    <th>
                        {{ number_format($total_harga_beli + $total_harga_adjustment_plus + $total_harga_retur_jual - $total_harga_jual - $total_harga_retur_beli - $total_harga_adjustment_minus) }}
                    </th>
                    <th>
                        {{ number_format($grandtotal_beli + $grandtotal_adjustment_plus + $grandtotal_retur_jual - $grandtotal_jual - $grandtotal_retur_beli - $grandtotal_adjustment_minus) }}
                    </th>
                </tr>
            </tfoot>
        </table>

        <small>
            <strong>
                @if (request()->query('per_tanggal'))
                    Per Tanggal:
                    {{ date('d F Y', strtotime(request()->query('per_tanggal'))) }}
                @endif
            </strong>
        </small>
    </div>

</body>

</html>
