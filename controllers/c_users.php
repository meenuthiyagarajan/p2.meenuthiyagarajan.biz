<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        //echo "users_controller construct called<br><br>";
    } 

    public function index() {
        echo "This is the index page";
    }

    //public function signup() {
      //  echo "This is the signup page";
    //}
	public function signup() {

        # Setup view
            $this->template->content = View::instance('v_users_signup');
            $this->template->title   = "Sign Up";

        # Render template
            echo $this->template;
			}
			#Helper function to validate field empty
			
		private function field() {
		# Setup view
            $this->template->content = View::instance('v_users_signup');
            $this->template->title   = "Sign Up";

        # Render template
            echo $this->template;
		
		if(trim($_POST['first_name'])==false){
		echo "Fill in Firstname";
		return false;}
		elseif(trim($_POST['last_name'])==false){
		echo"Fill in Lastname";
		return false;}
		elseif(trim($_POST['password'])==false){
		echo"Fill in the password";
		return false;}
		 else{
		return true;
		}
		}
			
		
		

    

    public function p_signup() {
	
		

        # Dump out the results of POST to see what the form submitted
        echo '<pre>';
        print_r($_POST);
	   	 $user_id = DB::instance(DB_NAME)->insert('users', $_POST);
       # More data we want stored with the user
    $_POST['created']  = Time::now();
    $_POST['modified'] = Time::now();

    # Insert this user into the database
    $user_id = DB::instance(DB_NAME)->insert('users', $_POST);

    # For now, just confirm they've signed up - 
    # You should eventually make a proper View for this
	# More data we want stored with the user
    $_POST['created']  = Time::now();
    $_POST['modified'] = Time::now();

    # Encrypt the password  
    $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

    # Create an encrypted token via their email address and a random string
    $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string()); 

    # Insert this user into the database 
    $user_id = DB::instance(DB_NAME)->insert("users", $_POST);
	
    # For now, just confirm they've signed up - 
    # You should eventually make a proper View for this
    echo 'You\'re signed up';
    echo '</pre>';          
    }
	
		
		



	/*public function p_signup() {
	$this->template->content=view::Instance('v_users_signup');
	echo $this->template;
	echo "<pre>";
	print_r($_POST);
	echo "<pre>";
	DB::INSTANCE(DB_NAME)->insert_row('users',$_POST);
	}*/    
	 public function login($error = NULL) {

    # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title   = "Login";
		$this->template->content->error = $error;

    # Render template
        echo $this->template;

        
    }
	/* public function p_login($error = NULL) {

    # Set up the view
    $this->template->content = View::instance("v_users_login");

    # Pass data to the view
    $this->template->content->error = $error;

    # Render the view
    echo $this->template;

}*/
	public function p_login() {

    # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
    $_POST = DB::instance(DB_NAME)->sanitize($_POST);

    # Hash submitted password so we can compare it against one in the db
    $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

    # Search the db for this email and password
    # Retrieve the token if it's available
    $q = "SELECT token 
        FROM users 
        WHERE email = '".$_POST['email']."' 
        AND password = '".$_POST['password']."'";

    $token = DB::instance(DB_NAME)->select_field($q);

    # If we didn't find a matching token in the database, it means login failed
    if(!$token) {

        # Send them back to the login page
        Router::redirect("/users/login/error");

    # But if we did, login succeeded! 
    } else {

        /* 
        Store this token in a cookie using setcookie()
        Important Note: *Nothing* else can echo to the page before setcookie is called
        Not even one single white space.
        param 1 = name of the cookie
        param 2 = the value of the cookie
        param 3 = when to expire
        param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
        */
        setcookie("token", $token, strtotime('+2 weeks'), '/');

        # Send them to the main page - or whever you want them to go
        Router::redirect("/");

    }

}



    public function logout() {

    # Generate and save a new token for next login
    $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

    # Create the data array we'll use with the update method
    # In this case, we're only updating one field, so our array only has one entry
    $data = Array("token" => $new_token);

    # Do the update
    DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

    # Delete their token cookie by setting it to a date in the past - effectively logging them out
    setcookie("token", "", strtotime('-1 year'), '/');

    # Send them back to the main index.
    Router::redirect("/");

}


    public function p_profile() {

    # If user is blank, they're not logged in; redirect them to the login page
    if(!$this->user) {
        Router::redirect('/users/login');
    }

    # If they weren't redirected away, continue:

    # Setup view
    $this->template->content = View::instance('v_users_profile');
    $this->template->title   = "Profile of".$this->user->first_name;

    # Render template
    echo $this->template;
	}

 public function p_profile_edit() {
if ($_FILES["file"]["error"] > 0)
   {
   echo "Error: " . $_FILES["file"]["error"] . "<br>";
   }
 else
   {
   echo "Upload: " . $_FILES["file"]["name"] . "<br>";
   echo "Type: " . $_FILES["file"]["type"] . "<br>";
   echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
   echo "Stored in: " . $_FILES["file"]["tmp_name"];
   }
   $allowedExts = array("gif", "jpeg", "jpg", "png");
 $temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
 if ((($_FILES["file"]["type"] == "image/gif")
 || ($_FILES["file"]["type"] == "image/jpeg")
 || ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
 || ($_FILES["file"]["type"] == "image/png"))
 && ($_FILES["file"]["size"] < 20000)
 && in_array($extension, $allowedExts))
   {
   if ($_FILES["file"]["error"] > 0)
     {
     echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
     }
   else
     {
     echo "Upload: " . $_FILES["file"]["name"] . "<br>";
     echo "Type: " . $_FILES["file"]["type"] . "<br>";
     echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
     echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

     if (file_exists("upload/" . $_FILES["file"]["name"]))
       {
       echo $_FILES["file"]["name"] . " already exists. ";
       }
     else
       {
       move_uploaded_file($_FILES["file"]["tmp_name"],
       "upload/" . $_FILES["file"]["name"]);
       echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
       }
     }
   }
 else
   {
   echo "Invalid file";
   }
   }
   public function email() {
    # Setup view
            $this->template->content = View::instance('v_users_email');
            $this->template->title   = "Email";

        # Render template
            echo $this->template;
			}
	public function p_email() {
	if (isset($_REQUEST['email']))
 //if "email" is filled out, send email
   {
   //send email
   $email = $_REQUEST['email'] ;
   $subject = $_REQUEST['subject'] ;
   $message = $_REQUEST['message'] ;
      ini_set("SMTP","mail.example.com");  
   echo "Thank you for using our mail form";
   }
    
 else
 { echo "<form method='post' action='/users/p_email'>
   Email: <input name='email' type='text'><br>
   Subject: <input name='subject' type='text'><br>
   Message:<br>
   <textarea name='message' rows='15' cols='40'>
   </textarea><br>
   <input type='submit'>
   </form>";
 }
   
   
    //public function p_profile($user_name = NULL) {
	//$template=view::Instance('_v_template');

    /*
    If you look at _v_template you'll see it prints a $content variable in the <body>
    Knowing that, let's pass our v_users_profile.php view fragment to $content so 
    it's printed in the <body>
    */
    //$this->template->content = View::instance('v_users_profile');

     //$title is another variable used in _v_template to set the <title> of the page
	
    //$this->template->title = "Profile";

    # Pass information to the view fragment
    //$this->template->content->user_name = $user_name;
	//$template=view::Instance('_v_template');

    # Render View
    //echo $this->template;

//}




//

	  //    if($user_name == NULL) {
    //        echo "No user specified";
      //  }
       // else {
       //    echo "This is the profile for ".$user_name;
       // }
    
	
}


}