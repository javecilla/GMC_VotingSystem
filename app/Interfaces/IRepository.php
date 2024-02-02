<?php

namespace App\Interfaces;

interface IRepository {
	public function create(array $data): array;
	public function update(array $data): array;
	//public function delete();
}