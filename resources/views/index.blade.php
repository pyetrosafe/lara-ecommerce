@extends('layouts.app')

@section('content')

    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-header card-header-master border-0">
            <h4 class="mb-0">As Melhores Ofertas</h4>
        </div>

        <div class="card-footer border-0">
            <form name="orderby" id="orderby" action="" method="GET" >
              {{-- @csrf --}}
              <div class="form-group row">
                <label class="col-auto col-form-label" for="orderby">Ordenar por: </label>
                <div class="col-auto">
                  <select name="orderby" class="form-control" id="orderby">
                    <option {{ ($orderby == 'latest' ? 'selected' : '') }} value="latest">Mais Recentes</option>
                    <option {{ ($orderby == 'best-selling' ? 'selected' : '') }} value="best-selling">Mais Vendidos</option>
                    <option {{ ($orderby == 'price-asc' ? 'selected' : '') }} value="price-asc">Preço Menor para Maior</option>
                    <option {{ ($orderby == 'price-desc' ? 'selected' : '') }} value="price-desc">Preço Maior para Menor</option>
                    <option {{ ($orderby == 'name-asc' ? 'selected' : '') }} value="name-asc">Nome A para Z</option>
                    <option {{ ($orderby == 'name-desc' ? 'selected' : '') }} value="name-desc">Nome Z para A</option>
                  </select>
                </div>
              </div>
            </form>
        </div>
    </div>

    <div class="row row-card-deck text-center">
        @foreach($produtos as $item)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <div class="card mb-4">
              <div class="card-body">
                <img class="card-img-top" src="{{ Storage::url($item->imagem) }}" alt="Carregando imagem...">
              </div>
              <div class="card-footer">
                  <p class="card-text">{{ str_limit($item->nome, 50) }}</p>
                  <h5 class="card-title pricing-card-title text-danger">
                    @if ($item->quantidade > 0)
                      R$ {{ number_format($item->valor, 2, ',', '.') }}
                    @else
                      Indisponível
                    @endif
                  </h5>
                  @if ($item->quantidade > 0)
                    <a href="{{ url('/').'/carrinho/'.$item->id  }}" type="button" class="btn btn-lg btn-block btn-primary">Comprar</a>
                  @else
                    <span type="button" class="btn btn-lg btn-block btn-secondary">Comprar</span>
                  @endif
              </div>
          </div>
        </div>
        @endforeach
    </div>
@endsection

@section('custom_js')
    <script src="{{ asset('js/index.js') }}"></script>
@endsection
