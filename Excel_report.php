<?php

include("conn.php");
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "POST":
        $input = json_decode(file_get_contents("php://input"));

        if (isset($input->getId)) {
            $id = $input->getId;

            $sql = "SELECT * FROM add_expense WHERE user_id = '$id'";

            $mob_sql = "SELECT contact FROM user WHERE id = '$id'";
            $result1 = mysqli_query($db_conn , $mob_sql);
            $mobile = mysqli_fetch_assoc($result1);
            $mobile_no = $mobile['contact'];

            $result = mysqli_query($db_conn, $sql);
            $data = [];

            if (mysqli_num_rows($result) > 0) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->setCellValue('A1', 'ID');
                $sheet->setCellValue('B1', 'Expense Type');
                $sheet->setCellValue('C1', 'Description');
                $sheet->setCellValue('D1', 'Date');
                $sheet->setCellValue('E1', 'Amount');
                $rowNumber = 2; 
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $sheet->setCellValue('A' . $rowNumber, $row['id']);
                    $sheet->setCellValue('B' . $rowNumber, $row['expense_type']);
                    $sheet->setCellValue('C' . $rowNumber, $row['description']);
                    $sheet->setCellValue('D' . $rowNumber, $row['date']);
                    $sheet->setCellValue('E' . $rowNumber, $row['amount']);
                    $rowNumber++;
                }
                $fileName = "expense_report_" . time() . ".xlsx";
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="'.$fileName.'"');
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No data']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Unsupported request method']);
        break;
}

?>
