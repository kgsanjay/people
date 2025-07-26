<?php
class PolicyAcknowledgment extends BaseModel {

    public function acknowledge($policy_id, $employee_id) {
        $stmt = self::$conn->prepare("INSERT INTO policy_acknowledgments (policy_id, employee_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $policy_id, $employee_id);
        return $stmt->execute();
    }

    public function getAcknowledgedPolicyIdsForUser($employee_id) {
        $stmt = self::$conn->prepare("SELECT policy_id FROM policy_acknowledgments WHERE employee_id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $ids = [];
        while ($row = $result->fetch_assoc()) {
            $ids[] = $row['policy_id'];
        }
        return $ids;
    }
    
    public function getAcknowledgmentsForPolicy($policy_id) {
        $stmt = self::$conn->prepare("
            SELECT pa.acknowledged_at, e.first_name, e.last_name
            FROM policy_acknowledgments pa
            JOIN employees e ON pa.employee_id = e.id
            WHERE pa.policy_id = ?
            ORDER BY pa.acknowledged_at DESC
        ");
        $stmt->bind_param("i", $policy_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getUnacknowledgedCountForUser($employee_id) {
        $total_policies_result = self::$conn->query("SELECT COUNT(id) as count FROM policies");
        $total_policies = $total_policies_result ? $total_policies_result->fetch_assoc()['count'] : 0;
        
        $acknowledged_count = count($this->getAcknowledgedPolicyIdsForUser($employee_id));
        
        return $total_policies - $acknowledged_count;
    }
}
?>
