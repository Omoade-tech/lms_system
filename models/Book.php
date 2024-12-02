<?php
require_once '/xampp/htdocs/lms_system/config/database.php';

class Book {
    private $id;
    private $title;
    private $author;
    private $isbn;
    private $available_copies;
    private $connect;

    public function __construct($connection) {
        $this->connect = $connection;
    }

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getIsbn() {
        return $this->isbn;
    }

    public function setIsbn($isbn) {
        $this->isbn = $isbn;
    }

    public function getAvailableCopies() {
        return $this->available_copies;
    }

    public function setAvailableCopies($copies) {
        $this->available_copies = $copies;
    }

    // Add a new book
    public function addBook($data) {
        try {
            $title = mysqli_real_escape_string($this->connect, $data['title']);
            $author = mysqli_real_escape_string($this->connect, $data['author']);
            $isbn = mysqli_real_escape_string($this->connect, $data['isbn']);
            $copies = (int)$data['available_copies'];

            $sql = "INSERT INTO books (title, author, isbn, available_copies) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect->prepare($sql);
            $stmt->bind_param("sssi", $title, $author, $isbn, $copies);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Error adding book: " . $this->connect->error);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Fetch all books
    public function getAllBooks() {
        $sql = "SELECT * FROM books";
        $result = $this->connect->query($sql);
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        return $books;
    }

    // Fetch a book by ID
    public function getBookById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM books WHERE id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Save or update a book
    public function updateBook($data) {
        try {
            $title = mysqli_real_escape_string($this->connect, $data['title']);
            $author = mysqli_real_escape_string($this->connect, $data['author']);
            $isbn = mysqli_real_escape_string($this->connect, $data['isbn']);
            $copies = (int)$data['available_copies'];

            if (isset($data['id']) && !empty($data['id'])) {
                // Update existing book
                $id = (int)$data['id'];
                $sql = "UPDATE books SET title = ?, author = ?, isbn = ?, available_copies = ? WHERE id = ?";
                $stmt = $this->connect->prepare($sql);
                $stmt->bind_param("sssii", $title, $author, $isbn, $copies, $id);
            } else {
                // Insert new book
                $sql = "INSERT INTO books (title, author, isbn, available_copies) VALUES (?, ?, ?, ?)";
                $stmt = $this->connect->prepare($sql);
                $stmt->bind_param("sssi", $title, $author, $isbn, $copies);
            }

            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Delete a book
    public function delete($id) {
        try {
            $id = (int)$id;
            $sql = "DELETE FROM books WHERE id = ?";
            $stmt = $this->connect->prepare($sql);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Borrow a book
    public function borrowBook($id) {
        try {
            $book = $this->getBookById($id);

            if (!$book) {
                throw new Exception("Book not found.");
            }

            if ($book['available_copies'] <= 0) {
                throw new Exception("No available copies to borrow.");
            }

            $sql = "UPDATE books SET available_copies = available_copies - 1 WHERE id = ?";
            $stmt = $this->connect->prepare($sql);
            $stmt->bind_param("i", $id);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Return a borrowed book
    public function returnBook($id) {
        try {
            $book = $this->getBookById($id);

            if (!$book) {
                throw new Exception("Book not found.");
            }

            $sql = "UPDATE books SET available_copies = available_copies + 1 WHERE id = ?";
            $stmt = $this->connect->prepare($sql);
            $stmt->bind_param("i", $id);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Search books
    public function searchBooks($searchTerm) {
        $searchPattern = "%{$searchTerm}%";
        $sql = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("sss", $searchPattern, $searchPattern, $searchPattern);
        $stmt->execute();
        $result = $stmt->get_result();
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        return $books;
    }
}
