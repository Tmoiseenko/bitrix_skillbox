<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="works-block">
    <div class="container">
        <?php foreach ($arResult['ITEMS'] as $item):?>
        <div class="work-item item-<?=$item['CODE']?>">
            <p><?=$item['NAME']?></p>
            <span><?=$item['PREVIEW_TEXT']?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>
