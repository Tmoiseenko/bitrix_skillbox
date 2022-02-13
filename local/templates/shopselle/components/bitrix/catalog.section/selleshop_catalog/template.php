<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

    <h1><?= $arResult['NAME'] ?></h1>


    <form action="#" class="form-sort">
        <label>Сортировать по</label>
        <select id="js_sort_field" class="sort">
            <?php foreach ($arParams['SORT_AVAILABLE'] as $key => $name): ?>
            <option
                    value="<?= $APPLICATION->GetCurPageParam('SORT_BY=' . $key, ['SORT_BY']) ?>"
                    <?php if($key == $arParams['SORT_NOW']): ?> selected="selected" <?php endif; ?>
            >
                <?= $name ?>
            </option>
            <?php endforeach; ?>
        </select>


        <select id="js_sort_direction" class="sort">
            <option value="<?= $APPLICATION->GetCurPageParam('SORT_DIRECTION=ASC', ['SORT_DIRECTION']) ?>"
                    <?php if("ASC" == $arParams['SORT_NOW_DIRECT']): ?> selected="selected" <?php endif; ?>
            >По возрастанию</option>
            <option value="<?= $APPLICATION->GetCurPageParam('SORT_DIRECTION=DESC', ['SORT_DIRECTION']) ?>"
                    <?php if("DESC" == $arParams['SORT_NOW_DIRECT']): ?> selected="selected" <?php endif; ?>
            >По убыванию</option>
        </select>


        <label>Показать</label>
        <select id="js_on_page" class="sort">
            <option value="<?= $APPLICATION->GetCurPageParam('ON_PAGE=3', ['ON_PAGE']) ?>"
            <?php if("3" == $arParams['ON_PAGE']): ?> selected="selected" <?php endif; ?>
            >3 на странице</option>

            <option value="<?= $APPLICATION->GetCurPageParam('ON_PAGE=6', ['ON_PAGE']) ?>"
            <?php if("6" == $arParams['ON_PAGE']): ?> selected="selected" <?php endif; ?>
            >6 на странице</option>

            <option value="<?= $APPLICATION->GetCurPageParam('ON_PAGE=12', ['ON_PAGE']) ?>"
            <?php if("12" == $arParams['ON_PAGE']): ?> selected="selected" <?php endif; ?>
            >12 на странице</option>

        </select>
    </form>


    <!--товары-->
<?php
$odd = 2;
foreach ($arResult['ITEMS'] as $key => $item): ?>
    <article class="product-item <? if (($key +1) == $odd): $odd = $odd + 3; ?> odd <? endif; ?>" itemscope itemtype="http://schema.org/Product">
        <? if ($item["MIN_PRICE"]['DISCOUNT_DIFF']): ?><div class="attr discount"></div> <? endif; ?>
        <? if ($item["PROPERTIES"]['SALELEADER']['PROPERTY_VALUE_ID']): ?><div class="attr top"></div> <? endif; ?>
        <? if ($item["PROPERTIES"]['NEWPRODUCT']['PROPERTY_VALUE_ID']): ?><div class="attr new"></div> <? endif; ?>
        <? if (false): ?><div class="attr sale"></div> <? endif; ?>
        <div class="image-block">
            <a href="<?= $item['DETAIL_PAGE_URL'] ?>">
                <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>"
                     alt="<?= $item['DETAIL_PICTURE']['ALT'] ?>"
                     itemprop="image">
            </a>
        </div>
        <div class="product-block">
            <div class="product-info">
                <a href="<?= $arResult['SECTION_PAGE_URL'] ?>"><?= $arResult['NAME'] ?></a>
                <div data-productid="1" class="rateit" data-rateit-value="2.5"></div>
            </div>
            <div class="product-name">
                <a href="<?= $item['DETAIL_PAGE_URL'] ?>" itemprop="name"><?= $item['NAME'] ?></a>
            </div>
            <div class="product-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <?= $item['MIN_PRICE']['PRINT_VALUE'] ?>
                <meta itemprop="price" content="<?= $item['MIN_PRICE']['DISCOUNT_VALUE'] ?>">
                <meta itemprop="priceCurrency" content="<?= $item['MIN_PRICE']['CURRENCY'] ?>">
            </div>
            <meta itemprop="description" content="Обязательно указывайте описание товара">
            <form action="#" class="product-add">
                <input type="hidden" name="productid" value="1">
                <input type="hidden" name="count" value="1">
                <input type="submit" class="small" value="В корзину">
                <span class="ui-favorites">В избранное</span>
            </form>
        </div>
    </article>
<?php endforeach; ?>

<?= $arResult['NAV_STRING'] ?>
