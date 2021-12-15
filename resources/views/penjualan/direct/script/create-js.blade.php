@push('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"
        integrity="sha256-EQtsX9S1OVXguoTG+N488HS0oZ1+s80IbOEbE3wzJig=" crossorigin="anonymous"></script>

    <script>
        // buat sidebar jadi mini, supaya tablenya jadi lega
        // $('.page-sidebar-fixed').addClass('page-sidebar-minified')

        get_barang_by_matauang_id()

        // #matauang -> select
        // .matauang -> input hidden pada table
        $('#matauang').change(function() {
            get_barang_by_matauang_id()
        })

        $('#search').on('keyup', function() {
            // setTimeout(() => {
            get_barang_by_matauang_id()
            // }, 500)
        })

        $(document).on('click', '.card', function() {
            let index = $(this).index()

            let id_barang = $('.id_barang').eq(index).val()
            let nama_barang = $('.nama_barang').eq(index).val()
            let harga = $('.harga').eq(index).val()
            let matauang = $('.matauang').eq(index).val()
            let stok = $('.stok').eq(index).val()
            let qty = 1
            let diskon = 0
            let ppn = 0
            let subtotal = harga
            let data_trx = ''

            $('.id_barang_hidden').each(function(i) {
                // i = index each
                if ($(this).val() == id_barang) {
                    let qty_hidden = $('.qty_hidden').eq(i).val()
                    let stok_hidden = $('.stok_hidden').eq(i).val()
                    let harga_hidden = $('.qty_hidden').eq(i).val()

                    qty = parseInt(qty_hidden) + 1
                    subtotal = parseFloat(harga) * qty

                    $('#tbl_trx tbody tr:eq(' + i + ')').remove()
                }
            })

            if (qty > stok) {
                if (stok == 0) {
                    // $('#tbl_trx tbody tr:eq(' + index + ')').remove()

                    Swal.fire({
                        icon: 'error',
                        title: 'Stok tidak mencukupi untuk dikeluarkan',
                        text: `Stok tersisa: ${stok}`
                    })
                } else {
                    let data_trx = `<tr>
                        <td></td>
                        <td>
                            <p style="line-height: 10px;">${nama_barang}</p>
                            <p style="line-height: 10px;">
                                <span class="span_harga">${matauang} ${format_ribuan(harga)}</span>
                            </p>
                            <p style="line-height: 10px;">
                                <span class="span_diskon">Disc: ${matauang} ${diskon}</span>,
                                <span class="span_ppn">PPN: ${matauang} ${ppn}</span>
                            </p>
                            <input type="hidden" name="id_barang[]" class="id_barang_hidden" value="${id_barang}">
                            <input type="hidden" class="nama_barang_hidden" value="${nama_barang}">
                            <input type="hidden" name="harga[]" class="harga_hidden" value="${harga}">
                            <input type="hidden" name="subtotal[]" class="subtotal_hidden" value="${harga}">
                            <input type="hidden" class="matauang_hidden" value="${matauang}">
                            <input type="hidden" class="stok_hidden" value="${stok}">

                            <input type="hidden" name="diskon[]" class="diskon_hidden" value="0">
                            <input type="hidden" name="diskon_persen[]" class="diskon_persen_hidden" value="0">
                            <input type="hidden" name="ppn[]" class="ppn_hidden" value="0">
                            <input type="hidden" name="netto[]" class="netto_hidden" value="${subtotal}">
                        </td>
                        <td>
                            <span class="span_qty">1</span>
                            <input type="hidden" name="qty[]" class="qty_hidden" value="1">
                        </td>
                        <td>
                            <span class="span_subtotal">${matauang} ${format_ribuan(harga)}</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs btn_edit" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-edit"></i>
                            </button>

                            <button type="button" class="btn btn-danger btn-xs btn_hapus">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>`

                    $('#tbl_trx').append(data_trx)
                    generate_nomer()
                    hitung_grand_total()
                    cek_table_length()

                    Swal.fire({
                        icon: 'error',
                        title: 'Stok tidak mencukupi untuk dikeluarkan',
                        text: `Stok tersisa: ${stok}`
                    })
                }
            } else {
                let data_trx = `<tr>
                    <td></td>
                    <td>
                        <p style="line-height: 10px;">${nama_barang}</p>
                        <p style="line-height: 10px;">
                            <span class="span_harga">${matauang} ${format_ribuan(harga)}</span>
                        </p>
                        <p style="line-height: 10px;">
                            <span class="span_diskon">Disc: ${matauang} ${diskon}</span>,
                            <span class="span_ppn">PPN: ${matauang} ${ppn}</span>
                        </p>

                        <input type="hidden" name="id_barang[]" class="id_barang_hidden" value="${id_barang}">
                        <input type="hidden"class="nama_barang_hidden" value="${nama_barang}">
                        <input type="hidden" name="harga[]" class="harga_hidden" value="${harga}">
                        <input type="hidden" name="subtotal[]" class="subtotal_hidden" value="${subtotal}">
                        <input type="hidden"class="matauang_hidden" value="${matauang}">
                        <input type="hidden" class="stok_hidden" value="${stok}">

                        <input type="hidden" name="diskon[]" class="diskon_hidden" value="0">
                        <input type="hidden" name="diskon_persen[]" class="diskon_persen_hidden" value="0">
                        <input type="hidden" name="ppn[]" class="ppn_hidden" value="0">
                        <input type="hidden" name="netto[]" class="netto_hidden" value="${subtotal}">
                    </td>
                    <td>
                        <span class="span_qty">${qty}</span>
                        <input type="hidden" name="qty[]" class="qty_hidden" value="${qty}">
                    </td>
                    <td>
                        <span class="span_subtotal">${matauang} ${format_ribuan(subtotal)}</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs btn_edit" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-xs btn_hapus">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>`

                $('#tbl_trx').append(data_trx)
                generate_nomer()
                hitung_grand_total()
                cek_table_length()
            }
        })

        $(document).on('click', '.btn_edit', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            let id_barang = $('.id_barang_hidden').eq(index).val()
            let nama_barang = $('.nama_barang_hidden').eq(index).val()
            let harga = $('.harga_hidden').eq(index).val()
            let matauang = $('.matauang_hidden').eq(index).val()
            let stok = $('.stok_hidden').eq(index).val()
            let qty = $('.qty_hidden').eq(index).val()
            let diskon = $('.diskon_hidden').eq(index).val()
            let diskon_persen = $('.diskon_persen_hidden').eq(index).val()
            let ppn = $('.ppn_hidden').eq(index).val()
            let netto = $('.netto_hidden').eq(index).val()
            let subtotal = $('.subtotal_hidden').eq(index).val()

            $('#id_barang_modal').val(id_barang)
            $('#nama_barang_modal').val(nama_barang)
            $('#harga_modal').val(harga)
            $('#qty_modal').val(qty)
            $('#matauang_modal').val(matauang)
            $('#stok_modal').val(stok)
            $('#diskon_modal').val(diskon)
            $('#diskon_persen_modal').val(diskon_persen)
            $('#gross_modal').val(subtotal)
            $('#ppn_modal').val(ppn)
            $('#netto_modal').val(netto)

            $("#qty_modal").attr({
                "max": stok,
                "min": 1
            })

            $('#hash').text('#' + (parseInt(index) + 1))
            $('#tr_index').val(index)
        })

        $('#btn_update').click(function() {
            $('#myModal').modal('hide')

            let index = $('#tr_index').val()

            let id_barang = $('#id_barang_modal').val()
            let nama_barang = $('#nama_barang_modal').val()
            let harga = $('#harga_modal').val()
            let diskon = $('#diskon_modal').val()
            let diskon_persen = $('#diskon_persen_modal').val()
            let gross = $('#gross_modal').val()
            let ppn = $('#ppn_modal').val()
            let netto = $('#netto_modal').val()
            let matauang = $('#matauang_modal').val()
            let qty = $('#qty_modal').val()
            let stok = $('#stok_modal').val()

            if (parseInt(stok) < parseInt(qty)) {
                qty = 1

                Swal.fire({
                    icon: 'error',
                    title: 'Stok tidak mencukupi untuk dikeluarkan',
                    text: `Stok tersisa: ${stok}`
                })
            } else {
                $('.id_barang_hidden').eq(index).val(id_barang)
                $('.nama_barang_hidden').eq(index).val(nama_barang)
                $('.harga_hidden').eq(index).val(harga)
                $('.matauang_hidden').eq(index).val(matauang)
                $('.qty_hidden').eq(index).val(qty)
                $('.stok_hidden').eq(index).val(stok)
                $('.diskon_hidden').eq(index).val(diskon)
                $('.diskon_persen_hidden').eq(index).val(diskon_persen)
                $('.ppn_hidden').eq(index).val(ppn)
                $('.subtotal_hidden').eq(index).val(gross)
                $('.netto_hidden').eq(index).val(netto)
                $('.matauang_hidden').eq(index).val(matauang)

                $('.span_ppn').eq(index).text('PPN: ' + matauang + ' ' + format_ribuan(ppn))
                $('.span_diskon').eq(index).text('Disc: ' + matauang + ' ' + format_ribuan(diskon))
                $('.span_subtotal').eq(index).text(matauang + ' ' + format_ribuan(netto))
                $('.span_harga').eq(index).text(matauang + ' ' + format_ribuan(harga))
                $('.span_qty').eq(index).text(qty)

                hitung_grand_total()
                $('#checkbox_ppn').prop('checked', false)
            }
        })

        $('#myModal').on('shown.bs.modal', function(e) {
            if ($('#ppn_modal').val() > 0) {
                $('#checkbox_ppn').prop('checked', true)
            } else {
                $('#checkbox_ppn').prop('checked', false)
            }

            hitung_grand_total()
        })

        function get_barang_by_matauang_id() {
            $.ajax({
                url: "/jual/direct-penjualan/get-barang-by-matauang/",
                data: {
                    id: $('#matauang').val(),
                    search: $('#search').val()
                },
                type: 'GET',
                success: function(data) {
                    barang = ''
                    $('#list-barang').html(`
                    <div class="col-md-12 text-center">
                        <img src="../../img/barang/loading.gif" alt="Loading..." width="20">
                    </div>`)

                    setTimeout(() => {
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                barang += `<div class="col-md-4 text-center card">
                                    <img src="${ value.gambar == 'noimage.png' ? '../../img/' : '../../img/barang/'}${value.gambar}" alt="gambar barang" class="img-fluid rounded" style="width: 100%; height: 190px; object-fit: cover; border-radius: 3px; margin-bottom: 5px;">

                                    <p class="p_nama_barang">${value.kode} - ${value.nama}</p>

                                    <small>${value.mata_uang_jual.kode} ${format_ribuan(value.harga_jual)}</small>

                                    <input type="hidden" class="id_barang" value="${value.id}">

                                    <input type="hidden" class="nama_barang" value="${value.kode} - ${value.nama}">

                                    <input type="hidden" class="harga" value="${value.harga_jual}">

                                    <input type="hidden" class="matauang" value="${value.mata_uang_jual.kode}">

                                    <input type="hidden" class="stok" value="${value.stok}">
                                </div>`
                            })

                            $('#list-barang').html(barang)
                        } else {
                            barang = `<div class="col-md-12">
                                <p class="text-center">Barang tidak ditemukan</p>
                            </div>`

                            $('#list-barang').html(barang)
                        }
                    }, 1000)
                }
            })
        }

        $(`#nama_barang_modal, #harga_modal,
            #qty_modal, #diskon_modal,
            #diskon_persen_modal,#gross_modal,
            #checkbox_ppn, #netto_modal`)
            .on('change keyup keydown', function() {
                let harga = $('#harga_modal').val() ? parseFloat($('#harga_modal').val()) : 0
                let diskon_persen = $('#diskon_persen_modal').val() ? parseFloat($('#diskon_persen_modal').val()) : 0
                let qty = $('#qty_modal').val()
                let stok = $('#stok_modal').val()

                // if (qty > stok) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Stok tidak mencukupi untuk dikeluarkan',
                //         text: `Stok tersisa: ${stok}`
                //     })

                //     $('#qty_modal').val(1)
                // } else {
                let diskon = (harga * qty) * diskon_persen / 100
                let gross = (qty * harga) - diskon
                let ppn = 0

                if ($('#checkbox_ppn').is(':checked')) {
                    // gross*10%
                    ppn = gross * 0.1
                }

                let netto = gross + ppn

                $('#diskon_modal').val(diskon)
                $('#ppn_modal').val(ppn)
                $('#netto_modal').val(netto)
                $('#gross_modal').val(gross)
                // }
            })

        $(document).on('click', '.btn_hapus', function(e) {
            e.preventDefault()
            $(this).parent().parent().remove()
            generate_nomer()
            hitung_grand_total()
            cek_table_length()
        })

        $('#btn_simpan').click(function() {
            $(this).prop('disabled', true)
            $(this).text('Loading...')

            let total_harga = 0
            let total_ppn = 0
            let total_diskon = 0
            let total_netto = 0
            let total_gross = 0

            $('input[name="harga[]"]').map(function() {
                total_harga += parseFloat($(this).val())
            }).get()

            $('input[name="ppn[]"]').map(function() {
                total_ppn += parseFloat($(this).val())
            }).get()

            $('input[name="diskon[]"]').map(function() {
                total_diskon += parseFloat($(this).val())
            }).get()

            $('input[name="netto[]"]').map(function() {
                total_netto += parseFloat($(this).val())
            }).get()

            $('input[name="subtotal[]"]').map(function() {
                total_gross += parseFloat($(this).val())
            }).get()

            let data_trx = {
                // header
                matauang: $('select[name="matauang"]').val(),
                pelanggan: $('select[name="pelanggan"]').val(),
                gudang: $('select[name="gudang"]').val(),
                total_netto: $('#grand_total_input').val(),
                bentuk_kepemilikan: $('#bentuk_kepemilikan').val(),

                // total  barang
                subtotal: total_harga,
                total_ppn: total_ppn,
                total_diskon: total_diskon,
                total_gross: total_gross,
                total_netto: total_netto,

                // detail barang
                barang: $('input[name="id_barang[]"]').map(function() {
                    return $(this).val()
                }).get(),
                harga: $('input[name="harga[]"]').map(function() {
                    return $(this).val()
                }).get(),
                qty: $('input[name="qty[]"]').map(function() {
                    return $(this).val()
                }).get(),
                diskon: $('input[name="diskon[]"]').map(function() {
                    return $(this).val()
                }).get(),
                gross: $('input[name="subtotal[]"]').map(function() {
                    return $(this).val()
                }).get(),
                diskon_persen: $('input[name="diskon_persen[]"]').map(function() {
                    return $(this).val()
                }).get(),
                ppn: $('input[name="ppn[]"]').map(function() {
                    return $(this).val()
                }).get(),
                netto: $('input[name="netto[]"]').map(function() {
                    return $(this).val()
                }).get()
            }

            if (
                !$('select[name="bentuk_kepemilikan"]').val() ||
                !$('select[name="matauang"]').val() ||
                !$('select[name="gudang"]').val() ||
                !$('select[name="pelanggan"]').val()
            ) {
                $('select[name="pelanggan"]').focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Mohon isi data POS Terminal - Header terlebih dahulu!'
                })

                $(this).prop('disabled', false)
                $(this).text('Simpan')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('direct-penjualan.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data_trx,
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Simpan data',
                            text: 'Berhasil'
                        }).then(function() {
                            setTimeout(() => {
                                window.location =
                                    '{{ route('direct-penjualan.create') }}'
                            })
                        })
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText)

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        })
                    }
                })
            }
        })

        // hitung jumlan <tr> pada table#tbl_trx dan table#tbl_payemnt
        function cek_table_length() {
            let table_trx = $('#tbl_trx tbody tr').length

            if (table_trx) {
                $('#btn_simpan').prop('disabled', false)
                $('#btn_clear_table').prop('disabled', false)
            } else {
                $('#btn_simpan').prop('disabled', true)
                $('#btn_clear_table').prop('disabled', true)
            }
        }

        // clear tr pada semua table
        $('#btn_clear_table').click(function() {
            $('#tbl_trx tbody tr').remove()
            hitung_grand_total()
            cek_table_length()
        })

        // auto generate no pada table
        function generate_nomer() {
            let no = 1
            $('#tbl_trx tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        function format_ribuan(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        function hitung_grand_total() {
            let total = 0

            $('.netto_hidden').each(function() {
                total += parseInt($(this).val())
            })

            // let matauang_type = $('#matauang option:selected').html()

            $('#grand_total').text(`GRAND TOTAL: ${format_ribuan(total)},- `)

            $('#grand_total_input').val(total)
        }
    </script>
@endpush
