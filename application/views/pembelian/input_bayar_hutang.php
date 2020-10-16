<div class="col-lg-12">
    <form autocomplete="off" id="form" class="pelangganForm" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>No Faktur</label>
            <input type="text" value="<?php echo $getbayar['no_fak_pemb']; ?>" name="no_fak_pemb" id="no_fak_pemb" class="form-control kosong form-control-sm" placeholder="No Fak Penj" />
        </div>
        <div class="form-group">
            <label>Sisa Bayar</label>
            <input type="text" style="text-align: right;" value="<?php echo number_format($getbayar['total'] - $getbayar['jumlahbayar']); ?>" name="sisabayar" id="sisabayar" class="form-control kosong form-control-sm" placeholder="No Fak Penj" />
        </div>
        <div class="form-group">
            <label>Jumlah Bayar</label>
            <input type="text" style="text-align: right;" value="<?php echo number_format($getbayar['total'] - $getbayar['jumlahbayar']); ?>" name="jmlbayar" id="jmlbayar" class="form-control kosong form-control-sm" placeholder="Jumlah Bayar" />
        </div>
        <div class="form-group mb-0">
            <a class="btn btn-primary btn-sm btn-block inputhutang" href="#">Simpan</a>
        </div>

    </form>
</div>

<script>
    $(document).ready(function() {

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

        $('#jmlbayar').on("input", function() {

            var jmlbayar = $('#jmlbayar').val();
            var sisabayar = $('#sisabayar').val();

            var jmlbayar = jmlbayar.replace(/[^\d]/g, "");
            var sisabayar = sisabayar.replace(/[^\d]/g, "");

            bayarlebih = sisabayar - jmlbayar;
            if (bayarlebih < 0) {
                Swal.fire('Oppss..', 'Jumlah Bayar Melebihi Sisa Bayar', 'warning')
                $('#jmlbayar').val(formatAngka(sisabayar * 1));
            } else {
                $('#jmlbayar').val(formatAngka(jmlbayar * 1));
                $('#jmlbayar').val(formatAngka(jmlbayar * 1));
            }

        });

        $('.inputhutang').click(function(e) {
            e.preventDefault();
            var no_fak_pemb = $('#no_fak_pemb').val();
            var jmlbayar = $('#jmlbayar').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/insert_hutang',
                data: {
                    no_fak_pemb: no_fak_pemb,
                    jmlbayar: jmlbayar
                },
                cache: false,
                success: function(respond) {
                    location.reload()
                }
            });
        });

    });
</script>