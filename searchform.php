<div class='search-form-container'>
	<button id="search-icon" class="search-icon">
		<i class="fa fa-search"></i>
	</button>
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="screen-reader-text"><?php _e( 'Search for:', 'tracks' ); ?></label>
		<input type="search" class="search-field" placeholder="<?php _e( 'Search', 'tracks' ); ?>&#8230;" value=""
		       name="s" title="<?php _e( 'Search for:', 'tracks' ); ?>"/>
		<input type="submit" class="search-submit" value='<?php _e( 'Go', 'tracks' ); ?>'/>
	</form>
</div>