<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package crystal
 */

?>
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="<?php crystal_the_layout_classes('footer'); ?>">
        <div class="row">
            <div class="col-md-4">
                <div class="site-info">
                    <span><?php printf(esc_html__('Free %1$s Theme | ', 'crystal'), 'WordPress'); bloginfo('name'); ?></span>
                    <br>
                    <span><?php printf(esc_html__('Copyright', 'crystal')); ?></span>
                    &copy; <span id="copyright-year"></span>
                </div><!-- .site-info -->
            </div>

            <aside id="secondary" class="footer-widget-area col-md-4" role="complementary">

                <?php
                if ( is_active_sidebar( 'footer-sidebar-1' ) ) {
                    dynamic_sidebar( 'footer-sidebar-1' );
                }
                ?>
            </aside>

            <aside id="secondary" class="footer-widget-area col-md-4" role="complementary">
                <?php
                if ( is_active_sidebar( 'footer-sidebar-2' ) ) {
                    dynamic_sidebar( 'footer-sidebar-2' );
                }
                ?>
            </aside>

        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
