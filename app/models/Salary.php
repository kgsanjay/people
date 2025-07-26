<?php
class Salary extends BaseModel {

    public function findByEmployeeId($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM salaries WHERE employee_id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createOrUpdate($data) {
        $existing = $this->findByEmployeeId($data['employee_id']);
        if ($existing) {
            // Update
            $stmt = self::$conn->prepare("UPDATE salaries SET basic_salary = ?, hra = ?, travel_allowance = ?, medical_allowance = ?, pf_deduction = ?, tax_deduction = ? WHERE employee_id = ?");
            $stmt->bind_param("ddddddi", $data['basic_salary'], $data['hra'], $data['travel_allowance'], $data['medical_allowance'], $data['pf_deduction'], $data['tax_deduction'], $data['employee_id']);
        } else {
            // Create
            $stmt = self::$conn->prepare("INSERT INTO salaries (employee_id, basic_salary, hra, travel_allowance, medical_allowance, pf_deduction, tax_deduction) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("idddddd", $data['employee_id'], $data['basic_salary'], $data['hra'], $data['travel_allowance'], $data['medical_allowance'], $data['pf_deduction'], $data['tax_deduction']);
        }
        return $stmt->execute();
    }

    public function getAllSalariesWithEmployee() {
        $query = "
            SELECT e.id, e.first_name, e.last_name, e.job_title, s.*
            FROM employees e
            LEFT JOIN salaries s ON e.id = s.employee_id
            ORDER BY e.first_name ASC
        ";
        $result = self::$conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getTotalMonthlyPayroll() {
        $query = "
            SELECT SUM(basic_salary + hra + travel_allowance + medical_allowance - pf_deduction - tax_deduction) as net_payroll 
            FROM salaries
        ";
        $result = self::$conn->query($query);
        $row = $result->fetch_assoc();
        return $row['net_payroll'] ?? 0;
    }
}
?>
