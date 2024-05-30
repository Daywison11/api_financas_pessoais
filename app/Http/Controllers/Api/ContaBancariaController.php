<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use  App\Models\ContasBancarias;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class ContaBancariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $contabancaria;

    public function __construct(ContasBancarias $contabancaria)
    {
        $this->contabancaria = $contabancaria;
    }

    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        // Buscando todas as contas bancárias do usuário autenticado
        $contas = ContasBancarias::CodigoUsuario($user_id)->get();

        // Retornando as contas bancárias como resposta JSON
        return response()->json($contas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'tipo_conta' => 'required|string|max:255',
            'banco' => 'required|string|max:255',
            'numero_conta' => 'required|string|max:255',
            'saldo' => 'required|numeric',
        ]);


        $user_id = $request->user()->id;
        $data = $request->all();
        $data['user_id'] = $user_id;

        $existe = ContasBancarias::CodigoUsuario($user_id)->where('numero_conta', $data['numero_conta'])->exists();


        // var_dump($data['numero_conta']);exit;

        if ($existe) {

            return response()->json(['mensagem' => 'Número da conta já cadastrado'], 409);
        }

        if (!isset($data['saldo']) && empty($data['saldo'])) {
            $data['saldo'] = 0.00;
        }

        $dados = ContasBancarias::create($data);

        return response()->json(['mensagem' => 'Conta cadastrada com sucesso!', 'conta' => $dados]);
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
        

        $user_id = $request->user()->id;
        $data = $request->all();
        $data['user_id'] = $user_id;


        $conta = ContasBancarias::CodigoUsuario($user_id)->find($id);


        if ($conta) {

            // Verificar se o número da conta já existe para o usuário, excluindo o ID atual
            $existe = ContasBancarias::codigoUsuario($user_id)
                ->where('numero_conta', $data['numero_conta'])
                ->where('id', '!=', $id)
                ->exists();

            if($existe){
                return response()->json(['mensagem' => 'Número da conta já cadastrado em outra conta'], 409);
            }

            if (!isset($data['saldo']) && empty($data['saldo'])) {
                $data['saldo'] = 0.00;
            }

            $conta->update($data);


            return response()->json(['mensagem' => 'Conta atualizada com sucesso!', 'conta' => $conta]);
        } else {
            return response()->json(['mensagem' => 'Conta não encontrada'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {

        $user_id = $request->user()->id;
        $data = $request->all();
        $data['user_id'] = $user_id;


        $conta = ContasBancarias::CodigoUsuario($user_id)->find($id);

        if ($conta) {

            $dados = $conta->delete($conta);

            return response()->json(['mensagem' => 'Conta deletada com sucesso!', 'conta' => $conta]);
        } else {
            return response()->json(['mensagem' => 'Conta não encontrada'], 404);
        }
    }
}
