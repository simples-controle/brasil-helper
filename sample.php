<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Brasil Helper</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
    <style rel="stylesheet">
      .box-demonstration{
          border-radius:3px; border: 1px solid #e1e1e1; padding: 15px; color: #555; font-weight: bold;
          background-color: whitesmoke;
          margin-bottom: 15px;
      }
      .method{
        color: #555;
        font-weight: normal;
      }
      .function,.class{
        color: navy;
        font-weight: bold;
      }
      .var{
        color: #DFB073
      }

      .var-class{
        color: #3ae86b;
      }
      .static{
        color: #d62c5f
      }
      h1 {
      	font-family: Raleway;
      	font-size: 28px;
        font-weight: bold;
      	line-height: 26.4px;
      }
      h3 {
      	font-family: Raleway;
      	font-size: 18px;
        font-weight: bold;
      	line-height: 15.4px;
      }
      p {
      	font-family: Raleway;
      	font-size: 14px !important;
      	font-style: normal;
      	font-variant: normal;
      	font-weight: 400;
      	line-height: 20px;
      }
      blockquote {
      	font-family: Raleway;
      	font-size: 21px;
      	font-style: normal;
      	font-variant: normal;
      	font-weight: 400;
      	line-height: 30px;
      }
      pre {
      	font-family: Raleway;
      	font-size: 13px;
      	font-style: normal;
      	font-variant: normal;
      	font-weight: 400;
      	line-height: 18.5714px;
      }
      code{
        width: 100%;
        background-color: transparent;
      }
      footer{
        width: 100%;
        background-color: #EEE;
        height: 80px;
        margin-top: 30px;
        padding: 15px;
        text-align: left;
      }
    </style>
  </head>
  <body style="background-color: #f5f5f5">
    <?php
    // Report all PHP errors
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include('BrasilHelper.php');

    include('lib/pierophp/InscricaoEstadual.php');

    $BrasilHelper = new sururulab\BrasilHelper\BrasilHelper();

    ?>

    <div class="container">
      <div class="clearfix">
        &nbsp;
      </div>
      <div class="col-md-12">
        <center>
           <figure>
             <img src="imgs/logo.png" class="img-thumbnail" alt="Cinque Terre" width="164" height="164">
           </figure>
        </center>
      </div>

      <div class="clearfix">
        &nbsp;
      </div>

      <div class="jumbotron">

          <h3>CPF e CNPJ</h3>
          <hr>
          <div class=" box-demonstration col-md-12">
            <div class="col-md-6">
              <img src="imgs/allcodes.png" class="img-rounded img-responsive" alt="Cinque Terre">
            </div>
            <div class=" col-md-6 box-demonstration" style="height: 100%; font-family">
              <p>retorno: "1";</p>
              <p>retorno: "1";</p>
              <p>retorno: "<span class="var">635.850.266-21</span>";</p>
              <p>retorno: "<span class="var">23.419.212/0001-03</span>";</p>
              <br>
            </div>
          </div>


          <h3>Estados Brasileiros</h3>
          <hr>

          <div class="col-md-12 box-demonstration">
              <div class="col-md-6">
                  <img src="imgs/forek.png" class="img-rounded img-responsive" alt="Cinque Terre">
              </div>
              <div  class="col-md-6 box-demonstration" style="font-weight: normal;">
                  <p>Acre</p>
                  <p>Alagoas</p>
                  <p>Amazonas</p>
                  <p>Amapá</p>
                  ...
              </div>
          </div>

          <h3>Cidades Brasileiras por Estado</h3>
          <hr>

          <div class="col-md-12 box-demonstration">
              <div class="col-md-6">
                  <img src="imgs/cidades.png" class="img-rounded img-responsive" alt="Cinque Terre">
              </div>
              <div  class="col-md-6 box-demonstration" style="font-weight: normal;">
                  <img src="imgs/vardump.png" class="img-rounded img-responsive" alt="Cinque Terre">
              </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>

    <footer>
     <p class="text-muted">  Copyright  ©  <a href="https://www.facebook.com/sururulab/">sururulab</a> <?=date('Y') ?> Copyright Holder All Rights Reserved. </p>
    </footer>
  </body>
</html>
