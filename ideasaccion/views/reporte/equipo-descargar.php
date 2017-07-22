<?php
use yii\db\Query;
use app\models\Ubigeo;
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
$equipos= Ubigeo::find()
                ->select(['
                            distinct ubigeo.department,
                            (SELECT COUNT( equipo.id ) FROM equipo INNER JOIN integrante ON integrante.equipo_id = equipo.id INNER JOIN estudiante ON estudiante.id = integrante.estudiante_id AND integrante.rol =1 INNER JOIN institucion ON institucion.id = estudiante.institucion_id INNER JOIN ubigeo u ON u.district_id = institucion.ubigeo_id WHERE u.department_id = ubigeo.department_id AND equipo.estado =1 ) AS province,
                            (SELECT COUNT( equipo.id ) FROM equipo INNER JOIN integrante ON integrante.equipo_id = equipo.id INNER JOIN estudiante ON estudiante.id = integrante.estudiante_id INNER JOIN institucion ON institucion.id = estudiante.institucion_id INNER JOIN ubigeo u ON u.district_id = institucion.ubigeo_id WHERE u.department_id = ubigeo.department_id AND equipo.estado =1 ) AS district ,
                            (SELECT COUNT( equipo.id ) FROM equipo INNER JOIN integrante ON integrante.equipo_id = equipo.id INNER JOIN estudiante ON estudiante.id = integrante.estudiante_id AND integrante.rol =1 INNER JOIN institucion ON institucion.id = estudiante.institucion_id INNER JOIN ubigeo u ON u.district_id = institucion.ubigeo_id WHERE u.department_id = ubigeo.department_id AND equipo.estado =0 ) AS latitude,
                            (SELECT COUNT( equipo.id ) FROM equipo INNER JOIN integrante ON integrante.equipo_id = equipo.id INNER JOIN estudiante ON estudiante.id = integrante.estudiante_id INNER JOIN institucion ON institucion.id = estudiante.institucion_id INNER JOIN ubigeo u ON u.district_id = institucion.ubigeo_id WHERE u.department_id = ubigeo.department_id AND equipo.estado =0 ) AS longitud
			  ']) 
                ->all();


    
    
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
            ->setCellValue('A1', 'Región')
            ->setCellValue('B1', 'Total de equipos finalizados')
	    ->setCellValue('C1', 'Total integrantes de equipos finalizados')
	    ->setCellValue('D1', 'Total de equipos no finalizados')
	    ->setCellValue('E1', 'Total integrantes de equipos no finalizados');

// Miscellaneous glyphs, UTF-8
    $i=2;
    foreach($equipos as $equipo):
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $equipo->department)
            ->setCellValue('B'.$i, $equipo->province)
	    ->setCellValue('C'.$i, $equipo->district)
	    ->setCellValue('D'.$i, $equipo->latitude)
	    ->setCellValue('E'.$i, $equipo->longitud);
    $i++;
    endforeach; 


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte de estudiantes.xls"');
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