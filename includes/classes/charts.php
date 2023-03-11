<?php



class Charts
{

    public static function basicLineChart()
    {
        echo "
        $(function () {

            $('#container').highcharts({
                title: {
                    text: 'Activity Report  between',
                    x: -20 //center
                },

                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    title: {
                        text: 'Number of Tweets'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: '�C'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: 'Tokyo',
                    data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                }, {
                    name: 'New York',
                    data: [6.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
                }]
            });
        });
        	";
    }



    public static function priceTracker()
    {
        echo "
        $(function () {

            $('#container').highcharts({
                title: {
                    text: 'Price Tracker between June 01 and June 18 2018',
                    x: -20 //center
                },

                xAxis: {
                    categories: ['June 01',
'June 02',
'June 03',
'June 04',
'June 05',
'June 06',
'June 07',
'June 08',
'June 09',
'June 10',
'June 11',
'June 12',
'June 13',
'June 14',
'June 15',
'June 16',
'June 17',
'June 18']
                },
                yAxis: {
                    title: {
                        text: 'Price / Tonne'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: '/='
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: 'Price/Tonne',
                    data: [".self::getLatestPrice()."]
                }]
            });
        });
        	";
    }



    public static function getLatestPrice(){
        $sql = database::performQuery("SELECT value FROM `market_price` WHERE produce_category_id=$_SESSION[produce_category_active] LIMIT 18");
        $values = [];
        while($data = $sql->fetch_assoc()){
            $values[] = $data['value'];
        }
        return implode(',',$values);
    }



