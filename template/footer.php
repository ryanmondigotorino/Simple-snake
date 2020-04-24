<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="./js/snake.js" type="text/javascript"></script>
<script type="text/javascript">
  if (window.location.pathname.includes('game.php')) {
    GLOBALSNAKE.EVENTS();
    $('.playerName').html(localStorage.getItem('name'));
    $.ajax({
      type: 'get',
      url: '/backend/backend.php',
    }).done((response) => {
      $('span#highScore').html(response);
    });
  }
  $('button.play-now').on('click', function() {
    const target =  $('input[name="name"]');
    localStorage.setItem("name", target.val());
    window.location.href = $(this).attr('data-url')
  });
</script>