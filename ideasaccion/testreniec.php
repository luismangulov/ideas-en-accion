<?php

		$servicio = "http://192.168.210.187:8080/prjMINEDU/ReniecWS?wsdl"; //url del servicio
        $parametros = array(); //parametros de la llamada
        $parametros['usuario'] = "USRDEPARTE";
        $parametros['clave'] = "0a223763";
        $parametros['ipsistema'] = "::1";
        $parametros['dni'] = "45584286";
        $client = new SoapClient($servicio, $parametros);
        $result = $client->buscarDNICascada($parametros); //llamamos al método que nos interesa con los parámetros
		print_r($result);
        

?>