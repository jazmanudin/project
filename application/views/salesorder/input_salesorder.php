<style>
    div.scrolled {
        width: 100%;
        height: 450px;
        overflow: auto;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT SALES ORDER</b></h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">No PO</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="no_so" name="no_so" placeholder="No PO">
                        <input type="hidden" autocomplete="off" name="kode_edit" id="kode_edit" value="0" class="form-control form-control-sm" />
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Pelanggan</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <select class="selectize" id="kode_pelanggan" name="kode_pelanggan" tabindex="1">
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php foreach ($pelanggan->result() as $s) { ?>
                                <option value="<?php echo $s->kode_pelanggan; ?>"><?php echo $s->nama_pelanggan; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Sales</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <input type="hidden" autocomplete="off" name="id_sales" id="id_sales" class="form-control form-control-sm" />
                        <input type="text" readonly autocomplete="off" name="nama_sales" id="nama_sales" class="form-control form-control-sm" placeholder="Nama Sales"/>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:2px;padding-right:0px">Jenis Harga</label>
                    <div class="col-md-8" style="padding-left:2px;padding-right:0px">
                        <input type="text" autocomplete="off" name="jenis_harga" id="jenis_harga" class="form-control form-control-sm" placeholder="Jenis Harga"/>
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
                        <a class="btn btn-info btn-sm btn-block caribarang" href="#" tabindex="3"><i class="fa fa-search"></i> Cari</a>
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
                    <div class="col-md-1" hidden style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm datepicker-here" autocomplete="off" name="exp_date" id="exp_date" placeholder="Exp Date" data-language="en" tabindex="2" />
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" style="text-align:right" id="harga_jual" name="harga_jual" placeholder="Harga" tabindex="5">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly autocomplete="off" id="stok" name="stok" placeholder="Stok" tabindex="6">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="qty" name="qty" placeholder="Jumlah" tabindex="6">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="total" style="text-align:right" name="total" placeholder="Total">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px;color:white">
                        <a class="btn btn-info btn-sm btn-block" id="inputbarang" href="#" tabindex="7"><i class="fa fa-plus"></i> Tambah</a>
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
                                        <th style="width: 10%;text-align:right">Harga</th>
                                        <th style="width: 10%;text-align:center">Jumlah</th>
                                        <th style="width: 10%;text-align:right">Total</th>
                                        <th style="width: 5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadsalesordertemp" style="font-size: 13px;">

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
                    <label for="example-text-input" class="col-md-4 col-form-label">Subtotal</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" readonly id="subtotal" name="subtotal" style="text-align: right;" placeholder="Jumlah Bayar">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Keterangan</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" id="keterangan" name="keterangan" placeholder="Keterangan" tabindex="8">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">PPN</label>
                    <div class="col-sm-8">
                        <select class="form-control form-control-sm" id="ppn" name="ppn" tabindex="9">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Konfirmasi</label>
                    <div class="col-md-8">
                        <a class="btn btn-sm btn-primary btn-block" href="#" id="inputsalesorder" tabindex="15"><i class="fa  fa-save"></i> Simpan</a>
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

        view_salesordertemp();

        function view_salesordertemp() {

            var no_so = $('#no_so').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>salesorder/view_salesorder_temp',
                data: {
                    no_so: no_so
                },
                cache: false,
                success: function(respond) {
                    $("#loadsalesordertemp").html(respond);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>salesorder/codeotomatis',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#no_so").val(respond);
                }
            });
        }

        $('.caribarang').click(function(e) {
            e.preventDefault();
            var kode_pelanggan = $('#kode_pelanggan').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            var jatuh_tempo = $('#jatuh_tempo').val();
            if (kode_pelanggan == "") {
                Swal.fire('Oppss..', 'Silahkan pilih pelanggan terlebih dahulu', 'warning')
                return false;
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
                return false;
            } else if (jatuh_tempo == "") {
                Swal.fire('Oppss..', 'Tanggal jatuh tempo tidak boleh kosong', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>salesorder/view_barang',
                    data: '',
                    cache: false,
                    success: function(respond) {
                        $("#loadbarang").html(respond);
                        $("#viewbarang").modal("show");
                    }
                });
            }
        });

        $('#harga_jual').on("input", function() {
            var harga_jual = $('#harga_jual').val();
            var harga_jual = harga_jual.replace(/[^\d]/g, "");
            $('#harga_jual').val(formatAngka(harga_jual * 1));
        });

        $('#kode_pelanggan').change(function(e) {
            var kode_pelanggan = $('#kode_pelanggan').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>salesorder/view_idsales',
                data: {
                    kode_pelanggan: kode_pelanggan
                },
                cache: false,
                success: function(respond) {
                    $("#id_sales").val(respond);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>salesorder/view_namasales',
                data: {
                    kode_pelanggan: kode_pelanggan
                },
                cache: false,
                success: function(respond) {
                    $("#nama_sales").val(respond);
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>salesorder/view_jenisharga',
                data: {
                    kode_pelanggan: kode_pelanggan
                },
                cache: false,
                success: function(respond) {
                    $("#jenis_harga").val(respond);
                }
            });
        });

        $('#qty').on("input", function() {
            var qty = $('#qty').val();
            var qty = qty.replace(/[^\d]/g, "");
            $('#qty').val(formatAngka(qty * 1));
        });

        $('#qty,#harga_jual').on("input", function() {
            var qty = $('#qty').val();
            var stok = $('#stok').val();
            var harga_jual = $('#harga_jual').val();

            var stok = stok.replace(/[^\d]/g, "");
            var qty = qty.replace(/[^\d]/g, "");
            var harga_jual = harga_jual.replace(/[^\d]/g, "");

            var stokakhir = stok - qty;

            if (stokakhir < 0) {
                Swal.fire('Oppss..', 'Qty melebihi Stok', 'warning')
                $('#qty').val(formatAngka(stok));
            }

            var hasiltotal = qty * harga_jual;

            $('#total').val(formatAngka(hasiltotal * 1));
        });

        $('#inputbarang').click(function(e) {
            e.preventDefault();
            var kode_barang = $('#kode_barang').val();
            var qty = $('#qty').val();
            var harga_jual = $('#harga_jual').val();
            var kode_edit = $('#kode_edit').val();
            var diskon = $('#diskon').val();
            var keterangan = $('#ket').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            var id_sales = $('#id_sales').val();
            var kode_pelanggan = $('#kode_pelanggan').val();

            if (kode_barang == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
            } else if (kode_pelanggan == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Pelanggan terlebih dahulu', 'warning')
            } else if (id_sales == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Sales terlebih dahulu', 'warning')
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
            } else if (qty == "") {
                Swal.fire('Oppss..', 'Qty tidak boleh kosong', 'warning')
            } else if (harga_jual == "") {
                Swal.fire('Oppss..', 'Harga Modal tidak boleh kosong', 'warning')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>salesorder/insert_salesorder_temp',
                    data: {
                        kode_barang: kode_barang,
                        kode_edit: kode_edit,
                        qty: qty,
                        harga_jual: harga_jual,
                        keterangan: keterangan
                    },
                    cache: false,
                    success: function(respond) {
                        view_salesordertemp();
                        $('#ket').val("");
                        $('#kode_barang').val("");
                        $('#kode_edit').val(0);
                        $('#stok').val("");
                        $('#satuan').val("");
                        $('#nama_barang').val("");
                        $('#qty').val("");
                        $('#harga_jual').val("");
                        $('#total').val("");
                    }
                });
            }
        });


        $('#inputsalesorder').click(function(e) {
            e.preventDefault();
            var keterangan = $('#keterangan').val();
            var subtotal = $('#subtotal').val();
            var potongan = "0";
            var tgl_transaksi = $('#tgl_transaksi').val();
            var kode_pelanggan = $('#kode_pelanggan').val();
            var id_sales = $('#id_sales').val();
            var ppn = $('#ppn').val();
            if (subtotal == "0") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
                return false;
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
                return false;
            } else if (kode_pelanggan == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Pelanggan terlebih dahulu', 'warning')
                return false;
            } else if (id_sales == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Sales terlebih dahulu', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>salesorder/insert_salesorder',
                    data: {
                        keterangan: keterangan,
                        id_sales: id_sales,
                        potongan: potongan,
                        subtotal: subtotal,
                        tgl_transaksi: tgl_transaksi,
                        kode_pelanggan: kode_pelanggan,
                        ppn: ppn
                    },
                    cache: false,
                    success: function(respond) {
                        Swal.fire('Oppss..', 'Berhasil di Simpan', 'success')
                        location.reload();
                    }
                });
            }
        });

    });
</script>