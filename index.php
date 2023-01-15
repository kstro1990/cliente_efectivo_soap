<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Efectivo API - SOAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body class="bg-body ">
    <div class="container text-center">
      <h1>Efectivo - SOAP directo </h1>
    </div>
    
    <div class="container-md">
      <?php
      $tempID = '';
      $login = '';
      $secretKey = '';
      session_start();
      if (!$_SESSION) {
          echo 'is null cara he chimba';
      } else {
          if ($_SESSION['idorden']) {
              echo 'id Orden: ' . $_SESSION['idorden'];
              $tempID = $_SESSION['idorden'];
          }
          $login = $_SESSION['login'];
          $secretKey = $_SESSION['secretKey'];
      }
      ?>
    </div>

    <div class="container">
      <div class="row">
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Credenciales
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <form method="post" id="credencialFrom" name="credencialFrom" action="src/session/creden.php">
                    <div class="mb-3">
                      <label for="login" class="form-label">Login</label>
                      <input type="login" class="form-control" id="login" name="login" value= <?php echo $login; ?>>
                    </div>
                    <div class="mb-3">
                      <label for="secretKey" class="form-label">SecretKey</label>
                      <input type="secretKey" class="form-control" id="secretKey" name="secretKey" value= <?php echo $secretKey; ?>>
                    </div>
                    <input type="hidden" value="credeciales" name="idForm" >
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-md">
      <div class="p-2 g-col-6 style="width: 200px;"></div>
    </div>

    <div class="container text-center">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Crear orden de pago</h5>
              <form method="post" id="addOrdenForm" name="addOrden" action="src/index.php">
                <div class="mb-3">
                  <label for="email" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                </div>
                <input type="hidden" value="addOrden" name="idForm" >
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Buscar orden de pago</h5>
                <form method="post" id="addOrdenForm" name="addOrden" action="src/index.php">
                  <div class="mb-3">
                    <label for="orderid" class="form-label">ID orden</label>
                    <input type="number" class="form-control" id="orderid" name="orderid" value= <?php echo $tempID; ?> >
                  </div>
                  <input type="hidden" value="get" name="idForm" >
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
          </div >
        </div>
        
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Eliminar orden de pago</h5>
                <form method="post" id="addOrdenForm" name="addOrden" action="src/index.php">
                  <div class="mb-3">
                    <label for="orderid" class="form-label">ID orden</label>
                    <input type="number" class="form-control" id="orderid" name="orderid" value= <?php echo $tempID; ?> >
                  </div>
                  <input type="hidden" value="delete" name="idForm" >
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
          </div >
        </div>
        <div class="col">
          <div class="mb-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Generar PDF</h5>
                <form method="post" id="addOrdenForm" name="addOrden" action="src/index.php">
                  <div class="mb-3">
                    <label for="orderid" class="form-label">ID orden</label>
                    <input type="number" class="form-control" id="orderid" name="orderid" value= <?php echo $tempID; ?>>
                  </div>
                  <input type="hidden" value="getPDF" name="idForm">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container text-center">
      <a href="src/session/deleteSession.php" class="btn btn-danger"> Elimnar Session</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>