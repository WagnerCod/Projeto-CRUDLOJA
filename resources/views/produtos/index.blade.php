<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>consultar produto</title>
</head>
<body>
    

@extends('layouts.app')
@section('content')
    <main class="container">
        <section>
            <div class="titlebar">
                <h1>Produtos</h1>
                <button><a href="{{ route('produtos.create') }}">Adicionar produto</a></button>
            </div>

            @if ($message = Session::get('Sucesso'))
                <script type="text/javascript">
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: '{{ $message }}'
                    })
                </script>
            @endif

            <div class="table">
                <div class="table-filter">
                    <div>
                        <ul class="table-filter-list">
                            <li>
                                <a href="{{ route('produtos.index') }}" class="table-filter-link link-active">Todos</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <form action="{{ route('produtos.index') }}"accept-charset="UTF-8" role="search" method="GET">
                    <div class="table-search">
                        <div>
                            <button class="search-select">
                                Procure o Produto
                            </button>
                            <span class="search-select-arrow">
                                <i class="fas fa-caret-down"></i>
                            </span>
                        </div>
                        <div class="relative">
                            <input class="search-input" type="text" name="search" placeholder="Procure o que deseja"
                                value="{{ request('search') }}" name="search">
                        </div>
                    </div>
                </form>

                <div class="table-product-head">
                    <p>Imagem</p>
                    <p>Nome</p>
                    <p>Categoria</p>
                    <p>Inventário</p>
                    <p>Ações</p>
                </div>
                <div class="table-product-body">
                    @if (count($produtos) > 0)
                        @foreach ($produtos as $produto)
                            <img src="{{ asset('imagens/' . $produto->imagem) }}" />
                            <p>{{ $produto->nome }}</p>
                            <p>{{ $produto->categoria }}</p>
                            <p>{{ $produto->quantidade }}</p>

                            <div style="display: flex">

                                <a class="btn btn-success alterar" href="{{ route('produtos.edit', $produto->id) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form method="post" action="{{ route('produtos.destroy', $produto->id) }}">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger deletar" onclick="deleteConfirm(event)">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>

                            </div>
                        @endforeach
                    @else
                        <p>Produto não encontrado</p>
                    @endif

                </div>
                <div class="table-paginate">
                    {{ $produtos->links('layouts.pagination') }}
                </div>
        </section>
    </main>
    <script>
        window.deleteConfirm = function(e) {
            e.preventDefault();
            var form = e.target.form;
            Swal.fire({
                title: 'VOCÊ TEM CERTEZA QUE QUER DELETAR??',
                text: "NÃO TEM COMO REVERTER O DELETE!",
                icon: 'CUIDADO',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar!!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deletado!',
                        'Seu arquivo foi deletado!!',
                        'success'
                    )
                    form.submit();
                }
            })
        }
    </script>
@endsection
</body>
</html>
