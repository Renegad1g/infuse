<?
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;
Loc::loadMessages(__FILE__);

if( !Loader::includeModule("crm") ) {
    return;
}

Loader::registerAutoLoadClasses(
    basename(__DIR__),
    [
        "\Infuse\Test\Helper" => "lib/helper.php",
        "\Infuse\Test\Events" => "lib/events.php",
        "\Infuse\Test\Controller\TestActions" => "lib/controller/testactions.php",
    ]
);