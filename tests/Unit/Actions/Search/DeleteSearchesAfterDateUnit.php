<?php

namespace Tests\Unit\Actions\Search;

use App\Actions\Search\DeleteSearchesAfterDate;
use App\Models\Search;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteSearchesAfterDateUnit extends TestCase
{
    use RefreshDatabase;

    public function test_it_does_not_delete_new_searches()
    {
        Search::factory()->create(['created_at' => Carbon::now()]);

        DeleteSearchesAfterDate::run(Carbon::now()->subDays(2));

        $this->assertCount(1, Search::count());
    }

    public function test_it_deletes_old_searches()
    {
        Search::factory()->create(['created_at' => Carbon::now()->subDays(16)]);

        DeleteSearchesAfterDate::run(Carbon::now()->subDays(7));

        $this->assertCount(0, Search::count());
    }
}
