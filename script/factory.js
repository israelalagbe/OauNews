 angular.module("Application.factory", ['ionic'])
    .factory('Menu', function(News, $q) {
        //var news_count = News.counts();
        var factory = {
            menu_links: function() {
                return News.counts().then(function(res) {
                    return {
                        'home': { 'name': 'Home', 'link': 'app/home' },
                        'latest': { total: res.latest, 'name': 'Latest News', 'link': 'app/latest_news' },
                        'top': { total: res.top, 'name': 'Top News', 'link': 'app/top_news' }
                    };
                });

                /*var deffered=$q.defer();
                deffered.resolve( {
                    'latest': { total: news_count.latest, 'name': 'Latest News', 'link': 'app/index' },
                    'top': { total: news_count.top, 'name': 'Top News', 'link': 'app/top_news' },
                });
                return deffered.promise;*/
            }
        };
        return factory;
    })
    .factory('News', function($http, $q, newsStorage, $timeout, newsStorage, $http, param) {
        window.newsStorage = newsStorage;
        var base_url = 'http://localhost/jerry/server/';
        //var base_url = 'http://wavesapi.eu5.net/jerry/';
        var news_count = { 'latest': 0, 'top': 0 };
        var factory = {
            counts: function() {
                return this.latest_news().then(function(res) {
                        news_count['latest'] = res.length;
                        return factory.top_news();
                    }) 
                    .then(function(res) {
                        news_count['top'] = res.length;
                        return news_count;
                    });
                //deffered.resolve({ 'latest': factory.latest_news(), 'top': factory.top_news().length });
            },
            refresh: function() {
                newsStorage.load();
                if (newsStorage.exist()&&newsStorage.getNews().length>0) {
                    var news = newsStorage.getNews();
                    //Returns the ID of news with biggest ID
                    var Firstid = news.reduce(function(initialID, currentValue, index, arr) { 
                        var id = initialID > currentValue.id ? initialID : currentValue.id; return id;
                    }, news[0]);
                    //First the news after the last update
                    return $http.get(base_url + "after/" + Firstid).then(function(res) {
                        var result = res.data.data;
                        result.map(function(news){
                            news.time=Date.now();
                        });
                        newsStorage.addNews(result);
                        newsStorage.save();
                        return newsStorage.getNews();
                    });
                    //deffered.resolve();
                    //http://localhost/jerry/server/after/1
                } else {
                    return this.all();
                }
            },
            all: function() {
                var deffered = $q.defer();
                $timeout(function() {
                    newsStorage.load()
                    if (newsStorage.exist()&&newsStorage.getNews().length>0) {
                        var n = newsStorage.getNews();
                        deffered.resolve(n);
                        return;
                    }

                    /* var data = {
                         title:"First Semester Exam Commences",
                         content: "This is teh content",
                         image: 'img/exam.jpg',
                         time: Date.now(),
                         author: "Alagbe Israel",
                         top:false
                     };*/
                    $http.get(base_url + "news").then(function(res) {
                        var result = res.data.data;
                        result.map(function(news){
                            news.time=Date.now();
                        });

                        deffered.resolve(result);
                        newsStorage.setNews(result);
                        newsStorage.save();
                    }, function(e) {
                        deffered.reject(e);
                    });
                    /*var result = [];
                    newsStorage.newData();
                    for (var i = 0; i < 100; i++) {
                        var temp = angular.copy(data);
                        temp.id = i;
                        temp.content += i;
                        temp.top = (Math.random() > 0.5) ? true : false;
                        result.push(temp);
                        newsStorage.addNews(temp);
                    }
                    deffered.resolve(result);*/
                }, 0);
                return deffered.promise;
            },
            top_news: function() {
                return this.all().then(function(data) {
                    return data.filter(function(item) {
                        return item.top == true;
                    });
                });
            },
            latest_news: function() {
                /*$http.get(base_url).success(function(data) {
                    console.log(data);
                });*/
                return this.all().then(function(res) {
                    return res;
                });
            },
            getById: function(id) {
                return this.all().then(function(res) {
                    for (var i in res) {
                        if (res[i].id == id)
                            return res[i];
                    }
                    return null;
                });
            }
        };
        return factory;

    })
    .factory('newsStorage', function() {
        var imageData = null;
        var newsData = null;
        var imageDbName = "imageTable";
        var newsDbName = "newsTable";
        var maxNewsLength=10
        /*
        * To make sure news doesn't exheed maxlength
        */
        function trimNews(newsArr){
            while(newsArr.length>maxNewsLength)
                newsArr.pop();
            return newsArr;
        }
        function load() {
            newsData = store.get(newsDbName);
            return newsData;
        }

        function save() {
            newsData=this.trimNews(newsData);
            store.set(newsDbName, newsData);
        }

        function newData() {
            imageData = [];
            newsData = [];
        }

        function exist() {
            return newsData != null && store.get(newsDbName) != null;
        }

        function addNews(arr) {
            newsData = arr.concat(newsData);
        }

        function setNews(obj) {
            newsData = obj.reverse();
        }

        function getNews() {
            return newsData;
        }
        return {
            addNews: addNews,
            newData: newData,
            getNews: getNews,
            load: load,
            exist: exist,
            save: save,
            setNews: setNews,
            trimNews:trimNews
        };
    })
    .factory('Loader', ['$ionicLoading', '$timeout', function($ionicLoading, $timeout) {
        return {
            show: function(text) {
                var config = {
                    showBackdrop: true,
                    animation: 'fade-in'
                }
                if (text)
                    config.template = text;
                $ionicLoading.show(config);
            },
            hide: function() {
                $ionicLoading.hide();
            },
            toggle: function(text, timeout) {
                var that = this;
                that.show(text);
                $timeout(function() {
                    that.hide();
                }, timeout || 3000);
            }
        };
    }])
    .filter('ago', function() {
        var MILISEC = 1000;
        var SEC = MILISEC * 60;
        var MINUTE = SEC * 60;
        var HOUR = MINUTE * 24;
        return function(time) {
            var sec = (Date.now()) - time;
            if (sec < SEC)
                var formated = Math.floor(sec / MILISEC) + " second(s) ago";
            else if (sec < MINUTE)
                var formated = Math.floor(sec / SEC) + " minute(s) ago";
            else if (sec < HOUR)
                var formated = Math.floor(sec / MINUTE) + " hour(s) ago";
            else
                var formated = Math.floor(sec / HOUR) + " day(s) ago";
            //return formated;
            return formated;
        }
    })
    .value('param', function(obj) {
        var temp = [];
        for (i in obj)
            temp.push(i + '=' + obj[i]);
        return temp.join('&');
    })
    .factory('Dialog',function($ionicPopup){
    return {
        alert:function(title,content){
            var alert = $ionicPopup.alert({
                title:title,
                template: content
            });
            return alert;
/*alert.then(function(res) {
console.log('Yeah!! I know!!');
});*/
        }
    };
});