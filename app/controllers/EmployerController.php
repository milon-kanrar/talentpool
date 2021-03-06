<?php

class EmployerController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	
	  function __construct()
	  {
	      $this->beforeFilter('auth');
	       if( isset(Sentry::getUser()->id) && (Sentry::getUser()->group_id==2))
		   $this->_user = User::find(Sentry::getUser()->id);
	       else
	       {
		    Sentry::logout();
		    return Redirect::route('homepage');
	       }
	  }
	  public function index()
	  {
		  //
	  }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	  public function create()
	  {
  //             $data = ['sports'  => Sport::all(), 
  //            'sportLevels'       => SportLevel::all(), 
  //            'sportPositions'    => SportPosition::all(), 
  //            //'languages'         => Language::orderBy('name', 'ASC')->get(),//previous code 04.11.2014
  //	    'languages'         => Language::orderBy('name_id', 'ASC')->get(),
  //            'languageLevels'    => LanguageLevel::all(),
  //            'degreeTypes'       => DegreeType::all(),
  //            'degreeSubjects'    => DegreeSubject::all(),
  //            'degreeResults'     => DegreeResult::all(),
  //            'workTypes'         => WorkType::all(),
  //            'ethnicities'       => Ethnicity::all(),
  //            'firstName'         => Input::get('first_name', ''), 
  //            'lastName'          => Input::get('last_name', ''), 
  //            'email'             => Input::get('email', ''), 
  //            'password'          => Input::get('password', ''),
  //            'universities'      => University::all(),
  //            'schoolQualificationTypes' => SchoolQualificationType::all(),
  //            'socialPositions'   => SocialPosition::all(),
  //            'socialCategories'  => SocialCategory::all(),
  //            'workOptions'       => Option::where('category_id', '=', 1)->get(),
  //            'schoolOptions'     => Option::where('subcategory_id', '=', 5)->get()
  //            ];
  //            return View::make('employer.create', $data);   // previous code
	       return View::make('employer.empcreate');
	  }
	  public function submit()
	  {
	       $data = Input::all();
	       print_r($data);die();
	//       $validator = Validator::make(
	//	    $data,
	//	    User::$validationRules);
	  }

	  public function settings()
	  {
	       return View::make('employer.settings');
	  }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	  public function store()
	  {
		 //
	  }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	  public function show($id)
	  {
		 //
	  }


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	  public function edit($id)
	  {
	       //
	  }


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	  public function update()
	  {
	       //
            $user = $this->_user;
            $user->update(Input::only(['first_name', 'last_name']));
            $user->company_name   = Input::get('company_name');
            $user->save();
            return Redirect::to(route('employers.settings'));
	  }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	  public function destroy($id)
	  {
	       //
	  }


}
