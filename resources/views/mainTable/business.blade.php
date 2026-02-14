@extends('layouts.mainTable')

@section('content')

<section class="page-search">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Advance Search -->
				<div class="advance-search">
                    {{ html()->form('GET', action([App\Http\Controllers\HomePageController::class, 'table']))->open() }}

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                {{ html()->text('search', old('search'))->class('form-control')->placeholder('Search list') }}
                                <p class="help-block"></p>
                                @if($errors->has('name'))
                                    <p class="help-block">
                                        {{ $errors->first('name') }}
                                    </p>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                {{ html()->select('businesses', $search_businesses, null)->class('form-control form-control-lg')->placeholder('Business') }}
                                <p class="help-block"></p>
                                @if($errors->has('businesses'))
                                    <p class="help-block">
                                        {{ $errors->first('businesses') }}
                                    </p>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                {{ html()->select('city_id', $search_cities, null)->class('form-control form-control-lg')->placeholder('City') }}
                                <p class="help-block"></p>
                                @if($errors->has('city_id'))
                                    <p class="help-block">
                                        {{ $errors->first('city_id') }}
                                    </p>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <button type="submit"
                                        class="btn btn-primary">
                                        Search Now
                                </button>
                            </div>
                        </div>

                    {{ html()->form()->close() }}
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section-sm">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="search-result bg-gray">
					<h2>Results For "{{ $business->name }}"</h2>
					<p>{{ $business->lists->count() }} Results</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="category-sidebar">
					<div class="widget category-list">
                        <h4 class="widget-header">All Business</h4>
                        <ul class="category-list">
                            @foreach ( $businesses_all as $business_all)
                                <li><a href="{{ route('business', [$business_all->id]) }}">{{ $business_all->name}} <span>{{$business_all->lists->count()}}</span></a></li>
                            @endforeach
                        </ul>
                    </div>
				</div>
			</div>
           
			<div class="col-md-9">
				<div class="product-grid-list">
					<div class="row mt-30">
                         
                        @foreach ($listings as $listing)
                            <div class="col-sm-12 col-lg-4 col-md-6">
                                <!-- product card -->
                                <div class="product-item bg-light">
                                    <div class="card">
                                        <div class="thumb-content">
                                        @if($listing->logo)
                                                <a href="{{ route('list', [$listing->id]) }}">
                                                    <img class="card-img-top img-fluid" src="{{ $listing->getUrl('logo') }}"/>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title"><a href="{{ route('list', [$listing->id]) }}">{{$listing->name}}</a></h4>
                                            @foreach ($listing->businesses as $singleBusinesses)
                                                <ul class="list-inline product-meta">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('business', [$singleBusinesses->id]) }}"><i class="fa fa-folder-open-o"></i>{{ $singleBusinesses->name }}</a>
                                                    </li>
                                                </ul>
                                            @endforeach
                                            <p class="card-text">{{ substr($listing->description, 0, 100) }}...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
					</div>
				</div>
                
                {{ $listings->render() }}
			</div>
		</div>
	</div>
</section>


@stop
