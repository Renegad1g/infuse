<?php

namespace Infuse\Test;

class Events
{
    public static function OnRestServiceBuildDescriptionHandler()
    {
        \Bitrix\Main\Loader::includeModule('rest');
        $return = [];
        $users = (new Helper)->getUsersForScope();
        AddMessage2Log($users);
        foreach($users as $userId) {
            $return = [
                $userId => [
                    'get.username.vowels' => [
                        'callback' => [__CLASS__, 'getVowels'],
                        'options' => [],
                    ],
                ]
            ];
        }
        echo '<pre style="display: block;padding: 9.5px;margin: 0 0 10px;font-size: 13px;line-height: 1.428571429;word-break: break-all;word-wrap: break-word;color: #333;background-color: #f5f5f5;border: 1px solid #ccc;border-radius: 4px;overflow: auto;white-space: pre;">';
        var_dump($return);
        echo '</pre>';
        die();
        return $return;
    }

    public static function getVowels($query, $nav, \CRestServer $server)
    {
        AddMessage2Log($query);
        if($query['error'])
        {
            throw new \Bitrix\Rest\RestException(
                'Message',
                'ERROR_CODE',
                \CRestServer::STATUS_WRONG_REQUEST
            );
        }

        return array('query' => $query, 'response' => (new Helper)->getUserNameVowels(1594));
    }
}