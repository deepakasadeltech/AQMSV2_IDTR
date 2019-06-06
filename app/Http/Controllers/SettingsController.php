<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SettingsRepository;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Counter;
use App\Models\User;
use DB;


class SettingsController extends Controller
{
    protected $settings;

    public function __construct(SettingsRepository $settings)
    {
        $this->settings = $settings;
    }

    public function index(Request $request)
    {
        return view('user.settings.index', [
            'settings' => $this->settings->getSettings(),
            'languages' => $this->settings->getLanguages(),
			'users' => $this->settings->getUsers(),
			'pdepartments' => $this->settings->getPDepartments(),
            'departments' => $this->settings->getDepartments(),
            'counters' => $this->settings->getCounters(),
            'c_locale' => \App::getLocale(),
        ]);

    }

    public function getMapDoctor(Request $request, User $user)
    {
        
    }


    public function update(Request $request)
    {
        $user = $request->user();

        if($request->password=='') {
            $this->validate($request, [
                'username' => 'bail|required|min:6|unique:users,username,'.$user->id,
                'name' => 'bail|required',
                'email' => 'bail|required|email',
            ]);

            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();
        } else {
            $this->validate($request, [
                'username' => 'bail|required|min:6|unique:users,username,'.$user->id,
                'name' => 'bail|required',
                'email' => 'bail|required|email',
                'password' => 'bail|required|min:6|confirmed',
            ]);

            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
        }

        flash()->success('Account updated');
        return redirect()->route('settings');
    }

	public function mapDept(Request $request)
	{
		$this->authorize('access', Setting::class);
		$this->validate($request, [
            'user' => 'required',
            'pid' => 'required',
            'department' => 'required',
            'counter' => 'required',
        ]);
        $x = User::where('counter_id', $request->counter)
            //->where('department_id', $request->department)
		    ->where('role', 'D')
		    ->count();
		    if($x > 0){
			flash()->warning('This Room Already Allotted, Please Add Room Number');
			return redirect('users');
		    }
		$user_id = $request->user;
		$users = User::find($user_id);
		$users->pid = $request->pid;
        $users->department_id = $request->department;
        $users->counter_id = $request->counter;
		$users->save();
		flash()->success('Department updated');
        return redirect('users');
    }
    
    public function companyUpdate(Request $request)
    {
        $this->authorize('access', Setting::class);

        $this->validate($request, [
            'name' => 'bail|required',
            'email' => 'bail|email',
        ]);

        $settings = $this->settings->getSettings();
        $settings->name = $request->name;
        $settings->address = $request->address;
        $settings->email = $request->email;
        $settings->phone = $request->phone;
        $settings->location = $request->location;
        $settings->save();

        flash()->success('Company updated');
        return redirect()->route('settings');
    }

    public function overmissedUpdate(Request $request)
    {
        $this->authorize('access', Setting::class);

        $this->validate($request, [
            'over_time' => 'bail|required|numeric',
            'missed_time' => 'bail|required|numeric',
        ]);

        $settings = $this->settings->getSettings();
        $settings->over_time = $request->over_time;
        $settings->missed_time = $request->missed_time;
        $settings->save();

        flash()->success('Settings updated');
        return redirect()->route('settings');
    }

    public function localeUpdate(Request $request)
    {
        $this->authorize('access', Setting::class);

        $this->validate($request, [
            'language' => 'bail|required|exists:languages,id',
        ]);

        $settings = $this->settings->getSettings();
        $settings->language_id = $request->language;
        $settings->save();

        $locale = Language::find($request->language);
        $request->session()->put('locale', $locale->code);

        flash()->success('Language updated');
        return redirect()->route('settings');
    }

    public function postUserdept(Request $request)
    {   //$pid_id = ParentDepartment::find($request->id);
        //$aid = Auth::user()->pid;
        //$usermap = ParentDepartment::find($request->id);
        $usermap = DB::table('parent_departments')
            ->join('users', 'parent_departments.id', '=', 'users.pid')
            //->where('users.id', $reques->$aid )
            ->select('parent_departments.name')
            ->where('users.pid', $pid_id)
            ->get();
        return $usermap->toJson();
        
    }
	
	public function postPdept(Request $request)
    { 
		$department = Department::where('pid', $request->pid)->get();
        return $department->toJson();
    }

    public function postCgdept(Request $request)
    { 
		$counter = Counter::where('pid', $request->pid)->get();
        return $counter->toJson();
    }



    public function assignroom($id = "")
    {
        $this->authorize('access', Setting::class);
        $user_details = User::find($id);
        return view('user.settings.assignroom', [
            'settings' => $this->settings->getSettings(),
            'users' => $this->settings->getSingleUsers($id),
			'pdepartments' => $this->settings->getSinglePDepartments($user_details->pid),
            'departments' => $this->settings->getSingleDepartments($user_details->department_id),
            'counters' => $this->settings->getCountersByPid($user_details->id, $user_details->pid, $user_details->department_id, $user_details->counter_id),
            'user_details' => $user_details
        ]);
    }



}
