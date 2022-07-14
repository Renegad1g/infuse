<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader,
    \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Config\Option,
    \Pri\Tools\Options;

$moduleId = basename( __DIR__ );
$moduleLangPrefix = strtoupper(str_replace(".", "_", $moduleId));

Loc ::loadMessages( __FILE__ );
global $APPLICATION;
if ( $APPLICATION -> GetGroupRight( $moduleId ) < "R" )
{
    $APPLICATION -> AuthForm( Loc ::getMessage( "ACCESS_DENIED" ) );
}

Loader ::includeModule( $moduleId );


$aTabs = [];

if ($request->isPost() && check_bitrix_sessid()) {
    if (strlen($request[ 'save' ]) > 0) {
        Option::delete($moduleId);
        foreach ( $aTabs as $arTab )
        {
            if($arTab["TYPE"] != 'rights')
                __AdmSettingsSaveOptions( $moduleId, $arTab['OPTIONS']);
        }
        Options::clearCache();
        Options::get();
    }
}
$tabControl = new CAdminTabControl( 'tabControl', $aTabs );
$realModuleId = $moduleId;
?>
<form method='post' action='<? echo $APPLICATION -> GetCurPage() ?>?mid=<?= $moduleId ?>&amp;lang=<?= $request[ 'lang' ] ?>'
      name='<?= $moduleId ?>_settings'>
    <? $tabControl -> Begin(); ?>
    <?
    foreach ( $aTabs as $aTab ):
        $tabControl -> BeginNextTab();
        ?>
        <?
        if ( $aTab[ 'OPTIONS' ] ):
            __AdmSettingsDrawList( $moduleId, $aTab[ 'OPTIONS' ] );
        elseif( $aTab["TYPE"] == 'rights' ):
            $table_id = $moduleId ."_". strtolower( $aTab["POSTFIX"] );
            require( __DIR__ . "/table_rights.php" );
            $moduleId = $realModuleId;
        endif;?>

    <?endforeach;
    ?>
    <?= bitrix_sessid_post();
    $tabControl -> Buttons( array( 'btnApply' => false, 'btnCancel' => false, 'btnSaveAndAdd' => false, "btnSave" => true ) );
    ?>
    <? $tabControl -> End(); ?>

    <?//need for tab_rights. If in $_REQUEST hasn't Update -> rights do not save?>
    <input type="hidden" name="Update" value="Y" />
</form>
