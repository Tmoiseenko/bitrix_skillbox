<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');
pre('start');
$data = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/local/integration/data/data.xml');
hlbAddElements($data);
pre('end');