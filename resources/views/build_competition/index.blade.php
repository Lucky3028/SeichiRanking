@extends('layouts.app')

@section('content')

<div class="container">

    <h1>第{{Config::get('buildcompetition.build_competition_count')}}回 建築コンペ投票ページ</h1>

    @if (Session::has('message'))
        <div class="alert alert-danger">{!! nl2br(e(Session::get('message'))) !!}</div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <ul>
        <li>1つの応募テーマにつき、1票入れることができます。</li>
        <li>画像をクリックすると、拡大表示されます。</li>
    </ul>

    <form method="post" action="/buildCompetition/submit" id="form">
        <div class="form-group">
            {{ csrf_field() }}

            @foreach($apply_data as $app_key => $data)
                <h2><span class="glyphicon {{$data['glyphicon']}}"></span> {{ $data['theme_division_name'] }}</h2>

                <table class="table table-bordered" style="border-collapse: collapse;">
                    <thead>
                    <tr>
                        <th class="text-center col-xs-2 col-ms-2 col-md-2 col-lg-2">候補者</th>
                        <th class="text-center col-xs-4 col-ms-4 col-md-4 col-lg-4">画像</th>
                        <th class="text-center col-xs-1 col-ms-1 col-md-1 col-lg-1">作品名</th>
                        <th class="text-center col-xs-3 col-ms-3 col-md-3 col-lg-3">アピールポイント</th>
                        <th class="text-center col-xs-2 col-ms-2 col-md-2 col-lg-2">区画No</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['apply_data'] as $val)
                        <tr>
                            <td style="vertical-align: middle; word-break : break-all;">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="{{$val->theme_division_id}}" @if($val->build_competition_vote_id) disabled @endif @if($val->build_competition_apply_id === $val->build_competition_vote_apply_id) checked @endif value="{{$val->build_competition_apply_id}}">{{$val->mcid}}
                                    </label>
                                </div>
                            </td>

                            <td style="vertical-align: middle; width:100px; height: 100px">
                                @empty(!$val->img_path)
                                    <a href="#" data-toggle="modal" data-target="#modal_{{$val->build_competition_apply_id}}">
                                        <img style="width: 100%; max-height:300px" src="{{asset('storage/'.$val->img_path)}}" />
                                    </a>

                                    <div class="modal fade" id="modal_{{$val->build_competition_apply_id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">{{$val->title}}＠{{$val->mcid}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <img style="width: 100%; height: 100%;"src="{{asset('storage/'.$val->img_path)}}" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">閉じる</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endempty
                            </td>
                            <td style="vertical-align: middle;">
                                {{$val->title}}
                            </td>

                            <td style="vertical-align: middle;">
                                {{$val->apply_comment}}
                            </td>
                            <td style="vertical-align: middle;">
                                {{$val->partition_no}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            @endforeach


        </div>
        @if($vote_flg)
            <button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">送信</button>
        @else
            <button type="button" class="btn btn-success" disabled>投票ありがとうございました！</button>
        @endif
    </form>
</div>

{{-- 広告欄 --}}
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1577125384876056"
     data-ad-slot="4448153429"
     data-ad-format="auto"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>

@include('footer')

@endsection

