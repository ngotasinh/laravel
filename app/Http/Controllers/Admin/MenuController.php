<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Menu\MenuService;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
	protected $menuService;

	public function __construct(MenuService $menuService)
	{
		$this->menuService = $menuService;
	}

	/**
	 * View page Login
	 */
	public function create()
	{
		return view('admin.menu.add', [
			'title' => 'Thêm Danh Mục Mới',
			'menus' => $this->menuService->getParent()
		]);
	}

	/**
	 * Add danh mục
	 */
	public function store(CreateFormRequest $request)
	{
		$this->menuService->create($request);

		return redirect()->back();
	}

	/**
	 * Get tất cả danh mục
	 */
	public function index()
	{
		return view('admin.menu.list', [
			'title' => 'Danh Sách Danh Mục Mới Nhất',
			'menus' => $this->menuService->getAll()
		]);
	}

	/**
	 * View danh mục
	 */
	public function show(Menu $menu)
	{
		return view('admin.menu.edit', [
			'title' => 'Chỉnh Sửa Danh Mục: ' . $menu->name,
			'menu' => $menu,
			'menus' => $this->menuService->getParent()
		]);
	}

	/**
	 * Update danh mục
	 */
	public function update(Menu $menu, CreateFormRequest $request)
	{
		$this->menuService->update($request, $menu);

		return redirect('/admin/menus/list');
	}

	/**
	 * Delete danh mục
	 */
	public function destroy(Request $request): JsonResponse
	{
		$result = $this->menuService->destroy($request);
		if ($result) {
			return response()->json([
				'error' => false,
				'message' => 'Xóa thành công danh mục'
			]);
		}

		return response()->json([
			'error' => true
		]);
	}
}
