<?php

global $wp;

$project_id = (int) basename( $wp->request );

gravity_form( 7, false, false );
