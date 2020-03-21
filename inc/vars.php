<?php
/** URL for getting purchasable plugins */
define('AIOSC_DIWAVE_ADDONS_URL','http://diwave-coders.com/addon-list.php');
/**
 * Class aiosc_tables
 * Tables that AIO Support Center uses
 *
 * @update 2.0
 */
abstract class aiosc_tables {
    const tickets = 'aiosc_tickets';
    const replies = 'aiosc_replies';
    const departments = 'aiosc_departments';
    const priorities = 'aiosc_priorities';
    const uploads = 'aiosc_uploads';
    const premade_responses = 'aiosc_premades';

    /** @since 2.0 */
    const cron = 'aiosc_cron';
}

/**
 * These are content tags that will be replaced with correct values.
 * Usually used in e-mail templates (auto-responders)
 * Tag must be used like {%TAG_NAME%}
 *
 * @filter aiosc_content_tags
 * @return mixed|void
 */
function aiosc_get_content_tags() {
    $tags = array(
        'ticket'=>array(
            'label'=>__('Ticket','aiosc'),
            'fields'=>array(
                'ticket.url'=>__('URL','aiosc'),
                'ticket.front_url'=>__('URL de Inicio','aiosc'),
                'ticket.dynamic_url'=>__('URL Dinámica','aiosc'),
                'ticket.id'=>__('ID','aiosc'),
                'ticket.priority.name'=>__('Nombre de Prioridad','aiosc'),
                'ticket.priority.id'=>__('ID de Prioridad','aiosc'),
                'ticket.priority.level'=>__('Nivel de Prioridad','aiosc'),
                'ticket.priority.color'=>__('Color de Prioridad','aiosc'),
                'ticket.department.name'=>__('Nombre de Departamento','aiosc'),
                'ticket.department.id'=>__('ID de Departamento','aiosc'),
                'ticket.subject'=>__('Asunto','aiosc'),
                'ticket.content'=>__('Contenido','aiosc'),
                'ticket.status'=>__('Estado','aiosc'),
                'ticket.date.created'=>__('Fecha de Creación','aiosc'),
                'ticket.date.open'=>__('Fecha Abierto','aiosc'),
                'ticket.date.closed'=>__('Fecha Cerrado','aiosc'),
                'ticket.closure_note'=>__('Nota de Cierre','aiosc'),
                'ticket.scheduled_closure.days'=>__('Cierre Programado (días)', 'aiosc'),
                'ticket.scheduled_closure.date'=>__('Cierre Programado (fecha)', 'aiosc'),
                'ticket.scheduled_closure.datetime'=>__('Cierre Programado (fecha y hora)', 'aiosc'),
                'ticket.attachments.count'=>__('Contador de Archivos Adjuntos','aiosc'),
                'ticket.attachments.size'=>__('Tamaño de los Archivos Adjuntos (en Kb)','aiosc')
            )
        ),
        'reply'=>array(
            'label'=>__('Respuesta','aiosc'),
            'fields'=>array(
                'reply.id'=>__('ID','aiosc'),
                'reply.content'=>__('Contenido','aiosc'),
                'reply.date.created'=>__('Fecha de Publicación','aiosc'),
                'reply.attachments.count'=>__('Contador de Archivos Adjuntos','aiosc'),
                'reply.attachments.size'=>__('Tamaño de los Archivos Adjuntos (en Kb)','aiosc')
            )
        ),
        'customer'=>array(
            'label'=>__('Cliente','aiosc'),
            'fields'=>array(
                'customer.id'=>__('ID','aiosc'),
                'customer.first_name'=>__('Nombre','aiosc'),
                'customer.last_name'=>__('Apellido','aiosc'),
                'customer.display_name'=>__('Nombre para Mostrar','aiosc'),
                'customer.email'=>__('Dirección de Correo Electrónico','aiosc'),
                'customer.role'=>__('Rol Ticket System','aiosc'),
                'customer.url'=>__('URL de Perfil','aiosc')
            )
        ),
        'operator'=>array(
            'label'=>__('Operador','aiosc'),
            'fields'=>array(
                'operator.id'=>__('ID','aiosc'),
                'operator.first_name'=>__('Nombre','aiosc'),
                'operator.last_name'=>__('Apellido','aiosc'),
                'operator.display_name'=>__('Nombre para Mostrar','aiosc'),
                'operator.email'=>__('Dirección de Correo Electrónico','aiosc'),
                'operator.role'=>__('Rol Ticket System','aiosc'),
                'operator.url'=>__('URL de Perfil','aiosc')
            )
        ),
        'misc'=>array(
            'label'=>__('Variados','aiosc'),
            'fields'=>array(
                'site.name'=>__('Nombre del Sitio','aiosc'),
                'site.url'=>__('URL de Sitio','aiosc'),
                'login.url'=>__('URL de Inicio de Sesión','aiosc'),
                'aiosc.my_tickets'=>__('URL de Mis Tickets','aiosc'),
                'aiosc.new_ticket'=>__('Nueva URL del Ticket','aiosc'),
                'aiosc.my_tickets_front'=>__('URL de Mis Tickets de Inicio','aiosc'),
                'aiosc.new_ticket_front'=>__('Nueva URL del Ticket de Inicio','aiosc'),
                'date.now'=>__('Fecha Actual','aiosc'),
                'date.year'=>__('Año de Fecha Actual','aiosc'),
                'date.month'=>__('Mes de Fecha Actual','aiosc'),
                'time.now'=>__('Horario Actual','aiosc')
            )
        )
    );
    return apply_filters('aiosc_content_tags',$tags);
}
