<div class="dreams">
<?php foreach($dreams as $dream):?>
	<?php $this->load->view("partial/dream", $dream);?>
<?php endforeach;?>
</div>