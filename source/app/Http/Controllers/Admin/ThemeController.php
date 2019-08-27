<?php

namespace App\Http\Controllers\Admin;
use App\Models\PageStorage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Image;
use App\Models\PageSection;
use App\Models\PageSectionData;

class ThemeController extends Controller
{
    //
    public function customize(Request $request){
      $pages = Page::all();
      return view('admin.theme.customize',compact('pages'));
    }

    public function getPageInfo($id,Request $request){
      $page = Page::with(['sections','sections.data' => function($query){
        return $query->select('page_section_datas.*','page_section_data_types.template','page_section_data_types.accepted_data')
        ->join('page_section_data_types','page_section_data_types.id','=','page_section_datas.data_type_id');
      }])->findOrFail($id);
      $azureUrl = config('filesystems.disks.azure.url');
      $images = Image::select('id','image')->get();
      $html = '';
      foreach($page->sections as $section){
        $html .= view('admin.theme.template.section',['section' => $section,'images' => $images])->render();
      }

      return response()->json(['data' => $html]);
    }

    public function updateSectionData($id,Request $request){
      $data = PageSectionData::findOrFail($id);
      $data->data = $request->input('data');
      $data->save();
      return response()->json([
        'success' => true
      ]);
    }
}
