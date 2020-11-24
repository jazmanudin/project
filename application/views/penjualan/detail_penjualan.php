<div class="table-rep-plugin">
    <div class="table-responsive mb-0">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead id="datatable" style="background-color:#0085cd;color:white;">
                <tr>
                    <th>No Faktur</th>
                    <th>No SO</th>
                    <th>Tanggal Transaksi</th>
                    <th>Kode Pelanggan</th>
                    <th>Nama Pelanggan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $penj['no_fak_penj']; ?></td>
                    <td><?php echo $penj['no_so']; ?></td>
                    <td><?php echo $penj['tgl_transaksi']; ?></td>
                    <td><?php echo $penj['kode_pelanggan']; ?></td>
                    <td><?php echo $penj['nama_pelanggan']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <h5>Barang</h5>
    <div class="table-responsive mb-0">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead id="datatable" style="background-color:#0085cd;color:white;">
                <tr>
                    <th style="width: 5%;">Kode</th>
                    <th style="width: 40%;">Nama Barang</th>
                    <th style="width: 5%;">Satuan</th>
                    <th>Keterangan</th>
                    <th style="width: 8%;">Jumlah</th>
                    <th style="width: 8%;">Harga</th>
                    <th style="width: 8%;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($data as $d) {
                    $total += $d->qty * $d->harga_jual;
                ?>
                    <tr>
                        <td><?php echo $d->kode_barang; ?></td>
                        <td><?php echo $d->nama_barang; ?></td>
                        <td><?php echo $d->satuan; ?></td>
                        <td><?php echo $d->keterangan; ?></td>
                        <td align="center"><?php echo number_format($d->qty); ?></td>
                        <td align="right"><?php echo number_format($d->harga_jual); ?></td>
                        <td align="right"><?php echo number_format($d->harga_jual * $d->qty); ?></td>
                    </tr>
                <?php } ?>
                <thead>
                    <tr>
                        <th colspan="6" style="text-align: center;">Total</th>
                        <th style="text-align:right"><?php echo number_format($total); ?></th>
                    </tr>
                </thead>
            </tbody>
        </table>
    </div>
    <br>
    <h5>Histori Pembayaran</h5>
    <div class="table-responsive mb-0">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead id="datatable" style="background-color:#0085cd;color:white;">
                <tr>
                    <th style="width: 10%;">No Bukti</th>
                    <th style="width: 20%;">Tanggal Bayar</th>
                    <th>Keterangan</th>
                    <th style="text-align:right;width:15%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($bayar as $d) {
                    $total += $d->jumlah;
                ?>
                    <tr>
                        <td><?php echo $d->nobukti; ?></td>
                        <td><?php echo $d->tgl_bayar; ?></td>
                        <td><?php echo $d->keterangan; ?></td>
                        <td align="right"><?php echo number_format($d->jumlah); ?></td>
                    </tr>
                <?php } ?>
                <thead>
                    <tr>
                        <th colspan="3" style="text-align: center;">Total</th>
                        <th style="text-align:right"><?php echo number_format($total); ?></th>
                    </tr>
                </thead>
            </tbody>
        </table>
    </div>
</div>