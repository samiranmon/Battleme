<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>Welcome to Tournament</title>
<!-- Bootstrap -->
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href="<?php echo base_url(); ?>public/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?=base_url('public/css/tournament_style.css')?>" rel="stylesheet">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 

</head>
<body>

    
<?php $this->load->view($middle); ?>





<!-- Include all compiled plugins (below), or include individual files as needed --> 
<!--<script src="js/bootstrap.js"></script>-->
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){

 $(".first_round_team_structure > .round_against_team").each(function(){

  var innerBoxCount = $(this).children(".round_team").length;
  console.log(innerBoxCount);

  if(innerBoxCount > 1 && innerBoxCount <= 2)
  {
   $(this).addClass("vs1");
   
  }


 } ); 
    
    
$(".second_round_team_structure > .round_against_team").each(function(){

  var innerBoxCount = $(this).children(".round_team").length;
  console.log(innerBoxCount);

  if(innerBoxCount > 1 && innerBoxCount <= 2)
  {
   $(this).addClass("vs2");
   
  }


 } ); 
    
    $(".third_round_team_structure > .round_against_team").each(function(){

  var innerBoxCount = $(this).children(".round_team").length;
  console.log(innerBoxCount);

  if(innerBoxCount > 1 && innerBoxCount <= 2)
  {
   $(this).addClass("vs3");
   
  }


 } ); 
    
    $(".fourth_round_team_structure > .round_against_team").each(function(){

  var innerBoxCount = $(this).children(".round_team").length;
  console.log(innerBoxCount);

  if(innerBoxCount > 1 && innerBoxCount <= 2)
  {
   $(this).addClass("vs4");
   
  }


 } ); 
    
    $(".fifth_round_team_structure > .round_against_team").each(function(){

  var innerBoxCount = $(this).children(".round_team").length;
  console.log(innerBoxCount);

  if(innerBoxCount > 1 && innerBoxCount <= 2)
  {
   $(this).addClass("vs5");
   
  }


 } ); 


  
});
</script>    
</body>
</html>