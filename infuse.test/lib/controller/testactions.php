<?
namespace Infuse\Test\Controller;

use \Bitrix\Main\Engine\Controller;
use \Infuse\Test\Helper;

class TestActions extends Controller
{
    public function configureActions()
    {
        return [
            'getUserNameVowels' => [
                'prefilters' => []
            ]
        ];
    }

    /**
     * Метод-обёртка для реализации вызова метода \Infuse\Test\Helper::getUserNameVowels()
     * @param $userId
     * @return string
     */
    public function getUserNameVowelsAction($userId): string
    {
        return (new Helper)->getUserNameVowels($userId);
    }
}