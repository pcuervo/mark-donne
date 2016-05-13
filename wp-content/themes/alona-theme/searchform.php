<form action="<?php echo home_url(); ?>" method="get" role="search">
	<fieldset>
		<div class="searchform-wrapper">
			<!-- <i class="fa fa-search"></i> -->
			<input type="text" class="searchinput" name="s"  placeholder="<?php _e("Search Here", 'subsolar'); ?>">
			<!-- <input type="submit" class="button searchsubmit" value="<?php _e("Search", 'subsolar'); ?>"> -->
            <button type="submit" class="button">
                <i class="fa fa-search"></i>
          </button>
		</div>
	</fieldset>
</form>