<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Skillbox шаблон");
?>
<?$APPLICATION->IncludeComponent(
    "timo:slider.preview",
    "",
    Array(
        "CACHE_TIME" => 0,
        "IBLOCK_ID" => 4
    )
);?>
<?$APPLICATION->IncludeComponent(
	"timo:steps.preview", 
	".default", 
	array(
		"CACHE_TIME" => "86400",
		"IBLOCK_ID" => "5",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
