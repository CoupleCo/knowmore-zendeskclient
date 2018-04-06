<?php
/**
 * Created by IntelliJ IDEA.
 * User: Emilo
 * Date: 04-04-2018
 * Time: 12:20
 */

namespace NomorePackage\Zendeskclient;

/**
 * reference: https://developer.zendesk.com/rest_api/docs/core/ticket_comments
 */
class TicketComment extends ZenDeskUtility
{

    public function replyToTicket($ticket_id, $message) {

        $content = ['ticket' => ['comment' => ['html_body' => $message, 'public' => true]]];

        $url = 'tickets/' . $ticket_id . '.json';

        return ['success' => true, 'data' => $this->client->request('PUT', $url, $content)];
    }

    public function createTicketNote($ticket_id, $message){

        $content = ['ticket' => ['comment' => ['html_body' => $message, 'public' => false]]];

        $url = 'tickets/' . $ticket_id . '.json';

        return ['success' => true, 'data' => $this->client->request('PUT', $url, $content)];

    }
}