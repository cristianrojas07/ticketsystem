<?php
global $aiosc_settings, $aiosc_capabilities;

global $wpdb;
$user_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users");
?>
<input type="hidden" name="section" value="general" />
<table class="form-table">
    <tbody>

    <tr>
        <th><label for="update_role"><?php _e('Eliminar Roles Antiguos','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Si tenía instalado el antiguo Ticket System (v0.8.2), debería marcar esta casilla.','aiosc')?> </small></th>
        <td>
            <?php if($user_count > AIOSC_ACTIVATION_MAX_USERS) : ?>
                <p>
                    <?php printf(__('Esta opción no está disponible porque tiene más de %d usuarios (%d para ser más precisos) y la actualización de todos los usuarios a la vez afectaría el rendimiento del servidor y produciría resultados inesperados.', 'aiosc'), AIOSC_ACTIVATION_MAX_USERS, $user_count)?>
                </p>
            <?php else : ?>
            <label>
                <input type="checkbox" id="remove_old_sc_roles" name="remove_old_sc_roles" />
                <?php _e('Sí, deshacerse de los roles antiguos.','aiosc')?>
            </label>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th><label for="update_role"><?php _e('Actualizar Roles Actuales','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Actualice en masa los roles actuales para todos los usuarios (excepto los miembros del personal).','aiosc')?> </small></th>
        <td>
            <?php if($user_count > AIOSC_ACTIVATION_MAX_USERS) : ?>
                <p>
                    <?php printf(__('Esta opción no está disponible porque tiene más de %d usuarios (%d para ser más precisos) y la actualización de todos los usuarios a la vez afectaría el rendimiento del servidor y produciría resultados inesperados.', 'aiosc'), AIOSC_ACTIVATION_MAX_USERS, $user_count)?>
                </p>
            <?php else : ?>
                <select id="update_role" name="update_role">
                    <option value=""><?php _e('- Seleccionar Rol -','aiosc')?></option>
                    <?php
                    $allowed_roles = $aiosc_capabilities->get_allowed_massupdate_roles();
                    foreach($allowed_roles as $k=>$v) :
                        ?>
                        <option value="<?php echo $k?>"><?php echo $v['name']?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
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
