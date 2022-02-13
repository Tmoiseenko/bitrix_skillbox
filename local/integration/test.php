<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Test page"); ?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.location.selector.steps", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"ID" => "",
		"CODE" => "",
		"INPUT_NAME" => "LOCATION",
		"PROVIDE_LINK_BY" => "id",
		"PRESELECT_TREE_TRUNK" => "N",
		"PRECACHE_LAST_LEVEL" => "N",
		"FILTER_BY_SITE" => "N",
		"SHOW_DEFAULT_LOCATIONS" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"JS_CONTROL_GLOBAL_ID" => "",
		"JS_CALLBACK" => "",
		"SUPPRESS_ERRORS" => "N",
		"DISABLE_KEYBOARD_INPUT" => "N",
		"INITIALIZE_BY_GLOBAL_EVENT" => ""
	),
	false
);?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>