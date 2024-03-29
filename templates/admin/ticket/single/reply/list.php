<?php
global $aiosc_user, $aiosc_settings, $ticket, $author;
global $can_edit_replies;
$can_edit_replies = $aiosc_user->can('edit_ticket',array('ticket_id'=>$ticket));

$reply_limit = apply_filters('aiosc_reply_limit',3);
$replies = aiosc_ReplyManager::get_replies(array('ticket_id'=>$ticket->ID),' ORDER BY ID DESC LIMIT 0,'.$reply_limit);
if(is_array($replies)) {
    $last_reply_by = new aiosc_User($replies[0]->author_id);
    $last_reply_by_url = aiosc_get_user_url($last_reply_by->ID);
    if(!empty($last_reply_by_url)) $last_reply_by = '<a href="'.$last_reply_by_url.'" target="_blank">'.$last_reply_by->display_name."</a>";
    else $last_reply_by = $last_reply_by->display_name;
}
$total_replies = aiosc_ReplyManager::get_count_by(array('ticket_id'=>$ticket->ID));
?>
<div class="aiosc-window aiosc-replies">
    <h2 class="page-title page-title-sm"><?php _e('Respuestas','aiosc') ?>
        <span>
            <?php if($total_replies > 0)
                printf(_n('There is %s reply posted on this ticket and last reply was posted by %s.',
                        'There are %s replies posted on this ticket and last reply was posted by %s.',
                        $total_replies,'aiosc'),
                    $total_replies, $last_reply_by);
            else _e('Aún no hay respuestas.','aiosc'); ?>
        </span>
        <div class="aiosc-separator"></div>
    </h2>
    <?php

    if(!empty($replies) && $replies !== false) :
        global $reply;
        foreach($replies as $r) :
            $reply = $r;
            echo aiosc_load_template('admin/ticket/single/reply/single.php');

        endforeach;
    ?>
        <div id="aiosc-replies-load-more">
            <div class="aiosc-reply-loading aiosc-loading-bar"></div>
            <a href="javascript:aiosc_load_replies(<?php echo $ticket->ID?>)"><?php _e('Cargar más','aiosc')?></a>
        </div>
        <div id="aiosc-replies-no-more"><?php _e('No hay mas respuestas','aiosc')?></div>
    <?php
    else : ?>
        <div class="aiosc-no-replies-found"><?php _e('Aún no hay respuestas publicadas.','aiosc')?></div>
    <?php endif; ?>
</div>
<script>
    var aiosc_replies_loaded = <?php echo $reply_limit; ?>
</script>
