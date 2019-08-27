<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\News;
use App\Models\Province;
use App\Http\Controllers\Controller;
use Session;

class PromotionController extends Controller
{
    public function index() {
        $lang = Session::get('locale');
        $promotions = Promotion::select('promotions.*', "promotions.name_$lang as name", "promotions.short_description_$lang as short_description")
        ->orderBy('created_at', 'desc');
        $promotions = $promotions->paginate(4);
        return view('user.promotion.promotion',compact('promotions'));
    }

    public function detail($id, Request $request) {
        $lang = Session::get('locale');
        $news = News::select('news.*', "news.name_$lang as name", "news.short_description_$lang as short_description")
        ->orderBy('created_at', 'desc')->take(4)->get();

        $provinces = Province::select('provinces.id',"provinces.name_$lang as name")->get();
        $province_id = $request->get('province_id');

        $promotion = Promotion::select('promotions.*', "promotions.name_$lang as name" , "promotions.description_$lang as description", "promotions.short_description_$lang as short_description")
        ->findOrFail($id);

        $related_promotions = Promotion::select('promotions.*', "promotions.name_$lang as name" , "promotions.description_$lang as description", "promotions.short_description_$lang as short_description")
        ->where('id','!=',$promotion->id)
        ->orderBy('created_at', 'desc')->take(2)->get();

        return view('user.promotion.detail',compact('promotion','related_promotions','news','provinces','province_id'));
    }
}
