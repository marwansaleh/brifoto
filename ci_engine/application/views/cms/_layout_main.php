<?php $this->load->view('cms/component/html_head'); ?>
<?php $this->load->view('cms/component/main_navigation'); ?>
<?php $this->load->view('cms/component/header_title'); ?>
<?php if (isset($subview)){$this->load->view($subview);} ?>
<?php $this->load->view('cms/component/html_footer'); ?>

