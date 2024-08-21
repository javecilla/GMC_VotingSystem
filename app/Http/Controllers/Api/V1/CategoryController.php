<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\App\Admin\ChangesOccuredException;
use App\Exceptions\App\Admin\CreateDataException;
use App\Exceptions\App\Admin\DeleteDataException;
use App\Exceptions\App\Admin\DuplicateDataException;
use App\Exceptions\App\Admin\UpdateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CategoryCreateRequest;
use App\Http\Requests\App\Admin\CategoryUpdateRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller {
	public function __construct(protected CategoryService $service) {}

	public function getRecordsAll(String $appVersionName) {
		try {
			$category = $this->service->getAllCategory($appVersionName);

			return CategoryResource::collection($category);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Throwable $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured. Code[CTID]']);
		}
	}

	public function store(CategoryCreateRequest $request): JsonResponse {
		try {
			$this->service->createCategory($request->validated());

			return Response::json(['success' => true, 'message' => 'New category created successfully']);
		} catch (CreateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during creation. Code[CTID]']);
		}
	}

	public function update(CategoryUpdateRequest $request): JsonResponse {
		try {
			$this->service->updateCategory($request->validated());

			return Response::json(['success' => true, 'message' => 'Category updated successfully.']);
		} catch (ChangesOccuredException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'info']);
		} catch (DuplicateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage(), 'type' => 'warning']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (UpdateDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			\Log::info($e->getMessage());

			return Response::json(['success' => false, 'message' => 'An error occured during updation. Code[CTID]']);
		}
	}

	public function destroy(String $appVersionName, String $categoryId): JsonResponse {
		try {
			$this->service->deleteCategory($categoryId);

			return Response::json(['success' => true, 'message' => 'Category deleted successfully']);
		} catch (ModelNotFoundException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (DeleteDataException $e) {
			return Response::json(['success' => false, 'message' => $e->getMessage()]);
		} catch (\Exception $e) {
			return Response::json(['success' => false, 'message' => 'An error occured during deletion. Code[CTID]']);
		}
	}
}