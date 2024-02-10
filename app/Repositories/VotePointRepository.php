<?php

namespace App\Repositories;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Interfaces\IRepository;
use App\Models\AppVersion;
use App\Models\VotePoint;
use Illuminate\Support\Facades\DB;

class VotePointRepository implements IRepository {

	# @Override
	public function getAll(String $appVersionName = ""): object {
		$appVersion = AppVersion::where('name', $appVersionName)->first();
		if ($appVersion) {
			return VotePoint::where('app_version_id', $appVersion->avid)->get();
		} else {
			return VotePoint::all();
		}
	}

	# @Override
	public function getOne(int $vpid): object {}

	# @Override
	public function create(array $attributes): array {
		$amount = number_format((float) $attributes['amount'], 2, '.', '');
		$point = (int) $attributes['point'];

		return DB::transaction(function () use ($attributes, $amount, $point) {
			$created = VotePoint::query()->create([
				'app_version_id' => data_get($attributes, 'app_version_id', null),
				'amount' => $amount,
				'point' => $point,
				'updated_at' => data_get($attributes, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException('Something went wrong! Failed to created new voting points');
			}

			return ['success' => true, 'message' => 'Vote points created successfully.'];
		});
	}

	# @Override
	public function update(array $attributes): array {
		$votePoint = $this->findVotePoint((int) $attributes['vpid']);
		//format the number into decimal [200 => 200.00]
		$amount = number_format((float) $attributes['amount'], 2, '.', '');
		$point = (int) $attributes['point'];

		return DB::transaction(function () use ($votePoint, $amount, $point) {
			$updated = $votePoint->update([
				'amount' => $amount,
				'point' => $point,
				'updated_at' => null,
			]);
			if (!$updated) {
				throw new UpdateDataException('Something went wrong! Failed to vote points');
			}

			return ['success' => true, 'message' => 'Vote points updated successfully.'];
		});
	}

	# @Override
	public function delete(int $vpid): array {
		$votePoint = $this->findVotePoint($vpid);
		return DB::transaction(function () use ($votePoint) {
			$deleted = $votePoint->delete();
			if (!$deleted) {
				throw new DeleteDataException('Something went wrong! Failed to delete vote point');
			}

			return ['success' => true, 'message' => 'Vote point deleted successfully'];
		});
	}

	public function findVotePoint(int $vpid): VotePoint {
		return VotePoint::findOrFail($vpid);
	}

	public function amountExists(float $amount, int $avid, int $vpid): bool {
		return VotePoint::where('amount', $amount)
			->where('app_version_id', $avid)
			->where('vpid', '<>', $vpid)
			->exists();
	}

	public function pointExists(int $point, int $avid, int $vpid): bool {
		return VotePoint::where('point', $point)
			->where('app_version_id', $avid)
			->where('vpid', '<>', $vpid)
			->exists();
	}

}