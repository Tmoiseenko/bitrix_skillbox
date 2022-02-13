<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

pre('Start');

try {
    $wsdl = new SoapClient('http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?wsdl');
    $date = $wsdl->GetLatestDateTime();
    $result = $wsdl->GetCursOnDate(array('On_date'=>$date->GetLatestDateTimeResult));

    $result = $wsdl->GetCursOnDateXML(array('On_date'=>$date->GetLatestDateTimeResult));

    if ($result->GetCursOnDateXMLResult->any) {
        $xml = new SimpleXMLElement($result->GetCursOnDateXMLResult->any);
        foreach ($xml->ValuteCursOnDate as $currency) {
            pre($currency);
        }
    }
} catch (Exception  $e) {
    pre("Exception : " . $e->getMessage());
}

pre('End');