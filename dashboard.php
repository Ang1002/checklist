<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="imagenes/kayser_icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="assets/style.css" />
</head>

<body>
  <center>
  <h1>
    Reporte General
  </h1>
    </center>
  <div id="wrapper">
    <div class="content-area">o00
      <div class="container-fluid">
       
        <div class="main">
          <div class="row sparkboxes mt-4">
            <div class="col-md-3">
              <div class="box box1">
                <div class="details">
                  <h3>18</h3>
                  <h4>Areas</h4>
                </div>
                <div id="spark1"></div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="box box2">
                <div class="details">
                  <h3>149</h3>
                  <h4>Elementos</h4>
                </div>
                <div id="spark2"></div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="box box3">
                <div class="details">
                  <h3>303</h3>
                  <h4>Alertas</h4>
                </div>
                <div id="spark3"></div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="box box4">
                <div class="details">
                  <h3> 112 </h3>
                  <h4>Reportes</h4>
                </div>
                <div id="spark4"></div>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-5">
              <div class="box shadow mt-4">
                <div id="radialBarBottom"></div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="box shadow mt-4">
                <div id="line-adwords" class=""></div>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-5">
              <div class="box shadow mt-4">
                <div id="barchart"></div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="box shadow mt-4">
                <div id="areachart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.slim.min.js"></script>
  <script src="apexcharts.js"></script>
  <script src="assets/scripts.js"></script>
</body>

</html>