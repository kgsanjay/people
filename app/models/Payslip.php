<?php
class Payslip extends BaseModel {

    public function create($data) {
        $stmt = self::$conn->prepare("
            INSERT INTO payslips (payroll_run_id, employee_id, basic_salary, hra, travel_allowance, medical_allowance, pf_deduction, tax_deduction, gross_earnings, total_deductions, net_pay)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "iiddddddddd",
            $data['payroll_run_id'], $data['employee_id'], $data['basic_salary'], $data['hra'],
            $data['travel_allowance'], $data['medical_allowance'], $data['pf_deduction'],
            $data['tax_deduction'], $data['gross_earnings'], $data['total_deductions'], $data['net_pay']
        );
        return $stmt->execute();
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("
            SELECT p.*, pr.month, pr.year
            FROM payslips p
            JOIN payroll_runs pr ON p.payroll_run_id = pr.id
            WHERE p.employee_id = ?
            ORDER BY pr.year DESC, pr.month DESC
        ");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("
            SELECT p.*, pr.month, pr.year
            FROM payslips p
            JOIN payroll_runs pr ON p.payroll_run_id = pr.id
            WHERE p.id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
