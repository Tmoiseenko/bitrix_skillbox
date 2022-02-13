<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CUser $USER
 * @var SaleOrderAjax $component
 * @var string $templateFolder
 */

$context = Main\Application::getInstance()->getContext();
$request = $context->getRequest();

$typeArr = [
    'STRING' => 'text',
    'NUMBER' => 'number',
    'ADDRESS' => 'text',
    'FILE' => 'file',
    'DATE' => 'date',
];

pre($arResult, 1);

?>
<section class="order-page">
    <form action="<?= POST_FORM_ACTION_URI ?>" method="POST" name="orderForm" enctype="multipart/form-data">

        <?= bitrix_sessid_post() ?>
        <input type="hidden" name="PERSON_TYPE" value="1">
        <input type="hidden" name="PERSON_TYPE_OLD" value="1">

        <div class="block-cell">
            <h1>Заполните заявку</h1>

            <div class="form-line">
                <label>Страна / Область / Район *</label>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:sale.location.selector.steps",
                    "skillbox",
                    Array(
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CODE" => "",
                        "COMPONENT_TEMPLATE" => "skillbox",
                        "DISABLE_KEYBOARD_INPUT" => "N",
                        "FILTER_BY_SITE" => "N",
                        "ID" => "",
                        "INITIALIZE_BY_GLOBAL_EVENT" => "",
                        "INPUT_NAME" => "LOCATION",
                        "JS_CALLBACK" => "",
                        "JS_CONTROL_GLOBAL_ID" => "",
                        "PRECACHE_LAST_LEVEL" => "N",
                        "PRESELECT_TREE_TRUNK" => "N",
                        "PROVIDE_LINK_BY" => "id",
                        "SHOW_DEFAULT_LOCATIONS" => "N",
                        "SUPPRESS_ERRORS" => "N"
                    )
                );?>
            </div>

            <?php foreach ($arResult['JS_DATA']['ORDER_PROP']['properties'] as $key => $input): ?>
                <?php if ($input['CODE'] == 'ADDRESS'): ?>
                    <div class="form-line">
                        <label><?= $input["NAME"] ?> <?= $input["REQUIRED"] ? '*' : '' ?></label>
                        <input
                                name="ORDER_PROP_<?= $input["ID"] ?>"
                                type="<?= $typeArr[$input["TYPE"]] ?>"
                                value="<?= $input["VALUE"][0] ?>"
                        >
                    </div>
                <?php endif ?>
            <?php endforeach; ?>

            <div class="form-line two-line">
                <?php $i = 0;
                foreach ($arResult['JS_DATA']['ORDER_PROP']['properties'] as $key => $input): ?>
                <?php if ($input['CODE'] != 'ADDRESS'): ?>
                    <div class="two-block">
                        <label><?= $input["NAME"] ?> <?= $input["REQUIRED"] == 'Y' ? '*' : '' ?></label>
                        <input
                                name="ORDER_PROP_<?= $input["ID"] ?>"
                                type="<?= $typeArr[$input["TYPE"]] ?>"
                                value="<?= $input["VALUE"][0] ?>"
                            <?= $input['CODE'] == 'PHONE' ? 'placeholder="+7 (999) 000-00-00"' : '' ?>
                        >
                    </div>
                <?php endif ?>
                <?php
                $i++;
                if (($i % 2) == 0) :
                ?>
                    </div>
                    <div class="form-line two-line">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <table class="price-total padding">
                <tr>
                    <th colspan="2">Итого</th>
                </tr>
                <tr>
                    <td class="title">Итог</td>
                    <td>120 000 руб</td>
                </tr>
                <tr>
                    <td class="title">Доставка</td>
                    <td>
                        <span class="color green">Бесплатная доставка</span>
                    </td>
                </tr>
                <tr>
                    <td class="title">Стоимость заказа</td>
                    <td>
                        <span class="color blue">12 000 руб</span>
                    </td>
                </tr>
            </table>

        </div>

        <div class="block-cell">

            <h2>Как оплатите?</h2>

            <div class="form-line payment-block">
                <?php foreach ($arResult['PAY_SYSTEM'] as $key => $input): ?>
                <div class="payment-item">
                    <label>
                        <input
                                name="PAY_SYSTEM_ID"
                                type="radio"
                                class="circle"
                                value="<?= $input["ID"] ?>"
                                <?= isset($input["CHECKED"]) ? "checked" : "" ?>
                        >
                        <?= $input["NAME"] ?>
                        <div class="payment-text">
                            <?= $input["DESCRIPTION"] ?>
                        </div>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>

            <h2>Как доставить?</h2>

            <div class="form-line payment-block">
                <?php foreach ($arResult['DELIVERY'] as $key => $input): ?>
                    <div class="payment-item">
                        <label>
                            <input
                                    name="DELIVERY_ID"
                                    type="radio"
                                    class="circle"
                                    value="<?= $input["ID"] ?>"
                                <?= isset($input["CHECKED"]) ? "checked" : "" ?>
                            >
                            <?= $input["NAME"] ?>
                            <div class="payment-text">
                                <?= $input["DESCRIPTION"] ?>
                            </div>
                        </label>
                    </div>
                <?php endforeach; ?>
            <div class="form-line">
                <input type="submit" value="Оформить заказ">
            </div>


        </div>

    </form>
    <?
    $signer = new Main\Security\Sign\Signer;
    $signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.order.ajax');
    $messages = Loc::loadLanguageFile(__FILE__);
    ?>
    <script>
        let sign = '<?=CUtil::JSEscape($signedParams)?>'
    </script>

</section>