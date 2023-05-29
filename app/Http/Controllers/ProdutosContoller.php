<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produtos;

class ProdutosContoller extends Controller
{

    // definindo quantos itens por pag terá e permitindo ter o metodo de busca do produto
    public function index(Request $request)
    {
        // $produtos = Produtos::orderby('created_at')->get();
        $chaveMundo = $request->get('search');
        $porPagina = 5;

        if (!empty($chaveMundo)) {
            $produtos = Produtos::where('nome', 'LIKE', "%$chaveMundo%")->orWhere('categoria', 'LIKE', "%$chaveMundo%")->latest()->paginate($porPagina);
        } else {
            $produtos = Produtos::latest()->paginate($porPagina);
        }
        return view('produtos.index', ['produtos' => $produtos])->with('1', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('produtos.create');
    }

    // cadastrar
    public function store(Request $request)
    {

        $request->validate(
            [
                'nome' => 'required',
                'imagem' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2028'

            ]
        );

        $pasta = time() . '.' . request()->imagem->Extension();
        request()->imagem->move(public_path('imagens'), $pasta); //para salvar a imagem em uma pasta

        //puxando as variaveís do banco de dados e do input para ser salvos no banco de dados.
        $produtos = new Produtos;
        $produtos->nome = $request->nome;
        $produtos->descricao = $request->descricao;
        $produtos->imagem = $pasta;
        $produtos->categoria = $request->categoria;
        $produtos->quantidade = $request->quantidade;
        $produtos->valor = $request->valor;

        $produtos->save(); //salvar no banco de dados
        return redirect()->route('produtos.index')->with('SUCESSO', 'Produto Cadastrado com SUCESSO'); //redireciona para a pagina principal

    }

    public function edit($id)
    {
        $produtos = Produtos::findOrFail($id);
        return view('produtos.edit', ['produto' => $produtos]); //funcao para acessar a alteração do produto
    }


    // alterar
    public function update(Request $request, Produtos $produtos)
    {
        $request->validate([
            'nome' => 'required'
        ]);

        $pasta = $request->hidden_produtos_imagem;
        if ($request->imagem != '') {
            $pasta = time() . '.' . request()->imagem->Extension();
            request()->imagem->move(public_path('imagens'), $pasta);
        }
        $produtos = Produtos::find($request->hidden_id);

        $produtos->nome = $request->nome;
        $produtos->descricao = $request->descricao;
        $produtos->imagem = $pasta;
        $produtos->categoria = $request->categoria;
        $produtos->quantidade = $request->quantidade;
        $produtos->valor = $request->valor;

        $produtos->save();
        return redirect()->route('produtos.index')->with('Sucesso', 'Produto Alterado com Sucesso');
    }
    public function destroy($id){
        $produtos = Produtos::findOrFail($id);  
        $pasta = public_path()."/imagens/";
        $imagem = $pasta. $produtos->imagem;
        if(file_exists($imagem)){
            @unlink($imagem);
        }
        $produtos->delete();
        return redirect('produtos')->with('Produto deletado!');
    }
}
