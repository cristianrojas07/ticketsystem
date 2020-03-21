<?php
global $aiosc_settings, $aiosc_user, $aiosc_capabilities;
?>
<input type="hidden" name="section" value="general" />
<table class="form-table">
    <tbody>
    <tr>
        <th><label><?php _e('Notificaciónes de Correo Electrónico','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Te gustaría recibir notificaciones?','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="aiosc_notifications" name="aiosc_notifications" value="1" <?php checked($aiosc_user->get_meta('aiosc_notifications', false))?>>
                <?php _e('Envíame notificaciones relacionadas con los tickets que me han sido asignados.','aiosc')?></label>
            <br /><br />
            <label>
                <input type="checkbox" id="aiosc_department_notifications" name="aiosc_department_notifications" value="1" <?php checked($aiosc_user->get_meta('aiosc_department_notifications', false))?>>
                <?php _e('Envíeme todas las notificaciones relacionadas con los departamentos a los que estoy asignado.','aiosc')?></label>
        </td>
    </tr>
    <tr>
        <th><label><?php _e('Ocultar la página "Crear nuevo"','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Desea ocultar esta página del menú principal de su cuenta?','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="aiosc_staff_create_form_disable" name="aiosc_staff_create_form_disable" value="1" <?php checked($aiosc_user->get_meta('aiosc_staff_create_form_disable', false))?>>
                <?php _e('Sí por favor, escóndelo.','aiosc')?></label>
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
