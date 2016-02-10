<div class="container">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" target="_blank" href="http://bri.co.id">BRI</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li<?php echo ($menu_active=='home')?' class="active"':'';?>>
                        <a href="<?php echo site_url(config_item('ctl_home')) ;?>">
                            <span class="glyphicon glyphicon-dashboard"></span>  Beranda
                        </a>
                    </li>
                    <li<?php echo ($menu_active=='upload')?' class="active"':'';?>>
                        <a href="<?php echo site_url(config_item('ctl_upload')) ;?>">
                            <span class="glyphicon glyphicon-dashboard"></span>  Unggah Foto
                        </a>
                    </li>
                    <li<?php echo ($menu_active=='gallery')?' class="active"':'';?>>
                        <a href="<?php echo site_url(config_item('ctl_gallery')) ;?>">
                            <span class="glyphicon glyphicon-leaf"></span>  Galeri Foto
                        </a>
                    </li>
                    <?php if ($is_final): ?>
                    <li<?php echo ($menu_active=='announcement')?' class="active"':'';?>>
                        <a href="<?php echo site_url(config_item('ctl_announcement')) ;?>">
                            <span class="glyphicon glyphicon-leaf"></span>  Pengumuman
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
