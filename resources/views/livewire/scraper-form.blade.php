<div>
    {{-- Do your work, then step back. --}}
    <h2 class="text-3xl font-bold">Enter url to scrape</h2>
    <form method="post" class="mt-4" wire:submit.prevent="scrape">
        @if(session()->has("success"))
            <div class="bg-green-600 text-white rounded p-4 flex justify-start items-center">
                <span>
                    {{ session("success") }}
                </span>
            </div>
        @endif
        <div class="flex flex-col mb-4">
            <label class="mb-2 uppercase font-bold text-lg text-grey-darkest">Url</label>
            <input type="text" wire:model.debounce.500ms="url" class="border border-gray-400 py-2 px-3 text-grey-darkest placeholder-gray-500" name="url" id="url" placeholder="Url..." />
            @error('url') <span class="text-red-700">{{ $message }}</span> @enderror
            <button type="submit" wire:loading.attr="disabled" class="btn btn-secondary block bg-red-400 hover:bg-teal-dark mx-auto rounded ">Add to queue</button>
        </div>
    </form>
    @if($startScrape)
        <p>Products will be loaded shorlty! don't close the page...</p>
    @endif
    <div wire:poll.20s="onProductFetch">
        <table class="table table-hover datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start Date</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['position'] }}</td>
                    <td>{{ $product['office'] }}</td>
                    <td>{{ $product['age'] }}</td>
                    <td>{{ $product['start_date'] }}</td>
                    <td>{{ $product['salary'] }}</td>
                </tr>
                @endforeach        
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right">
                        {{ $products->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
