$(document).ready(function(){

  function showBarGraph()
  {
    {
      $.post("../php/hostsys.inc.php",
      {
        getReportData:1,
      },
      function (data)
      {

        const parseData = JSON.parse(data);
                //console.log(parseData);
                //console.log(parseData[0].month_name);
                var monthname = [];
                var sales = [];

                for(var i=0;i<parseData.length;i++) {
                  monthname.push(parseData[i].month_name);
                  sales.push(parseData[i].sales_made);
                }

                var chartdata = {
                  labels: monthname,
                  
                  datasets: [
                  {
                    data: sales,
                    label: 'Sales made',
                    fill:false,

                    /*backgroundColor: 'green',
                    borderColor: '#82caff',
                    hoverBackgroundColor: '#CCCCCC',
                    hoverBorderColor: '#666666'*/

                  }
                  ]
                };

                var graphTarget = $("#graphCanvas");
                 if(window.bar != undefined)
                  window.bar.destroy();

                  window.bar = new Chart(graphTarget, {
                  type: 'bar',
                  data: chartdata,
                  options: {
                    title: {
                      display: true,
                      text: 'Barchart showing the growth of sales generated over months',
                    },

                    plugins: {
                      colorschemes: {
                        scheme: 'tableau.GoldPurple7'
                      }
                    },
                  }
                });
              });
    }
  }


  function showPieChart()
  {
    {
      $.post("../php/hostsys.inc.php",
      {
        getReportData:1,
      },
      function (data)
      {
        var parseData = JSON.parse(data);
        var monthname = [];
        var sales = [];

        for (var i=0;i<parseData.length;i++) {
          monthname.push(parseData[i].month_name);
          sales.push(parseData[i].sales_made);
        }

        var chartdata = {
          labels: monthname,
          datasets: [
          {
            label: 'Sales made',
            backgroundColor: ['#b87333','orange','grey','#B1FB17',
            'white','#82caff',
            '#7D0552','#006400','#4B0082',
            'pink','black','red'
            ],
            borderColor: '#b87333',
            hoverBackgroundColor: '#CCCCCC',
            hoverBorderColor: '#666666',
            data: sales
          }
          ]
        };

        var graphTarget = $("#graphCanvas");
         if(window.bar != undefined)
         window.bar.destroy();

         window.bar = new Chart(graphTarget, {
          type: 'pie',
          data: chartdata,
          options: {
            title: {
              display: true,
              text: 'Piechart showing the growth of sales generated over month'
            }
          }
        });
      });
    }
  }

  function showLineChart()
  {
    {
      $.post("../php/hostsys.inc.php",
      {
        getReportData:1,
      },
      function (data)
      {

        var monthname = [];
        var sales = [];
        const parseData = JSON.parse(data);

        for (var i= 0;i<parseData.length;i++) {
          monthname.push(parseData[i].month_name);
          sales.push(parseData[i].sales_made);
        }

        var chartdata = {
          labels: monthname,
          datasets: [
          {
            label: 'Sales made',
            data: sales,
            fill: false,
            backgroundColor: '#ffa62f',
            borderColor: '#ffa62f',
          }
          ]
        };

        var graphTarget = $("#graphCanvas");
         if(window.bar != undefined)
          window.bar.destroy();

         window.bar = new Chart(graphTarget, {
          type: 'line',
          data: chartdata,
          options: {
            title: {
              display: true,
              text: 'Linegraph showing sales generated per month'
            }
          }
        });
      });
    }
  }

  $("#barchart").click(function () {
   $(".report-panel").css("display","none");

   showBarGraph();
 });

  $("#piedrawing").click(function () {
   $(".report-panel").css("display","none");
   showPieChart();

 });
  $("#linegraph").click(function () {
   $(".report-panel").css("display","none");
   showLineChart();

 });

  $('#cashierz_table').Tabledit({
   url:'../php/updates.inc.php',
   buttons:{
     delete:{
      html: '<span class="glyphicon glyphicon-trash" id="delete"></span>',
      action:'DeleteCashier',
    },
    edit:{
      html: '<span class="glyphicon glyphicon-pencil" id="edit"></span>',
      action:'EditCashierDetails',
    }
  },
  columns:{
    identifier:[0, "id"],
    editable:[[1,'CashierName'],[2,'MobileNo'],[3,'Address'],
    [4,'Email']]
  },
        // $("edit").css('background','blue'),
        restoreButton:false,
        onSuccess:function(data, textStatus, jqXHR){
          console.log(data);
          if(data.action == 'delete'){
            $('#'+data.id).remove();
          }
          
        }
      });

  $("#limit-CashierRecords").change(function(){
    $('#CashierRecords-form').submit();
      //alert(this.value);
    });

  var cashier_label = $('#cashier-search-label').val();
  $("#cashier-search-label").typeahead({
    source:function(query,result){
      $.ajax({
        url:'../php/hostsys.inc.php',
        method:'POST',
        data:{
          SearchCashier:1,
          CashierQuery:cashier_label
        },
        dataType:'json',
        success: function(data){
          result($.map(data, function(item){
            return item;
          }));
        },
        error:function(data){
          console.log(data);
        },
      });
    }
  });





});