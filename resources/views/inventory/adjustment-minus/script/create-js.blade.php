@push('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"
        integrity="sha256-EQtsX9S1OVXguoTG+N488HS0oZ1+s80IbOEbE3wzJig=" crossorigin="anonymous"></script>

    <script>
        get_kode()
        cek_form_entry()

        $('input[name="tanggal"]').change(function() {
            get_kode()
        })

        $('#kode_barang_input').change(function() {
            cek_stok($(this).val())
        })

        $('#kode_input, #bentuk_kepemilikan_input, #qty_input').on('keyup keydown change',
            function() {
                cek_form_entry()
            })

        $('#form_trx').submit(function(e) {
            e.preventDefault()

            if (
                !$('input[name="tanggal"]').val() ||
                !$('select[name="gudang"]').val()
            ) {
                $('select[name="gudang"]').focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Mohon isi data Adjusment minus - Header terlebih dahulu!'
                })
            } else {
                let kode_barang = $('#kode_barang_input option:selected')
                let supplier = $('#supplier_input option:selected')
                let bentuk_kepemilikan = $('#bentuk_kepemilikan_input option:selected')
                let qty = $('#qty_input').val()
                let stok = parseInt($('#stok').val())
                let min_stok = parseInt($('#min_stok').val())

                if (stok == min_stok || qty > stok) {
                    $('#qty_input').val('')
                    $('#qty_input').focus()

                    cek_form_entry()

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
                            ${format_ribuan(qty)}
                            <input type="hidden"  class="qty_hidden" name="qty[]" value="${qty}">
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

                    cek_form_entry()
                }
            }
        })

        $('#btn_clear_form').click(function() {
            clear_form_entry()

            cek_table_length()

            cek_form_entry()
        })

        $('#btn_update').click(function() {
            update_list($('#index_tr').val())
        })

        $('#btn_clear_table').click(function() {
            $('#tbl_trx tbody tr').remove()

            clear_form_entry()

            cek_table_length()

            cek_form_entry()
        })

        $('#btn_simpan').click(function() {
            $(this).prop('disabled', true)
            $(this).text('loading...')

            let data = {
                kode: $('input[name="kode"]').val(),
                tanggal: $('input[name="tanggal"]').val(),
                gudang: $('select[name="gudang"]').val(),
                barang: $('input[name="barang[]"]').map(function() {
                    return $(this).val()
                }).get(),
                supplier: $('input[name="supplier[]"]').map(function() {
                    return $(this).val()
                }).get(),
                bentuk_kepemilikan: $('input[name="bentuk_kepemilikan[]"]').map(function() {
                    return $(this).val()
                }).get(),
                qty: $('input[name="qty[]"]').map(function() {
                    return $(this).val()
                }).get(),
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('adjustment-minus.store') }}',
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
                            window.location = '{{ route('adjustment-minus.create') }}'
                        }, 500)
                    })

                    // $('#tbl_trx tbody tr').remove()

                    // $('input[name="tanggal"]').val("{{ date('Y-m-d') }}")
                    // $('select[name="gudang"] option[value=""]').attr('selected', 'selected')

                    // clear_form_entry()
                    // cek_table_length()
                    // get_kode()
                    // cek_form_entry()

                    // $('select[name="gudang"]').focus()
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

        $(document).on('click', '.btn_hapus', function(e) {
            e.preventDefault()

            $(this).parent().parent().remove()

            generate_nomer()
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
            let qty = $('.qty_hidden:eq(' + index + ')').val()

            $('#kode_barang_input option[value="' + kode_barang + '"]').attr('selected', 'selected')
            $('#supplier_input option[value="' + supplier + '"]').attr('selected', 'selected')
            $('#bentuk_kepemilikan_input option[value="' + bentuk_kepemilikan + '"]').attr('selected', 'selected')

            $('#qty_input').val(qty)

            $('#btn_add').hide()
            $('#btn_update').show()

            $('#index_tr').val(index)

            cek_stok(kode_barang)
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

        function update_list(index) {
            let kode_barang = $('#kode_barang_input option:selected')
            let supplier = $('#supplier_input option:selected')
            let bentuk_kepemilikan = $('#bentuk_kepemilikan_input option:selected')
            let qty = $('#qty_input').val()
            let stok = parseInt($('#stok').val())
            let min_stok = parseInt($('#min_stok').val())

            if (stok == min_stok || qty > stok) {
                $('#qty_input').val('')
                $('#qty_input').focus()

                cek_form_entry()

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
                        ${supplier.html()}
                        <input type="hidden" class="supplier_hidden" name="supplier[]" value="${supplier.val()}">
                    </td>
                    <td>
                        ${bentuk_kepemilikan.html()}
                        <input type="hidden" class="bentuk_kepemilikan_hidden" name="bentuk_kepemilikan[]" value="${bentuk_kepemilikan.val()}">
                    </td>
                    <td>
                        ${format_ribuan(qty)}
                        <input type="hidden"  class="qty_hidden" name="qty[]" value="${qty}">
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

                cek_form_entry()
            }
        }

        function clear_form_entry() {
            $('#kode_barang_input option[value=""]').attr('selected', 'selected')
            $('#supplier_input option[value="1"]').attr('selected', 'selected')
            $('#bentuk_kepemilikan_input option[value=""]').attr('selected', 'selected')

            $('#qty_input').val('')
            $('#stok_input').val('')

            $('#btn_update').hide()
            $('#btn_add').show()
        }

        // ajax get kode
        function get_kode() {
            $.ajax({
                url: "/inventory/adjustment-minus/generate-kode/" + $('input[name="tanggal"]').val(),
                type: 'GET',
                success: function(data) {
                    $('input[name="kode"]').val(data)
                }
            })
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

        // cek apakah form entry(adjusment minus - list) kosong atau tidak
        // kalo kosong buat button(add & clear) disabled
        function cek_form_entry() {
            if (
                !$('#kode_barang_input').val() ||
                !$('#supplier_input').val() ||
                !$('#bentuk_kepemilikan_input').val() ||
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

        function cek_stok(id) {
            let stok = $('#stok_input')
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
                    stok.prop('placeholder', 'Stok')

                    $('#supplier_input').focus()
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
