@push('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"
        integrity="sha256-EQtsX9S1OVXguoTG+N488HS0oZ1+s80IbOEbE3wzJig=" crossorigin="anonymous"></script>

    <script>
        cek_form_entry_brg()
        hitung_total_payment()
        hitung_semua_total_brg()
        get_barang_by_matauang_id()

        // $('#matauang').change(function() {
        //     hitung_semua_total_brg()
        //     get_barang_by_matauang_id()
        // })

        $('#bank_input').change(function() {
            if ($('#jenis_pembayaran_input').val() == 'Transfer') {
                get_rekening()
            }
        })

        $('#kode_barang_input').change(function() {
            cek_stok($(this).val())
        })

        $('#qty_input, #harga_input, #kode_input, #diskon_input, #diskon_persen_input, #ppn_input,#pph_input, #gross_input, #biaya_masuk_input, #clr_fee_input, #checkbox_ppn, #checkbox_pph')
            .on('keyup keydown change',
                function() {
                    hitung_netto()
                    cek_form_entry_brg()
                    cek_table_length()
                })

        $('#jenis_pembayaran_input, #bank_input, #rekening_input, #no_cek_giro_input,#tgl_cek_giro_input,#bayar_input').on(
            'keyup keydown change',
            function() {
                cek_form_entry_payment()

                cek_table_length()
            })

        $('#form_trx').submit(function(e) {
            e.preventDefault()
            // ||
            //     !$('select[name="kode_po"]').val()
            if (
                !$('input[name="tanggal"]').val() ||
                !$('input[name="rate"]').val() ||
                !$('select[name="bentuk_kepemilikan"]').val() ||
                !$('select[name="matauang"]').val() ||
                !$('select[name="gudang"]').val()
            ) {
                $('select[name="rate"]').focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Mohon isi data Pembelian - Header terlebih dahulu!'
                })
            } else {
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

                let gross = harga * qty

                // cek duplikasi barang
                $('input[name="barang[]"]').each(function() {
                    // cari index tr ke berapa
                    let index = $(this).parent().parent().index()

                    // kalo id barang di cart dan form input(barang) sama
                    //  kalo id supplier di cart dan form input(barang) sama
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
                        ${format_ribuan(pph)}
                        <input type="hidden"  class="pph_hidden" name="pph[]" value="${pph}">
                    </td>
                    <td>
                        ${format_ribuan(biaya_masuk)}
                        <input type="hidden"  class="biaya_masuk_hidden" name="biaya_masuk[]" value="${biaya_masuk}">
                    </td>
                    <td>
                        ${format_ribuan(clr_fee)}
                        <input type="hidden"  class="clr_fee_hidden" name="clr_fee[]" value="${clr_fee}">
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
                $('#checkbox_ppn').prop('checked', true)
                $('#checkbox_pph').prop('checked', true)
            }
        })

        $('#form_payment').submit(function(e) {
            e.preventDefault()

            let jenis_pembayaran = $('#jenis_pembayaran_input option:selected')
            let bank = $('#bank_input option:selected')
            let rekening = $('#rekening_input option:selected')
            let no_cek_giro = $('#no_cek_giro_input').val()
            let tgl_cek_giro = $('#tgl_cek_giro_input').val()
            let bayar = $('#bayar_input').val()

            // cek duplikasi barang
            $('input[name="no_cek_giro[]"]').each(function() {
                // cari index tr ke berapa
                let index = $(this).parent().parent().index()

                // kalo id barang di cart dan form input(barang) sama
                //  kalo id supplier di cart dan form input(barang) sama
                if ($(this).val() == no_cek_giro) {
                    // hapus tr berdasarkan index
                    $('#tbl_payment tbody tr:eq(' + index + ')').remove()

                    generate_nomer_payment()
                }
            })

            let no = $('#tbl_payment tbody tr').length + 1

            let data_payment = `<tr>
                    <td>${no}</td>
                    <td>
                        ${jenis_pembayaran.html()}
                        <input type="hidden" class="jenis_pembayaran_hidden" name="jenis_pembayaran[]" value="${jenis_pembayaran.val()}">
                    </td>
                    <td>
                        ${bank.html() == '-- Pilih --' ? '-' : bank.html()}
                        <input type="hidden"  class="bank_hidden" name="bank[]" value="${bank.val()}">
                    </td>
                    <td>
                        ${rekening.html() == '-- Pilih Bank terlebih dahulu --' ? '-' : rekening.html()}
                        <input type="hidden"  class="rekening_hidden" name="rekening[]" value="${rekening.val()}">
                    </td>
                    <td>
                        ${!no_cek_giro ? '-' : no_cek_giro}
                        <input type="hidden"  class="no_cek_giro_hidden" name="no_cek_giro[]" value="${no_cek_giro}">
                    </td>
                    <td>
                        ${!tgl_cek_giro ? '-' : tgl_cek_giro}
                        <input type="hidden"  class="tgl_cek_giro_hidden" name="tgl_cek_giro[]" value="${tgl_cek_giro}">
                    </td>
                    <td>
                        ${format_ribuan(bayar)}
                        <input type="hidden"  class="bayar_hidden" name="bayar[]" value="${bayar}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs btn_edit_payment">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-xs btn_hapus_payment">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>`

            $('#tbl_payment').append(data_payment)

            cek_table_length()
            clear_form_entry_payment()
            hitung_total_payment()

            $('#jenis_pembayaran_input').focus()

            $('#btn_add_payment').prop('disabled', true)
            $('#btn_clear_form_payment').prop('disabled', true)
        })

        $('#btn_clear_form_brg').click(function() {
            $(this).prop('disabled', true)
            clear_form_entry_brg()

            cek_table_length()
        })

        $('#btn_clear_form_payment').click(function() {
            clear_form_entry_payment()

            cek_table_length()
        })

        $('#btn_update_brg').click(function() {
            update_list_brg($('#index_tr_brg').val())
        })

        $('#btn_update_payment').click(function() {
            update_list_payment($('#index_tr_payment').val())
        })

        // clear tr pada semua table
        $('#btn_clear_table').click(function() {
            $('#tbl_trx tbody tr').remove()
            $('#tbl_payment tbody tr').remove()

            clear_form_entry_brg()
            clear_form_entry_payment()

            hitung_semua_total_brg()
            hitung_total_payment()

            cek_table_length()

            $('#btn_simpan').prop('disabled', true)
            $('#btn_clear_table').prop('disabled', true)
        })

        $('#btn_simpan').click(function() {
            $(this).prop('disabled', true)
            $(this).text('loading...')

            let data = {
                // header
                kode: $('input[name="kode"]').val(),
                tanggal: $('input[name="tanggal"]').val(),
                matauang: $('select[name="matauang"]').val(),
                supplier: $('select[name="supplier"]').val(),
                rate: $('input[name="rate"]').val(),
                kode_po: $('select[name="kode_po"]').val(),
                gudang: $('select[name="gudang"]').val(),
                keterangan: $('#keterangan').val(),
                bentuk_kepemilikan: $('#bentuk_kepemilikan').val(),

                // total  barang
                subtotal: $('#subtotal').val(),
                total_ppn: $('#total_ppn').val(),
                total_pph: $('#total_pph').val(),
                total_diskon: $('#total_diskon').val(),
                total_biaya_masuk: $('#total_biaya_masuk').val(),
                total_gross: $('#total_gross').val(),
                total_clr_fee: $('#total_clr_fee').val(),
                total_netto: $('#total_netto').val(),
                total_payment: $('#total_payment').val(),

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
                pph: $('input[name="pph[]"]').map(function() {
                    return $(this).val()
                }).get(),
                biaya_masuk: $('input[name="biaya_masuk[]"]').map(function() {
                    return $(this).val()
                }).get(),
                netto: $('input[name="netto[]"]').map(function() {
                    return $(this).val()
                }).get(),
                clr_fee: $('input[name="clr_fee[]"]').map(function() {
                    return $(this).val()
                }).get(),

                // total payment
                jenis_pembayaran: $('input[name="jenis_pembayaran[]"]').map(function() {
                    return $(this).val()
                }).get(),
                bank: $('input[name="bank[]"]').map(function() {
                    return $(this).val()
                }).get(),
                rekening: $('input[name="rekening[]"]').map(function() {
                    return $(this).val()
                }).get(),
                no_cek_giro: $('input[name="no_cek_giro[]"]').map(function() {
                    return $(this).val()
                }).get(),
                tgl_cek_giro: $('input[name="tgl_cek_giro[]"]').map(function() {
                    return $(this).val()
                }).get(),
                bayar: $('input[name="bayar[]"]').map(function() {
                    return $(this).val()
                }).get(),
            }

            $.ajax({
                type: 'PUT',
                url: '{{ route('pembelian.update', $pembelian->id) }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(data) {
                    // $('#btn_simpan').text('simpan')

                    Swal.fire({
                        icon: 'success',
                        title: 'Update data',
                        text: 'Berhasil'
                    }).then(function() {
                        setTimeout(() => {
                            window.location = '{{ route('pembelian.index') }}'
                        }, 500)
                    })
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

        $(document).on('click', '.btn_hapus_payment', function(e) {
            e.preventDefault()

            $(this).parent().parent().remove()

            generate_nomer_payment()
            hitung_total_payment()
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
            let pph = $('.pph_hidden:eq(' + index + ')').val()
            let biaya_masuk = $('.biaya_masuk_hidden:eq(' + index + ')').val()
            let clr_fee = $('.clr_fee_hidden:eq(' + index + ')').val()
            let netto = $('.netto_hidden:eq(' + index + ')').val()

            if (ppn > 0) {
                $('#checkbox_ppn').prop('checked', true)
            } else {
                $('#checkbox_ppn').prop('checked', false)
                $('#checkbox_pph').prop('checked', false)
            }

            if (pph > 0) {
                $('#checkbox_pph').prop('checked', true)
            } else {
                $('#checkbox_pph').prop('checked', false)
            }

            $('#kode_barang_input option[value="' + kode_barang + '"]').attr('selected', 'selected')

            $('#harga_input').val(harga)
            $('#qty_input').val(qty)
            $('#gross_input').val(gross)
            $('#diskon_input').val(diskon)
            $('#diskon_persen_input').val(diskon_persen)
            $('#ppn_input').val(ppn)
            $('#pph_input').val(pph)
            $('#biaya_masuk_input').val(biaya_masuk)
            $('#clr_fee_input').val(clr_fee)
            $('#netto_input').val(netto)

            $('#btn_add_brg').hide()
            $('#btn_update_brg').show()

            $('#index_tr_brg').val(index)

            cek_stok(kode_barang, harga)
        })

        $(document).on('click', '.btn_edit_payment', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            let jenis_pembayaran = $('.jenis_pembayaran_hidden:eq(' + index + ')').val()
            let bank = $('.bank_hidden:eq(' + index + ')').val()
            let rekening = $('.rekening_hidden:eq(' + index + ')').val()
            let no_cek_giro = $('.no_cek_giro_hidden:eq(' + index + ')').val()
            let tgl_cek_giro = $('.tgl_cek_giro_hidden:eq(' + index + ')').val()
            let bayar = $('.bayar_hidden:eq(' + index + ')').val()

            if (jenis_pembayaran == 'Cash') {
                $('#no_cek_giro_input').prop('disabled', true)
                $('#tgl_cek_giro_input').prop('disabled', true)
                $('#bank_input').prop('disabled', true)
                $('#rekening_input').prop('disabled', true)

                $('#bank_input option[value=""]').attr('selected', 'selected')
                $('#rekening_input').html(
                    '<option value="" disabled selected>-- Pilih Bank terlebih dahulu --</option>')
            } else if (jenis_pembayaran == 'Transfer') {
                $('#no_cek_giro_input').prop('disabled', true)
                $('#tgl_cek_giro_input').prop('disabled', true)
                $('#bank_input').prop('disabled', false)
                $('#rekening_input').prop('disabled', false)

                $('#bank_input option[value="' + bank + '"]').attr('selected', 'selected')

                get_rekening(rekening)

                $('#rekening_input option[value="' + rekening + '"]').attr('selected', 'selected')
            } else {
                $('#no_cek_giro_input').prop('disabled', false)
                $('#tgl_cek_giro_input').prop('disabled', false)
                $('#bank_input').prop('disabled', true)
                $('#rekening_input').prop('disabled', true)

                $('#bank_input option[value=""]').attr('selected', 'selected')
                $('#rekening_input').html(
                    '<option value="" disabled selected>-- Pilih Bank terlebih dahulu --</option>')
            }

            $('#jenis_pembayaran_input option[value="' + jenis_pembayaran + '"]').attr('selected', 'selected')
            $('#no_cek_giro_input').val(no_cek_giro)
            $('#tgl_cek_giro_input').val(tgl_cek_giro)
            $('#bayar_input').val(bayar)

            $('#jenis_pembayaran_input').focus()

            $('#btn_add_payment').hide()
            $('#btn_update_payment').show()

            $('#index_tr_payment').val(index)
        })

        function get_rekening(selected = null) {
            $.ajax({
                url: "/beli/pembelian/get-rekening/" + $('#bank_input').val(),
                type: 'GET',
                success: function(data) {
                    let rekening = []

                    $('#rekening_input').prop('disabled', true)
                    $('#rekening_input').html(
                        '<option value="" disabled selected>Loading...</option>')

                    setTimeout(() => {
                        if (data.length > 0) {
                            data.forEach(elm => {
                                rekening.push(
                                    `<option value="${elm.id}">${elm.nomor_rekening} - ${elm.nama_rekening}</option>`
                                )
                            })

                            $('#rekening_input').html(rekening)
                            $('#rekening_input').prop('disabled', false)

                            // kalo dipanggil dari .btn_edit_payment
                            if (selected) {
                                $('#rekening_input option[value="' + selected + '"]').attr('selected',
                                    'selected')
                            }
                        } else {
                            $('#rekening_input').html(
                                '<option value="" disabled selected>-- No.Rekening tidak ditemukan --</option>'
                            )
                        }
                    }, 1000)
                }
            })
        }

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

            let gross = harga * qty

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
                    ${format_ribuan(pph)}
                    <input type="hidden"  class="pph_hidden" name="pph[]" value="${pph}">
                </td>
                <td>
                    ${format_ribuan(biaya_masuk)}
                    <input type="hidden"  class="biaya_masuk_hidden" name="biaya_masuk[]" value="${biaya_masuk}">
                </td>
                <td>
                    ${format_ribuan(clr_fee)}
                    <input type="hidden"  class="clr_fee_hidden" name="clr_fee[]" value="${clr_fee}">
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

            $('#checkbox_ppn').prop('checked', false)
            $('#checkbox_pph').prop('checked', false)
        }

        function update_list_payment(index) {
            let jenis_pembayaran = $('#jenis_pembayaran_input option:selected')
            let bank = $('#bank_input option:selected')
            let rekening = $('#rekening_input option:selected')
            let no_cek_giro = $('#no_cek_giro_input').val()
            let tgl_cek_giro = $('#tgl_cek_giro_input').val()
            let bayar = $('#bayar_input').val()

            let no = $('#tbl_payment tbody tr').length + 1

            let data_payment = `
                <td>${no}</td>
                <td>
                    ${jenis_pembayaran.html()}
                    <input type="hidden" class="jenis_pembayaran_hidden" name="jenis_pembayaran[]" value="${jenis_pembayaran.val()}">
                </td>
                <td>
                    ${bank.html()}
                    <input type="hidden"  class="bank_hidden" name="bank[]" value="${bank.val()}">
                </td>
                <td>
                    ${rekening.html()}
                    <input type="hidden"  class="rekening_hidden" name="rekening[]" value="${rekening.val()}">
                </td>
                <td>
                    ${no_cek_giro}
                    <input type="hidden"  class="no_cek_giro_hidden" name="no_cek_giro[]" value="${no_cek_giro}">
                </td>
                <td>
                    ${tgl_cek_giro}
                    <input type="hidden"  class="tgl_cek_giro_hidden" name="tgl_cek_giro[]" value="${tgl_cek_giro}">
                </td>
                <td>
                    ${format_ribuan(bayar)}
                    <input type="hidden"  class="bayar_hidden" name="bayar[]" value="${bayar}">
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-xs btn_edit_payment">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-xs btn_hapus_payment">
                        <i class="fa fa-times"></i>
                    </button>
                </td>`

            $('#tbl_payment tbody tr:eq(' + index + ')').html(data_payment)

            cek_table_length()

            clear_form_entry_payment()

            hitung_total_payment()

            $('#jenis_pembayaran_input').focus()

            $('#btn_update_payment').hide()
            $('#btn_add_payment').show()
            $('#btn_add_payment').prop('disabled', true)
            $('#btn_clear_form_payment').prop('disabled', true)
        }

        function clear_form_entry_brg() {
            $('#kode_barang_input option[value=""]').attr('selected', 'selected')
            $('#harga_input').val('')
            $('#qty_input').val('')
            $('#ppn_input').val('')
            $('#pph_input').val('')
            $('#stok_input').val('')
            $('#gross_input').val('')
            $('#qty_input').val('')
            $('#netto_input').val('')
            $('#diskon_input').val('')
            $('#diskon_persen_input').val('')
            $('#biaya_masuk_input').val('')
            $('#clr_fee_input').val('')

            $('#btn_update_brg').hide()
            $('#btn_add_brg').show()

            $('#index_tr_brg').val('')
        }

        function clear_form_entry_payment() {
            $('#jenis_pembayaran_input option[value=""]').attr('selected', 'selected')
            $('#bank_input option[value=""]').attr('selected', 'selected')
            $('#rekening_input').html('<option value="" disabled selected>-- Pilih Bank terlebih dahulu --</option>')
            $('#no_cek_giro_input').val('')
            $('#tgl_cek_giro_input').val('')
            $('#bayar_input').val('')
            $('#total_payment_input').val('')

            $('#btn_update_payment').hide()
            $('#btn_add_payment').show()
        }

        function hitung_semua_total_brg() {
            let subtotal = 0
            let total_pph = 0
            let total_ppn = 0
            let total_diskon = 0
            let total_biaya_masuk = 0
            let total_gross = 0
            let total_clr_fee = 0
            let total_netto = 0
            let matauang = $('#matauang option:selected').html()

            $('input[name="harga[]"]').map(function() {
                subtotal += parseFloat($(this).val())
            }).get()

            $('input[name="pph[]"]').map(function() {
                total_pph += parseFloat($(this).val())
            }).get()

            $('input[name="ppn[]"]').map(function() {
                total_ppn += parseFloat($(this).val())
            }).get()

            $('input[name="diskon[]"]').map(function() {
                total_diskon += parseFloat($(this).val())
            }).get()

            $('input[name="biaya_masuk[]"]').map(function() {
                total_biaya_masuk += parseFloat($(this).val())
            }).get()

            $('input[name="clr_fee[]"]').map(function() {
                total_clr_fee += parseFloat($(this).val())
            }).get()

            $('input[name="netto[]"]').map(function() {
                total_netto += parseFloat($(this).val())
            }).get()

            $('input[name="gross[]"]').map(function() {
                total_gross += parseFloat($(this).val())
            }).get()

            $('#subtotal').val(subtotal)
            $('#total_ppn').val(total_ppn)
            $('#total_pph').val(total_pph)
            $('#total_diskon').val(total_diskon)
            $('#total_biaya_masuk').val(total_biaya_masuk)
            $('#total_clr_fee').val(total_clr_fee)
            $('#total_netto').val(total_netto)
            $('#total_gross').val(total_gross)

            cek_form_entry_brg()
        }

        function hitung_total_payment() {
            let total_payment = 0

            $('input[name="bayar[]"]').map(function() {
                total_payment += parseFloat($(this).val())
            }).get()

            $('#total_payment_input').val(total_payment)
        }

        function hitung_netto() {
            let harga = $('#harga_input').val() ? parseFloat($('#harga_input').val()) : 0
            let qty = $('#qty_input').val() ? parseFloat($('#qty_input').val()) : 0
            let diskon_persen = $('#diskon_persen_input').val() ? parseFloat($('#diskon_persen_input').val()) : 0
            let biaya_masuk = $('#biaya_masuk_input').val() ? parseFloat($('#biaya_masuk_input').val()) : 0
            let clr_fee = $('#clr_fee_input').val() ? parseFloat($('#clr_fee_input').val()) : 0

            let diskon = (harga *  qty) * diskon_persen / 100
            let gross = harga * qty - diskon

            let ppn = 0
            let pph = 0

            if ($('#checkbox_ppn').is(':checked')) {
                // gross*10%
                ppn = gross * 0.1
            }

            if ($('#checkbox_pph').is(':checked')) {
                pph = ppn / 4
            }

            let netto = gross + ppn + pph + biaya_masuk + clr_fee

            $('#diskon_input').val(diskon)
            $('#ppn_input').val(ppn)
            $('#pph_input').val(pph)
            $('#netto_input').val(netto)
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

        function generate_nomer_payment() {
            let no = 1
            $('#tbl_payment tbody tr').each(function() {
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
                $('#btn_update_brg').prop('disabled', false)
                $('#btn_clear_form_brg').prop('disabled', false)
            }
        }

        function cek_form_entry_payment() {
            let jenis_pembayaran_input = $('#jenis_pembayaran_input')
            let bank_input = $('#bank_input')
            let rekening_input = $('#rekening_input')
            let no_cek_giro_input = $('#no_cek_giro_input')
            let tgl_cek_giro_input = $('#tgl_cek_giro_input')
            let bayar_input = $('#bayar_input')

            // kalo cash, bank dan giro boleh kosong
            if (jenis_pembayaran_input.val() == 'Cash') {
                bank_input.prop('disabled', true)
                rekening_input.prop('disabled', true)
                no_cek_giro_input.prop('disabled', true)
                tgl_cek_giro_input.prop('disabled', true)

                bank_input.val('')
                no_cek_giro_input.val('')
                tgl_cek_giro_input.val('')
                rekening_input.html('<option value="" disabled selected>-- Pilih Bank terlebih dahulu --</option>')

                if (bayar_input.val()) {
                    $('#btn_add_payment').prop('disabled', false)
                    $('#btn_clear_form_payment').prop('disabled', false)
                } else {
                    $('#btn_add_payment').prop('disabled', true)
                    $('#btn_clear_form_payment').prop('disabled', true)
                }
            }

            if (jenis_pembayaran_input.val() == 'Transfer') {
                bank_input.prop('disabled', false)
                rekening_input.prop('disabled', true)
                // bank_input.val('')

                no_cek_giro_input.prop('disabled', true)
                no_cek_giro_input.val('')
                tgl_cek_giro_input.prop('disabled', true)
                tgl_cek_giro_input.val('')

                if (bayar_input.val() && bank_input.val() && rekening_input.val()) {
                    $('#btn_add_payment').prop('disabled', false)
                    $('#btn_clear_form_payment').prop('disabled', false)
                } else {
                    $('#btn_add_payment').prop('disabled', true)
                    $('#btn_clear_form_payment').prop('disabled', true)
                }
            }

            if (jenis_pembayaran_input.val() == 'Giro') {
                bank_input.prop('disabled', false)
                // bank_input.val('')
                rekening_input.prop('disabled', true)
                rekening_input.html('<option value="" disabled selected>-- Pilih Bank terlebih dahulu --</option>')

                no_cek_giro_input.prop('disabled', false)
                tgl_cek_giro_input.prop('disabled', false)

                if (bayar_input.val() && bayar_input.val() && no_cek_giro_input.val() && tgl_cek_giro_input.val()) {
                    $('#btn_add_payment').prop('disabled', false)
                    $('#btn_clear_form_payment').prop('disabled', false)
                } else {
                    $('#btn_add_payment').prop('disabled', true)
                    $('#btn_clear_form_payment').prop('disabled', true)
                }
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

                    if (harga_edit) {
                        harga.val(harga_edit)
                    } else {
                        harga.val(data.harga_beli)
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
