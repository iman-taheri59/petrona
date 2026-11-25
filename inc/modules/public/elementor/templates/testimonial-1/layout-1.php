<?php
/**
 * @author  Techno Theme
 * @since   1.0
 * @version 1.0
 */

 use Elementor\Group_Control_Image_Size;
 $allowed_tags = wp_kses_allowed_html( 'post' );

?>
<div class="techt-testimonial-area ptb--100 overflow-hidden">
    <div class="container-fluid">
        <div class="row g-5 align-items-center">
            <div class="col">
                <div class="overflow-hidden">
                    <div class="scroll-animation-wrapper pt--50 pb--30">
                        <div class="scroll-animation scroll-right-left">
                        <?php foreach ($settings['testimonial_list_7'] as $option_list_7) {
                            $rating7  = $option_list_7['rating7'];
                            $nonrating = 5 - (int)$rating7;  
                            ?> 
                            <!-- Start Single Testimonial  -->
                            <div class="single-column-20">
                                <div class="techt-testimonial-box">
                                    <div class="inner">
                                        <div class="clint-info-wrapper">
                                            <div class="thumb">
                                            <?php echo Group_Control_Image_Size::get_attachment_image_html( $option_list_7, 'thumbnail', 'client_image_7' );?>
                                            </div>
                                            <div class="client-info">
                                                <h5 class="title"><?php echo esc_html($option_list_7['testimonial_title_7']); ?></h5>
                                                <span><?php echo esc_html($option_list_7['testimonial_sub_title_7']); ?></i></span>
                                            </div>
                                        </div>
                                        <div class="description">
                                            <p class="subtitle-3"><?php echo esc_html($option_list_7['testimonial_description_7']); ?></p>
                                             <?php if($option_list_7['rating_display7'] == 'yes') { ?>
                                                <ul class="item-rating rating mt--20 d-flex list-unstyled g-10">
                                                    <?php foreach (range(1, $rating7) as $key): ?>
                                                        <li class="has-rating"><i class="fa fa-star"></i></li>
                                                    <?php endforeach; ?>
                                                    <?php for ($i=1; $i <= $nonrating; $i++): ?>
                                                        <li class="nonrating"><i class="fa fa-star"></i></li>
                                                    <?php endfor; ?>
                                                </ul>
                                            <?php } ?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Testimonial  -->
                            <?php } ?> 
                        </div>
                    </div>
                    <div class="scroll-animation-wrapper pb--50">
                        <div class="scroll-animation scroll-left-right">
                        <?php foreach ($settings['testimonial_list_8'] as $option_list_8) { 
                            $rating8  = $option_list_8['rating8'];
                            $nonrating = 5 - (int)$rating8;  ?>

                            <!-- Start Single Testimonial  -->
                            <div class="single-column-20">
                                <div class="techt-testimonial-box">
                                    <div class="inner">
                                        <div class="clint-info-wrapper">
                                            <div class="thumb">
                                            <?php echo Group_Control_Image_Size::get_attachment_image_html( $option_list_8, 'thumbnail', 'client_image_8' );?>
                                            </div>
                                            <div class="client-info">
                                                <h5 class="title"><?php echo esc_html($option_list_8['testimonial_title_8']); ?></h5>
                                                <span><?php echo esc_html($option_list_8['testimonial_sub_title_8']); ?></span>
                                            </div>
                                        </div>
                                        <div class="description">
                                            <p class="subtitle-3"><?php echo esc_html($option_list_8['testimonial_description_8']); ?></p> 
                                              <?php if($option_list_8['rating_display8'] == 'yes') { ?>
                                                <ul class="item-rating rating mt--20 d-flex list-unstyled g-10">
                                                    <?php foreach (range(1, $rating8) as $key): ?>
                                                        <li class="has-rating"><i class="fa fa-star"></i></li>
                                                    <?php endforeach; ?>
                                                    <?php for ($i=1; $i <= $nonrating; $i++): ?>
                                                        <li class="nonrating"><i class="fa fa-star"></i></li>
                                                    <?php endfor; ?>
                                                </ul>
                                            <?php } ?>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Testimonial  -->
                            <?php } ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>