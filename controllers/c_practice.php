 <?php
//class practice_controller extends base_controller
//{
//public function test1()
//{
//require(APP_PATH.'/libraries/image1.php');
//$imageobj = new Image('http://placekitten.com/1000/1000');
//$imageobj->resize(200,200);
//$imageobj->display();
//}
//}


//public function test2()
//{
//Time::new()
//}
class practice_controller extends base_controller{
public function testdb()
{
$q = "Insert into users set first_name='somu',last_name='thiyagu'";
echo $q;
DB::INSTANCE(DB_NAME)->query($q);
//$data = Array(
    'first_name' => 'Sam', 
    'last_name' => 'Seaborn', 
    'email' => 'seaborn@whitehouse.gov');

/*
Insert requires 2 params
1) The table to insert to
2) An array of data to enter where key = field name and value = field data

The insert method returns the id of the row that was created
*/
//$user_id = DB::instance(DB_NAME)->insert('users', $data);

//echo 'Inserted a new row; resulting id:'.$user_id;
}




	
	
	




 
   



  
 






