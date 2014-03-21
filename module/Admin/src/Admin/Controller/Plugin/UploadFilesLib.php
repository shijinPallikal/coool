<?php
namespace Admin\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class UploadFilesLib extends AbstractPlugin{
  
   private $name	=	"";
   private $max_size	=	"";
   private $files	=	"";
   private $tmp_name	=	"";
   private $size	=	"";
   private $filename	=	"";
   private $error	=	"";
   private $des		=	"";
   private $upfile	=	"";
		
    function  __construct($max_size = 5, $files=""){
        $this->set_max_size($max_size);
        $this->set_files($files);
    }
    
    public function  set_name($name){
        $this->name	=	$name;
    }
    
    public function set_max_size($size_mb=5){
        if($this->size	<=	0)	$this->size	=	5;//size in MB
        $this->max_size	=	$this->size * (1024 * 1024);
    }
    
    public function set_files($files){
        $this->files	=	$files;
    }
    
    private function  set_error($err){
        $this->error	=	$err;
    }
    
    public function  get_status(){
            if(!$this->error) return false;
            else return $this->error;
    }
            
    public function copyFile($filename, $des, $filetype="1", $name=""){ 
   // print_r($filename);exit;       
            //fileteype=1 for same file name,fileteype=2 for random file name
            $opath	=	$des;
            $path	=	$des;
            $this->set_error("");
            if(!$filename)	$this->set_error("Not a valid Filename");
            $this->name		=	$filename;
            $this->tmp_name	=	$_FILES[$filename]["tmp_name"];
            $this->size		=	$_FILES[$filename]["size"];
            $this->filename	=	$_FILES[$filename]["name"];
            $ext			=	pathinfo($this->filename);
            $ext			=	strtolower($ext["extension"]);

 //echo $this->tmp_name; 
            if($this->size > $this->max_size){       echo 0;exit;  $this->set_error("File size is too large!"); }
            $flag			=	1;
            if($this->files)
                    {
                            $arr_ext	=	array();
                            $arr_ext	=	explode(",",$this->files);
                            $flag		=	0;
                            foreach ($arr_ext	as $val)	if(strtolower($val)	==	$ext)	$flag	=	1;
                    }
            if($flag	!=	1)	$this->set_error("File Format is Invalid");
            if(!$this->error)
                    {
                            if($name)
                                    {
                                            $des	.=	"/".$name;
                                    }
                            else
                                    {
                                            if($filetype	==	"1") $des	.=	"/".$this->name;
                                            if($filetype	==	"2")
                                                    {
                                                            $tmpfname = tempnam("$opath/","");
                                                            rename($tmpfname,$tmpfname.".".$ext);
                                                            $temp	=	explode("/",$tmpfname);
                                                            $temp	=	end($temp);
                                                            $des	.=	"/".$temp.".".$ext;
                                                    }
                                    }
                                //echo $this->tmp_name ;exit;
                            if(copy($this->tmp_name,$des))
                                    {  //echo $this->tmp_name.'>'.$des;exit;
                                            chmod("$des", 0755);
                                            $this->set_error("Copied Successfully");
                                            $temp		=	explode("/",$des);
                                            $this->des		=	$des;	
                                            $this->upfile	=	end($temp);                                            
                                            return end($temp);				
                                    }
                            else 
                                    {
                                            $this->set_error("Cannot Copy the file");
                                            return "0";	
                                    }
                    }	                    
        }
   
