<!DOCTYPE html>
<?php require_once 'core.php'; ?>
<html lang="en">
<head>
  <title>Buying and Selling Portal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <!-- Page styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="$$hosted_libs_prefix$$/$$version$$/material.min.css">
  
  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
  </style>
</head>
<link href="login_style.css" rel="stylesheet">
<link href="css/divison_style.css" rel="stylesheet">
<link href="timeline.css" rel="stylesheet">
<body >




<nav class="navbar-fixed navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Buy and Sell</a>
    </div>

    <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
    <span class ="icon-bar"></span>
    <span class ="icon-bar"></span>
    <span class ="icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse navHeaderCollapse">

      <ul class="nav navbar-nav navbar-right">
      <li class="active"><a href="home.php">Home</a></li>

      <li> 
  <a href = "create_adv.php">Create Advertisement</a></li>
     


      <?php 
      if(loggedin())
      {
      		$temp = $_SESSION['username'];
      		echo <<< _END
      		<li><a href="profile.php">Welcome ! $temp</a>
      		<li><a href="logout.php">Logout</a> 
_END;
      		
      }
      else
      {
      		echo <<< _END
      		<li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
      		<li><a href="login.php"><span class="glyphicon glyphicon-user"></span> Sign In</a>
_END;
      }
     
      ?>

	 </ul>
    </div>  

   
     
  </div>
</nav>

</br>
 <!-- Slide show starts******************************** -->
 <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="buy.png" alt="buy image">
    </div>

 

    <div class="item">
      <img src="sell.png" alt="rent image">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<!-- Slide show ENDS******************************** -->




<br>
<div class="container" >
<div class="container" style="background-color:white">

<div class="row" style="background-color:lightblue">

  <div class="col-md-12 col-xs-6"   >
  	<form method="post" action="home.php">
	<fieldset style="padding:20px;">
  <div class="col-md-3" >
                <legend>Filter by category</legend>
                        <input type="checkbox" name="category[]" value="book" />Books <br>
                        <input type="checkbox" name="category[]" value="electronics" />Electronics <br>
                        <input type="checkbox" name="category[]" value="Vehicles" /> Vehicles <br>
                        <input type="checkbox" name="category[]" value="accessories" />Accessories <br>
						            <input type="checkbox" name="category[]" value="other" />other 
            </div>
            <div class="col-md-3">
				<legend>Filter by Area</legend>
						<select  name =  "area" class="input pass"  value = "$area">
        				<option  value="">Select your locality</option>
						<option  value="Vijayanagar" >Vijayanagar</option>
						<option  value="Rajajinagar" >Rajajinagar</option>
						<option  value="MG_Road">MG Road</option>
						<option  value="RT_Nagar">RT Nagar</option>
						<option  value="Indranagar">Indranagar</option>
						<option  value="JP_nagar">JP Nagar</option>
						<option  value="Peenya">Peenya</option>
						</select>
            </div>
            <div class="col-md-3">
				<legend>Filter by Price</legend>
        <br>
						<input type="number" name="init_price" placeholder="lowest price"> <br>
						<input type="number" name="final_price" placeholder="highest price">
				</div>	
        <div class="col-md-3">			
				<input type="submit" value="Filter" style="margin-top:23%;" />
        </div>
        
     </fieldset>
	</form>
     </div>
      </div>
      </div>

