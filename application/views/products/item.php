<style>
.prod_content{
	
	max-height:85px;
	min-height:85px;
	overflow:hidden;
	width:100%;
	float:left;
}
</style>
<div class="prod-container">
<div class="prodimg-holder">
	<img src="<?php echo $image; ?>" />
</div>
<div class="prod-dis">
	<p class="text-center"><span class="plus-sym">+</span></p>
	<h2 class="prod-name"><?php echo $name; ?></h2>
	<div class="prod_content">
	<p >
		<?php echo $content; ?>
	</p>
	</div>
	<div style="clear:both;"></div>
	<p>
		<a href="javaScript:void(0)" onClick="inquiry_frm(<?php echo $product_id; ?>)"  class="learn-more" data-toggle="modal" data-target="#myModal">Learn More</a>
	</p>
</div>
</div>