<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<!-- Common CSS/JSS -->
   // <link rel="stylesheet" href="/css/app.css" type="text/css">
	//<link $client_files_head=Array('/css/profile.css',$this->template->client_files_head=<link> '/css/master.css');
	
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    		
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>	

	<?php if(isset($content)) echo $content; ?>
	<?php if(isset($user_name)): ?>
    <h1>This is the profile for <?=$user_name?></h1>
<?php else: ?>
    <h1>No user specified</h1>
<?php endif; ?>


	<?php if(isset($client_files_body)) echo $client_files_body; ?>
</body>
</html>