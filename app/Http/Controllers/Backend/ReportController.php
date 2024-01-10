<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RoomType;
use App\Models\Room;
use App\Models\Facility;
use App\Models\MultiImage;

use App\Models\BookingRoomList;

use App\Models\Booking;
use App\Models\RoomBookedDate;
use App\Models\RoomNumber;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReportController extends Controller
{
    public function BookingReport()
    {
        return view('backend.report.booking_report');

    } // End Method

    public function BookingReportSearch(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $bookings = Booking::where('check_in', '>=', $start_date)->where('check_out', '<=', $end_date)->get();

        return view('backend.report.booking_search_result', compact('start_date', 'end_date', 'bookings'));

    } // End Method



}
