<style>
    div.scrolled {
        width: 100%;
        height: 450px;
        overflow: auto;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT PEMBAYARAN PIUTANG</b></h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="nobukti" name="nobukti" placeholder="No Bukti">
                        <input type="hidden" class="form-control form-control-sm" value="0" id="kode_edit" name="kode_edit">
                    </div>
                    <div class="col-md-4" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autofocus id="nama_pelanggan" name="nama_pelanggan" placeholder="Nama Pelanggan" tabindex="1">
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="kode_pelanggan" name="kode_pelanggan" placeholder="Kode Pelanggan">
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <select class="form-control form-control-sm" id="jenis_pembayaran" name="jenis_pembayaran" tabindex="2">
                            <option value="">-- Pilih Jenis Pembayaran --</option>
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" name="tgl_bayar" id="tgl_bayar" placeholder="Tanggal Bayar" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="3" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="no_fak_penj" name="no_fak_penj" placeholder="No Faktur" tabindex="4">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="total" name="total" placeholder="Total">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="potongan" name="potongan" placeholder="Potongan">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="bayar" name="bayar" placeholder="Bayar">
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly autocomplete="off" id="sisa_bayar" name="sisa_bayar" placeholder="Sisa Bayar">
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" style="text-align:right" id="jumlah_bayar" name="jumlah_bayar" placeholder="Jumlah Bayar" tabindex="5">
                    </div>
                    <div class="col-md-3" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" style="text-align:right" id="keterangan" name="keterangan" placeholder="Keterangan" tabindex="6">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px;color:white">
                        <a class="btn btn-sm btn-info btn-block" id="inputfaktur" href="#" tabindex="7"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="padding-left:2px;padding-right:0px">
                        <div class="table-responsive mb-0">
                            <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                                <thead style="background-color: #0085cd;color:white">
                                    <tr>
                                        <th style="width: 10%;">No Faktur</th>
                                        <th>Keterangan</th>
                                        <th style="width: 15%;text-align:right;">Jumlah Bayar</th>
                                        <th style="width: 5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadpembayarantemp" style="font-size: 13px;">

                                </tbody>

                            </table>
                        </div>
                        <br>
                        <a class="btn btn-sm btn-primary btn-block" href="#" id="inputpembayaran" tabindex="8"><i class="fa  fa-save"></i> Simpan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

        view_pembayarantemp();

        function view_pembayarantemp() {

            var kode_pelanggan = $('#kode_pelanggan').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembayaran/view_pembayaran_piutang_temp',
                data: {
                    kode_pelanggan: kode_pelanggan
                },
                cache: false,
                success: function(respond) {
                    $("#loadpembayarantemp").html(respond);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembayaran/codeotomatispemb',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#nobukti").val(respond);
                }
            });
        }

        $('#nama_pelanggan').autocomplete({
            serviceUrl: "<?php echo base_url(); ?>pembayaran/get_pelanggan/",
            onSelect: function(suggestions) {
                $('#nama_pelanggan').val(suggestions.nama_pelanggan);
                $('#kode_pelanggan').val(suggestions.kode_pelanggan);

                var kode_pelanggan = suggestions.kode_pelanggan;

                $('#no_fak_penj').autocomplete({
                    serviceUrl: "<?php echo base_url(); ?>pembayaran/get_faktur_penjualan/" + kode_pelanggan,
                    onSelect: function(suggestions) {

                        $('#total').val(formatAngka(suggestions.total));
                        $('#potongan').val(formatAngka(suggestions.potongan));
                        $('#bayar').val(formatAngka(suggestions.jumlahbayar));
                        $('#sisa_bayar').val(formatAngka(suggestions.total - suggestions.potongan - suggestions.jumlahbayar));
                        $('#jumlah_bayar').val(formatAngka(suggestions.total - suggestions.potongan - suggestions.jumlahbayar));
                        // $('#stok').val(formatAngka(suggestions.stok));
                        view_pembayarantemp();
                    }
                });

            }
        });


        $('#jumlah_bayar').on("input", function() {
            var sisa_bayar = $('#sisa_bayar').val();
            var jumlah_bayar = $('#jumlah_bayar').val();
            var total = $('#total').val();
            var bayar = $('#bayar').val();

            var jumlah_bayar = jumlah_bayar.replace(/[^\d]/g, "");
            var total = total.replace(/[^\d]/g, "");
            var bayar = bayar.replace(/[^\d]/g, "");
            var sisa_bayar = sisa_bayar.replace(/[^\d]/g, "");
            $('#jumlah_bayar').val(formatAngka(jumlah_bayar * 1));

            sisa_bayar = total - bayar;

            if (jumlah_bayar > sisa_bayar) {
                $('#jumlah_bayar').val(formatAngka(sisa_bayar * 1));
                Swal.fire('Oppss..', 'Jumlah Bayar melebihi Sisa Bayar', 'warning')
            }

        });

        $('#inputfaktur').click(function(e) {
            e.preventDefault();
            var no_fak_penj = $('#no_fak_penj').val();
            var jumlah_bayar = $('#jumlah_bayar').val();
            var keterangan = $('#keterangan').val();
            var tgl_bayar = $('#tgl_bayar').val();
            var kode_edit = $('#kode_edit').val();
            var kode_pelanggan = $('#kode_pelanggan').val();

            if (no_fak_penj == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Faktur terlebih dahulu', 'warning')
            } else if (kode_pelanggan == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Supllier terlebih dahulu', 'warning')
            } else if (tgl_bayar == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
            } else if (jumlah_bayar == "") {
                Swal.fire('Oppss..', 'Jumlah Bayar tidak boleh kosong', 'warning')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembayaran/insert_pembayaran_piutang_temp',
                    data: {
                        no_fak_penj: no_fak_penj,
                        jumlah_bayar: jumlah_bayar,
                        kode_edit: kode_edit,
                        keterangan: keterangan
                    },
                    cache: false,
                    success: function(respond) {
                        view_pembayarantemp();
                        $('#no_fak_penj').val("");
                        $('#sisa_bayar').val("");
                        $('#jumlah_bayar').val("");
                        $('#bayar').val("");
                        $('#total').val("");
                        $('#potongan').val("");
                        $('#keterangan').val("");
                        $('#kode_edit').val(0);
                    }
                });
            }
        });

        $('#inputpembayaran').click(function(e) {
            e.preventDefault();
            var total = $('#totals').text();
            var no_fak_penj = $('#no_fak_penj').val();
            var keterangan = $('#keterangan').val();
            var jenis_pembayaran = $('#jenis_pembayaran').val();
            var tgl_bayar = $('#tgl_bayar').val();
            var kode_pelanggan = $('#kode_pelanggan').val();
            var ppn = $('#ppn').val();
            if (total == "0") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
                return false;
            } else if (kode_pelanggan == "") {
                Swal.fire('Oppss..', 'Pilih pelanggan terlebih dahulu', 'warning')
                return false;
            } else if (jenis_pembayaran == "") {
                Swal.fire('Oppss..', 'Pilih Jenis Pembayaran terlebih dahulu', 'warning')
                return false;
            } else if (tgl_bayar == "") {
                Swal.fire('Oppss..', 'Tanggal bayar tidak boleh kosong', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembayaran/insert_pembayaran_piutang',
                    data: {
                        no_fak_penj: no_fak_penj,
                        keterangan: keterangan,
                        total: total,
                        tgl_bayar: tgl_bayar,
                        jenis_pembayaran: jenis_pembayaran,
                        kode_pelanggan: kode_pelanggan
                    },
                    cache: false,
                    success: function(respond) {
                        Swal.fire('Oppss..', 'Berhasil di Simpan', 'success')
                        window.location.href = "<?php echo base_url(); ?>pembayaran/view_pembayaran_piutang";
                    }
                });
            }
        });

        $(document).on('keyup', 'body', function(e) {
            e.preventDefault();
            var charCode = (e.which) ? e.which : event.keyCode;

            if (charCode == 37) {
                $('#no_fak_penj').focus();
            }

            if (charCode == 39) {
                $('#keterangan').focus();
            }

            if (charCode == 46) {
                clear();
            }

            if (charCode == 16) {
                // $('#kode_barang').focus();
            }
        });

        document.onkeyup = function(e) {
            var evt = window.event || e;

            if (evt.keyCode == 13 && evt.ctrlKey) {

                $('#simpan').click();

            }

        }
    });
</script>