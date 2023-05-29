<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tela de cadastro de produto</title>
</head>
<body>
@extends('layouts.app')
@section('content')
    <main class="container">
        <section>
            <form method="post" action="{{ route('produtos.store') }}" enctype="multipart/form-data">

                @csrf

                <div class="titlebar">
                    <h1>Adionar Produto</h1>
                    <button><a style="text-decoration: none;" href="{{ route('produtos.index') }}">Voltar</a></button>
                </div>

                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div>
                        <label>Nome</label>
                        <input type="text" name="nome">

                        <label>Descrição (Opcional)</label>
                        <textarea cols="10" rows="5" name="descricao"></textarea>

                        <label>Adicionar Imagem</label>
                        <img src="" alt="" class="img-product" id="imagem" />
                        <input type="file" name="imagem" accept="image/*" onchange="showFIle(event)">

                    </div>
                    <div>
                        <label>Categoria</label>
                        <select name="categoria">

                            @foreach (json_decode('{"Smartphone":"Smartphone","Smart TV":"Smart TV","Computer":"Computer"}', true) as $optionKey => $optionValue)
                                <option value="{{ $optionKey }}">{{ $optionValue }}</option>
                            @endforeach

                        </select>
                        <hr>

                        <label>Inventário</label>
                        <input type="text" class="input" name="quantidade">
                        <hr>

                        <label>Valor R$</label>
                        <input type="text" class="input" name="valor">
                    </div>
                </div>
                <div class="titlebar">
                    <h1></h1>
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


</body>

</html>
