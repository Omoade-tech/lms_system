<?php
class Student
{
    private $connect;
    private $table = 'students';

    public $id;
    public $name;
    public $username;
    public $email;
    public $password;
    public $phone;
    public $sex;
    public $age;
    public $total_books_borrowed;

    public function __construct($db)
    {
        $this->connect = $db;
    }

 

    // Enhanced Find by ID Method
    public function findById($id)
    {
        $query = "SELECT id, name, UserName, email, phone, sex, age, total_books_borrowed 
                  FROM " . $this->table . " 
                  WHERE id = ?";

        try {
            $stmt = $this->connect->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $result = $stmt->get_result();
            $student = $result->fetch_assoc();

            return $student ?: false; 
        } catch (Exception $e) {
            error_log('Error finding student by ID: ' . $e->getMessage());
            return false;
        }
    }

    // Enhanced Update Student Profile Method
    public function updateStudentProfile()
    {
        if (!$this->id || !$this->name || !$this->email) {
            error_log("Missing required fields for student update");
            return false;
        }

        $query = "UPDATE " . $this->table . " SET 
                    name = ?, 
                    email = ?, 
                    phone = ?, 
                    sex = ?, 
                    age = ? 
                  WHERE id = ?";

        try {
            $stmt = $this->connect->prepare($query);

            if (!$stmt) {
                error_log("Statement preparation failed: " . $this->connect->error);
                return false;
            }

            $stmt->bind_param(
                "ssssii", 
                $this->name, 
                $this->email, 
                $this->phone, 
                $this->sex, 
                $this->age, 
                $this->id,
                // $this->total_books_borrowed,
            );

            if ($stmt->execute()) {
                $affectedRows = $stmt->affected_rows;
                $stmt->close();
                return $affectedRows > 0;
            }

            error_log("No rows updated: " . $stmt->error);
            $stmt->close();
            return false;
        } catch (Exception $e) {
            error_log("Error updating student profile: " . $e->getMessage());
            return false;
        }
    }
}
