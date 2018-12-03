<?php
namespace App\Http\Controllers\BackEnd\Document;
use App\Http\Controllers\BackendController;
use App\Repositories\Document\PrivateSectorRepository;
use App\Models\BackEnd\Document\PrivateSectorModel;
use Illuminate\Http\Request;
use App\Http\Requests\Document\PrivateSectorRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class PrivateSectorController extends BackendController
{
    protected $repository;
    protected $privateSector;

    public function __construct(PrivateSectorRepository $reposi, PrivateSector $PrivateSector){
        parent::__construct();
        $this->privateSector = $PrivateSector;
        $this->repository = $reposi;
    }

    public function getIndex()
    {
        return view($this->viewFolder.'.document.private-sector.index')->with($this->data);
    }

    public function postNew(Request $request){
        return view($this->viewFolder.'.document.private-sector.new')->with($this->data);
    }

    public function postSave(PrivateSectorRequest $request){
        $this->privateSector->fill(request()->all());
        $this->privateSector->save();
        return("ជោគជ័យ");
    }

//    public function store(Request $request)
//    {
//        $this->room->fill(request()->all());
//        $this->room->save();
//    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
