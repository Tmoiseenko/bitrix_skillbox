<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<?
if (is_array($arResult['ITEMS']) && count($arResult['ITEMS']) > 0):
?>
<div class="aside-nav">
    <h1>Выберите категорию</h1>
<ul>
<?
	foreach ($arResult['ITEMS'] as $arItem):

?>
    <li><a href="<?=$arItem['DETAIL_URL']?>"><?=$arItem['NAME']?></a></li>
<?
	endforeach;
?>
</ul>
</div>
<?
endif;
?>
