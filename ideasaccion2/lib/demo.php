
<?php
	
	$servicio="https://api.perueduca.pe/wsPeruEducaN/services/User_Service?wsdl"; //url del servicio
	$parametros=array(); //parametros de la llamada
	$parametros['usuario']="pestudiante@perueduca.pe";
	$parametros['clave']="1234";
	$parametros['usuario_externo']="educared";
	$parametros['clave_externo']="RUryTXwUM96cQQN";
	$client = new SoapClient($servicio, $parametros);
	$result = $client->loginUser($parametros);//llamamos al métdo que nos interesa con los parámetros
		// print_r($result);
		  echo $result->return->m_codigo;
		 /*$resultado=(get_object_vars($result));
		 print_r($resultado);
		 echo $result['return']->m_codigo;*/
	/*
	require_once "nusoap/nusoap.php";
$client = new nusoap_client("https://api.perueduca.pe/wsPeruEducaN/services/User_Service?wsdl", true);
$error  = $client->getError();
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}else{
	$person = array('usuario' => 'pestudiante@perueduca.pe', 'clave' => '1234', 'usuario_externo' => 'educared', 'clave_externo' => 'RUryTXwUM96cQQN');
	$result = $client->call("loginUser", $person);
	if ($client->fault) {
	    echo "<h2>Fault</h2><pre>";
	    print_r($result);
	    echo "</pre>";
	}else {
	    $error = $client->getError();
	    if ($error) {
	        echo "<h2>Error</h2><pre>" . $error . "</pre>";
	    } else {
	        echo "<h2>Main</h2>";
	        echo $result;
	    }
	}
 
}

*/

?>