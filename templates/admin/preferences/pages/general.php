<?php
global $aiosc_settings, $aiosc_capabilities;

$pages = get_pages();
?>
<input type="hidden" name="section" value="pages" />
<table class="form-table">
    <tbody>
    <tr>
        <th><label for="pages_frontend_enable"><?php _e('Usar Páginas de Inicio','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Vas a utilizar Ticket System de Inicio?','aiosc')?> </small></th>
        <td>
            <label>
            <input type="checkbox" id="pages_frontend_enable" name="pages_frontend_enable" <?php checked($aiosc_settings->get('pages_frontend_enable')) ?> />
                <?php _e('Sí, habilitar las páginas de Inicio.','aiosc')?>
            </label>
        </td>
    </tr>
    <tr><td colspan="2"><div class="aiosc-separator"></div></td> </tr>
    <tr>
        <th><label for="page_ticket_form"><?php _e('Formulario de Ticket Nuevo','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Qué página mostrará este formulario?','aiosc')?> </small></th>
        <td>
            <select id="page_ticket_form" name="page_ticket_form">
                <option value=""><?php _e('- Ninguna -','aiosc')?></option>
                <?php
                foreach($pages as $page) :
                    $selected = $page->ID == $aiosc_settings->get('page_ticket_form')?'selected="selected"':'';
                    ?>
                    <option value="<?php echo $page->ID?>" <?php echo $selected ?>><?php echo $page->post_title?></option>
                <?php endforeach; ?>
            </select>
            <small><?php printf(__('Use el shortcode <code>%s</code> en una página para mostrar el formulario.','aiosc'),'[aiosc_ticket_form]')?></small>
        </td>
    </tr>
    <tr>
        <th><label for="page_ticket_preview"><?php _e('Vista Previa del Ticket (individual)','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Qué página mostrará la vista previa de un solo ticket?','aiosc')?> </small></th>
        <td>
            <select id="page_ticket_preview" name="page_ticket_preview">
                <option value=""><?php _e('- Ninguna -','aiosc')?></option>
                <?php
                foreach($pages as $page) :
                    $selected = $page->ID == $aiosc_settings->get('page_ticket_preview')?'selected="selected"':'';
                    ?>
                    <option value="<?php echo $page->ID?>" <?php echo $selected ?>><?php echo $page->post_title?></option>
                <?php endforeach; ?>
            </select>
            <small><?php printf(__('Use el shortcode <code>%s</code> en una página para obtener una vista previa de el ticket.','aiosc'),'[aiosc_ticket_preview]')?></small>
        </td>
    </tr>
    <tr>
        <th><label for="page_ticket_list"><?php _e('Lista de Tickets (Mis Tickets)','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Qué página mostrará la lista de tickets de todos los usuarios?','aiosc')?> </small></th>
        <td>
            <select id="page_ticket_list" name="page_ticket_list">
                <option value=""><?php _e('- Ninguna -','aiosc')?></option>
                <?php
                foreach($pages as $page) :
                    $selected = $page->ID == $aiosc_settings->get('page_ticket_list')?'selected="selected"':'';
                    ?>
                    <option value="<?php echo $page->ID?>" <?php echo $selected ?>><?php echo $page->post_title?></option>
                <?php endforeach; ?>
            </select>
            <small><?php printf(__('Use el shortcode <code>%s</code> en una página para mostrar la lista de tickets.','aiosc'),'[aiosc_ticket_list]')?></small>
        </td>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <td>
            <input type="submit" class="button button-primary" id="aiosc-form-submit" value="<?php _e('Enviar','aiosc')?>" />
            <button type="button" class="button" id="aiosc-form-discard"><?php _e('Descartar','aiosc')?></button>
        </td>
    </tr>
    </tbody>
</table>
