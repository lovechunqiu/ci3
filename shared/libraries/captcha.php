<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha {
	var $pool       = '23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
    var $img_width  = 100;
    var $img_height = 30;

    public function create($length, $pool = '') {
		if(empty($pool)) {
			$pool = $this->pool;
		}
		if ( ! extension_loaded('gd')) {
			return FALSE;
		}

        $font_path  = dirname(__FILE__) . '/ttfs/t' . mt_rand(1, 10) . '.ttf';
        $word = '';
        for ($i = 0; $i < $length; $i++) {
            $word .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
        }

		// -----------------------------------
		// Determine angle and position
		// -----------------------------------

		$angle	= ($length >= 6) ? rand(-($length-6), ($length-6)) : 0;
		$x_axis	= rand(6, (360/$length)-16);
		$y_axis = ($angle >= 0 ) ? rand($this->img_height, $this->img_width) : rand(6, $this->img_height);

		// -----------------------------------
		// Create image
		// -----------------------------------

		// PHP.net recommends imagecreatetruecolor(), but it isn't always available
		if (function_exists('imagecreatetruecolor')) {
			$im = imagecreatetruecolor($this->img_width, $this->img_height);
		} else {
			$im = imagecreate($this->img_width, $this->img_height);
		}

		// -----------------------------------
		//  Assign colors
		// -----------------------------------

		$bg_color		= imagecolorallocate($im, 255, 255, 255);
		$border_color	= imagecolorallocate($im, 153, 102, 102);
		$text_color		= imagecolorallocate($im, 204, 153, 153);
		$grid_color		= imagecolorallocate($im, 255, 182, 182);
		$shadow_color	= imagecolorallocate($im, 255, 240, 240);

		// -----------------------------------
		//  Create the rectangle
		// -----------------------------------

		ImageFilledRectangle($im, 0, 0, $this->img_width, $this->img_height, $bg_color);

		// -----------------------------------
		//  Create the spiral pattern
		// -----------------------------------

		$theta		= 1;
		$thetac		= 7;
		$radius		= 16;
		$circles	= 20;
		$points		= 32;

		for ($i = 0; $i < ($circles * $points) - 1; $i++)
		{
			$theta = $theta + $thetac;
			$rad = $radius * ($i / $points );
			$x = ($rad * cos($theta)) + $x_axis;
			$y = ($rad * sin($theta)) + $y_axis;
			$theta = $theta + $thetac;
			$rad1 = $radius * (($i + 1) / $points);
			$x1 = ($rad1 * cos($theta)) + $x_axis;
			$y1 = ($rad1 * sin($theta )) + $y_axis;
			imageline($im, $x, $y, $x1, $y1, $grid_color);
			$theta = $theta - $thetac;
		}

		// -----------------------------------
		//  Write the text
		// -----------------------------------

		$use_font = ($font_path != '' AND file_exists($font_path) AND function_exists('imagettftext')) ? TRUE : FALSE;

		if ($use_font == FALSE) {
			$font_size = 5;
			$x = rand(0, $this->img_width/($length/3));
			$y = 0;
		} else {
			$font_size	= 18;
			$x = rand(0, $this->img_width/($length/1.5));
			$y = $font_size+2;
		}

		for ($i = 0; $i < strlen($word); $i++) {
			if ($use_font == FALSE) {
				$y = rand(0 , $this->img_height/2);
				imagestring($im, $font_size, $x, $y, substr($word, $i, 1), $text_color);
				$x += ($font_size*2);
			} else {
				$y = rand($this->img_height/2, $this->img_height-3);
				imagettftext($im, $font_size, $angle, $x, $y, $text_color, $font_path, substr($word, $i, 1));
				$x += $font_size;
			}
		}


		// -----------------------------------
		//  Create the border
		// -----------------------------------

		imagerectangle($im, 0, 0, $this->img_width-1, $this->img_height-1, $border_color);

		// -----------------------------------
		//  Generate the image
		// -----------------------------------
        header('Pragma: no-cache');
        header("content-type: image/JPEG");

		ImageJPEG($im);

		ImageDestroy($im);

        return $word;

	}
}

/* End of file Captcha.php */
/* Location: ./application/libraries/Captcha.php */
