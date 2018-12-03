app.controller("newsController", function ($scope,$routeParams,$http, $sce, $location, $rootScope,$timeout) {
    $scope.newsId = $routeParams.id;
	$scope.cate_id = $routeParams.cate_id;
	$scope.active = null;
    $scope.newsList = [];
    $scope.newsDetail = {};
    $scope.more = 1;
    $scope.search_text = '';
	$scope.topNews = [];
	$scope.limit = 12;
	$scope.readNews = (sessionStorage.getItem('readNews')!=null)? JSON.parse(sessionStorage.getItem('readNews')):[];
	$scope.page_title ='';
    var listUrl = baseUrl+'news/data';
    var detailUrl = baseUrl+'news/detail';
	var getNewsByCateUrl = baseUrl+'news/category';
	var getNormalSearchUrl = baseUrl+'news/search';
	var getAdvanceSearchUrl = baseUrl+'news/searchadvance'
    loadingWaiting();
    // if ($location.path()!='/news/search') $rootScope.search.text ='';
    $scope.page = 1;

    $scope.slickConfigLoaded = false;
	$scope.mainSlick = function (last) {
		$scope.slickConfigLoaded = last;
		$scope.slickConfig = {
			autoplay: false,
			infinite: true,
			autoplaySpeed: 8000,
			slidesToShow: 3,
			slidesToScroll: 1,
			method: {}
		},
		{
		  breakpoint: 960,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 1
		  }
		};
	}

    $scope.renderHtml = function (html) {
	    return $sce.trustAsHtml(html);
    }

    $scope.getLatestNews = function(){
	    // $scope.page = 1;
    	if ($location.path()=='/news'){
		    $http.post(listUrl, {page:$scope.page})
			    .success(function (response) {
				    if (response.length < $scope.limit ) $scope.more = 0;
				    $scope.newsList = response;
			    })
			    .catch(function (err) {
			    })
			    .finally(function () {
				    endLoadingWaiting();
			    });
	    }
    };

	loadingWaiting()
    $scope.getNewDetail = function () {
		var count = false;
	    if ($scope.readNews.indexOf($scope.newsId)==-1){
	    	count = true
		    $scope.readNews.push($scope.newsId)
		    sessionStorage.setItem('readNews',JSON.stringify($scope.readNews))
	    }
	    $http.post(detailUrl,{id:$scope.newsId,count:count})
		    .success(function (response) {
			    $scope.newsDetail = response.news;
			    $scope.topNews = response.topNews;
				$scope.readNews.push($scope.newsId)

		    })
		    .catch(function (err) {
		    })
		    .finally(function () {
			    endLoadingWaiting();
		    });
    }

    $scope.getNewsByCategory = function () {
		
	    loadingWaiting()
	    $http.post(getNewsByCateUrl, {
			'id':$scope.cate_id,
		    'page':$scope.page
	    }).success(function (response) {
			console.log('category =>', response)
		    if (response.news.length < $scope.limit ) $scope.more = 0;
		    $scope.newsList = response.news;
			$scope.page_title = response.category_name;
			$scope.active = response.active;
	    }).catch(function (err) {
	    }).finally(function () {
		    endLoadingWaiting();
	    });
    }

    $scope.loadMore = function () {
	    var text =  window.localStorage.getItem('search_text');
    	if (!angular.isUndefined($scope.cate_id)){
    		url = getNewsByCateUrl;
		    data = {
			    id:$scope.cate_id,
			    page:++$scope.page
		    };
	    } else if ($location.path() == '/news/search-advance'){
		    data =  JSON.parse(localStorage.getItem('advance'));
		    url = getAdvanceSearchUrl;
		    data.page = ++$scope.page
	    } else if ($location.path() == '/news/search') {
		    url =  getNormalSearchUrl;
		    data = {
			    'text':text,
			    'page':++$scope.page
		    };
	    } else {
		    url =  listUrl;
		    data = {
			    'page':++$scope.page
		    };
	    }
	    loadingWaiting()
	    $http.post(url, data).success(function (response) {
		    if (response.length < $scope.limit ) $scope.more = 0;
		    if (!response.length==0){
			    angular.forEach(response, function (i) {
				    $scope.newsList.push(i);
			    })
		    } else {
		    	$scope.more = 0;
		    }
	    }).catch(function (err) {
	    }).finally(function () {
		    endLoadingWaiting();
	    });
	}
	$scope.btn_search = 1;
	
	$scope.normalSearch = function (btn_search) {
		if (btn_search==1){
			//console.log(checkSearch);
			 //if(checkSearch){
				 
				angular.element(".wrap-blg-adv").animate({
					height : '0'
				},200, function(){
				});
				$scope.adv_search = 1;
				
			 //}
		
				 angular.element(".blg-search input[type=text]").css({
					width: "200",
					display: "block"
				});
	
				angular.element(".blg-search span").animate({
					width: 200,
				}, 200, function () {
				});
				

		} else {
			angular.element(".blg-search span").animate({
				width: "0",
			}, 200, function () {
			});
		}
		$scope.btn_search = !$scope.btn_search;

    	if ($scope.search_text!=''&&$location.path!='/news/search'){
    		var text =  window.localStorage.getItem('search_text');
    		if (text != $scope.search_text){
			    text = $scope.search_text;
			    localStorage.setItem('search_text', $scope.search_text);
			    $scope.getNormalSearch();
		    }
		    $location.path('/news/search');
	    }
	}
	$scope.getNormalSearch = function () {
		loadingWaiting()
		var text =  window.localStorage.getItem('search_text');
		$scope.page = 1;
		$scope.more = 1
		$http.post(getNormalSearchUrl, {
			'text':text,
			'page':$scope.page
		}).success(function (response) {
			if (response.news.length < $scope.limit ) $scope.more = 0;
			$scope.newsList = response.news;
			$scope.page_title = response.page_title;
		}).catch(function (err) {
		}).finally(function () {
			endLoadingWaiting();
		});
	}
	$scope.adv = {
		fromdate:'',
		todate:'',
		category:[],
		source:''
	};
	$scope.advancedSearch =function () {
		if ($scope.adv.fromdate!=''|| $scope.adv.todate!=''||$scope.adv.category.length!=0||$scope.adv.source!=''){
			var advance =  localStorage.getItem('advance');
			localStorage.setItem('advance', JSON.stringify($scope.adv));
			if ($location.path()=='/news/search-advance')
				$scope.getAdvanceSearch();
			$location.path('/news/search-advance');
		}
	}

	$scope.getAdvanceSearch = function () {
		var advance = JSON.parse(localStorage.getItem('advance'));
		loadingWaiting()
		if (advance){
			$scope.more = 1
			advance.page = 1
			$http.post(getAdvanceSearchUrl, advance).success(function (response) {
				if (response.news.length < $scope.limit ) $scope.more = 0;
					$scope.newsList = response.news;
					$scope.page_title = response.page_title;
			}).catch(function (err) {
			}).finally(function () {
				endLoadingWaiting();
			});
		}
	}
	//route
	if (!angular.isUndefined($scope.newsId)){
		$scope.getNewDetail($scope.newsId);
	} else if (!angular.isUndefined($scope.cate_id)){
		$scope.getNewsByCategory()
	} else if ($location.path()=="/news/search"){
		$scope.getNormalSearch();
	} else if ($location.path()=="/news/search-advance"){
		$scope.getAdvanceSearch();
	} else {
		$scope.getLatestNews();
	}

	angular.element("#sub-news-cate").css("display", "none");
	angular.element(".other-cate").click(function () {
		angular.element("#sub-news-cate").slideToggle();
	});
	angular.element(".blg-search span").css("width", "0");
	angular.element(".blg-search span").css("overflow", "hidden");
	angular.element(".blg-search input[type=text]").css({
		width: "0",
		display: "none"
	});
	angular.element('.clickRight').click(function(){angular.element( ".slick-next" ).trigger( "click" );})
	$scope.adv_search = 1;
	$scope.toggleAdvSearch = function (e) {
		 if(e){
				angular.element(".blg-search span").animate({
					width: "0",
				}, 200, function () {
						
				});
				$scope.btn_search = 1;
			$(".wrap-blg-adv").animate({
				height : '220px'
			},200, function(){
			});
			$(".blg-adv").css({
				height: "220px",
				display: "block"
			});
		}else{
			$(".wrap-blg-adv").animate({
				height : '0'
			},200, function(){
			});
		}
		$scope.adv_search = !$scope.adv_search;
	}

	var url = baseUrl+'news/category';
	// prepare the data
	var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'Id' },
				{ name: 'name' }
			],
			url: url,
			async: false
		};
	var dataAdapter_viewer = new $.jqx.dataAdapter(source);
	$scope.mef_viewer = {
		source: dataAdapter_viewer
		, displayMember: "name"
		, valueMember: "Id"
		, width: '100%'
		, height: 30
	};
	var url = baseUrl+'news/tag';
	// prepare the data
	var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'Id' },
				{ name: 'name' }
			],
			localdata: $scope.mef_category,
			url: url,
			async: false
		};
	var tagAdapter = new $.jqx.dataAdapter(source);
	$scope.mef_category = {
		source: tagAdapter
		, displayMember: "name"
		, valueMember: "Id"
		, width: '100%'
		, height: 30
		, multiSelect:true
	};

	$scope.selectTag = function (event) {
		if (!angular.isUndefined(event.args)){
			var item = event.args.item;
			$scope.adv.category.push(item.value);
		}
	}
	$scope.unselectTag = function (event) {
		if (!angular.isUndefined(event.args)){
			var item = event.args.item;
			angular.forEach($scope.adv.category, function (val, i) {
				if (val == item.value){
					$scope.adv.category.splice(i, 1);
				}
			})
		}
	}
});