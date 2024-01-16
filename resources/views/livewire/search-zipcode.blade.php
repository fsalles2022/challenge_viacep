<div>
    <h1 class="mx-auto p-2 text-center">Buscador de endereço por Cep</h1>
    <form class="container mb-3">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="zipcode" type="text" wire:model.lazy="zipcode"
                placeholder="name@example.com" maxlength="9">
            <label for="zipcode">Cep</label>

            @error('zipcode')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            @if ($invalidResponse)
                <div class="alert alert-danger">
                    <p><strong>Erro:</strong></p>
                    <pre>{{ $invalidResponse }}</pre>
                </div>
            @endif

        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="street" type="text" wire:model="street"
                placeholder="name@example.com">
            <label for="street">Rua</label>
            @error('street')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="number" type="text" wire:model="number"
                placeholder="name@example.com">
            <label for="number">Nº</label>
            @error('number')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="complement" type="text" wire:model="complement"
                placeholder="name@example.com">
            <label for="complement">Complemento</label>
            @error('complement')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="neighborhood" type="text" wire:model="neighborhood"
                placeholder="name@example.com">
            <label for="neighborhood">Bairro</label>
            @error('neighborhood')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="city" type="text" wire:model="city" wire:model="city"
                placeholder="name@example.com">
            <label for="city">Cidade</label>
            @error('city')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="state" type="text" wire:model="state"
                wire:model="state" placeholder="name@example.com">
            <label for="state">Estado</label>
            @error('state')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="ddd" type="text" wire:model="ddd" wire:model="ddd"
                placeholder="name@example.com">
            <label for="ddd">DDD</label>
            @error('ddd')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
        <div>
            <button type="button" class="btn btn-success" type="button" wire:click="save">Cadastrar</button>

            <button type="button" class="btn btn-danger" type="button" wire:click="cancel">Cancelar</button>
        </div>

    </form>
    
    <hr>
    <div class="container">

        <table class="table table-striped table-hover table-success container">
            @if (session('mensagem'))
                <div id="mensagem" class="alert alert-success">
                    {{ session('mensagem') }}
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('mensagem').style.display = 'none';
                    }, 2000); // 2000 milissegundos = 2 segundos
                </script>
            @endif
            <thead>
                <tr>
                    {{-- <th scope="col">#</th> --}}
                    <th scope="col">CEP</th>
                    <th scope="col">Logradouro</th>
                    <th scope="col">Nº</th>
                    <th scope="col">Complemento</th>
                    <th scope="col">Bairro</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Estado - UF</th>
                    <th scope="col">DDD</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($addresses as $address)
                    <tr>
                        <td>{{ $address['zipcode'] }}</td>
                        <td>{{ $address['street'] }}</td>
                        <td>{{ $address['number'] }}</td>
                        <td>{{ $address['complement'] }}</td>
                        <td>{{ $address['neighborhood'] }}</td>
                        <td>{{ $address['city'] }}</td>
                        <td>{{ $address['state'] }}</td>
                        <td>{{ $address['ddd'] }}</td>

                        <div class="grid gap-3">

                            <td class="p-2 g-col-6">

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary"
                                        wire:click="edit({{ $address['id'] }}) ">Editar</button>
                                    <button type="button" class="btn btn-danger"
                                        wire:click="remove({{ $address['id'] }})">Exclur</button>
                                </div>
                            </td>
                        </div>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
