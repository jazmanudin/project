<div class="row container-grid scrolled">
    <?php foreach ($barang->result() as $b) { ?>
        <div class="col-xl-3 col-md-4 col-sm-6 branding designing">
            <?php if ($b->foto != "") { ?>
                <a href="#" class="inputbarang" data-kode="<?php echo $b->kode_barang; ?>" data-harga="<?php echo $b->harga; ?>"><img class="gallery-demo-img img-fluid mx-auto" src="<?php echo base_url(); ?>assets/images/barang/<?php echo $b->foto; ?>" /></a>
            <?php } else { ?>
                <a href="#" class="inputbarang" data-kode="<?php echo $b->kode_barang; ?>" data-harga="<?php echo $b->harga; ?>"><img class="gallery-demo-img img-fluid mx-auto" src="../assets/images/small/img-11.jpg" /></a>
            <?php } ?>
            <div class="gallery-overlay">
                <div class="overlay-content">
                    <h4 align="center" class="inputbarang" style="font-size: 14px;margin-top:5px;margin-bottom:2px">Rp. <?php echo number_format($b->harga, 2); ?></h4>
                    <h5 align="center" class="inputbarang" style="font-size: 14px;"><?php echo $b->nama_barang; ?></h5>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    $(document).ready(function() {

        function view_penjualantemp() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/view_penjualan_temp',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#loadpenjualantemp").html(respond);
                }
            });
        }

        $('.inputbarang').click(function(e) {
            e.preventDefault();
            var kode_barang = $(this).attr('data-kode');
            var harga = $(this).attr('data-harga');
            var qty = "1";
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/insert_penjualan_temp',
                data: {
                    kode_barang: kode_barang,
                    qty: qty,
                    harga: harga
                },
                cache: false,
                success: function(respond) {
                    view_penjualantemp();
                }
            });
        });

    });
</script>