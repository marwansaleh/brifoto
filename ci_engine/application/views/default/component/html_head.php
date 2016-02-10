<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="<?php echo site_url(config_item('theme').'favicon.png'); ?>"/>
        
        <title><?php echo isset($meta_title)?$meta_title:'BFC Photo Competition'; ?></title>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo site_url(config_item('library').'jquery/jquery-1.11.1.min.js'); ?>"></script>
        
        <!-- Bootstrap -->
        <link type="text/css" href="<?php echo site_url(config_item('bootstrap_theme').'bootstrap.min.css'); ?>" rel="stylesheet" />
        
        <!-- theme custom -->
        <link href="<?php echo site_url(config_item('theme'). $template .'/bfc_competition.css'); ?>" rel="stylesheet">
        
        <!-- Fontaesome -->
        <link type="text/css" href="<?php echo site_url(config_item('library').'font-awesome-4.1.0/css/font-awesome.min.css'); ?>" rel="stylesheet" />
        
        <!-- Fontaesome -->
        <link type="text/css" href="<?php echo site_url(config_item('library').'fancybox/jquery.fancybox.css'); ?>" rel="stylesheet" />
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="<?php echo site_url(config_item('library').'html5shiv/html5shiv.js'); ?>"></script>
          <script src="<?php echo site_url(config_item('library').'respond/respond.min.js'); ?>"></script>
        <![endif]-->
        
        <!-- Normalize -->
        <link href="<?php echo site_url(config_item('library').'normalize/normalize.css'); ?>" rel="stylesheet">
    </head>
    <body>