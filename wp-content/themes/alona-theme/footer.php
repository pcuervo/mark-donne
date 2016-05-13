<?php
global $redux_data;
?>
</div><!--end main-content-->
<?php
if( !empty( $redux_data['tracking-code']) ) {
  echo $redux_data['tracking-code'];
}
wp_footer() ;?>
</body>
</html>