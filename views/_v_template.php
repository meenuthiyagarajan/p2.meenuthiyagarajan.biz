<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<!-- Common CSS/JSS -->
    
	
	
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    		
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>	

	    <div id='menu'>

        <a href='/'>Home</a><br>

        <!-- Menu for users who are logged in -->
        <?php if($user): ?>
           <a href='/posts/add'> Add post </a><br>
		   <a href='/posts/p_add'> View post</a><br>
		    <a href='/posts/users'> Follow users</a><br>
            <a href='/users/logout'>Logout</a><br>
            <a href='/users/p_profile'>Profile</a><br>

        <!-- Menu options for users who are not logged in -->
        <?php else: ?>

            <a href='/users/signup'>Sign up</a>
            <a href='/users/login'>Log in</a>

        
		<a href='/users/posts/p_add'> Add post </a><br>
		<a href='/users/posts/index'> View post</a><br>
		<a href='/users/posts/users'> Follow users</a><br>
		<?php endif ?>

    

    <?php if(isset($error)): ?>
        <div class='error'>
            Login failed. Please double check your email and password.
        </div>
        <br>
    <?php endif; ?>

    

</form>


    <?php if(isset($content)) echo $content; ?>

</body>


</html>