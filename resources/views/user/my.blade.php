@extends('layouts.appdefault')

@section('content')
<div class="board-list-con" style="padding-left: 10px !important; padding-top: 40px !important; padding-right: 0px; padding-bottom: 0px;">
    <div class="my-fv-board">
        <h1 class="board-starred-heading" style="margin-top: 10px;margin-left: 15px;font-weight: 500;font-size: 25px;"><span class="glyphicon glyphicon-star-empty starred-boards" aria-hidden="true"></span>@lang('Starred boards')</h1>
        <div class="row boards-col">
            @forelse($starredBoards as $board)
            <div class="col-lg-3" data-boardid="{{ $board->id }}">
                <a href="{{ url('board/' . $board->id) }}" class="board-main-link-con">
                    <div class="board-link">
                        <div class="row">
                            <div class="col-lg-8">
                                <h2 style="font-size: 20px; ">
                                    {{ $board->boardTitle }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <h2 class="board-create-head">
                @lang('There is no starred board')
            </h2>
            @endforelse
        </div>
    </div>
    <div class="my-board">

        <h1 class="board-starred-heading" style="margin-top: 10px;margin-left: 15px;font-weight: 500;font-size: 25px;"><span class="glyphicon glyphicon-home starred-boards" aria-hidden="true"></span>@lang('Departments')</h1>


        <div class="row boards-col">
            @forelse($boards as $board)
            <div class="col-lg-3" data-boardid="{{ $board->id }}">
                <div style="cursor: pointer;" data-boardid="{{ $board->id }}" class="{{$board->owner_id==Auth::id()?'board-admin':'board-link'}}">
                    <div class="row">
                        <div class="col-lg-10">
                            <h2 style="margin-top: 5px;">
                                <a href="{{ url('board/' . $board->id) }}" class="board-main-link-con" style="font-size: 20px; color: #FFFFFF;">
                                    {{ $board->boardTitle }}
                                </a>
                            </h2>
                        </div>
                        <div class="col-lg-2">
                            <p style="margin-top: 12px;">
                                <a href="#" style="font-size: 20px; {{ ($board->is_starred == 1) ? 'color: #FFEB3B;' : 'color: #FFF;' }}" id="make-fv-board"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></a>
                            </p>
                        </div>
                    </div>
                    <div class="row" style="text-align: left;">
                        <div class="col-lg-10">
                            <div style="margin-top: 5px;">
                                <a href="{{ url('board/' . $board->id) }}" class="board-main-link-con" style="font-size: 20px; color: #FFFFFF;">
                                    {{ $board->owner?$board->owner['name']:"-" }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <h2 class="board-create-head">
                There is no board in this department for you as an administrator or manager - هیچ بوردی در این دپارتمان بعنوان مجری یا مدیر به شما اختصاص ندارد </h2>
            @endforelse


            <!-- <div class="col-lg-3">
                <a data-toggle="modal" href='#create-new-board' class="board-create-link">
                    <div class="board-create">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="board-create-head">
                                    @lang('Build a new board')
                                </h1>
                            </div>
                        </div>
                    </div>
                </a>
            </div> -->
        </div>

    </div>
</div>
@endsection
