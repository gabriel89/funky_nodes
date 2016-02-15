<?php
	global $min, $max;

	// start script execution timer
	$time_start = microtime (true);

	// use random vector elements over the hard-coded ones from the assignment?
	$random = false;

	// set vector-length interval
	$min = 2;
	$max = 16;

	/**
	* Generates elements for the array randomly
	*
	* @param *
	*
	* @return $ret_array - array - contains the elements of the array
	*
	* @author Gabriel Barina <barinagabriel2007@yahoo.com>
	*/
	function generateVector2 () {
		global $min, $max;

		$array_length 	= rand ($min, $max);
		$ret_array 		= array();

		// generate unique prefixes for the node-id's
		for ($i = 0; $i < $array_length; $i ++)
			array_push ($ret_array, substr (str_shuffle (str_repeat ('abcdefghijklmnopqrstuvwxyz', 1)), 0, 1));

		// sort the prefixes alphabetically
		sort ($ret_array);

		// append integer value to the prefixes
		$last_prefix = '';
		$last_value  = 0;
		foreach ($ret_array as $key => $value) {
			// reset flags
			if ($last_prefix != $value) {
				$last_prefix = $value;
				$last_value	 = 0;
			}

			$int_val = rand (0, 255);
			$int_val = ($int_val > $last_value) ? $int_val : $last_value + 1;

			$ret_array[$key] = $value . '/' . $int_val;
			$last_value 	 = $int_val;
		}
		
		return $ret_array;
	}

	/**
	* Reformats the two arrays in order to better compare each values and merges them
	*
	* @param $v1 - array - contains the elements of the first array
	* @param $v2 - array - contains the elements of the second array
	*
	* @return *
	*
	* @author Gabriel Barina <barinagabriel2007@yahoo.com>
	*/
	function compareAndMerge2 ($v1, $v2) {
		printVector ('v1', $v1);
		printVector ('v2', $v2);

		$v1 = separateElements ($v1);
		$v2 = separateElements ($v2);
		$v3 = (count ($v2) > count ($v1)) ? compareElements ($v1, $v2) : compareElements ($v2, $v1);
		$v3 = regroupElements ($v3);

		printVector('v3', $v3);
	}

	/**
	* Prints out the individual elements of the array using a custom format
	*
	* @param $name - string - contains the name of the array
	* @param $elements - array - contains the elements of the array
	*
	* @return *
	*
	* @author Gabriel Barina <barinagabriel2007@yahoo.com>
	*/
	function printVector2 ($name, $elements) {
		echo $name . ' = { ' . implode(', ', $elements) . " }<br/><br/>";
	}

	/**
	* Separates each of the array's elements into two separate groups: the alphabetical prefix and the value
	*
	* @param $elements - array - contains the elements of the array
	*
	* @return $unique_ids - array - contains the elements of the array grouped into distinct groups
	*
	* @author Gabriel Barina <barinagabriel2007@yahoo.com>
	*/
	function separateElements2 ($elements) {
		$grouped_array = array();

		foreach ($elements as $key => $value) {
			$partials = explode('/', $value);

			if (!array_key_exists ($partials[0], $grouped_array)) {
				$grouped_array[$partials[0]] = array();
			}

			array_push ($grouped_array[$partials[0]], $partials[1]);
		}

		return $grouped_array;
	}

	/**
	* Separates each of the array's keys and values and creates a union of these 
	*
	* @param $v1 - array - contains the elements of the first (shortest) array
	* @param $v2 - array - contains the elements of the second array
	*
	* @return $v2 - array - contains the union of the first and second array's elements
	*
	* @author Gabriel Barina <barinagabriel2007@yahoo.com>
	*/
	function compareElements2 ($v1, $v2) {
		// cycle through each of the elements of the shortest array and check if an individual keys exists, 
		// in which case merge its elements into the existing values, if not, copy it to the other array as is
		foreach ($v1 as $key => $value)			
			$v2[$key] = array_key_exists ($key , $v2) ? array_unique (array_merge ($v2[$key], $value)) : $value;

		return $v2;
	}

	/**
	* Function to re-sort and regroup each of the elements with their respective keys
	*
	* @param $array - array - contains the elements of the merged array
	*
	* @return $array - array - contains the re-merged elements of the array
	*
	* @author Gabriel Barina <barinagabriel2007@yahoo.com>
	*/
	function regroupElements2 ($array) {
		$ret_array = array();

		// sort the keys of the array alphabetically
		ksort ($array);

		// sort each of sub-arrays' values
		foreach ($array as $key => $value)
			$array[$key] = $value;

		// recombine the array keys with the individual values
		foreach ($array as $key => $values) {
			foreach ($values as $value)
				array_push($ret_array, $key . '/' . $value);
		}

		return $ret_array;
	}


	// ----------------------------------------------------------------------------------------------------------------------------

	$v1 = $random ? generateVector2() : array('a/1', 'a/2', 'a/3', 'a/4', 'a/128', 'a/129', 'b/65', 'b/66', 'c/1', 'c/10', 'c/42');
	$v2 = $random ? generateVector2() : array('a/1', 'a/2', 'a/3', 'a/4', 'a/5', 'a/126', 'a/127', 'b/100', 'c/2', 'c/3', 'd/1');

	compareAndMerge2 ($v1, $v2);

	// ----------------------------------------------------------------------------------------------------------------------------

	// Display Script End time
	$time_end = microtime (true);

	//dividing with 60 will give the execution time in seconds
	$execution_time = ($time_end - $time_start) * 1000;

	//execution time of the script
	echo "<br/><hr/><b>Total Execution Time:</b> $execution_time ms";
	echo "<br/><b>Total Memory Usage:</b> " . memory_get_peak_usage () . ' bytes';
	echo "<br/><hr/>";