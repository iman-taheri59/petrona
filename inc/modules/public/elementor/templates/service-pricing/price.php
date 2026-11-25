<?php
/**
 * Service Pricing price block template
 */
?>
<div class="service-pricing__price"><?php
	$this->_html( 'price_prefix', '<span class="service-pricing__price-prefix">%s</span>' );
	$this->_html( 'price', '<span class="service-pricing__price-val">%s</span>' );
	$this->_html( 'price_suffix', '<span class="service-pricing__price-suffix">%s</span>' );
	$this->_html( 'price_desc', '<p class="service-pricing__price-desc">%s</p>' );
?></div>