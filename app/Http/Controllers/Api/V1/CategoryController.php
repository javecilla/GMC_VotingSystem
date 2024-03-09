<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CategoryCreateRequest;
use App\Http\Requests\App\Admin\CategoryUpdateRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller {
	public function __construct(protected CategoryService $service) {}

	public function getRecordsAll(String $appVersionName) {
		try {
			return $this->service->getAllCategory($appVersionName);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured. Code[CTID]']);
		}
	}

	public function store(CategoryCreateRequest $request): JsonResponse {
		try {
			return $this->service->createCategory($request->validated());
		} catch (CreateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during creation. Code[CTID]']);
		}
	}

	public function update(CategoryUpdateRequest $request): JsonResponse {
		try {
			return $this->service->updateCategory($request->validated());
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during updation. Code[CTID]']);
		}
	}

	public function destroy(String $appVersionName, int $categoryId): JsonResponse {
		try {
			return $this->service->deleteCategory($categoryId);
		} catch (ModelNotFoundException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'An error occured during deletion. Code[CTID]']);
		}
	}
}