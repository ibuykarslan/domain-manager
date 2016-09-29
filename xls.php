<?php
 	
 	require_once "_conf.php";
    $results    = $db->get_results("SELECT * FROM domain_list Where domain_status = '1' ORDER BY domain_expiration_date ASC ");

/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
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
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
@require_once 'classes/PHPExcel.php';
@require_once 'classes/PHPExcel/Calculation.php';
@require_once 'classes/PHPExcel/Cell.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Domain Manager")
							 ->setLastModifiedBy("Domain Manager")
							 ->setTitle("Domain Manager");
							// ->setSubject("Office 2007 XLSX Test Document")
							// ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							// ->setKeywords("office 2007 openxml php")
							// ->setCategory("Test result file");

$time = date('d/m/Y');

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Domain Name')
            ->setCellValue('C1', 'Registered Company')
            ->setCellValue('D1', 'Creation Date')
            ->setCellValue('E1', 'Expiration Date')
            ->setCellValue('G1', $time);

$value = 2;

foreach ( $results as $db_rows ){

$value1 = "A".$value;
$value2 = "B".$value;
$value3 = "C".$value;
$value4 = "D".$value;
$value5 = "E".$value;


$domain_creation_date	=	date('d/m/Y',$db_rows->domain_creation_date);
$domain_expiration_date	=	date('d/m/Y',$db_rows->domain_expiration_date);

								// Miscellaneous glyphs, UTF-8
									$objPHPExcel->setActiveSheetIndex(0)
									            ->setCellValue($value1, $db_rows->domain_id)
									            ->setCellValue($value2, $db_rows->domain_link)
									            ->setCellValue($value3, $db_rows->domain_company)
									            ->setCellValue($value4, $domain_creation_date)
									            ->setCellValue($value5, $domain_expiration_date);
									            
									            

$value++;
}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Domain Manager List');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="domain-manager-list.xls"');
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
