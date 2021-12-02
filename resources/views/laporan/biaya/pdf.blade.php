<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('dashboard.laporan.biaya') }}</title>

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
            <h4>{{ trans('dashboard.laporan.biaya') }}</h4>
            <p><small>{{ date('d F Y') }}</small></p>
        </center>

        <table style="margin-top: 1em;">
            <thead>
                <tr>
                    <th width="15">No.</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Jenis Transaksi</th>
                    <th colspan="2">Kas/Bank</th>
                    <th>Rate</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grand_total = 0;
                    $total_jumlah = 0;
                @endphp
                @forelse ($laporan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->tanggal->format('d F Y') }}</td>
                        <td>{{ $item->jenis_transaksi }}</td>
                        <td colspan="2">
                            {{ $item->kas_bank }}
                            @if ($item->kas_bank == 'Bank')
                                <br>
                                {{ $item->bank->nama }}
                                <br>
                                Rekening:
                                {{ $item->rekening->nomor_rekening . ' - ' . $item->rekening->nama_rekening }}
                            @endif
                        </td>
                        <th>{{ $item->rate }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="3">Deskripsi</th>
                        <th>Jumlah</th>
                        <th colspan="2">Subtotal</th>
                    </tr>
                    @foreach ($item->biaya_detail as $detail)
                        <tr>
                            <td></td>
                            <td colspan="3">{{ $detail->deskripsi }}</td>
                            <td>
                                @if ($item->jenis_transaksi == 'Pengeluaran')
                                    -
                                @endif
                                {{ $item->matauang->kode . ' ' . number_format($detail->jumlah) }}
                            </td>
                            <td colspan="2">
                                @if ($item->jenis_transaksi == 'Pengeluaran')
                                    -
                                @endif
                                {{ $item->matauang->kode . ' ' . number_format($detail->jumlah * $item->rate) }}
                            </td>
                        </tr>
                        @php
                            $total_jumlah += $detail->jumlah;
                            $grand_total += $detail->jumlah * $item->rate;
                        @endphp
                    @endforeach
                    <tr>
                        <th></th>
                        <th colspan="3">Total</th>
                        <th>
                            @if ($item->jenis_transaksi == 'Pengeluaran')
                                -
                            @endif
                            {{ $item->matauang->kode . ' ' . number_format($total_jumlah) }}
                        </th>
                        <th colspan="2">
                            @if ($item->jenis_transaksi == 'Pengeluaran')
                                -
                            @endif
                            {{ $item->matauang->kode . ' ' . number_format($grand_total) }}
                        </th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center">Data tidak ditemukan</td>
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
