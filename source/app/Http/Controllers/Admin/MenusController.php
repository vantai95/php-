<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.menus.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/menus'),
                    'text' => __('admin.menus.breadcrumbs.menu_index')
                ]
            ]
        ];
        $status = $request->get('status');
        $menus = Menu::orderBy('sequence', 'asc')->get();
        if ($status == Menu::STATUS_FILTER['inactive']) {
            $menus = $menus->where('active', '=', false);
        } elseif ($status == Menu::STATUS_FILTER['active']) {
            $menus = $menus->where('active', '=', true);
        } else {
            $status = "";
        }
        session(['mainPage' => $request->fullUrl()]);
        $total = Menu::count();
        return view ('admin.menus.index', compact('menus', 'status', 'total', 'breadcrumbs'));
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
            'title' => __('admin.menus.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.layouts.breadcrumbs.change_sequence')
                ]
            ]
        ];
        $menus = Menu::orderBy('sequence', 'asc')->get();        
        return view ('admin.menus.sequence_index', compact('menus', 'breadcrumbs'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.menus.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/menus'),
                    'text' => __('admin.menus.breadcrumbs.menu_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.menus.breadcrumbs.add_menu')
                ]
            ]
        ];
        return view('admin.menus.create',compact( 'breadcrumbs'));
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
        ]);

        $requestData = $request->all();

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        $requestData['sequence'] = Menu::count() + 1;

        Menu::create($requestData);

        Session::flash('flash_message', trans('admin.menus.flash_messages.new'));

        return redirect('admin/menus');
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
        $breadcrumbs = [
            'title' => __('admin.menus.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/menus'),
                    'text' => __('admin.menus.breadcrumbs.menu_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.menus.breadcrumbs.edit_menu')
                ]
            ]
        ];
        $menu = Menu::findOrFail($id);       
        return view('admin.menus.edit',compact('menu', 'breadcrumbs'));
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
        ]);
        $requestData = $request->all();

        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        
        $menu = Menu::findOrFail($id);

        $menu->update($requestData);

        Session::flash('flash_message', trans('admin.menus.flash_messages.update'));

        return redirect('admin/menus');
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
        foreach ($requestDatas['menus'] as $requestData){
            Menu::where('id', $requestData['id'])->update([
              'sequence' => $requestData['sequence'],
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
        $menu = Menu::findOrFail($id);

        $oldSequence = $menu->sequence;

        $menu->delete();

        $menus = $menu->where('sequence','>',$oldSequence)->get();

        foreach ($menus as $item) {
            $item->update(['sequence' => $item->sequence - 1]);
        }

        Session::flash('flash_message', trans('admin.menus.flash_messages.destroy'));

        return redirect('admin/menus');
    }
}
