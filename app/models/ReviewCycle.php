<?php
class ReviewCycle extends BaseModel {
    public function create($name, $start_date, $end_date) {
        $stmt = self::$conn->prepare("INSERT INTO review_cycles (name, start_date, end_date) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $start_date, $end_date);
        return $stmt->execute();
    }

    public function getAll() {
        return self::$conn->query("SELECT * FROM review_cycles ORDER BY start_date DESC")->fetch_all(MYSQLI_ASSOC);
    }
}
?>
