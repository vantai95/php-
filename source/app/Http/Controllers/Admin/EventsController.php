<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Image;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Log;

class EventsController extends Controller
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
            'title' => __('admin.events.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/events'),
                    'text' => __('admin.events.breadcrumbs.event_index')
                ]
            ]
        ];
        session(['mainPage' => $request->fullUrl()]);

        $keyword = $request->get('q');
        $status = $request->get('status');

        $lang = Session::get('locale');

        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $events = Event::select('events.*')->orderBy('events.id', 'desc');

        if ($status == Event::STATUS_FILTER['inactive']) {
            $events = $events->where('events.active', '=', false);
        } elseif ($status == Event::STATUS_FILTER['active']) {
            $events = $events->where('events.active', '=', true);
        } else {
            $status = "";
        }

        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $events = $events->where(function ($query) use ($keyword) {
                $query->orWhere('events.name_en', 'LIKE', $keyword);
                $query->orWhere('events.name_vi', 'LIKE', $keyword);
            });
        }

        $events = $events->paginate($perPage);
        return view('admin.events.index', compact('events', 'status', 'breadcrumbs', 'lang'));
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
            'title' => __('admin.events.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/events'),
                    'text' => __('admin.events.breadcrumbs.event_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.events.breadcrumbs.add_event')
                ]
            ]
        ];

        $lang = Session::get('locale');
        $event_types = EventType::orderBy('name_en', 'asc')->pluck("name_$lang", 'id');
        return view('admin.events.create', compact('breadcrumbs', 'imageList','event_types'));
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
        $this->validate($request, [
            'name_vi' => 'required',
            'date_begin' => 'date_format:Y-m-d'
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        Event::create($requestData);
        Session::flash('flash_message', trans('admin.events.flash_messages.new'));

        return redirect('admin/events');
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
        $imageList = Image::get();

        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }

        $event = Event::findOrFail($id);
        $checkedImageList = $event->image;

        $lang = Session::get('locale');
        $breadcrumbs = [
            'title' => __('admin.events.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/events'),
                    'text' => __('admin.events.breadcrumbs.event_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.events.breadcrumbs.edit_event')
                ],
            ]
        ];

        if (empty($event->image)) {
            $event->image = '';
        } else {
            $event->image;
        }
        $event_types = EventType::orderBy('name_en', 'asc')->pluck("name_$lang", 'id');

        return view('admin.events.edit', compact('event', 'breadcrumbs', 'imageList', 'checkedImageList','event_types'));
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
            'name_vi' => 'required',
            'date_begin' => 'date_format:Y-m-d'
        ]);

        $requestData = $request->all();
        $event = Event::findOrFail($id);
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        $event->update($requestData);
        Session::flash('flash_message', trans('admin.events.flash_messages.update'));
        return redirect('admin/events');
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
        $event = Event::findOrFail($id);
        //delete image
        if (!empty($event->image) && File::exists(public_path(config('constants.UPLOAD.EVENT_IMAGE')) . '/' . $event->image)) {
            unlink(public_path(config('constants.UPLOAD.EVENT_IMAGE')) . '/' . $event->image);
        }
        $event->delete();

        Session::flash('flash_message', __('admin.events.flash_messages.destroy'));

        return redirect("admin/events");
    }

    public function upload()
    {
        return;
    }
}
