<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
pre('start');
#-------------ТУТ ВАШ КОД
# Что нужно сделать: Загрузить XML в PHP (рекомендую simplexml_load_file).
# Далее вывести на экран каждый элемент со свойствами
# Цель: Аккуратно окунуть Вас в работу с самим PHP и посмотреть у кого возникнут сложности с чистым PHP.
# Далее мы имея данные в массивах/обьектах научимся загружать это непосредственно в Bitrix.
$data = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/local/integration/data/data.xml');
pre('Кол-во елементов в дереве: ' . $data->count());
parseXmlElement($data);
#-------------КОНЕЦ КОДА
pre('done.');