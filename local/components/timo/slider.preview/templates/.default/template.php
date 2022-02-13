<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="home-slider-conteiner">
    <div class="home-slider">
        <?php foreach ($arResult['ITEMS'] as $item):
//            vd($item, 1);
            ?>
        <div class="home-slider-item">
            <img src="<?=$item["DETAIL_PICTURE"]['SRC']?>" alt="" class="home-slider-bg">

            <div class="container">
                <a href="#">
                    <img src="<?=$item["PREVIEW_PICTURE"]['SRC']?>" alt="" class="home-slider-content">
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
