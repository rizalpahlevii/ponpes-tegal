<?php
	function start_transaction()
	{
		mysqli_query("START TRANSACTION");
	}

	function commit()
	{
		mysqli_query("COMMIT");
	}

	function rollback()
	{
		mysqli_query("ROLLBACK");
	}


?>