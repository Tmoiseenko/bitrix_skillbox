<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
    <section class="catalog-page">

        <aside class="catalog-filter">

            <?$APPLICATION->IncludeComponent(
                "bitrix:furniture.catalog.index",
                "skillbox",
                array(
                    "COMPONENT_TEMPLATE" => "skillbox",
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "2",
                    "IBLOCK_BINDING" => "section",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000",
                    "CACHE_GROUPS" => "Y"
                ),
                false
            );?>

            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "skillbox",
                array(
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPONENT_TEMPLATE" => "skillbox",
                    "COUNT_ELEMENTS" => "Y",
                    "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                    "FILTER_NAME" => "sectionsFilter",
                    "IBLOCK_ID" => "2",
                    "IBLOCK_TYPE" => "catalog",
                    "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
                    "SECTION_FIELDS" => array(0 => "", 1 => "",),
                    "SECTION_ID" => "",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => array(0 => "", 1 => "",),
                    "SHOW_PARENT_NAME" => "Y",
                    "TOP_DEPTH" => "4",
                    "VIEW_MODE" => "LIST"
                )
            ); ?>


            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.smart.filter",
                "skillbox",
                array(
                    "COMPONENT_TEMPLATE" => "skillbox",
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "2",
                    "SECTION_ID" => "",
                    "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
                    "PREFILTER_NAME" => "smartPreFilter",
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "FILTER_VIEW_MODE" => "vertical",
                    "POPUP_POSITION" => "left",
                    "DISPLAY_ELEMENT_COUNT" => "Y",
                    "SEF_MODE" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "Y",
                    "SAVE_IN_SESSION" => "N",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "PRICE_CODE" => array(
                        0 => "BASE",
                    ),
                    "CONVERT_CURRENCY" => "N",
                    "XML_EXPORT" => "N",
                    "SECTION_TITLE" => "-",
                    "SECTION_DESCRIPTION" => "-"
                ),
                false
            ); ?>

        </aside>

        <?php
        $parameterSort = mb_strtoupper(\Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getQueryList()->get('SORT_BY'));
        switch ($parameterSort) {
            case 'COST':
                $sortField1 = 'catalog_PRICE_' . SKLBOX_SORT_PRICE;
                break;
            case 'NEW':
                $sortField1 = 'SORT';
                break;
            case 'NAME':
            default;
                $sortField1 = 'name';
                $parameterSort = "NAME";
                break;
        }

        $parameterSortDirection = mb_strtoupper(\Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getQueryList()->get('SORT_DIRECTION'));
        switch ($parameterSortDirection) {
            case 'ASC':
                $orderField1 = 'ASC';
                break;
            case 'DESC':
            default;
                $orderField1 = 'DESC';
                $parameterSortDirection = "DESC";
                break;
        }

        $pageElementCount = \Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getQueryList()->get('ON_PAGE');
        switch ($pageElementCount) {
            case '6':
                $onPage = '6';
                break;
            case '3':
                $onPage = '3';
                break;
            case '12':
            default;
                $onPage = '12';
                $pageElementCount = "12";
                break;
        }

        $sortField2 = 'id';
        $orderField2 = 'desc';

        ?>

        <section class="catalog-list">

            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "selleshop_catalog",
                array(
                    "ACTION_VARIABLE" => "action",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "BACKGROUND_IMAGE" => "-",
                    "BASKET_URL" => "/personal/basket.php",
                    "BROWSER_TITLE" => "-",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPATIBLE_MODE" => "Y",
                    "CONVERT_CURRENCY" => "N",
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_COMPARE" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "$sortField1",
                    "ELEMENT_SORT_FIELD2" => "$sortField2",
                    "ELEMENT_SORT_ORDER" => "$orderField1",
                    "ELEMENT_SORT_ORDER2" => "$orderField2",
                    "ENLARGE_PRODUCT" => "STRICT",
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => "2",
                    "IBLOCK_TYPE" => "catalog",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "LAZY_LOAD" => "N",
                    "LINE_ELEMENT_COUNT" => "3",
                    "LOAD_ON_SCROLL" => "N",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_LIMIT" => "5",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "skillbox",
                    "PAGER_TITLE" => "Товары",
                    "PAGE_ELEMENT_COUNT" => "$onPage",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array('BASE'),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                    "PRODUCT_SUBSCRIPTION" => "Y",
                    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                    "RCM_TYPE" => "personal",
                    "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
                    "SECTION_ID" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "SEF_MODE" => "N",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "Y",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "N",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_FROM_SECTION" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "Y",
                    "TEMPLATE_THEME" => "blue",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "COMPONENT_TEMPLATE" => ".default",
                    "SLIDER_INTERVAL" => "3000",
                    "SLIDER_PROGRESS" => "N",
                    "SORT_AVAILABLE" => [
                        'NAME' => 'По Названию',
                        'COST' => 'По Цене',
                        'NEW' => 'По Новизне',
                    ],
                    "SORT_NOW" => $parameterSort,
                    "SORT_NOW_DIRECT" => $parameterSortDirection,
                    "ON_PAGE" => $pageElementCount,
                ),
                false
            ); ?>


        </section>
    </section>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>