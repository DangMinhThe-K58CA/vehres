<?php

namespace App\Http\Controllers\Partner;

use App\Http\Requests\AddingGarageRequest;
use App\Http\Requests\UpdateGarageLocationRequest;
use App\Models\AdministrationUnit;
use App\Models\Garage;
use Illuminate\Http\UploadedFile;
use MyHelper;
use App\Http\Requests\UpdateGarageRequest;
use App\Repositories\Contracts\GarageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GarageController extends Controller
{
    private $repository;

    public function __construct(GarageRepositoryInterface $repo)
    {
        $this->repository = $repo;
    }

    public function garageMaps(Request $request)
    {
        $id = $request->input('id');
        $garage = $this->repository->find($id);

//        dd($garage);

        return view('partners.garages.workingOnMaps', ['garage' => $garage]);
    }

    public function index(Request $request)
    {
        $status = $request->input('status');

        $garages = Auth::user()->garages()->where('status', $status)->paginate(config('common.paging_number'));

        return view('partners.garages.index', [
            'status' => $status,
            'garages' => $garages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tmpProvince = AdministrationUnit::where('parent_id', 0)->first();
        $tmpDistrict = $tmpProvince->children()->first();
        $adminUnits = $this->initAdministrationUnit($tmpProvince->id, $tmpDistrict->id);

        return view('partners.garages.create', $adminUnits);
    }

    private function initAdministrationUnit($provinceId, $districtId)
    {
        $data =  [
            'provinces' => null,
            'districts' => null,
            'wards' => null,
        ];
        $provincesObj = AdministrationUnit::where('parent_id', 0)->select('id', 'name')->get();
        $provinces = $this->stdSelectData($provincesObj);
        $data['provinces'] = $provinces;

        $tmpProvince = AdministrationUnit::find($provinceId);
        $districtsObj = $tmpProvince->children;
        $districts = $this->stdSelectData($districtsObj);
        $data['districts'] = $districts;

        $tmpDistrict = AdministrationUnit::find($districtId);
        if ($tmpDistrict === null) {
            return $data;
        }
        $wardsObj = $tmpDistrict->children;
        $wards = $this->stdSelectData($wardsObj);
        $data['wards'] = $wards;

        return $data;
    }
    private function stdSelectData($objects)
    {
        $stdArray = [];
        foreach ($objects as $std) {
            $stdArray[$std->id] = $std->name;
        }

        return $stdArray;
    }

    public function store(AddingGarageRequest $request)
    {
        $data = $request->except('avatar');
        $data['user_id'] = Auth::user()->id;
        if ($request->hasFile('avatar')) {
            $filePath = $this->uploadFile($request->file('avatar'));
            $data['avatar'] = $filePath;
        }

        foreach ($data as $key => $value) {
            if ($value === '') {
                $data[$key] = null;
            }
        }

        $newGarage = $this->repository->create($data);

        return redirect()->to(action('Partner\GarageController@show', ['garage' => $newGarage->id]))
            ->with('success', 'Your garage has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $garage = $this->repository->find($id);

        if ($garage === null) {
            abort(404, 'Garage\'s not found !');
        }

        $this->authorize('view', $garage);
//        if (! Auth::user()->can('view', $garage)) {
//            abort(401);
//        }

        $data = $this->initAdministrationUnit($garage->province_id, $garage->district_id);
        $data['garage'] = $garage;

        return view('partners.garages.showGarage', $data);
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

    public function uploadFile(UploadedFile $file)
    {
        return MyHelper::uploadFile($file);
    }

    public function updateLocation(UpdateGarageLocationRequest $request)
    {
        $id = $request->input('id');
        $garage = $this->repository->find($id);

        if ($garage !== null || Auth::user()->can('update', $garage)) {
            $latLng = $request->all();
            $result = $garage->update($latLng);

            if ($result === 1) {
                return \Response::json(['status' => '1', 'data' => null]);
            }
        }

        return \Response::json(['status' => -1, 'data' => [['error' => 'update_failed', 'message' => 'Something\'s wrong !']]]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGarageRequest $request, $id)
    {
        $garage = $this->repository->find($id);
        if ($garage === null) {
            abort(404, 'Garage\'s not found');
        }

        $this->authorize('update', $garage);
        
        if ($request->hasFile('avatar')) {
            $filePath = $this->uploadFile($request->file('avatar'));
            $garage->avatar = $filePath;
            $garage->save();
        }

        $data = $request->except(['avatar']);
        foreach ($data as $key => $value) {
            if ($value === '') {
                $data[$key] = null;
                if ($key === 'district_id') {
                    $data['ward_id'] = null;
                }
            }
        }
        $garage->update($data);

        return redirect()->to(action('Partner\GarageController@show', ['garage' => $garage->id]))
                ->with('success', 'Update success.');
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
