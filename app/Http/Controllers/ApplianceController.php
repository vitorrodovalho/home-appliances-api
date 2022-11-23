<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplianceRequest;
use App\Http\Requests\ApplianceUpdateRequest;
use App\Models\Appliance;
use Illuminate\Http\Request;

class ApplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    /*public function index(Request $request)
    {
        $qb = Appliance::query();

        $page_size = $request->has('page_size') ? $request->page_size : 15;

        if ($request->has('q')) {
            $qb->where(function($query) use ($qb, $request) {
                $query->where('appliance_name', 'Like', '%' . $request->q. '%');
                $query->orWhere('appliance_description', 'Like', '%' . $request->q . '%');
            });
        }

        if ($request->has('filter'))
            $qb->where(
                $request->get('filter', 'appliance_name'),
                $request->get('operator', '='),
                $request->get('value', '0')
            );

        if ($request->has('sortBy'))
            $qb->orderBy(
                $request->get('sortBy'),
                $request->get('direction', 'ASC')
            );

        if ($request->has('min_id'))
            $qb->where('id', '>=', $request->min_id);

        if ($request->has('max_id'))
            $qb->where('id', '<=', $request->max_id);

        return $qb->paginate($page_size);
    }*/

    public function index(Request $request)
    {
        $columns = array(
            0 =>'id',
            1 =>'name',
            2=> 'description',
            3=> 'voltage'
        );

        $totalData = Appliance::count();
        $totalFiltered = $totalData;

        $limit = $request->has('length') ? $request->input('length') : 20;
        $start = $request->has('start') ? $request->input('start') : 0;
        $order = $request->has('order.0.column') ? $columns[$request->input('order.0.column')] : 'id';
        $dir = $request->has('order.0.dir') ? $request->input('order.0.dir') : 'asc';
        $search = $request->input('search.value');

        $qb = Appliance::query();
        if(!empty($request->input('search.value')))
        {
            $qb->where(function($query) use ($search) {
                $query->whereRaw("CONCAT_WS(\" \", name,description) REGEXP '{$search}'");
            });
        }

        $totalFiltered = $qb->count();
        $qb->offset($start);
        $qb->limit($limit);
        $qb->orderBy($order,$dir);
        $appliances = $qb->get();

        $data = array();
        if(!empty($appliances))
        {
            foreach ($appliances as $appliance)
            {
                $nestedData['id'] = $appliance->id;
                $nestedData['name'] = $appliance->name;
                $nestedData['description'] = $appliance->description;
                $nestedData['voltage'] = $appliance->voltage;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        return json_encode($json_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param
     * @return
     */
    public function store(ApplianceRequest $request)
    {
        return response()->json(Appliance::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Appliance::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApplianceUpdateRequest $request, $id)
    {
        $appliance = Appliance::find($id);
        $appliance->fill($request->all());
        $appliance->save();
        return $appliance;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return
     */
    public function destroy($id)
    {
        $status = Appliance::destroy($id);
        if ($status === 0)
            return response()->json(['message' => "Erro ao excluir registro"], 404);
        return response()->json(['message' => "Registro excluído com sucesso"], 200);
    }
}
