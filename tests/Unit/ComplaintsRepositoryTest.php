<?php

namespace Tests\Unit;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\Location;
use App\Models\User;
use App\Repositories\ComplaintsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\Image;

class ComplaintsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ComplaintsRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ComplaintsRepository();
    }

    public function test_create_complaint()
    {
        $user = User::factory()->create();
        $category = ComplaintCategory::factory()->create();
        $location = Location::factory()->create();

        $data = [
            'user_id' => $user->id,
            'location_id' => $location->id,
            'complaint_category_id' => $category->id,
            'title' => 'Noise Pollution',
            'description' => 'Too much noise at night.',
            'status' => 'انتظار',
            'region' => 'القاهرة',
            'priority_points' => 10,
        ];

        $complaint = $this->repository->create($data);

        $this->assertDatabaseHas('complaints', ['title' => 'Noise Pollution']);
        $this->assertEquals($user->id, $complaint->user_id);
    }

    public function test_apply_common_filters_valid()
    {
        $category = ComplaintCategory::factory()->create();
        $location = Location::factory()->create();
        $user = User::factory()->create();
        Complaint::factory()->create([
            'user_id' => $user->id,
            'location_id' => $location->id,
            'complaint_category_id' => $category->id,
            'title' => 'Water Leakage',
            'description' => 'Leak in the kitchen pipe.',
            'status' => 'منجزة',
        ]);

        $filters = [
            'status' => 'منجزة',
            'category_id' => $category->id,
            'location_id' => $location->id,
        ];

        $query = $this->repository->applyCommonFilters($filters);
        $results = $query->get();

        $this->assertCount(1, $results);
    }

    public function test_applyCommonFilters_with_empty_filters_returns_all()
    {
        // Create some complaints in DB
        $repository = new ComplaintsRepository();
        $user = User::factory()->create();
        $location = Location::factory()->create();
        $category = ComplaintCategory::factory()->create();

        // Then create complaint using those actual IDs
        Complaint::factory()->create([
            'user_id' => $user->id,
            'complaint_category_id' => $category->id,
            'location_id' => $location->id,
            'title' => 'Clean Area',
            'description' => 'Nothing to report here.',
            'status' => 'مرفوضة ',
        ]);
        Complaint::factory()->create([
            'user_id' => $user->id,
            'complaint_category_id' => $category->id,
            'location_id' => $location->id,
            'title' => 'Clean Area',
            'description' => 'Nothing to report here.',
            'status' => 'مرفوضة ',
        ]);
        Complaint::factory()->create([
            'user_id' => $user->id,
            'complaint_category_id' => $category->id,
            'location_id' => $location->id,
            'title' => 'Clean Area',
            'description' => 'Nothing to report here.',
            'status' => 'مرفوضة ',
        ]);
        $filters = []; // empty filters

        $query = $repository->applyCommonFilters($filters);
        $results = $query->get();

        $this->assertCount(3, $results);
    }
    public function test_apply_common_filters_invalid_status()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->repository->applyCommonFilters(['status' => 'invalid_status'])->get();
    }

    public function test_get_complaint_by_id_success()
    {
        $user = User::factory()->create();
        $category = ComplaintCategory::factory()->create();
        $location = Location::factory()->create();
        $complaint = Complaint::factory()->create(
            [
                'user_id' => $user->id,
                'location_id' => $location->id,
                'complaint_category_id' => $category->id,
                'title' => 'Water Leakage',
                'description' => 'Leak in the kitchen pipe.',
                'status' => 'انتظار',
            ]
        );
        $found = $this->repository->getComplaintById($complaint->id);
        $this->assertEquals($complaint->id, $found->id);
    }

    public function test_get_complaint_by_id_not_found()
    {
        $this->expectException(\Exception::class);
        $this->repository->getComplaintById(9999);
    }

    public function test_get_complaint_categories()
    {
        ComplaintCategory::factory()->count(2)->create();
        $categories = $this->repository->getComplaintCategories();
        $this->assertCount(2, $categories);
        $this->assertArrayHasKey('category_id', $categories->first());
    }

    public function test_create_complaint_category()
    {
        $category = $this->repository->createComplaintCategory('Water Issue',5);
        $this->assertDatabaseHas('complaint_categories', ['name' => 'Water Issue']);
        $this->assertEquals('Water Issue', $category->name);
    }

    public function test_update_complaint_category()
    {
        $category = ComplaintCategory::factory()->create(['name' => 'Old Name']);
        $updated = $this->repository->updateComplaintCategory($category->id, 'New Name');
        $this->assertEquals('New Name', $updated->name);
    }

    public function test_delete_complaint_category()
    {
        $category = ComplaintCategory::factory()->create();
        $deleted = $this->repository->deleteComplaintCategory($category->id);
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('complaint_categories', ['id' => $category->id]);
    }

    public function test_apply_nearby_filter_success()
    {
        // Create test data with location
        $user = User::factory()->create();
        $location = Location::factory()->create([
            'latitude' => 40.7128,
            'longitude' => -74.0060
        ]);
        $image = Image::factory()->create();

        // Create client profile with location
        $user->clientProfile()->create([
            'user_id' => $user->id,
            'image_id' => $image->id,
            'bio' => 'Bio',
            'phone' => '1234567890',
            'age' => 25,
            'gender' => 'male',
            'location_id' => $location->id,
        ]);

        // Refresh user model with relationships
        $user = User::with('clientProfile.location')->find($user->id);

        // Create complaint category
        $category = ComplaintCategory::factory()->create();

        // Mock Auth facade
        Auth::shouldReceive('user')->andReturn($user);

        // Create complaint
        $complaint = Complaint::factory()->create([
            'user_id' => $user->id,
            'location_id' => $location->id,
            'complaint_category_id' => $category->id,
            'title' => 'Water Leakage',
            'description' => 'Leak in the kitchen pipe.',
            'status' => 'انتظار',
        ]);

        // Apply nearby filter
        $query = Complaint::query();

        $result = $this->repository->applyNearbyFilter($query, 200);
        $result= $result->get();

        // Assert
        $this->assertTrue($result->contains('id', $complaint->id));
    }

    public function test_apply_nearby_filter_missing_location()
    {
        $user = User::factory()->create();
        Auth::shouldReceive('user')->andReturn($user);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User location not set.');

        $this->repository->applyNearbyFilter(Complaint::query(), 10);
    }
}
