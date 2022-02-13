<?
/*
 * Полезные и простые функции для работы с PHP. Намеренно объявляются в глобальном namespace
 * */
if (!function_exists('pre')) {
	function pre($var, $die = false)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
		if ($die)
			die('Debug in PRE');
	}
}

if (!function_exists('vd')) {
	function vd($var, $die = false)
	{
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
		if ($die)
			die('Debug in VD');
	}
}

if (!function_exists('writeEvent')) {
	function writeEvent($dump)
	{
		ulogging($dump, 'writeEvent', true);
	}
}

if (!function_exists('ulogging')) {
	/*
	 * ВНИМАНИЕ! Перед использованием создать папку logs в upload и дать права на записать в папку
	 * */
	function ulogging($input, $logname = 'debug', $dt = false)
	{
		$endLine = "\r\n"; #PHP_EOL не используется, т.к. иногда это нужно конфигурировать это

		$fp = fopen($_SERVER["DOCUMENT_ROOT"] . '/upload/logs/' . $logname . '.txt', "a+");

		if (is_string($input)) {
			$writeStr = $input;
		} else {
			$writeStr = print_r($input, true);
		}

		if ($dt) {
			fwrite($fp, date('d.m.Y H:i:s') . $endLine);
		}

		fwrite($fp, $writeStr . $endLine);

		fclose($fp);
		return true;
	}
}

/*
* Парсер вложенных елементов XML
*/
if (!function_exists('parseXmlElement')) {
    function parseXmlElement($array)
    {
        if ($array->count()) {
            pre('Ключ элемента: ' . $array->getName() . ' -- значения элементов: ');
            pre('-----------------');
            foreach ($array as $arrayItem) {
                parseXmlElement($arrayItem);
                if ($arrayItem->attributes()->count()) pre('Аттрибут: ' . $arrayItem->attributes()->asXML());
            }
            pre('-----------------');
        } else {
            pre('Ключ элемента: ' . $array->getName() . ' -- значение элемента: ' . $array->asXML());
            return $array;
        }
    }
}

/*
* Получение обьекта Hiloadblock по имени
*/
if (!function_exists('hlbGetCompileEntity')) {
	function hlbGetCompileEntity($hlbName)
	{
		$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getList([
			'filter' => ['=NAME' => $hlbName]
		])->fetch();
		$hlClassName = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
		return $hlClassName->getDataClass();
	}
}

/*
* Парсер вложенных елементов XML и добавления в справочники
*/
if (!function_exists('hlbAddElements')) {
    function hlbAddElements($array)
    {
        if ($array->count()) {
            foreach ($array as $arrayItem) {
                hlbAddElements($arrayItem);
                $keyArr = ['SYKNO', 'VIKRASKA'];
                if ($arrayItem->attributes()->count() && in_array($array->getName(), $keyArr) ){
                    $hlbName = ucfirst(strtolower($array->getName()));
                    $hlb = hlbGetCompileEntity($hlbName);
                    $hlbData = $hlb::getList([
                        'filter' => array('=UF_NAME' => (string)$arrayItem['VALUE'])
                    ])->fetch();
                    if(!$hlbData) {
                        $hlb::add([
                           'UF_NAME' => $arrayItem['VALUE'],
                           'UF_XML_ID' => (string)$arrayItem->__toString()
                       ]);
                        pre('Аттрибут: ' . $arrayItem['VALUE'] . ' добавлен в справочник ' . $hlbName);
                    } else {
                        pre('Аттрибут: ' . $arrayItem['VALUE'] . ' уже есть в справочнике ' . $hlbName);
                    }

                }

            }
        } else {
            return $array;
        }
    }
}

/*
 * Добавляет или возвращает найденный елемент в Highload блоке
 * на входе подается резулатат функции hlbGetCompileEntity и UF_XML_ID елемента
 */

if (!function_exists('hlbGetElementByXmlId')) {
    function hlbGetElementByXmlId($hlbCls, $elId) {
        $hlbData = $hlbCls::getList([
            'filter' => array('=UF_XML_ID' => $elId)
        ])->fetch();
        return $hlbData['ID'];
    }
}

/*
 * Добавляет или возвращает найденный елемент в Highload блоке
 * на входе подается резулатат функции hlbGetCompileEntity и UF_NAME елемента
 */

if (!function_exists('hlbGetOrAddElementByName')) {
    function hlbGetOrAddElementByName($hlbCls, $elName) {
        $hlbData = $hlbCls::getList([
            'filter' => array('=UF_NAME' => $elName)
        ])->fetch();
        if(!$hlbData) {
            $obResult = $hlbCls::add([
                'UF_NAME' => $elName,
                'UF_XML_ID' => uniqIdReal()
            ]);
            return $obResult->getData(["UF_XML_ID"]);
        }
        return $hlbData['UF_XML_ID'];
    }
}

/*
 * Получение уникального ID
 * Взято с https://www.php.net/manual/ru/function.uniqid.php
 */
if (!function_exists('uniqIdReal')) {
    function uniqIdReal($lenght = 13)
    {
        // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}