
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <span class="search-open"><i class="fa fa-search" aria-hidden="true"></i></span>
    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
    <span class="search-close"><i class="fa fa-times" aria-hidden="true"></i></span>
</form>