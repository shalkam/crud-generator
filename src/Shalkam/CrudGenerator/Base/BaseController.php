<?php

namespace Shalkam\CrudGenerator\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller {

    public $params = ['form_data' =>''];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $class = $this->params['model'];
        $entries = $class::all();
        return view("{$this->params['tpl_path']}.list", compact('entries'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $class = $this->params['model'];
        $entry = $class::find($id);
        $params = $this->params;
        return view("{$this->params['tpl_path']}.details", compact('entry', 'params'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $class = $this->params['model'];
        $model = new $class;
        $form = \FormBuilder::create($this->params['form'], [
                    'method' => 'POST',
                    'model' => $model,
                    'url' => route("{$this->params['route']}.store"),
                    'data' => $this->params['form_data']
        ]);
        return view("{$this->params['tpl_path']}.edit", compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $class = $this->params['model'];
        $entry = $class::create($request->input());
        return redirect(route("{$this->params['route']}.show", [$entry->id]))->with('message', '<div class="alert alert-success col-md-10 col-md-offset-1">New ' . $this->params['name'] . ' Added</div>');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $class = $this->params['model'];
        $entry = $class::find($id);
        $form = \FormBuilder::create($this->params['form'], [
                    'method' => 'PUT',
                    'model' => $entry,
                    'url' => route("{$this->params['route']}.update", [$id]),
                    'data' => $this->params['form_data']
        ]);
        return view("{$this->params['tpl_path']}.edit", compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request) {
        $class = $this->params['model'];
        $entry = $class::find($id);
        $entry->fill($request->input())->save();
        return redirect(route("{$this->params['route']}.show", [$id]))->with('message', '<div class="alert alert-info col-md-10 col-md-offset-1">' . $this->params['name'] . ' updated</div>');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $class = $this->params['model'];
        $entry = $class::find($id)->delete();
        return redirect($this->params['route'])->with('message', '<div class="alert alert-danger col-md-10 col-md-offset-1">Patient deleted</div>');
    }

}
