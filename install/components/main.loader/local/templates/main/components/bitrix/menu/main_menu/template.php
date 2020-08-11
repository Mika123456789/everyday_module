<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="header-top">
    <div class="container">
        <div class="header-menu">
            <ul class="header-menu-list">

<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<li><a href="<?=$arItem["LINK"]?>" class="header-menu__link goto"><?=$arItem["TEXT"]?></a></li>
	<?else:?>
		<li><a href="<?=$arItem["LINK"]?>" class="header-menu__link goto"><?=$arItem["TEXT"]?></a></li>
	<?endif?>
	
<?endforeach?>

            </ul>
        </div>
    </div>
</div>
<?endif?>