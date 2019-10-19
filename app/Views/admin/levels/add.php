<!DOCTYPE html>
<html>
<head>
  <title>Quiz</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.css" integrity="sha256-cZDeXQ7c9XipzTtDgc7DML5txS3AkSj0sjGvWcdhfns=" crossorigin="anonymous" />
</head>
<body style="margin: 20px">
  <form id="form-quiz" method="post" class="form-horizontal" action="/admin/levels/add" autocomplete="off">

    <div class="form-group">
      <label for="title">Title</label>
      <input id="title" type="text" class="form-control" name="title" placeholder="Enter title">
    </div>

    <button id="submit-btn" type="submit" class="btn btn-primary">Submit</button>
  </form>
</body>
</html>