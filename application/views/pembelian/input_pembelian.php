<style>
    div.scrolled {
        width: 100%;
        height: 450px;
        overflow: auto;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT PEMBELIAN</b></h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">No Faktur</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="no_fak_pemb" name="no_fak_pemb" placeholder="Faktur Pembelian">
                        <input type="hidden" class="form-control form-control-sm" value="0" id="kode_edit" name="kode_edit" >
                        <?php
                        if ($this->uri->segment(3) != "") {
                            $no_po = $this->uri->segment(3);
                        } else {
                            $no_po = "-";
                        }
                        ?>
                        <input type="hidden" autocomplete="off" value="<?php echo $no_po; ?>" name="no_po" id="no_po" placeholder="No PO" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="2" />
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
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Tgl Transaksi</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" name="tgl_transaksi" id="tgl_transaksi" placeholder="Tanggal Transaksi" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="2" />
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
                        <a class="btn btn-info btn-sm btn-block caribarang" href="#" tabindex="3">Cari</a>
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="kode_barang" name="kode_barang" placeholder="Kode" tabindex="4">
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="nama_barang" name="nama_barang" placeholder="Nama Barang">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="satuan" name="satuan" placeholder="Satuan">
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="ket" name="ket" placeholder="Keterangan" tabindex="4">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm  datepicker-here" autocomplete="off" style="text-align:right" id="exp_date" name="exp_date" placeholder="Exp Date" data-language="en" tabindex="5">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" style="text-align:right" id="harga_modal" name="harga_modal" placeholder="Harga Modal" tabindex="5">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="qty" name="qty" placeholder="Jumlah" tabindex="6">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="total" style="text-align:right" name="total" placeholder="Total">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px;color:white">
                        <a class="btn btn-sm btn-info btn-block" id="inputbarang" href="#" tabindex="8"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="padding-left:2px;padding-right:0px">
                        <div class="table-responsive mb-0">
                            <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                                <thead style="background-color: #0085cd;color:white">
                                    <tr>
                                        <th style="width: 5%;">Kode</th>
                                        <th>Nama</th>
                                        <th style="width: 5%;">Satuan</th>
                                        <th>Keterangan</th>
                                        <th style="width: 10%;">Exp Date</th>
                                        <th style="width: 10%;text-align:right;">Harga</th>
                                        <th style="width: 10%;text-align:center;">Jumlah</th>
                                        <th style="width: 10%;text-align:right;">Total</th>
                                        <th style="width: 5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadpembeliantemp" style="font-size: 13px;">

                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
    </div>
    <div class="col-sm-4" id="pembayaran">
        <div class="card">
            <div class="card-body">
                <!-- <h5 style="text-align: center;" colspan="4">PEMBAYARAN</h5> -->
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Subtotal</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="subtotal" name="subtotal" style="text-align: right;" placeholder="Jumlah Bayar">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Potongan</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="potongan" name="potongan" style="text-align: right;" placeholder="Potongan" tabindex="11">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Sisa Bayar</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="sisabayar" name="sisabayar" style="text-align: right;" placeholder="Sisa Bayar">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Keterangan</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" id="keterangan" name="keterangan" placeholder="Keterangan" tabindex="13">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Jenis Transaksi</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <select class="form-control form-control-sm" id="jenis_transaksi" name="jenis_transaksi" tabindex="14">
                            <option value="Tunai">Tunai</option>
                            <option value="Kredit">Kredit</option>
                        </select>
                    </div>
                </div>
                <?php if ($this->uri->segment(3) == "") { ?>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">PPN</label>
                        <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                            <select class="form-control form-control-sm" id="ppn" name="ppn" tabindex="15">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                <?php } else { ?>
                    <input type="hidden" class="form-control form-control-sm" id="ppn" name="ppn" placeholder="PPN" value="<?php echo $this->uri->segment(5);?>">
                <?php } ?>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Konfirmasi</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <a class="btn btn-sm btn-primary btn-block" href="#" id="inputpembelian" tabindex="16"><i class="fa  fa-save"></i> Simpan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewbarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loadbarang">

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

        view_pembeliantemp();

        function view_pembeliantemp() {

            var no_po = $('#no_po').val();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/view_pembelian_temp',
                data: {
                    no_po: no_po
                },
                cache: false,
                success: function(respond) {
                    $("#loadpembeliantemp").html(respond);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/codeotomatis',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#no_fak_pemb").val(respond);
                }
            });
        }

        $('.caribarang').click(function(e) {
            e.preventDefault();
            var kode_supplier = $('#kode_supplier').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            if (kode_supplier == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Supplier terlebih dahulu', 'warning')
                return false;
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembelian/view_barang',
                    data: '',
                    cache: false,
                    success: function(respond) {
                        $("#loadbarang").html(respond);
                        $("#viewbarang").modal("show");
                    }
                });
            }
        });

        $('#harga_modal').on("input", function() {
            var harga_modal = $('#harga_modal').val();
            var harga_modal = harga_modal.replace(/[^\d]/g, "");
            $('#harga_modal').val(formatAngka(harga_modal * 1));
        });

        $('#qty').on("input", function() {
            var qty = $('#qty').val();
            var qty = qty.replace(/[^\d]/g, "");
            $('#qty').val(formatAngka(qty * 1));
        });

        $('#qty,#harga_modal').on("input", function() {
            var qty = $('#qty').val();
            var harga_modal = $('#harga_modal').val();

            var qty = qty.replace(/[^\d]/g, "");
            var harga_modal = harga_modal.replace(/[^\d]/g, "");

            var hasiltotal = qty * harga_modal;

            $('#total').val(formatAngka(hasiltotal * 1));
        });

        $('#potongan').on("input", function() {

            var potongan = $('#potongan').val();
            var subtotal = $('#subtotal').val();
            var sisabayar = $('#sisabayar').val();

            var sisabayar = sisabayar.replace(/[^\d]/g, "");
            var subtotal = subtotal.replace(/[^\d]/g, "");
            var potongan = potongan.replace(/[^\d]/g, "");


            $('#potongan').val(formatAngka(potongan * 1));

            var sisabayar = subtotal - potongan;
            if (sisabayar < 1) {
                var sisabayar = 0;
            } else {
                var sisabayar = subtotal - potongan;
            }

            potonganlebih = subtotal - potongan;
            if (potonganlebih < 0) {
                Swal.fire('Oppss..', 'Potongan Melebihi Total', 'warning')
                $('#sisabayar').val(formatAngka(subtotal));
                $('#potongan').val(0);
            } else {
                $('#sisabayar').val(formatAngka(sisabayar));
            }

        });

        $('#inputbarang').click(function(e) {
            e.preventDefault();
            var kode_barang = $('#kode_barang').val();
            var qty = $('#qty').val();
            var harga_modal = $('#harga_modal').val();
            var total = $('#total').val();
            var keterangan = $('#ket').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            var kode_edit = $('#kode_edit').val();
            var exp_date = $('#exp_date').val();
            var kode_supplier = $('#kode_supplier').val();

            if (kode_barang == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
            } else if (kode_supplier == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Supllier terlebih dahulu', 'warning')
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
            } else if (exp_date == "") {
                Swal.fire('Oppss..', 'Exp Date tidak boleh kosong', 'warning')
            } else if (qty == "") {
                Swal.fire('Oppss..', 'Qty tidak boleh kosong', 'warning')
            } else if (harga_modal == "") {
                Swal.fire('Oppss..', 'Harga Modal tidak boleh kosong', 'warning')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembelian/insert_pembelian_temp',
                    data: {
                        kode_barang: kode_barang,
                        exp_date: exp_date,
                        qty: qty,
                        kode_edit: kode_edit,
                        harga_modal: harga_modal,
                        total: total,
                        keterangan: keterangan
                    },
                    cache: false,
                    success: function(respond) {
                        view_pembeliantemp();
                        $('#ket').val("");
                        $('#kode_barang').val("");
                        $('#exp_date').val("");
                        $('#nama_barang').val("");
                        $('#kode_edit').val(0);
                        $('#qty').val("");
                        $('#harga_modal').val("");
                        $('#total').val("");
                    }
                });
            }
        });

        $('#inputpembelian').click(function(e) {
            e.preventDefault();
            var keterangan = $('#keterangan').val();
            var subtotal = $('#subtotal').val();
            var potongan = $('#potongan').val();
            var no_po = $('#no_po').val();
            var jenis_transaksi = $('#jenis_transaksi').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            var kode_supplier = $('#kode_supplier').val();
            var ppn = $('#ppn').val();
            if (subtotal == "0") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
                return false;
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembelian/insert_pembelian',
                    data: {
                        keterangan: keterangan,
                        potongan: potongan,
                        no_po: no_po,
                        subtotal: subtotal,
                        tgl_transaksi: tgl_transaksi,
                        jenis_transaksi: jenis_transaksi,
                        kode_supplier: kode_supplier,
                        ppn: ppn
                    },
                    cache: false,
                    success: function(respond) {
                        Swal.fire('Oppss..', 'Berhasil di Simpan', 'success')
                        window.location.href = "<?php echo base_url(); ?>pembelian/input_pembelian";
                    }
                });
            }
        });

    });
</script>