<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Editar conta') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="text-gray-900 dark:text-gray-100">
                <x-forms.bill-form :bill="$bill" :action="route('bills.update', $bill)">
                    @method('put')
                    <div class="grid grid-cols-1 gap-6">
                        <div class="grid-cols-1">
                            <x-input-label for="title" :value="__('Título')" class="mb-2" />
                            <x-text-input id="title" name="title" type="text" class="block w-full mt-1"
                                :value="old('title', $bill->title)" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div class="grid-cols-1">
                            <x-input-label for="description" :value="__('Descrição')" class="mb-2" />
                            <x-text-input id="description" name="description" type="text" class="block w-full mt-1"
                                :value="old('description', $bill->description)" required autofocus autocomplete="description" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col">
                            <x-input-label for="amount" :value="__('Valor')" class="mb-2" />
                            <x-text-input type="number" id="amount" name="amount" class="block w-full mt-1"
                                :value="old('amount', $bill->amount)" required autofocus autocomplete="amount" />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>
                        <div class="flex flex-col">
                            <x-input-label for="due_date" :value="__('Data de Vencimento')" class="mb-2" />
                            <x-text-input type="date" id="due_date" name="due_date" class="block w-full mt-1"
                                :value="old('due_date', $bill->due_date)" required autofocus autocomplete="date" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <x-input-label for="status" :value="__('Status')" class="mb-2" />
                        <x-select-input class="block w-full mt-1" id="status" name="status">
                            <option value="paid" {{ $bill->status == 'paid' ? 'selected' : '' }}>Pago</option>
                            <option value="pending" {{ $bill->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                </x-forms.bill-form>
            </div>
        </div>
    </div>
</x-app-layout>
