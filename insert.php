<?php
require('config.php');
require('queries.php');

define('TABLE_NAME', 'Persons');

if (isset($_POST['insert_1m'])) {
    insert_1m_records();
}
if (isset($_POST['export_1m'])) {
    export_1m_records_file_csv();
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="index.php" type="button">back!</a>
</body>

</html>

<?php

//tạo dữ liệu mẫu
function fake_data()
{
    $records = array();
    for ($i = 0; $i < 1000000; $i++) {
        $age = rand(1, 120);
        $records[] = "($age)";
    }
    return $records;
}

//insert 1 million records into the db
function insert_1m_records()
{
    $table = TABLE_NAME;
    // Truy cập biến kết nối từ $GLOBALS
    $conn = $GLOBALS['g_conn'];

    try {
        // Bắt đầu transaction
        $conn->begin_transaction();

        //xóa records cũ trước khi insert records mới vào
        $result_check = check_row_count($table);
        if ($result_check > 0) {
            truncate_table($table);
        }
        // Chia thành các chunk nhỏ để insert một lúc
        $values_chunked = array_chunk(fake_data(), 5000);
        // thời gian bắt đầu thực hiện câu truy vấn
        $start_time = microtime(true);
        // Chèn dữ liệu vào cơ sở dữ liệu
        foreach ($values_chunked as $chunk) {
            $values = implode(', ', $chunk);
            insert_record($table, $values);
        }
        // Kết thúc transaction
        $conn->commit();
        //thời gian kết thúc câu truy vấn
        $end_time = microtime(true);
        // tổng thời gian insert 1 triệu records vào db
        $execution_time = ($end_time - $start_time);
        echo 'Insert dữ liệu thành công!' . '<br>';
        echo 'Thời gian thực hiện: ' . $execution_time . ' s' . '<br>';
    } catch (Exception $e) {
        // Nếu có lỗi xảy ra, rollback transaction
        $conn->rollback();
        echo 'Có lỗi xảy ra: ' . $e->getMessage();
    }
    // Đóng kết nối
    $conn->close();
}

//xuất 1 triệu records ra file csv
function export_1m_records_file_csv()
{
    $table = TABLE_NAME;

    // Truy cập biến kết nối từ $GLOBALS
    $conn = $GLOBALS['g_conn'];
    // Danh sách cột cần chọn
    $selectedColumns = array('ID', 'Age');

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=data.csv');
    $csv_file  = fopen('php://output', 'wb');

    // Bắt đầu transaction
    $conn->begin_transaction();

    try {
        // Thay bằng các tiêu đề thực tế
        fputcsv($csv_file, $selectedColumns);

        // Số lượng bản ghi trong mỗi chunk
        $chunk_size = 1000;
        $start = 0;
        // Số lượng bản ghi đã xuất
        $record_count = 0;
        // Số lượng bản ghi tối đa
        $max_records = 1000000;

        while ($record_count < $max_records) {

            // Gọi hàm select_records để thực hiện câu truy vấn SELECT
            $result = select_records($table, $selectedColumns, 'ID > \'$start\'', 'ID', $chunk_size);

            // insert dữ liệu từ db vào file csv vừa tạo
            if ($result !== false) {
                while ($row = $result->fetch_assoc()) {
                    fputcsv($csv_file, $row);
                    $record_count++;
                }
            } else {
                // Kết thúc nếu không còn dữ liệu
                break;
            }
            $start += $chunk_size;
        }
        // Đóng tệp CSV
        fclose($csv_file);
        // Kết thúc transaction
        $conn->commit();
    } catch (Exception $e) {
        // Nếu có lỗi xảy ra, rollback transaction và in ra thông báo lỗi
        $conn->rollback();
        echo 'Có lỗi xảy ra: ' . $e->getMessage();
    }
    // Đóng kết nối
    $conn->close();
    header('Location:index.php');
}
