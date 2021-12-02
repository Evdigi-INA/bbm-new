@push('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"
        integrity="sha256-EQtsX9S1OVXguoTG+N488HS0oZ1+s80IbOEbE3wzJig=" crossorigin="anonymous"></script>

    <script>
        get_kode()
        cek_form_entry()

        // Cek stok
        $('#kode_barang_input').change(function() {
            cek_stok($(this).val())
        })

        $('#matauang').change(function() {
            hitung_grand_total()
            get_barang_by_matauang_id()
        })

        $('input[name="tanggal"]').change(function() {
            get_kode()
        })

        $('#qty_input, #harga_input, #kode_input, #supplier_input, #bentuk_kepemilikan_input').on('keyup keydown change',
            function() {
                subtotal = $('#qty_input').val() * $('#harga_input').val()

                $('#subtotal_input').val(subtotal)

                cek_form_entry()
            })

        $('#form_trx').submit(function(e) {
            e.preventDefault()

            if (
                !$('input[name="tanggal"]').val() ||
                !$('input[name="rate"]').val() ||
                !$('select[name="gudang"]').val() ||
                !$('select[name="matauang"]').val()
            ) {
                $('select[name="gudang"]').focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Mohon isi data Adjusment Plus - Header terlebih dahulu!'
                })
            } else {
                let kode_barang = $('#kode_barang_input option:selected')
                let supplier = $('#supplier_input option:selected')
                let harga = $('#harga_input').val()
                let bentuk_kepemilikan = $('#bentuk_kepemilikan_input option:selected')
                let qty = $('#qty_input').val()

                let subtotal = harga * qty

                // cek duplikasi barang
                $('input[name="barang[]"]').each(function() {
                    // cari index tr ke berapa
                    let index = $(this).parent().parent().index()

                    // kalo id barang di cart dan form input(barang) sama
                    //  kalo id supplier di cart dan form input(barang) sama
                    if ($(this).val() == kode_barang.val()) {
                        // hapus tr berdasarkan index
                        $('#tbl_trx tbody tr:eq(' + index + ')').remove()

                        generate_nomer()
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
                        ${supplier.html()}
                        <input type="hidden" class="supplier_hidden" name="supplier[]" value="${supplier.val()}">
                    </td>
                    <td>
                        ${bentuk_kepemilikan.html()}
                        <input type="hidden" class="bentuk_kepemilikan_hidden" name="bentuk_kepemilikan[]" value="${bentuk_kepemilikan.val()}">
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
                        ${format_ribuan(subtotal)}
                        <input type="hidden" name="subtotal[]" class="subtotal_hidden" value="${subtotal}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs btn_edit">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-xs btn_hapus">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>`

                $('#tbl_trx').append(data_trx)

                cek_table_length()

                clear_form_entry()

                hitung_grand_total()
            }
        })

        $('#btn_clear_form').click(function() {
            // $(this).prop('disabled', true)
            // $('#btn_update').prop('disabled', true)
            // $('#btn_add').prop('disabled', true)

            clear_form_entry()

            cek_table_length()
        })

        $('#btn_update').click(function() {
            update_list($('#index_tr').val())
        })

        $('#btn_clear_table').click(function() {
            $('#tbl_trx tbody tr').remove()

            clear_form_entry()
            hitung_grand_total()
            cek_table_length()
        })

        $('#btn_simpan').click(function() {
            $(this).prop('disabled', true)
            $(this).text('loading...')

            let data = {
                kode: $('input[name="kode"]').val(),
                tanggal: $('input[name="tanggal"]').val(),
                matauang: $('select[name="matauang"]').val(),
                gudang: $('select[name="gudang"]').val(),
                rate: $('input[name="rate"]').val(),
                grand_total: $('#grand_total_input').val(),
                barang: $('input[name="barang[]"]').map(function() {
                    return $(this).val()
                }).get(),
                supplier: $('input[name="supplier[]"]').map(function() {
                    return $(this).val()
                }).get(),
                bentuk_kepemilikan: $('input[name="bentuk_kepemilikan[]"]').map(function() {
                    return $(this).val()
                }).get(),
                harga: $('input[name="harga[]"]').map(function() {
                    return $(this).val()
                }).get(),
                qty: $('input[name="qty[]"]').map(function() {
                    return $(this).val()
                }).get(),
                subtotal: $('input[name="subtotal[]"]').map(function() {
                    return $(this).val()
                }).get()
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('adjustment-plus.store') }}',
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
                            window.location = '{{ route('adjustment-plus.create') }}'
                        }, 500)
                    })

                    // $('#tbl_trx tbody tr').remove()

                    // $('input[name="tanggal"]').val("{{ date('Y-m-d') }}")
                    // $('input[name="rate"]').val('')

                    // $('select[name="gudang"] option[value=""]').attr('selected', 'selected')
                    // $('select[name="matauang"] option[value=""]').attr('selected', 'selected')

                    // clear_form_entry()
                    // hitung_grand_total()
                    // cek_table_length()
                    // get_kode()

                    // $('select[name="gudang"]').focus()
                    // $('#btn_simpan').text('simpan')
                    // $('#grand_total').text(`GRAND TOTAL: 0,- `)

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

        $(document).on('click', '.btn_hapus', function(e) {
            e.preventDefault()

            $(this).parent().parent().remove()

            generate_nomer()
            hitung_grand_total()
            cek_table_length()
        })

        $(document).on('click', '.btn_edit', function(e) {
            e.preventDefault()
            $('#btn_update').prop('disabled', false)
            $('#btn_clear_form').prop('disabled', false)

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            let kode_barang = $('.kode_barang_hidden:eq(' + index + ')').val()
            let supplier = $('.supplier_hidden:eq(' + index + ')').val()
            let bentuk_kepemilikan = $('.bentuk_kepemilikan_hidden:eq(' + index + ')').val()
            let harga = $('.harga_hidden:eq(' + index + ')').val()
            let qty = $('.qty_hidden:eq(' + index + ')').val()
            let subtotal = $('.subtotal_hidden:eq(' + index + ')').val()

            $('#kode_barang_input option[value="' + kode_barang + '"]').attr('selected', 'selected')
            $('#supplier_input option[value="' + supplier + '"]').attr('selected', 'selected')
            $('#bentuk_kepemilikan_input option[value="' + bentuk_kepemilikan + '"]').attr('selected', 'selected')

            $('#harga_input').val(harga)
            $('#qty_input').val(qty)
            $('#subtotal_input').val(subtotal)

            $('#btn_add').hide()
            $('#btn_update').show()

            $('#index_tr').val(index)

            cek_stok(kode_barang, harga)
        })

        // hitung jumlan <tr> pada table#tbl_trx
        function cek_table_length() {
            let total = $('#tbl_trx tbody tr').length

            if (total > 0) {
                $('#btn_simpan').prop('disabled', false)
                $('#btn_clear_table').prop('disabled', false)
            } else {
                $('#btn_simpan').prop('disabled', true)
                $('#btn_clear_table').prop('disabled', true)
            }
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

        function update_list(index) {
            let kode_barang = $('#kode_barang_input option:selected')
            let supplier = $('#supplier_input option:selected')
            let harga = $('#harga_input').val()
            let bentuk_kepemilikan = $('#bentuk_kepemilikan_input option:selected')
            let qty = $('#qty_input').val()

            let subtotal = harga * qty

            // cek duplikasi pas update
            let cek = 0
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
                    ${supplier.html()}
                    <input type="hidden" class="supplier_hidden" name="supplier[]" value="${supplier.val()}">
                </td>
                <td>
                    ${bentuk_kepemilikan.html()}
                    <input type="hidden" class="bentuk_kepemilikan_hidden" name="bentuk_kepemilikan[]" value="${bentuk_kepemilikan.val()}">
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
                    ${format_ribuan(subtotal)}
                    <input type="hidden" name="subtotal[]" class="subtotal_hidden" value="${subtotal}">
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-xs btn_edit">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-xs btn_hapus">
                        <i class="fa fa-times"></i>
                    </button>
                </td>`

            $('#tbl_trx tbody tr:eq(' + index + ')').html(data_trx)

            clear_form_entry()

            hitung_grand_total()

            generate_nomer()
        }

        function clear_form_entry() {
            $('#kode_barang_input option[value=""]').attr('selected', 'selected')
            $('#supplier_input option[value="1"]').attr('selected', 'selected')
            $('#bentuk_kepemilikan_input option[value=""]').attr('selected', 'selected')

            $('#harga_input').val('')
            $('#stok_input').val('')
            $('#qty_input').val('')
            $('#subtotal_input').val('')

            $('#btn_update').hide()
            $('#btn_add').show()
        }

        // ajax get kode
        function get_kode() {
            $.ajax({
                url: "/inventory/adjustment-plus/generate-kode/" + $('input[name="tanggal"]').val(),
                type: 'GET',
                success: function(data) {
                    // setTimeout(() => {
                    //     $('input[name="kode"]').val('Loading...')
                    // }, 500)

                    $('input[name="kode"]').val(data)
                }
            })
        }

        function hitung_grand_total() {
            let total = 0

            $('.subtotal_hidden').each(function() {
                total += parseInt($(this).val())
            })

            let matauang_type = $('#matauang option:selected').html()
            // if (matauang_type == '-- Pilih -- ') {
            //     matauang_type = ''
            // }

            $('#grand_total').text(`GRAND TOTAL: ${matauang_type} ${format_ribuan(total)},- `)

            $('#kode_barang_input').focus()

            $('#grand_total_input').val(total)

            cek_form_entry()
        }

        function format_ribuan(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        // auto generate no pada table
        function generate_nomer() {
            let no = 1
            $('#tbl_trx tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        // cek apakah form entry(adjusment plus - list) kosong atau tidak
        // kalo kosong buat button(add & clear) disabled
        function cek_form_entry() {
            if (
                !$('#kode_barang_input').val() ||
                !$('#supplier_input').val() ||
                !$('#bentuk_kepemilikan_input').val() ||
                !$('#harga_input').val() ||
                !$('#subtotal_input').val() ||
                !$('#qty_input').val() ||
                $('#qty_input').val() < 1
            ) {
                $('#btn_update').prop('disabled', true)
                $('#btn_add').prop('disabled', true)
                $('#btn_clear_form').prop('disabled', true)
            } else {
                $('#btn_update').prop('disabled', false)
                $('#btn_add').prop('disabled', false)
                $('#btn_clear_form').prop('disabled', false)
            }
        }

        function cek_stok(id, harga_edit = null) {
            let harga = $('#harga_input')
            harga.prop('disabled', true)
            let stok = $('#stok_input')
            harga.val('')
            harga.prop('placeholder', 'Loading...')
            stok.prop('disabled', true)
            stok.val('')
            stok.prop('placeholder', 'Loading...')

            $.ajax({
                url: '/masterdata/barang/cek-stok/' + id,
                type: 'GET',
                success: function(data) {
                    // ini stok buat cek stok(hidden)
                    $('#stok').val(data.stok)
                    $('#min_stok').val(data.min_stok)

                    // ini stok yg ditampilin(input)
                    stok.val(data.stok)

                    if (harga_edit) {
                        harga.val(harga_edit)
                    } else {
                        harga.val(data.harga_beli)
                    }

                    harga.prop('disabled', false)
                    harga.prop('placeholder', 'Harga')
                    stok.prop('placeholder', 'Stok')

                    $('#bentuk_kepemilikan_input').focus()
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
