<footer class="content-info clearfix" role="contentinfo">
    <div class="container">
    	<div class="footer-info"><?php the_field("want_footer_info",'option'); ?></div>
        <?php wp_nav_menu( array('menu' => 'footer-menu' ,'menu_class'=>'footer-menu')); ?>
        <div class="footer-impressum">
            <?php the_field("want_footer_impressum","option"); ?>
    	</div>
    </div>
</footer>
