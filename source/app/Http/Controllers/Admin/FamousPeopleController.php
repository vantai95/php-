<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FamousPeople;
use App\Models\Image;
use Session,Log;
use App\Services\CommonService;
use Illuminate\Support\Facades\File;

class FamousPeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.famous_people.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/famous-people'),
                    'text' => __('admin.famous_people.breadcrumbs.famous_people_index')
                ]
            ]
        ];

        $keyword = $request->get('q');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');
        $famousPeople = FamousPeople::select('famous_people.*' )->orderBy('famous_people.id', 'desc');
        if(!empty($status)) {
            if ($status == FamousPeople::STATUS_FILTER['INACTIVE']) {
                $famousPeople = $famousPeople->where('active', '=', false);
            } elseif ($status == FamousPeople::STATUS_FILTER['ACTIVE']) {
                $famousPeople = $famousPeople->where('active', '=', true);
            }
        }
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $famousPeople = $famousPeople->where(function ($query) use ($keyword) {
                $query->orWhere('name_en', 'LIKE', $keyword);
                $query->orWhere('name_vi', 'LIKE', $keyword);
            });
        }
        $famousPeople = $famousPeople->paginate($perPage);

        return view('admin.famous_people.index', compact('breadcrumbs','famousPeople','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $imageList = Image::get();

        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }
        $breadcrumbs = [
            'title' => __('admin.famous_people.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/famous-people'),
                    'text' => __('admin.famous_people.breadcrumbs.famous_people_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.famous_people.breadcrumbs.add_famous_people')
                ]
            ]
        ];
        return view('admin.famous_people.create', compact( 'breadcrumbs', 'imageList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_vi' => 'required',
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        FamousPeople::create($requestData);
        Session::flash('flash_message', trans('admin.famous_people.flash_messages.new'));
        return redirect('admin/famous-people');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $imageList = Image::get();

        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }
        $famousPeople = FamousPeople::findOrFail($id);
        //get all checked image
        $checkedImageList = $famousPeople->image;

        $breadcrumbs = [
            'title' => __('admin.famous_people.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/famous-people'),
                    'text' => __('admin.famous_people.breadcrumbs.famous_people_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.famous_people.breadcrumbs.edit_famous_people')
                ],
            ]
        ];

        if (empty($famousPeople->image)) {
            $famousPeople->image = '';
        } else {
            $famousPeople->image;
        }

        return view('admin.famous_people.edit', compact('famousPeople', 'breadcrumbs', 'imageList', 'checkedImageList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name_vi' => 'required',
        ]);

        $requestData = $request->all();
        $famousPeople = FamousPeople::findOrFail($id);
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        isset($requestData['name_en']) ? $requestData['name_en'] = $request->get('name_en') : $requestData['name_en'] = $requestData['name_vi'];

        $famousPeople->update($requestData);
        Session::flash('flash_message', trans('admin.famous_people.flash_messages.update'));
        return redirect('admin/famous-people');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $famousPeople = FamousPeople::findOrFail($id);
        //delete image
        if (!empty($famousPeople->image) && File::exists(public_path(config('constants.UPLOAD.FAMOUS_PEOPLE_IMAGE')) . '/' . $famousPeople->image)) {
            unlink(public_path(config('constants.UPLOAD.FAMOUS_PEOPLE_IMAGE')) . '/' . $famousPeople->image);
        }
        $famousPeople->delete();

        Session::flash('flash_message', __('admin.famous_people.flash_messages.destroy'));

        return redirect("admin/famous-people");
    }

    public function upload()
    {
        return;
    }
}
