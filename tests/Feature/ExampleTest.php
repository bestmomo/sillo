<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ExampleTest extends TestCase {
	/**
	 * A basic test example.
	 */
	public function testTheApplicationReturnsASuccessfulResponse(): void {
		$response = $this->get('/');

		$response->assertStatus(200);
	}
}
