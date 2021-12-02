@push('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"
        integrity="sha256-EQtsX9S1OVXguoTG+N488HS0oZ1+s80IbOEbE3wzJig=" crossorigin="anonymous"></script>

    <script>
        hitung_total_piutang()

        let selected_rekening = '{{ $pelunasanPiutang->rekening_bank ? $pelunasanPiutang->rekening_bank->id : '' }}'

        if ($('#bank :selected').val()) {
            $('#bank').prop('disabled', false)
            if ($('#jenis_pembayaran').val() == 'Transfer') {
                get_rekening()
            }
        }

        if ($('#tgl_cek_giro').val()) {
            $('#tgl_cek_giro').prop('disabled', false)
        }

        if ($('#no_cek_giro').val()) {
            $('#no_cek_giro').prop('disabled', false)
        }

        $('#btn_add').click(function(e) {
            e.preventDefault()

            if (
                !$('input[name="tanggal"]').val() ||
                !$('input[name="rate"]').val() ||
                !$('input[name="kode"]').val()
            ) {
                $('input[name="rate"]').focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Mohon isi data {{ trans('pelunasan_piutang.title.index') }} - Header terlebih dahulu!'
                })
            } else {

                let kode_penjualan = $('#kode_penjualan option:selected')
                let tgl_penjualan = $('#tgl_penjualan').val()
                let pelanggan = $('#pelanggan').val()
                let matauang = $('#matauang').val()
                let piutang = parseFloat($('#piutang').val())

                // cek duplikasi kode_penjualan
                $('input[name="kode_penjualan[]"]').each(function() {
                    // cari index tr ke berapa
                    let index = $(this).parent().parent().index()
                    // kalo id kode_penjualan di cart dan form input(kode_penjualan) sama
                    //  kalo id pelanggan di cart dan form input(kode_penjualan) sama
                    if ($(this).val() == kode_penjualan.val()) {
                        // hapus tr berdasarkan index
                        $('#tbl_trx tbody tr:eq(' + index + ')').remove()
                        generate_nomer()
                    }
                })

                let data_trx = `<tr>
                                    <td></td>
                                    <td>
                                        ${kode_penjualan.html()}
                                        <input type="hidden" class="kode_penjualan_hidden" name="kode_penjualan[]" value="${kode_penjualan.val()}">
                                    </td>
                                    <td>
                                        ${tgl_penjualan}
                                        <input type="hidden" class="tgl_penjualan_hidden" name="tgl_penjualan[]" value="${tgl_penjualan}">
                                    </td>
                                    <td>
                                        ${pelanggan}
                                        <input type="hidden" class="pelanggan_hidden" name="pelanggan[]" value="${pelanggan}">
                                    </td>
                                    <td>${matauang}
                                        <input type="hidden" class="matauang_hidden" name="matauang[]" value="${matauang}">
                                    </td>
                                    <td>${format_ribuan(piutang)}
                                        <input type="hidden" class="piutang_hidden" name="piutang[]" value="${piutang}">
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

                generate_nomer()

                clear_form_entry()

                cek_form_entry()

                hitung_total_piutang()

                $('#bayar').val('')
                $('#btn_simpan').prop('disabled', true)
            }
        })

        $('#btn_update').click(function() {
            let index = $('#index_tr').val()

            let kode_penjualan = $('#kode_penjualan option:selected')
            let tgl_penjualan = $('#tgl_penjualan').val()
            let pelanggan = $('#pelanggan').val()
            let matauang = $('#matauang').val()
            let piutang = parseFloat($('#piutang').val())

            // cek duplikasi pas update
            $('input[name="kode_penjualan[]"]').each(function(i) {
                // i = index each
                if ($(this).val() == kode_penjualan.val() && i != index) {
                    $('#tbl_trx tbody tr:eq(' + i + ')').remove()
                }
            })

            let data_trx = `<td></td>
                <td>
                    ${kode_penjualan.html()}
                    <input type="hidden" class="kode_penjualan_hidden" name="kode_penjualan[]" value="${kode_penjualan.val()}">
                </td>
                <td>
                    ${tgl_penjualan}
                    <input type="hidden" class="tgl_penjualan_hidden" name="tgl_penjualan[]" value="${tgl_penjualan}">
                </td>
                                    <td>
                                        ${pelanggan}
                                        <input type="hidden" class="pelanggan_hidden" name="pelanggan[]" value="${pelanggan}">
                                    </td>
                                    <td>${matauang}
                                        <input type="hidden" class="matauang_hidden" name="matauang[]" value="${matauang}">
                                    </td>
                                    <td>${format_ribuan(piutang)}
                                        <input type="hidden" class="piutang_hidden" name="piutang[]" value="${piutang}">
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

            hitung_total_piutang()

            generate_nomer()

            cek_form_entry()

            $('#bayar').val('')
            $('#btn_simpan').prop('disabled', true)
        })

        $('#kode_penjualan').change(function() {
            $('#btn_update').prop('disabled', true)
            $('#btn_add').prop('disabled', true)
            $('#btn_clear_form').prop('disabled', true)

            $.ajax({
                url: "/keuangan/pelunasan-piutang/get-penjualan-belum-lunas/" + $(this).val(),
                type: 'GET',
                success: function(data) {
                    $('#pelanggan').val('Loading...')
                    $('#piutang').val('Loading...')
                    $('#matauang').val('Loading...')
                    $('#tgl_penjualan').val('Loading...')

                    setTimeout(() => {
                        let format = new Date(data.tanggal)

                        $('#pelanggan').val(data.pelanggan ? data.pelanggan.nama_pelanggan :
                            'Tanpa pelanggan')
                        $('#piutang').val(data.total_netto)
                        $('#matauang').val(data.matauang.nama)
                        $('#tgl_penjualan').val(format.toLocaleDateString('id-ID'))

                        cek_form_entry()
                    }, 1000)
                }
            })
        })

        $('#bank').change(function() {
            if ($('#jenis_pembayaran').val() == 'Transfer') {
                get_rekening()
            }
        })

        $('#tanggal').change(function() {
            get_kode()
        })

        $(document).on('click', '.btn_edit', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            let kode_penjualan = $('.kode_penjualan_hidden:eq(' + index + ')').val()
            let pelanggan = $('.pelanggan_hidden:eq(' + index + ')').val()
            let tgl_penjualan = $('.tgl_penjualan_hidden:eq(' + index + ')').val()
            let matauang = $('.matauang_hidden:eq(' + index + ')').val()
            let piutang = $('.piutang_hidden:eq(' + index + ')').val()

            $('#kode_penjualan option[value="' + kode_penjualan + '"]').attr('selected', 'selected')
            $('#pelanggan').val(pelanggan)
            $('#tgl_penjualan').val(tgl_penjualan)
            $('#matauang').val(matauang)
            $('#piutang').val(piutang)

            $('#btn_add').hide()
            $('#btn_update').show()

            $('#index_tr').val(index)

            $('#btn_update').prop('disabled', false)
            $('#btn_clear_form').prop('disabled', false)
        })

        $('#jenis_pembayaran, #bayar').on('keyup change', function() {
            let jenis_pembayaran = $('#jenis_pembayaran')
            let bank = $('#bank')
            let rekening = $('#rekening')
            let no_cek_giro = $('#no_cek_giro')
            let tgl_cek_giro = $('#tgl_cek_giro')
            let bayar = $('#bayar')
            let total_piutang = $('#total_piutang_hidden')

            // kalo cash, bank dan giro boleh kosong
            if (jenis_pembayaran.val() == 'Cash') {
                bank.prop('disabled', true)
                rekening.prop('disabled', true)
                no_cek_giro.prop('disabled', true)
                tgl_cek_giro.prop('disabled', true)

                bank.val('')
                no_cek_giro.val('')
                tgl_cek_giro.val('')
                rekening.html('<option value="" disabled selected>-- Pilih Bank terlebih dahulu --</option>')

                if (parseFloat(bayar.val()) && parseFloat(bayar.val()) >= parseFloat(total_piutang.val())) {
                    $('#btn_simpan').prop('disabled', false)
                    // $('#btn_clear_form_payment').prop('disabled', false)
                } else {
                    $('#btn_simpan').prop('disabled', true)
                    // $('#btn_clear_form_payment').prop('disabled', true)
                }

                bank.prop('required', false)
                rekening.prop('required', false)
                no_cek_giro.prop('required', false)
                tgl_cek_giro.prop('required', false)
            }

            if (jenis_pembayaran.val() == 'Transfer') {
                bank.prop('disabled', false)
                rekening.prop('disabled', false)

                no_cek_giro.prop('disabled', true)
                no_cek_giro.val('')
                tgl_cek_giro.prop('disabled', true)
                tgl_cek_giro.val('')

                if (parseFloat(bayar.val()) && parseFloat(bayar.val()) >= parseFloat(total_piutang.val()) && bank
                    .val() && rekening.val()) {
                    $('#btn_simpan').prop('disabled', false)
                    // $('#btn_clear_form_payment').prop('disabled', false)
                } else {
                    $('#btn_simpan').prop('disabled', true)
                    // $('#btn_clear_form_payment').prop('disabled', true)
                }

                bank.prop('required', true)
                rekening.prop('required', true)
            }

            if (jenis_pembayaran.val() == 'Giro') {
                rekening.prop('disabled', true)
                rekening.html('<option value="" disabled selected>-- Pilih Bank terlebih dahulu --</option>')

                bank.prop('disabled', false)
                no_cek_giro.prop('disabled', false)
                tgl_cek_giro.prop('disabled', false)

                if (parseFloat(bayar.val()) && parseFloat(bayar.val()) >= parseFloat(total_piutang.val()) &&
                    no_cek_giro.val() &&
                    bank.val() &&
                    tgl_cek_giro.val()) {
                    $('#btn_simpan').prop('disabled', false)
                    // $('#btn_clear_form_payment').prop('disabled', false)
                } else {
                    $('#btn_simpan').prop('disabled', true)
                    // $('#btn_clear_form_payment').prop('disabled', true)
                }

                bank.prop('required', true)
                no_cek_giro.prop('required', true)
                tgl_cek_giro.prop('required', true)
            }
        })

        $(document).on('click', '.btn_hapus', function(e) {
            e.preventDefault()

            $(this).parent().parent().remove()

            generate_nomer()
            hitung_total_piutang()
            cek_table_length()

            $('#bayar').val('')
            $('#btn_simpan').prop('disabled', true)
        })

        $('#btn_clear_form').click(function() {
            $(this).prop('disabled', true)
            $('#btn_update').prop('disabled', true)
            $('#btn_add').prop('disabled', true)

            clear_form_entry()
            cek_table_length()
        })

        $('#btn_simpan').click(function() {
            $(this).prop('disabled', true)
            $(this).text('loading...')

            let data = {
                kode: $('#kode').val(),
                tanggal: $('#tanggal').val(),
                rate: $('#rate').val(),
                penjualan_id: $('input[name="kode_penjualan[]"]').map(function() {
                    return $(this).val()
                }).get(),
                jenis_pembayaran: $('#jenis_pembayaran').val(),
                bank: $('#bank').val(),
                rekening: $('#rekening').val(),
                no_cek_giro: $('#no_cek_giro').val(),
                tgl_cek_giro: $('#tgl_cek_giro').val(),
                bayar: $('#bayar').val(),
                keterangan: $('#keterangan').val(),
            }

            $.ajax({
                type: 'PUT',
                url: '{{ route('pelunasan-piutang.update', $pelunasanPiutang->id) }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Update data',
                        text: 'Berhasil'
                    }).then(function() {
                        setTimeout(() => {
                            window.location = '{{ route('pelunasan-piutang.index') }}'
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

        function get_rekening() {
            $.ajax({
                url: "/jual/penjualan/get-rekening/" + $('#bank').val(),
                type: 'GET',
                success: function(data) {
                    let rekening = []

                    $('#rekening').prop('disabled', true)
                    $('#rekening').html(
                        '<option value="" disabled selected>Loading...</option>')

                    setTimeout(() => {
                        if (data.length > 0) {
                            data.forEach(elm => {
                                rekening.push(
                                    `<option value="${elm.id}">${elm.nomor_rekening} - ${elm.nama_rekening}</option>`
                                )
                            })

                            $('#rekening').html(rekening)

                            $('#rekening').prop('disabled', false)

                            if (selected_rekening) {
                                $('#rekening option[value=' + selected_rekening + ']').attr('selected',
                                    'selected')
                            }
                        } else {
                            $('#rekening').html(
                                '<option value="" disabled selected>-- No.Rekening tidak ditemukan --</option>'
                            )
                        }
                    }, 1000);
                }
            })
        }

        function hitung_total_piutang() {
            let total_piutang = 0

            $('.piutang_hidden').each(function() {
                total_piutang += parseInt($(this).val())
            })

            $('#total_piutang').val(format_ribuan(total_piutang))
            $('#total_piutang_hidden').val(total_piutang)
        }

        function get_kode() {
            $.ajax({
                url: "/keuangan/pelunasan-piutang/generate-kode/" + $('input[name="tanggal"]').val(),
                type: 'GET',
                success: function(data) {
                    $('input[name="kode"]').val('Loading...')

                    setTimeout(() => {
                        $('input[name="kode"]').val(data)
                    }, 1000)
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

        function clear_form_entry() {
            $('#kode_penjualan option[value=""]').attr('selected', 'selected')
            $('#tgl_penjualan').val('')
            $('#pelanggan').val('')
            $('#matauang').val('')
            $('#piutang').val('')

            $('#btn_update').hide()
            $('#btn_add').show()
        }

        // hitung jumlan <tr> pada table#tbl_trx
        function cek_table_length() {
            let total = $('#tbl_trx tbody tr').length

            if (total > 0) {
                $('#btn_simpan').prop('disabled', false)
                // $('#btn_clear_table').prop('disabled', false)
            } else {
                $('#btn_simpan').prop('disabled', true)
                // $('#btn_clear_table').prop('disabled', true)
            }
        }

        function cek_form_entry() {
            if (
                !$('#kode_penjualan').val() ||
                !$('#tgl_penjualan').val() ||
                !$('#pelanggan').val() ||
                !$('#matauang').val() ||
                !$('#piutang').val()
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
    </script>
@endpush
