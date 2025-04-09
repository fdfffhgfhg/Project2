<?php
   require_once "./mvc/core/redirect.php";
   require_once "./mvc/core/constant.php";
   $redirect = new redirect();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>
    <base href="http://localhost/Project2Web/">
    <!-- Bootstrap -->
    <link href="public/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="public/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="public/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="public/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="public/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="auth/login" method="post">
              <h1>Login Form</h1>
              <div>
                <input type="text" name="username" value="<?= $data['datas']!=null?$data['datas']['username']:''?>" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="password" value="<?= $data['datas']!=null?$data['datas']['password']:''?>" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button class="btn btn-primary" href="index.html">Log in</button>
                <label for="remember">Ghi nho thong tin dang nhap</label>
                <input type = "checkbox" name="remember" <?= $data['datas']!=null?$data['datas']['remember']==1?'checked':'':''?> value="1" id="remember">
              </div>

              <div class="clearfix"></div>
              <div class="clearfix"></div>
              <br />

                <div>
                    <?php if(isset($_SESSION['errors'])){ ?>
                         <h4 class="text-danger"><?= $redirect->setFlash('errors') ?></h4>
                     <?php } ?>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>