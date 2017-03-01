
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <base href="<?php echo base_url(); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title; ?></title>

  <!-- Global stylesheets -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
  <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
  <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="assets/css/core.css" rel="stylesheet" type="text/css">
  <link href="assets/css/components.css" rel="stylesheet" type="text/css">
  <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
  <!-- /global stylesheets -->

  <!-- Core JS files -->
  <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
  <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
  <!-- /core JS files -->

  <!-- Theme JS files -->
  <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

  <script type="text/javascript" src="assets/js/core/app.js"></script>
  <script type="text/javascript" src="assets/js/pages/login.js"></script>
  <!-- /theme JS files -->

</head>

<body class="login-container">

  <!-- Main navbar -->
  <!-- <div class="navbar navbar-inverse">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.html"><img src="assets/images/logo_light.png" alt=""></a>

      <ul class="nav navbar-nav pull-right visible-xs-block">
        <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
      </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="#">
            <i class="icon-display4"></i> <span class="visible-xs-inline-block position-right"> Go to website</span>
          </a>
        </li>

        <li>
          <a href="#">
            <i class="icon-user-tie"></i> <span class="visible-xs-inline-block position-right"> Contact admin</span>
          </a>
        </li>

        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-cog3"></i>
            <span class="visible-xs-inline-block position-right"> Options</span>
          </a>
        </li>
      </ul>
    </div>
  </div> -->
  <!-- /main navbar -->


  <!-- Page container -->
  <div class="page-container">

    <!-- Page content -->
    <div class="page-content">

      <!-- Main content -->
      <div class="content-wrapper">

        <!-- Content area -->
        <div class="content">
          
          <!-- Advanced login -->
          <form method="POST" action="<?php echo base_url() . 'index.php/home/check_login';?>">
            <div class="panel panel-body login-form">
              <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                <?php if ($this->session->flashdata('error') != '') {?>
                  <span class="help-block text-danger">
                    <i class="icon-cancel-circle2 position-left"></i> 
                    <strong>Warning!</strong> <?php echo $this->session->flashdata('error');?>
                  </span>
                <?php } ?>
                <h5 class="content-group">Login to your account <small class="display-block">Your credentials</small></h5>
              </div>

              <div class="form-group has-feedback has-feedback-left">
                <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" >
                <div class="form-control-feedback">
                  <i class="icon-user text-muted"></i>
                </div>
              </div>

              <div class="form-group has-feedback has-feedback-left">
                <input type="password" class="form-control" name="password" required="">
                <div class="form-control-feedback">
                  <i class="icon-lock2 text-muted"></i>
                </div>
              </div>

              <div class="form-group login-options">
                <div class="row">
                  <div class="col-sm-6">
                    <label class="checkbox-inline">
                      <input type="checkbox" class="styled" checked="checked">
                      Remember
                    </label>
                  </div>

                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn bg-blue btn-block">Login <i class="icon-arrow-right14 position-right"></i></button>
                <input type="hidden" name="ci_nonce" value="<?php echo $ci_nonce;?>">
              </div>

            </div>
          </form>
          <!-- /advanced login -->
          
        </div>
        <!-- /content area -->

      </div>
      <!-- /main content -->

    </div>
    <!-- /page content -->

  </div>
  <!-- /page container -->

</body>
</html>