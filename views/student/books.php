<?php
include_once("/xampp/htdocs/lms_system/config/database.php");
include_once("/xampp/htdocs/lms_system/controllers/BookController.php");

$bookController = new BookController($connect);
$books = $bookController->getAllBooks();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $result = $bookController->borrowBook($id);

  if ($result) {
      header('Location: ../lms_system/views/student/books.php?message=Book Borrowed Successfully');
  } else {
      header('Location: /view/book.php?error=Failed to Borrow Book');
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  
<div class="container mt-5">
        <div class="card">
            <div class="card-body">
  
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Title</th>
          <th scope="col">Author</th>
          <th scope="col">ISBN</th>
          <th scope="col">Available Copies</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($books)) : ?>
          <?php foreach ($books as $book) : ?>
            <tr>

              <td><?= htmlspecialchars($book['title']) ?></td>
              <td><?= htmlspecialchars($book['author']) ?></td>
              <td><?= htmlspecialchars($book['isbn']) ?></td>
              <td>
                <?php if ($book['available_copies'] > 0): ?>
                  <span class="text-success">Available</span>
                <?php else: ?>
                  <span class="text-danger">Not Available</span>
                <?php endif; ?>
              </td>
              <td>
                                  <a href="/lms_system/views/student/viewbook.php?id=<?= $book['id'] ?>" 
   class="btn btn-info btn-sm <?= $book['available_copies'] == 0 ? 'disabled' : '' ?>">
    Borrow
</a>

                                </td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>

      </tbody>
    </table>
  </div>
  </div>
  </div>
</body>

</html>