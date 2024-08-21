<?php

namespace App\Services;

use App\Exceptions\App\Admin\ChangesOccuredException;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\DuplicateDataException;
use App\Helpers\Decoder;
use App\Models\AppVersion;
use App\Models\VotePoint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VotePointService {
	public function getAllVotePoints(String $appVersionName) {
		$appVersion = AppVersion::where('name', $appVersionName)->firstOrFail();
		return Cache::remember('votePoints:' . $appVersion->avid, 60 * 60 * 24,
			function () use ($appVersion) {
				$votePoint = VotePoint::orderBy('created_at', 'desc')
					->where('app_version_id', $appVersion->avid)->get();

				return $votePoint;
			});
	}

	public function getOneVotePoints(String $votePointsId) {
		return Cache::remember('votePointsId:' . $votePointsId, 60 * 60 * 24,
			function () use ($votePointsId) {
				$vpid = Decoder::decodeIds($votePointsId);
				$votePoint = VotePoint::findOrFail($vpid);
				return $votePoint;
			});
	}

	public function createVotePoints(array $data) {
		return DB::transaction(function () use ($data) {
			$file = $data['image'] ?? null;
			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				$path = Storage::disk('public')->put('qrcode', $file);
				$data['image'] = $path;
			}
			$avid = Decoder::decodeIds($data['app_version_id']);
			$created = VotePoint::query()->create([
				'app_version_id' => $avid,
				'amount' => data_get($data, 'amount', null),
				'point' => data_get($data, 'point', null),
				'image' => $data['image'],
				'created_at' => data_get($data, 'created_at', now()),
				'updated_at' => data_get($data, 'updated_at', null),
			]);
			if (!$created) {
				throw new CreateDataException('Failed to created new voting points.', 422);
			}

			return;
		});
	}

	public function updateVotePoints(array $data) {
		$data['vpid'] = Decoder::decodeIds($data['vpid']);

		if(!$this->hasChangesOccurred($data)) {
			throw new ChangesOccuredException('No changes occured.');
		}

		if($this->amountExists($data)) {
			throw new DuplicateDataException('Cannot duplicate vote amount for points.');
		}

		if($this->pointExists($data)) {
			throw new DuplicateDataException('Cannot duplicate vote points for amount.');
		}

		$votePoint = VotePoint::findOrFail($data['vpid']);
		return DB::transaction(function () use ($votePoint, $data) {
			$file = $data['image'] ?? null;
			if ($file instanceof \Illuminate\Http\UploadedFile  && $file->isValid()) {
				$path = Storage::disk('public')->put('qrcode', $file);
				$data['image'] = $path;
			} elseif (!isset($data['image']) || $data['image'] === 'undefined' || $data['image'] === null) {
				$data['image'] = $votePoint->image;
			}

			$updated = $votePoint->update([
				'amount' => data_get($data, 'amount', $votePoint->amount),
				'point' => data_get($data, 'point', $votePoint->point),
				'image' => data_get($data, 'image', $votePoint->image),
			]);

			if(!$updated) {
				throw new UpdateDataException('Failed to update vote points.', 422);
			}

			return;
		});
	}

	public function deleteVotePoints(String $votePointId) {
		$vpid = Decoder::decodeIds($votePointId);
		$votePoint = VotePoint::findOrFail($vpid);
		return DB::transaction(function () use ($votePoint) {
			$deleted = $votePoint->delete();
			if (!$deleted) {
				throw new DeleteDataException('Failed to delete vote point');
			}

			return;
		});
	}

	private function hasChangesOccurred(array $data): bool {
		$votePoint = VotePoint::findOrFail($data['vpid']);
		$votePoint->fill([
			'amount' => data_get($data, 'amount', $votePoint->amount),
			'point' => data_get($data, 'point', $votePoint->point),
			'image' => data_get($data, 'image', $votePoint->image)
		]);

		return $votePoint->isDirty();
	}

	//this check if the update request for ammount and points
	//is already exist on the specific amount and points and version
	private function amountExists(array $data): bool {
    return VotePoint::where('amount', $data['amount'])
      ->where('app_version_id', $data['app_version_id'])
      ->where('point', '<>', $data['point'])
      ->where('vpid', '<>', $data['vpid'])
      ->exists();
	}

	private function pointExists(array $data): bool {
    return VotePoint::where('point', $data['point'])
      ->where('app_version_id', $data['app_version_id'])
      ->where('amount', '<>', $data['amount'])
      ->where('vpid', '<>', $data['vpid'])
      ->exists();
	}
}