angular.module('Application', ['ionic', "Application.factory"], function($httpProvider) {
        $httpProvider.defaults.headers.post['Content-Type'] = "application/x-www-form-urlencoded";
    })
    .config(function($stateProvider, $urlRouterProvider, $ionicConfigProvider) {

        $stateProvider
            .state('load', {
                'url': '/load',
                'templateUrl': 'templates/load.html',
                'controller': 'load'
            })
            .state('app', {
                'url': '/app',
                'templateUrl': 'templates/menu.html',
                'controller': 'menu',
                'abstract': 'true'

            })
            //Latest News Page
            //It contains the latest news
            .state('app.home', {
                'url': '/home',
                views: {
                    'menuContent': {
                        templateUrl: 'templates/home.html',
                        controller: 'home'
                    }
                }

            })
            //Latest News Page
            //It contains the latest news
            .state('app.latest_news', {
                'url': '/latest_news',
                views: {
                    'menuContent': {
                        templateUrl: 'templates/latest_news.html',
                        controller: 'latest_news'
                    }
                }

            })
            //Top news
            .state('app.top_news', {
                'url': '/top_news',
                views: {
                    'menuContent': {
                        templateUrl: 'templates/top_news.html',
                        controller: 'top_news'
                    }
                }

            })
            //About Page
            .state('app.about', {
                'url': '/about',
                views: {
                    'menuContent': {
                        templateUrl: 'templates/about.html',
                        'controller': 'about'
                    }
                }

            })
            //News reader
            //For reading the news content
            .state('app.read', {
                'url': '/read',
                views: {
                    'menuContent': {
                        templateUrl: 'templates/read.html',
                        controller: "read"
                    }
                }

            });
        //In case none of the urls match
        $urlRouterProvider.otherwise('app/home');;

    })
    .controller('menu', function(News, $scope, Menu, $location, $ionicLoading, Loader, $ionicPopup, $timeout, Dialog,$rootScope) {
        //Id of the selected news
        $scope.selectedId = 0;
        $scope.hideSplash = function() {
            document.getElementById('splash').style.display = 'none'
        }
        $rootScope.refresh = function() {
            Loader.show();

            News.refresh().then(function() {
                $scope.$broadcast('scroll.refreshComplete');
                Menu.menu_links().then(function(res) {
                    $scope.menu_links = res;
                });
                $timeout(function() {
                    Loader.hide();
                }, 200);
            }, function() {
                $scope.$broadcast('scroll.refreshComplete');
                Loader.hide();
                Dialog.alert("Can't connect to server");
            });
        }

        //console.log($scope.menu_links);
        $scope.handle_click = function(id) {
            $scope.selectedId = id;
            //console.log(data.title)
            $location.path('/app/read');
        }

    })
    .controller('home', function($timeout, $state, $scope, News, Menu, $rootScope, Dialog) {
        $timeout(function() {
            /* $scope.refresh().then();*/
            //Load the sidebar links

            $scope.hideSplash();
            Menu.menu_links().then(function(res) {
                $rootScope.menu_links = res;
            });
        }, 1000);
    })
    .controller('latest_news', function($scope, $timeout, News, Loader, $ionicNavBarDelegate, Menu, $rootScope, Dialog) {
        //$scope.menu_links.latest.total=100;
        //$ionicNavBarDelegate.title("Latest News <span class='badge badge-assertive' ng-bind=''>"+$scope.menu_links.latest.total+"</span>")
        $rootScope.refresh = function() {
            Loader.show();

            News.refresh().then(function() {
                $scope.$broadcast('scroll.refreshComplete');
                Menu.menu_links().then(function(res) {
                    $rootScope.menu_links = res;
                });
                News.latest_news().then(function(res) {
                    $scope.news_links = res;
                    $timeout(function() {
                        Loader.hide();
                    }, 200);
                }, function(e) {
                    
                    Loader.hide();
                    Dialog.alert("Error in response while fetching data from server");
                });
            }, function() {
                Loader.hide();
                $scope.$broadcast('scroll.refreshComplete');
                Dialog.alert("Can't connect to server");
            });
        }
        /*Loader.show();
        News.latest_news().then(function(res) {
            $scope.$broadcast('scroll.refreshComplete');
            Menu.menu_links().then(function(res) {
                $rootScope.menu_links = res;
            });
            $scope.news_links = res;
            Loader.hide();
            $scope.refresh();
        }, function(e) {
            $scope.$broadcast('scroll.refreshComplete');
            Loader.hide();
            Dialog.alert("Can't connect to server");
        });*/
        $scope.refresh();
        //Hide the splash screen
        $scope.hideSplash();
    })
    .controller('top_news', function(Menu, $scope, $timeout, News, Loader, $rootScope, Dialog) {
        $rootScope.refresh = function() {
            Loader.show();

            News.refresh().then(function() {
                $scope.$broadcast('scroll.refreshComplete');
                Menu.menu_links().then(function(res) {
                    $rootScope.menu_links = res;
                });
                News.top_news().then(function(res) {
                    $scope.news_links = res;
                    $timeout(function() {
                        Loader.hide();
                    }, 200);
                }, function(e) {
                    
                    Loader.hide();
                    Dialog.alert("Error in response while fetching data from server");
                });
            }, function(e) {
                Loader.hide();
                $scope.$broadcast('scroll.refreshComplete');
                Dialog.alert("Can't connect to server");
                
            });
        }
        /*Loader.show();
        News.top_news().then(function(res) {
            $scope.$broadcast('scroll.refreshComplete');
            Menu.menu_links().then(function(res) {
                $rootScope.menu_links = res;
            });
            $scope.news_links = res;
            Loader.hide();
            $scope.refresh();
        }, function() {
            Loader.hide();
            $scope.$broadcast('scroll.refreshComplete');
            Dialog.alert("Can't connect to server");
        });*/
        $scope.refresh();
        //Hide the splash screen
        $scope.hideSplash();
    })
    .controller('read', function($scope, Loader, $timeout, News) {
        //Dialog.alert('reader')
        $scope.hideSplash();
        Loader.show('Loading...');
        News.getById($scope.selectedId).then(function(data) {
            $scope.news = data;
            Loader.hide();
        });

    })
    .controller('about', function($scope, Loader, $timeout, News) {
        //Dialog.alert('reader')
        $scope.hideSplash();
    });;