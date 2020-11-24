<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT OPNAME STOK</b></h5>
    </div>
</div>

<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>opname/insert_opname">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Kode Saldo</label>
                        <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                            <input class="form-control form-control-sm" readonly value="<?php echo $getdata['kode_opname']; ?>" id="kode_opname" name="kode_opname" placeholder="Kode Saldo Awal">
                            <input type="hidden" readonly id="getsa" name="getsa" value="0" class="form-control" />
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Bulan</label>
                        <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                            <select class="selectize" required id="bulan" name="bulan">
                                <option value="">Bulan</option>
                                <?php for ($a = 1; $a <= 12; $a++) { ?>
                                    <option <?php if ($getdata['bulan'] == $a) {
                                                echo "selected";
                                            } ?> value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Tahun</label>
                        <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                            <select class="selectize" required id="tahun" name="tahun">
                                <option value="">Tahun</option>
                                <?php for ($t = 2020; $t <= $tahun; $t++) { ?>
                                    <option <?php if ($getdata['tahun'] == $t) {
                                                echo "selected";
                                            } ?> value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Tgl Input</label>
                        <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                            <input type="text" autocomplete="off" name="tgl_transaksi" id="tgl_transaksi" value="<?php echo $getdata['tgl_transaksi']; ?>" placeholder="Tanggal Transaksi" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="2" />
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
                        <div class="col-md-2" style="padding-left:7px;padding-right:0px">
                            <input class="form-control form-control-sm" readonly autocomplete="off" id="kode_barang" name="kode_barang" placeholder="Kode Barang">
                        </div>
                        <div class="col-md-5" style="padding-left:7px;padding-right:0px">
                            <input class="form-control form-control-sm" readonly id="nama_barang" name="nama_barang" placeholder="Nama Barang">
                        </div>
                        <div class="col-md-2" style="padding-left:7px;padding-right:0px">
                            <input class="form-control form-control-sm" readonly id="satuan" name="satuan" placeholder="Satuan">
                        </div>
                        <div class="col-md-2" style="padding-left:7px;padding-right:0px">
                            <input class="form-control form-control-sm" autocomplete="off" id="qty" name="qty" placeholder="Jumlah" tabindex="3">
                        </div>
                        <div hidden class="col-md-1" style="padding-left:7px;padding-right:0px;color:white">
                            <a class="btn btn-sm btn-success btn-block" href="#" id="getsaldo" tabindex="8"><i class="fa fa-save"></i></a>
                        </div>
                        <div class="col-md-1" style="padding-left:7px;padding-right:0px;color:white">
                            <a class="btn btn-sm btn-info btn-block" href="#" id="simpanopname" tabindex="8"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="padding-left:7px;padding-right:0px">
                            <div class="table-responsive mb-0">
                                <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                                    <thead style="background-color: #0085cd;color:white">
                                        <tr>
                                            <th style="width: 10%;">Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th style="width: 10%;">Satuan</th>
                                            <th style="width: 10%;">Qty</th>
                                            <th style="width: 10%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="loaddetailopname" style="font-size: 13px;">

                                    </tbody>

                                </table>
                            </div>

                            <div class="mt-4 d-flex justify-content-end">
                                <input type="submit" name="submit" class="btn btn-block btn-sm btn-primary" value="Simpan">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function() {

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

        view_detailopname();

        function view_detailopname() {

            var kode_opname = $("#kode_opname").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>opname/view_opname_detail',
                data: {
                    kode_opname: kode_opname
                },
                cache: false,
                success: function(respond) {
                    $("#loaddetailopname").html(respond);
                }
            });
        }

        $('#qty').on("input", function() {
            var qty = $('#qty').val();
            var qty = qty.replace(/[^\d]/g, "");
            $('#qty').val(formatAngka(qty * 1));
        });

        $('#simpanopname').click(function(e) {
            e.preventDefault();
            var kode_opname = $('#kode_opname').val();
            var kode_barang = $('#kode_barang').val();
            var qty = $('#qty').val();
            var bulan = $('#bulan').val();
            var tgl_transaksi = $('#tgl_transaksi').val();

            if (kode_barang == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
            } else if (bulan == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Bulan terlebih dahulu', 'warning')
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
            } else if (qty == "") {
                Swal.fire('Oppss..', 'Qty tidak boleh kosong', 'warning')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>opname/insert_opname_detail',
                    data: {
                        kode_opname: kode_opname,
                        kode_barang: kode_barang,
                        qty: qty
                    },
                    cache: false,
                    success: function(respond) {
                        view_detailopname();
                        $('#kode_barang').val("");
                        $('#nama_barang').val("");
                        $('#satuan').val("");
                        $('#qty').val("");
                    }
                });
            }
        });

    });
</script>