    public static function volumeTracker()
    {
        echo "
        $(function () {

            $('#containerVolumes').highcharts({
                title: {
                    text: 'Volumes Traded between June 01 and June 18 2018',
                    x: -20 //center
                },

                xAxis: {
                    categories: ['June 01',
'June 02',
'June 03',
'June 04',
'June 05',
'June 06',
'June 07',
'June 08',
'June 09',
'June 10',
'June 11',
'June 12',
'June 13',
'June 14',
'June 15',
'June 16',
'June 17',
'June 18']
                },
                yAxis: {
                    title: {
                        text: 'Voluems Traded'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#C0C0C0'
                    }]
                },
                tooltip: {
                    valueSuffix: 'Tonnes'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: 'Volumes Traded',
                    data: [".self::getLatestVolume()."]
                }]
            });
        });
        	";
    }



    public static function getLatestVolume(){
        $sql = database::performQuery("SELECT value FROM `market_volume` WHERE produce_category_id=$_SESSION[produce_category_active] LIMIT 18");
        $values = [];
        while($data = $sql->fetch_assoc()){
            $values[] = $data['value'];
        }
        return implode(',',$values);
    }


    public static function tweetTypes($q)
    {
        return "
        $(function () {
            $('#container-tweetTypes-".trim($q)."').highcharts({
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: 'Tweet types for $q between $_SESSION[date_from] and $_SESSION[date_to]'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.1f} Tweets</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}'
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Tweet Types',
                    data: [
                        ['Tweets',   " . Search::checkTweets($q) . "],
                        ['Replies',  " . Search::checkReplies($q) . "],
                        ['Retweets', " . Search::checkRetweets($q) . "],
                        ['Favorites', " . Search::checkFavs($q) . "],
                        ['Videos', " . Search::checkVideos($q) . "],
                        ['URLs', " . Search::checkUrls($q) . "],
                        ['Photos',   " . Search::checkPhotos($q) . "]
                    ]
                }]
            });
        });
        		";
    }

    public static function tweetSources($q,$limit=10)
    {
        $sql = "SELECT source,COUNT(*) as count
                FROM  tweet
                WHERE DATE(created_at) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                AND MATCH(text) AGAINST ('$q' IN BOOLEAN MODE)
                GROUP BY source
                ORDER BY count DESC
                LIMIT $limit";
        $res = database::performQuery($sql);
        $plot = [];
        while ($data = $res->fetch_assoc()) {
            $plot[] = "['$data[source]',$data[count]]";
        }

        $values = implode(",", $plot);

        return "
        $(function () {
            $('#container-tweetSources-".trim($q)."').highcharts({
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45
                    }
                },
                title: {
                    text: 'Sources for $q between $_SESSION[date_from] and $_SESSION[date_to]'
                },

                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    }
                },
                series: [{
                    name: 'Tweets',
                    data: [
                        $values
                    ]
                }]
            });
        });
        		";
    }

    public static function prepUTCDate() {
        $month =date('m',strtotime($_SESSION['date_from'])) - 1;
        $year = date("Y",strtotime($_SESSION['date_from']));
        $day = date("d",strtotime($_SESSION['date_from']));

        return $year.",".$month.",".$day;
    }

     //Activity graph
    public static function largeActivityGraph($q) {
        $plot = [];
        $days = howManyDays($_SESSION['date_from'], $_SESSION['date_to']);

        //Days are more than 3
        if($days > 2)
        {
        $count = 0;
       $date_from = $_SESSION['date_from'];
        while ($count <= $days) {
            $plot[]=self::countDayTweets($q, $date_from);
            //Add one day
            $date_from = date('Y-m-d',strtotime('+1 day', strtotime($date_from)));
            $count++;
        }



            $values = implode(",", $plot);

        return"
    $(function () {
    $('#container-activity-".trim($q)."').highcharts({
        chart: {
            zoomType: 'x'
        },
        title: {
            text: 'Activity Report for $q between $_SESSION[date_from] and $_SESSION[date_to]'
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' :
                    'Pinch the chart to zoom in'
        },
        xAxis: {
            type: 'datetime',
            minRange: 4 * 24 * 3600000 // four days
        },
        yAxis: {
            title: {
                text: 'Number of Tweets'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },

        series: [{
            type: 'area',
            name: 'Tweets',
            pointInterval: 24 * 3600 * 1000,
            pointStart: Date.UTC(".self::prepUTCDate()."),
            data: [   $values  ]
        }]
    });
});
	";
    }
    //Days are less than 2, Plot by Hours
    else
    {

        $from = $_SESSION['date_from'].' 00:00:00';
        $to = $_SESSION['date_to'].' 23:59:59';
        $hours =  howManyHours($from, $to);

        $count = 0;
            while ($count <= $hours) {
            $date = date("Y-m-d", strtotime($from));
            $hour = date("H", strtotime($from));
            $plot[]=self::countHourTweets($q, $date,$hour);
            //Add one hour on each iteration
             $from = date("Y-m-d H:i:s",strtotime('+1 hour', strtotime($from)));
            $count++;
        }



        $values = implode(",", $plot);

        return"
    $(function () {
    $('#container-activity-".trim($q)."').highcharts({
            chart: {
            zoomType: 'x'
        },
        title: {
        text: 'Activity Report for $q between $_SESSION[date_from] and $_SESSION[date_to]'
        },
        subtitle: {
        text: document.ontouchstart === undefined ?
        'Click and drag in the plot area to zoom in' :
        'Pinch the chart to zoom in'
        },
        xAxis: {
        type: 'datetime',
        minRange: 4 * 3600000 // four hours
        },
        yAxis: {
        title: {
        text: 'Number of Tweets'
        }
        },
        legend: {
        enabled: false
        },
        plotOptions: {
        area: {
        fillColor: {
        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
        stops: [
        [0, Highcharts.getOptions().colors[0]],
        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
        ]
        },
        marker: {
        radius: 2
        },
        lineWidth: 1,
        states: {
        hover: {
        lineWidth: 1
        }
        },
        threshold: null
        }
        },

        series: [{
        type: 'area',
        name: 'Tweets',
        pointInterval: 3600 * 1000,
        pointStart: Date.UTC(".self::prepUTCDate()."),
        data: [   $values  ]
        }]
        });
        });
        ";
    }



    }
    public static function countDayTweets($q,$date) {
    $sql = "SELECT COUNT(*) as count
        FROM  tweet
        WHERE DATE(created_at) = '$date'
        AND MATCH(text) AGAINST ('$q' IN BOOLEAN MODE)";
        $res = database::performQuery($sql);
        $data = $res->fetch_assoc();
        return $data['count'];

    }


    public static function countHourTweets($q,$date,$hour) {
        $sql = "SELECT COUNT(*) as count
        FROM  tweet
        WHERE DATE(created_at) = '$date'
        AND HOUR (created_at) = '$hour'
        AND MATCH(text) AGAINST ('$q' IN BOOLEAN MODE)";
        $res = database::performQuery($sql);
        $data = $res->fetch_assoc();
        return $data['count'];

    }


    public static function sentimentPieChart($q) {



        return"$(function () {

    $(document).ready(function () {

        // Build the chart
        $('#container-sentiment').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Content sentiment for $q between $_SESSION[date_from] and $_SESSION[date_to]'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b> Tweets Made'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Sentiment by Tweets',
                data: [
                     ['Negative',   ".self::sentimentCount($q, 2)."],
                     ['Positive',  ".self::sentimentCount($q, 1)."],
                     ['Neutral',  ".self::sentimentCount($q, 3)."]
                ]
            }]
        });
    });

   });";
    }
	/**
	 * Sentiment count by sentiment
     * @param q
     * @param sentiment
     */public static function sentimentCount($q, $sentiment)
    {
        $sql = "SELECT COUNT(*) as count
        FROM  tweet
        WHERE DATE(created_at) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
        AND MATCH(text) AGAINST ('$q' IN BOOLEAN MODE)
        AND sentiment_type_id=$sentiment";
        $res = database::performQuery($sql);
        $data = $res->fetch_assoc();
        return $data['count'];
    }


    public static function plotArea($value=null,$value2=null,$value3=null,$value4=null) {
        return"
            $(function () {
    $('#container').highcharts({
        chart: {
            type: 'area'
        },
        title: {
            text: '$_SESSION[username] Insights between $_SESSION[date_from] and $_SESSION[date_to]'
        },

        xAxis: {
            allowDecimals: false,
            labels: {
                formatter: function () {
                    return this.value; // clean, unformatted number for year
                }
            }
        },
        yAxis: {
            title: {
                text: ''
            },
            labels: {
                formatter: function () {
                    return this.value / 1000 + 'k';
                }
            }
        },
        tooltip: {
            pointFormat: '{series.name} <b>{point.y:,.0f}</b><br/> on in {point.x}'
        },
        plotOptions: {
            area: {
                 pointStart: 2000,
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            }
        },
        series: [{
            name: 'Tweets',
            data: [null, null, null, null, null, 6, 11, 32, 110, 235, 369, 640,
                1005, 1436, 2063, 3057, 4618, 6444, 9822, 15468, 20434, 24126,
                22380, 21004, 17287, 14747, 13076, 12555, 12144, 11009, 10950]
        },
        {
            name: 'Retweets',
            data: [
                1005, 1436, 2063, 3057, 4618, 6444, 9822, 15468, 20434, 24126,
                27387, 29459, 31056, 31982, 32040, 31233, 29224, 27342, 26662,
                26956, 27912, 28999, 28965, 27826, 25579, 25722, 24826, 24605
                ]
        },{
            name: 'Mentions',
            data: [null, null, null, null, null, null, null, null, null, null,
                5, 25, 50, 120, 150, 200, 426, 660, 869, 1060, 1605, 2471, 3322,
                4238, 5221, 6129, 7089, 8339, 9399, 10538, 11643, 13092, 14478
               ]
        }]
    });
});
            ";
    }



    //Count mentions on specific day
    public static  function countMentionsDay($date,$id) {
        $sql = "SELECT COUNT(*) as count
        FROM tweet,tweet_mention
        WHERE DATE(created_at) = '$date'
        AND tweet.id=tweet_mention.tweet_id
        AND mention_id_str = $id
        ";
        $res = database::performQuery($sql);
        $count = $res->fetch_assoc();
        return $count['count'];
    }

    //Count mentions on specific day and hour
    public static function countMentionsHour($date,$hour,$id) {
        $sql = "SELECT COUNT(*) as count
        FROM tweet,tweet_mention
        WHERE DATE(created_at) = '$date'
        AND HOUR(created_at) = '$hour'
        AND tweet.id=tweet_mention.tweet_id
        AND mention_id_str = $id
        ";
        $res = database::performQuery($sql);
        $count = $res->fetch_assoc();
        return $count['count'];
    }






    //Plot activity graph
    public static function mentionActivityGraph($id) {
        $plot = [];
        $days = howManyDays($_SESSION['date_from'], $_SESSION['date_to']);

        //Days are more than 3
        if($days > 2)
        {
            $count = 0;
            $date_from = $_SESSION['date_from'];
            while ($count <= $days) {
                $plot[]=self::countMentionsDay($date_from,$id);
                //Add one day
                $date_from = date('Y-m-d',strtotime('+1 day', strtotime($date_from)));
                $count++;
            }



            $values = implode(",", $plot);
            $username = User::getUsername($id);

            return"
            $(function () {
            $('#container-mention-$id').highcharts({
            chart: {
            zoomType: 'x'
        },
        title: {
        text: 'Mention Report for $username between $_SESSION[date_from] and $_SESSION[date_to]'
        },
        subtitle: {
        text: document.ontouchstart === undefined ?
        'Click and drag in the plot area to zoom in' :
        'Pinch the chart to zoom in'
        },
        xAxis: {
        type: 'datetime',
        minRange: 4 * 24 * 3600000 // four days
        },
        yAxis: {
        title: {
        text: 'Number of Tweets'
        }
        },
        legend: {
        enabled: false
        },
        plotOptions: {
        area: {
        fillColor: {
        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
        stops: [
        [0, Highcharts.getOptions().colors[0]],
        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
        ]
        },
        marker: {
        radius: 2
        },
        lineWidth: 1,
        states: {
        hover: {
        lineWidth: 1
        }
        },
        threshold: null
        }
        },

        series: [{
        type: 'area',
        name: 'Tweets',
        pointInterval: 24 * 3600 * 1000,
        pointStart: Date.UTC(".Charts::prepUTCDate()."),
        data: [   $values  ]
        }]
        });
        });
        ";
        }
        //Days are less than 2, Plot by Hours
        else
            {

                $from = $_SESSION['date_from'].' 00:00:00';
                    $to = $_SESSION['date_to'].' 23:59:59';
                    $hours =  howManyHours($from, $to);

                    $count = 0;
                    while ($count <= $hours) {
                        $date = date("Y-m-d", strtotime($from));
                        $hour = date("H", strtotime($from));
                        $plot[]=self::countMentionsHour($date, $hour, $id);
                        //Add one hour on each iteration
                        $from = date("Y-m-d H:i:s",strtotime('+1 hour', strtotime($from)));
                        $count++;
                        }



                        $values = implode(",", $plot);
                        $username = User::getUsername($id);
                        return"
                        $(function () {
                        $('#container-mention-$id').highcharts({
                        chart: {
                        zoomType: 'x'
                        },
                        title: {
                        text: 'Mention Report for $username  between $_SESSION[date_from] and $_SESSION[date_to]'
                        },
                        subtitle: {
                        text: document.ontouchstart === undefined ?
                        'Click and drag in the plot area to zoom in' :
                        'Pinch the chart to zoom in'
                        },
                        xAxis: {
                        type: 'datetime',
                        minRange: 4 * 3600000 // four hours
                        },
                        yAxis: {
                        title: {
                        text: 'Number of Tweets'
                        }
                        },
                        legend: {
                        enabled: false
                        },
                        plotOptions: {
                        area: {
                        fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                        },
               marker: {
               radius: 2
       },
               lineWidth: 1,
               states: {
               hover: {
               lineWidth: 1
       }
       },
               threshold: null
       }
       },

               series: [{
               type: 'area',
               name: 'Tweets',
               pointInterval: 3600 * 1000,
               pointStart: Date.UTC(".Charts::prepUTCDate()."),
               data: [   $values  ]
       }]
       });
       });
               ";
       }



       }

       public static function mentionTweetSources($id,$limit=12)
       {
           $sql = "SELECT source,COUNT(*) as count
           FROM  tweet,tweet_mention
           WHERE DATE(created_at) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
           AND tweet.id=tweet_mention.tweet_id
           AND mention_id_str = $id
           GROUP BY source
           ORDER BY count DESC
           LIMIT $limit";
           $res = database::performQuery($sql);
           $plot = [];
           while ($data = $res->fetch_assoc()) {
               $plot[] = "['$data[source]',$data[count]]";
           }

           $values = implode(",", $plot);

           return "
        $(function () {
            $('#container-mention-sources-$id').highcharts({
                   chart: {
                   type: 'pie',
                   options3d: {
                   enabled: true,
                   alpha: 45
       }
       },
       title: {
       text: 'Sources for @".User::getUsername($id)." between $_SESSION[date_from] and $_SESSION[date_to]'
       },
        tooltip: {
                pointFormat: '{point.y} Tweets <br /><b>{point.percentage:.1f}%</b>'
            },

       plotOptions: {
       pie: {
       innerSize: 100,
       depth: 45
       }
       },
       series: [{
       name: 'Tweets',
       data: [
       $values
           ]
       }]
       });
       });
       ";
       }



       public static function mentionSentimentChart($id) {
           return"
$(function () {
    $('#container-mention-sentiment-$id').highcharts({


    chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Mentions of @".User::getUsername($id)." by sentiment.'
            },
            tooltip: {
                pointFormat: '{point.y} Tweets <br /><b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Tweets',
                data: [
                    ['Positive',    ".self::mentionSentimentCount($id, 1)."],
                        {
                        name: 'Negative',
                        y: ".self::mentionSentimentCount($id, 2).",
                        sliced: true,
                        selected: true
                    },
                    ['Neutral',   ".self::mentionSentimentCount($id, 3)."]
                ]
            }]




    });
});";
       }


       public static function mentionSentimentCount($id, $sentiment)
       {
           $sql = "SELECT COUNT(*) as count
           FROM  tweet,tweet_mention
           WHERE DATE(created_at) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
           AND tweet.id=tweet_mention.tweet_id
           AND mention_id_str = $id
           AND sentiment_type_id=$sentiment";
           $res = database::performQuery($sql);
           $data = $res->fetch_assoc();
           return $data['count'];
       }





       //Count tweets on specific day
       public static  function countTweetsDay($date,$id) {
           $sql = "SELECT COUNT(*) as count
           FROM tweet
           WHERE DATE(created_at) = '$date'
           AND oauth_uid = $id
           ";
           $res = database::performQuery($sql);
           $count = $res->fetch_assoc();
           return $count['count'];
       }

           //Count tweets on specific day and hour
           public static function countTweetsHour($date,$hour,$id) {
           $sql = "SELECT COUNT(*) as count
           FROM tweet
           WHERE DATE(created_at) = '$date'
           AND HOUR(created_at) = '$hour'
           AND oauth_uid = $id
           ";
           $res = database::performQuery($sql);
           $count = $res->fetch_assoc();
           return $count['count'];
           }






           //Plot tweet activity graph
           public static function tweetActivityGraph($id) {
           $plot = [];
           $days = howManyDays($_SESSION['date_from'], $_SESSION['date_to']);

           //Days are more than 3
           if($days > 2)
           {
               $count = 0;
           $date_from = $_SESSION['date_from'];
           while ($count <= $days) {
               $plot[]=self::countTweetsDay($date_from,$id);
                   //Add one day
                   $date_from = date('Y-m-d',strtotime('+1 day', strtotime($date_from)));
                   $count++;
                   }



                   $values = implode(",", $plot);
                   $username = User::getUsername($id);

                   return"
                   $(function () {
                   $('#container-tweet-$id').highcharts({
                   chart: {
                   zoomType: 'x'
           },
           title: {
           text: 'Tweet Report for $username between $_SESSION[date_from] and $_SESSION[date_to]'
           },
           subtitle: {
           text: document.ontouchstart === undefined ?
           'Click and drag in the plot area to zoom in' :
           'Pinch the chart to zoom in'
           },
           xAxis: {
           type: 'datetime',
           minRange: 4 * 24 * 3600000 // four days
           },
           yAxis: {
           title: {
           text: 'Number of Tweets'
           }
           },
           legend: {
           enabled: false
           },
           plotOptions: {
           area: {
           fillColor: {
           linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
           stops: [
           [0, Highcharts.getOptions().colors[0]],
           [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
           ]
           },
           marker: {
           radius: 2
           },
           lineWidth: 1,
           states: {
           hover: {
           lineWidth: 1
           }
           },
           threshold: null
           }
           },

           series: [{
           type: 'area',
           name: 'Tweets',
           pointInterval: 24 * 3600 * 1000,
           pointStart: Date.UTC(".Charts::prepUTCDate()."),
           data: [   $values  ]
           }]
           });
           });
           ";
           }
           //Days are less than 2, Plot by Hours
           else
           {

           $from = $_SESSION['date_from'].' 00:00:00';
           $to = $_SESSION['date_to'].' 23:59:59';
           $hours =  howManyHours($from, $to);

           $count = 0;
           while ($count <= $hours) {
               $date = date("Y-m-d", strtotime($from));
               $hour = date("H", strtotime($from));
                   $plot[]=self::countTweetsHour($date, $hour, $id);
                   //Add one hour on each iteration
                   $from = date("Y-m-d H:i:s",strtotime('+1 hour', strtotime($from)));
                       $count++;
                   }



                   $values = implode(",", $plot);
                   $username = User::getUsername($id);
                       return"
                       $(function () {
                       $('#container-tweet-$id').highcharts({
                       chart: {
                       zoomType: 'x'
                   },
                   title: {
                   text: 'Tweet Report for $username  between $_SESSION[date_from] and $_SESSION[date_to]'
                       },
                       subtitle: {
                       text: document.ontouchstart === undefined ?
                       'Click and drag in the plot area to zoom in' :
                       'Pinch the chart to zoom in'
                   },
                   xAxis: {
                   type: 'datetime',
                   minRange: 4 * 3600000 // four hours
                   },
                   yAxis: {
                   title: {
                   text: 'Number of Tweets'
                   }
                   },
                   legend: {
                   enabled: false
                   },
                   plotOptions: {
                   area: {
                   fillColor: {
                   linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                   stops: [
                   [0, Highcharts.getOptions().colors[0]],
                   [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                   ]
                   },
                   marker: {
                   radius: 2
                   },
                   lineWidth: 1,
                   states: {
                   hover: {
                   lineWidth: 1
                   }
                   },
                   threshold: null
                   }
                   },

                   series: [{
                   type: 'area',
                   name: 'Tweets',
                   pointInterval: 3600 * 1000,
                   pointStart: Date.UTC(".Charts::prepUTCDate()."),
                   data: [   $values  ]
                   }]
                   });
                   });
                   ";
                   }



                   }

                   public static function tweetTweetSources($id,$limit=12)
                   {
                   $sql = "SELECT source,COUNT(*) as count
                   FROM  tweet
                   WHERE DATE(created_at) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                   AND oauth_uid = $id
                   GROUP BY source
                   ORDER BY count DESC
                   LIMIT $limit";
                   $res = database::performQuery($sql);
                   $plot = [];
                   while ($data = $res->fetch_assoc()) {
                   $plot[] = "['$data[source]',$data[count]]";
                   }

                   $values = implode(",", $plot);

                   return "
                   $(function () {
                   $('#container-tweet-sources-$id').highcharts({
                       chart: {
                       type: 'pie',
                       options3d: {
                       enabled: true,
                   alpha: 45
                   }
           },
           title: {
           text: 'Sources for @".User::getUsername($id)." between $_SESSION[date_from] and $_SESSION[date_to]'
           },
               tooltip: {
               pointFormat: '{point.y} Tweets <br /><b>{point.percentage:.1f}%</b>'
           },

               plotOptions: {
               pie: {
               innerSize: 100,
               depth: 45
           }
           },
               series: [{
               name: 'Tweets',
               data: [
               $values
           ]
           }]
           });
           });
           ";
           }



           public static function tweetSentimentChart($id) {
               return"
               $(function () {
                   $('#container-tweet-sentiment-$id').highcharts({


                       chart: {
                   plotBackgroundColor: null,
                   plotBorderWidth: null,
                   plotShadow: false
           },
           title: {
           text: 'Tweets of @".User::getUsername($id)." by sentiment.'
           },
           tooltip: {
           pointFormat: '{point.y} Tweets <br /><b>{point.percentage:.1f}%</b>'
           },
           plotOptions: {
           pie: {
           allowPointSelect: true,
           cursor: 'pointer',
           dataLabels: {
           enabled: false
           },
           showInLegend: true
           }
           },
           series: [{
           type: 'pie',
           name: 'Tweets',
           data: [
           ['Positive',    ".self::tweetSentimentCount($id, 1)."],
           {
           name: 'Negative',
           y: ".self::tweetSentimentCount($id, 2).",
           sliced: true,
           selected: true
           },
           ['Neutral',   ".self::tweetSentimentCount($id, 3)."]
           ]
           }]




           });
           });";
           }


           public static function tweetSentimentCount($id, $sentiment)
           {
           $sql = "SELECT COUNT(*) as count
           FROM  tweet
           WHERE DATE(created_at) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
           AND oauth_uid = $id
           AND sentiment_type_id=$sentiment";
           $res = database::performQuery($sql);
           $data = $res->fetch_assoc();
           return $data['count'];
       }




       //Count tweets on specific day
       public static  function countRepliesDay($date,$id) {
           $sql = "SELECT COUNT(*) as count
           FROM tweet
           WHERE DATE(created_at) = '$date'
           AND in_reply_to_user_id_str = $id
           ";
           $res = database::performQuery($sql);
           $count = $res->fetch_assoc();
           return $count['count'];
       }

       //Count tweets on specific day and hour
       public static function countRepliesHour($date,$hour,$id) {
       $sql = "SELECT COUNT(*) as count
       FROM tweet
       WHERE DATE(created_at) = '$date'
       AND HOUR(created_at) = '$hour'
       AND in_reply_to_user_id_str = $id
       ";
       $res = database::performQuery($sql);
       $count = $res->fetch_assoc();
       return $count['count'];
       }






       //Plot tweet activity graph
       public static function repliesActivityGraph($id) {
       $plot = [];
           $days = howManyDays($_SESSION['date_from'], $_SESSION['date_to']);

           //Days are more than 3
           if($days > 2)
               {
               $count = 0;
               $date_from = $_SESSION['date_from'];
                   while ($count <= $days) {
                   $plot[]=self::countRepliesDay($date_from,$id);
                   //Add one day
                   $date_from = date('Y-m-d',strtotime('+1 day', strtotime($date_from)));
                   $count++;
                   }



                   $values = implode(",", $plot);
                       $username = User::getUsername($id);

                       return"
                       $(function () {
                           $('#container-reply-$id').highcharts({
                           chart: {
                           zoomType: 'x'
                   },
                   title: {
                   text: 'Replies Report for $username between $_SESSION[date_from] and $_SESSION[date_to]'
                   },
                   subtitle: {
                   text: document.ontouchstart === undefined ?
                   'Click and drag in the plot area to zoom in' :
                   'Pinch the chart to zoom in'
                   },
                   xAxis: {
                   type: 'datetime',
                   minRange: 4 * 24 * 3600000 // four days
                   },
                   yAxis: {
                   title: {
                   text: 'Number of Tweets'
                   }
                   },
                   legend: {
                   enabled: false
                   },
                   plotOptions: {
                   area: {
                   fillColor: {
                   linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                   stops: [
                   [0, Highcharts.getOptions().colors[0]],
                   [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                   ]
                   },
                   marker: {
                   radius: 2
                   },
                   lineWidth: 1,
                   states: {
                   hover: {
                   lineWidth: 1
                   }
                   },
                   threshold: null
                   }
                   },

                   series: [{
                   type: 'area',
                   name: 'Tweets',
                   pointInterval: 24 * 3600 * 1000,
                   pointStart: Date.UTC(".Charts::prepUTCDate()."),
                   data: [   $values  ]
                   }]
                   });
                   });
                   ";
                   }
                   //Days are less than 2, Plot by Hours
                   else
                   {

                   $from = $_SESSION['date_from'].' 00:00:00';
                   $to = $_SESSION['date_to'].' 23:59:59';
                   $hours =  howManyHours($from, $to);

                   $count = 0;
                   while ($count <= $hours) {
                   $date = date("Y-m-d", strtotime($from));
                   $hour = date("H", strtotime($from));
                       $plot[]=self::countRepliesHour($date, $hour, $id);
                       //Add one hour on each iteration
                           $from = date("Y-m-d H:i:s",strtotime('+1 hour', strtotime($from)));
                           $count++;
                   }



                       $values = implode(",", $plot);
                       $username = User::getUsername($id);
                       return"
                       $(function () {
                       $('#container-reply-$id').highcharts({
                       chart: {
                       zoomType: 'x'
                   },
                   title: {
                   text: 'Replies Report for $username  between $_SESSION[date_from] and $_SESSION[date_to]'
                   },
                   subtitle: {
                   text: document.ontouchstart === undefined ?
                   'Click and drag in the plot area to zoom in' :
                   'Pinch the chart to zoom in'
                   },
                   xAxis: {
                   type: 'datetime',
                   minRange: 4 * 3600000 // four hours
                   },
                   yAxis: {
                   title: {
                   text: 'Number of Tweets'
                   }
                   },
                   legend: {
                   enabled: false
                   },
                   plotOptions: {
                   area: {
                   fillColor: {
                   linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                   stops: [
                   [0, Highcharts.getOptions().colors[0]],
                   [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                   ]
                   },
                   marker: {
                   radius: 2
                   },
                   lineWidth: 1,
                   states: {
                   hover: {
                   lineWidth: 1
                   }
                   },
                   threshold: null
                   }
                   },

                   series: [{
                   type: 'area',
                   name: 'Tweets',
                   pointInterval: 3600 * 1000,
                   pointStart: Date.UTC(".Charts::prepUTCDate()."),
                   data: [   $values  ]
                   }]
                   });
                   });
                   ";
                   }



                   }

                   public static function repliesTweetSources($id,$limit=12)
                   {
                   $sql = "SELECT source,COUNT(*) as count
                   FROM  tweet
                   WHERE DATE(created_at) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
                   AND in_reply_to_user_id_str = $id
                   GROUP BY source
                   ORDER BY count DESC
                   LIMIT $limit";
                   $res = database::performQuery($sql);
                   $plot = [];
                   while ($data = $res->fetch_assoc()) {
                   $plot[] = "['$data[source]',$data[count]]";
                   }

                   $values = implode(",", $plot);

                   return "
                   $(function () {
                   $('#container-reply-sources-$id').highcharts({
                   chart: {
                   type: 'pie',
                   options3d: {
                   enabled: true,
                   alpha: 45
               }
               },
               title: {
               text: 'Sources for @".User::getUsername($id)."'s Replies between $_SESSION[date_from] and $_SESSION[date_to]'
               },
               tooltip: {
               pointFormat: '{point.y} Tweets <br /><b>{point.percentage:.1f}%</b>'
               },

               plotOptions: {
               pie: {
               innerSize: 100,
               depth: 45
               }
               },
               series: [{
               name: 'Tweets',
               data: [
               $values
               ]
               }]
               });
       });
       ";
       }



       public static function repliesSentimentChart($id) {
       return"
       $(function () {
           $('#container-reply-sentiment-$id').highcharts({


           chart: {
           plotBackgroundColor: null,
           plotBorderWidth: null,
           plotShadow: false
       },
       title: {
       text: 'Tweets of @".User::getUsername($id)." by sentiment.'
       },
       tooltip: {
       pointFormat: '{point.y} Tweets <br /><b>{point.percentage:.1f}%</b>'
       },
       plotOptions: {
       pie: {
       allowPointSelect: true,
       cursor: 'pointer',
       dataLabels: {
       enabled: false
       },
       showInLegend: true
       }
       },
       series: [{
       type: 'pie',
       name: 'Tweets',
       data: [
       ['Positive',    ".self::repliesSentimentCount($id, 1)."],
       {
       name: 'Negative',
       y: ".self::repliesSentimentCount($id, 2).",
       sliced: true,
       selected: true
       },
       ['Neutral',   ".self::repliesSentimentCount($id, 3)."]
       ]
       }]




       });
       });";
       }


       public static function repliesSentimentCount($id, $sentiment)
       {
       $sql = "SELECT COUNT(*) as count
       FROM  tweet
       WHERE DATE(created_at) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'
       AND in_reply_to_user_id_str = $id
       AND sentiment_type_id=$sentiment";
       $res = database::performQuery($sql);
       $data = $res->fetch_assoc();
       return $data['count'];
       }







}

?>