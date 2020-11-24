<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT SALDO AWAL</b></h5>
    </div>
</div>

<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>saldoawal/insert_saldoawal">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Kode Saldo</label>
                        <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                            <input class="form-control form-control-sm" readonly id="kode_saldoawal" name="kode_saldoawal" placeholder="Kode Saldo Awal">
                            <input type="hidden" readonly id="getsa" name="getsa" value="0" class="form-control" />
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Bulan</label>
                        <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                            <select class="selectize" required id="bulan" name="bulan">
                                <option value="">Bulan</option>
                                <?php for ($a = 1; $a <= 12; $a++) { ?>
                                    <option value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Tahun</label>
                        <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                            <select class="selectize" required id="tahun" name="tahun">
                                <option value="">Tahun</option>
                                <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
                                    <option value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Tgl Input</label>
                        <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                            <input type="text" autocomplete="off" name="tgl_transaksi" id="tgl_transaksi" value="<?php echo date('Y-m-d'); ?>" placeholder="Tanggal Transaksi" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="2" />
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px"></label>
                        <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                            <a class="btn btn-info btn-sm btn-block getsaldo" href="#" tabindex="3">Get Saldo</a>
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
                        <div class="col-md-12" style="padding-left:7px;padding-right:0px">
                            <div class="table-responsive mb-0">
                                <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                                    <thead style="background-color: #0085cd;color:white">
                                        <tr>
                                            <th style="width: 10%;">Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th style="width: 10%;">Satuan</th>
                                            <th style="width: 10%;">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody id="loaddetailsaldo" style="font-size: 13px;">

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

        function loadNoMutasi() {
            var bulan = $("#bulan").val();
            var tahun = $("#tahun").val();
            var status = "SA";
            var thn = tahun.substr(2, 2);
            if (parseInt(bulan.length) == 1) {
                var bln = "0" + bulan;
            } else {
                var bln = bulan;
            }
            var kode = status + bln + thn;
            $("#kode_saldoawal").val(kode);
        }

        function loadSaldoAwal() {
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            if (bulan == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Bulan terlebih dahulu', 'warning')
                return false;
            } else if (tahun == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Tahun terlebih dahulu', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>saldoawal/getdetailsaldo',
                    data: {
                        bulan: bulan,
                        tahun: tahun
                    },
                    cache: false,
                    success: function(respond) {
                        if (respond == 1) {
                            $("#getsa").val(0);
                            Swal.fire('Oppss..', 'Saldo Bulan Sebelumnya Belum Diset! Atau Saldo Bulan Tersebut Sudah Ada', 'warning')
                        } else {
                            $("#getsa").val(1);
                            $("#loaddetailsaldo").html(respond);
                        }
                    }
                });
            }
        }

        $('.getsaldo').click(function(e) {
            loadSaldoAwal();
        });

        $("#bulan,#tahun").change(function() {
            loadNoMutasi();
        });

    });
</script>