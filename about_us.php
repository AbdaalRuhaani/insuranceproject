<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	include_once("includes/form_functions.php");
	if(isset($_SESSION['cust_id'])) {
		redirect_to('cust/home.php');
	}
	// START FORM PROCESSING
	if (isset($_POST['Submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('cu_id', 'passwd');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('cu_id' => 30, 'passwd' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$username = trim(mysql_prep($_POST['cu_id']));
		$password = trim(mysql_prep($_POST['passwd']));
		$hashed_password=sha1($password);

		
		if ( empty($errors) ) {
			// Check database to see if username and the hashed password exist there.
			$query = "SELECT cust_id, name ";
			$query .= "FROM customer ";
			$query .= "WHERE cust_id = '{$username}' ";
			$query .= "AND hashed_password = '{$hashed_password}' ";
			$query .= "LIMIT 1";
			$result_set = mysql_query($query);
			confirm_query($result_set);
			if (mysql_num_rows($result_set) == 1) {
				// username/password authenticated
				// and only 1 match
				$found_user = mysql_fetch_array($result_set);
				$_SESSION['cust_id'] = $found_user['cust_id'];
				$_SESSION['name'] = $found_user['name'];
				redirect_to("cust/home.php");
			} else {
				// username/password combo was not found in the database
				$message = "Username/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
		
	} else { // Form has not been submitted.
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			//$message = "You are now logged out.";
		} 
		$username = "";
		$password = "";
	}
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="your description goes here" />
<meta name="keywords" content="your,keywords,goes,here" />

<link rel="stylesheet" type="text/css" href="variant.css" media="screen,projection" title="Variant Portal" />


<title>About Us</title>
</head>

<body>


<div id="container">

<div id="toplinks">
<p><a href="#">Link 1</a> &middot; <a href="#">Link 2</a> &middot; <a href="#">Link 3</a> &middot; <a href="#">Link 4</a></p>
</div>

<div id="logo">
<h1><a href="../index.php">Insurance Corp</a></h1>
<p>A trustworthy investment...</p>

</div>


<h2 class="hide">Site menu:</h2>
<ul id="navitab">
<li><a  href="cust.php">Home</a></li>
<li><a class="current" href="about_us.php">About Us</a></li>
<li><a href="products.php">Policies</a></li>
<li><a href="contact_us.php">Contacts</a></li>
<li><a href="downloads.php">Downloads</a></li>
<li><a href="#">News</a></li>

</ul>




<div id="desc">

<div class="splitleft">

<p>
In law and economics, insurance is a form of risk management primarily used to hedge against the risk of a contingent, uncertain loss. Insurance is defined as the equitable transfer of the risk of a loss, from one entity to another, in exchange for payment. An insurer is a company selling the insurance; an insured or policyholder is the person or entity buying the insurance policy. The insurance rate is a factor used to determine the amount to be charged for a certain amount of insurance coverage, called the premium. Risk management, the practice of appraising and controlling risk, has evolved as a discrete field of study and practice.

</p>
<p class="right"></p>
</div>

<div class="splitright">
<h2>Sample links:</h2>
<ul>
<li><a href="http://google.com">Google Profile</a></li>
<li><a href="http://facebook.com">Facebook page</a></li>
<li><a href="http://twitter.com/">Twitter Page</a></li>
</ul>
<p class="right"><a href="#">Read more &raquo;</a></p>
</div>
<hr />
</div>

<div id="main">

	
	
	<h2>Introducing Ourselves</h2>
  	

    <p><strong>* UI is a leading General Insurance Company. </br>
    </strong></p>
    <p><strong>* More than three decades of experience in Non-life Insurance business. </br>
    </strong></p>
    <p><strong>* Formed by the merger of 22 companies, consequent to nationalisation of General Insurance. </br>
    </strong></p>
    <p><strong>* Head Quarters at Chennai. </br>
    </strong> </p>
<h2>&nbsp;</h2>
  	<h2>Corporate Mission</h2>
  	
<p class="right">
    <p><strong>* To provide Insurance protection to all. </br>
    </strong></p>
    <p><strong>* To ensure customer satisfaction </br>
    </strong></p>
    <p><strong>* To function on sound business principles </br>
    </strong></p>
    <p><strong>* To help minimise national waste and to help develop the Indian economy. </br>
 </p>     
      
    </strong></p>
    <h2>&nbsp;</h2>
</div>

<?php require_once("sidebar_user.php"); ?>

<?php require_once("footer.php"); ?>


</body>
</html>

