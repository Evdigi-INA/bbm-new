<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('dashboard.laporan.gross_profit') }}</title>

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
            <h4>{{ trans('dashboard.laporan.gross_profit') }}</h4>
            <p><small>{{ date('d F Y') }}</small></p>
        </center>

        <table style="margin-top: 1em;">
            <thead>
                <tr>
                    <th width="15">No.</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Gudang</th>
                    <th>Pelanggan</th>
                    <th>Salesman</th>
                    <th>Total Jual</th>
                    <th>Gross Profit</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $item)
                    {{-- @php
                        $total_qty = 0;
                        $total = 0;
                    @endphp --}}
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <th>{{ $item->kode }}</th>
                        <th>{{ $item->tanggal->format('d F Y') }}</th>
                        <th>{{ $item->gudang->nama }}</th>
                        <th>{{ $item->pelanggan->nama_pelanggan }}</th>
                        <th>{{ $item->salesman->nama }}</th>
                        <th>{{ $item->matauang->kode . ' ' . number_format($item->total_netto, 2, '.', ',') }}
                        </th>
                        <th>{{ $item->matauang->kode . ' ' . number_format($item->total_gross, 2, '.', ',') }}
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="3">Barang</th>
                        <th>Qty</th>
                        <th colspan="3">Harga Jual</th>
                        {{-- <th colspan="2">Harga Beli</th> --}}
                    </tr>
                    @foreach ($item->penjualan_detail as $detail)
                        <tr>
                            <td></td>
                            <td colspan="3">
                                {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                            </td>
                            <td>{{ $detail->qty }}</td>
                            <td colspan="3">
                                {{ $item->matauang->kode . ' ' . number_format($detail->harga, 2, '.', ',') }}
                            </td>
                            {{-- <td colspan="2">{{ $detail->barang->harga_beli }}</td> --}}
                        </tr>
                        {{-- @php
                            $total_qty += $detail->qty;
                        @endphp --}}
                    @endforeach
                    {{-- <tr>
                        <th></th>
                        <th>Total</th>
                        <th>{{ $total_qty }}</th>
                    </tr> --}}
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <small>
            <strong>
                @if (request()->query('dari_tanggal') && request()->query('sampai_tanggal'))
                    Dari:
                    {{ date('d F Y', strtotime(request()->query('dari_tanggal'))) . ' s/d ' . date('d F Y', strtotime(request()->query('sampai_tanggal'))) }}
                @endif
            </strong>
        </small>
    </div>

</body>

</html>
