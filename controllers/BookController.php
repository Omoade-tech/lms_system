<?php
include("/xampp/htdocs/lms_system/models/Book.php");

class BookController {
    private $bookModel;

    public function __construct($connection) {
        $this->bookModel = new Book($connection);
    }

    public function getAllBooks() {
        return $this->bookModel->getAllBooks();
    }

    public function getBook($id) {
        return $this->bookModel->getBookById($id);
    }

    public function createBook($bookData) {
        return $this->bookModel->addBook($bookData);
    }

    public function updateBook($bookData) {
        return $this->bookModel->updateBook($bookData);
    }

    public function deleteBook($id) {
        return $this->bookModel->delete($id);
    }

    // public function borrowBook($id) {
    
    //     $book = $this->bookModel->getBookById($id);
    //     if (!$book || $book['available_copies'] <= 0) {
    //         return false; 
    //     }

        
    //     $borrow_date = date("Y-m-d"); 
    //     $return_date = date("Y-m-d", strtotime("+30 days")); 


    //     return $this->bookModel->borrowBook($id, $borrow_date, $return_date);
    // }
    public function borrowBook($id, $return_date, $student_id, $student_name) {
        $book = $this->bookModel->getBookById($id);
    
        if (!$book || $book['available_copies'] <= 0) {
            return false; 
        }
    
        $borrow_date = date("Y-m-d");
    
        // Borrow the book in the Book model
        $isBookBorrowed = $this->bookModel->borrowBook($id, $borrow_date, $return_date);
    
        if ($isBookBorrowed) {
            // Record transaction in the Transaction model
            $transactionModel = new Transaction($this->bookModel->connect); // Assuming same connection
            return $transactionModel->createTransaction([
                'student_id' => $student_id,
                'student_name' => $student_name,
                'book_id' => $id,
                'book_title' => $book['title'],
                'borrow_date' => $borrow_date,
                'return_date' => $return_date,
                'status' => 'Borrowed'
            ]);
        }
    
        return false;
    }
    

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['deleteBook'])) {
                $id = $_POST['id'];
                if ($this->deleteBook($id)) {
                    header("Location: /lms_system/views/Admin/books.php?success=delete");
                } else {
                    header("Location: /lms_system/views/Admin/books.php?error=delete");
                }
                exit;
            }

            if (isset($_POST['updateBook'])) {
                $bookData = [
                    'id' => $_POST['id'],
                    'title' => $_POST['title'],
                    'author' => $_POST['author'],
                    'isbn' => $_POST['isbn'],
                    'available_copies' => $_POST['available_copies']
                ];
                if ($this->updateBook($bookData)) {
                    header("Location: /lms_system/views/Admin/books.php?success=update");
                } else {
                    header("Location: /lms_system/views/Admin/books.php?error=update");
                }
                exit;
            }

            if (isset($_POST['addBook'])) {
                $bookData = [
                    'title' => $_POST['title'],
                    'author' => $_POST['author'],
                    'isbn' => $_POST['isbn'],
                    'available_copies' => $_POST['available_copies']
                ];
            
                if ($this->createBook($bookData)) {
                    header("Location: /lms_system/views/Admin/addbook.php?success=add");
                } else {
                    header("Location: /lms_system/views/Admin/admin.php?error=add");
                }
                exit;
            }

            if (isset($_POST['borrowBook'])) {
                $id = $_POST['id'];
                if ($this->borrowBook($id)) {
                    header("Location: /lms_system/views/student/students.php?success=borrow");
                } else {
                    header("Location: /lms_system/views/student/book.php?error=borrow");
                }
                exit;
            }
        }
    }
}

include_once("/xampp/htdocs/lms_system/config/database.php");
$controller = new BookController($connect);
$controller->handleRequest();
?>