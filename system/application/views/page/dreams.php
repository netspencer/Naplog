<section id="dreams">
	<div class="container_12">
		<div class="grid_8">
			<ul class="sections">
				<li><a href="<?=base_url()?>dreams/following">Following</a></li>
				<li><a href="<?=base_url()?>dreams/popular">Popular</a></li>
				<li><a href="<?=base_url()?>dreams/everything">Everything</a></li>
			</ul>
			<?php $this->load->view("inc/list_dreams", array("dreams"=>$dreams));?>
			<a href="#" id="load_more">Load More Dream</a>
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