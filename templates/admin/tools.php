<?php aisoc_print_js_debug() ?>
<div class="wrap">
    <div class="aiosc-window">
        <h2 class="page-title"><?php _e('Herramientas','aiosc') ?>
            <span><?php _e('Aquí hay algunas herramientas de Ticket System que consideramos útiles y que también pueden ser útiles para usted.','aiosc') ?></span></h2>
        <div class="aiosc-toolbar">
            <ul class="aiosc-tabs">
                <li data-screen="general"><?php _e('Roles del Usuario','aiosc')?></li>
            </ul>
        </div>
        <div class="aiosc-clear"></div>
        <div id="ajax-response"></div>

        <div class="aiosc-form">
            <form method="post" id="aiosc-form" action="<?php echo get_admin_url()?>admin-ajax.php">
                <input type="hidden" name="action" value="aiosc_tools_submit" />
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
