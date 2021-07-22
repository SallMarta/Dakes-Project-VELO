<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Traveller;
use App\Message;
// use Dotenv\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login()
    {
        if(Auth::user()){
            return redirect('/home');
        } else{
            return view('auths.login');
        }
    }

    public function postlogin(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/home');
        } else {
            return redirect()->back()->withInput()->with('error', 'Invalid Account!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|integer',
        ]);

        if ($validator->passes()) {

            $user = new User;
            $user->role = 'traveller';
            $photo = 'profile.jpg';
            $user->name = $request->first_name . " " . $request->last_name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->remember_token = Str::random(60);
            $user->save();

            $request->request->add(['user_id' => $user->id]);
            $request->request->add(['photo' => $photo]);
            $request->request->add(['bio' => 'Empty']);

            Traveller::create($request->all());

            if (Auth::attempt($request->only('email', 'password'))) {
                return redirect('/home');
            } else {
                return redirect('/login');
            }
        } else {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
    }
}
// $eventpemilik = Event::leftjoin('tiket', 'event.id', '=', 'tiket.id_event')
//                 ->join('kategorievent', 'event.id_kategorievent', '=', 'kategorievent.id')
//                 ->select('event.*', 'tiket.id_kategoritiket AS id_kategoritiket', 'tiket.qty AS stok_tiket', 'kategorievent.nama AS id_kategorievent')
//                 ->sum('tiket.qty')
//                 ->groupBy(\DB::raw('event.*, tiket.id_kategoritiket AS id_kategoritiket, tiket.qty AS stok_tiket, kategorievent.nama AS id_kategorievent'))
//                 // ->groupBy(\DB::raw('event.*', 'tiket.id_kategoritiket AS id_kategoritiket', 'tiket.qty AS stok_tiket', 'kategorievent.nama AS id_kategorievent'))
//                 ->orderBy('id', 'desc')
//                 ->where('id_pemilik', $pemilik->id)->get();

// $eventpemilik = Event::leftjoin('tiket', 'event.id', '=', 'tiket.id_event')
//                         ->join('kategorievent', 'event.id_kategorievent', '=', 'kategorievent.id')
//                         ->sum(tiket.qty)
//                         ->select('event.*', 'tiket.id_kategoritiket AS id_kategoritiket', 'tiket.qty AS stok_tiket', 'kategorievent.nama AS id_kategorievent')
//                         ->orderBy('id', 'desc')
//                         ->where('id_pemilik', $pemilik->id)->get();

//  $eventpemilik = DB::table('event')
//                     ->leftjoin('tiket', 'event.id', '=', 'tiket.id_event')
//                     ->join('kategorievent', 'event.id_kategorievent', '=', 'kategorievent.id')
//                     ->select(DB::raw('event.*, tiket.id_kategoritiket as id_kategoritiket, SUM(tiket.qty) as stok_tiket, kategorievent.nama as id_kategorievent'))
//                     ->groupBy('status')
//                     ->orderBy('id', 'desc')
//                     ->where('id_pemilik', $pemilik->id)->get();
