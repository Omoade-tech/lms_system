<?php
require_once '/xampp/htdocs/lms_system/models/libraryTransaction.php';

class TransactionController {
    private $transaction;

    public function __construct($connect) {
        $this->transaction = new Transaction($connect);
    }

    // Helper: Send JSON response
    private function sendResponse($status, $data = null, $message = null) {
        return json_encode([
            'status' => $status,
            'transaction' => $data,
            'message' => $message
        ]);
    }

    // Fetch all transactions
    public function getAllTransactions() {
        try {
            $transactions = $this->transaction->findAll();
            return $this->sendResponse('success', $transactions);
        } catch (Exception $e) {
            return $this->sendResponse('error', null, $e->getMessage());
        }
    }

    // Fetch a specific transaction by ID
    public function getTransactionById($id) {
        if (empty($id) || !is_numeric($id)) {
            return $this->sendResponse('error', null, 'Invalid transaction ID');
        }

        try {
            $transaction = $this->transaction->findById($id);
            if ($transaction) {
                return $this->sendResponse('success', $transaction);
            } else {
                return $this->sendResponse('error', null, 'Transaction not found');
            }
        } catch (Exception $e) {
            return $this->sendResponse('error', null, $e->getMessage());
        }
    }

    // Create a new transaction
    public function createTransaction($data) {
        if (empty($data['student_id']) || empty($data['book_id']) || empty($data['borrow_date']) || empty($data['return_date']) || empty($data['status'])) {
            return $this->sendResponse('error', null, 'Missing required fields');
        }

        try {
            $result = $this->transaction->createTransaction($data);
            if ($result) {
                return $this->sendResponse('success', null, 'Transaction created successfully');
            } else {
                return $this->sendResponse('error', null, 'Failed to create transaction');
            }
        } catch (Exception $e) {
            return $this->sendResponse('error', null, $e->getMessage());
        }
    }

public function getStudentTransactions($student_id) {
    if (empty($student_id) || !is_numeric($student_id)) {
        return $this->sendResponse('error', null, 'Invalid student ID');
    }

    try {
        $transactions = $this->transaction->findAllByStudentId($student_id);
        return $this->sendResponse('success', $transactions);
    } catch (Exception $e) {
        return $this->sendResponse('error', null, $e->getMessage());
    }
}

    // Update an existing transaction by ID
    public function updateTransaction($id, $data) {
        if (empty($id) || !is_numeric($id)) {
            return $this->sendResponse('error', null, 'Invalid transaction ID');
        }

        try {
            $result = $this->transaction->updateTransaction($id, $data);
            if ($result) {
                return $this->sendResponse('success', null, 'Transaction updated successfully');
            } else {
                return $this->sendResponse('error', null, 'Failed to update transaction');
            }
        } catch (Exception $e) {
            return $this->sendResponse('error', null, $e->getMessage());
        }
    }

   
public function borrowBook($student_id, $book_id, $return_date) {
    if (empty($student_id) || empty($book_id) || empty($return_date)) {
        return $this->sendResponse('error', null, 'Missing student ID, book ID, or return date');
    }

    try {
        $response = $this->transaction->borrowBook($student_id, $book_id, $return_date);
        return $this->sendResponse(
            $response['success'] ? 'success' : 'error',
            null,
            $response['message']
        );
    } catch (Exception $e) {
        return $this->sendResponse('error', null, $e->getMessage());
    }
}



   // Return a book by transaction ID
public function returnBook($transaction_id) {
    if (empty($transaction_id) || !is_numeric($transaction_id)) {
        return $this->sendResponse('error', null, 'Invalid transaction ID');
    }

    try {
        $result = $this->transaction->returnBook($transaction_id);
        if ($result['success']) {
            return $this->sendResponse('success', null, $result['message']);
        } else {
            return $this->sendResponse('error', null, $result['message']);
        }
    } catch (Exception $e) {
        return $this->sendResponse('error', null, $e->getMessage());
    }
}

}