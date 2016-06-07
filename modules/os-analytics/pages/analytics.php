<?php 
//http://marocartiza.okadshop.com/modules/os-analytics/index.php
//https://ga-dev-tools.appspot.com/embed-api/third-party-visualizations/
//https://github.com/googleanalytics/ga-dev-tools/issues/51

function page_analytics(){
global $common;
$client_id = $common->select_mete_value('analytics_client_id');
?>
<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>

<style>
div[id^="chart"] {
width: 500px;
height: 300px;
}

#embed-api-auth-container{
margin-top: 7px;
position: inherit;
margin-right: 15px;
}

#selector-container{
background-color: #ddd;
margin: 0px auto;
display: inline-block;
width: 100%;
padding: 10px;
margin-bottom: 10px;
border-bottom: 2px solid #A5245E;
}

#selector-container table{
width: auto !important;
float: left;
}

.panel-body {
min-height: 324px;
}

.reportContainer {
float: left;
margin-bottom: 20px;
margin-right: 20px;
}

.chartContainer {
width: 500px;
height: 200px;
}

.chartTitleContainer {
width: 500px;
text-align: center;
font-weight: bold;
font-size: 1.5em;
}

.up {
color: green;
}

.down {
color: red;
}
</style>

<input type="hidden" value="<?=$client_id;?>" id="client_id">
  
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-bar-chart"></i> <?=l("Google Analytics", "analytics");?> - <span id="view-name"></span></h3>
  </div>
  <div id="embed-api-auth-container" class="pull-right"></div>
</div><br>


<div class="col-sm-12">
<div id="selector-container"></div>

<?php if( $client_id == "" ) : ?>
  <div class="alert alert-warning">
    <h4><?=l("Vous n'avez pas ajouter un ID Client", "analytics");?></h4>
    <a href="?module=modules&slug=os-analytics&page=analytics-config"><?=l("Cliquer ici pour l'ajouter.", "analytics");?></a>
  </div>
<?php endif; ?>
</div>

<div class="col-sm-6">
<div class="panel panel-default">
	<div class="panel-heading"><?=l("Visiteurs par Pays", "analytics");?></div>
	<div class="panel-body">
    <div id="countries-container"></div>
	</div><!--/ .panel-body -->
</div><!--/ .panel -->
</div><!--/ .col-sm-6 -->


<div class="col-sm-6">
<div class="panel panel-default">
  <div class="panel-heading"><?=l("Taux", "analytics");?></div>
  <div class="panel-body">
    <div id="timeline"></div>
  </div><!--/ .panel-body -->
</div><!--/ .panel -->
</div><!--/ .col-sm-6 -->

<div class="col-sm-12">
<div class="panel panel-default">
  <div class="panel-heading"><?=l("Sessions", "analytics");?></div>
  <div class="panel-body">
    <div id="sessions-container"></div>
  </div><!--/ .panel-body -->
</div><!--/ .panel -->
</div><!--/ .col-sm-12 -->



<!-- This demo uses the Chart.js graphing library and Moment.js to do date formatting and manipulation. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<!-- Include the ViewSelector2 component script. -->
<script src="http://marocartiza.okadshop.com/modules/os-analytics/js/view-selector2.js"></script>
<!-- Include the DateRangeSelector component script. -->
<script src="http://marocartiza.okadshop.com/modules/os-analytics/js/date-range-selector.js"></script>
<!-- Include the ActiveUsers component script. -->
<script src="http://marocartiza.okadshop.com/modules/os-analytics/js/active-users.js"></script>
<script>
var profiles;
var curProfile = 0;

function getProfiles(cb) {
  //do we have a cached version?
  if(sessionStorage["gaProfiles"]) {
    //console.log("profiles fetched from cache");
    cb(JSON.parse(sessionStorage["gaProfiles"]));
    return;
  }

  gapi.client.analytics.management.accounts.list().then(function(res) { 
    var accountId = res.result.items[0].id;
    var profiles = [];
    gapi.client.analytics.management.webproperties.list({'accountId': accountId}).then(function(res) {
  
      res.result.items.forEach(function(item) {
        if(item.defaultProfileId) profiles.push({id:"ga:"+item.defaultProfileId,name:item.name});
      });
      sessionStorage["gaProfiles"] = JSON.stringify(profiles);    
      cb(profiles);      
    });
  });
}

//Credit: https://ga-dev-tools.appspot.com/embed-api/third-party-visualizations/
function query(params) {
  return new Promise(function(resolve, reject) {
    var data = new gapi.analytics.report.Data({query: params});
    data.once('success', function(response) { resolve(response); })
        .once('error', function(response) { reject(response); })
        .execute();
  });
}

function makeCanvas(id) {
  var container = document.getElementById(id);
  var canvas = document.createElement('canvas');
  var ctx = canvas.getContext('2d');

  container.innerHTML = '';
  canvas.width = container.offsetWidth;
  canvas.height = container.offsetHeight;
  container.appendChild(canvas);

  return ctx;
}
      
