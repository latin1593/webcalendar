<?php

include "includes/config.php";
include "includes/php-dbi.php";
include "includes/functions.php";
include "includes/$user_inc";
include "includes/validate.php";
include "includes/connect.php";

load_global_settings ();
load_user_preferences ();

$updating_public = false;
if ( $is_admin && ! empty ( $public ) && $public_access == "Y" ) {
  $updating_public = true;
  $layer_user = "__public__";
} else {
  $layer_user = $login;
}

load_user_layers ( $layer_user, 1 );

if ( strlen ( $layers[$id]['cal_layeruser'] ) > 0 &&
  ( $is_admin || $readonly == "N" ) ) {
  $layeruser = $layers[$id]['cal_layeruser'];

  dbi_query ( "DELETE FROM webcal_user_layers " .
    "WHERE cal_login = '$layer_user' AND cal_layeruser = '$layeruser'" );
}

if ( $updating_public )
  do_redirect ( "layers.php?public=1" );
else
  do_redirect ( "layers.php" );
?>
