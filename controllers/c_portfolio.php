<?php
class portfolio_controller extends base_controller {
    public function view($project_id) {         
        # Code here to grab the project from the database using the $project_id
		parent::view($project_id);
		echo"portfolio_controller construct called <br><br>";
    } 
	public function pf()
	{
	echo"This is an portfolio page";
}
?>
