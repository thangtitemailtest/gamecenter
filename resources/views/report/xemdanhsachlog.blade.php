@section('title','admin')
@extends('master')
@section('noidung')

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Log event</h1>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('get-xemdanhsachlog') }}" method="GET" class="mb-5" id="filter-frm">
                    <div class="row">
                        <div class="col-sm-3" style="height:85px">
                            <div class="form-group input-group-sm">
                                <label class="radio-inline mr-3">Game</label>
                                <select id="gameid" name="gameid" class="form-control">
                                    <option value="">--Chọn game--</option>
                                    @foreach($listGame as $game)
                                        <option value="{{ $game->game_id }}" {{ $game->game_id == $input['gameid'] ? 'selected' : '' }}>{{ $game->game_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3" style="height:85px">
                            <div class="form-group input-group-sm">
                                <label class="radio-inline mr-3">Eventname</label>
                                <select id="eventname" name="eventname" class="form-control">
                                    <option value="0">--Chọn eventname--</option>
                                    @foreach($listEventname as $event_name)
                                        <option value="{{ $event_name->eventname }}" {{ $event_name->eventname == $input['eventname'] ? 'selected' : '' }}>{{ $event_name->eventname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3" style="height:85px">
                            <div class="form-group input-group-sm">
                                <label class="radio-inline mr-3">
                                    <input type="radio" name="time" id="time-2" onchange="changeRadio('ngay')"
                                           {{$input['time'] == 'ngay' && !empty($input['time']) ? 'checked' : ''}}
                                           value="ngay">&nbsp;Theo ngày
                                </label>
                                <input type="date" name="date" class="form-control" id="date"
                                       value="{{!empty($input['ngay']) ? $input['ngay'] : date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col-sm-3" style="height:85px;">
                            <div class="form-group input-group-sm">
                                <label class="radio-inline mr-3">
                                    <input type="radio" name="time" id="time-3" onchange="changeRadio('tuychon')"
                                           {{$input['time'] == 'tuychon' && !empty($input['time']) ? 'checked' : ''}}
                                           value="tuychon">&nbsp;Tuỳ chọn
                                </label>
                                <input type="date" name="from-date" class="form-control" id="from-date" title="Từ ngày"
                                       value="{{!empty($input['from-date']) ? $input['from-date'] : ''}}">
                                <input type="date" name="to-date" class="form-control" id="to-date" title="Đến ngày"
                                       value="{{!empty($input['to-date']) ? $input['to-date'] : ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <input type="submit" onclick="clickSubmit()" class="btn btn-primary" id="btnsubmit"
                               value="Filter">
                    </div>
                </form>

                <style>
                    .contable {
                        width: 100%;
                        margin: 0px auto 0 auto;
                        overflow: auto;
                        min-height: 50%;

                    }

                    #divbang td, #divbang th {
                        padding: 5px !important;
                    }

                    .overtit {
                        overflow-y: auto !important;
                    }

                    .webkit-scrollbar::-webkit-scrollbar,
                    .webkit-scrollbar + #floating-scrollbar::-webkit-scrollbar {
                        height: 12px;
                    }

                    ::-webkit-scrollbar-button:start, ::-webkit-scrollbar-button:end {
                        display: none;
                    }

                    ::-webkit-scrollbar-track-piece, ::-webkit-scrollbar-thumb {
                        -webkit-border-radius: 8px;
                    }

                    ::-webkit-scrollbar-track-piece {
                        background-color: #444;
                    }

                    ::-webkit-scrollbar-thumb:horizontal {
                        width: 50px;
                        background-color: #777;
                    }

                    ::-webkit-scrollbar-thumb:hover {
                        background-color: #aaa;
                    }


                </style>

                <div class="row" id="divbang">
                    <div class="col-xs-12 table-responsive contable">
                        <table class="table table-bordered" width="100%" cellspacing="0" id="dataTable">
                            <thead>
                            <tr>
                                @foreach($listColumnLog as $key_col => $item_col)
                                    @if($item_col != 'id' && $item_col != 'game_id')
                                        <th>{{$item_col}}</th>
                                    @endif
                                @endforeach
                            </tr>
                            </thead>

                            <tbody>
                            @if(!empty($logpagi))
                                @foreach($logpagi as $key => $item)
                                    <tr>
                                        @foreach($listColumnLog as $key_col => $item_col)
                                            @if($item_col != 'id' && $item_col != 'game_id')
                                                @if($item_col == 'country')
                                                    <td>{{isset($country_array[strtoupper($item->$item_col)]) ? $country_array[strtoupper($item->$item_col)] : $item->$item_col}}</td>
                                                @else
                                                    <td>{{$item->$item_col}}</td>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div style="float: right">
                            @if(!empty($logpagi))
                                {!!  $logpagi->appends(request()->except(['page']))->links("pagination::bootstrap-4")  !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>

    <link rel="stylesheet" href="{{asset('floating_scroll/floatingscroll.css')}}">
    <script src="{{asset('floating_scroll/floatingscroll.min.js')}}"></script>

    <!-- Page level plugins -->
    <script>

        $(function () {
            changeRadio('{{empty($input['time']) ? 'ngay' : $input['time']}}');

            $(".contable").floatingScroll();
        });

        function changeRadio(time) {
            if (time == 'ngay') {
                $('#ngay').removeAttr('disabled');

                $('#from-date').attr('disabled', 'disabled');
                $('#to-date').attr('disabled', 'disabled');
            } else if (time == 'tuychon') {
                $('#ngay').attr('disabled', 'disabled');

                $('#from-date').removeAttr('disabled');
                $('#to-date').removeAttr('disabled');
            }
        }

        function clickSubmit() {
            event.preventDefault();

            if ($('#gameid').val() == '') {
                makeAlertright('Vui lòng chọn Game.', 3000);
                return;
            }
            if ($('#time-2').is(':checked') === true && $('#ngay').val() == '') {
                makeAlertright('Vui lòng chọn Ngày.', 3000);
                return;
            }

            if ($('#time-3').is(':checked') === true && ($('#from-date').val() == '' || $('#to-date').val() == '')) {
                makeAlertright('Vui lòng chọn Từ ngày/Đến ngày.', 3000);
                return;
            }

            $('#btnsubmit').attr('disabled', 'disabled');
            $('#divbang').html("<div class='loader'></div>");

            $('#filter-frm').submit();
        }


        function makeAlertright(msg, duration) {
            var el = document.createElement("div");
            el.setAttribute("style", "position:fixed;bottom:2%;right:2%; width:25%;z-index:999999");
            el.innerHTML = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-times"></i> <strong>Error!! </strong>' + msg + '</div>';
            setTimeout(function () {
                el.parentNode.removeChild(el);
            }, duration);
            document.body.appendChild(el);
        }

    </script>

@endsection