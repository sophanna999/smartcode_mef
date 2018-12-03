@extends('layout.smart-module')
@section('pageTitle','ការិយាល័យវៃឆ្លាត - ជំហានចាប់ផ្ដើមឆ្ពោះទៅកាន់រដ្ឋាភិបាលអេឡិកត្រូនិក')
@section('content')
    <!--Content left-->
    <div>
        <div class="clickLeft">
            <img src="{{asset('images/arrow-point-to-right.png')}}" alt="arrow">
        </div>
        <div class="blg-left">
            @include('front-end.include.content-left')
        </div>
    </div>
    <!-- Content center -->
    <input type="hidden" id="is_small_module" value="false" />
    <div class="blg-main">
        <div class="main-content">
            
            <div class="blue-white-switch pull-right" style="margin-left:30px;">
                <div class="switch mt-5">
                    <div class="slider-switch">
                        <div class="switch-circle"  href="#tab-circle" data-toggle="tab"><img src="{{asset('images/switch-circle.png')}}"></div>
                        <div class="switch-grid" href="#tab-grid" data-toggle="tab"><img src="{{asset('images/switch-grid.png')}}"></div>
                        <span class="square" ></span>
                    </div>
                </div>
            </div>
            <!-- <div class="smart-title text-center">
                ការិយាល័យវៃឆ្លាត<span>SMART OFFICE</span>
            </div> -->
            <div class="tab-content main-switcher">
                <!--start tab1default-->
                <div class="tab-pane fade in active" id="tab-circle">
                <div class="cssplay-menu" >
                        <div class="blg-logo-middle">
                            <img src="images/middle.png" class="logo-middle">
                        </div>
                        <div class="wrapper" id="wrapper-propeller">
                            <input type="radio" id="c1" name="segment" checked="checked">
                            <input type="radio" id="c2" name="segment">
                            <input type="radio" id="c3" name="segment">
                            <input type="radio" id="c4" name="segment">
                            <input type="radio" id="c5" name="segment">
                            <input type="radio" id="c6" name="segment">
                            <input type="radio" id="c7" name="segment">
                            <input type="radio" id="c8" name="segment">
                            <input type="radio" id="c9" name="segment">
                            <input type="radio" id="c10" name="segment">
                            <input type="radio" id="c11" name="segment">
                            <input type="radio" id="c12" name="segment">
                            <input type="checkbox" id="toggle" checked="checked">
                            <div class="holder">
                                <div class="segment">
                                    <label class="piece" for="c1" data-head="" data-page="#/all-form"><span></span></label>
                                    <label class="piece" for="c2" data-head="" data-page="#/news"><span></span></label>
                                    <label class="piece" style="cursor:not-allowed" for="c3"​ data-head="" data-page=""><span></span></label>
                                    <label class="piece" style="cursor:not-allowed" for="c4" data-head="" data-page=""><span></span></label>
                                    <label class="piece" style="cursor:not-allowed" for="c5" data-head="" data-page=""><span></span></label>
                                    <label class="piece" style="cursor:not-allowed" for="c6" data-head="" data-page=""><span></span></label>
                                    <label class="piece" style="cursor:not-allowed" for="c7" data-head="" data-page=""><span></span></label>
                                    <label class="piece" for="c8" data-head="" data-page="#/schedule"><span></span></label>
                                    <label class="piece" id="some-id" style="cursor:not-allowed" for="c9" data-head="" data-page=""><span></span></label>
                                    <label class="piece" for="c10" data-head="" data-page="#/attendance-info"><span></span></label>
                                    <label class="piece" style="cursor:not-allowed" for="c11" data-head="" data-page=""><span></span></label>
                                    <label class="piece" style="cursor:not-allowed" for="c12" data-head="" data-page=""><span></span></label>
                                </div>
                                <div class="curve-lower">
                                    <div class="curve"></div>
                                </div>
                                <div class="curve-upper"></div>
                                <label for="toggle" class="center"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="smart-grid row tab-pane fade in" id="tab-grid">
                    @include('front-end.smart-office-grid')
                </div>
            </div>
        </div>
        <div class="blg-table">
            <div ng-view></div>
        </div>

        {{--@include('front-end.include.chat')--}}
    </div>
    <!--Content right-->

    @include('front-end.include.notification')

@endsection