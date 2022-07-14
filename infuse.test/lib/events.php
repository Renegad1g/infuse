<?php

namespace Infuse\Test;

class Events
{
    public static function OnRestServiceBuildDescriptionHandler()
    {
        $return = [];
        $users = (new Helper)->getUsersForScope();
        foreach($users as $userId) {
            $return[$userId] = [
                'get.username.vowels' => [
                    'callback' => [__CLASS__, 'getVowels'],
                    'options' => [],
                ]
            ];
        }

        return $return;
    }

    public static function getVowels($query, $nav, \CRestServer $server)
    {
        if($query['error'])
        {
            throw new \Bitrix\Rest\RestException(
                'Message',
                'ERROR_CODE',
                \CRestServer::STATUS_WRONG_REQUEST
            );
        }

        return array('query' => $query, 'response' => (new Helper)->getUserNameVowels($query));
    }
}