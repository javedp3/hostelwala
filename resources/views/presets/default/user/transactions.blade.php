@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap mt-0">
                <div class="row gy-4 mb-5">
                    <form >
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('Transaction Number')</label>
                                <input type="text" name="search" value="{{ request()->search }}" class="form--control">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Type')</label>
                                <select name="type" class="form--control">
                                    <option value="">@lang('All')</option>
                                    <option value="+" @selected(request()->type == '+')>@lang('Plus')</option>
                                    <option value="-" @selected(request()->type == '-')>@lang('Minus')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Remark')</label>
                                <select class="form--control" name="remark">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($remarks as $remark)
                                        <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                            {{ __(keyToTitle($remark->remark)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100"><i class="las la-filter"></i>
                                    @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div>
                    <table class="table table--responsive--lg mt-5">
                        <thead>
                            <tr>
                                <th>@lang('Trx')</th>
                                <th>@lang('Transacted')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Post Balance')</th>
                                <th>@lang('Detail')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td data-label="Trx">
                                        <strong>{{ $trx->trx }}</strong>
                                    </td>
    
                                    <td data-label="Transacted">
                                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                    </td>
    
                                    <td data-label="Amount" class="budget">
                                        <span
                                            class="fw-bold @if ($trx->trx_type == '+') text-success @else text-danger @endif">
                                            {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                                            {{ $general->cur_text }}
                                        </span>
                                    </td>
    
                                    <td data-label="Post Balance" class="budget">
                                        {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                    </td>
    
    
                                    <td data-label="Detail">{{ __($trx->details) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td data-label="Trx" class="text-muted text-center" colspan="100%">@lang('No Transactions found')
                                    </td>
                                </tr>
                            @endforelse
    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
