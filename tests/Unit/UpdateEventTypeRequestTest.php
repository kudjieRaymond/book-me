<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Requests\UpdateEventTypeRequest ;


class UpdateEventTypeRequestTest extends TestCase
{
  protected function setUp():void
	{
		parent::setUp();
		
		$this->subject = new UpdateEventTypeRequest ();
		
	}

	
	public function testRules()
	{
		$this->assertEquals(
			[
				'name'=>'required',
				'slug'=>'required',
				'photo'=>'nullable|image'
			],
			$this->subject->rules()
		);
	}

	public function testAuthorize()
	{
		$this->assertTrue($this->subject->authorize());
	}
}