<?php

namespace App\Http\Controllers;

use App\Niveau;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $niveau = Niveau::paginate(5);

        return view('system-mgmt/niveau/index', ['niveau' => $niveau]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system-mgmt/niveau/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateInput($request);
         Niveau::create([
            'name' => $request['name']
        ]);

        return redirect()->intended('system-management/niveau');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Niveau  $niveau
     * @return \Illuminate\Http\Response
     */
    public function show(Niveau $niveau)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Niveau  $niveau
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $niveau = Niveau::find($id);
        // Redirect to roles list if updating niveau wasn't existed
        if ($niveau == null || count($niveau) == 0) {
            return redirect()->intended('/system-management/niveau');
        }

        return view('system-mgmt/niveau/edit', ['niveau' => $niveau]);
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
        $niveau = Niveau::findOrFail($id);
        $this->validateInput($request);
        $input = [
            'name' => $request['name']
        ];
        Niveau::where('id', $id)
            ->update($input);
        
        return redirect()->intended('system-management/niveau');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Niveau::where('id', $id)->delete();
         return redirect()->intended('system-management/niveau');
    }

    /**
     * Search division from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']
            ];

       $roles = $this->doSearchingQuery($constraints);
       return view('system-mgmt/niveau/index', ['niveau' => $roles, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Niveau::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
    private function validateInput($request) {
        $this->validate($request, [
        'name' => 'required|max:60|unique:niveau'
    ]);
    }
}
