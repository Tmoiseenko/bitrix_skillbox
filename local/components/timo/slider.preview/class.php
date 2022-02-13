<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

class SliderPreview extends CBitrixComponent
{
	function onPrepareComponentParams($params)
	{
		if ($params['CACHE_TYPE'] == 'Y' || $params['CACHE_TYPE'] == 'A') {
			$params['CACHE_TIME'] = intval($params['CACHE_TIME']);
		} else {
			$params['CACHE_TIME'] = 0;
		}

		#проверка входных параметров
		$params['IBLOCK_ID'] = isset($params['IBLOCK_ID']) && intval($params['IBLOCK_ID']) > 0 ? intval($params['IBLOCK_ID']) : 0;

		return $params;
	}

	public function executeComponent()
	{
		try {
			if ($this->startResultCache(false)) {
				$this->checkModules();
                $this->prepareData();
				$this->doAction();
				$this->includeComponentTemplate();
			}
		} catch (Exception $e) {
			$this->AbortResultCache();
			$this->arResult['ERROR'] = $e->getMessage();
		}
	}

    protected function prepareData()
    {

        #проверки на существования
        $this->arResult['IBLOCK'] = [];
        if ($this->arParams['IBLOCK_ID']) {
            $this->arResult['IBLOCK'] = CIBlock::GetByID($this->arParams['IBLOCK_ID'])->Fetch();
        }
        if (!$this->arResult['IBLOCK']) {
            throw new Exception('Инфоблок не найден');
        }
    }

	protected function checkModules()
	{
		#подключаем нужные модули
		if (!Loader::includeModule('iblock'))
			throw new Exception('Модуль "Инфоблоки" не установлен');
	}

	protected function doAction()
	{
		$arSelect = ['ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE'];
		$arFilter = ['IBLOCK_ID' => intval($this->arParams['IBLOCK_ID']), 'ACTIVE' => 'Y'];
		$result = CIBlockElement::GetList(['SORT' => 'ASC'], $arFilter,false, false, $arSelect);
		while ($element = $result->Fetch()) {
		    $this->arResult['ITEMS'][$element['ID']]['PREVIEW_PICTURE'] = CFile::GetFileArray($element['PREVIEW_PICTURE']);
		    $this->arResult['ITEMS'][$element['ID']]['DETAIL_PICTURE'] = CFile::GetFileArray($element['DETAIL_PICTURE']);
        }
	}
}