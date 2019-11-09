<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Requests\StoreEventTypeRequest ;

class StoreEventTypeRequestTest extends TestCase
{
	private $subject;
	
	protected function setUp():void
	{
		parent::setUp();
		
		$this->subject = new StoreEventTypeRequest ();
		
	}

	
	public function testRules()
	{
		$this->assertEquals(
			[
				'name'=>'required',
				'slug'=>'required',
				'photo'=>'required|image'
			],
			$this->subject->rules()
		);
	}

	public function testAuthorize()
	{
		$this->assertTrue($this->subject->authorize());
	}
	
}