<?php
require('config.php');

if (isset($_POST['insert_1m'])) {
    insert();
}
if (isset($_POST['export_1m'])) {
    exportFileCsv();
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
function fakeData()
{
    $records = [];
    for ($i = 0; $i < 1000000; $i++) {
        $age = rand(1, 120);
        $records[] = "($age)";
    }
    return $records;
}

//insert 1 million records into the db
function insert()
{
    // Truy cập biến kết nối từ $GLOBALS
    $conn = $GLOBALS['conn'];

    //truncate du liệu cũ trước khi insert dữ liệu mới vào.
    $sql_check = 'SELECT COUNT(*) as rowCount FROM Persons';
    $result_check = $conn->query($sql_check);

    if ($result_check && $result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $row_count = $row['rowCount'];
        if ($row_count > 0) {
            $sql_truncate = "TRUNCATE TABLE Persons";
            $conn->query($sql_truncate);
        }
    }

    // Chia thành các chunk nhỏ để insert một lúc
    $values_chunked = array_chunk(fakeData(), 5000);

    //2k->17.6s, 3k->17.1s, 5k->17.16, 7k->16.50  10k->18.48  12k->17.59

    // thời gian thực hiện câu truy vấn
    $start_time = microtime(true);

    // Chèn dữ liệu vào cơ sở dữ liệu
    foreach ($values_chunked as $chunk) {
        $values = implode(', ', $chunk);
        $sql = "INSERT INTO Persons (age) VALUES $values";
        $conn->query($sql);
    }
    //thời gian kết thúc câu truy vấn
    $end_time = microtime(true);

    // tổng thời gian insert 1 triệu records vào db
    $execution_time = ($end_time - $start_time);
    echo 'Insert dữ liệu thành công!' . '<br>';
    echo 'Thời gian thực hiện: ' . $execution_time . ' s' . '<br>';

    // Đóng kết nối
    $conn->close();
}

//xuất 1 triệu records ra file csv
function exportFileCsv()
{
    // Truy cập biến kết nối từ $GLOBALS
    $conn = $GLOBALS['conn'];

    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=data.csv");
    $csv_file  = fopen("php://output", "wb");
    $column_headers = ['ID', 'AGE']; // Thay bằng các tiêu đề thực tế

    fputcsv($csv_file, $column_headers);

    $chunk_size = 1000; // Số lượng bản ghi trong mỗi chunk
    $start = 0;
    $record_count = 0; // Số lượng bản ghi đã xuất
    $max_records = 1000000; // Số lượng bản ghi tối đa

    while ($record_count < $max_records) {
        // $sql = "SELECT * FROM Persons LIMIT $start, $chunkSize";
        $sql = "SELECT * FROM Persons WHERE ID > $start ORDER BY ID LIMIT $chunk_size";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                fputcsv($csv_file, $row);
                $record_count++;
            }
        } else {
            break; // Kết thúc nếu không còn dữ liệu
        }

        $start += $chunk_size;
    }
    // Đóng tệp CSV
    fclose($csv_file);
    // Đóng kết nối
    $conn->close();
    header('Location:index.php');
}
