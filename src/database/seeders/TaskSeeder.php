<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tanaka = User::where('email', 'tanaka@example.com')->first();
        $sato = User::where('email', 'sato@example.com')->first();

        Task::create([
            'user_id' => $tanaka->id,
            'title' => 'Laravelの勉強',
            'description' => 'ルーティング、コントローラー、モデルを学ぶ',
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => now()->addDay(3),
        ]);

        Task::create([
            'user_id' => $tanaka->id,
            'title' => 'データベース設計書を作成',
            'description' => 'ER図とテーブル定義書',
            'status' => 'completed',
            'priority' => 'low',
            'completed_at' => now()->subDays(2),
        ]);

        Task::create([
            'user_id' => $sato->id,
            'title' => 'プレゼン資料作成',
            'description' => '来週のミーティング用',
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => now()->addDays(5),
        ]);

        Task::create([
            'user_id' => $sato->id,
            'title' => 'コードレビュー',
            'description' => 'プルリクエスト#123をレビュー',
            'status' => 'in_progress',
            'priority' => 'medium',
            'due_date' => now()->addDay(),
        ]);
    }
}
