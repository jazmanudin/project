<style>
    div.scrolled {
        width: 100%;
        height: 450px;
        overflow: auto;
    }
</style>
<div class="row">
    <div class="col-xl-8 col-md-7 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <ul class="col list-inline gallery-categories-filter text-center">
                        <li class="list-inline-item"><a class="categories btn active filterkategori" data-filter="">All</a></li>
                        <?php foreach ($kategori->result() as $k) { ?>
                            <li class="list-inline-item"><a class="categories active btn filterkategori" data-filter="<?php echo $k->kode_kategori; ?>"><?php echo $k->nama_kategori; ?></a></li>
                        <?php } ?>
                    </ul>
                    <!-- Tab panes -->
                    <h6 id="loadviewbarang">

                    </h6>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-5 col-sm-6">
        <div class="card">
            <div class="card-body">
                <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                    <thead class="thead-dark" style="font-size: 13px;">
                        <tr>
                            <th>Nama</th>
                            <th style="width: 25%;">Harga</th>
                            <th style="width: 20%;">Jumlah</th>
                            <th style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="loadpenjualantemp" style="font-size: 13px;">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        view_barang();
        view_penjualantemp();

        function view_barang() {
            var kode_kategori = $(this).attr('data-filter');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>Penjualan/view_barang',
                data: {
                    kode_kategori: kode_kategori
                },
                cache: false,
                success: function(respond) {
                    $("#loadviewbarang").html(respond);
                }
            });
        }

        function view_penjualantemp() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>Penjualan/view_penjualan_temp',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#loadpenjualantemp").html(respond);
                }
            });
        }

        $('.filterkategori').click(function(e) {
            e.preventDefault();
            var kode_kategori = $(this).attr('data-filter');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>Penjualan/view_barang',
                data: {
                    kode_kategori: kode_kategori
                },
                cache: false,
                success: function(respond) {
                    $("#loadviewbarang").html(respond);
                }
            });
        });


    });
</script>