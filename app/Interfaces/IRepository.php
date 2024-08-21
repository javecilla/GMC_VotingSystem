<?php

namespace App\Interfaces;

interface IRepository {
	public function getAll(String $condition = ""): object;
	public function getOne(int $id): object;
	public function create(array $attributes): array;
	public function update(array $attributes): array;
	public function delete(int $id): array;
}