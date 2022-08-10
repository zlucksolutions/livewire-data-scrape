<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <table class="table table-hover">
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
