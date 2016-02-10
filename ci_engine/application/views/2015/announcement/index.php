<div class="container">
    <h2>Pengumuman Final</h2>
    <p>
        Berikut hasil final 120 thn BRI Photo Contest. 
    </p>
    
    <div id="nanoGallery">
        <?php foreach ($champs as $item): ?>
        <a href="<?php echo $item->image_url; ?>" data-ngthumb="<?php echo $item->image_url; ?>">
            <?php echo $item->name; ?> - <?php echo $item->description; ?> - <?php echo $item->uker; ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#nanoGallery").nanoGallery({
            colorScheme: 'none',
            thumbnailWidth: 'auto',
            thumbnailHeight: 250,
            thumbnailHoverEffect: [{ name: 'labelAppear75', duration: 300 }],
            theme: 'clean',
            thumbnailGutterWidth : 0,
            thumbnailGutterHeight : 0,
            i18n: { thumbnailImageDescription: 'View Photo', thumbnailAlbumDescription: 'Open Album' },
            thumbnailLabel: { display: true, position: 'overImageOnMiddle', align: 'center' }
        });
    });
</script>