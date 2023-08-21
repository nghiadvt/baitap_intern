<?php

require('config.php');

/**
 * Hàm insert_record: Thực hiện việc chèn dữ liệu vào bảng trong cơ sở dữ liệu.
 *
 * @param string $table Tên của bảng cần chèn dữ liệu vào.
 * @param string $values Chuỗi chứa các giá trị cần chèn vào cột "age".
 * @return mixed Trả về kết quả của câu truy vấn chèn dữ liệu, hoặc false nếu có lỗi.
 */
function insert_record($table, $values)
{
    global $conn;

    $sql = "INSERT INTO $table (age) VALUES $values";
    return $conn->query($sql);
}


/**
 * Hàm check_row_count: Thực hiện kiểm tra xem có dữ liệu từ bảng trong cơ sở dữ liệu.
 *
 * @param string $table Tên của bảng cần chèn dữ liệu vào.
 * @return mixed Trả về kết quả của câu truy vấn là số lượng records có trong bảng
 */
function check_row_count($table)
{
    global $conn;

    $sql = "SELECT COUNT(*) as rowCount FROM $table";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['rowCount'];
    } else {
        return 0;
    }
}

/**
 * Hàm truncate_table: Thực hiện xóa tất cả recors từ bảng trong cơ sở dữ liệu.
 *
 * @param string $table Tên của bảng cần chèn dữ liệu vào.
 * @return mixed Trả về kết quả của câu truy vấn xóa tất cả records có trong bảng
 */
function truncate_table($table)
{
    global $conn;

    $sql_truncate = "TRUNCATE TABLE $table";
    return $conn->query($sql_truncate);
}

/**
 * Hàm thực hiện câu truy vấn SELECT với điều kiện, sắp xếp và giới hạn.
 *
 * @param string $table Tên của bảng cần thực hiện truy vấn SELECT.
 * @param array $columns Mảng chứa danh sách các cột cần chọn.
 * @param string $condition Điều kiện WHERE cho câu truy vấn.
 * @param string $orderBy Câu truy vấn ORDER BY để sắp xếp kết quả.
 * @param int $limit Số lượng bản ghi giới hạn trong kết quả.
 * @return mixed Trả về kết quả của câu truy vấn SELECT hoặc false nếu có lỗi.
 */
function select_records($table, $columns, $condition = '', $orderBy = '', $limit = null)
{
    global $conn; // Sử dụng biến kết nối toàn cục đã được định nghĩa ở nơi khác

    // Xây dựng chuỗi danh sách cột cần chọn
    $columnsList = implode(', ', $columns);

    // Xây dựng câu truy vấn SELECT dựa trên tham số
    $sql = "SELECT $columnsList FROM $table";
    if (!empty($condition)) {
        $sql .= " WHERE $condition";
    }
    if (!empty($orderBy)) {
        $sql .= " ORDER BY $orderBy";
    }
    if ($limit !== null) {
        $sql .= " LIMIT $limit";
    }

    // Thực thi câu truy vấn SELECT và trả về kết quả
    return $conn->query($sql);
}
