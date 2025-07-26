<?php
class PayrollRun extends BaseModel {

    public function create($month, $year, $run_by_id) {
        $stmt = self::$conn->prepare("INSERT INTO payroll_runs (month, year, run_by_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $month, $year, $run_by_id);
        $stmt->execute();
        return self::$conn->insert_id;
    }

    public function getAll() {
        $query = "
            SELECT pr.*, e.first_name, e.last_name
            FROM payroll_runs pr
            JOIN employees e ON pr.run_by_id = e.id
            ORDER BY pr.year DESC, pr.month DESC
        ";
        return self::$conn->query($query)->fetch_all(MYSQLI_ASSOC);
    }
}
?>
