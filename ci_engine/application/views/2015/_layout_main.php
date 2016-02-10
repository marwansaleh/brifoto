<?php $this->load->view($template . '/component/html_head'); ?>
<?php $this->load->view($template . '/component/body_top'); ?>
<?php $this->load->view($template . '/component/main_navigation'); ?>
<?php $this->load->view($template . '/component/header_title'); ?>
<?php if (isset($subview)){$this->load->view($subview);} ?>
<?php $this->load->view($template . '/component/body_bottom'); ?>
<?php $this->load->view($template . '/component/html_footer'); ?>

