<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Location;
use App\User;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Controllers\Admin\LocationController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocationControllerTest extends TestCase
{
	use RefreshDatabase;
	
	protected $user;
	
	protected function setUp():void
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
		
	}

	/** @test */
	function guests_may_not_create_locations()
	{
		$this->get(route('admin.locations.create'))
				->assertRedirect('/login');
		$this->post(route('admin.locations.store'))
				->assertRedirect('/login');
	}
	
	/** @test */
	public function display_location_creation_form()
	{
		$response = $this->actingAs($this->user)->get(route('admin.locations.create'));
		
		$response->assertStatus(200);
		$response->assertViewIs('admin.locations.create');
	}

	/** @test */
	public function store_validates_using_a_form_request()
	{
		$this->assertActionUsesFormRequest(
			LocationController::class,
			'store',
			StoreLocationRequest::class
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
		
		$response = $this->actingAs($this->user)->post(route('admin.locations.store'),$payload);
		
		  // $response->dumpHeaders();
			// 	$response->dump();
				
		$response->assertStatus(302);

		//Storage::disk('photos')->assertExists('photo1.jpg');


		$response->assertSessionHas('success', 'Location Created Successfully');

		$response->assertRedirect(route('admin.locations.index'));

    $this->assertDatabaseHas('locations',[
			'name'=> 'conferences',
			'slug'=>'conferences',
	
		]);

	}

			/** @test */
	public function update_validates_using_a_form_request()
	{
		$this->assertActionUsesFormRequest(
			LocationController::class,
			'update',
			UpdateLocationRequest::class
		);
	}

	/** @test */
	public function edit_location()
	{
		$location = factory(Location::class)->create(
			[
			'name'=> 'conferences',
			'slug'=>'conferences',
			]
		);

		$payload = [
			'name'=> 'Private Dinning',
			'slug'=>'Private Dinning',
		];

		$response = $this->actingAs($this->user)->put(route('admin.locations.update', $location->id), $payload);

		$response->assertStatus(302);
		$response->assertSessionHas('success', 'Location Updated Successfully');
		
		$this->assertDatabaseHas('locations',$payload);
		
	}

	/** @test */
	public function delete_an_location()
	{
		$location = factory(Location::class)->create(
					[
					'name'=> 'conferences',
					'slug'=>'conferences',
					]
				);
						
		$response = $this->actingAs($this->user)->delete(route('admin.locations.destroy', $location->id));
		
		$response->assertStatus(302);
		$response->assertSessionHas('success', 'Location Deleted Successfully');
		
		$this->assertDatabaseHas('locations', [
				'id'=>$location->id,
				'deleted_at'=> now()
			]);
		

	}
}