<?php
global $aiosc_settings, $aiosc_capabilities;
?>
<input type="hidden" name="section" value="general" />
<table class="form-table">
    <tbody>
    <?php
    /*
     <tr>
        <th><label for="enable_hints"><?php _e('Enable Hints','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Would you like to see hints next to input fields?','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="enable_hints" name="enable_hints" value="1" <?php checked(aiosc_get_settings('enable_hints'))?>>
                <?php _e('Yes, enable hints.','aiosc')?></label>
        </td>
    </tr>
     */ ?>
    <tr>
        <th><label for="enable_staff_ribbon"><?php _e('Habilitar Cinta de Personal','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Te gustaría tener una cinta sobre tu avatar?','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="enable_staff_ribbon" name="enable_staff_ribbon" value="1" <?php checked(aiosc_get_settings('enable_staff_ribbon'))?>>
                <?php _e('Sí, mostrar cinta de personal sobre avatares de miembros del personal.','aiosc')?></label>
        </td>
    </tr>
    <tr>
        <th><label for="enable_public_tickets"><?php _e('Habilitar Tickets Públicos','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Los clientes pueden crear tickets públicos?','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="enable_public_tickets" name="enable_public_tickets" value="1" <?php checked(aiosc_get_settings('enable_public_tickets'))?>>
                <?php _e('Sí, permitir a los usuarios hacer públicos sus tickets.','aiosc')?></label>
        </td>
    </tr>
    <tr><td colspan="2" class="aiosc-title"><h3><?php _e('Roles del Usuario','aiosc')?></h3><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th><label for="default_role"><?php _e('Rol Predeterminado','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Al registrarse, se otorgará a los usuarios este rol.','aiosc')?> </small></th>
        <td>
            <select id="default_role" name="default_role">
                <option value=""><?php _e('- Sin rol por defecto -','aiosc')?></option>
                <?php
                foreach($aiosc_capabilities->get_roles() as $k=>$v) :
                    $selected = $k === aiosc_get_settings('default_role')?'selected="selected"':'';
                    ?>
                    <option value="<?php echo $k?>" <?php echo $selected ?>><?php echo $v['name']?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    <tr><td colspan="2" class="aiosc-title"><h3><?php _e('Archivos Adjuntos','aiosc')?></h3><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th><label for="allow_upload"><?php _e('Permitir subir','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Permitir a los clientes subir archivos junto con tickets y respuestas.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" value="1" <?php checked(aiosc_get_settings('allow_upload'))?> id="allow_upload" name="allow_upload" />
                <?php _e('Sí, permite a los usuarios cargar archivos adjuntos con tickets y respuestas.','aiosc') ?></label>
        </td>
    </tr>
    <tr>
        <th><label for="allow_download"><?php _e('Permitir la descarga','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Permitir a los clientes descargar sus archivos en cualquier momento.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" value="1" <?php checked(aiosc_get_settings('allow_download'))?> id="allow_download" name="allow_download" />
                <?php _e('Sí, permitir a los usuarios descargar archivos adjuntos de tickets y respuestas.','aiosc') ?></label>
        </td>
    </tr>
    <tr>
        <th><label for="max_upload_size_per_file"><?php _e('Tamaño máximo de archivo(Kb)','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Tamaño máximo de un solo archivo, no el tamaño de la carga completa.','aiosc')?> </small>
        </th>
        <td>
            <input type="number" min=1 required value="<?php echo aiosc_get_settings('max_upload_size_per_file')?>" id="max_upload_size_per_file" name="max_upload_size_per_file" />
            <?php _e('Kb','aiosc') ?> &nbsp;
            <em><?php printf(__('Max. valor posible es <code>%sb</code>, de acuerdo a <code>%s</code>.','aiosc'),aiosc_ini_get('upload_max_filesize',0),'php.ini') ?></em>
        </td>
    </tr>
    <tr>
        <th><label for="max_files_per_ticket"><?php _e('Max. archivos por ticket','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Cuántos archivos puede adjuntar el usuario a un ticket único?','aiosc')?> </small>
        </th>
        <td>
            <input type="number" min=1 <?php echo aiosc_ini_get('max_file_uploads') != ''?'max="'.aiosc_ini_get('max_file_uploads').'"':''?> required value="<?php echo aiosc_get_settings('max_files_per_ticket')?>" id="max_files_per_ticket" name="max_files_per_ticket" />
            <em><?php printf(__('Max. valor posible es <code>%s</code>, de acuerdo a <code>%s</code>.','aiosc'),aiosc_ini_get('max_file_uploads'),'max_file_uploads') ?></em>
        </td>
    </tr>
    <tr>
        <th><label for="max_files_per_reply"><?php _e('Max. archivos por respuesta','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Cuántos archivos puede adjuntar el usuario a la respuesta de un solo ticket?','aiosc')?> </small>
        </th>
        <td>
            <input type="number" min=1 <?php echo aiosc_ini_get('max_file_uploads') != ''?'max="'.aiosc_ini_get('max_file_uploads').'"':''?> required value="<?php echo aiosc_get_settings('max_files_per_reply')?>" id="max_files_per_reply" name="max_files_per_reply" />
            <em><?php printf(__('Max. valor posible es <code>%s</code>, de acuerdo a <code>%s</code>.','aiosc'),aiosc_ini_get('max_file_uploads'),'max_file_uploads') ?></em>
        </td>
    </tr>

    <tr><td colspan="2" class="aiosc-title"><h3><?php _e('Archivos Adjuntos con Tipos MIME','aiosc')?></h3><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th><label for="upload_mimes"><?php _e('Tipos MIME permitidos','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Extensiones de archivo (separadas por comas) que están permitidas para cargar.','aiosc')?> </small>
        </th>
        <td>
            <input type="text" style="width: 100%" required value="<?php echo aiosc_get_settings('upload_mimes')?>" id="upload_mimes" name="upload_mimes" />
        </td>
    </tr>
    <tr>
        <th><label for="upload_mimes_forbid"><?php _e('Prohibir los tipos MIME','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('En lugar de permitir los tipos MIME anteriores, puedes prohibirlos.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" value="1" <?php checked(aiosc_get_settings('upload_mimes_forbid'))?> id="upload_mimes_forbid" name="upload_mimes_forbid" />
                <?php _e('Prohibir las extensiones anteriores y permitir todas las demás.','aiosc') ?></label>
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
