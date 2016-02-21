<?php
	class ArrayRange {
		public function __construct ($arrays) {
	        $this->v1 = $this->determineRange ($arrays[0]);
			$this->v2 = $this->determineRange ($arrays[1]);
	    }

	    /**
		* Helper method that transforms a regular array used as input-data into ranges
		*
		* @param $array - array - contains the elements of the array without ranges
		*
		* @return $newArray - array - contains the elements of the array but using ranges
		*
		* @author Gabriel Barina <barinagabriel2007@yahoo.com>
		*/
	    function determineRange ($array) {
	    	$array 		= $this->separateElements ($array);
	    	$newArray 	=  array();

	    	foreach ($array as $key => $values) {
	    		$range 	= false; 
	    		$start 	= $values[0];

	    		for ($i = 0; $i < sizeof ($values) - 1; $i ++) {			
	    			if (($values[$i] + 1) == $values[$i+1])
	    				$range = true;
	    			
	    			else if ($range) {
	    				array_push ($newArray, $key . '/' . $start . '-' . $values[$i]);
	    				$start 	= $values[$i+1];
	    				$range 	= false;
	    			
	    			} else
	    				array_push ($newArray, $key . '/' . $values[$i]);
	    		}

    			array_push ($newArray, $key . '/' . ($range ? $start . '-' : '') . $values[$i]);
	    	}
	    	
	    	return $newArray;
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
		function separateElements ($elements) {
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
		function compareElements ($v1, $v2) {
			print_r("<br/>======================<br/>");
			var_dump($v1);
			print_r("<br/>--------------------------<br/>");
			var_dump($v2);
			print_r("<br/>======================<br/>");

			// cycle through each of the elements of the shortest array and check if an individual keys exists, 
			// in which case merge its elements into the existing values, if not, copy it to the other array as is
			foreach ($v1 as $key => $value)	{
				// key doesn't exist
				if (!array_key_exists ($key , $v2)) {
					$v2[$key] = $value;

				// key exists, need to merge contents
				} else {
					$v2_values = array();

					// turn intervals into arrays for testing
					foreach ($v2[$key] as $v2_key => $v2_value) {
						$local = explode ('-', $v2_value);

						array_push ($v2_values, (count ($local) < 2) ? $local : range ($local[0], $local[1]));
					}
					// var_dump($v2_values);
					// print_r("<br/>======================22222222<br/>");
					foreach ($v2_values as $v2_key => $v2_value) {
						// var_dump($v2_value);
						foreach ($value as $v1_key => $v1_value) {
							// split possible intervals
							$local = explode ('-', $v1_value);
							// var_dump($local);

							if (count ($local) < 2)
								if  (is_array ($v1_value))
									if (in_array ($local[0], $v1_value))
										print_r("Found ".$local[0] . ' in '. $v1_value);

							// var_dump($local);
							// die();

							// print_r("searching for ". json_encode($local) .' in '. json_encode($v2_value)."<br/>");

						}


					}
				}

			}





			// print_r("<br/>======================<br/>");
			// var_dump($v2);
			// print_r("<br/>======================<br/>");


			return $v2;
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
		function printVector ($name, $elements) {
			echo $name . ' = { ' . implode(', ', $elements) . " }<br/><br/>";
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
		function compareAndMerge () {
			$this->printVector ('v1', $this->v1);
			$this->printVector ('v2', $this->v2);

			$this->v1 = $this->separateElements ($this->v1);
			$this->v2 = $this->separateElements ($this->v2);
			$v3 = (count ($this->v2) > count ($this->v1)) ? $this->compareElements ($this->v1, $this->v2) : $this->compareElements ($this->v2, $this->v1);
			// $v3 = $this->regroupElements ($v3);

			// $this->printVector('v3', $v3);
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
		function regroupElements ($array) {
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
	}
