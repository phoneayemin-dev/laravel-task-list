<?php
namespace App\Interfaces;

interface TaskRepositoryInterface {
    public function createTask(array $task);
    public function getTasksByUser(int $userId);
    public function deleteTask(int $id);
}