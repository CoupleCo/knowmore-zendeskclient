<?php

namespace NomorePackage\Zendeskclient;

/**
 * reference: https://developer.zendesk.com/rest_api/docs/core/tickets
 */
class Ticket extends ZenDeskUtility {

    private $with;

    private $search;

    private $query_sign = '?';

    public function create($description, $subject, $email, $priority = 'normal', $public = true) {

        $content = ['ticket' =>
            [
                'subject' => $subject,
                'comment' => ['html_body' => $description, 'public' => $public],
                'requester' => $email,
                'priority' => $priority
            ]];

        return $this->client->request('POST', 'tickets.json', $content);
    }

    public function update($id, $information){

        $content = ['ticket' => $information];

        return $this->client->request('PUT', 'tickets/'. $id.'.json', $content);
    }

    public function get() {

        if (is_null($this->search)) $endpoint = 'tickets';
        else $endpoint = $this->search;

        if (strpos($this->with, '.json') !== false) {

            $tickets = $this->client->request('GET', $endpoint . $this->with);
        } else {
            if (is_null($this->search)) $endpoint .= '.json';

            $tickets = $this->client->request('GET', $endpoint . $this->with);
        }

        $this->with = null;
        $this->search = null;

        return $tickets;
    }

    public function delete() {
        if (is_null($this->with)) abort(403, 'No ticket id specified.');

        // move to deleted
        $response = $this->client->request('DELETE', 'tickets' . $this->with);

        // then delete permanently
        $response = $this->client->request('DELETE', 'deleted_tickets' . $this->with);

        $this->with = null;

        return $response;
    }

    public function destroy_many($ids) {

        if (count($ids) == 0) return;
        elseif (count($ids) == 1) $ticket_string = $ids[0];
        else {
            $pages = ceil(count($ids) / 100);

            if ($pages == 1) $ticket_string = implode(",", $ids);
            else {
                //Not tested, but it's prob gonna work
                for ($i = 0; $i >= $pages; $i++) {

                    $new_ids = array_slice($ids, $i * 100, 100);

                    $ticket_string = implode(",", $new_ids);

                    $response = $this->client->request('DELETE', '/tickets/destroy_many?ids=' . $ticket_string . ', 34567890976543');

                    $response = $this->client->request('DELETE', '/deleted_tickets/destroy_many?ids=' . $ticket_string);
                }
                return;
            }
        }
        // then delete permanently
        $response = $this->client->request('DELETE', '/tickets/destroy_many?ids=' . $ticket_string);

        $response = $this->client->request('DELETE', '/deleted_tickets/destroy_many?ids=' . $ticket_string);

        return $response;
    }


    public function include($include) {

        $this->with .= $this->query_sign . 'include=' . $include;

        $this->query_sign = '&';

        return $this;
    }

    public function find($id) {

        $this->with .= '/' . $id . '.json';

        return $this;
    }

    public function get_custom($endpoint) {

        return $this->client->request('GET', $endpoint);
    }

    public function search($type, $value) {

        $this->search = 'search.json?query=type:ticket ' . $type . ':' . $value;

        $this->query_sign = '&';

        return $this;
    }

}