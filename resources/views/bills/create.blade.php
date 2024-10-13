<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Criar nova conta') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="text-gray-900 dark:text-gray-100" x-data="{
                users: [],
                searchQuery: '',
                selectedUserId: '{{ old('user_id') }}',
                isAdmin: {{ json_encode($isAdmin) }},
                init() {
                    if (this.isAdmin) {
                        this.fetchUsers();
                    }
                },
                fetchUsers() {
                    fetch('{{ route('users.search') }}?query=' + this.searchQuery)
                        .then(response => response.json())
                        .then(data => {
                            this.users = data;
                        });
                }
            }" x-init="init()">
                <x-forms.bill-form :action="route('bills.store')">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="grid-cols-1">
                            <x-input-label for="title" :value="__('Título')" class="mb-2" />
                            <x-text-input id="title" name="title" type="text" class="block w-full mt-1"
                                :value="old('title')" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div class="grid-cols-1">
                            <x-input-label for="description" :value="__('Descrição')" class="mb-2" />
                            <x-text-input id="description" name="description" type="text" class="block w-full mt-1"
                                :value="old('description')" required autofocus autocomplete="description" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col">
                            <x-input-label for="amount" :value="__('Valor')" class="mb-2" />
                            <x-text-input type="number" id="amount" name="amount" class="block w-full mt-1"
                                :value="old('amount')" required autofocus autocomplete="amount" />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>
                        <div class="flex flex-col">
                            <x-input-label for="due_date" :value="__('Data de Vencimento')" class="mb-2" />
                            <x-text-input type="date" id="due_date" name="due_date" class="block w-full mt-1"
                                :value="old('due_date')" required autofocus autocomplete="date" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <x-input-label for="status" :value="__('Status')" class="mb-2" />
                        <x-select-input class="block w-full mt-1" id="status" name="status">
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Pago</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                    @if ($isAdmin)
                        <div class="grid grid-cols-1">
                            <x-input-label for="user_id" :value="__('Usuário')" class="mb-2" />
                            <x-text-input type="text" id="user_search" name="user_search" class="block w-full mt-1"
                                x-model="searchQuery" @input="fetchUsers" placeholder="Pesquisar usuário..." />
                            <x-select-input class="block w-full mt-1" id="user_id" name="user_id"
                                x-model="selectedUserId">
                                <option value="" disabled selected>Selecione um usuário</option>
                                <template x-for="user in users" :key="user.id">
                                    <option :value="user.id" x-text="user.name"
                                        :selected="selectedUserId == user.id"></option>
                                </template>
                            </x-select-input>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </div>
                    @else
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @endif

                    <x-primary-button>{{ __('Criar') }}</x-primary-button>
                </x-forms.bill-form>
            </div>
        </div>
    </div>
</x-app-layout>
