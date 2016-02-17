<?php
	include ('generator.php');
	include ('arrays_only.php');
	include ('ranges.php');

	$res = new ArrayGen (false, 2, 16);

	echo "<hr/><b>Solution using arrays only</b><br/><hr/><br/>";

	// start script execution timer
	$time_start = microtime (true);

	$sol1 = new ArraySol ($res->getArrays ());
	$sol1->compareAndMerge ();

	// Display Script End time
	$time_end = microtime (true);

	//dividing with 60 will give the execution time in seconds
	$execution_time = ($time_end - $time_start) * 1000;

	//execution time of the script
	echo "<hr/><b>Total Execution Time:</b> $execution_time ms";
	echo "<br/><b>Total Memory Usage:</b> " . memory_get_peak_usage () . ' bytes';
	echo "<br/><hr/>";

	echo "<br/><br/><br/><br/><br/><br/><hr/><b>Solution using ranges</b><br/><hr/><br/>";

	// start script execution timer
	$time_start = microtime (true);

	$sol2 = new ArrayRange ($res->getArrays ());
	$sol2->compareAndMerge ();

	// Display Script End time
	$time_end = microtime (true);

	//dividing with 60 will give the execution time in seconds
	$execution_time = ($time_end - $time_start) * 1000;

	//execution time of the script
	echo "<hr/><b>Total Execution Time:</b> $execution_time ms";
	echo "<br/><b>Total Memory Usage:</b> " . memory_get_peak_usage () . ' bytes';
	echo "<br/><hr/>";