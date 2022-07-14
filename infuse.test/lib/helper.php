<?
namespace Infuse\Test;


use \Bitrix\Main\UserTable;

class Helper
{
    const MODULE_ID = 'infuse.test';

    public function getUserNameVowels($userId): string
    {
        $words = UserTable::getRow([
            'filter'  => ['=ID' => $userId],
            'select'  => [
                'WORDS' => (new \Bitrix\Main\ORM\Query\Expression)->concat('NAME', 'LAST_NAME', 'SECOND_NAME')
            ],
            /*SELECT NAME FROM b_user WHERE NAME REGEXP '[aeiouy]/i';*/
        ])['WORDS'];

        return preg_replace('/[^aeiouy]/i', '', $words);
    }

    public function getUsersForScope(): array
    {
        $return = UserTable::getList([
            'select' => ['ID'],
            'cache'  => ['ttl' => 3600]
        ])->fetchAll();

        return array_column($return, 'ID');
    }
}