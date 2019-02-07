<?php

namespace App\Http\Controllers;

use App\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Niveau;

class EtudiantController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etudiant = DB::table('etudiants')
        ->leftJoin('niveau', 'etudiants.niveau_id', '=', 'niveau.id')
        ->select('etudiants.*', 'niveau.name as niveau_name', 'niveau.id as niveau_id')
        ->paginate(5);

        return view('system-mgmt/etudiant/index', ['etudiant' => $etudiant]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $niveau = Niveau::all();
        return view('system-mgmt/etudiant/create', ['niveau' => $niveau]);
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
        // Upload image
        $path = $request->file('picture')->store('avatars');
        $keys = ['lastname', 'firstname', 'middlename', 'address', 'zip',
        'age', 'birthdate', 'registration_date', 'niveau_id'];
        $input = $this->createQueryInput($keys, $request);
        $input['picture'] = $path;
        
        Etudiant::create($input);

        return redirect()->intended('system-management/etudiant');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
   /* public function show(Etudiant $etudiant)
    {
        //
    }*/


    public function show($id)
    {
       
            $etudiant =Etudiant::find($id);
            return view('system-mgmt.etudiant.show',compact('etudiantShow'));  
            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $etudiant = Etudiant::find($id);
        // Redirect to state list if updating state wasn't existed
        if ($etudiant == null || count($etudiant) == 0) {
            return redirect()->intended('system-mgmt/etudiant');
        }
       
        $niveau = Niveau::all();
        return view('system-mgmt/etudiant/edit', ['etudiant' => $etudiant, 'niveau' => $niveau]);
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
        $etudiant = Etudiant::findOrFail($id);
        $this->validateInput($request);
        // Upload image
        $keys = ['lastname', 'firstname', 'middlename', 'address', 'zip',
        'age', 'birthdate', 'registration_date','niveau_id'];
        $input = $this->createQueryInput($keys, $request);
        if ($request->file('picture')) {
            $path = $request->file('picture')->store('avatars');
            $input['picture'] = $path;
        }

        Etudiant::where('id', $id)
            ->update($input);

        return redirect()->intended('system-management/etudiant');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Etudiant::where('id', $id)->delete();
         return redirect()->intended('system-mgmt/etudiant');
    }

    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'firstname' => $request['firstname'],
            'niveau.name' => $request['niveau_name']
            ];
        $etudiant = $this->doSearchingQuery($constraints);
        $constraints['niveau_name'] = $request['niveau_name'];
        return view('system-mgmt/etudiant/index', ['etudiant' => $etudiant, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = DB::table('etudiants')
        ->leftJoin('niveau', 'etudiants.niveau_id', '=', 'niveau.id')
        ->select('etudiants.firstname as etudiant_name', 'etudiants.*','niveau.name as niveau_name', 'niveau.id as niveau_id');
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }

     /**
     * Load image resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function load($name) {
         $path = storage_path().'/app/avatars/'.$name;
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    private function validateInput($request) {
        $this->validate($request, [
            'lastname' => 'required|max:60',
            'firstname' => 'required|max:60',
            'middlename' => 'required|max:60',
            'address' => 'required|max:120',
            'zip' => 'required|max:10',
            'age' => 'required',
            'birthdate' => 'required',
            'registration_date' => 'required',
            'niveau_id' => 'required'
        ]);
    }

    private function createQueryInput($keys, $request) {
        $queryInput = [];
        for($i = 0; $i < sizeof($keys); $i++) {
            $key = $keys[$i];
            $queryInput[$key] = $request[$key];
        }

        return $queryInput;
    }
}
