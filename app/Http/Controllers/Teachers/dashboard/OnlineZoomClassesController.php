<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Traits\MeetingZoomTrait;
use App\Models\Grade;
use App\Models\online_classe;
use Illuminate\Http\Request;
use MacsiDigital\Zoom\Facades\Zoom;
use Illuminate\Support\Facades\Http;


class OnlineZoomClassesController extends Controller
{
    use MeetingZoomTrait;
    public function index()
    {
        $online_classes = online_classe::where('created_by',auth()->user()->email)->get();
        return view('pages.Teachers.dashboard.online_classes.index', compact('online_classes'));
    }


    public function create()
    {
        $Grades = Grade::all();
        return view('pages.Teachers.dashboard.online_classes.add', compact('Grades'));
    }

    public function indirectCreate()
    {
        $Grades = Grade::all();
        return view('pages.Teachers.dashboard.online_classes.indirect', compact('Grades'));
    }



    public function store(Request $request)
    {
        try {

//            $meeting = $this->createMeeting($request);
//
//            online_classe::create([
//                'integration' => true,
//                'Grade_id' => $request->Grade_id,
//                'Classroom_id' => $request->Classroom_id,
//                'section_id' => $request->section_id,
//                'created_by' => auth()->user()->email,
//                'meeting_id' => $meeting->id,
//                'topic' => $request->topic,
//                'start_at' => $request->start_time,
//                'duration' => $meeting->duration,
//                'password' => $meeting->password,
//                'start_url' => $meeting->start_url,
//                'join_url' => $meeting->join_url,
//            ]);


            $accessToken = "U779fKccQaKz6ztbHSqJ2g"; // Replace with your actual token

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post('https://api.zoom.us/v2/users/me/meetings', [
                'topic'      => 'Laravel Zoom API Meeting',
                'type'       => 2, // Scheduled meeting
                'start_time' => '2024-03-21T15:00:00Z', // UTC time format
                'duration'   => 30, // Meeting duration in minutes
                'timezone'   => 'UTC',
                'agenda'     => 'Laravel Zoom API Integration',
                'settings'   => [
                    'host_video'         => true,
                    'participant_video'  => true,
                    'join_before_host'   => false,
                    'mute_upon_entry'    => true,
                    'waiting_room'       => true,
                ],
            ]);

// Convert response to array
            $data = $response->json();
            dd($data);

            toastr()->success(trans('messages.success'));
            return redirect()->route('online_zoom_classes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function storeIndirect(Request $request)
    {
        try {
            online_classe::create([
                'integration' => false,
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'created_by' => auth()->user()->email,
                'meeting_id' => $request->meeting_id,
                'topic' => $request->topic,
                'start_at' => $request->start_time,
                'duration' => $request->duration,
                'password' => $request->password,
                'start_url' => $request->start_url,
                'join_url' => $request->join_url,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('online_zoom_classes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }


    public function destroy(Request $request,$id)
    {
        try {

            $info = online_classe::find($id);

            if($info->integration == true){
                $meeting = Zoom::meeting()->find($request->meeting_id);
                $meeting->delete();
                online_classe::destroy($id);
            }
            else{

                online_classe::destroy($id);
            }

            toastr()->success(trans('messages.Delete'));
            return redirect()->route('online_zoom_classes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
