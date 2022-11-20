<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkRequest;
use App\Models\Mark;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $qb = Mark::query();

        $page_size = $request->has('page_size') ? $request->page_size : 15;

        if ($request->has('q')) {
            $qb->where(function($query) use ($qb, $request) {
                $query->where('mark_name', 'Like', '%' . $request->q. '%');
            });
        }

        if ($request->has('filter'))
            $qb->where(
                $request->get('filter', 'mark_name'),
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(MarkRequest $request)
    {
        return response()->json(Mark::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Mark::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MarkRequest $request, $id)
    {
        $mark = Mark::find($id);
        $mark->fill($request->all());
        $mark->save();
        return $mark;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return
     */
    public function destroy($id)
    {
        $status = Mark::destroy($id);
        if ($status === 0)
            return response()->json(['message' => "Erro ao excluir registro"], 404);
        return response()->json(['message' => "Registro excluído com sucesso"], 200);
    }
}
