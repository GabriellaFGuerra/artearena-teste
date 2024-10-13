<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Contas a Pagar e Receber') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{
                    bills: [],
                    search: '',
                    filteredBills: [],
                    currentPage: 1,
                    pageSize: 10,
                    sortColumn: '',
                    sortDirection: 'asc',
                    get paginatedBills() {
                        const start = (this.currentPage - 1) * this.pageSize;
                        const end = this.currentPage * this.pageSize;
                        return this.filteredBills.slice(start, end);
                    },
                    get totalPages() {
                        return Math.ceil(this.filteredBills.length / this.pageSize);
                    },
                    init() {
                        fetch('{{ route('bills.index', ['client_side' => true]) }}')
                            .then(response => response.json())
                            .then(data => {
                                this.bills = data;
                                this.filteredBills = this.bills;
                                console.log('Bills:', this.bills);
                            });
                    },
                    filterBills() {
                        const searchLower = this.search.toLowerCase();
                        this.filteredBills = this.bills.filter(bill => {
                            const status = bill.status === 'paid' ? 'pago' : 'pendente';
                            return bill.title.toLowerCase().includes(searchLower) ||
                                bill.description.toLowerCase().includes(searchLower) ||
                                (bill.user && bill.user.name.toLowerCase().includes(searchLower)) ||
                                bill.amount.toString().includes(searchLower) ||
                                status.includes(searchLower);
                        });
                        this.currentPage = 1;
                        this.sortBills();
                    },
                    sortBills() {
                        if (this.sortColumn) {
                            this.filteredBills.sort((a, b) => {
                                let aValue = a[this.sortColumn];
                                let bValue = b[this.sortColumn];
                
                                if (this.sortColumn === 'user') {
                                    aValue = a.user.name;
                                    bValue = b.user.name;
                                } else if (this.sortColumn === 'due_date') {
                                    aValue = new Date(a.due_date);
                                    bValue = new Date(b.due_date);
                                }
                
                                if (aValue < bValue) return this.sortDirection === 'asc' ? -1 : 1;
                                if (aValue > bValue) return this.sortDirection === 'asc' ? 1 : -1;
                                return 0;
                            });
                        }
                    },
                    setSort(column) {
                        if (this.sortColumn === column) {
                            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                        } else {
                            this.sortColumn = column;
                            this.sortDirection = 'asc';
                        }
                        this.sortBills();
                    },
                    nextPage() {
                        if (this.currentPage < this.totalPages) {
                            this.currentPage++;
                        }
                    },
                    prevPage() {
                        if (this.currentPage > 1) {
                            this.currentPage--;
                        }
                    }
                }" x-init="init()">

                    <div class="mb-4">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Search
                        </label>
                        <input type="text" id="search" name="search"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            x-model="search" @input="filterBills" placeholder="Search...">
                    </div>

                    <div class="mb-4">
                        <a href="{{ route('bills.create') }}"
                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Adicionar conta
                        </a>

                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('bills.report') }}"
                                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2h-7z" />
                                </svg>
                                Gerar relatório
                            </a>
                        @endif


                        <div class="overflow-x-auto relative">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 cursor-pointer"
                                            @click="setSort('due_date')">
                                            Vencimento
                                            <span x-show="sortColumn === 'due_date'">
                                                <span x-show="sortDirection === 'asc'">&uarr;</span>
                                                <span x-show="sortDirection === 'desc'">&darr;</span>
                                            </span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 cursor-pointer" @click="setSort('title')">
                                            Conta
                                            <span x-show="sortColumn === 'title'">
                                                <span x-show="sortDirection === 'asc'">&uarr;</span>
                                                <span x-show="sortDirection === 'desc'">&darr;</span>
                                            </span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 cursor-pointer"
                                            @click="setSort('description')">
                                            Descrição
                                            <span x-show="sortColumn === 'description'">
                                                <span x-show="sortDirection === 'asc'">&uarr;</span>
                                                <span x-show="sortDirection === 'desc'">&darr;</span>
                                            </span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 cursor-pointer" @click="setSort('amount')">
                                            Valor
                                            <span x-show="sortColumn === 'amount'">
                                                <span x-show="sortDirection === 'asc'">&uarr;</span>
                                                <span x-show="sortDirection === 'desc'">&darr;</span>
                                            </span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 cursor-pointer" @click="setSort('user')">
                                            Usuário
                                            <span x-show="sortColumn === 'user'">
                                                <span x-show="sortDirection === 'asc'">&uarr;</span>
                                                <span x-show="sortDirection === 'desc'">&darr;</span>
                                            </span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 cursor-pointer" @click="setSort('status')">
                                            Status
                                            <span x-show="sortColumn === 'status'">
                                                <span x-show="sortDirection === 'asc'">&uarr;</span>
                                                <span x-show="sortDirection === 'desc'">&darr;</span>
                                            </span>
                                        </th>
                                        <th scope="col" class="px-6 py-3">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="bill in paginatedBills" :key="bill.id">
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-6 py-4"
                                                x-text="(() => { 
                                                            let date = new Date(bill.due_date); 
                                                            date.setMinutes(date.getMinutes() + date.getTimezoneOffset()); 
                                                            return date.toLocaleDateString('pt-BR'); 
                                                        })()">
                                            </td>
                                            <td class="px-6 py-4" x-text="bill.title"></td>
                                            <td class="px-6 py-4" x-text="bill.description"></td>
                                            <td class="px-6 py-4" x-text="bill.amount"></td>
                                            <td class="px-6 py-4" x-text="bill.user ? bill.user.name : 'N/A'"></td>
                                            <td class="px-6 py-4" x-text="bill.status === 'paid' ? 'Pago' : 'Pendente'">
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex space-x-2">
                                                    <x-secondary-button x-bind:href="`/bills/${bill.id}/edit`">
                                                        Editar
                                                    </x-secondary-button>
                                                    <form x-bind:action="`/bills/${bill.id}`" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-danger-button type="submit">
                                                            Deletar
                                                        </x-danger-button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <button @click="prevPage" :disabled="currentPage === 1"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md disabled:opacity-50">
                                Previous
                            </button>
                            <span>Page <span x-text="currentPage"></span> of <span x-text="totalPages"></span></span>
                            <button @click="nextPage" :disabled="currentPage === totalPages"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md disabled:opacity-50">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
