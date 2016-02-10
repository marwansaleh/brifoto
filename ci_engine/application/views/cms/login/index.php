<div class="container">
    <div class="col-xs-12 col-lg-6 col-lg-offset-3 text-center">
        <form class="form-signin" role="form" method="post" action="<?php echo site_url(config_item('ctl_auth').'login'); ?>">
            
            <div class="well" style="margin-top: 40px;">
                <h2 class="form-signin-heading">Authentication Required</h2>
                <p>Please login using your username and password</p>
                <?php echo isset($message_box)?$message_box:''; ?>
                <hr>
                <input type="text" name="user_name" class="form-control" placeholder="Username" required="" autofocus="">
                <input type="password" name="password" class="form-control" placeholder="Password" required="">
                
                <p style="margin-top: 30px;">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                </p>
            </div>
            
        </form>
    </div>
</div>