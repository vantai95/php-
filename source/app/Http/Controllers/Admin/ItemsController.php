<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Image;
use App\Models\SubItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\CommonService;
use Illuminate\Support\Facades\File;
use JavaScript;
use Session, Log;
use App\Models\CategoryItem;
use App\Rules\CheckUniqueData;
use App\Models\SubCategory;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     *
     * @internal param Request $request
     */
    public function index(Request $request)
    {
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $keyword = $request->get('q');

        $category_id = $request->get('category_id');

        $lang = Session::get('locale');

        $items = Item::join('categories_items', 'items.id', 'categories_items.item_id')
            ->join('categories', 'categories_items.category_id', 'categories.id')
            ->select('items.*', 'categories_items.category_id');

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $items = $items->where(function ($query) use ($keyword) {
                $query->orWhere('items.name_en', 'LIKE', $keyword);
                $query->orWhere('items.name_vi', 'LIKE', $keyword);
                $query->orWhere('items.name_ja', 'LIKE', $keyword);
            });
        }

        if (!empty($category_id)) {
            $items->where('categories_items.category_id', $category_id);
        }

        $items = $items->paginate($perPage);

        $breadcrumbs = [
            'title' => __('admin.items.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/items'),
                    'text' => __('admin.items.breadcrumbs.item_index')
                ]
            ]
        ];

        return view('admin.items.index', compact('items', 'category_id', 'breadcrumbs', 'lang'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function sequenceIndex(Request $request)
    {
        $categoryId = $request->get('category_id');

        $subCategoryId = $request->get('sub_category_id');

        $items = Item::join('categories_items', 'categories_items.item_id', 'items.id')
            ->join('categories', 'categories_items.category_id', 'categories.id')
            ->select('categories_items.*', 'items.*')->with('categories');

        if (!empty($categoryId) && !empty($subCategoryId)) {
            $items->where('categories_items.category_id', $categoryId)
                ->where('categories_items.sub_category_id', $subCategoryId)
                ->orderBy('categories_items.sequence', 'asc');
        } elseif (!empty($categoryId) && empty($subCategoryId)) {
            $items = $items->where('categories_items.category_id', $categoryId)
                ->where('categories_items.sub_category_id', '')
                ->orderBy('categories_items.sequence', 'asc');
        } elseif (empty($categoryId) && !empty($subCategoryId)) {
            $items = $items->where('categories_items.category_id', '')
                ->where('categories_items.sub_category_id', $subCategoryId)
                ->orderBy('categories_items.sequence', 'asc');
        } else {
            $items = $items->where('categories_items.category_id', '')
                ->where('categories_items.sub_category_id', 0);
        }

        $items = $items->get();

        $breadcrumbs = [
            'title' => __('admin.items.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.layouts.breadcrumbs.change_sequence')
                ]
            ]
        ];

        return view('admin.items.sequence_index', compact('items', 'breadcrumbs', 'categoryId', 'subCategoryId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $imageList = Image::get();
        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }

        $breadcrumbs = [
            'title' => __('admin.items.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/items'),
                    'text' => __('admin.items.breadcrumbs.item_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.items.breadcrumbs.item_create')
                ],
            ]
        ];

        JavaScript::put([
            'subItems' => [
                []
            ],
            'items' => $this->getAllItems()
        ]);

        return view('admin.items.create', compact('breadcrumbs', 'imageList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $validateList = [
            'name_en' => 'required',
            'category_ids' => 'required',
            'price' => 'required|numeric|min:1000',
            'description_en' => 'required'
        ];

        if (isset($requestData['item_type']) && $requestData['item_type'] == 1) {
            $validateList['sub_items'] = 'required|array|min:1|is_duplicated';
        }
        $this->validate($request, $validateList);

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        $catId = $request->get('category_ids');

        if ($catId != 3) {
            $requestData['begin_date'] = null;
            $requestData['end_date'] = null;
        }

        $itemNumb = CategoryItem::where('category_id', $catId)
            ->where('sub_category_id', $requestData['sub_category_ids'])
            ->count();

        $item = Item::create($requestData);

        $item_id = $item->id;

        if (isset($requestData['item_type']) && $requestData['item_type'] == 1) {
            foreach ($requestData['sub_items'] as $subItemData) {
                SubItem::create([
                    'main_item_id' => $item_id,
                    'item_id' => $subItemData,
                    'sequence' => 1
                ]);
            }
        }

        $item->categories()->sync([$catId => ['sequence' => $itemNumb + 1,
            'sub_category_id' => $requestData['sub_category_ids'],
            'sub_sub_category_id' => $requestData['sub_sub_category_id']]]);

        Session::flash('flash_message', trans('admin.items.flash_message.new'));

        return redirect('admin/items');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);

        $imageList = Image::get();
        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }

        //get all checked image
        $checkedImageList = $item->image;
        $checkedThumbImageList = $item->thumb_image;

        JavaScript::put([
            'subItems' => $item->subItems()
                ->join('items', 'items.id', 'sub_items.item_id')
                ->select('items.price', 'sub_items.item_id', 'items.image')
                ->get(),
            'items' => $this->getAllItems()
        ]);

        $breadcrumbs = [
            'title' => __('admin.items.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/items'),
                    'text' => __('admin.items.breadcrumbs.item_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.items.breadcrumbs.item_update')
                ],
            ]
        ];

        return view('admin.items.edit', compact('item', 'breadcrumbs', 'imageList', 'checkedImageList', 'checkedThumbImageList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $requestData = $request->all();

        $validateList = [
            'name_en' => 'required',
            'category_ids' => 'required',
            'price' => 'required|numeric|min:1000',
            'description_en' => 'html_required'
        ];

        if (isset($requestData['item_type']) && $requestData['item_type'] == 1) {
            $validateList['sub_items'] = 'required|array|min:1|is_duplicated';
        }

        $this->validate($request, $validateList);

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        $catId = $request->get('category_ids');

        $item = Item::findOrFail($id);

        // Get old item
        $oldItemCategory = CategoryItem::where('item_id', $id)->first();

        // get old category_id
        $oldCategory = $oldItemCategory->category_id;

        // get old sub_category_id
        $oldSubCategory = $oldItemCategory->sub_category_id;

        $item->update($requestData);

        $oldSubItems = SubItem::where('main_item_id', $id)->pluck('item_id')->toArray();

        $newSubItems = isset($requestData['sub_items']) ? $requestData['sub_items'] : [];

        if ($requestData['item_type'] == 1 && !empty($newSubItems)) {
            foreach ($newSubItems as $newSubItem) {
                //check if newSubItem is present in oldSubItem
                // if not, add newSubItem
                if (!in_array($newSubItem, $oldSubItems)) {
                    $item->subItems()->create([
                        'item_id' => $newSubItem,
                        'sequence' => 1
                    ]);
                } else {
                    $oldSubItems = array_diff($oldSubItems, [$newSubItem]);
                }
            }
            foreach ($oldSubItems as $oldSubItem) {
                SubItem::where('item_id', $oldSubItem)->where('main_item_id', $id)->delete();
            }
        }

        $item->categories()->sync([$catId => ['sequence' => $oldItemCategory->sequence, 'sub_category_id' => $requestData['sub_category_ids'], 'sub_sub_category_id' => $requestData['sub_sub_category_id']]]);

        // if category_id or sub_category_id is change => update new sequence for all data
        if ($oldCategory != $requestData['category_ids'] || $oldSubCategory != $requestData['sub_category_ids']) {

            //count item which have category_id and sub_category_id equal with the request
            $itemNumb = CategoryItem::where('category_id', $catId)
                ->where('sub_category_id', $requestData['sub_category_ids'])
                ->count();

            // get data of item category to update
            $itemCategory = CategoryItem::where('item_id', $id)->first();

            $oldSequence = $itemCategory->sequence;

            // get data of all items which have the sequence is greater than old sequence
            $itemsCategories = $itemCategory->where('category_id', $oldCategory)
                ->where('sub_category_id', $oldSubCategory)
                ->where('sequence', '>', $oldSequence)
                ->get();

            //update new sequence
            foreach ($itemsCategories as $item) {
                $item->update(['sequence' => $item->sequence - 1]);
            }

            $itemCategory->update(['sequence' => $itemNumb]);
        }

        Session::flash('flash_message', trans('admin.items.flash_message.update'));

        return redirect('admin/items');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateSequence(Request $request)
    {
        $requestDatas = $request->all();
        foreach ($requestDatas['items'] as $requestData) {
            CategoryItem::where('item_id', $requestData['id'])
                ->update(['sequence' => $requestData['sequence'],
                ]);
        }
        return response('updated', 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        $oldItemCategory = CategoryItem::where('item_id', $id)->first();

        $oldCategory = $oldItemCategory->category_id;

        $oldSubCategory = $oldItemCategory->sub_category_id;

        $oldSequence = $oldItemCategory->sequence;

        $item->categories()->detach();

        $item->delete();

        if ($item->item_type) {
            SubItem::where('main_item_id', $id)->delete();
        }

        $itemsCategories = $oldItemCategory->where('category_id', $oldCategory)
            ->where('sub_category_id', $oldSubCategory)
            ->where('sequence', '>', $oldSequence)
            ->get();

        foreach ($itemsCategories as $item) {
            $item->update(['sequence' => $item->sequence - 1]);
        }

        Session::flash('flash_message', trans('admin.items.flash_message.destroy'));

        return redirect('admin/items');
    }

    public function getSubCategories($id)
    {
        $arr = [];
        $lang = Session::get('locale');
        $arr['category'] = Category::findOrFail($id);
        $arr['subCategory'] = Category::findOrFail($id)->subCategories()->whereNull('sub_categories.parent_id')->get(['sub_categories.id', 'sub_categories.name_' . $lang . ' as name']);
        return response()->json($arr);

    }

    public function getSubSubCategories($id)
    {
        $arr = [];
        $lang = Session::get('locale');
        $arr['subSubCategory'] = SubCategory::where('parent_id', $id)->get(['id', "name_$lang as name"]);
        return response()->json($arr);

    }

    public function getAllItems()
    {
        $lang = Session::get('locale');
        return Item::where('item_type', false)->get(['id', "name_$lang as name", 'price', 'image']);
    }

    public function getItemsData($id)
    {
        $itemsData = Item::findOrFail($id);

        return response()->json($itemsData);

    }


    public function upload()
    {
        return;
    }
}
