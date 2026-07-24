<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'image',
        'completed_at',
    ];

    // $castsの中に日付関係のカラムとカラム型を指定すると計算等がしやすくなる
    // 設定しない場合は文字列として日付等が取得されるため、計算等ができなくなる
    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    // リレーションシップを定義
    // タスクは一人のユーザーに紐づく
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // statusが完了（'completed）かどうかを判定する関数
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    // 期限切れかどうかを判定する関数
    public function isOverdue(): bool
    {
        // 期限が指定されていない、または、完了の場合は、falseを返す
        if (!$this->due_date || $this->isCompleted()) {
            return false;
        }

        /* 
        isPast()：指定した日付が今よりも前（Past）ならtrue、今と同じまたは未来なら
        falseを返す関数
        */ 
        return $this->due_date->isPast();
    }


    /*
    ステータスを完了（'completed'）に変えて、完了日付（'completed_at'）に
    今の日付時刻を登録する（タスクを完了する）
    */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    // 画像のURLを取得する
    public function getImageUrl(): ?string
    {
        // 画像が無ければnull
        if (!$this->image) {
            return null;
        }

        // Storageに保存されている画像のURLを返す
        return Storage::url($this->image);
    }

    // 優先度別の色を指定
    public function getPriorityColor(): string
    {
        return match($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'red',
            default => 'gray',
        };
    }

    // ステータス別の色を指定
    public function getStatusColor(): string
    {
        return match($this->status) {
            'pending' => 'gray',
            'in_progress' => 'blue',
            'completed' => 'green',
            default => 'gray',
        };
    }

    // 優先度別の日本語名を指定
    public function getPriorityLabel(): string
    {
        return match($this->priority) {
            'low' => '低',
            'medium' => '中',
            'high' => '高',
            default => '不明',
        };
    }

    // ステータス別の日本語名を指定
    public function getStatusLabel(): string
    {
        return match($this->status) {
            'pending' => '未着手',
            'in_progress' => '進行中',
            'completed' => '完了',
            default => '不明',
        };
    }
}
