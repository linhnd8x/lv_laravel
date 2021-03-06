<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog Demo | Find All Together</title>
    <link href="<?php echo e(asset('/css/app.css')); ?>" rel="stylesheet">
    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.findalltogether.com">Find All Together</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li>
              <a href="<?php echo e(url('/')); ?>">Home</a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if(Auth::guest()): ?>
            <li>
              <a href="<?php echo e(url('/auth/login')); ?>">Login</a>
            </li>
            <li>
              <a href="<?php echo e(url('/auth/register')); ?>">Register</a>
            </li>
            <?php else: ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo e(Auth::user()->name); ?> <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <?php if(Auth::user()->can_post()): ?>
                <li>
                  <a href="<?php echo e(url('/new-post')); ?>">Add new post</a>
                </li>
                <li>
                  <a href="<?php echo e(url('/user/'.Auth::id().'/posts')); ?>">My Posts</a>
                </li>
                <?php endif; ?>
                <li>
                  <a href="<?php echo e(url('/user/'.Auth::id())); ?>">My Profile</a>
                </li>
                <li>
                  <a href="<?php echo e(url('/auth/logout')); ?>">Logout</a>
                </li>
              </ul>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container">
      <?php if(Session::has('message')): ?>
      <div class="flash alert-info">
        <p class="panel-body">
          <?php echo e(Session::get('message')); ?>

        </p>
      </div>
      <?php endif; ?>
      <?php if($errors->any()): ?>
      <div class='flash alert-danger'>
        <ul class="panel-body">
          <?php foreach( $errors->all() as $error ): ?>
          <li>
            <?php echo e($error); ?>

          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
      <div class="row">
        <!-- <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h2><?php echo $__env->yieldContent('title'); ?></h2>
              <?php echo $__env->yieldContent('title-meta'); ?>
            </div>
            <div class="panel-body"> -->
              <?php echo $__env->yieldContent('content'); ?>
       <!--      </div>
          </div>
        </div> -->
      </div>
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <p>Copyright © 2015 | <a href="http://www.findalltogether.com">Find All Together</a></p>
        </div>
      </div>
    </div>
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
