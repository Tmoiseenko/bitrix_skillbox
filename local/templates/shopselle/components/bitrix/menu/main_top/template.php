<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>


<? if (!empty($arResult)): ?>
    <nav itemscope itemtype="http://schema.org/SiteNavigationElement">
        <ul>

            <?
            $previousLevel = 0;
            foreach ($arResult

            as $arItem): ?>

            <? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel): ?>
                <?= str_repeat("</ul></div></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
            <? endif ?>

            <? if ($arItem["IS_PARENT"]): ?>

            <? if ($arItem["DEPTH_LEVEL"] == 1): ?>
            <li class="sub-menu popap-show <?= $arItem["SELECTED"] ? 'active' : '' ?>">
                <a itemprop="url"><?= $arItem["TEXT"] ?></a>
            <div class="popap-block">
                <ul>
                    <? else: ?>
                    <li class="<?= $arItem["SELECTED"] ? 'active' : '' ?>"><a href="<?= $arItem["LINK"] ?>"
                                                                              itemprop="url"><?= $arItem["TEXT"] ?></a>
                    </li>
                    <div class="popap-block">
                        <ul>
                            <? endif ?>

                            <? else: ?>

                                <? if ($arItem["PERMISSION"] > "D"): ?>

                                    <? if ($arItem["DEPTH_LEVEL"] == 1): ?>
                                        <li class="<?= $arItem["SELECTED"] ? 'active' : '' ?>"><a href="<?= $arItem["LINK"] ?>" itemprop="url"><?= $arItem["TEXT"] ?></a>
                                        </li>
                                    <? else: ?>
                                        <li class="<?= $arItem["SELECTED"] ? 'active' : '' ?>"><a href="<?= $arItem["LINK"] ?>" itemprop="url"><?= $arItem["TEXT"] ?></a>
                                        </li>
                                    <? endif ?>

                                <? else: ?>

                                    <? if ($arItem["DEPTH_LEVEL"] == 1): ?>
                                        <li>
                                            <a href="" title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>">
                                                <?= $arItem["TEXT"] ?>
                                            </a>
                                        </li>
                                    <? else: ?>
                                        <li>
                                            <a href="" class="denied"
                                               title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>">
                                                <?= $arItem["TEXT"] ?>
                                            </a>
                                        </li>
                                    <? endif ?>

                                <? endif ?>

                            <? endif ?>

                            <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

                            <? endforeach ?>

                            <? if ($previousLevel > 1)://close last item tags?>
                                <?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
                            <? endif ?>

                        </ul>
    </nav>
<? endif ?>

