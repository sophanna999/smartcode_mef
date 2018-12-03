<div id="general-knowledge" class="container-fluid" ng-controller="newsController">
	<div class="inner-head">
	
		<nav aria-label="breadcrumb" >
            <ol class="breadcrumb kbach-title">
                <li class="breadcrumb-item"><a href="#">ទំព័រដើម</a></li>
                <li class="breadcrumb-item header-title active" aria-current="page">ដំណឹង</li>
            </ol>
        </nav>
		<!-- <div class=" header-title">ដំណឹង</div> -->
	</div>
	<!--  -->
	<div class="inner-content">
	
		@include('front-end.news.news-cate', ['tags'=>$tags])
		<div class="list-blog-news">
			<!-- <p class="ttl-news col-red">ព័ត៌មានថ្មីៗ</p> -->
			<div class="second-top-news">
				<slick class="slider" settings="slickConfig" ng-show="slickConfigLoaded">
					<div class="wrap-slick" ng-repeat="news in newsList | limitTo:4:0"
					     ng-init="$last ? mainSlick($last) : null">
						<div class="top-news-img">
							<img ng-src="@{{news.image}}">
						</div>
						<div class="cont-news">
							<a href="#news/detail/@{{ news.Id }}">@{{news.title}}</a>
							<p class="date-news" title="@{{ news.create_date}}">@{{ news.create_date|timeago}} <span
										style="font-style:italic">@{{ news.category_name }}</span></p>
						</div>
					</div>
				</slick>
			</div>
			<!--second-top-news-->
			<div class="top-news">
				<div ng-repeat="news in newsList | limitTo:newsList.length:4">
					<div class="news-img">
						<img ng-src="@{{news.image}}">
					</div>
					<a href="#news/detail/@{{ news.Id }}" class="ttl-top-news">@{{news.title}}</a>
					<p>@{{ news.short_description }}</p>
					<p class="date-news-bottom" title="@{{ news.create_date}}">@{{ news.create_date|timeago}}<span
								class="col-red">@{{ news.category_name }}</span></p>
				</div>
			</div><!--top-news-->
		</div>
		<p class="listMore" ng-click="loadMore()" ng-show="more">ទាញព័ត៌មានបន្ថែម</p>
	</div>
</div>
