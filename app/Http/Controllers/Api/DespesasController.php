<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Despesas;


class DespesasController extends Controller
{
    protected $despesas;

    public function __construct(Despesas $despesas)
    {
        $this->despesas = $despesas;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        // Buscando  e retornando todas as despesas do usuário autenticado
        $despesas = Despesas::CodigoUsuario($user_id)->get();
        
        return response()->json($despesas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data_vencimento' => 'required|date|max:255',
            'status' => 'required|string|in:pago,pendente,atrasado',
        ]);


        $user_id = $request->user()->id;
        $data = $request->all();
        $data['user_id'] = $user_id;

       
        if (!isset($data['valor']) && empty($data['valor'])) {
            $data['valor'] = 0.00;
        }

        $dados = Despesas::create($data);

        return response()->json(['mensagem' => 'Despesa cadastrada com sucesso!', 'despesa' => $dados]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
