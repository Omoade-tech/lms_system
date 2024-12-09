<?php
require_once '/xampp/htdocs/lms_system/config/database.php';

class Transaction {
    private $connect;
    private $table = 'transactions';

    public function __construct($connect) {
        $this->connect = $connect;
    }

    // Find a transaction by its ID
    public function findById($id) {
        $id = (int)$id;
        $sql = "SELECT 
                    t.id, 
                    t.student_id, 
                    s.name as student_name, 
                    t.book_id, 
                    b.title as book_title, 
                    t.borrow_date, 
                    t.return_date, 
                    t.status 
                FROM {$this->table} t
                JOIN students s ON t.student_id = s.id
                JOIN books b ON t.book_id = b.id
                WHERE t.id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); 
    }

    // Fetch all transactions with student and book details
    public function findAll() {
        $sql = "SELECT 
                    t.id, 
                    t.student_id, 
                    s.name as student_name, 
                    t.book_id, 
                    b.title as book_title, 
                    t.borrow_date, 
                    t.return_date, 
                    t.status 
                FROM {$this->table} t
                JOIN students s ON t.student_id = s.id
                JOIN books b ON t.book_id = b.id";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch transactions for a specific student by student_id
    public function findStudentById($student_id) {
        $student_id = (int)$student_id;
        $sql = "SELECT 
                    t.id, 
                    t.student_id, 
                    s.name as student_name, 
                    t.book_id, 
                    b.title as book_title, 
                    t.borrow_date, 
                    t.return_date, 
                    t.status 
                FROM {$this->table} t
                JOIN students s ON t.student_id = s.id
                JOIN books b ON t.book_id = b.id
                WHERE t.student_id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Create a new transaction
    public function createTransaction($data) {
        try {
            $sql = "INSERT INTO {$this->table} (student_id, book_id, borrow_date, return_date, status) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->connect->prepare($sql);
            $stmt->bind_param(
                "iisss", 
                $data['student_id'], 
                $data['book_id'], 
                $data['borrow_date'], 
                $data['return_date'], 
                $data['status']
            );
            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Update transaction details based on student_id
    public function updateTransaction($id, $data) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET book_id = ?, borrow_date = ?, return_date = ?, status = ?
                    WHERE id = ?";
            $stmt = $this->connect->prepare($sql);
            $stmt->bind_param(
                "isssi", 
                $data['book_id'], 
                $data['borrow_date'], 
                $data['return_date'], 
                $data['status'], 
                $id
            );
            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }



    // Borrow a book
    // public function borrowBook($student_id, $book_id) {
    //     $borrow_date = date('Y-m-d');
    //     $status = 'borrowed';
    
    //     // Start transaction
    //     $this->connect->begin_transaction();
    
    //     try {
    //         // Decrement available copies
    //         $updateBookSql = "UPDATE books SET available_copies = available_copies - 1 WHERE id = ? AND available_copies > 0";
    //         $updateStmt = $this->connect->prepare($updateBookSql);
    //         $updateStmt->bind_param("i", $book_id);
    //         if (!$updateStmt->execute()) {
    //             throw new Exception("Failed to update book availability.");
    //         }
    
    //         // Insert transaction
    //         $sql = "INSERT INTO {$this->table} (student_id, book_id, borrow_date, status) VALUES (?, ?, ?, ?)";
    //         $stmt = $this->connect->prepare($sql);
    //         $stmt->bind_param("iiss", $student_id, $book_id, $borrow_date, $status);
    //         if (!$stmt->execute()) {
    //             throw new Exception("Failed to record transaction.");
    //         }
    
    //         // Commit transaction
    //         $this->connect->commit();
    //         return ['success' => true, 'message' => 'Book borrowed successfully'];
    //     } catch (Exception $e) {
    //         $this->connect->rollback();
    //         return ['success' => false, 'message' => $e->getMessage()];
    //     }
    // }
    // In Transaction model
    // Model: Transaction.php
public function borrowBook($student_id, $book_id, $return_date) {
    $borrow_date = date('Y-m-d');
    $status = 'borrowed';

    if ($this->hasBorrowedBook($student_id, $book_id)) {
        return ['success' => false, 'message' => 'You have already borrowed this book'];
    }

    // Start transaction
    $this->connect->begin_transaction();

    try {
        // Decrement available copies
        $updateBookSql = "UPDATE books SET available_copies = available_copies - 1 WHERE id = ? AND available_copies > 0";
        $updateStmt = $this->connect->prepare($updateBookSql);
        $updateStmt->bind_param("i", $book_id);
        if (!$updateStmt->execute()) {
            throw new Exception("Failed to update book availability.");
        }

        // Insert transaction
        $sql = "INSERT INTO {$this->table} (student_id, book_id, borrow_date, return_date, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("iisss", $student_id, $book_id, $borrow_date, $return_date, $status);
        if (!$stmt->execute()) {
            throw new Exception("Failed to record transaction.");
        }

        // Commit transaction
        $this->connect->commit();
        return ['success' => true, 'message' => 'Book borrowed successfully'];
    } catch (Exception $e) {
        $this->connect->rollback();
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

public function hasBorrowedBook($student_id, $book_id) {
    $sql = "SELECT id FROM {$this->table} WHERE student_id = ? AND book_id = ? AND status = 'borrowed'";
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("ii", $student_id, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

    

    // Return a book
    public function returnBook($transaction_id) {
        $return_date = date('Y-m-d');
        $status = 'returned';

        $sql = "UPDATE {$this->table} 
                SET return_date = ?, status = ? 
                WHERE id = ? AND status = 'borrowed'";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("ssi", $return_date, $status, $transaction_id);

        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Book returned successfully'
            ];
        }
        return [
            'success' => false,
            'message' => 'Failed to return book or book already returned'
        ];
    }

   
}