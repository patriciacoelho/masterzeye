<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItListsAllTheProjectsOrderedByName(): void
    {
        $user = User::factory()->create();
        $projects = Project::factory(['user_id' => $user->id])->count(5)->create();

        $this->actingAs($user)
            ->getJson(route('projects.index'))
            ->assertOk()
            ->assertJsonCount(5, 'projects')
            ->assertSeeInOrder(
                $projects->sortBy('name')->pluck('id')->toArray()
            )
            ->assertJsonStructure([
                'projects' => [
                    '*' => [
                        'id',
                        'name',
                        'start_date',
                        'end_date',
                        'status',
                        'creator_name',
                        'updated_at',
                    ],
                ],
            ]);
    }

    public function testAProjectCanBeShown(): void
    {
        $user = User::factory()->create();
        $project = Project::factory(['user_id' => $user->id])->create();

        $this->actingAs($user)
            ->getJson(
                route('projects.show', $project)
            )
            ->assertOk()
            ->assertJsonStructure([
                'project' => [
                    'id',
                    'name',
                    'start_date',
                    'end_date',
                    'value',
                    'status',
                    'creator',
                ],
            ]);
    }

    public function testAProjectCanBeStored(): void
    {
        $user = User::factory()->create();
        $projects = Project::factory()->make()->toArray();

        $this->actingAs($user)
            ->post(route('projects.store'), $projects)
            ->assertCreated()
            ->assertJson(['message' => 'Project successfully created!']);

        $this->assertDatabaseHas(Project::class, $projects);
    }

    public function testAnProjectCanBeUpdated(): void
    {
        $user = User::factory()->create();
        $project = Project::factory(['user_id' => $user->id])->create();
        $new_project_payload = Project::factory()
            ->make()
            ->toArray();

        $this->actingAs($user)
            ->put(
                route('projects.update', $project),
                $new_project_payload
            )
            ->assertOk()
            ->assertJson(['message' => 'Project successfully updated!']);

        $this->assertDatabaseHas(Project::class, [
            'id' => $project->id,
        ] + $new_project_payload);
    }
}
