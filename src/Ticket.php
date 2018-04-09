<?php
/**
 * Created by IntelliJ IDEA.
 * User: Emilo
 * Date: 04-04-2018
 * Time: 12:17
 */

namespace NomorePackage\Zendeskclient;

/**
 * reference: https://developer.zendesk.com/rest_api/docs/core/tickets
 */
class Ticket extends ZenDeskUtility
{

    private $with;

    private $search;

    private $query_sign = '?';

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

    public function get(){

        if(is_null($this->search)) $endpoint = 'tickets';
        else $endpoint = $this->search;

        if (strpos($this->with, '.json') !== false) {

            $tickets = $this->client->request('GET', $endpoint . $this->with);
        }else{
            if(is_null($this->search)) $endpoint .= '.json';

            $tickets = $this->client->request('GET', $endpoint . $this->with);
            dd($tickets);
        }

        $this->with = null;
        $this->search = null;

        return $tickets;
    }

    public function delete()
    {
        if (is_null($this->with)) abort (403, 'No ticket id specified.');

        // move to deleted
        $response = $this->client->request('DELETE', 'tickets' . $this->with);

        // then delete permanently
        $response = $this->client->request('DELETE', 'deleted_tickets' . $this->with);

        $this->with = null;

        return $response;
    }


    public function include($include){

        $this->with .= $this->query_sign . 'include=' . $include;

        $this->query_sign = '&';

        return $this;
    }

    public function find($id){

        $this->with .= '/' . $id . '.json';

        return $this;
    }

    public function search($type, $value){

        $this->search =  'search.json?query=type:ticket '. $type.':' . $value;

        $this->query_sign = '&';

        return $this;
    }

}