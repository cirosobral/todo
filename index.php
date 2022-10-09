<?php

require_once 'db.php';

$dbh = new DB();

$sth = $dbh->prepare("SELECT * FROM `todo`;");

$sth->execute();

$resultados = $sth->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de tarefas</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <style>
    body {
      background-color: #0093E9;
      background-image: linear-gradient(135deg, #0093E9 0%, #80D0C7 100%);
      background-repeat: no-repeat;
      background-attachment: fixed;
    }

    .bg-white:first-of-type {
      border-top-left-radius: 42px
    }

    .bg-white:last-of-type {
      border-bottom-right-radius: 42px
    }

    @keyframes click-wave {
      0% {
        height: 40px;
        width: 40px;
        opacity: 0.15;
        position: relative
      }

      100% {
        height: 200px;
        width: 200px;
        margin-left: -80px;
        margin-top: -80px;
        opacity: 0
      }
    }

    .option-input {
      -webkit-appearance: none;
      -moz-appearance: none;
      -ms-appearance: none;
      -o-appearance: none;
      appearance: none;
      position: relative;
      top: 10.3px;
      right: 0;
      bottom: 0;
      left: 0;
      height: 30px;
      width: 30px;
      transition: all 0.15s ease-out 0s;
      background: #cbd1d8;
      border: none;
      color: #fff;
      cursor: pointer;
      display: inline-block;
      margin-right: 0.5rem;
      outline: none;
      position: relative;
      z-index: 1000
    }

    .option-input:hover {
      background: #9faab7
    }

    .option-input:checked {
      background: limegreen
    }

    .option-input:checked::before {
      height: 30px;
      width: 30px;
      position: absolute;
      content: "✔";
      display: inline-block;
      font-size: 16.7px;
      text-align: center;
      line-height: 30px
    }

    .option-input:checked::after {
      -webkit-animation: click-wave 0.25s;
      -moz-animation: click-wave 0.25s;
      animation: click-wave 0.25s;
      background: green;
      content: '';
      display: block;
      position: relative;
      z-index: 100
    }

    .option-input.radio {
      border-radius: 50%
    }

    .option-input.radio::after {
      border-radius: 50%
    }

    .completed {
      color: gray;
      text-decoration: line-through
    }

    .none {
      color: gray;
      font-style: italic
    }

    .center {
      text-align: center
    }
  </style>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll('input[type=checkbox]').forEach(function(input) {
        input.addEventListener('change', function() {
          const formData = new FormData();
          formData.append(this.name, this.checked);

          fetch('updateTodo.php', {
            method: 'POST',
            body: formData,
          }).then((data) => {
            if (input.checked) {
              input.nextElementSibling.classList.add('completed')
            } else {
              input.nextElementSibling.classList.remove('completed')
            }
          })
        })
      })
    });
  </script>

</head>

<body>
  <div class="container mt-5">
    <div class="d-flex justify-content-center row">
      <div class="col-md-6">
        <div class="p-4 bg-white">
          <div class="d-flex flex-row align-items-center">
            <h4>Lista de tarefas ✅</h4>
          </div>
        </div>
        <div class="p-2 bg-white">
          <form action="addTodo.php" method="post">
            <input type="text" class="form-control" name="todo" placeholder="Nova tarefa">
          </form>
        </div>
        <div class="p-3 bg-white">
          <form method="POST" id="tarefas">
            <?php if (empty($resultados)) { ?>
              <div class="d-flex align-items-center">
                <span class="none">
                  Nenhuma tarefa encontrada.
                </span>
              </div>
            <?php }
            foreach ($resultados as $linha) { ?>
              <div class="d-flex align-items-center">
                <label>
                  <input type="checkbox" class="option-input radio" name="<?php echo $linha['id'] ?>" <?php echo ($linha['feito'] ? "checked" : "") ?>>
                  <span class="label-text<?php echo ($linha['feito'] ? " completed" : "") ?>"><?php echo $linha['texto'] ?></span>
                </label>
              </div>
            <?php } ?>
          </form>
        </div>
        <div class="p-3 bg-white center">
          <button type="submit" form="tarefas" formaction="deleteTodo.php" class="btn btn-danger">🗑 Apagar concluídos</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>