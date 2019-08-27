<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\NewsType;
use App\Models\EventType;
use App\Models\News;
use App\Models\Service;
use App\Models\Category;
use Session;
use Carbon\Carbon;

class EventsController extends Controller
{
    public function index(Request $request) {
        $lang = Session::get('locale');
        //filter by event_type
        $event_types = EventType::orderBy('name_en', 'asc')->select("name_$lang as name", 'id')->get();
        $event_type_id = $request->get('event_type_id');
        $date_upcoming_event = $request->get('date_upcoming_event');

        $query = Event::query();
        $query = $query->select('events.*', "events.name_$lang as name")
                        ->where('events.date_begin', '>=', Carbon::now())
                        ->orderBy('events.date_begin', 'asc');
        if(!empty($event_type_id)) {
            $query ->where('events.event_type_id', '=', $event_type_id);
        }
        if(!empty($date_upcoming_event)) {
            $query->where('events.date_begin', '=',$date_upcoming_event);
        }
        $events = $query->take(3)->get();

        //filter by new_type
        $news_type_id = $request->get('news_type_id');
        $news_types = NewsType::orderBy('name_en', 'asc')->select("name_$lang as name", 'id')->get();
        if(!empty($news_type_id)) {
            $news = News::select('news.*', "news.name_$lang as name", "news.short_description_$lang as short_description","news_types.name_$lang as news_type_name")
            ->join('news_types', 'news.news_type_id', 'news_types.id')
            ->where('news.news_type_id', '=', $news_type_id)
            ->orderBy('created_at', 'desc');
        }
        else {
            $news = News::select('news.*', "news.name_$lang as name", "news.short_description_$lang as short_description","news_types.name_$lang as news_type_name")
            ->join('news_types', 'news.news_type_id', 'news_types.id')
            ->orderBy('created_at', 'desc');
        }

        $news = $news->paginate(8);

        return view('user.event.index', compact('events','event_types','news_types','news','event_type_id','news_type_id','date_upcoming_event'));
    }
    public function detail($id) {
        $lang = Session::get('locale');

        $event = Event::select('events.*', "events.name_$lang as name", "events.description_$lang as description")
        ->findOrFail($id);

        $news = News::select('news.*', "news.name_$lang as name", "news.short_description_$lang as short_description")
        ->orderBy('created_at', 'desc')->take(4)->get();

        $service = Service::select("services.id","services.image", "services.name_$lang as service_name", "categories.name_$lang as category_name")
        ->join('categories' , "categories.id", "services.category_id")
        ->orderBy('services.created_at', 'desc')
        ->take(3)->get();
        return view('user.event.detail',compact('event','news','service'));
    }
}
