<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * oauth2.0认证
 * @author lideqiang87@gmail.com
 * @since 2016-09-06 16:26:19
 * @version 1.0.0
 */
class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	/**
	 * session 认证
	 * @author lideqiang87@gmail.com
	 * @date   2016-09-06
	 * @return [type]     [description]
	 */
	public function session($provider){

        $this->load->library('oauth2');
        $provider = $this->oauth2->provider(
        	$provider, 
        	array(
            	'id'     => '400302477',
            	'secret' => 'kjsdfhsdkjfhsk',
        ));
        exit('调试中……');
        if( ! $this->input->get('code')){
            $provider->authorize();
        }else{
            try{
                $token = $provider->access($_GET['code']);

                $user = $provider->get_user_info($token);

                // Here you should use this information to A) look for a user B) help a new user sign up with existing data.
                // If you store it all in a cookie and redirect to a registration page this is crazy-simple.
                echo "<pre>Tokens: ";
                var_dump($token);

                echo "\n\nUser Info: ";
                var_dump($user);
            }catch (OAuth2_Exception $e){
                show_error('That didnt work: '.$e);
            }
        }
	}




}


/* End of file Auth.php */
/* Location: ../api/controllers/Auth.php */