<?php
include_once('connection.php');
if(isset($_SESSION['registered']) && $_SESSION['registered'] == 1)
{
	echo 'You are Successfully Registered' ;
	$_SESSION['registered'] = 0 ;
}
$sql_query = "SELECT * FROM advertisements WHERE `approve` = '1' " ;
$clause = " AND ( ";
$cat_add = "";
$area_add = "" ;
$tot_add = "";
$price_add = "" ;
$display_message = "" ;
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['category']))
	{
		$category = $_POST['category'];
		foreach($category as $temp)
		{
			if(!empty($temp))
			{
				$cat_add .= $clause."`"."category"."` = '{$temp}'";
                $clause = " OR ";//Change  to OR after 1st WHERE
			}
		}
	}
  
	if(!empty($cat_add))
	{
		$cat_add =  $cat_add . " )" ;
		$clause = " AND ( ";
	}
	if(isset($_POST['area']) && !empty($_POST['area']))
	{
		$temp = $_POST['area'] ;
		$area_add .= $clause."`"."area"."`"." = '{$temp}'" ;
		$area_add = $area_add." ) ";
		$clause = " AND ( " ;
	}
	if(isset($_POST['init_price']) && !empty($_POST['init_price']))
	{
		$price_initial = $_POST['init_price'];
	}
	else
	{
		$price_initial = "0";
	}
	if(isset($_POST['final_price']) && !empty($_POST['final_price']))
	{
		$price_final = $_POST['final_price'];
	}
	else
	{
		$price_final = "999999" ;
	}
	$price_add .= $clause."`price_initial`"." >= {$price_initial}"." AND "."`price_final`"." <= {$price_final} )";
	$tot_add = $cat_add.$area_add.$price_add ;		 
}
	$sql_query =  $sql_query." ".$tot_add." ORDER BY `adv_id` DESC";
	#echo $sql_query ;
	$insert_run = mysqli_query($conn , $sql_query);
	$i = 1 ;
	if($insert_run)
	{
		while($row = mysqli_fetch_assoc($insert_run))
		{ 
    
			$image_path = "user_uploads/".$row['image'];
			$adv_id = $row['adv_id'] ;
			//echo $image_path;

			echo '<br><div class="container" style="background-color:darkblue"  >
      <div clss="row" id="div'.$i.'" >
      <div class="col-md-7 col-md-offset-4 div" style="overflow:auto;padding:10px">
			<div class="col-md-4"><img src='.$image_path.' style="width:100%;"></div>
			<div class="col-md-8" style="overflow:auto;">
			<p style="text-align:center;" class = title><b>'.$row['title'].'</b></p>
			<p style="text-align:center;" class = price >'."Price: ".$row['price_initial'].'-'.$row['price_final'].'</p>
			<p style="text-align:center;" class = price>'."Location: ".$row['area'].'</p>
			<p style="text-align:center;">'."Phone Number: ".$row['phone'].'</p>
			<p style="text-align:center;">'."Address :".$row['address'].'</p>
			<p style="text-align:center;">'."Description: ".$row['description'].'</p>';

      

			if(loggedin() && $_SESSION['username'] != $row['username'] )
			{
				$username = $_SESSION['username'];
				$sql_q = "SELECT * FROM `negotiations` WHERE `adv_id` = '$adv_id' AND `interested_username` = '$username' " ;
				$result = mysqli_query($conn,$sql_q);
				if(mysqli_num_rows($result) == 1)
				{
					$neg_row = mysqli_fetch_assoc($result);
					$neg_id = $neg_row['neg_id'];
					echo'<p style="text:align:center; font-weight:bold; font-color:#FAB;">You have already shown an interest in this post.</p>';
					echo'<img src = "star.png" height= "20" width= "20" /> ';
					echo'<form action="delete_negotiations.php" method = "post">' ;
					echo'<input type="hidden" name="del_neg_id" value='.$neg_id.'>' ;
					echo'<input type="submit" value="Withdraw Interest">' ;
					echo'</form>';
				}
				else
				{
					echo'<p style="text:align:center;">Interested? Leave a message to the seller here</p>';
					echo'<form action="start_negotiations.php" method = "post">' ;
					echo'<input type="hidden" name="create_neg_adv_id" value='.$adv_id.'>' ;
					echo'<input type="hidden" name="create_neg_username" value='.$username.'>' ;
					echo'<textarea name = "message" placeholder="Leave a Message(50 characters)"></textarea>';
          echo '<br>';
					echo'<input type="submit" value="Create Interest">' ;
					echo'</form>';

				}
			}
			else
			{
				
			}
			echo' 
				     </div>
				  </div>
			</div> 
      </div> ';
      
			$i++;
		}

	}


?>

  


 
  
  
</div>

</div>

<br>
<br>


<!-- FOOTER starts ********************************************************* -->

<link href="https://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
<!--footer start from here-->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-6 footerleft ">
        <div class="logofooter"> Buying and Selling Portal</div>
        <p>This is an online selling and buying portal</p>
        <p><i class="fa fa-map-pin"></i> Bangalore</p>
        <p><i class="fa fa-phone"></i> Phone : +91 9672421899</p>
        <p><i class="fa fa-envelope"></i> E-mail : abcd@gmail.com</p>
        
      </div>
      
      </div>
      
    </div>
  </div>
</footer>
<!--footer start from here-->



  

</body>
</html>

