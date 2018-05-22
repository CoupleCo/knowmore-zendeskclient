<?php

namespace NomorePackage\Zendeskclient;


use Carbon\Carbon;

class UpdateRequestFromTicket  {

    public $requesterModel;
    public $requestModel;
    public $id;
    public $email;
    public $subject;
    public $description;
    public $freshdeskRequesterId;
    public $freshdeskUpdatedAt;
    public $freshdeskCreatedAt;
    public $requester;

    /**
     * @param $id (freshdeskId)
     */
    public function handle($id) {

        $this->id = $id;

        $this->setModels();

        $this->getZendeskInformation();

        $this->getModelInformation();

        return $this->createReturnInput();

    }

    /**
     * Set the database interface models to reflect the different namespsaces of the models
     */
    private function setModels()
    {

        if (class_exists(\App\Models\Client\Requester\Requester::class)) $this->requesterModel = \App\Models\Client\Requester\Requester::class;
        if (class_exists(\App\Models\Client\Requesters::class)) $this->requesterModel = \App\Models\Client\Requesters::class;
        if (is_null($this->requesterModel)) throw new \Exception('Unable to identify requester model');


        // sets the requester model
        if (class_exists(\App\Models\Request\Request::class)) $this->requestModel = \App\Models\Request\Request::class;

        if (is_null($this->requestModel)) throw new \Exception('Unable to identify request model');

    }

    /**
     * Capture information from Zendesk - and abort is information is missing
     */
    private function getZendeskInformation()
    {
        $zendeskResponse = (new Ticket())->find($this->id)->include('users')->get();

        if (!isset($zendeskResponse['ticket'])) abort(403, 'Invalid request id provided');

        foreach ($zendeskResponse['users'] as $user) {
            if ($user->role == 'end-user') {
                $this->email = $user->email;
            }
        }

        $this->subject = $zendeskResponse['ticket']->subject;
        $this->description = $zendeskResponse['ticket']->description;
        $this->freshdeskRequesterId = $zendeskResponse['ticket']->requester_id;
        $this->freshdeskCreatedAt = Carbon::parse($zendeskResponse['ticket']->created_at)->toDateTimeString();
        $this->freshdeskUpdatedAt = Carbon::parse($zendeskResponse['ticket']->updated_at)->toDateTimeString();

    }

    /**
     * Get exisiting local data via the DB
     */
    private function getModelInformation()
    {

        $this->requester = (new $this->requesterModel)->where('email', $this->email)->first();


    }

    /**
     * Prepare and array based on the combined information
     */
    private function createReturnInput()
    {
        return [

            'description' => $this->description,
            'subject' => $this->subject,
            'requesterEmail' => $this->email,
            'freshdeskUpdate' =>$this->freshdeskUpdatedAt,
            'freshdeskCreated' =>  $this->freshdeskCreatedAt,
            'companyId' => is_null($this->requester) ? null : $this->requester->companyId,
            'requesterId' => is_null($this->requester) ? null : $this->requester->id,
            'freshdeskRequesterId' =>  $this->freshdeskRequesterId,
            'freshdeskId' => $this->id,

        ];
    }


}