    public function copyFileArray($filename, $index, $des, $filetype = "1", $name = "", $resize = array()){
            //fileteype=1 for same file name,fileteype=2 for random file name
            $opath	=	$des;
            $path	=	$des;
            $this->set_error("");
            if(!$filename)	$this->set_error("Not a valid Filename");
            $this->name		=	$filename;
            $this->tmp_name	=	$_FILES[$filename]["tmp_name"][$index];
            $this->size		=	$_FILES[$filename]["size"][$index];
            $this->filename	=	$_FILES[$filename]["name"][$index];
            $ext			=	pathinfo($this->filename);
            $ext			=	strtolower($ext["extension"]);

            if($this->size > $this->max_size)		$this->set_error("File size is too large!");
            $flag			=	1;
            if($this->files)
                    {
                            $arr_ext	=	array();
                            $arr_ext	=	explode(",",$this->files);
                            $flag		=	0;
                            foreach ($arr_ext	as $val)	if(strtolower($val)	==	$ext)	$flag	=	1;
                    }
            if($flag	!=	1)	$this->set_error("File Format is Invalid");
            if(!$this->error)
                    {
                            if($name)
                                    {
                                            $des	.=	"/".$name;
                                    }
                            else
                                    {
                                            if($filetype	==	"1") $des	.=	"/".$this->name;
                                            if($filetype	==	"2")
                                                    {
                                                            $tmpfname = tempnam("$opath/","");
                                                            rename($tmpfname,$tmpfname.".".$ext);
                                                            $temp	=	explode("/",$tmpfname);
                                                            $temp	=	end($temp);
                                                            $des	.=	"/".$temp.".".$ext;
                                                    }
                                    }
                            if(copy($this->tmp_name, $des))
                                    {
                                            chmod("$des", 0755);
                                            $this->set_error("Copied Successfully");
                                            $temp		=	explode("/",$des);
                                            $this->des		=	$des;	
                                            $this->upfile	=	end($temp);

                                            if(!empty($resize)){
                                                $this->imgResize($resize['width'], $resize['height'], $resize['des']);
                                            }

                                            return end($temp);				
                                    }
                            else 
                                    {
                                            $this->set_error("Cannot Copy the file");
                                            return "0";	
                                    }
                    }					
    }         
                   
    public function imgResize($widthtmp, $heighttemp, $des = "", $del = "0")
            {
                    $src	=	$this->des;
//                    if($des	==	"")	$des	=	$this->des;
//                    else			$des	.=	"/".$this->upfile;	

                    $filename 	= 	$src;
                    $dest_file 	= 	$des;
                    $fnamerev	=	strrev($filename);
                    $expfname	=	explode(".",$fnamerev);///for extension 
                    $expfname1	=	$expfname[0];
                    $filetype	=	strrev($expfname1);
                    $ftype 		=	$filetype;
                    $percent 	= 	0.5;

                    $a			=	getimagesize($filename);// Get new sizes
                    $old_w		=	$a[0];
                    $old_h		=	$a[1];
                    $new_w		=	$a[0];
                    $new_h		=	$a[1];

                    if($old_w	>	$widthtmp)
                            {
                                    $new_w	=	$widthtmp; 
                                    $x		=	round(($new_w*100)/$old_w);
                                    $new_h	=	round($old_h*($x/100));
                                    $old_h	=	$new_h;
                            }	
                    if($old_h	>	$heighttemp)
                            {		
                                    $new_h	=	$heighttemp;
                                    $x		=	round(($new_h*100)/$old_h);
                                    $new_w	=	round($new_w*($x/100)); 
                            }
                    list($width, $height) = getimagesize($filename);

                    if(($a[0]>$widthtmp) or ($a[1]>$heighttemp))	$thumb 		= imagecreatetruecolor($new_w, $new_h);
                    else											$thumb 		= imagecreatetruecolor($old_w, $old_h);

                    if(strtolower($ftype)	==	'jpeg') $ftype="jpg";
                    if(strtolower($ftype)	==	'bmp' )	$ftype="wbmp";

                    if(strtolower($ftype)	==	'jpg' )	$source 	= imagecreatefromjpeg($filename);
                    if(strtolower($ftype)	==	'gif' )	$source 	= imagecreatefromgif($filename);
                    if(strtolower($ftype)	==	'png' )	$source 	= imagecreatefrompng($filename);
                    if(strtolower($ftype)	==	'wbmp')	$source 	= imagecreatefromwbmp($filename);

                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_w, $new_h, $width, $height);// Resize

                    if(strtolower($ftype)=='jpg')	imagejpeg($thumb, $dest_file,99); 
                    if(strtolower($ftype)=='gif')	imagegif($thumb, $dest_file); 
                    if(strtolower($ftype)=='png')	imagepng($thumb, $dest_file); 
                    if(strtolower($ftype)=='wbmp')	imagewbmp($thumb, $dest_file); 

                    if ($del	<>	"0")	unlink($this->des);
            }

            public function getRandFileNa($fileName){
                $ext = explode('.', $fileName);
                $fileNa  = microtime(); 
                $fileNa  = trim(str_replace('.', '', $fileNa));
                $fileNa .= ".".$ext[count($ext)-1];
                return $fileNa;                								
            }
            
        public function test(){
            echo 'test my site';
        }    
       
    
}

