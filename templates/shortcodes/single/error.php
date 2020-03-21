<?php
global $aiosc_user, $ticket;
$form_args = array(
    'echo'           => true,
    'redirect'       => aiosc_is_ticket($ticket) ? aiosc_get_page_ticket_preview($ticket, false, true) : get_bloginfo('url'),
    'form_id'        => 'loginform',
    'label_username' => __( 'Nombre de Usuario', 'aiosc' ),
    'label_password' => __( 'Contraseña', 'aiosc' ),
    'label_remember' => __( 'Recuérdame', 'aiosc' ),
    'label_log_in'   => __( 'Iniciar sesión', 'aiosc' ),
    'id_username'    => 'user_login',
    'id_password'    => 'user_pass',
    'id_remember'    => 'rememberme',
    'id_submit'      => 'wp-submit',
    'remember'       => true,
    'value_username' => NULL,
    'value_remember' => false
);
?>
<div class="aiosc-window">
    <?php if(is_user_logged_in()) : ?>
        <div class="aiosc-form-response error" style="display: block">
            <?php if(aiosc_is_ticket($ticket)) : ?>
            <p>
                <?php _e('<strong>Error:</strong> No tienes permiso para ver este ticket.','aiosc')?>
            </p>
            <?php else : ?>
            <p>
                <?php _e('<strong>Error:</strong> El ticket que intenta ver no existe.','aiosc')?>
            </p>
            <?php endif; ?>
        </div>
            <p>
        <?php if(aiosc_is_user($aiosc_user)) : ?>
            <?php printf(__('« Volver a <a href="%s">List</a>','aiosc'),aiosc_get_page_ticket_list(true)); ?>
        <?php else : ?>
            <?php printf(__('« Volver a <a href="%s">Home</a>','aiosc'),get_bloginfo('url')); ?>
        <?php endif; ?>
            </p>
    <?php else : ?>
        <div class="aiosc-form-response warning" style="display: block">
            <p>
                <?php _e('Para ver este ticket, primero debe iniciar sesión con su cuenta.','aiosc')?>
            </p>
        </div>
        <?php echo wp_login_form($form_args); ?>
        <?php if(aiosc_can_register()) : ?>
            <p>
                <?php printf(__("¿Aún no tienes una cuenta? <a href='%s'>¡Regístrate ahora!</a>",'aiosc'),wp_registration_url()) ?>
            </p>
        <?php else : ?>
            <p>
                <?php _e('<strong>Nota:</strong> Las inscripciones para nuevos usuarios están cerradas.','aiosc') ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>
</div>
