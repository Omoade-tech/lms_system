<?php
require_once '/xampp/htdocs/lms_system/models/Student.php'; 

class StudentController
{
    private $student;

    public function __construct($db)
    {
        $this->student = new Student($db);
    }

    // Find Student by ID function
    public function findStudentById($id)
    {
        if (empty($id)) {
            return ['error' => 'Student ID is required'];
        }
    
        $student = $this->student->findById($id);
    
        if ($student) {
            return ['success' => true, 'student' => $student];
        }
    
        return ['error' => 'Student not found'];
    }

    // Update Student Profile function
    public function updateProfile($data)
    {
        if (empty($data['id']) || empty($data['name']) || empty($data['email'])) {
            return ['error' => 'ID, Name, and Email are required'];
        }

        // Sanitize input data
        $this->student->id = trim($data['id']);
        $this->student->name = trim($data['name']);
        $this->student->email = trim($data['email']);
        $this->student->phone = isset($data['phone']) ? trim($data['phone']) : '';
        $this->student->sex = isset($data['sex']) ? trim($data['sex']) : '';
        $this->student->age = isset($data['age']) ? (int)$data['age'] : 0;

        // Additional validation if needed
        if (!filter_var($this->student->email, FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Invalid email format'];
        }

        if ($this->student->age < 0) {
            return ['error' => 'Age cannot be negative'];
        }

        if ($this->student->updateStudentProfile()) {
            return ['success' => true, 'message' => 'Profile updated successfully'];
        }

        return ['error' => 'Failed to update profile'];
    }

    // New Method: Find All Students
    public function findAll()
    {
        $students = $this->student->findAll();

        if ($students) {
            return ['success' => true, 'students' => $students];
        }

        return ['error' => 'No students found'];
    }
}