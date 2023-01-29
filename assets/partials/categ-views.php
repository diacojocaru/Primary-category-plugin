<script type="text/html" id="tmpl-categ-set-admin-views">
  <a href="#" class="categ-set-primary categ-category" data-tax="{{data.taxonomy}}">
    <?php _e( 'Set Primary', 'Categ' ); ?>
  </a>
</script>
<script type="text/html" id="tmpl-categ-unset-admin-views">
  <a href="#" class="categ-unset-primary categ-category" data-tax="{{data.taxonomy}}">
    <?php _e( 'Unset Primary', 'Categ' ); ?>
  </a>
</script>
<?php wp_nonce_field( 'categ_primary_nonce', 'categ_primary_nonce' ); ?>
