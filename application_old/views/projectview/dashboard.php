<?php /*?>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyCAEvzYa61muASjsV_CqZ_v0WkQwoqENHk'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Sale'],
          ['Germany', 300000.00],
          ['United States', 400000.00],
          ['Brazil', 300000.00],
          ['Canada', 100000.00],
          ['France', 200000.00],
          ['RU', 700000.00],
		  ['BW', 300000.00],
		  ['India', 800000.00]		  
        ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>
 
   
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content" ng-app="Accounts"  ng-controller="experimental_report_dashboard" >
		
	
          
		 <div class="row">
			
			<div class="col-lg-3">
			  <!-- small box -->
			  <div class="small-box bg-aqua">
				<div class="inner">
				  <h3>150</h3>
				  <p>Total Sales amount</p>
				</div>
				<div class="icon">
				  <i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div><!-- ./col -->
			
			<div class="col-lg-3">
			  <!-- small box -->
			  <div class="small-box bg-green">
				<div class="inner">
				  <h3>53<sup style="font-size: 20px">%</sup></h3>
				  <p>Total Sales Margin</p>
				</div>
				<div class="icon">
				  <i class="ion ion-arrow-graph-down-right"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div><!-- ./col -->
			
			<div class="col-lg-3">
			  <!-- small box -->
			  <div class="small-box bg-aqua">
				<div class="inner">
				  <h3>30<sup style="font-size: 20px">%</sup></h3>
				  <p>Sales Margin %</p>
				</div>
				<div class="icon">
				  <i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div><!-- ./col -->
			
			<div class="col-lg-3">
			  <!-- small box -->
			  <div class="small-box bg-green">
				<div class="inner">
				  <h3>53</h3>
				  <p>Total Sales Costs</p>
				</div>
				<div class="icon">
				  <i class="ion ion-arrow-graph-down-right"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div><!-- ./col -->
			
		 </div>
		  
		  <!-- Small boxes (Stat box) -->
          <div class="row">
          
		 		  <div class="col-lg-4">
		  	
			 <div class="row">
				<div class="col-lg-6">
				  <!-- small box -->
				  <div class="small-box bg-aqua">
					<div class="inner">
					  <h3>$6,075,020</h3>
					  <p>Turnover of New customers</p>
					</div>
					<div class="icon">
					  <i class="ion ion-bag"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				<div class="col-lg-6">
				  <!-- small box -->
				  <div class="small-box bg-green">
					<div class="inner">
					  <h3>$530<sup style="font-size: 20px"></sup></h3>
					  <p>Turnover per Customer</p>
					</div>
					<div class="icon">
					  <i class="ion ion-stats-bars"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
			 </div>
			 <div class="row">
				<div class="col-lg-6">
				  <!-- small box -->
				  <div class="small-box bg-yellow">
					<div class="inner">
					  <h3>44</h3>
					  <p>Distinct New customers</p>
					</div>
					<div class="icon">
					  <i class="ion ion-person-add"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				<div class="col-lg-6">
				  <!-- small box -->
				  <div class="small-box bg-red">
					<div class="inner">
					  <h3>65</h3>
					  <p>Average Selling Price</p>
					</div>
					<div class="icon">
					  <i class="ion ion-social-usd"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
			 </div>
			 
			 <div class="row">
				<div class="col-lg-6">
				  <!-- small box -->
				  <div class="small-box bg-aqua">
					<div class="inner">
					  <h3>150</h3>
					  <p>Distinct Items Sold</p>
					</div>
					<div class="icon">
					  <i class="ion ion-bag"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				<div class="col-lg-6">
				  <!-- small box -->
				  <div class="small-box bg-green">
					<div class="inner">
					  <h3>53</h3>
					  <p>Total Sold Quantity</p>
					</div>
					<div class="icon">
					  <i class="ion ion-stats-bars"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
			 </div>
			 <div class="row">
				<div class="col-lg-6">
				  <!-- small box -->
				  <div class="small-box bg-yellow">
					<div class="inner">
					  <h3>44<sup style="font-size: 20px">%</sup></h3>
					  <p>Sales Costs %</p>
					</div>
					<div class="icon">
					  <i class="ion ion-person-add"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				<div class="col-lg-6">
				  <!-- small box -->
				  <div class="small-box bg-red">
					<div class="inner">
					  <h3>$650</h3>
					  <p>Total Sales Costs</p>
					</div>
					<div class="icon">
					  <i class="ion ion-pie-graph"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
			 </div>
			
			</div>
			
			 	<div class="col-lg-8">			 
				<div id="regions_div" ></div>			
          		</div><!-- /.row -->
			 
				<!--<div id="regions_div" ></div>-->
		 </div>
		 
		 <div class="panel panel-danger">		
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-12" align="center">
							 <button type="submit" class="btn btn-success"  ng-click="create_chart('sales_trend')">Sales Trend</button>
							 <button type="submit" class="btn btn-success"  ng-click="create_chart('category_wise_sale')">Category Wise Sale</button>
							 <button type="submit" class="btn btn-success"  ng-click="create_chart('top_20')">Top 20</button>
							 <button type="submit" class="btn btn-success"  ng-click="create_chart('bottom_20')">Bottom 20</button>
						</div>
					</div>
				</div>
		</div>	
	
		<!-- {{FormInputArray}}-->
	
		 
		 <div class="row">
				<div id="barchart_material" style="width:100%; height:600px;"></div>				 
		</div>
	   

        </section><!-- /.content -->
  <?php */?>
      
        <!-- Main content -->
        <section class="content" ng-app="Accounts" ng-controller="experimental_report_dashboard">
		
       <div class="row">
		  
		  <div class="col-lg-6">
				<div class="panel panel-primary" >
					  <div class="panel-heading "><strong>Sales Trend</strong></div>
					  <div class="panel-body" id="sales_trend" style="width:100%;height:400px;"></div>
				</div>
		  </div>
		 <div class="col-lg-6">
			<div class="panel panel-danger">
				  <div class="panel-heading">Category Wise Sales</div>
				  <div class="panel-body" id="category_wise_sale" style="width:100%;height:400px;"></div>
			</div>
		  </div> 
		</div>
		
		<div class="row">
		
		  <div class="col-lg-6">
				<div class="panel panel-warning" >
					  <div class="panel-heading "><strong>Top 20</strong></div>
					  <div class="panel-body" id="top_20" style="width:100%;height:400px;"></div>
				</div>
		  </div>
		 <div class="col-lg-6">
			<div class="panel panel-success">
				  <div class="panel-heading">Bottom 20</div>				 
				  <div class="panel-body" id="bottom_20" style="width:100%;height:400px;"></div>
			</div>
		  </div> 
		</div>
		
		<div class="row">
			<div class="panel panel-primary" >
				  <div class="panel-heading"><strong>Party Wise Sale</strong></div>
				  <div class="panel-body" id="party_wise_sale" style="width:100%;height:10000px;"></div>
			</div>
		</div>
		
		
		
		  
		  
          <div class="row"  >
		  
				  		 
		    <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable">

              <!-- Map box -->
           <?php /*?>   <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                  <!-- tools box -->
                 <!-- <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button>
                    <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" 
										style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                  </div>-->

                  <i class="fa fa-map-marker"></i>
                  <h3 class="box-title">Sales Trend</h3>
				   <div id="sales_trend" ></div>
                </div>
                <!--<div class="box-body" align="center">
                  <div id="sales_trend" style="height: 250px; width: 800px;"></div>
                </div>-->
             
              </div>
              <!-- /.box -->

              <!-- solid sales graph -->
              <div class="box box-solid bg-teal-gradient">
                <div class="box-header">
                  <i class="fa fa-th"></i>
                  <h3 class="box-title">category_wise_sale</h3>
                  <div class="box-tools pull-right">
                    <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body" align="center">
                  <div id="category_wise_sale" id="line-chart" style="height: 250px;"></div>
                </div><!-- /.box-body -->
              
              </div><!-- /.box --><?php */?>

          
            </section><!-- right col -->
			
			<section class="col-lg-6 connectedSortable">
<?php /*?>
              <!-- Map box -->
              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                  <!-- tools box -->
                  <!--<div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button>
                    <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" 
										style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                  </div>-->

                  <i class="fa fa-map-marker"></i>
                  <h3 class="box-title">Top 20</h3>
				  
                </div>
                <div class="box-body">
                  <div id="top_20" style="height: 250px; width: 100%;"></div>
                </div><!-- /.box-body-->
               
              </div>
              <!-- /.box -->

              <!-- solid sales graph -->
              <div class="box box-solid bg-teal-gradient">
                <div class="box-header">
                  <i class="fa fa-th"></i>
                  <h3 class="box-title">Bottom 20</h3>
                  <div class="box-tools pull-right">
                    <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body border-radius-none">
                  <div id="bottom_20" id="line-chart" style="height: 250px;"></div>
                </div><!-- /.box-body -->
              
              </div><!-- /.box -->
<?php */?>
          
            </section><!-- right col -->
			
			
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
		
	