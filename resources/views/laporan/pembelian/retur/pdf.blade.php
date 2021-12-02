<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('dashboard.laporan.retur_pembelian') }}</title>

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
            <p>{{ $toko->telp1 . ' s/d ' . $toko->telp2 }}</p>
        </center>

        {{-- <hr style="margin-bottom: 15px"> --}}
        <div class="garis"></div>

        <center>
            <h4>{{ trans('dashboard.laporan.retur_pembelian') }}</h4>
            <p><small>{{ date('d F Y') }}</small></p>
        </center>

        <table style="margin-top: 1em;">
            <thead>
                <tr>
                    <th width="15">No.</th>
                    <th colspan="2">Kode</th>
                    <th colspan="2">Kode Pembelian</th>
                    <th>Tanggal</th>
                    <th colspan="2">Gudang</th>
                    <th colspan="2">Supplier</th>
                    <th>Rate</th>
                </tr>
            </thead>
            @php
                $grandtotal = 0;
            @endphp
            <tbody>
                @forelse ($laporan as $item)
                    @php
                        $total_qty_beli = 0;
                        $total_qty_retur = 0;
                        $total = 0;
                    @endphp
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <th colspan="2">{{ $item->kode }}</th>
                        <th colspan="2">{{ $item->pembelian->kode }}</th>
                        <th>{{ $item->tanggal->format('d F Y') }}</th>
                        <th colspan="2">{{ $item->gudang->nama }}</th>
                        <th colspan="2">
                            {{ $item->pembelian->supplier ? $item->pembelian->supplier->nama_supplier : 'Tanpa Supplier' }}
                        </th>
                        <th>{{ $item->rate }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Barang</th>
                        <th>Qty Beli</th>
                        <th>Qty Retur</th>
                        <th>Harga</th>
                        <th width="20">Disc</th>
                        <th>PPN</th>
                        <th>PPH</th>
                        <th>B.Msk</th>
                        <th>Clr.Fee</th>
                        <th>Subtotal</th>
                    </tr>
                    @foreach ($item->retur_pembelian_detail as $detail)
                        <tr>
                            <td></td>
                            <td>
                                {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                            </td>
                            <td>{{ $detail->qty_beli }}</td>
                            <td>{{ $detail->qty_retur }}</td>
                            <td>
                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->harga) }}
                            </td>
                            <td>
                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->diskon) }}
                            </td>
                            <td>
                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->ppn) }}
                            </td>
                            <td>
                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->pph) }}
                            </td>
                            <td>
                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->biaya_masuk) }}
                            </td>
                            <td>
                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->clr_fee) }}
                            </td>
                            <td>
                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->netto) }}
                            </td>
                        </tr>
                        @php
                            $total_qty_beli += $detail->qty_beli;
                            $total_qty_retur += $detail->qty_retur;
                            $total += $detail->subtotal;
                            $grandtotal += $detail->subtotal;
                        @endphp
                    @endforeach
                    <tr>
                        <th></th>
                        <th>Total</th>
                        <th>{{ $total_qty_beli }}</th>
                        <th>{{ $total_qty_retur }}</th>
                        <th>
                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_gross) }}
                        </th>
                        <th>
                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_diskon) }}
                        </th>
                        <th>
                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_ppn) }}
                        </th>
                        <th>
                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_pph) }}
                        </th>
                        <th>
                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_biaya_masuk) }}
                        </th>
                        <th>
                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_clr_fee) }}
                        </th>
                        <th>
                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_netto) }}
                        </th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" style="text-align: center">Data tidak ditemukan</td>
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
