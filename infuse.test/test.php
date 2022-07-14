<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;
$APPLICATION->ShowHead();

\Bitrix\Main\Loader::includeModule('infuse.test');
var_dump((new \Infuse\Test\Helper)->getUserNameVowels(1594));
?>
    <script type="text/javascript">
        let vowels = BX.ajax.runAction('infuse:test.api.TestActions.getUserNameVowels', {data:{
                userId: '1594'
            }});
        console.log(vowels);
    </script>
<?php
