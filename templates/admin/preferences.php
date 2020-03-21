<?php
wp_enqueue_media();
?>
<?php aisoc_print_js_debug() ?>
<div class="aiosc-wp_editor">
    <?php wp_editor(
        '',
        'aiosc-demo-wp_editor',
        array(
            "media_buttons"=>true,
            "quicktags"=>false,
            'textarea_rows'=>4,
            "tinymce"=>array(
                "forced_root_block"=>false,
                "force_br_newlines"=>true,
                "force_p_newlines"=>false
            )
        )
    );
    ?>
</div>
<div class="wrap">
    <div class="aiosc-window">
        <h2 class="page-title"><?php _e('Preferencias','aiosc') ?>
            <span><?php _e('Configure Ticket System para que se adapte a sus necesidades, pero asegúrese de leer cuidadosamente la documentación para que sepa lo que está haciendo.','aiosc') ?></span></h2>
        <div class="aiosc-toolbar">
            <ul class="aiosc-tabs">
                <li data-screen="general"><?php _e('General','aiosc')?></li>
                <li data-screen="tickets"><?php _e('Tickets','aiosc')?></li>
                <li data-screen="departments"><?php _e('Departamentos','aiosc')?></li>
                <li data-screen="priorities"><?php _e('Prioridades','aiosc')?></li>
                <li data-screen="email"><?php _e('Correo Electrónico','aiosc')?></li>
                <li data-screen="email-templates-customer-creation"><?php _e('Plantillas de Correo Electrónico','aiosc')?></li>
                <li data-screen="pages"><?php _e('Páginas','aiosc')?></li>
                <li data-screen="cron"><?php _e('Cron','aiosc')?></li>
                <li data-screen="addons"><?php _e('Complementos','aiosc')?></li>
            </ul>
        </div>
        <div class="aiosc-clear"></div>
        <div id="ajax-response"></div>

        <div class="aiosc-form">
            <form method="post" id="aiosc-form" action="<?php echo get_admin_url()?>admin-ajax.php">
                <input type="hidden" name="action" value="aiosc_pref_save" />
                <div class="aiosc-tab-content-holder">
                    <div class="aiosc-loading-holder"><div class="aiosc-loading-bar"><span><?php _e('Cargando Pantalla...','aiosc')?></span></div></div>
                    <div class="aiosc-tab-content">

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    jQuery(document).on("click","#aiosc-content-tags-wrap > button",function() {
        var sel = jQuery(this).parent().find("select");
        if(sel.val() != "") {
            if (aiosc_tinymce_enabled()) {
                tinymce.get('aiosc-content').execCommand('mceInsertContent', true, sel.val());
            }
            else jQuery('#aiosc-content').val(sel.val());
        }
    })
</script>
