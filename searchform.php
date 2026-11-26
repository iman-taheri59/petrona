<?php
/**
 * The template for displaying search form.
 *
 * @package Petrona
 * @since 1.0
 */
?>
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="searchform">
    <div class="input-group">
        <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search here &hellip;', 'petrona' ); ?>" class="form-control" required="required" value="<?php echo esc_attr( get_search_query() ); ?>">
        <span class="input-group-append">
            <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
            </button>
        </span> 
    </div>
</form>

