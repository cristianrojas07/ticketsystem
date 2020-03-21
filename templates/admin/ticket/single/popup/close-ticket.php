<div class="aiosc-popup aiosc-close-ticket-popup">
    <div class="aiosc-popup-x" title="<?php _e('Close popup','aiosc')?>"><i class="dashicons dashicons-no"></i></div>
    <div class="aiosc-popup-header">
        <?php _e('Cerrar Ticket','aiosc')?>
    </div>
    <form id="aiosc-close-ticket-form" name="aiosc-close-ticket-form" action="<?php echo admin_url('/admin-ajax.php')?>" method="post">
        <input type="hidden" name="ticket_id" value="0" />
        <input type="hidden" name="action" value="aiosc_close_ticket" />
    <div class="aiosc-popup-content">
        <div id="close-ticket-response"></div>
        <?php wp_editor('','aiosc-ticket-closure-content',array(
            "media_buttons"=>false,
            "quicktags"=>true,
            'textarea_rows'=>4,
            "textarea_name"=>"content",
            "tinymce"=>array(
                "forced_root_block"=>false,
                "force_br_newlines"=>true,
                "force_p_newlines"=>false
            )
        ))?>
    </div>
        <div class="aiosc-popup-controls">
            <label class="aiosc-fleft" title="<?php _e('Envíe una notificación por correo electrónico informándole al cliente que su ticket fue cerrado.', 'aiosc')?>">
                <input type="checkbox" name="notify_customer" checked value="1" /><?php _e('Enviar notificación al cliente.', 'aiosc')?></label>
            <input type="submit" class="button button-primary" value="<?php _e('Enviar','aiosc')?>" />
            <button type="button" class="button aiosc-discard-button"><?php _e('Descartar','aiosc')?></button>
        </div>

    </form>
</div>
