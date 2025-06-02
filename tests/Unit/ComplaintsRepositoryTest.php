<?php

namespace Tests\Unit;

use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\Location;
use App\Models\User;
use App\Repositories\ComplaintsRepository;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\Image;

class ComplaintsRepositoryTest extends TestCase
{

    protected ComplaintsRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ComplaintsRepository();
    }

    public function test_create_complaint()
    {
        $user = User::first();
        $category = ComplaintCategory::first();
        $location = Location::first();

        $data = [
            'user_id' => $user->id,
            'location_id' => $location->id,
            'complaint_category_id' => $category->id,
            'title' => 'Noise Pollution',
            'description' => 'Too much noise at night.',
            'status' => 'انتظار',
            'area' => 'القاهرة',
            'priority_points' => 10,
        ];

        $complaint = $this->repository->create($data);

        $this->assertDatabaseHas('complaints', ['title' => 'Noise Pollution']);
        $this->assertEquals($user->id, $complaint->user_id);
    }

    public function test_apply_common_filters_valid()
    {
        $category = ComplaintCategory::first();
        $location = Location::first();
        $user = User::first();

        $this->assertNotNull($category);
        $this->assertNotNull($location);
        $this->assertNotNull($user);

        $filters = [
            'status' => 'منجزة',
            'category_id' => $category->id,
            'location_id' => $location->id,
        ];

        $query = $this->repository->applyCommonFilters($filters);
        $results = $query->get();

        $this->assertIsIterable($results);
    }

    public function test_apply_common_filters_invalid_status()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->repository->applyCommonFilters(['status' => 'invalid_status'])->get();
    }

    public function test_get_complaint_by_id_success()
    {
        $complaint = Complaint::first();
        $this->assertNotNull($complaint);

        $found = $this->repository->getComplaintById($complaint->id);
        $this->assertEquals($complaint->id, $found->id);
    }

    public function test_get_complaint_by_id_not_found()
    {
        $this->expectException(\Exception::class);
        $this->repository->getComplaintById(9999);
    }

    public function test_create_complaint_category()
    {
        $category = $this->repository->createComplaintCategory('Water Issue',5);
        $this->assertDatabaseHas('complaint_categories', ['name' => 'Water Issue']);
        $this->assertEquals('Water Issue', $category->name);
    }

    public function test_update_complaint_category()
    {
        $category = ComplaintCategory::first();
        $updated = $this->repository->updateComplaintCategory($category->id, 'New Name');
        $this->assertEquals('New Name', $updated->name);
    }

    public function test_delete_complaint_category()
    {
        $category = ComplaintCategory::first();
        $deleted = $this->repository->deleteComplaintCategory($category->id);
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('complaint_categories', ['id' => $category->id]);
    }

    public function test_apply_nearby_filter_success()
    {
        $user = User::with('clientProfile.location')->has('clientProfile.location')->first();
        $this->assertNotNull($user);

        Auth::shouldReceive('user')->andReturn($user);

        $query = Complaint::query();
        $result = $this->repository->applyNearbyFilter($query, 200)->get();

        $this->assertIsIterable($result);
    }

    public function test_apply_nearby_filter_missing_location()
    {
        $user = User::doesntHave('clientProfile.location')->first() ?? User::first();
        Auth::shouldReceive('user')->andReturn($user);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User location not set.');

        $this->repository->applyNearbyFilter(Complaint::query(), 10);
    }
}
