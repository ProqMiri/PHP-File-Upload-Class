<?php
// First we include the class.fileUpload.php
require "class.fileUpload.php";

// then create an object
$fileUpload = new FileUpload();

// follow code we set extension for upload file. Default extensions are pdf, doc, docx, jpg, jpeg, png, gif, zip, rar, xls, xlsx
$fileUpload -> setExtensions(["jpg", "jpeg", "png"]);

// follow code we set directory for upload file. 
$fileUpload -> setDirection('images/');

// follow code we set max size for upload file. Default 5 MB 
$fileUpload -> setFileMaxSize(2 * 1024 * 1024);

// Finaly we upload our file ... Upload() function return an array. If file uploaded an array consist ["status"=>"success","newFileName"=>"newFile.extension","oldFileName"=>"oldFile.extension" ]; . If file did not upload an array consist ["status"=>"error","errorMsg"=>"Error Message"];
$fileUpload -> Upload($_FILES['fileName']);
?>