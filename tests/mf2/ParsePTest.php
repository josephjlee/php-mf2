<?php

/**
 * Tests of the parsing methods within mf2\Parser
 */

namespace mf2\Parser\test;

// Include Parser.php
$autoloader = require_once dirname(__DIR__) . '/../mf2/Parser.php';

use mf2\Parser,
	PHPUnit_Framework_TestCase,
	DateTime;

class ParsePTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		date_default_timezone_set('Europe/London');
	}

	/**
	 * @group parseP
	 */
	public function testParsePHandlesInnerText() {
		$input = '<div class="h-card"><p class="p-name">Example User</p></div>';
		$parser = new Parser($input);
		$output = $parser->parse();

		$this->assertArrayHasKey('name', $output['items'][0]['properties']);
		$this->assertEquals('Example User', $output['items'][0]['properties']['name'][0]);
	}

	/**
	 * @group parseP
	 */
	public function testParsePHandlesImg() {
		$input = '<div class="h-card"><img class="p-name" alt="Example User"></div>';
		$parser = new Parser($input);
		$output = $parser->parse();


		$this->assertArrayHasKey('name', $output['items'][0]['properties']);
		$this->assertEquals('Example User', $output['items'][0]['properties']['name'][0]);
	}

	/**
	 * @group parseP
	 */
	public function testParsePHandlesAbbr() {
		$input = '<div class="h-card h-person"><abbr class="p-name" title="Example User">@example</abbr></div>';
		$parser = new Parser($input);
		$output = $parser->parse();

		$this->assertArrayHasKey('name', $output['items'][0]['properties']);
		$this->assertEquals('Example User', $output['items'][0]['properties']['name'][0]);
	}

	/**
	 * @group parseP
	 */
	public function testParsePHandlesData() {
		$input = '<div class="h-card"><data class="p-name" value="Example User"></data></div>';
		$parser = new Parser($input);
		$output = $parser->parse();


		$this->assertArrayHasKey('name', $output['items'][0]['properties']);
		$this->assertEquals('Example User', $output['items'][0]['properties']['name'][0]);
	}

	/**
	 * @group parseP
	 */
	public function testParsePReturnsEmptyStringForBrHr() {
		$input = '<div class="h-card"><br class="p-name"/></div><div class="h-card"><hr class="p-name"/></div>';
		$parser = new Parser($input);
		$output = $parser->parse();

		$this->assertArrayHasKey('name', $output['items'][0]['properties']);
		$this->assertEquals('', $output['items'][0]['properties']['name'][0]);
		$this->assertEquals('', $output['items'][0]['properties']['name'][0]);
	}

}

// EOF tests/mf2/testParser.php