<div class='search-form-container'>
	<button id="search-icon" class="search-icon">
		<i class="fas fa-search"></i>
	</button>
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'tracks' ); ?></label>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search', 'tracks' ); ?>&#8230;" value=""
		       name="s" title="<?php esc_attr_e( 'Search for:', 'tracks' ); ?>"/>
		<input type="submit" class="search-submit" value='<?php esc_attr_e( 'Go', 'tracks' ); ?>'/>
	</form>
</div>