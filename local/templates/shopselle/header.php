<?php
use \Bitrix\Main\Page\Asset;
$asset = Asset::getInstance();
$asset->addCss(CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/css/application.css'));
$asset->addJs(CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/js/jquery.min.js'));
$asset->addJs(CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/js/application.min.js'));
CJSCore::Init(array('ajax'));
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php $APPLICATION->ShowTitle() ?></title>
    <?php $APPLICATION->ShowHead(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1250">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic&subset=latin,cyrillic" rel="stylesheet" type="text/css">
<!--    <link rel="stylesheet" href="css/application.css">-->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<div id="panel">
    <?php $APPLICATION->ShowPanel(); ?>
</div>
<body>
<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="main">

    <!--Header-->
    <header id="header" itemscope itemtype="http://schema.org/Organization">
        <div class="wrapper header-top">
            <div class="container">
                <nav>
                    <a href="#" class="button mini">Вход</a>
                    <a href="#" class="button mini gray">Регистрация</a>
                </nav>
                <div class="favorites popap-show">
                    <span>Избранное (3)</span>
                    <div class="popap-block">
                        <ul class="favorites-popap">
                            <li>
                                <div class="favorites-info">
                                    <div class="favorites-name">
                                        <a href="#">Tabletus sus 64GB</a>
                                    </div>
                                    <div class="favorites-price">
                                        30 000 руб.
                                    </div>
                                </div>
                                <div class="image-block mini" itemscope itemtype="http://schema.org/ImageObject">
                                    <a href="#">
                                        <img src="temp/product-1.png" alt="" itemprop="image">
                                    </a>
                                </div>
                                <div class="favorites-cart">
                                    <form action="#" method="post">
                                        <input type="hidden" name="product_id" value="1">
                                        <input type="hidden" name="count" value="1">
                                        <input type="submit" value="Добавить">
                                    </form>
                                </div>
                            </li>
                            <li>
                                <div class="favorites-info">
                                    <div class="favorites-name">
                                        <a href="#">Monoblok Full HD 28</a>
                                    </div>
                                    <div class="favorites-price">
                                        30 000 руб.
                                    </div>
                                </div>
                                <div class="image-block mini" itemscope itemtype="http://schema.org/ImageObject">
                                    <a href="#">
                                        <img src="temp/product-2.png" alt="" itemprop="image">
                                    </a>
                                </div>
                                <div class="favorites-cart">
                                    <form action="#" method="post">
                                        <input type="hidden" name="product_id" value="1">
                                        <input type="hidden" name="count" value="1">
                                        <input type="submit" value="Добавить">
                                    </form>
                                </div>
                            </li>
                            <li>
                                <div class="favorites-info">
                                    <div class="favorites-name">
                                        <a href="#">McBakus 17 500GB</a>
                                    </div>
                                    <div class="favorites-price">
                                        30 000 руб.
                                    </div>
                                </div>
                                <div class="image-block mini" itemscope itemtype="http://schema.org/ImageObject">
                                    <a href="#">
                                        <img src="temp/product-3.png" alt="" itemprop="image">
                                    </a>
                                </div>
                                <div class="favorites-cart">
                                    <form action="#" method="post">
                                        <input type="hidden" name="product_id" value="1">
                                        <input type="hidden" name="count" value="1">
                                        <input type="submit" value="Добавить">
                                    </form>
                                </div>
                            </li>
                            <li class="favorites-clear">
                                <form action="#" method="post">
                                    <input type="submit" class="gray small" value="Очистить список">
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="user popap-show">
                    <a href="#">Профиль</a>
                    <div class="popap-block">
                        <form action="#" method="post" class="popap-form">
                            <div class="form-line">
                                <input type="text" placeholder="Логин или E-mail">
                            </div>
                            <div class="form-line">
                                <input type="password" placeholder="Пароль">
                            </div>
                            <div class="form-line">
                                <label for="check">
                                    <input type="checkbox" name="check" class="gray">
                                    Запомнить меня
                                </label>
                            </div>
                            <div class="form-line">
                                <input type="submit" class="button small" value="Вход">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="info">
                <span class="tel" itemprop="telephone">
                  8 (999) 000 00 00
                </span>
                    <span class="email" itemprop="email">
                  info@shopselle.com
                </span>
                </div>
            </div>
        </div>
        <div class="wrapper header-nav">
            <div class="container">
                <a href="#" class="logo" itemprop="url">
                    <img src="<?=SITE_TEMPLATE_PATH?>/images/logo.png" alt="" itemprop="logo">
                    <meta itemprop="name" content="Shopselle">
                    <meta itemprop="address" content="Москва">
                </a>


                <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"main_top", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "shopsell_top_menu",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "shopsell_top_menu",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "main_top"
	),
	false
);?>

                <?$APPLICATION->IncludeComponent(
                    "bitrix:sale.basket.basket.line",
                    "shopsell_basket",
                    Array(
                        "COMPONENT_TEMPLATE" => "shopsell_basket",
                        "HIDE_ON_BASKET_PAGES" => "Y",
                        "PATH_TO_AUTHORIZE" => "",
                        "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                        "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                        "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                        "PATH_TO_PROFILE" => SITE_DIR."personal/",
                        "PATH_TO_REGISTER" => SITE_DIR."login/",
                        "POSITION_FIXED" => "N",
                        "SHOW_AUTHOR" => "N",
                        "SHOW_EMPTY_VALUES" => "Y",
                        "SHOW_NUM_PRODUCTS" => "Y",
                        "SHOW_PERSONAL_LINK" => "Y",
                        "SHOW_PRODUCTS" => "N",
                        "SHOW_REGISTRATION" => "N",
                        "SHOW_TOTAL_PRICE" => "Y"
                    )
                );?>
                <!--пустая без active и a-->
                <!--<div class="cart-icon"></div>-->
            </div>
        </div>
        <div class="wrapper nav-block">
            <div class="container">
                <nav itemscope itemtype="http://schema.org/SiteNavigationElement">
                    <ul>
                        <li>
                            <a href="#" itemprop="url">Моноблоки</a>
                        </li>
                        <li>
                            <a href="#" itemprop="url">Ноутбуки</a>
                            <img src="temp/menu-top.png" alt="">
                        </li>
                        <li>
                            <a href="#" itemprop="url">Планшеты</a>
                        </li>
                        <li>
                            <a href="#" itemprop="url">Телефоны</a>
                            <img src="temp/menu-new.png" alt="">
                        </li>
                        <li>
                            <a href="#" itemprop="url">Гаджеты</a>
                        </li>
                        <li>
                            <a href="#" itemprop="url">Аксессуары</a>
                        </li>
                    </ul>
                </nav>

                <form action="#" class="search" method="get">
                    <input type="text" placeholder="Поиск">
                    <input type="submit" value="Поиск">
                </form>
            </div>
        </div>
    </header>
    <!--end Header-->
    <div class="content <?php if($APPLICATION->GetCurPage(false) === '/skillbox/'): ?>home<?php endif ?>">

        <?php if($APPLICATION->GetCurPage(false) !== '/skillbox/'): ?>
            <div class="wrapper title-block">
                <div class="container">
                    <h1 class="catalog">Магазин</h1>

                    <ul class="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemscope
                            itemtype="http://schema.org/ListItem">
                            <a href="#" itemprop="item">
                                <span itemprop="name">Главная</span>
                            </a>
                            <meta itemprop="position" content="1" />
                        </li>
                        <li itemprop="itemListElement" itemscope
                            itemtype="http://schema.org/ListItem">
                            <a href="#" itemprop="item">
                                <span itemprop="name">Магазин</span>
                            </a>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif ?>
        <!--Основной контент-->
        <main class="container">