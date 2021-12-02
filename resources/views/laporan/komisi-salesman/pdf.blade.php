<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('dashboard.laporan.komisi_salesman') }}</title>

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
            <h4>{{ trans('dashboard.laporan.komisi_salesman') }}</h4>
            <p><small>{{ date('d F Y') }}</small></p>
        </center>

        <table style="margin-top: 1em;">
            <thead>
                <tr>
                    <th width="15">No.</th>
                    <th>Kode Penjualan</th>
                    @role('admin')
                        <th>Kode Pelunasan</th>
                    @endrole
                    <th>Tanggal</th>
                    <th>Salesman</th>
                    <th>Nilai</th>
                    <th>Rate</th>
                    {{-- <th>Total</th> --}}
                    <th>Komisi</th>
                    <th>Total Komisi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode }}</td>
                        @role('admin')
                            <td>{{ $item->pelunasan_piutang ? $item->pelunasan_piutang->kode : $item->kode }}
                        </td> @endrole
                        <td>{{ $item->pelunasan_piutang ? $item->pelunasan_piutang->tanggal->format('d F Y') : $item->tanggal->format('d F Y') }}
                        </td>
                        <td>{{ $item->salesman->nama }}</td>
                        <td>
                            {{ $item->matauang->kode }}
                            {{ $item->pelunasan_piutang ? number_format($item->pelunasan_piutang->bayar, 2, '.', ',') : number_format($item->total_penjualan, 2, '.', ',') }}
                        </td>
                        <td>{{ $item->rate }}</td>
                        <td>1%</td>
                        <td>
                            {{ $item->matauang->kode }}
                            {{ $item->pelunasan_piutang ? number_format($item->pelunasan_piutang->bayar * 0.01, 2, '.', ',') : number_format($item->total_penjualan * 0.01, 2, '.', ',') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center;">Data tidak ditemukan</td>
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
