@extends('layouts.app')

@section('content')
    <h3 class="page-title">Location Boost Prices</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            <form action="">
                <input type="search" name="q" value="{{ $keyword }}" placeholder="Search prices..." />
            </form>
        </div>
        <div class="--panel-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th style="min-width:150px;">Name</th>
                        <th>Postcode</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Environment</th>
                        <th>Options</th>
                        <th>Product Id</th>
                        <th>Price Id</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($items?->isNotEmpty())
                        @foreach ($items as $index => $item)
                            <tr>
                                <td>{{ ($page - 1) * $limit + ($index + 1) }}</td>
                                <td>
                                    <a href="{{ route('admin.location-boost-prices.edit', $item) }}">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td>{{ $item->postcode }}</td>
                                <td>
                                    <span class="label label-info">
                                        {{ $item->currency_code }} {{ $item->amount }}
                                    </span>
                                </td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->environment }}</td>
                                <td>
                                    <a href="{{ route('admin.location-boost-prices.edit', $item) }}"
                                        class="btn btn-xs btn-info">
                                        Edit
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" rel="noopener noreferrer nofollow"
                                        href="https://dashboard.stripe.com/products/{{ $item->stripe_product_id }}">
                                        {{ $item->stripe_product_id }}
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" rel="noopener noreferrer nofollow"
                                        href="https://dashboard.stripe.com/prices/{{ $item->stripe_price_id }}">
                                        {{ $item->stripe_price_id }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="100%">
                                No prices found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            {{ $items->onEachSide(2)->links() }}
        </div>
    </div>
@endsection
