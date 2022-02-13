<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");

?>

<section class="pagination-block">

    <? if ($arResult["bDescPageNumbering"] === true): ?>

        <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
            <? if ($arResult["bSavePage"]): ?>
                <a class="key"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>"><?= GetMessage("nav_begin") ?></a>
                <a class="key"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"><?= GetMessage("nav_prev") ?></a>
            <? else: ?>
                <a class="key"
                   href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= GetMessage("nav_begin") ?></a>
                <? if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"] + 1)): ?>
                    <a class="key"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= GetMessage("nav_prev") ?></a>
                <? else: ?>
                    <a class="key"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"><?= GetMessage("nav_prev") ?></a>
                <? endif ?>
            <? endif ?>
        <? endif ?>

        <span class="pagination-text">Показано
            <?= $arResult["NavFirstRecordShow"] ?> <?= GetMessage("nav_to") ?> <?= $arResult["NavLastRecordShow"] ?> <?= GetMessage("nav_of") ?> <?= $arResult["NavRecordCount"] ?>
 результатов</span>
        <div class="pagination-page">
            <? while ($arResult["nStartPage"] >= $arResult["nEndPage"]): ?>
                <? $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1; ?>

                <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
                    <a class="key active"><?= $NavRecordGroupPrint ?></a>
                <? elseif ($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false): ?>
                    <a class="key"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= $NavRecordGroupPrint ?></a>
                <? else: ?>
                    <a class="key"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"><?= $NavRecordGroupPrint ?></a>
                <? endif ?>

                <? $arResult["nStartPage"]-- ?>
            <? endwhile ?>
        </div>

        <? if ($arResult["NavPageNomer"] > 1): ?>
            <a class="key"
               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"><?= GetMessage("nav_next") ?></a>
            <a class="key"
               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1"><?= GetMessage("nav_end") ?></a>
        <? endif ?>

    <? else: ?>

        <? if ($arResult["NavPageNomer"] > 1): ?>

            <? if ($arResult["bSavePage"]): ?>
                <a class="key"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1"><?= GetMessage("nav_begin") ?></a>
                <a class="key"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"><?= GetMessage("nav_prev") ?></a>
            <? else: ?>
                <a class="key"
                   href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= GetMessage("nav_begin") ?></a>
                <? if ($arResult["NavPageNomer"] > 2): ?>
                    <a class="key"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"><?= GetMessage("nav_prev") ?></a>
                <? else: ?>
                    <a class="key"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= GetMessage("nav_prev") ?></a>
                <? endif ?>

            <? endif ?>

        <? endif ?>

        <span class="pagination-text">Показано
            <?= $arResult["NavFirstRecordShow"] ?> <?= GetMessage("nav_to") ?> <?= $arResult["NavLastRecordShow"] ?> <?= GetMessage("nav_of") ?> <?= $arResult["NavRecordCount"] ?>
 результатов</span>
        <div class="pagination-page">
            <? while ($arResult["nStartPage"] <= $arResult["nEndPage"]): ?>

                <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
                    <a class="key active"><?= $arResult["nStartPage"] ?></a>
                <? elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false): ?>
                    <a class="key"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= $arResult["nStartPage"] ?></a>
                <? else: ?>
                    <a class="key"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"><?= $arResult["nStartPage"] ?></a>
                <? endif ?>
                <? $arResult["nStartPage"]++ ?>
            <? endwhile ?>
        </div>

        <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
            <a class="key"
               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"><?= GetMessage("nav_next") ?></a>&nbsp;
            <a class="key"
               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>"><?= GetMessage("nav_end") ?></a>
        <? endif ?>

    <? endif ?>

    </div>
</section>