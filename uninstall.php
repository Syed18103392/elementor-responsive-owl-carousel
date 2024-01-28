<?php

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'GF_OWL_CAROUSEL_VERSION' );
delete_option( 'gf_owl_carousel_installed' );
