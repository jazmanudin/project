<style>
    div.scrolled {
        width: 100%;
        height: 450px;
        overflow: auto;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT PEMBAYARAN HUTANG</b></h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">No Bukti</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="nobukti" name="nobukti" placeholder="No Bukti">
                        <input type="hidden" class="form-control form-control-sm" value="0" id="kode_edit" name="kode_edit">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Supplier</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <select class="selectize" id="kode_supplier" name="kode_supplier" tabindex="1">
                            <option value="">-- Pilih Supplier --</option>
                            <?php foreach ($supplier->result() as $s) { ?>
                                <option <?php if ($this->uri->segment(4) == $s->kode_supplier) {
                                            echo "selected";
                                        } ?> value="<?php echo $s->kode_supplier; ?>"><?php echo $s->nama_supplier; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Jenis Pembayaran</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <select class="selectize" id="jenis_pembayaran" name="jenis_pembayaran" tabindex="2">
                            <option value="">-- Pilih Jenis Pembayaran --</option>
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Tgl Bayar</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
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
                        <a class="btn btn-info btn-sm btn-block carinofaktur" href="#" tabindex="4"><i class="fa fa-search"></i> Cari</a>
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="no_fak_pemb" name="no_fak_pemb" placeholder="No Faktur">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="total" name="total" placeholder="Total">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="bayar" name="bayar" placeholder="Bayar">
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly autocomplete="off" id="sisa_bayar" name="sisa_bayar" placeholder="Sisa Bayar">
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" style="text-align:right" id="jumlah_bayar" name="jumlah_bayar" placeholder="Jumlah Bayar" tabindex="7">
                    </div>
                    <div class="col-md-3" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" style="text-align:right" id="keterangan" name="keterangan" placeholder="Keterangan" tabindex="8">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px;color:white">
                        <a class="btn btn-sm btn-info btn-block" id="inputfaktur" href="#" tabindex="8"><i class="fa fa-plus"></i></a>
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
                        <a class="btn btn-sm btn-primary btn-block" href="#" id="inputpembayaran" tabindex="16"><i class="fa  fa-save"></i> Simpan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewfaktur" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Data Faktur pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loadfaktur">

            </div>
            <div class="modal-footer">
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

            var kode_supplier = $('#kode_supplier').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembayaran/view_pembayaran_hutang_temp',
                data: {
                    kode_supplier: kode_supplier
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

        $('#kode_supplier').change(function(e) {
            view_pembayarantemp();
        });

        $('.carinofaktur').click(function(e) {
            e.preventDefault();
            var kode_supplier = $('#kode_supplier').val();
            var tgl_bayar = $('#tgl_bayar').val();
            if (kode_supplier == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Supplier terlebih dahulu', 'warning')
                return false;
            } else if (tgl_bayar == "") {
                Swal.fire('Oppss..', 'Tanggal bayar tidak boleh kosong', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembayaran/view_faktur_pemb',
                    data: {
                        kode_supplier: kode_supplier
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadfaktur").html(respond);
                        $("#viewfaktur").modal("show");
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

            sisa_bayar = total-bayar;

            if (jumlah_bayar > sisa_bayar) {
                $('#jumlah_bayar').val(formatAngka(sisa_bayar * 1));
                Swal.fire('Oppss..', 'Jumlah Bayar melebihi Sisa Bayar', 'warning')
            }

        });

        $('#inputfaktur').click(function(e) {
            e.preventDefault();
            var no_fak_pemb = $('#no_fak_pemb').val();
            var jumlah_bayar = $('#jumlah_bayar').val();
            var keterangan = $('#keterangan').val();
            var tgl_bayar = $('#tgl_bayar').val();
            var kode_edit = $('#kode_edit').val();
            var kode_supplier = $('#kode_supplier').val();

            if (no_fak_pemb == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Faktur terlebih dahulu', 'warning')
            } else if (kode_supplier == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Supllier terlebih dahulu', 'warning')
            } else if (tgl_bayar == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
            } else if (jumlah_bayar == "") {
                Swal.fire('Oppss..', 'Jumlah Bayar tidak boleh kosong', 'warning')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembayaran/insert_pembayaran_hutang_temp',
                    data: {
                        no_fak_pemb: no_fak_pemb,
                        jumlah_bayar: jumlah_bayar,
                        kode_edit: kode_edit,
                        keterangan: keterangan
                    },
                    cache: false,
                    success: function(respond) {
                        view_pembayarantemp();
                        $('#no_fak_pemb').val("");
                        $('#sisa_bayar').val("");
                        $('#jumlah_bayar').val("");
                        $('#bayar').val("");
                        $('#total').val("");
                        $('#keterangan').val("");
                        $('#kode_edit').val(0);
                    }
                });
            }
        });

        $('#inputpembayaran').click(function(e) {
            e.preventDefault();
            var total = $('#totals').text();
            var keterangan = $('#keterangan').val();
            var jenis_pembayaran = $('#jenis_pembayaran').val();
            var tgl_bayar = $('#tgl_bayar').val();
            var kode_supplier = $('#kode_supplier').val();
            var ppn = $('#ppn').val();
            if (total == "0") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
                return false;
            } else if (kode_supplier == "") {
                Swal.fire('Oppss..', 'Pilih Supplier terlebih dahulu', 'warning')
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
                    url: '<?php echo base_url(); ?>pembayaran/insert_pembayaran_hutang',
                    data: {
                        keterangan: keterangan,
                        total: total,
                        tgl_bayar: tgl_bayar,
                        jenis_pembayaran: jenis_pembayaran,
                        kode_supplier: kode_supplier
                    },
                    cache: false,
                    success: function(respond) {
                        Swal.fire('Oppss..', 'Berhasil di Simpan', 'success')
                        window.location.href = "<?php echo base_url(); ?>pembayaran/view_pembayaran_hutang";
                    }
                });
            }
        });

    });
</script>