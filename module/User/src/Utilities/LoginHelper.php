<?php
namespace User\Utilities;

use Zend\Crypt\Password\Bcrypt;

class LoginHelper 
{
	public static function login($password, $securePass)
	 {   
	  $bcrypt = new Bcrypt();

	  if ($bcrypt->verify($password, $securePass)) 
	  {
	    return 1;
	  } else {
	    return 0;
	  }
	}
  
  public static function encrypt($password)
  {
  	$bcrypt = new Bcrypt();
  	return $bcrypt->create($password);
  }
}
?>