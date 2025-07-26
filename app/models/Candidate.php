<?php
class Candidate extends BaseModel {
    public function create($name, $email, $phone, $resume_filename) {
        $stmt = self::$conn->prepare("INSERT INTO candidates (name, email, phone, resume_filename) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $resume_filename);
        $stmt->execute();
        return self::$conn->insert_id;
    }
}
?>
