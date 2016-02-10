<?php $this->load->view('cms/component/html_head'); ?>
<?php $this->load->view('cms/component/header_login'); ?>
<?php if (isset($subview)){$this->load->view($subview);} ?>
<?php $this->load->view('cms/component/html_footer'); ?>

