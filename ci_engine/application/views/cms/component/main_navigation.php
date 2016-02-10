<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
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
                <li<?php echo ($menu_active=='dashboard')?' class="active"':'';?>>
                    <a href="<?php echo site_url(config_item('ctl_dashboard')) ;?>">
                        <span class="glyphicon glyphicon-dashboard"></span>  Dashboard
                    </a>
                </li>
                <li<?php echo ($menu_active=='gallery')?' class="active"':'';?>>
                    <a href="<?php echo site_url(config_item('ctl_cms_gallery')) ;?>">
                        <span class="glyphicon glyphicon-leaf"></span>  Galeri Foto
                    </a>
                </li>
                <li<?php echo ($menu_active=='competition')?' class="active"':'';?>>
                    <a href="<?php echo site_url(config_item('ctl_cms_comp')) ;?>">
                        <span class="glyphicon glyphicon-briefcase"></span>  Kompetisi
                    </a>
                </li>
                <li<?php echo ($menu_active=='member')?' class="active"':'';?>>
                    <a href="<?php echo site_url('cms/member') ;?>">
                        <span class="glyphicon glyphicon-user"></span>  Member
                    </a>
                </li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-user"></span> <?php echo $this->session->userdata('full_name'); ?>  <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url('cms/account/change_password'); ?>"><i class="icon-edit"></i> Change Password</a></li>
                        <li><a href="<?php echo site_url(config_item('ctl_auth').'logout'); ?>"><i class="icon-off"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
