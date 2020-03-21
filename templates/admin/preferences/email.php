<?php
global $aiosc_settings, $aiosc_capabilities;
?>
<div class="aiosc-subtoolbar">
    <ul class="aiosc-subtabs">
        <li class="active" data-screen="email"><?php _e('Respondedores automáticos','aiosc')?></li>
        <li data-screen="email-piping"><?php _e('Canalización de Correo Electrónico','aiosc')?></li>
    </ul>
</div>
<input type="hidden" name="section" value="email" />
<table class="form-table">
    <tbody>
    <tr><td colspan="2" class="aiosc-title"><h3 style="margin-top: 0;"><?php _e('Clientes','aiosc')?></h3><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th><label for="email_ar_customer_ticket_creation"><?php _e('En la Creación de Tickets','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Enviar correo electrónico de confirmación al usuario cuando su ticket se haya creado correctamente.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="email_ar_customer_ticket_creation" name="email_ar_customer_ticket_creation" value="1" <?php checked($aiosc_settings->get('email_ar_customer_ticket_creation'))?>>
                <?php _e('Sí, enviar confirmación al usuario.','aiosc')?></label>
        </td>
    </tr>
    <tr>
        <th><label for="email_ar_customer_ticket_reply"><?php _e('En Nueva Respuesta','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Enviar un correo electrónico de notificación al usuario cuando el Operador publique una nueva respuesta en su ticket.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="email_ar_customer_ticket_reply" name="email_ar_customer_ticket_reply" value="1" <?php checked($aiosc_settings->get('email_ar_customer_ticket_reply'))?>>
                <?php _e('Sí, enviar notificación al usuario.','aiosc')?></label>
        </td>
    </tr>
    <tr>
        <th><label for="email_ar_customer_ticket_close"><?php _e('Cierre de Ticket','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Enviar un correo electrónico de notificación al usuario cuando el Operador cierre su ticket.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="email_ar_customer_ticket_close" name="email_ar_customer_ticket_close" value="1" <?php checked($aiosc_settings->get('email_ar_customer_ticket_close'))?>>
                <?php _e('Sí, enviar notificación al usuario.','aiosc')?></label>
        </td>
    </tr>
    <tr>
        <th><label for="email_ar_customer_ticket_reopen"><?php _e('En Reapertura','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Enviar un correo electrónico de notificación al usuario cuando se vuelva a abrir su ticket.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="email_ar_customer_ticket_reopen" name="email_ar_customer_ticket_reopen" value="1" <?php checked($aiosc_settings->get('email_ar_customer_ticket_reopen'))?>>
                <?php _e('Sí, enviar notificación al usuario.','aiosc')?></label>
        </td>
    </tr>
    <tr><td colspan="2" class="aiosc-title"><h3><?php _e('Miembros del Personal','aiosc')?></h3><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th><label for="email_ar_staff_ticket_creation"><?php _e('En la Asignación de Tickets','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Enviar una notificación por correo electrónico al Operador cuando se le asigne un nuevo ticket.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="email_ar_staff_ticket_creation" name="email_ar_staff_ticket_creation" value="1" <?php checked($aiosc_settings->get('email_ar_staff_ticket_creation'))?>>
                <?php _e('Sí, enviar una notificación a un miembro del personal.','aiosc')?></label>
        </td>
    </tr>
    <tr>
        <th><label for="email_ar_staff_ticket_reply"><?php _e('En Nueva Respuesta','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Envíe un correo electrónico de notificación al Operador cuando el cliente publique una nueva respuesta en el ticket.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="email_ar_staff_ticket_reply" name="email_ar_staff_ticket_reply" value="1" <?php checked($aiosc_settings->get('email_ar_staff_ticket_reply'))?>>
                <?php _e('Sí, enviar una notificación a un miembro del personal.','aiosc')?></label>
        </td>
    </tr>
    <tr>
        <th><label for="email_ar_staff_ticket_close"><?php _e('Solicitud de Cierre de Ticket','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Envíe un correo electrónico de notificación al Operador cuando el cliente solicite el cierre de su ticket.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="email_ar_staff_ticket_close" name="email_ar_staff_ticket_close" value="1" <?php checked($aiosc_settings->get('email_ar_staff_ticket_close'))?>>
                <?php _e('Sí, enviar una notificación a un miembro del personal.','aiosc')?></label>
        </td>
    </tr>
    <tr>
        <th><label for="email_ar_staff_ticket_reopen"><?php _e('En Reapertura','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Envíe un correo electrónico de notificación al Operador cuando el cliente vuelva a abrir su ticket.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="email_ar_staff_ticket_reopen" name="email_ar_staff_ticket_reopen" value="1" <?php checked($aiosc_settings->get('email_ar_staff_ticket_reopen'))?>>
                <?php _e('Sí, enviar una notificación a un miembro del personal.','aiosc')?></label>
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
