<?php

namespace App\Services;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Http\Resources\Api\VotePointResource;
use App\Models\AppVersion;
use App\Models\VotePoint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VotePointService {
	public function getAllVotePoints(String $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('votePoints', 60 * 60 * 24, function () use ($appVersion) {
			$votePoint = VotePoint::orderBy('created_at', 'desc')
				->where('app_version_id', $appVersion->avid)->get();
			return VotePointResource::collection($votePoint);
		});
	}

	public function getOneVotePoints(int $votePointsId) {
		$cacheKey = 'votePointsId:' . $votePointsId;
		return Cache::remember($cacheKey, 60 * 60 * 24, function () use ($votePointsId) {
			$votePoint = VotePoint::findOrFail($votePointsId);
			return new VotePointResource($votePoint);
		});
	}

	public function createVotePoints(array $data) {
		return DB::transaction(function () use ($data) {
			//format the number into decimal [200 => 200.00]
			$amount = number_format((float) $data['amount'], 2, '.', '');
			$point = (int) $data['point'];

			$file = $data['image'] ?? null;
			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				$path = Storage::disk('public')->put('qrcode', $file);
				$data['image'] = $path;
			}

			$created = VotePoint::query()->create([
				'app_version_id' => data_get($data, 'app_version_id', null),
				'amount' => $amount,
				'point' => $point,
				'image' => $data['image'],
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);

			if (!$created) {
				throw new CreateDataException('Failed to created new voting points');
			}

			return response()->json(['success' => true, 'message' => 'Vote points created successfully.']);
		});
	}

	public function updateVotePoints(array $data) {
		if (!$this->hasChangesOccurred($data)) {
			return response()->json(['success' => false, 'message' => 'No changes occured', 'type' => 'info']);
		}

		if ($this->isDuplicateVotePoint($data)) {
			return response()->json(['success' => false, 'message' => 'Cannot duplicate vote points or amount.', 'type' => 'warning']);
		}

		$votePoint = VotePoint::findOrFail($data['vpid']);
		return DB::transaction(function () use ($votePoint, $data) {
			$amount = number_format((float) $data['amount'], 2, '.', '');
			$point = (int) $data['point'];

			$file = $data['image'] ?? null;
			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				$path = Storage::disk('public')->put('qrcode', $file);
				$data['image'] = $path;
			} elseif (!isset($data['image']) || $data['image'] === 'undefined' || $data['image'] === null) {
				$data['image'] = $votePoint->image;
			}

			$updated = $votePoint->update([
				'amount' => $amount,
				'point' => $point,
				'image' => data_get($data, 'image', $votePoint->image),
			]);

			if (!$updated) {
				throw new UpdateDataException('Failed to update vote points');
			}

			return response()->json(['success' => true, 'message' => 'Vote points updated successfully.']);
		});
	}

	public function deleteVotePoints(int $votePointId) {
		$votePoint = VotePoint::findOrFail($votePointId);
		return DB::transaction(function () use ($votePoint) {
			$deleted = $votePoint->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete vote point');
			}

			return response()->json(['success' => true, 'message' => 'Vote point deleted successfully']);
		});
	}

	private function isDuplicateVotePoint(array $data): bool {
		return $this->amountExists($data['amount'], $data['app_version_id'], $data['vpid'])
		|| $this->pointExists($data['point'], $data['app_version_id'], $data['vpid']);
	}

	private function hasChangesOccurred(array $data): bool {
		$votePoint = VotePoint::findOrFail($data['vpid']);
		$votePoint->fill($data);

		return $votePoint->isDirty();
	}

	private function amountExists(float $amount, int $avid, int $vpid): bool {
		return VotePoint::where('amount', $amount)
			->where('app_version_id', $avid)
			->where('vpid', '<>', $vpid)
			->exists();
	}

	private function pointExists(int $point, int $avid, int $vpid): bool {
		return VotePoint::where('point', $point)
			->where('app_version_id', $avid)
			->where('vpid', '<>', $vpid)
			->exists();
	}
}