<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //$this->call(MyTableSeeder::class);

        // \App\Models\Workflow::factory()->create([
        //     'name' => 'test1'
        // ]);

        \App\Models\Trigger::factory()->create([
            'name' => 'test trigger',
            'type' =>'event',
            'params' => 'MyTable new record',
            'workflow_id' => 1
        ]);

        \App\Models\Condition::factory()->create([
            'criteria' => 'priority > 3',
            'workflow_id' => 1
        ]);

        \App\Models\Action::factory()->create([
            'name' => 'log',
            'params' => 'log',
            'workflow_id' => 1
        ]);


    }
}
