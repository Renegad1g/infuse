<?

use \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Config\Option,
    \Bitrix\Main\Loader,
    \Bitrix\Main\ModuleManager,
    \Bitrix\Main\EventManager;

Loc::loadMessages( Loader::getLocal( "modules/infuse.test/include.php" ) );

class infuse_test extends \CModule
{
    const MODULE_ID = 'infuse.test';

    function __construct()
    {
        $arModuleVersion = [];

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_ID = self::MODULE_ID;
        $this->MODULE_NAME = Loc::getMessage(self::MODULE_ID.'_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage(self::MODULE_ID.'_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = '';
        $this->PARTNER_URI = '';
    }

    function installEvents()
    {
        EventManager::getInstance()->registerEventHandler(
            'rest',
            'OnRestServiceBuildDescription',
            self::MODULE_ID,
            '\Infuse\Test\Events',
            'OnRestServiceBuildDescriptionHandler'
        );
    }
	
    function UnInstallEvents()
    {
        EventManager::getInstance()->unRegisterEventHandler(
            'rest',
            'OnRestServiceBuildDescription',
            self::MODULE_ID,
            '\Infuse\Test\Events',
            'OnRestServiceBuildDescriptionHandler'
        );
    }
	
    public function uninstallOptions()
    {
        Option::delete(self::MODULE_ID);
    }

    /**
     * Метод-обёртка для установки всех настроек модуля
     * @return void
     */
    function DoInstall()
    {
        $this->InstallFiles();
        ModuleManager::registerModule(self::MODULE_ID);
        $this -> installEvents();
        $this -> installDb();
    }

    /**
     * Метод-обёртка для удаления всех настроек модуля
     * @return void
     */
    function DoUninstall()
    {
        $this -> UnInstallEvents();
        $this -> UnInstallDB();
        $this -> uninstallOptions();
        ModuleManager::unRegisterModule(self::MODULE_ID);
        $this->UnInstallFiles();
    }
}