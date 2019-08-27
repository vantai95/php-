<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Log;

class SubMenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        session(['mainPage' => $request->fullUrl()]);
        $breadcrumbs = [
            'title' => __('admin.sub_menus.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/sub-menus'),
                    'text' => __('admin.sub_menus.breadcrumbs.sub_menu_index')
                ]
            ]
        ];

        $status = $request->get('status');
        $sub_menus = SubMenu::orderBy('sequence', 'asc')->get();
        if ($status == SubMenu::STATUS_FILTER['inactive']) {
            $sub_menus = $sub_menus->where('active', '=', false);
        } elseif ($status == SubMenu::STATUS_FILTER['active']) {
            $sub_menus = $sub_menus->where('active', '=', true);
        } else {
            $status = "";
        }
       
        $total = SubMenu::count();
        return view ('admin.sub_menus.index', compact('sub_menus', 'status', 'total',  'breadcrumbs'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function sequenceIndex(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.sub_menus.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.layouts.breadcrumbs.change_sequence')
                ]
            ]
        ];

        $menuId = $request->get('menu_id');
        $sub_menus = SubMenu::select('sub_menus.*');
        if(!empty($menuId)){
            $sub_menus->where('menu_id',$menuId)
                ->orderBy('sequence', 'asc');
        }else{
            $sub_menus = $sub_menus->where('menu_id','');
        }

        $sub_menus = $sub_menus->get();
        return view ('admin.sub_menus.sequence_index', compact('sub_menus', 'breadcrumbs','menuId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.sub_menus.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/sub-menus'),
                    'text' => __('admin.sub_menus.breadcrumbs.sub_menu_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.sub_menus.breadcrumbs.add_sub_menu')
                ]
            ]
        ];
        $menus = Menu::orderBy("name_$lang", 'asc')->pluck("name_$lang", 'id');
        return view('admin.sub_menus.create', compact('menus', 'breadcrumbs'));
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
        $this->validate($request,[
            'name_en' => 'required',
            'url' => 'required',
            'menu_id' => 'required'
        ]);

        $requestData = $request->all();

        $subMenuNumb = SubMenu::where('menu_id',$requestData['menu_id'])->count();

        $requestData['sequence'] = $subMenuNumb + 1;

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        $menus = Menu::findOrFail($requestData['menu_id']);

        $menus->subMenus()->create($requestData);

        Session::flash('flash_message', trans('admin.sub_menus.flash_messages.new'));

        return redirect('admin/sub-menus');
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
        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.sub_menus.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/sub-menus'),
                    'text' => __('admin.sub_menus.breadcrumbs.sub_menu_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.sub_menus.breadcrumbs.edit_sub_menu')
                ]
            ]
        ];
        $sub_menu = SubMenu::findOrFail($id);
        $menus = Menu::orderBy("name_$lang", 'asc')->pluck("name_$lang", 'id');
        return view('admin.sub_menus.edit',compact('sub_menu', 'menus', 'breadcrumbs'));
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
        $this->validate($request, [
            'name_en' => 'required',
            'url' => 'required',
            'menu_id' => 'required'
        ]);
        $requestData = $request->all();

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        $menuId = $request->get('menu_id');

        $sub_menu = SubMenu::findOrFail($id);

        // Get old item
        $oldSubMenu = SubMenu::where('id', $id)->first();

        $oldMenu = $oldSubMenu->menu_id;

        $sub_menu->update($requestData);

        // if menu_id change  => update new sequence for all data
        if ($oldMenu != $requestData['menu_id']) {
            //count sub menu which have menu_id equal with the request
            $subMenuNumb = SubMenu::where('menu_id', $menuId)->count();
            // get data of sub menu to update
            $subMenuItem = SubMenu::where('id', $id)->first();
            $oldSequence = $subMenuItem->sequence;
            // get data of all sub menu which have the sequence is greater than old sequence
            $subMenuItems = $subMenuItem->where('menu_id', $oldMenu)
                ->where('sequence', '>', $oldSequence)
                ->get();
            //update new sequence
            foreach ($subMenuItems as $item) {
                $item->update(['sequence' => $item->sequence - 1]);
            }
            $subMenuItem->update(['sequence' => $subMenuNumb]);
        }
        Session::flash('flash_message', trans('admin.sub_menus.flash_messages.update'));
        return redirect('admin/sub-menus');
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
        foreach ($requestDatas['sub_menus'] as $requestData){
            SubMenu::where('sub_menus.id', $requestData['id'])
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
        $sub_menu = SubMenu::findOrFail($id);
        $oldSequence = $sub_menu->sequence;
        $sub_menu->delete();
        $sub_menus = $sub_menu->where('sequence','>',$oldSequence)->get();
        foreach ($sub_menus as $item) {
            $item->update(['sequence' => $item->sequence - 1]);
        }
        Session::flash('flash_message', trans('admin.sub_menus.flash_messages.destroy'));
        return redirect('admin/sub-menus');
    }
}
