<?php
/**
 * CharCombinationGenerator
 * This is a tool to generate all possible combinations
 * given a charset and a maximum length.
 *
 * @author  Pierre-Julien MAZENOT <pj.mazenot@gmail.com>
 * @link    https://github.com/pjmazenot/project-stats
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class CharCombinationGenerator {

	/** @var int Maximum length of the combinations */
	public $maxLength = 0;

	/** @var array Charset available to create te combinations */
	public $alphabet = [];

	/** @var int Maximum of combination that can be generated */
	public $maxCombinations = 0;

	/** @var array Letter index by level */
	public $letterIndexByLevel = [];

	/*
	 * CharCombinationGenerator constructor.
	 *
	 * @param int $maxLength
	 * @param array $alphabet
	 */
	public function __construct($maxLength, array $alphabet) {

		// Set parameters
		$this->maxLength = $maxLength;
		$this->alphabet = $alphabet;

		// Get the total number of possible combinations
		$maxCombinations = 0;
		for($i = 1; $i <= $maxLength; $i++) {
			$maxCombinations += pow(count($this->alphabet), $i);
		}
		$this->maxCombinations = $maxCombinations;

		// Init the letter index by level array
		$this->letterIndexByLevel = array_fill(0, $maxLength, -1);

	}

	/*
	 * Run the generation of all possible combinations and execute the callback function on
	 * each one of them.
	 *
	 * @param callable $callback
	 *
	 * @throw Exception
	 */
	public function run($callback) {

		// Run the script until all the combinations have been generated
		$nextCombination = true;

		while(!empty($nextCombination)) {

			// Generate the next combination
			$nextCombination = $this->generateNextCombination();

			if(!empty($nextCombination)) {

				// Execute the callback function
				if(is_callable($callback)) {
					$callback($nextCombination);
				} else {
					throw new Exception('The callback parameter is not a valid function or reference.');
				}

			}

		}

	}

	/*
	 * Generate the next combination
	 *
	 * @return string
	 */
	public function generateNextCombination() {

		// Increment current level index
		$this->letterIndexByLevel[0]++;

		// Init vars
		$levels = count($this->letterIndexByLevel);
		$nextCombination = '';
		$newLevel = false;

		for($i = 0 ; $i < $levels ; $i++) {

			// Skip if the level has not been reached yet
			if($this->letterIndexByLevel[$i] === -1) {
				break;
			}

			// Update next index and reset current if the end of the charset has been reached
			if($this->letterIndexByLevel[$i] > count($this->alphabet) - 1) {

				// Reset current level index
				$this->letterIndexByLevel[$i] = 0;

				if(!isset($this->letterIndexByLevel[$i + 1])) {

					// Activate next level
					$this->letterIndexByLevel[$i + 1] = 0;
					$newLevel = true;

					// Return empty combination to end the process if the last combination has already been returned
					if(count($this->letterIndexByLevel) > $this->maxLength) {
						return '';
					}

				} else {

					// Increment next level index
					$this->letterIndexByLevel[$i + 1]++;

				}

			}

			// Add characters to the new combination
			$nextCombination .= $this->alphabet[$this->letterIndexByLevel[$i]];
			$nextCombination .= ($newLevel ? $this->alphabet[$this->letterIndexByLevel[$i + 1]] : '');

		}

		return $nextCombination;

	}

}