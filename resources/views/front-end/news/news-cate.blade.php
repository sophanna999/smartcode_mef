<!-- <ul id="news-cate" class="navigation">
 <input type="checkbox" id="more" aria-hidden="true" tabindex="-1" class="toggle"/>
 <div class="navigation__inner">
        
        <ul class="navigation__list">
         
            <li class="navigation__item">
                <a href="{{url('#news/')}}"><img src="images/news/news.png"><span>ព័ត៌មានថ្មីៗ</span></a>
            </li>
            @if(!empty($tags))
                @for($i=0; $i<count($tags);$i++)
                    <li class="navigation__item">
                        <a href="{{url('#news/category/'.$tags[$i]->Id)}}"><img src="{{$tags[$i]->icon}}"><span>{{$tags[$i]->name}}</span></a>
                    </li>
                @endfor
            @endif
		</ul>
 		<div class="navigation__toggle">
          <label for="more" aria-hidden="true" class="navigation__link">ផ្សេងទៀត...</label>
        </div>
    </div>
</ul> -->
<div class="row">
    <div class="wrap-head-container" style="">
        <div class="col-md-8 wrap-navbar">
            <div class="navbar-nav module-heading" >
                <ul class="nav nav-tabs">
                    <li ng-class="{active:cate_id==null}">
                        <a href="{{url('#news')}}">
                        <!-- <img src="images/news/news.png"> -->
                        <span>ព័ត៌មានថ្មីៗ</span></a>
                    </li>
                    @if(!empty($tags))
                        @for($i=0; $i<count($tags);$i++)
                            <li ng-class="{active:cate_id=={{$tags[$i]->Id}}}">
                                <a href="{{url('#news/category/'.$tags[$i]->Id)}}"><!-- <img src="{{$tags[$i]->icon}}"> --><span>{{$tags[$i]->name}}</span></a>
                            </li>
                        @endfor
                    @endif
                    {{--<li  class="dropdown">--}}
                            {{--<a for="more" aria-hidden="true" class="dropbtn">ផ្សេងទៀត...<i class="fa fa-caret-down"></i></a>--}}
                            {{--<div class="dropdown-content">--}}
                                {{--<a href="#">តំណភ្ជាប់ ១</a>--}}
                                {{--<a href="#">តំណភ្ជាប់ ១</a>--}}
                            {{--</div>--}}
                    {{--</li>--}}
                </ul>
                
            </div>
        </div>
        <div class="col-md-4">
        <div  style="position:relative">@include('front-end.news.blog-search')	</div>
        </div>
    </div>
</div>
<hr style="position:relative;z-index:3;width:96%;border-top: 3px solid #eee;">

