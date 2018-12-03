<div class="container-fluid" ng-controller="newsController">
    <div class="inner-head">
        <!-- <div  style="position:relative">@include('front-end.news.blog-search')	</div> -->
        <nav aria-label="breadcrumb" >
            <ol class="breadcrumb kbach-title">
                <li class="breadcrumb-item"><a href="#">ទំព័រដើម</a></li>
                <li class="breadcrumb-item header-title active" aria-current="page">ដំណឹង</li>
            </ol>
        </nav>
        <!-- <div class=" header-title">ដំណឹង</div> -->
    </div>
    <div class="inner-content">
        <div>
            @include('front-end.news.news-cate', ['tags'=>$tags])
            <div class="main-news-detail">
                <div class="news-each-detail">
                    <p class="ttl-news-detail">@{{ newsDetail.title }}</p>
                    <img src="@{{newsDetail.image}}">
                    <p class="date-news-bottom pull-left">@{{ newsDetail.create_date|timeago}} <span class="col-red">@{{ newsDetail.name }}</span></p>
                    <a><img src="images/facebook.jpg" alt="facebook" class="icn-facebook"></a>
                    <p class="clear" ng-bind-html="renderHtml(newsDetail.long_description)"></p>
                </div>
                <div class="news-side-bar">
                    <p class="most-popular">ដំណឹងពេញនិយម</p>
                    <div class="ttl-news-popular" ng-repeat="top in topNews">
                        <a href="#news/detail/@{{ top.Id }}">
                            @{{ top.title }}
                        </a>
                        {{--<p class="date-news" title="@{{ top.create_date}}">@{{ top.create_date|timeago}}<span class="col-red">@{{ top.category_name}}</span></p>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
