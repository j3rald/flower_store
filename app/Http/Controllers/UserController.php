<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::orderBy('created_at', 'DESC')->get();
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
        $newUser = new User; 
        $newUser->first_name = $request->user["first_name"];
        $newUser->last_name = $request->user["last_name"];
        $newUser->email_address = $request->user["email_address"];
        $newUser->password = $request->user["password"];
        $newUser->mobile_number = $request->user["mobile_number"];
        $newUser->address = $request->user["address"];
        $newUser->status = $request->user["status"];

        $newUser->save();

        return $newUser;
    }

    public function getUser(Request $request, $email)
    {
        // $existingUser = User::find('email_address', $email_address); 
        $existingUser = User::select('select * from users where email_address = ?', [$request->email]); 

        if($existingUser) {
            return $existingUser;
        }
        
        // return User::table('users')->where('email_address', $request->user['email'])->get();
        return json_encode(array(['msg' => 'User not found!']));

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
}
