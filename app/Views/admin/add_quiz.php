<!DOCTYPE html>
<html>
<head>
  <title>Quiz</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.css" integrity="sha256-cZDeXQ7c9XipzTtDgc7DML5txS3AkSj0sjGvWcdhfns=" crossorigin="anonymous" />
</head>
<body style="margin: 20px">
  <form id="form-quiz" method="post" class="form-horizontal" action="/admin/quizzes/add" autocomplete="off">
    <div class="form-group">
      <label for="answer">Level</label>
      <select name="level_id" class="form-control">
        <?php foreach($levels as $level): ?>
          <option value="<?= $level->id ?>"><?= $level->title ?></option>
        <?php endforeach ?>
      </select>
    </div>

    <div class="form-group">
      <label for="question">Question</label>
      <input id="question" type="text" class="form-control" name="question" placeholder="Enter question">
    </div>

    <div class="form-group">
      <label for="answer">Answer</label>
      <input id="answer" type="text" class="form-control" name="answer" placeholder="Enter answer">
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <input id="description" type="text" class="form-control" name="description" placeholder="Enter description">
    </div>

    <div class="form-group">
      <label for="description">Photo</label>
      <input type="file" name="image" id="image" onchange="readURL(this)"/>
      <input type="hidden" name="quiz_pict" id="quiz-pict">
      <div class="img-container" style="max-height: 550px; max-width: 550px;">
        <img id="photo" />
      </div>
    </div>

    <button id="submit-btn" type="button" class="btn btn-primary">Submit</button>
  </form>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js" integrity="sha256-EuV9YMxdV2Es4m9Q11L6t42ajVDj1x+6NZH4U1F+Jvw=" crossorigin="anonymous"></script>

  <script type="text/javascript">
    var cropper

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader()
        reader.onload = function (e) {
          $('#photo').attr('src', e.target.result)
          initCropper()
        }
        reader.readAsDataURL(input.files[0])
      }
    }

    function initCropper() {
      if(cropper) cropper.destroy()

      const $photo = document.getElementById('photo')
      cropper = new Cropper($photo, {
        aspectRatio: 1 / 1,
        minCropBoxWidth: 400,
        minCropBoxHeight: 400,
        viewMode: 1
      })
    }

    $('#submit-btn').click(function() {
      $('#answer').val($('#answer').val().toLowerCase())

      if(!cropper) return alert('image required')

      if(!$('#question').val()) return alert('question is required')
      if(!$('#answer').val()) return alert('answer is required')
      if(!$('#description').val()) return alert('description is required')

      if($('#answer').val().length > 20) return alert('answer max 20 character')

      const imgUrl = cropper.getCroppedCanvas().toDataURL()
      $('#quiz-pict').val(imgUrl)
      $('#form-quiz').submit()
    })
  </script>
</body>
</html>