function processProfiles() {
  console.log("working on profile "+profiles[curProfile].name);
  
  var now = moment();
  console.log('this week',moment(now).subtract(1, 'day').day(0).format('YYYY-MM-DD'),moment(now).format('YYYY-MM-DD') );
  console.log('this week',moment(now).subtract(8, 'day').format('YYYY-MM-DD'),moment(now).subtract(1,'day').format('YYYY-MM-DD') );
  console.log('last week',moment(now).subtract(15, 'day').format('YYYY-MM-DD'),moment(now).subtract(8,'day').format('YYYY-MM-DD') );
  //console.log('last week',moment(now).subtract(1, 'day').day(0).subtract(1, 'week').format('YYYY-MM-DD'),moment(now).subtract(1, 'day').day(6).subtract(1, 'week').format('YYYY-MM-DD') )

  var id = profiles[curProfile].id;
  
  var thisWeek = query({
    'ids': id,
    'dimensions': 'ga:date,ga:nthDay',
    'metrics': 'ga:pageviews',
    'start-date': moment(now).subtract(8, 'day').format('YYYY-MM-DD'),
    'end-date': moment(now).subtract(1,'day').format('YYYY-MM-DD')
  });

  var lastWeek = query({
    'ids': id,
    'dimensions': 'ga:date,ga:nthDay',
    'metrics': 'ga:pageviews',
    'start-date': moment(now).subtract(15, 'day').subtract(1, 'week')
    .format('YYYY-MM-DD'),
    'end-date': moment(now).subtract(8, 'day').subtract(1, 'week')
    .format('YYYY-MM-DD')
  });
    
    
  Promise.all([thisWeek, lastWeek]).then(function(results) {
    //console.log("Promise.all");console.dir(results);
      
    var data1 = results[0].rows.map(function(row) { return +row[2]; });
    var data2 = results[1].rows.map(function(row) { return +row[2]; });
    var labels = results[1].rows.map(function(row) { return +row[0]; });

    var totalThisWeek = results[0].totalsForAllResults["ga:pageviews"];
    var totalLastWeek = results[1].totalsForAllResults["ga:pageviews"];
    var percChange = (((totalThisWeek - totalLastWeek) / totalLastWeek) * 100).toFixed(2);
    console.log(totalLastWeek, totalThisWeek, percChange);
    
    labels = labels.map(function(label) {
      return moment(label, 'YYYYMMDD').format('ddd');
    });

    var data = {
      labels : labels,
      datasets : [
        {
          label: 'Last Week',
          fillColor : 'rgba(220,220,220,0.5)',
          strokeColor : 'rgba(220,220,220,1)',
          pointColor : 'rgba(220,220,220,1)',
          pointStrokeColor : '#fff',
          data : data2
        },
        {
          label: 'This Week',
          fillColor : 'rgba(151,187,205,0.5)',
          strokeColor : 'rgba(151,187,205,1)',
          pointColor : 'rgba(151,187,205,1)',
          pointStrokeColor : '#fff',
          data : data1
        }
      ]
    };

    var titleStr = profiles[curProfile].name + " ";
    if(totalLastWeek > 0 && totalThisWeek > 0) {
      if(percChange < 0) {
        titleStr += "<span class='down'>(Down "+Math.abs(percChange) + "%)</span>";
      } else {
        titleStr += "<span class='up'>(Up "+percChange + "%)</span>";      
      }
    }
        
    $("#timeline").append("<div class='reportContainer'><div class='chartTitleContainer'>"+titleStr+"</div><div class='chartContainer' id='chart-"+curProfile+"-container'></div></div>");

    new Chart(makeCanvas('chart-'+curProfile+'-container')).Line(data);

    if(curProfile+1 < profiles.length) {
      curProfile++;
      //settimeout to try to avoid GA rate limits
      setTimeout(processProfiles,200);
    }
  });
}



//console.log( processProfiles() );

gapi.analytics.ready(function() {



  /**
   * Authorize the user immediately if the user has already granted access.
   * If no access has been created, render an authorize button inside the
   * element with the ID "embed-api-auth-container".
   */
  gapi.analytics.auth.authorize({
    container: 'embed-api-auth-container',
    clientid: $('#client_id').val(),//'7051046564-iooramnc18lcnt6ec3bqtgsrp8gkimig.apps.googleusercontent.com',
    /*serverAuth: {
      access_token: '0vx_jrcPkpaaTL7mjdnJiKQa'
    }*/
  });

  //Create a ViewSelector for the first view to be rendered inside of an element
  var viewSelector = new gapi.analytics.ViewSelector({
    container: 'selector-container'
  });

  // Render both view selectors to the page.
  viewSelector.execute();



    /*gapi.analytics.auth.on('success', function(response) {

    //hide the auth-button
    document.querySelector("#auth-button").style.display='none';
      console.log("get profiles");
      getProfiles(function(profs) {
        window.profiles = profs;
        processProfiles();      
      });
    
    });*/


    getProfiles(function(profs) {
      window.profiles = profs;
      processProfiles();      
    });

    Chart.defaults.global.animationSteps = 60;
    Chart.defaults.global.animationEasing = 'easeInOutQuart';
    Chart.defaults.global.responsive = true;
    Chart.defaults.global.maintainAspectRatio = false;






  /**
   * Create the first DataChart for top countries over the past 30 days.
   * It will be rendered inside an element with the id "countries-container".
   */
  var dataChart1 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:country',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      'max-results': 6,
      sort: '-ga:sessions'
    },
    chart: {
      container: 'countries-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });



  /**
   * Create a new DataChart instance with the given query parameters
   * and Google chart options. It will be rendered inside an element
   * with the id "sessions-container".
   */
  var dataChart = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:date',
      'start-date': '30daysAgo',
      'end-date': 'yesterday'
    },
    chart: {
      container: 'sessions-container',
      type: 'LINE',
      options: {
        width: '100%'
      }
    }
  });






  //Render the dataChart on the page whenever a new view is selected.
  viewSelector.on('change', function(ids) {
    dataChart.set({query: {ids: ids}}).execute();
    dataChart1.set({query: {ids: ids}}).execute();
  });


});
</script>
<?php
}