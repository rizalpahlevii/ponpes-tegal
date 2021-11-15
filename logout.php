<?php
session_start();
if(session_destroy()) // Menghapus Sessions
{
	header("location:index2.php"); // Langsung mengarah ke Home index.php
}
?>