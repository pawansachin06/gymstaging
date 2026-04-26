@extends('layouts.app')

@section('content')
    <h3 class="page-title">Edit Membership</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.memberships.update', $item) }}" data-js="form" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" value="{{ $item->name }}" required class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Excerpt</label>
                        <input type="text" name="excerpt" value="{{ $item->excerpt }}" required class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Overline</label>
                        <input type="text" name="overline" value="{{ $item->overline }}" placeholder="Most Popular" class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Underline</label>
                        <input type="text" name="underline" value="{{ $item->underline }}" placeholder="Billed at £270 | Save £60" class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Duration</label>
                        <select name="duration" class="form-control">
                            <option value="">Select duration</option>
                            <option value="monthly" @selected('monthly' == $item->duration)>Monthly</option>
                            <option value="yearly" @selected('yearly' == $item->duration)>Yearly</option>
                        </select>
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Sequence</label>
                        <input type="number" name="sequence" value="{{ $item->sequence }}" required min="0" step="1" class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Stripe Product Id</label>
                        <input type="text" name="stripe_product_id" value="{{ $item->stripe_product_id }}" placeholder="prod_1234567" class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Is Popular</label>
                        <div>
                            <input type="checkbox" value="1" name="is_popular" @checked($item->is_popular) />
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        @foreach($currencies as $currency)
                            <div style="margin-bottom:8px;">
                                <label class="control-label">{{ $currency->code }} Price ID</label>
                                <input type="text" name="stripe_price_ids[{{ $currency->code }}]" placeholder="price_1234567" class="form-control"
                                    value="{{ $item->stripe_price_ids[$currency->code] ?? '' }}" />
                            </div>
                        @endforeach
                    </div>
                    <!--currencies-->
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Features</label>
                        <div id="features-wrapper">
                            @foreach($features as $i => $feature)
                                @if(!empty($feature['title']))
                                    <div class="feature-item" style="margin-bottom:4px;">
                                        <input type="text" name="features[{{ $i }}][title]" value="{{ $feature['title'] ?? '' }}" class="form-control feature-input" />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div style="display:flex;flex-wrap:wrap;column-gap:32px;">
                            @foreach($capabilities as $key => $label)
                                <label>
                                    <input type="checkbox" value="1" name="capabilities[{{ $key }}]" @checked($item->hasCapability($key)) />
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="">
                    <div data-js="form-msg" style="padding:6px 12px;"></div>
                    <button data-js="form-btn" type="submit" class="btn btn-success">
                        <span>Update</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('features-wrapper');
        
            function updateIndexes() {
                const inputs = wrapper.querySelectorAll('.feature-input');
                inputs.forEach((input, index) => {
                    input.name = `features[${index}][title]`;
                });
            }
        
            function addNewInput() {
                const div = document.createElement('div');
                div.classList.add('feature-item');
                div.style.marginBottom = '4px';
        
                const input = document.createElement('input');
                input.type = 'text';
                input.classList.add('form-control', 'feature-input');
        
                div.appendChild(input);
                wrapper.appendChild(div);
            }
        
            function handleInput() {
                const inputs = wrapper.querySelectorAll('.feature-input');
                const lastInput = inputs[inputs.length - 1];
        
                // If last input has text → add a new one
                if (!lastInput || lastInput?.value.trim() !== '') {
                    addNewInput();
                }
        
                // Remove extra empty inputs (keep only one empty at end)
                const allInputs = wrapper.querySelectorAll('.feature-input');
                let emptyCount = 0;
        
                allInputs.forEach((input, index) => {
                    if (input.value.trim() === '') {
                        emptyCount++;
        
                        if (emptyCount > 1 && index !== allInputs.length - 1) {
                            input.parentElement.remove();
                        }
                    }
                });
        
                updateIndexes();
            }
        
            wrapper.addEventListener('input', handleInput);
            handleInput(); // on page load
        });
    </script>
@endsection