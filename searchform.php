<div class='search-form-container'>
    <button id="search-icon" class="search-icon">
        <i class="fa fa-search"></i>
    </button>
    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
        <label class="screen-reader-text">Search for:</label>
        <input type="search" class="search-field" placeholder="Search..." value="" name="s" title="Search for:" />
        <input type="submit" class="search-submit" value='Go' />
    </form>
</div>