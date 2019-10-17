<!DOCTYPE html>
<html>
<head>
  <title>View Quiz</title>
</head>
<body style="font-family: sans-serif;">
  <a href="/admin/quizzes">Back</a>
  <br />

  <h3>ID: <?= $quiz['id'] ?></h3>
  <h3>Level: <?= $quiz['level_title'] ?></h3>
  <h3>Question: <?= $quiz['question'] ?></h3>
  <h3>Answer: <?= $quiz['answer'] ?></h3>
  <h3>Description: <?= $quiz['description'] ?></h3>
  <img src="/image/<?= $quiz['id'] ?>.normal.jpg" />
</body>
</html>