<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateSupportRequest;
use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Support $support)
    {
        $supports = $support->all();

        return view('admin/supports/index', compact('supports'));
    }

    public function show(string|int $id)
    {
        // Support::find($id) //Buscar registro pelo id
        // Support::where('id', $id) ou Support::where('nome', '=', 'teste') ou Support::where('id', $id)->first()
        if(!$support = Support::find($id)) {
            return back();
        }

        return view('admin/supports/show', compact('support'));
    }

    public function create()
    {
        return view('admin/supports/create');
    }

    public function store(StoreUpdateSupportRequest $request, Support $support)
    {
        //$data['titulo'] = $request->subject;
        //$data['descricao'] = $request->body;
        $data = $request->validated();
        $data['status'] = 'a';

        $support = $support->create($data);

        return redirect()->route('supports.index');
    }

    public function edit(Support $support, string|int $id)
    {
        if(!$support = $support->where('id', $id)->first()) {
            return back();
        }

        return view('admin/supports/edit', compact('support'));
    }

    public function update(StoreUpdateSupportRequest $request, Support $support, string|int $id)
    {
        if(!$support = $support->where('id', $id)->first()) {
            return back();
        }

        //$support->subject = $request->subject;
        //$support->body = $request->body;
        //$support->save();

        $support->update($request->only(['subject', 'body']));

        return redirect()->route('supports.index');
    }

    public function destroy(Support $support, string|int $id)
    {
        if(!$support = $support->find($id)) {
            return back();
        }

        $support->delete($id);

        return redirect()->route('supports.index');
    }
}
