<div class="container">
    <div class="row">
        <div id="nanoGallery">
            <?php foreach ($items as $item): ?>
            <a href="<?php echo $item->image_url; ?>" data-ngthumb="<?php echo $item->image_url; ?>"><?php echo $item->description; ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="container"><?php echo $pagination; ?></div>

<script type="text/javascript">
    $(document).ready(function(){
        <?php if (count($items)) :?>
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
        <?php endif; ?>
    });
</script>

