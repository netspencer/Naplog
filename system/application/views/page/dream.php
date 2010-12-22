<section id="dreams">
	<div class="container_12">
		<div class="grid_8">
			<?php $this->load->view("inc/list_dreams", array("dreams"=>$dreams));?>
			<?php $this->load->view("inc/list_likes", array("likes"=>$likes->list, "num_likes"=>$likes->num));?>
			<?php $this->load->view("inc/list_comments", array("comments"=>$comments));?>
		</div>
		<div class="grid_4">
			<div class="ad">	
				<h3>Advertisement</h3>
				<a href="http://klassio.com"><img src="http://f.cl.ly/items/3n2W1o321z3Q2M0D2t14/klassio-ad.jpg" alt="ad" /></a>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</section>