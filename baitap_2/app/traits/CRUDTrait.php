<?php
trait CRUDTrait
{
    public function create($table, $data)
    {

        // Thực hiện tạo dữ liệu trong bảng $table với thông tin trong mảng $data
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            // Chuỗi đại diện cho kiểu dữ liệu
            $types = str_repeat('s', count($data));
            // Mảng các giá trị cần gắn
            $values = array_values($data);
            // Gắn giá trị vào câu truy vấn
            $stmt->bind_param($types, ...$values);

            if ($stmt->execute()) {

                return true; // Thêm bài viết thành công
            }
        }
        return false; // Thêm bài viết thất bại hoặc không có kết nối
    }

    public function read($table, $condition = "")
    {
        $sql = "SELECT * FROM $table";
        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }

        $result = $this->conn->query($sql);
        $data = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function update($table, $data, $condition)
    {
    }

    public function delete($table, $condition)
    {
    }
}
