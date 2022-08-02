<?PHP
class img_opt
{
var $max_width;
var $max_height;
var $path;
var $img;
var $new_width;
var $new_height;
var $mime;
var $image;
var $width;
var $height;
	function max_width($width)
	{
		$this->max_width = $width;
	}
	function max_height($height)
	{
		$this->max_height = $height;
	}
	function image_path($path, $name, $pref)
	{
		$this->path = $path.$name;
		$this->patht = $path.$pref.$name;
	}
	function get_mime()
	{
		$img_data = getimagesize($this->path);
		$this->mime = $img_data['mime'];
	}
	function create_image()
	{
		switch($this->mime)
		{
			case 'image/jpeg': $this->image = imagecreatefromjpeg($this->path);
			break;			
			case 'image/gif': $this->image = imagecreatefromgif($this->path);
			break;			
			case 'image/png': $this->image = imagecreatefrompng($this->path);
			break;
		}
	}	
	function image_resize()
		{
				set_time_limit(120);
				$this->get_mime();
				$this->create_image();
				$this->width = imagesx($this->image);
				$this->height = imagesy($this->image);
				$this->set_dimension();
				$image_resized = imagecreatetruecolor($this->new_width,$this->new_height);
				imagecopyresampled($image_resized, $this->image, 0, 0, 0, 0, $this->new_width, $this->new_height,$this->width, $this->height);
				imagejpeg($image_resized,$this->patht,90);				
		}
		//######### FUNCTION FOR RESETTING DEMENSIONS OF IMAGE ###########
		function set_dimension()
		{				
				if($this->width==$this->height)
					$case = 'first';
				elseif($this->width > $this->height)
					$case = 'second';
				else
					 $case = 'third'; 
				
				if($this->width>$this->max_width && $this->height>$this->max_height)
					$cond = 'first';
				elseif($this->width>$this->max_width && $this->height<=$this->max_height)
					$cond = 'first';
				else
					$cond = 'third';
			
				switch($case)
				{
					case 'first':
						$this->new_width = $this->max_width;
						$this->new_height = $this->max_height;
					break;
					case 'second':
						$ratio = $this->width/$this->height;
						$amount = $this->width - $this->max_width;
						$this->new_width = $this->width - $amount;
						$this->new_height = $this->height - ($amount/$ratio);
					break;
					case 'third':
						$ratio = $this->height/$this->width;
						$amount = $this->height - $this->max_height;
						$this->new_height = $this->height - $amount;
						$this->new_width = $this->width - ($amount/$ratio);
					break;
				} 					
		}
}
?>