<?php
  require_once 'config.php';

  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
  }

  $username = $_POST["username"];
  $password = $_POST["password"];
  $password_confirm = $_POST["password_confirm"];

  if ($password !== $password_confirm) {
    die("Пароли не совпадают!");
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Используйте bcrypt или Argon2i в продакшене!

  $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $username, $hashed_password);

  if ($stmt->execute()) {
    header("Location: login.html");
    exit;
  } else {
    echo "Ошибка регистрации.";
  }

  $stmt->close();
  $conn->close();
?>