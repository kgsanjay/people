<?php
class ApprovalRequest extends BaseModel {

    public function create($request_type, $request_id, $workflow_step_id, $approver_id) {
        $stmt = self::$conn->prepare("INSERT INTO approval_requests (request_type, request_id, workflow_step_id, approver_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siii", $request_type, $request_id, $workflow_step_id, $approver_id);
        return $stmt->execute();
    }

    public function getPendingForUser($user_id) {
        $query = "
            (SELECT ar.id, ar.request_type, ar.request_id, e.first_name, e.last_name, ws.step_name, 
                    lr.start_date as `date`, CONCAT('Leave: ', lt.name) as `subject`
             FROM approval_requests ar
             JOIN leave_requests lr ON ar.request_id = lr.id AND ar.request_type = 'leave'
             JOIN leave_types lt ON lr.leave_type_id = lt.id
             JOIN employees e ON lr.employee_id = e.id
             JOIN workflow_steps ws ON ar.workflow_step_id = ws.id
             WHERE ar.approver_id = ? AND ar.status = 'pending')
            UNION
            (SELECT ar.id, ar.request_type, ar.request_id, e.first_name, e.last_name, ws.step_name, 
                    ex.expense_date as `date`, CONCAT('Expense: ', ex.category) as `subject`
             FROM approval_requests ar
             JOIN expenses ex ON ar.request_id = ex.id AND ar.request_type = 'expense'
             JOIN employees e ON ex.employee_id = e.id
             JOIN workflow_steps ws ON ar.workflow_step_id = ws.id
             WHERE ar.approver_id = ? AND ar.status = 'pending')
            UNION
            (SELECT ar.id, ar.request_type, ar.request_id, e.first_name, e.last_name, ws.step_name, 
                    tr.start_date as `date`, CONCAT('Travel: ', tr.destination) as `subject`
             FROM approval_requests ar
             JOIN travel_requests tr ON ar.request_id = tr.id AND ar.request_type = 'travel'
             JOIN employees e ON tr.employee_id = e.id
             JOIN workflow_steps ws ON ar.workflow_step_id = ws.id
             WHERE ar.approver_id = ? AND ar.status = 'pending')
            UNION
            (SELECT ar.id, ar.request_type, ar.request_id, e.first_name, e.last_name, ws.step_name, 
                    ts.start_date as `date`, CONCAT('Timesheet: ', ts.total_hours, ' hrs') as `subject`
             FROM approval_requests ar
             JOIN timesheet_submissions ts ON ar.request_id = ts.id AND ar.request_type = 'timesheet'
             JOIN employees e ON ts.employee_id = e.id
             JOIN workflow_steps ws ON ar.workflow_step_id = ws.id
             WHERE ar.approver_id = ? AND ar.status = 'pending')
            UNION
            (SELECT ar.id, ar.request_type, ar.request_id, e.first_name, e.last_name, ws.step_name, 
                    cl.claim_date as `date`, CONCAT('Claim: ', cl.category) as `subject`
             FROM approval_requests ar
             JOIN claims cl ON ar.request_id = cl.id AND ar.request_type = 'claim'
             JOIN employees e ON cl.employee_id = e.id
             JOIN workflow_steps ws ON ar.workflow_step_id = ws.id
             WHERE ar.approver_id = ? AND ar.status = 'pending')
            ORDER BY `date` DESC
        ";
        $stmt = self::$conn->prepare($query);
        $stmt->bind_param("iiiii", $user_id, $user_id, $user_id, $user_id, $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($id, $status, $user_id) {
        $stmt = self::$conn->prepare("UPDATE approval_requests SET status = ? WHERE id = ? AND approver_id = ?");
        $stmt->bind_param("sii", $status, $id, $user_id);
        return $stmt->execute();
    }
    
    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM approval_requests WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
