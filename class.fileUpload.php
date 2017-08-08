<?php
class FileUpload
{
	private $extensions = ["pdf", "doc", "docx", "jpg", "jpeg", "png", "gif", "zip", "rar", "xls", "xlsx"]; // allow extensions
	private $direction  = __DIR__."/"; // upload direction
	private $maxSize 	= 5 * 1024 * 1024; // max size 5 MB
	public function setExtensions($extension = array())
	{
		if(is_array($extension) && empty($extension))
		{
			$this->extensions = $extension;
		}
	}
	public function setDirection($dir = "")
	{
		if(is_string($dir) && trim($dir) != "")
		{
			$this->direction = trim($dir);
		}
	}
	public function setFileMaxSize($size = 0)
	{
		if((int)$size)
		{
			$this->maxSize = (int)$size;
		}
	}
	public function checkFileExist($file = [])
	{
		if(	isset($file['name']) 	 && is_string($file['name']) 	 && trim($file['name']) != '' 	  &&
			isset($file['size']) 	 && is_numeric($file['size']) 	 && (int)$file['size'] 		 	  &&
			isset($file['tmp_name']) && is_string($file['tmp_name']) && trim($file['tmp_name']) != '' &&
			isset($file['type']) 	 && is_string($file['type']) 	 && trim($file['type']) 		  &&
			isset($file['error']) 	 && is_numeric($file['error'])	 && (int)$file['error'] == 0 )
		{
			return true;
		}
		return false;
	}
	public function Upload($file = [])
	{
		if(!$this->checkFileExist($file))
		{
			return ['status' => 'error', 'errorMsg' => 'File is not exist!'];
		}
		else
		{
			$fileName = $file['name'];
			$fileSize = (int)$file['size'];
			$fileTmpName = $file['tmp_name'];
			$fileType = $file['type'];
			$fileError = (int)$file['error'];
			if($fileError)
			{
				return ['status' => 'error', 'errorMsg' => 'Error!'];
			}
			$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
			if(!in_array($fileExtension, $this->extensions))
			{
				return ['status' => 'error', 'errorMsg' => 'Unexpected extension!'];
			}
			if($fileSize > $this->maxSize)
			{
				return ['status' => 'error', 'errorMsg' => 'The storage of file is long!'];
			}
			$newFileName = "file".date('Y-m-d-H-d-i').uniqid().".".$fileExtension;
			if(move_uploaded_file($fileTmpName, $this->direction.$newFileName))
			{
				return ['status' => 'success', 'newFileName' => $newFileName, 'oldFileName' => $fileName];
			}
			else
			{
				return ['status' => 'error', 'errorMsg' => 'Try again!'];
			}
		}
		return ['status' => 'error', 'errorMsg' => 'Error!'];
	}
}