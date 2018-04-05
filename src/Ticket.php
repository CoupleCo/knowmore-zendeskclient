<?php
/**
 * Created by IntelliJ IDEA.
 * User: Emilo
 * Date: 04-04-2018
 * Time: 12:17
 */

namespace NomorePackage\zendeskclient;

/**
 * reference: https://developer.zendesk.com/rest_api/docs/core/tickets
 */
class Ticket extends ZenDeskUtility
{

    public function create($description, $subject, $email, $priority = 'normal') {

        $content = ['ticket' =>
            [
                'subject' => $subject,
                'comment' => ['html_body' => $description],
                'requester' => $email,
                'priority' => $priority
            ]];

        return $this->client->request('POST', 'tickets.json', $content);
    }

}