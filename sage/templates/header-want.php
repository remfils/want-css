<header class="header<?php echo (is_front_page()||is_singular('reference')||is_singular('news'))?'':'';?>">
    <a href="<?php echo esc_url( home_url( '/' ) );?>">
    <!-- START sage/want-logo.svg -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300.35999 126.74667">
          <path fill="#231f20" d="M121.227 81.5l6.063-52.37c1.654 20.746 3.306 38.214 4.95 52.37zm88.404-24.43L191.156 0h-27.558v93.394L149.707 0H102.07c-1.43 9.852-11.865 89.445-11.865 89.445S82.665 3.705 82.21 0H47.984c-4.862 35.863-7.9 64.85-9.117 86.98l-3.365-42.756L32.02 0H0l14.753 126.747H55.67c4.814-33.66 7.875-55.82 9.193-66.465 2.882 24.84 6.207 46.99 9.972 66.465h44.497l1.98-22.783h11.79l1.77 22.783h56.28V69.124l17.143 57.623h28.89V25.37h10.642v101.377h32.957V25.37h19.57V0H209.63v57.07"/>
        </svg>

        <!-- END sage/want-logo.svg -->
    </a>
    <div class="menu-toggle">
         <div class="toggle-open">
             <span></span>
             <span></span>
             <span></span>
          </div>
          <div class="toggle-close"></div>
    </div>
     <?php wp_nav_menu( array(
         'theme_location' => 'primary_navigation' ,
         'container'=>'nav',
         'container_class'=>'header-menu',
         'menu_id'=>NULL
        )); ?>
</header>
