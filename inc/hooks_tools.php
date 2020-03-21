<?php

/**
 * These hooks are used for "Tools" page only and this is the only file that does
 * everything you can find in Tools page
 *
 * Class aiosc_HooksTools
 */
class aiosc_HooksTools {
    function __construct() {

        /** AJAX */

        //screen switching
        add_action('wp_ajax_aiosc_tools_screen',array($this,'tools_screen'));
        //submitting
        add_action('wp_ajax_aiosc_tools_submit',array($this,'tools_submit'));
    }

    /**
     * Loads preferences tab template from defined $_POST['screen']
     * @POST['screen'] - determines which screen we are loading
     */
    function tools_screen() {
        $screens = array(
            'general'=>'admin/tools/general.php'
        );
        if(isset($_POST['screen']) && array_key_exists($_POST['screen'], $screens)) {
            echo aiosc_response(1,'',array('html'=>aiosc_load_template($screens[$_POST['screen']])));
            die();
        }
        else {
            echo aiosc_response(0,__("<strong>Error:</strong> La pestaña seleccionada no existe.",'aiosc'));
            die();
        }
    }
    /**
     * Process submit from Tools forms
     * @POST['section'] - determines which tab we are submitting
     */
    function tools_submit() {
        global $aiosc_settings, $aiosc_user, $aiosc_capabilities;

        if(!$aiosc_user->can('manage_options')) {
            echo aiosc_response(0,AIOSC_PERMISSION_ERROR);
            die();
        }
        $sections = array(
            'general'
        );
        if(isset($_POST['section']) && in_array($_POST['section'], $sections)) {
            $s = $_POST['section'];
            if($s == 'general') {
                $message = '';
                //Mass Update AIOSC roles (excluding staff members)
                if(isset($_POST['update_role']) && $aiosc_capabilities->role_exists($_POST['update_role'])) {
                    $role = $_POST['update_role'];
                    $allowed = $aiosc_capabilities->get_allowed_massupdate_roles();
                    if(is_array($allowed) && !array_key_exists($_POST['update_role'], $allowed)) { //$aiosc_capabilities->role_has_cap('staff',$role)
                        echo aiosc_response(0,__('<strong>Advertencia:</strong> La función seleccionada es demasiado alta para la actualización masiva. Solo puedes usar roles de bajo nivel desde el menú desplegable.','aiosc'));
                        die();
                    }
                    $staff_members = $aiosc_capabilities->get_roles_by_cap('staff');
                    $excluded = array();
                    foreach($staff_members as $k=>$v) {
                        $temp_e = get_users(array(
                            'role'=>$k,
                            'fields'=>'ID'
                        ));
                        $excluded = array_merge($excluded, $temp_e);
                    }
                    $y=0;
                    $users = get_users(array(
                        'fields'=>'ID', //only IDs
                        'exclude'=>$excluded
                    ));
                    foreach($users as $uid) {
                        $user = new aiosc_User($uid);
                        $user->set_role($role);
                        $y++;
                    }
                    if(!empty($message)) $message .= "<br />";
                    $message .= sprintf(__('<strong>Actualizar Roles Actuales:</strong> El total de %d usuarios se ha actualizado.','aiosc'),$y);
                }


                //DELETE old Support Center role of needed
                if(isset($_POST['remove_old_sc_roles'])) {
                    $users = get_users(array(
                        'fields'=>'ID'
                    ));
                    $old_sc_roles = $aiosc_capabilities->get_old_sc_roles();
                    $y= 0;
                    foreach($users as $uid) {
                        $user = new aiosc_User($uid);
                        foreach($old_sc_roles as $old_role) {
                            if(in_array($old_role,$user->wpUser->roles)) {
                                $user->wpUser->remove_role($old_role);
                                $y++;
                            }
                        }
                    }
                    if(!empty($message)) $message .= "<br />";
                    $message .= sprintf(__('<strong>Eliminación de roles antiguos: </strong> Se actualizaron el total de %d usuarios.','aiosc'),$y);
                }
                if(!empty($message)) {
                    echo aiosc_response(1,$message);
                    die();
                }
                else {
                    echo aiosc_response(1,__('<strong>Información:</strong> No se realizó ninguna acción.','aiosc'));
                    die();
                }
            }
        }
        else {
            echo aiosc_response(0,__('<strong>Error:</strong> La sección no existe.','aiosc'));
            die();
        }
    }
}
