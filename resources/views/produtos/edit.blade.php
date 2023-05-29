@extends('layouts.app')
@section('content')
<main class="container">
    <section>
        <form method="post" action="{{ route('produtos.update', $produto->id)}}" enctype="multipart/form-data">

            @csrf
            @method('PUT') {{-- vai ajudar a atualizar as informações --}}

            <div class="titlebar">
                <h1>Altere o Produto</h1>
                <button>Salvar</button>
            </div>

            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="card">
                <div>
                    <label>Nome</label>
                    <input type="text" name="nome" value="{{$produto->nome}}">

                    <label>Descrição (Opcional)</label>
                    <textarea cols="10" rows="5" name="descricao" aria-valuemax="{{$produto->descricao}}">{{$produto->descricao}}</textarea>

                    <label>Adicionar Imagem</label>
                    <img src="{{asset('imagens/'.$produto->imagem)}}" alt="" class="img-product" id="imagem" />
                   
                    <input type="hidden" name="imagem_atual" value="{{$produto->imagem}}"> {{--vai ajudar a ocutar a imagem antiga para mostrar a atual--}}
                    <input type="file" name="imagem" accept="image/*"  onchange="showFIle(event)">
                </div>
                <div>
                    <label>Categoria</label>
                    <select name="categoria">

                        @foreach (json_decode('{"Smartphone":"Smartphone","Smart TV":"Smart TV","Computer":"Computer"}', true) as $optionKey => $optionValue)
                        <option value="{{ $optionKey }} " {{ isset($produto->categoria) && ($produto->categoria == $optionKey) ? 'selected' : ''}} >{{ $optionValue}}</option>
                        @endforeach

                    </select>
                    <hr>

                    <label>Inventário</label>
                    <input type="text" class="input" name="quantidade" value="{{$produto->quantidade}}">
                    <hr>

                    <label>Valor R$</label>
                    <input type="text" class="input" name="valor" value="{{$produto->valor}}">
                </div>
            </div>
            <div class="titlebar">
                <h1></h1>
                <input type="hidden" name="hidden id" value="{{$produto->id}}">
                <button>Salvar</button>
            </div>
        </form>
    </section>
</main>
<script>
    function showFIle(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function() {
            var dataURL = reader.result;
            var output = document.getElementById('imagem');
            output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endsection
