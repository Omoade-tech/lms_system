<?php 
include("/xampp/htdocs/lms_system/models/libraryTransaction.php");

class TransactionController {
    private $transaction;
    public function __construct($connect) {
        $this->transaction = new Transaction($connect);
    }
    public function findAll() 
    {
        $transaction = $this->transaction->findAll();

        if ($transaction) {
            return ['success' => true,'transaction'=> $transaction];
        }
        return ['error' => 'No Library Transaction Found' ];
    }
    public function findStudentById($student_id) {
    $transaction = $this->transaction->findStudentById($student_id);

    if ($transaction) {
        return ['success' => true, 'transactions' => $transaction];
    }
    return ['error' => 'No transactions found for the specified student ID'];
}

}