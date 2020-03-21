<?php
global $aiosc_user;
$form_args = array(
    'echo'           => true,
    'redirect'       => aiosc_get_page_ticket_list(true),
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
            <p>
                <?php _e('<strong>Error:</strong> No tienes permiso para ver esta lista.','aiosc')?>
            </p>
        </div>
        <p>
            <?php printf(__('« Volver a <a href="%s">Home</a>','aiosc'),get_bloginfo('url')); ?>
        </p>
    <?php else : ?>
        <div class="aiosc-form-response warning" style="display: block">
            <p>
                <?php _e('Para ver esta lista, primero debe iniciar sesión con su cuenta.','aiosc')?>
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
