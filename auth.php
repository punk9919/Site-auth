<?php
  require_once 'config.php';

  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
  }

  $username = $_POST["username"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
      header("Location: success.html");
      exit;
    } else {
      echo "Неверный пароль.";
    }
  } else {
    echo "Пользователь не найден.";
  }

  $stmt->close();
  $conn->close();
?>