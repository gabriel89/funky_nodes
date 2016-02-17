<?php
	class ArrayGen {
		public function __construct ($random, $min, $max) {
			$this->min = $min;
			$this->max = $max;

	        $this->v1 = $random ? $this->generateVector() : array('a/1', 'a/2', 'a/3', 'a/4', 'a/128', 'a/129', 'b/65', 'b/66', 'c/1', 'c/10', 'c/42');
			$this->v2 = $random ? $this->generateVector() : array('a/1', 'a/2', 'a/3', 'a/4', 'a/5', 'a/126', 'a/127', 'b/100', 'c/2', 'c/3', 'd/1');
	    }
	    
		/**
		* Generates elements for the array randomly
		*
		* @param *
		*
		* @return $ret_array - array - contains the elements of the array
		*
		* @author Gabriel Barina <barinagabriel2007@yahoo.com>
		*/
		function generateVector () {
			$array_length 	= rand ($this->min, $this->max);
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
		* Returns the generated arrays
		*
		* @param *
		*
		* @return * - array - contains the generated arrays
		*
		* @author Gabriel Barina <barinagabriel2007@yahoo.com>
		*/
		function getArrays () {
			return array($this->v1, $this->v2);
		}
	}