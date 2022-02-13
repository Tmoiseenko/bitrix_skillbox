<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/*
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */


$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
    'STICKER_ID' => $mainId . '_sticker',
    'BIG_SLIDER_ID' => $mainId . '_big_slider',
    'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId . '_slider_cont',
    'OLD_PRICE_ID' => $mainId . '_old_price',
    'PRICE_ID' => $mainId . '_price',
    'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
    'PRICE_TOTAL' => $mainId . '_price_total',
    'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
    'QUANTITY_ID' => $mainId . '_quantity',
    'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
    'QUANTITY_UP_ID' => $mainId . '_quant_up',
    'QUANTITY_MEASURE' => $mainId . '_quant_measure',
    'QUANTITY_LIMIT' => $mainId . '_quant_limit',
    'BUY_LINK' => $mainId . '_buy_link',
    'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
    'COMPARE_LINK' => $mainId . '_compare_link',
    'TREE_ID' => $mainId . '_skudiv',
    'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
    'OFFER_GROUP' => $mainId . '_set_group_',
    'BASKET_PROP_DIV' => $mainId . '_basket_prop',
    'SUBSCRIBE_LINK' => $mainId . '_subscribe',
    'TABS_ID' => $mainId . '_tabs',
    'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
    'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers) {
    $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
        ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
        : reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['MORE_PHOTO_COUNT'] > 1) {
            $showSliderControls = true;
            break;
        }
    }
} else {
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');


//pre($arResult, 1);
?>
<section class="product-page" itemscope itemtype="http://schema.org/Product">
    <div class="image-block-list">

<!--        сделать лейблы скидо-новинок-итд и тп-->

        <ul class="gallery">
            <?
            if (!empty($actualItem['MORE_PHOTO'])) {
                foreach ($actualItem['MORE_PHOTO'] as $key => $photo) {
                    ?>
                    <li data-thumb="<?= $photo['SRC'] ?>">
                        <img src="<?= $photo['SRC'] ?>" alt="<?= $alt ?>" title="<?= $title ?>" itemprop="image">
                    </li>
                    <?
                }
            }
            ?>
            <?
            if (!empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])) {
                foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $key => $imgId) {
                    $src = CFile::GetPath($imgId);
                    ?>
                    <li data-thumb="<?= $src ?>">
                        <img src="<?= $src ?>" alt="<?= $alt ?>" title="<?= $title ?>" itemprop="image">
                    </li>
                    <?
                }
            }
            ?>
        </ul>
    </div>
    <div class="product-info-block">
        <div class="product-category">
            <a href="<?= $arResult['SECTION']['SECTION_PAGE_URL'] ?>">
                <?= $arResult['SECTION']['NAME'] ?>
            </a>
        </div>
        <?
        if ($arParams['DISPLAY_NAME'] === 'Y') {
            ?>
            <div class="product-name">
                <a href="<?= $arParams['CURRENT_BASE_PAGE'] ?>" itemprop="name"><?= $name ?></a>
            </div>
            <?
        }
        ?>

        <div class="product-info">
            <div data-productid="1" class="rateit" data-rateit-value="2.5"></div>
            <a href="#tab-3" class="review">4 отзыва</a>

            <div class="availability">
                Наличие:
                <span>Есть</span>
                Нет
            </div>
        </div>
        <div class="product-favorites">
            <span class="ui-favorites" data-productid="1">В избранное</span>
            <span class="ui-share-mail" data-productid="1">Отправить другу</span>
        </div>
        <div class="product-description" itemprop="description">
            <?= $arResult['PREVIEW_TEXT'] ?>
        </div>
        <div class="product-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <?= $price['PRINT_PRICE'] ?>
            <meta itemprop="price" content="49 0000">
            <meta itemprop="priceCurrency" content="RUB">
        </div>

        <form action="#" class="product-add">
            <input type="number" name="count" min="1" max="15" value="1">
            <input type="hidden" name="productid" value="1">
            <input type="submit" value="В корзину">
            <input type="submit" class="blue" disabled value="Уже в корзине»">
        </form>

        <div class="tags-list">
            Теги:
            <a href="#">apple</a>
            <a href="#">laptop</a>
            <a href="#">computer</a>
            <a href="#">visuas</a>
            <a href="#">sale</a>
            <a href="#">netebook</a>
            <a href="#">macbook</a>
        </div>
        <div class="social-share">
            Поделится:
            <ul class="social-icon">
                <li><a href="#" class="icon1"></a></li>
                <li><a href="#" class="icon2"></a></li>
                <li><a href="#" class="icon3"></a></li>
                <li><a href="#" class="icon4"></a></li>
                <li><a href="#" class="icon5"></a></li>
            </ul>
        </div>


    </div>

    <div class="tabs-light">
        <ul class="tabs-menu">
            <? if ($showDescription) { ?>
                <li><a href="#description"><?= $arParams['MESS_DESCRIPTION_TAB'] ?></a></li>
                <?
            }
            if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) {
                ?>
                <li><a href="#properties"><?= $arParams['MESS_PROPERTIES_TAB'] ?></a></li>
            <? }
            if ($arParams['USE_COMMENTS'] === 'Y') {
                ?>
                <li><a href="#comments"><?= $arParams['MESS_COMMENTS_TAB'] ?></a></li>
            <? } ?>
        </ul>

        <div class="tabs-content">
            <?
            if ($showDescription) {
            ?>
            <div id="description">
                <?
                if ($arResult['PREVIEW_TEXT'] != '' && ( $arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
                        || ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == ''))) {
                    echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>' . $arResult['PREVIEW_TEXT'] . '</p>';
                }
                if ($arResult['DETAIL_TEXT'] != '') {
                    echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>' . $arResult['DETAIL_TEXT'] . '</p>';
                }
                ?>
            </div>
            <?
            if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) { ?>
                <div id="properties">
                    <? if (!empty($arResult['DISPLAY_PROPERTIES'])) { ?>
                        <dl>
                            <? foreach ($arResult['DISPLAY_PROPERTIES'] as $property) { ?>
                                <dt><?= $property['NAME'] ?></dt>
                                <dd><?= (
                                    is_array($property['DISPLAY_VALUE'])
                                        ? implode(' / ', $property['DISPLAY_VALUE'])
                                        : $property['DISPLAY_VALUE']
                                    ) ?>
                                </dd>
                                <?
                            }
                            unset($property);
                            ?>
                        </dl>
                        <?
                    }

                    if ($arResult['SHOW_OFFERS_PROPS']) {
                        ?>
                        <dl></dl>
                        <?
                    }
                    ?>

                <?
            }

            if ($arParams['USE_COMMENTS'] === 'Y') {
                ?>
                <div id="comments">
                    <?
                    $componentCommentsParams = array(
                        'ELEMENT_ID' => $arResult['ID'],
                        'ELEMENT_CODE' => '',
                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                        'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
                        'URL_TO_COMMENT' => '',
                        'WIDTH' => '',
                        'COMMENTS_COUNT' => '5',
                        'BLOG_USE' => $arParams['BLOG_USE'],
                        'FB_USE' => $arParams['FB_USE'],
                        'FB_APP_ID' => $arParams['FB_APP_ID'],
                        'VK_USE' => $arParams['VK_USE'],
                        'VK_API_ID' => $arParams['VK_API_ID'],
                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                        'CACHE_TIME' => $arParams['CACHE_TIME'],
                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                        'BLOG_TITLE' => '',
                        'BLOG_URL' => $arParams['BLOG_URL'],
                        'PATH_TO_SMILE' => '',
                        'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
                        'AJAX_POST' => 'Y',
                        'SHOW_SPAM' => 'Y',
                        'SHOW_RATING' => 'N',
                        'FB_TITLE' => '',
                        'FB_USER_ADMIN_ID' => '',
                        'FB_COLORSCHEME' => 'light',
                        'FB_ORDER_BY' => 'reverse_time',
                        'VK_TITLE' => '',
                        'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
                    );
                    if (isset($arParams["USER_CONSENT"]))
                        $componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
                    if (isset($arParams["USER_CONSENT_ID"]))
                        $componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
                    if (isset($arParams["USER_CONSENT_IS_CHECKED"]))
                        $componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
                    if (isset($arParams["USER_CONSENT_IS_LOADED"]))
                        $componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
                    $APPLICATION->IncludeComponent(
                        'bitrix:catalog.comments',
                        '',
                        $componentCommentsParams,
                        $component,
                        array('HIDE_ICONS' => 'Y')
                    );
                    ?>
                </div>
            <? } ?>
            <? } ?>
        </div>

    </div>


</section>
