<?php
session_start();

$db = new SQLite3('messages.db');

$successMessage = '';
$isAdmin = $_SESSION['isAdmin'] ?? false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = $db->query("SELECT * FROM admin WHERE username='$username' AND password='$password'");
    if ($result->fetchArray()) {
      $_SESSION['isAdmin'] = true;
      $isAdmin = true;
    }
  } elseif (isset($_POST['logout'])) {
    session_destroy();
    $isAdmin = false;
    $_SESSION['isAdmin'] = false;
  } elseif (isset($_POST['message'])) {
    $message = $_POST['message'];
    $stmt = $db->prepare('INSERT INTO messages (message) VALUES (:message)');
    $stmt->bindValue(':message', $message, SQLITE3_TEXT);
    $stmt->execute();
    $successMessage = 'تم إرسال صراحتك بنجاح!';
  } elseif (isset($_POST['delete_id']) && $isAdmin) {
    $delete_id = $_POST['delete_id'];
    $db->query("DELETE FROM messages WHERE id='$delete_id'");
  }
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <title>صارح تركي</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    h1 {
      font-size: 2em;
      margin-top: 20px;
    }
    form {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 20px;
      width: 80%;
      max-width: 400px;
    }
    textarea {
  width: 90%;
  min-height: 100px;
  padding: 15px;
  font-size: 18px;
  border-radius: 8px;
  border: 1px solid #ccc;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
  font-family: 'Cairo', sans-serif;  /* استخدام الخط العربي الذي اخترته */
}
    button {
      padding: 15px 25px;
      background-color: blue;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    .success {
      background-color: green;
      color: white;
      padding: 15px;
      margin: 10px;
      width: 50%;
      max-width: 800px;
      text-align: center;
      border-radius: 8px;
    }
.card {
  width: 80%;
  border: 1px solid #ccc;
  padding: 20px;
  margin: 10px 0;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  border-radius: 12px;
  position: relative;
  word-wrap: break-word;
  padding-bottom: 40px;
}

.card-actions {
  position: absolute;
  bottom: 10px;
  right: 10px;
  font-size: 18px; /* تكبير حجم الأيقونات */
}

.card-actions a, .card-actions button {
  margin: 0 2px; /* تقليل المسافة بين الأيقونات */
  padding: 0;
}

.card-actions .delete-icon,
.card-actions .twitter-icon {
  vertical-align: bottom; /* للتأكيد على محاذاة الأيقونات */
}

.card-actions .delete-icon {
  color: red;
}

.card-actions .twitter-icon {
  color: #1DA1F2;
}

  .modal {
    display: none;
    position: fixed;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
  }
  .modal-content {
    margin: 20% auto;
    padding: 20px;
    background-color: #fff;
    width: 50%;
  }
#loginBtn {
  font-size: 24px;
  color: #FFFFFF;
  cursor: pointer;
  background-color: #007bff;
  padding: 10px;
  border-radius: 50%;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}
#loginBtn:hover {
  background-color: #0056b3;
}
.timestamp {
  font-size: 0.8em;
  color: gray;
  float: left;
}
.unread-dot {
  position: absolute;
  width: 10px;
  height: 10px;
  background-color: green;
  border-radius: 50%;
  top: 10px;
  left: 10px;
}


  </style>
</head>
<body>

<i id="loginBtn" class="fas fa-sign-in-alt"></i>


<center>
  <h1>صارحني</h1>

  <?php if($successMessage): ?>
    <div class="success">
      <?php echo $successMessage; ?>
    </div>
  <?php endif; ?>

  <form action="index.php" method="post">
    <textarea name="message" placeholder="أدخل صراحتك هنا"></textarea>
    <button type="submit">إرسال</button>
  </form>


<?php if ($isAdmin): ?>
<div>
  <h2>الصراحات الحديثة:</h2>
  <?php
    $results = $db->query('SELECT * FROM messages ORDER BY id DESC');
    while ($row = $results->fetchArray()) {
      $class = $row['viewed'] ? 'read' : 'unread';
      echo "<div class='card $class'>";
      if (!$row['viewed']) {
        echo "<div class='unread-dot'></div>";
      }
      echo "{$row['message']} <span style='float: left;'>{$row['timestamp']}</span>";
      if ($isAdmin) {
        echo "<div class='card-actions'>
                <form method='post' style='display: inline;'>
                  <button type='submit' name='delete_id' value='{$row['id']}' style='background: none; border: none;'>
                    <i class='fas fa-trash-alt delete-icon'></i>
                  </button>
                </form>";
        $tweetText = urlencode("({$row['message']})");
        echo "<a href='https://twitter.com/intent/tweet?text=$tweetText' target='_blank'>
                <i class='fab fa-twitter twitter-icon'></i>
              </a>
            </div>";
      }
      echo "</div>";
    }
  ?>
</div>
<?php endif; ?>



  <center>
  <div id="loginModal" class="modal">
  <div class="modal-content">
    <span id="closeBtn">&times;</span>
    <form method="post">
      <input type="text" name="username" placeholder="اسم المستخدم">
      <input type="password" name="password" placeholder="كلمة المرور">
      <button type="submit" name="login">تسجيل الدخول</button>
    </form>
  </div>
</div>
<script>
  var modal = document.getElementById("loginModal");
  var btn = document.getElementById("loginBtn");
  var span = document.getElementById("closeBtn");

  btn.onclick = function() {
    modal.style.display = "block";
  }
  
  span.onclick = function() {
    modal.style.display = "none";
  }
  
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>

</body>
</html>