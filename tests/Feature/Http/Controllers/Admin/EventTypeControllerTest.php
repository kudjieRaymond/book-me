<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\EventType;
use App\User;
use App\Http\Requests\StoreEventTypeRequest;
use App\Http\Requests\UpdateEventTypeRequest;
use App\Http\Controllers\Admin\EventTypeController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EventTypeControllerTest extends TestCase
{
	use RefreshDatabase;
	
	protected $user;
	
	protected function setUp():void
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
		
	}

	/** @test */
	function guests_may_not_create_event_types()
	{
		$this->get(route('admin.event-types.create'))
				->assertRedirect('/login');
		$this->post(route('admin.event-types.store'))
				->assertRedirect('/login');
	}
	
	/** @test */
	public function display_event_type_creation_form()
	{
		$response = $this->actingAs($this->user)->get(route('admin.event-types.create'));
		
		$response->assertStatus(200);
		$response->assertViewIs('admin.event-types.create');
	}

	/** @test */
	public function store_validates_using_a_form_request()
	{
		$this->assertActionUsesFormRequest(
			EventTypeController::class,
			'store',
			StoreEventTypeRequest::class
		);
	}

	/** @test */
	public function store_new_client()
	{
		Storage::fake('photos');
		
		$payload = [
			'name'=> 'conferences',
			'slug'=>'conferences',
			'photo' => UploadedFile::fake()->image('photo1.jpg'),
		];
		
		config()->set('filesystems.disks.photos', [
			'driver' => 'local',
			'root' => Storage::disk('photos')->getAdapter()->getPathPrefix(),
		]);	
		config()->set('medialibrary.disk_name', 'photos');
		
		$response = $this->actingAs($this->user)->post(route('admin.event-types.store'),$payload);
		
		  // $response->dumpHeaders();
			// 	$response->dump();
				
		$response->assertStatus(302);

		//Storage::disk('photos')->assertExists('photo1.jpg');


		$response->assertSessionHas('success', 'Event Type Created Successfully');

		$response->assertRedirect(route('admin.event-types.index'));

    $this->assertDatabaseHas('event_types',[
			'name'=> 'conferences',
			'slug'=>'conferences',
	
		]);

	}

			/** @test */
	public function update_validates_using_a_form_request()
	{
		$this->assertActionUsesFormRequest(
			EventTypeController::class,
			'update',
			UpdateEventTypeRequest::class
		);
	}

	/** @test */
	public function edit_event_type()
	{
		$event_type = factory(EventType::class)->create(
			[
			'name'=> 'conferences',
			'slug'=>'conferences',
			]
		);

		$payload = [
			'name'=> 'Private Dinning',
			'slug'=>'Private Dinning',
		];

		$response = $this->actingAs($this->user)->put(route('admin.event-types.update', $event_type->id), $payload);

		$response->assertStatus(302);
		$response->assertSessionHas('success', 'Event Type Updated Successfully');
		
		$this->assertDatabaseHas('event_types',$payload);
		
	}

	/** @test */
	public function delete_an_event_type()
	{
		$event_type = factory(EventType::class)->create(
					[
					'name'=> 'conferences',
					'slug'=>'conferences',
					]
				);
						
		$response = $this->actingAs($this->user)->delete(route('admin.event-types.destroy', $event_type->id));
		
		$response->assertStatus(302);
		$response->assertSessionHas('success', 'Event Type Deleted Successfully');
		
		$this->assertDatabaseHas('event_types', [
				'id'=>$event_type->id,
				'deleted_at'=> now()
			]);
		

	}



}