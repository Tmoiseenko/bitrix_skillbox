<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');
pre('start');
#-------------ТУТ ВАШ КОД
# Что нужно сделать: Загрузить XML в PHP (рекомендую simplexml_load_file).
# Далее вывести на экран каждый элемент со свойствами
# Цель: Аккуратно окунуть Вас в работу с самим PHP и посмотреть у кого возникнут сложности с чистым PHP.
# Далее мы имея данные в массивах/обьектах научимся загружать это непосредственно в Bitrix.

function xmlToArr($xml, $out=[]) {
    foreach ((array)$xml as $index => $node) {
        $out[$index] = (is_object($node)) ? xmlToArr($node) : $node;
    }

    return $out;
}


$data = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/local/integration/data/data.xml');

$element = new CIBlockElement;

$images = [
    'https://s5.eshoper.ru/355/v0/b5efa54c1bd1dd4d41b7af53d9e13a1b.jpg',
    'https://insporto.ru/image/cache/catalog/insporto/billiard/stoly/gercog-piramida-8ft/gercog-piramida-8ft-560x440.png',
    'https://www.rostov.billiard1.ru/upload/iblock/f8e/077.jpg',
    'https://www.samara.billiard1.ru/upload/iblock/b22/18.jpg'
];

foreach ($data->product as $product) {
    $product = xmlToArr($product);

    $props = [
        'OLDID' => $product['OLDID'],
        'SYKNO' => $product['SYKNO']['VARIANT'],
        'VIKRASKA' => $product['VIKRASKA']['VARIANT'],
    ];

    foreach ($images as $img) {
        $props['IMAGES'][] = CFile::MakeFileArray($img);
    }

    $arrFields = [
        "IBLOCK_SECTION_ID" => $product['SECTION_ID'],
        "IBLOCK_ID"      => ID_INFOBLOCK_PRODUCT,
        "PROPERTY_VALUES"=> $props,
        "NAME"           => $product['NAME'],
        "CODE"           => $product['CODE'],
        "ACTIVE"         => "Y",
        "DETAIL_TEXT"    => $product['DESCRIPTION'],
    ];

    if ($prodID = $element->Add($arrFields)) {
        pre('Товар ' . $product['NAME'] . ' добавлен под ID - ' . $prodID);
        CCatalogProduct::Add([
            'ID' => $prodID,
            'QUANTITY' => 0
        ]);

        foreach ($product['OFFERS']['OFFER'] as $offer) {
            $arrOffersProps = [
                'QTY_LEGS' => intval($offer->QTY_LEGS),
                'ART' => (string)$offer->ART,
                'CML2_LINK' => $prodID,
                'SIZE_FIELD' => hlbGetOrAddElementByName(hlbGetCompileEntity('Sizefield'), (string)$offer->SIZE_FIELD),
                'GAME_TYPE' => hlbGetOrAddElementByName(hlbGetCompileEntity('Gametype'), (string)$offer->GAME_TYPE),
                'TABLE_MATERIAL' => hlbGetOrAddElementByName(hlbGetCompileEntity('Tablematerial'), (string)$offer->TABLE_MATERIAL),
                'TABLE_TYPE' => hlbGetOrAddElementByName(hlbGetCompileEntity('Tabletype'), (string)$offer->TABLE_TYPE),
            ];
            pre($arrOffersProps);
            $arrOffersFields = [
                'NAME' => implode(
                    ',',
                    [
                        $product['NAME'],
                        (string)$offer->SIZE_FIELD,
                        (string)$offer->GAME_TYPE,
                        (string)$offer->TABLE_MATERIAL,
                        (string)$offer->TABLE_TYPE
                    ]
                ),
                'IBLOCK_ID' => ID_INFOBLOCK_OFFERS,
                'ACTIVE'         => "Y",
                'PROPERTY_VALUES' => $arrOffersProps
            ];

            if ($offerID = $element->Add($arrOffersFields)) {
                pre('Оффер добавлен под ID - ' . $offerID);
                $arrOffersFields = [
                    'ID' => $offerID,
                    'QUANTITY' => rand(1, 10),
                    'WEIGHT' => $offer->VES
                ];
                CCatalogProduct::Add($arrOffersFields);
                CPrice::SetBasePrice($offerID, $offer->PRICE, 'RUB');
            } else {
                pre('Ошибка добавления оферра');
                pre($element->LAST_ERROR);
            }

        }

    } else {
        pre('Ошибка добавления товара');
        pre($element->LAST_ERROR);
        continue;
    }

    break;
}

#-------------КОНЕЦ КОДА
pre('done.');