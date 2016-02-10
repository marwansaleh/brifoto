<div class="container">
    <div class="row">
        <?php foreach ($items as $item): ?>
        <div class="col-lg-3 col-md-3 col-sm-4">
            <div class="thumbnail">
                <a class="fancybox" href="<?php echo $item->image_url; ?>" title="<?php echo $item->description; ?>">
                    <img src="<?php echo $item->image_url; ?>" class="img-responsive img-thumbnail" />
                </a>
                <div class="caption">
                    <h5 class="ellipsis"><?php echo $item->description; ?></h5>
                    <p><?php echo $item->member_unit;?></p>
                </div>
            </div>
            
        </div>

        <?php endforeach; ?>
    </div>
</div>
<div class="container"><?php echo $pagination; ?></div>