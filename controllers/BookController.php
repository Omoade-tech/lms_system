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
    public function searchBooks($searchTerm) {
        return $this->bookModel->searchBooks($searchTerm);
    }
    
    // public function handleRequest() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         if (isset($_POST['searchBooks'])) {
    //             $searchTerm = $_POST['search'];
    //             $books = $this->searchBooks($searchTerm);
    //             include "/xampp/htdocs/lms_system/views/Admin/books.php"; 
    //             exit;
    //         }
        
    //     }
    // }
    

  
    

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
                if (isset($_POST['searchBooks'])) {
                    $searchTerm = $_POST['search'];
                    $books = $this->searchBooks($searchTerm);
                    include "/xampp/htdocs/lms_system/views/Admin/books.php"; 
                    exit;
                }
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

          
        }
    }
}

include_once("/xampp/htdocs/lms_system/config/database.php");
$controller = new BookController($connect);
$controller->handleRequest();
?>