<?php
use yii\db\Query;
use app\models\Estudiante;
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */
	$querys = new Query;
        if($estado==1)
        {
            $querys=Estudiante::find()
            ->select('institucion.denominacion as denominacion,estudiante.nombres as nombres,estudiante.apellido_paterno as apellido_paterno,estudiante.apellido_materno as apellido_materno,estudiante.email as email,estudiante.celular as celular,estudiante.grado as grado')
           
            ->innerJoin('institucion','institucion.id = estudiante.institucion_id')
            ->innerJoin('ubigeo','ubigeo.district_id = institucion.ubigeo_id')
            ->innerJoin('integrante','estudiante.id = integrante.estudiante_id')
            ->innerJoin('equipo','integrante.equipo_id = equipo.id')
            ->where('equipo.estado = 1 and ubigeo.department_id=:department_id',[':department_id'=>$region])
            ->all();
        }
        elseif($estado==2)
        {
            $querys=Estudiante::find()
            ->select('institucion.denominacion as denominacion,estudiante.nombres as nombres,estudiante.apellido_paterno as apellido_paterno,estudiante.apellido_materno as apellido_materno,estudiante.email as email,estudiante.celular as celular,estudiante.grado as grado')
            
            ->innerJoin('institucion','institucion.id = estudiante.institucion_id')
            ->innerJoin('ubigeo','ubigeo.district_id = institucion.ubigeo_id')
            ->innerJoin('integrante','estudiante.id = integrante.estudiante_id')
            ->innerJoin('equipo','integrante.equipo_id = equipo.id')
            ->where('equipo.estado = 0 and ubigeo.department_id=:department_id',[':department_id'=>$region])
            ->all();
        }
        elseif($estado==3)
        {
            $querys=Estudiante::find()
            ->select('institucion.denominacion as denominacion,estudiante.nombres as nombres,estudiante.apellido_paterno as apellido_paterno,estudiante.apellido_materno as apellido_materno,estudiante.email as email,estudiante.celular as celular,estudiante.grado as grado')
            
            ->innerJoin('institucion','institucion.id = estudiante.institucion_id')
            ->innerJoin('ubigeo','ubigeo.district_id = institucion.ubigeo_id')
            ->innerJoin('invitacion','invitacion.estudiante_invitado_id = estudiante.id')
            ->where('invitacion.estado = 1 and ubigeo.department_id=:department_id',[':department_id'=>$region])
            ->all();
        }
        elseif($estado==4)
        {
            $querys=Estudiante::find()
            ->select('institucion.denominacion as denominacion,estudiante.nombres as nombres,estudiante.apellido_paterno as apellido_paterno,estudiante.apellido_materno as apellido_materno,estudiante.email as email,estudiante.celular as celular,estudiante.grado as grado')
            
            ->innerJoin('institucion','institucion.id = estudiante.institucion_id')
            ->innerJoin('ubigeo','ubigeo.district_id = institucion.ubigeo_id')
            ->where('estudiante.id NOT IN (SELECT estudiante_id FROM integrante UNION ALL SELECT estudiante_invitado_id FROM invitacion WHERE estado = 1) and ubigeo.department_id=:department_id',[':department_id'=>$region])
	    ->all();
        }
	elseif($region)
        {
            $querys=Estudiante::find()
            ->select('institucion.denominacion as denominacion,estudiante.nombres as nombres,estudiante.apellido_paterno as apellido_paterno,estudiante.apellido_materno as apellido_materno,estudiante.email as email,estudiante.celular as celular,estudiante.grado as grado')
            
            ->innerJoin('institucion','institucion.id = estudiante.institucion_id')
            ->innerJoin('ubigeo','ubigeo.district_id = institucion.ubigeo_id')
	    ->where('ubigeo.department_id=:department_id',[':department_id'=>$region])
	    ->all();
        }
        else
        {
            $querys=Estudiante::find()
            ->select('institucion.denominacion as denominacion,estudiante.nombres as nombres,estudiante.apellido_paterno as apellido_paterno,estudiante.apellido_materno as apellido_materno,estudiante.email as email,estudiante.celular as celular,estudiante.grado as grado')
            
            ->innerJoin('institucion','institucion.id = estudiante.institucion_id')
            ->innerJoin('ubigeo','ubigeo.district_id = institucion.ubigeo_id')
	    ->all();
        }

    
    
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../../web/PHPExcel/Classes/PHPExcel.php';



// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Colegio')
            ->setCellValue('B1', 'Nombres Completos')
	    ->setCellValue('C1', 'Correo')
	    ->setCellValue('D1', 'Celular')
	    ->setCellValue('E1', 'Rol');

// Miscellaneous glyphs, UTF-8
    $i=2;
    foreach($querys as $query):
    $rol="estudiante";
    if($query->grado==6)
    {
	$rol="docente";
    }
    
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $query->denominacion)
	    ->setCellValue('B'.$i, $query->nombres." ".$query->apellido_paterno." ".$query->apellido_materno)
	    ->setCellValue('C'.$i, $query->email)
	    ->setCellValue('D'.$i, $query->celular)
	    ->setCellValue('E'.$i, $rol);
	    
    $i++;
    endforeach; 


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte01.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;