<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <title><?=  isset($battleCategoryName)? $battleCategoryName : 'Battleme'?></title>
<!--    <link rel="stylesheet" type="text/css" href="css/menu.css">-->
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>public/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/asScrollbar.css">
    <link href="<?php echo base_url(); ?>public/css/style.css" rel="stylesheet"> 
    
    
    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
    </script>
    <script src="<?php echo base_url('public/js/jquery.min.js'); ?>"></script>
   
    
    </head>
    
    <?php if ($this->router->fetch_class().'/'.$this->router->fetch_method()=='user/index' 
            || $this->router->fetch_class().'/'.$this->router->fetch_method()=='user/login'
            || $this->router->fetch_class().'/'.$this->router->fetch_method()=='contactUs/index'
            || $this->router->fetch_class().'/'.$this->router->fetch_method()=='login/index'
            || $this->router->fetch_class().'/'.$this->router->fetch_method()=='forgetpassword/index') { ?>
        <body class="repeated-background">
    <?php } else { ?>
            <body>
    <?php } ?>
