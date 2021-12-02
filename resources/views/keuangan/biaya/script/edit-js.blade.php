@push('custom-js')
    <script>
        hitung_grand_total()

        let selected_rekening = '{{ $biaya->rekening ? $biaya->rekening->id : '' }}'

        if ($('#bank :selected').val()) {
            $('#bank').prop('disabled', false)

            get_rekening()
        }

        $('#tanggal').change(function() {
            get_kode()
        })

        $('#kas_bank').change(function() {
            if ($(this).val() == 'Bank') {
                $('#bank').prop('disabled', false)
                $('#rekening').prop('required', true)
                $('#bank').prop('required', true)
            } else {
                $('#bank').prop('disabled', true)
                $('#bank').prop('required', false)
                $('#bank option[value=""]').attr('selected', 'selected')
                $('#rekening').prop('disabled', true)
                $('#rekening').prop('required', false)
                $('#rekening').html(
                    '<option value="" disabled selected>-- Pilih Bank terlebih dahulu --</option>')
            }
        })

        $('#bank').change(function() {
            get_rekening()
        })

        $('#btn_add').click(function() {
            let tbl_trx = $('#tbl_trx tbody')
            let jumlah = $('#jumlah').val()
            let deskripsi = $('#deskripsi').val()
            let no = $('#tbl_trx tbody tr').length + 1

            let data_trx = `<tr>
                    <td>${no}</td>
                    <td>
                        ${format_ribuan(jumlah)}
                        <input type="hidden" class="jumlah_hidden" name="jumlah[]" value="${jumlah}">
                    </td>
                    <td>
                        ${deskripsi}
                        <input type="hidden" class="deskripsi_hidden" name="deskripsi[]" value="${deskripsi}">
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

            $('#btn_simpan').prop('disabled', false)

            $('#jumlah').val('')
            $('#deskripsi').val('')

            $('#btn_add').prop('disabled', true)
            $('#btn_clear_form').prop('disabled', true)

            $('#jumlah').focus()

            hitung_grand_total()
        })

        $(document).on('click', '.btn_edit', function(e) {
            // ambil <tr> index
            let index = $(this).parent().parent().index()

            let jumlah = $('.jumlah_hidden:eq(' + index + ')').val()
            let deskripsi = $('.deskripsi_hidden:eq(' + index + ')').val()

            $('#jumlah').val(jumlah)
            $('#deskripsi').val(deskripsi)

            $('#btn_add').hide()
            $('#btn_update').show()

            $('#index_tr').val(index)

            cek_form()
        })

        $('#jumlah, #deskripsi').on('change keyup keydown', function() {
            cek_form()
        })

        $(document).on('click', '.btn_hapus', function(e) {
            $(this).parent().parent().remove()

            generate_nomer()
            cek_table_length()
            hitung_grand_total()
        })

        $('#btn_update').click(function() {
            let index = $('#index_tr').val()
            let tbl_trx = $('#tbl_trx tbody')
            let jumlah = $('#jumlah').val()
            let deskripsi = $('#deskripsi').val()

            let no = parseInt(parseInt(index) + 1)

            let data_trx = `<td>${no}</td>
                    <td>
                        ${format_ribuan(jumlah)}
                        <input type="hidden" class="jumlah_hidden" name="jumlah[]" value="${jumlah}">
                    </td>
                    <td>
                        ${deskripsi}
                        <input type="hidden" class="deskripsi_hidden" name="deskripsi[]" value="${deskripsi}">
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

            $('#btn_simpan').prop('disabled', false)

            $('#jumlah').val('')
            $('#deskripsi').val('')

            $('#btn_add').show()
            $('#btn_update').hide()

            $('#btn_add').prop('disabled', true)
            $('#btn_clear_form').prop('disabled', true)

            hitung_grand_total()
        })

        $('#btn_clear_form').click(function() {
            $('#jumlah').val('')
            $('#deskripsi').val('')

            $('#btn_add').prop('disabled', true)
            $('#btn_clear_form').prop('disabled', true)

            $('#btn_add').show()
            $('#btn_update').hide()

            $('#index_tr').val('')

            cek_form()
            cek_table_length()
        })

        function get_rekening() {
            $.ajax({
                url: "/beli/pembelian/get-rekening/" + $('#bank').val(),
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
                                $('#rekening option[value=' + selected_rekening + ']')
                                    .attr('selected', 'selected')
                            }
                        } else {
                            $('#rekening').html(
                                '<option value="" disabled selected>-- No.Rekening tidak ditemukan --</option>'
                            )
                        }
                    }, 1500);
                }
            })
        }

        function cek_form() {
            if ($('#jumlah').val() && $('#deskripsi').val()) {
                $('#btn_add').prop('disabled', false)
                $('#btn_clear_form').prop('disabled', false)
                $('#btn_update').prop('disabled', false)
            }
        }

        function get_kode() {
            $.ajax({
                url: "/keuangan/biaya/generate-kode/" + $('input[name="tanggal"]').val(),
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

        // auto generate no pada table
        function generate_nomer() {
            let no = 1
            $('#tbl_trx tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        function hitung_grand_total() {
            let total = 0

            $('.jumlah_hidden').each(function() {
                total += parseInt($(this).val())
            })

            $('#grand_total').text(`GRANDTOTAL: ${format_ribuan(total)},-`)

            $('#kode_barang_input').focus()

            $('#grand_total_input').val(total)
        }
    </script>
@endpush
