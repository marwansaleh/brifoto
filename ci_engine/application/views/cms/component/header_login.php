<?php if ($this->session->flashdata('message')): ?>
<div class="container">
    <?php echo create_alert_box($this->session->flashdata('message'), $this->session->flashdata('message_type')) ?>
</div>
<?php endif; ?>