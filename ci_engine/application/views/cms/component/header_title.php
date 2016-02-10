<?php if ((isset ($page_title)&& $page_title!='')||(isset ($breadcumb)&&count($breadcumb))):?>
<div class="container-fluid">
    <div class="pull-right">
        <?php echo isset($breadcumb)?breadcrumb($breadcumb):'';?>
    </div>
    <h1 class="page-header"><?php echo $page_title; ?></h1>
</div>
<?php endif; ?>
<?php if ($this->session->flashdata('message_text')): ?>
<div class="container-fluid">
    <?php echo create_alert_box($this->session->flashdata('message_text'), $this->session->flashdata('message_type')) ?>
</div>
<?php endif; ?>