<?php
	require_once (realpath(dirname(__FILE__)).'/Classes/Input.php');
	require_once (realpath(dirname(__FILE__)).'/Classes/Validate.php');
	require_once (realpath(dirname(__FILE__)).'/Classes/Token.php');
	require_once (realpath(dirname(__FILE__)).'/Classes/Session.php');
	
	
	if(Input::exists()){
		if(Token::check(Input::get('token'))){
			$validate = new Validate();
			$validation=$validate->check($_POST,array(
				'username'=>array(
					'required'=>true,
					'min'=>2,
					'max'=>20,
					'unique'=>'Users'
				),

				'password'=>array(
					'required'=>true,
					'min'=>6,
					'max'=>64

				),

				'password_again'=>array(
					'required'=>true,
					'matches'=>'password'
				),

				'name'=>array(
					'required'=>true,
					'min'=>2,
					'max'=>50
				)

			));

			if($validate->passed()){
				$user =new User();
				$salt=Hash::salt(32);
				try{
					$user->create(array(
						'username'=>Input::get('username'),
						'password'=>Hash::make(Input::get('password')),
						'salt'=>$salt,
						'name'=>Input::get('name'),
						'joined'=>date('Y-m-d H:i:s'),
						'groupid'=>1
					));

					Session::flash('home','You have been registered and can now log in');
					Redirect::To(404);


				}catch(Exception $e){
					die($e->getMessage());
				}
				
			}
			else{
				print_r($validate->errors());
			}
		
		}

	}
?>

<form action="" method="POST">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="" autocomplete="off">
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" value="">
	</div>

	<div class="field">
		<label for="password_again">Confirm your password</label>
		<input type="password" name="password_again" id="password_again" value="">
	</div>

	<div class="field">
		<label for="name">Name</label>
		<input type="password" name="name" id="name" value="">
	</div>
	
	<input type="hidden" name="token" value="<?php echo Token::generate();?>">
	<input type="submit" value="Register!">

</form>