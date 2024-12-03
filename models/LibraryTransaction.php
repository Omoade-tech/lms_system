<?php
require_once '/xampp/htdocs/lms_system/config/database.php';

class Transaction {
    private $connect;
    private $table = 'transactions';
    private $id;
    private $student_id;
    private $student_name;
    private $book_id;
    private $book_title;
    private $borrow_date;
    private $return_date;
    private $status;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function findById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); 
    }

    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

   

    public function findStudentById($student_id) {
        $student_id = (int)$student_id;
        $sql = "SELECT * FROM {$this->table} WHERE student_id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
}
