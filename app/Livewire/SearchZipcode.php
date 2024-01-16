<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Address;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;





use Livewire\Component;


class SearchZipcode extends Component
{

    public $invalidResponse;

    protected array $rules = [

        // 'zipcode' => 'required',
        'street' => 'required',
        'number' => 'required|max:5',
        'complement' => 'required|max:30',
        'neighborhood' => 'required',
        'city' => 'required',
        'state' => 'required|max:2',
        'ddd' => 'required|max:2',
    ];

    protected array $message = [
        // 'zipcode' => 'O campo é obrigatório',
        'street' => 'O campo é obrigatório',
        'number' => 'O campo é obrigatorio',
        'complement' => 'O campo é obrigatorio',
        'neighborhood' => 'O campo é obrigatório',
        'city' => 'O campo é obrigatório',
        'state' => 'O campo Esatdo deve ter dois caracteres (SP, MG, RJ) por exemplo',
        'ddd' => 'O campo Esatdo deve ter dois caracteres (11 - 31 -  21 ) por exemplo',


    ];

    public string   $zipcode = '';
    public string   $street = '';
    public string   $number = '';
    public string   $complement = '';
    public string   $neighborhood = '';
    public string   $city = '';
    public string   $state = '';
    public string   $ddd = '';
    public array $addresses = [];

    public function updatedZipcode(string $value)
    {



        $response = Http::get("https://viacep.com.br/ws/{$value}/json")->json();


        // Verifica se a resposta contém a chave 'cep'
        if (isset($response['cep'])) {
            $this->zipcode = $response['cep'];
            $this->street = $response['logradouro'];
            $this->neighborhood = $response['bairro'];
            $this->city = $response['localidade'];
            $this->state = $response['uf'];
            $this->ddd = $response['ddd'];
            $this->resetExcept('zipcode', 'street', 'neighborhood', 'city', 'state', 'ddd');
        } else {
            $this->resetExcept('addresses');
            // Passa a resposta inválida para a view
            $this->invalidResponse = 'Cep não encontrado na base de dados!';
        }
    }
    public function save()
    {
        $this->validate();

        if (isset($this->zipcode)) {
            Address::updateOrCreate(
                [
                    'zipcode' => $this->zipcode,
                ],
                [
                    'street' => $this->street,
                    'number' => $this->number,
                    'complement' => $this->complement,
                    'neighborhood' => $this->neighborhood,
                    'city' => $this->city,
                    'state' => $this->state,
                    'ddd' => $this->ddd,
                ]
            );

            $this->render();
            $this->resetExcept('addresses');
            return redirect()->route('SearchZipcode')->with('mensagem', 'Operação realizada com sucesso!');
        }
    }


    public function cancel()
    {

        // dd("chamou");
        return redirect()->route('SearchZipcode')->with('mensagem', 'Operação cancelada com sucesso!');
    }


    // public function mount(): void
    // {
    //     $this->addresses = Address::all()->toArray();
    // }


    public function edit(string $id)
    {
        $address = Address::find($id);

        $this->zipcode = $address->zipcode;
        $this->street = $address->street;
        $this->number = $address->number;
        $this->complement = $address->complement;
        $this->neighborhood = $address->neighborhood;
        $this->city = $address->city;
        $this->state = $address->state;
        $this->ddd = $address->ddd;
        
    }



    public function remove(string $id)
    {


        $address = Address::find($id);

        if ($address) {
            $address->update(['deleted_at' => null]); // Define o deleted_at como null
            session()->flash('mensagem', 'Endereço removido com sucesso.');
        } else {
            session()->flash('mensagem', 'Erro ao remover o endereço.');
        }

        $this->render(); // Move this line before the return statement

        return redirect()->route('SearchZipcode');
    }


    public function render()
    {
        $this->addresses = Address::all()->toArray();
        return view('livewire.search-zipcode');
    }
}
