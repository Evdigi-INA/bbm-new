<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('dashboard.laporan.pelunasan_piutang') }}</title>

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
            <h4>{{ trans('dashboard.laporan.pelunasan_piutang') }}</h4>
            <p><small>{{ date('d F Y') }}</small></p>
        </center>

        <table style="margin-top: 1em;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode</th>
                    <th>Kode Penjualan</th>
                    {{-- <th>Tanggal</th> --}}
                    <th>Pelanggan</th>
                    <th>Jenis Pembayaran</th>
                    <th>Nilai</th>
                    <th>Rate</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $total_nilai = 0;
                    $grand_total = 0;
                @endphp
                @forelse ($laporan as $jual)
                    @foreach ($jual->pelunasan_piutang_detail as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $jual->kode }}</td>
                            <td>{{ $detail->penjualan->kode }}</td>
                            {{-- <td>{{ $detail->tanggal->format('d F Y') }}</td> --}}
                            <td>{{ $detail->penjualan->pelanggan ? $detail->penjualan->pelanggan->nama_pelanggan : 'Tanpa pelanggan' }}
                            </td>
                            <td>
                                {{ $jual->jenis_pembayaran }}
                                @if ($jual->jenis_pembayaran == 'Transfer')
                                    <br>
                                    Bank: {{ $jual->bank->nama }}
                                    <br>
                                    Rekening:
                                    {{ $jual->rekening_bank->nomor_rekening . ' - ' . $jual->rekening_bank->nama_rekening }}
                                @endif

                                @if ($jual->jenis_pembayaran == 'Giro')
                                    <br>
                                    No Cek/Giro: {{ $jual->no_cek_giro }}
                                    <br>
                                    Tgl Cek/Giro:
                                    {{ date('d F Y', strtotime($jual->tgl_cek_giro)) }}
                                @endif
                            </td>
                            <td>{{ $detail->penjualan->matauang->kode . ' ' . number_format($jual->bayar) }}
                            </td>
                            <td>{{ $jual->rate }}</td>
                            <td>{{ $detail->penjualan->matauang->kode . ' ' . number_format($jual->bayar * $jual->rate) }}
                            </td>
                        </tr>
                        @php
                            $total_nilai += $jual->bayar;
                            $grand_total += $jual->bayar * $jual->rate;
                        @endphp
                    @endforeach

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
