@push('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"
        integrity="sha256-EQtsX9S1OVXguoTG+N488HS0oZ1+s80IbOEbE3wzJig=" crossorigin="anonymous"></script>

    <script>
        get_kode()
        cek_form_entry_brg()

        $('#matauang').change(function() {
            hitung_semua_total_brg()
            get_barang_by_matauang_id()
        })

        $('input[name="tanggal"]').change(function() {
            get_kode()
        })

        // Cek stok
        $('#kode_barang_input').change(function() {
            cek_stok($(this).val())
        })

        $('#pelanggan').change(function() {
            $.ajax({
                url: "/jual/penjualan/get-alamat/" + $('#pelanggan').val(),
                type: 'GET',
                success: function(data) {
                    $('#alamat').val('Loading..')
                    $('#alamat').prop('disabled', true)

                    setTimeout(() => {
                        $('#alamat').val(data.alamat)
                        $('#alamat').prop('disabled', false)
                    }, 1000);
                }
            })
        })

        $('#total_biaya_kirim').on('keyup keydown change', function() {
            let total_netto = $('#total_netto').val()

            if ($(this).val()) {
                $('#total_penjualan').val(parseFloat(total_netto) + parseFloat($(this).val()))
            } else {
                $('#total_penjualan').val(parseFloat(total_netto))
            }
        })

        $('#qty_input, #harga_input, #kode_input, #diskon_input, #diskon_persen_input, #ppn_input,#gross_input, #checkbox_ppn')
            .on('keyup keydown change',
                function() {
                    hitung_netto()

                    cek_form_entry_brg()

                    cek_table_length()
                })

        $('#form_trx').submit(function(e) {
            e.preventDefault()

            if (
                !$('input[name="tanggal"]').val() ||
                !$('input[name="rate"]').val() ||
                !$('select[name="bentuk_kepemilikan"]').val() ||
                !$('select[name="matauang"]').val() ||
                !$('select[name="pelanggan"]').val() ||
                !$('textarea[name="alamat"]').val()
                // !$('select[name="gudang"]').val() ||
            ) {
                $('select[name="matauang"]').focus()
                // !$('select[name="salesman"]').val() ||

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Mohon isi data penjualan - Header terlebih dahulu!'
                })
            } else {
                let kode_barang = $('#kode_barang_input option:selected')
                let harga = $('#harga_input').val()
                let qty = parseInt($('#qty_input').val())
                let ppn = $('#ppn_input').val()
                let diskon = $('#diskon_input').val()
                let diskon_persen = $('#diskon_persen_input').val() ? parseFloat($('#diskon_persen_input').val()) :
                    0
                let netto = $('#netto_input').val()

                let gross = (qty * harga) - diskon

                let stok = parseInt($('#stok').val())
                let min_stok = parseInt($('#min_stok').val())

                // kalo stok - qty lebih besar dari min stok
                // let min_stok_qty = stok - qty
                // kalo mau validasi min stok
                // if (stok == min_stok || qty > stok || min_stok_qty < min_stok)

                if (stok == min_stok || qty > stok) {
                    $('#qty_input').val('')
                    $('#qty_input').focus()

                    Swal.fire({
                        icon: 'error',
                        title: 'Stok tidak mencukupi untuk dikeluarkan',
                        text: `Stok: ${stok}, Stok Minim: ${min_stok}`
                    })
                } else {
                    // cek duplikasi barang
                    $('input[name="barang[]"]').each(function() {
                        // cari index tr ke berapa
                        let index = $(this).parent().parent().index()

                        // kalo id barang di cart dan form input(barang) sama
                        if ($(this).val() == kode_barang.val()) {
                            // hapus tr berdasarkan index
                            $('#tbl_trx tbody tr:eq(' + index + ')').remove()

                            generate_nomer_brg()
                        }
                    })

                    let no = $('#tbl_trx tbody tr').length + 1

                    let data_trx = `<tr>
                        <td>${no}</td>
                        <td>
                            ${kode_barang.html()}
                            <input type="hidden" class="kode_barang_hidden" name="barang[]" value="${kode_barang.val()}">
                        </td>
                        <td>
                            ${format_ribuan(harga)}
                            <input type="hidden"  class="harga_hidden" name="harga[]" value="${harga}">
                        </td>
                        <td>
                            ${format_ribuan(qty)}
                            <input type="hidden"  class="qty_hidden" name="qty[]" value="${qty}">
                        </td>
                        <td>
                            ${format_ribuan(diskon_persen)}%
                            <input type="hidden"  class="diskon_persen_hidden" name="diskon_persen[]" value="${diskon_persen}">
                        </td>
                        <td>
                            ${format_ribuan(diskon)}
                            <input type="hidden"  class="diskon_hidden" name="diskon[]" value="${diskon}">
                        </td>
                        <td>
                            ${format_ribuan(gross)}
                            <input type="hidden" name="gross[]" class="gross_hidden" value="${gross}">
                        </td>
                        <td>
                            ${format_ribuan(ppn)}
                            <input type="hidden"  class="ppn_hidden" name="ppn[]" value="${ppn}">
                        </td>
                        <td>
                            ${format_ribuan(netto)}
                            <input type="hidden"  class="netto_hidden" name="netto[]" value="${netto}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs btn_edit_brg">
                                <i class="fa fa-edit"></i>
                            </button>

                            <button type="button" class="btn btn-danger btn-xs btn_hapus_brg">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>`

                    $('#tbl_trx').append(data_trx)

                    cek_table_length()

                    clear_form_entry_brg()

                    hitung_semua_total_brg()

                    $('#kode_barang_input').focus()
                    $('#stok').val('')
                    $('min_stok').val()

                    $('#checkbox_ppn').prop('checked', true)
                }
            }
        })


        $('#btn_clear_form_brg').click(function() {
            clear_form_entry_brg()
            cek_table_length()

            $('#btn_clear_form_brg').prop('disabled', true)
        })

        $('#btn_update_brg').click(function() {
            update_list_brg($('#index_tr_brg').val())
        })


        // clear tr pada semua table
        $('#btn_clear_table').click(function() {
            $('#tbl_trx tbody tr').remove()

            clear_form_entry_brg()
            hitung_semua_total_brg()
            cek_table_length()
        })

        $('#btn_simpan').click(function() {
            $(this).prop('disabled', true)
            $(this).text('Loading...')

            let data = {
                // header
                kode: $('input[name="kode"]').val(),
                tanggal: $('input[name="tanggal"]').val(),
                matauang: $('select[name="matauang"]').val(),
                pelanggan: $('select[name="pelanggan"]').val(),
                rate: $('input[name="rate"]').val(),
                keterangan: $('#keterangan').val(),
                alamat: $('#alamat').val(),
                total_penjualan: $('#total_penjualan').val(),
                total_netto: $('#total_netto').val(),
                total_biaya_kirim: $('#total_biaya_kirim').val(),
                bentuk_kepemilikan: $('#bentuk_kepemilikan').val(),
                // gudang: $('select[name="gudang"]').val(),
                // salesman: $('select[name="salesman"]').val(),

                // total  barang
                subtotal: $('#subtotal').val(),
                total_ppn: $('#total_ppn').val(),
                total_diskon: $('#total_diskon').val(),
                total_gross: $('#total_gross').val(),
                total_netto: $('#total_netto').val(),

                // detail barang
                barang: $('input[name="barang[]"]').map(function() {
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
                gross: $('input[name="gross[]"]').map(function() {
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
                }).get(),
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('pesanan-penjualan.store') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Simpan data',
                        text: 'Berhasil'
                    }).then(function() {
                        setTimeout(() => {
                            window.location =
                                '{{ route('pesanan-penjualan.create') }}'
                        }, 500)
                    })

                    // get_kode()

                    // $('#tbl_trx tbody tr').remove()

                    // $('input[name="tanggal"]').val("{{ date('Y-m-d') }}")
                    // $('input[name="rate"]').val('')
                    // $('textarea[name="keterangan"]').val('')
                    // $('textarea[name="alamat"]').val('')

                    // $('select[name="pelanggan"] option[value=""]').attr('selected', 'selected')

                    // // $('select[name="gudang"] option[value=""]').attr('selected', 'selected')

                    // $('select[name="matauang"] option[value=""]').attr('selected', 'selected')
                    // // $('select[name="salesman"] option[value=""]').attr('selected', 'selected')
                    // $('select[name="bentuk_kepemilikan"] option[value="0"]').attr('selected',
                    //     'selected')

                    // clear_form_entry_brg()
                    // hitung_semua_total_brg()
                    // cek_table_length()

                    // $('select[name="matauang"]').focus()
                    // $('#btn_simpan').text('simpan')

                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Tambah data',
                    //     text: 'Berhasil'
                    // })
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText)

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                }
            })
        })

        $(document).on('click', '.btn_hapus_brg', function(e) {
            e.preventDefault()

            $(this).parent().parent().remove()

            generate_nomer_brg()
            hitung_semua_total_brg()
            cek_table_length()
        })


        $(document).on('click', '.btn_edit_brg', function(e) {
            e.preventDefault()
            $('#btn_update_brg').prop('disabled', false)
            $('#btn_clear_form_brg').prop('disabled', false)

            // ambil <tr> index
            let index = $(this).parent().parent().index()
            let kode_barang = $('.kode_barang_hidden:eq(' + index + ')').val()
            let harga = $('.harga_hidden:eq(' + index + ')').val()
            let qty = $('.qty_hidden:eq(' + index + ')').val()
            let gross = $('.gross_hidden:eq(' + index + ')').val()
            let diskon = $('.diskon_hidden:eq(' + index + ')').val()
            let diskon_persen = $('.diskon_persen_hidden:eq(' + index + ')').val()
            let ppn = $('.ppn_hidden:eq(' + index + ')').val()
            let netto = $('.netto_hidden:eq(' + index + ')').val()

            if (ppn > 0) {
                $('#checkbox_ppn').prop('checked', true)
            } else {
                $('#checkbox_ppn').prop('checked', false)
            }

            $('#kode_barang_input option[value="' + kode_barang + '"]').attr('selected', 'selected')
            $('#qty_input').val(qty)
            $('#gross_input').val(gross)
            $('#diskon_input').val(diskon)
            $('#diskon_persen_input').val(diskon_persen)
            $('#ppn_input').val(ppn)
            $('#netto_input').val(netto)
            $('#harga_input').val(harga)

            $('#btn_add_brg').hide()
            $('#btn_update_brg').show()

            $('#index_tr_brg').val(index)


            // parameter kedua buat ngasih tau kalo functionnya dipanggil ketika edit, dan agar harga ngisi dari input harga_hidden bukan dari API
            cek_stok(kode_barang, harga)
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

        function update_list_brg(index) {
            let kode_barang = $('#kode_barang_input option:selected')
            let harga = $('#harga_input').val()
            let qty = $('#qty_input').val()
            let ppn = $('#ppn_input').val()
            let pph = $('#pph_input').val()
            let diskon = $('#diskon_input').val()
            let diskon_persen = $('#diskon_persen_input').val() ? parseFloat($('#diskon_persen_input').val()) :
                0
            let biaya_masuk = $('#biaya_masuk_input').val() ? parseFloat($('#biaya_masuk_input').val()) : 0
            let clr_fee = $('#clr_fee_input').val() ? parseFloat($('#clr_fee_input').val()) : 0
            let netto = $('#netto_input').val()

            let gross = (qty * harga) - diskon

            let stok = parseInt($('#stok').val())
            let min_stok = parseInt($('#min_stok').val())

            if (stok == min_stok || qty > stok) {
                $('#qty_input').val('')
                $('#qty_input').focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Stok tidak mencukupi untuk dikeluarkan',
                    text: `Stok: ${stok}, Stok Minim: ${min_stok}`
                })
            } else {
                // cek duplikasi pas update
                $('input[name="barang[]"]').each(function(i) {
                    // i = index each
                    if ($(this).val() == kode_barang.val() && i != index) {
                        $('#tbl_trx tbody tr:eq(' + i + ')').remove()
                    }
                })

                let no = parseInt(parseInt(index) + 1)

                let data_trx = `<td>${no}</td>
                    <td>
                        ${kode_barang.html()}
                        <input type="hidden" class="kode_barang_hidden" name="barang[]" value="${kode_barang.val()}">
                    </td>
                    <td>
                        ${format_ribuan(harga)}
                            <input type="hidden"  class="harga_hidden" name="harga[]" value="${harga}">
                    </td>
                    <td>
                        ${format_ribuan(qty)}
                            <input type="hidden"  class="qty_hidden" name="qty[]" value="${qty}">
                    </td>
                    <td>
                        ${format_ribuan(diskon_persen)}%
                        <input type="hidden"  class="diskon_persen_hidden" name="diskon_persen[]" value="${diskon_persen}">
                    </td>
                    <td>
                        ${format_ribuan(diskon)}
                        <input type="hidden"  class="diskon_hidden" name="diskon[]" value="${diskon}">
                    </td>
                    <td>
                        ${format_ribuan(gross)}
                        <input type="hidden" name="gross[]" class="gross_hidden" value="${gross}">
                    </td>
                    <td>
                        ${format_ribuan(ppn)}
                        <input type="hidden"  class="ppn_hidden" name="ppn[]" value="${ppn}">
                    </td>
                    <td>
                        ${format_ribuan(netto)}
                        <input type="hidden"  class="netto_hidden" name="netto[]" value="${netto}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs btn_edit_brg">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-xs btn_hapus_brg">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>`

                $('#tbl_trx tbody tr:eq(' + index + ')').html(data_trx)

                clear_form_entry_brg()
                hitung_semua_total_brg()
                generate_nomer_brg()

                $('#checkbox_ppn').prop('checked', true)
            }
        }

        function clear_form_entry_brg() {
            $('#kode_barang_input option[value=""]').attr('selected', 'selected')
            $('#harga_input').val('')
            $('#qty_input').val('')
            $('#ppn_input').val('')
            $('#netto_input').val('')
            $('#gross_input').val('')
            $('#diskon_input').val('')
            $('#diskon_persen_input').val('')

            $('#btn_update_brg').hide()
            $('#btn_add_brg').show()

            $('#index_tr_brg').val('')
        }

        // ajax get kode
        function get_kode() {
            $.ajax({
                url: "/jual/pesanan-penjualan/generate-kode/" + $('input[name="tanggal"]').val(),
                type: 'GET',
                success: function(data) {
                    $('input[name="kode"]').val(data)
                }
            })
        }

        function hitung_semua_total_brg() {
            let subtotal = 0
            let total_ppn = 0
            let total_diskon = 0
            let total_netto = 0
            let total_gross = 0
            let matauang = $('#matauang option:selected').html()

            $('input[name="harga[]"]').map(function() {
                subtotal += parseFloat($(this).val())
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

            $('input[name="gross[]"]').map(function() {
                total_gross += parseFloat($(this).val())
            }).get()

            $('#subtotal').val(subtotal)
            $('#total_ppn').val(total_ppn)
            $('#total_diskon').val(total_diskon)
            $('#total_netto').val(total_netto)
            $('#total_penjualan').val(total_netto)
            $('#total_gross').val(total_gross)

            cek_form_entry_brg()
        }

        function hitung_netto() {
            let harga = $('#harga_input').val() ? parseFloat($('#harga_input').val()) : 0
            let qty = $('#qty_input').val() ? parseFloat($('#qty_input').val()) : 0
            let diskon_persen = $('#diskon_persen_input').val() ? parseFloat($('#diskon_persen_input').val()) : 0

            let diskon = (harga * qty) * diskon_persen / 100
            let gross = (qty * harga) - diskon
            let ppn = 0

            if ($('#checkbox_ppn').is(':checked')) {
                ppn = gross * 0.1
            }

            let netto = gross + ppn

            $('#diskon_input').val(diskon)
            $('#ppn_input').val(ppn)
            $('#netto_input').val(netto)
            $('#total_penjualan').val(netto)
            $('#gross_input').val(gross)
        }

        // auto generate no pada table
        function generate_nomer_brg() {
            let no = 1
            $('#tbl_trx tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        // cek apakah form entry(barang - list) kosong atau tidak
        // kalo kosong buat button(add & clear) disabled
        function cek_form_entry_brg() {
            if (
                !$('#kode_barang_input').val() ||
                !$('#harga_input').val() ||
                !$('#qty_input').val() ||
                $('#qty_input').val() < 1
            ) {
                $('#btn_add_brg').prop('disabled', true)
                $('#btn_update_brg').prop('disabled', true)
                $('#btn_clear_form_brg').prop('disabled', true)
            } else {
                $('#btn_add_brg').prop('disabled', false)
                $('#btn_clear_form_brg').prop('disabled', false)
                $('#btn_update_brg').prop('disabled', false)
            }
        }


        function format_ribuan(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }

        function cek_stok(id, harga_edit = null) {
            let harga = $('#harga_input')
            let stok = $('#stok_input')

            harga.prop('disabled', true)
            harga.val('')
            harga.prop('placeholder', 'Loading...')
            stok.prop('disabled', true)
            stok.val('')
            stok.prop('placeholder', 'Loading...')

            $.ajax({
                url: '/masterdata/barang/cek-stok/' + id,
                type: 'GET',
                success: function(data) {
                    stok.val(data.stok)

                    $('#stok').val(data.stok)
                    $('#min_stok').val(data.min_stok)

                    if (harga_edit) {
                        harga.val(harga_edit)
                    } else {
                        harga.val(data.harga_jual)
                    }

                    harga.prop('disabled', false)
                    harga.prop('placeholder', 'Harga')
                    stok.prop('placeholder', 'Stok')

                    $('#qty_input').focus()
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText)

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                }
            })
        }

        function get_barang_by_matauang_id() {
            let select_barang = $('#kode_barang_input')
            select_barang.prop('disabled', true)
            select_barang.html(`<option value="" disabled selected>Loading...</option>`)

            $.ajax({
                url: "/jual/direct-penjualan/get-barang-by-matauang/",
                data: {
                    id: $('#matauang').val()
                },
                type: 'GET',
                success: function(data) {
                    barang = ''
                    setTimeout(() => {
                        if (data.length > 0) {
                            barang += ` <option value="" disabled selected>-- Pilih --</option>`
                            $.each(data, function(key, value) {
                                barang +=
                                    `<option value="${value.id}">${value.kode} - ${value.nama}</option>`
                            })

                            select_barang.html(barang)
                            select_barang.prop('disabled', false)
                        } else {
                            barang =
                                `<option value="" disabled selected>Barang tidak ditemukan</option>`

                            select_barang.html(barang)
                            select_barang.prop('disabled', false)
                        }
                    }, 1000)
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText)

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                }
            })
        }
    </script>
@endpush
