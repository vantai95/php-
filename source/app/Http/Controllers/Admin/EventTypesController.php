<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventType;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Log;

class EventTypesController extends Controller
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
            'title' => __('admin.event_types.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/event-types'),
                    'text' => __('admin.event_types.breadcrumbs.event_type_index')
                ]
            ]
        ];

        $keyword = $request->get('q');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $event_types = EventType::orderBy('created_at', 'asc');

        if ($status == EventType::STATUS_FILTER['inactive']) {
            $event_types = $event_types->where('active', '=', false);
        } elseif ($status == EventType::STATUS_FILTER['active']) {
            $event_types = $event_types->where('active', '=', true);
        } else {
            $status = "";
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $event_types = $event_types->where(function ($query) use ($keyword) {
                $query->orWhere('event_types.name_en', 'LIKE', $keyword);
                $query->orWhere('event_types.name_vi', 'LIKE', $keyword);
                $query->orWhere('event_types.name_ja', 'LIKE', $keyword);
            });
        }

        $event_types = $event_types->paginate($perPage);
        return view ('admin.event_types.index',compact('event_types', 'status', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.event_types.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/event-types'),
                    'text' => __('admin.event_types.breadcrumbs.event_type_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.event_types.breadcrumbs.add_event_type')
                ]
            ]
        ];

        return view('admin.event_types.create', compact('breadcrumbs'));
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
            'name_vi' => 'required',
        ]);

        $requestData = $request->all();

        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        EventType::create($requestData);

        Session::flash('flash_message', trans('admin.event_types.flash_messages.new'));

        return redirect('admin/event-types');
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
            'title' => __('admin.event_types.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/event-types'),
                    'text' => __('admin.event_types.breadcrumbs.event_type_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.event_types.breadcrumbs.edit_event_type')
                ]
            ]
        ];
        $event_type = EventType::findOrFail($id);

        return view('admin.event_types.edit',compact('event_type', 'breadcrumbs' ));
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
        $this->validate($request,[
            'name_vi' => 'required',
        ]);
        $requestData = $request->all();

        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        $event_type = EventType::findOrFail($id);

        $event_type->update($requestData);

        Session::flash('flash_message', trans('admin.event_types.flash_messages.update'));

        return redirect('admin/event-types');
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
        $event_type = EventType::findOrFail($id);

        $event_type->delete();

        Session::flash('flash_message', trans('admin.event_types.flash_messages.destroy'));

        return redirect('admin/event-types');
    }
}
