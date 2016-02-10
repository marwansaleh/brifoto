<div class="container">
    <h2>Tema</h2>
    <p class="lead">Penggunaan Teknologi BRI dalam melayani seluruh nasabah (UMKM, Korporasi, Prioritas, dll)</p>
    <h2>Syarat dan Ketentuan</h2>
    <ol>
        <li>Lomba foto bersifat internal</li>
        <li>
            Terbuka untuk seluruh Pekerja PT> Bank Rakyat Indonesia (Persero) Tbk tidak terkecuali pekerja
            organik maupun tenaga kontrak / outsourcing
        </li>
        <li>Karya foto milik pribadi (bukan karya orang lain) dan belum pernah memenangkan lomba foto apapun</li>
        <li>Karya foto harus sesuai dengan Tema Foto yang dilombakan</li>
        <li>
            Apabila menggunakan model harus dapat menyerahkan kepada Panitia Surat Pernyataan dari model ybs
            (Model Release) dengan format surat standar yang dikeluarkan Pihak Panitia dimana peserta dapat
            mengunduhnya pada website resmi BFC. <a target="_blank" href="<?php echo site_url('home/download?file='.$files['spm-model']); ?>">(Download PDF)</a>
        </li>
        <li>Jumlah foto dibatasi tiap peserta hanya dapat mengirimkan fotonya paling banyak 3 foto </li>
        <li>Lokasi foto di seluruh wilayah Indonesia</li>
        <li>karya foto WAJIB dalam format berwarna</li>
        <li>Rekayasa digital diijinkan sebatas tidak menambah objek atau merusak esensi dari foto</li>
        <li>
            Semua karya foto yang akan diikutsertakan dalam lomba ini dikirimkan dengan ukuran maksimum
            500Kb (1024 x 700 piksel) melalui website resmi BFC di www.brifotograferclub.com
        </li>
        <li>
            Pengiriman foto menggunakan format penamaan sebagai berikut
            <ul>
                <li>Nama_No.HP_Personal Number_Unit kerja_udul Foto.jpg</li>
                <li>Contoh: Corleone_08138855XXX_12345_kanca cibadak_internet banking.jpg</li>
            </ul>
        </li>
        <li>Karya foto paling lambat diterima oleh panitia pada tanggal 5 Desember 2014 <strong>dan diperpanjang sampai 20 Desember 2014</strong></li>
        <li>Seluruh foto yang dilombakan dapat digunakan untuk kepentingan BRI</li>
        <li>Keputusan dewan juri tidak bisa diganggu gugat</li>
    </ol>
    
    <h2>Hadiah</h2>
    <ol>
        <li>Juara Pertama: Rp 10.000.000 + Piagam Penghargaan</li>
        <li>Juara Kedua: Rp 7.500.000 + Piagam Penghargaan</li>
        <li>Juara Ketiga: Rp 5.000.000 + Piagam Penghargaan</li>
    </ol>

    <div class="well well-sm">
        <p class="lead">CP: avinetbri@gmail.com</p>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Pengumuman Perpanjangan Masa Upload</h4>
            </div>
            <div class="modal-body">
                <p>Melihat antusias yang tinggi dan kesibukan pekerjaan di akhir tahun ini maka BRI Photo Contest 2014 diperpanjang waktunya hingga tanggal 20 Desember 2014. Selamat berkarya !</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function(){
        <?php// if (!$this->session->userdata('muncul_pengumuman')): ?>
            //muncul_pengumuman();
            <?php //$this->session->set_userdata('muncul_pengumuman',TRUE); ?>
        <?php //endif; ?>
    });
    
    function muncul_pengumuman(){
        $('#myModal').modal();
    }
</script>