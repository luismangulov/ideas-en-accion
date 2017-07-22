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
            ->setCellValue('A1', 'Título del proyecto')
            ->setCellValue('B1', '# de integrantes')
	    ->setCellValue('C1', 'Participación en foro de "Participación estudiantil"')
	    ->setCellValue('D1', 'Participación en foro de "Asuntos públicos"')
	    ->setCellValue('E1', 'Proyecto finalizado')
	    ->setCellValue('F1', 'Registro del video')
            ->setCellValue('G1', 'Registro de reflexión')
            ->setCellValue('H1', 'Archivo de proyecto');

// Miscellaneous glyphs, UTF-8
    $i=2;
    
    foreach($proyectos as $proyecto):
    
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $proyecto->titulo)
            ->setCellValue('B'.$i, $proyecto->total_integrantes)
	    ->setCellValue('C'.$i, ($proyecto->foro_abierto==1)?'Si':'')
	    ->setCellValue('D'.$i, ($proyecto->foro_asunto==1)?'Si':'')
	    ->setCellValue('E'.$i, ($proyecto->proyecto_finalizado==1)?'Si':'')
	    ->setCellValue('F'.$i, ($proyecto->video_check==1)?'Si':'')
            ->setCellValue('G'.$i, ($proyecto->reflexion_check==1)?'Si':'')
            ->setCellValue('H'.$i, ($proyecto->archivo_proyecto_check==1)?'Si':'');
    $i++;
    endforeach; 


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte de proyectos');


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