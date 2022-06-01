<?php
namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;

use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface {

    public function createTask(array $task)
    {
        return Task::create($task);
    }

    public function getTasksByUser(int $userId) {
        return Task::where('user_id', $userId)->orderBy('created_at', 'DESC')->get();
    }

    public function deleteTask(int $id) {
        Task::destroy($id);
    }
}