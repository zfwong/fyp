<?php 
require_once 'includes/header.php';
require_once 'php_action/fetchEvent.php'; 

$productSql = "SELECT * FROM product WHERE status = 1";
$productResult = $connect->query($productSql);
$countProduct = $productResult->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderResult = $connect->query($orderSql);
$countOrder = $orderResult->num_rows;

$lowStockSql = "SELECT * FROM product WHERE quantity <= 5 AND status = 1";
$lowStockResult = $connect->query($lowStockSql);
$countLowStock = $lowStockResult->num_rows;

$connect->close();
?>


<!-- FullCalendar 3.2.1 CSS -->
<link rel="stylesheet" type="text/css" href="assets/plugins/fullcalendar/fullcalendar.min.css">
<!-- FullCalendar 3.2.1 PRINT CSS -->
<link rel="stylesheet" type="text/css" href="assets/plugins/fullcalendar/fullcalendar.print.css" media="print">
<div class="row">

		<div class="col-sm-4">
			<div class="panel panel-success plus">
			  <div class="panel-heading">
				  Total Stocks
				  <a href="product.php" class="badge pull pull-right">
				  	<?php echo $countProduct; ?>
				  </a>
			  </div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="panel panel-info plus">
			  <div class="panel-heading">
				  Total Orders
				  <a href="orders.php?o=manord" class="badge pull pull-right">
				  	<?php echo $countOrder; ?>
				  </a>
			  </div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="panel panel-danger plus">
			  <div class="panel-heading">
				  Low Stocks
				  <a href="product.php" class="badge pull pull-right">
				  	<?php echo $countLowStock; ?>
				  </a>
			  </div>
			</div>
		</div>

	<div class="col-md-4">
		<div class="card">
			<div class="cardHeader">
				<h1><?php echo date('d'); ?></h1>
			</div>
			<div class="cardContainer">
				<p><?php echo date('l').', '.date('d').' '.date('F').' '.date('Y'); ?></p>
			</div>
		</div>
		<br />

		<div class="card">
			<div class="cardHeader" style="background-color: #4a9992">
				<h2>EVENT</h2>
			</div>
			<div class="cardContainer padding-off">
        <button type="button" id="addEventBtn" class="btn btn-default pull pull-right" data-toggle="modal" data-target="#addEventModal" onclick="addEvent()"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Add Event</button>
				
				<table class="display compact" id="manageEventTable" style="width: 100%">
					<thead>
						<tr>
							<th style="width: 35%;">Date</th>
							<th>Title</th>
						</tr>
					</thead>
				</table>
				<br />
			</div>
		</div>
		<br />
	</div><!-- /col-md-4 -->

	<div class="col-md-8">
		<div class="panel panel-info plus">
		  <div class="panel-heading"><i class="glyphicon glyphicon-calendar"></i>&nbsp;&nbsp;Calendar&nbsp;&nbsp;<a class="glyphicon glyphicon-question-sign" title="Help" data-toggle="modal" data-target="#showHelpModal"></a></div>
		  <div class="panel-body">
		    <div id="calendar"></div>
		  </div>
		</div>
	</div>

</div><!-- /row -->

<div class="modal fade" tabindex="-1" role="dialog" id="addEventModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Event</h4>
      </div>

    	<form class="form-horizontal" id="createEventForm" action="php_action/createEvent.php" method="POST">

	      <div class="modal-body" style="overflow: auto;">
	        <div>

					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
					    
					    <li role="presentation" class="active"><a href="#addEventTab" aria-controls="info" role="tab" data-toggle="tab">Event Info</a></li>
					  </ul>

					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="addEventTab">
					    	<br />

							  <div class="form-group">
							    <label for="eventTitle" class="col-sm-3 control-label">Event Title :</label>
							    <div class="col-sm-9">
							      <input type="text" class="form-control" id="eventTitle" name="eventTitle" placeholder="Example: Meeting" autocomplete="off">
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="eventColor" class="col-sm-3 control-label">Event Color :</label>
							    <div class="col-sm-9">
								    <input type="color" class="form-control" id="eventColor" name="eventColor">
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="allDay" class="col-sm-3 control-label">All Day :</label>
							    <div class="col-sm-2">
								    <input type="checkbox" class="form-control" id="allDay" name="allDay">
								    <input type="hidden" class="form-control" id="eventAllDay" name="eventAllDay" value=0>
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="eventStart" class="col-sm-3 control-label">Start Date :</label>
							    <div class="col-sm-9">
								    <div class="input-group date" id="dateStart" name="dateStart">
								      <input type="text" class="form-control" id="eventStart" name="eventStart" placeholder="Example: 01-01-2017 00:00 AM" autocomplete="off">
								      <span class="input-group-addon">
			                	<span class="fa fa-calendar"></span>
			                </span>
								    </div>
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="eventEnd" class="col-sm-3 control-label">End Date :</label>
							    <div class="col-sm-9">
							      <div class="input-group date" id="dateEnd" name="dateEnd">
								      <input type="text" class="form-control" id="eventEnd" name="eventEnd" placeholder="Example: 01-01-2017 00:00 AM" autocomplete="off">
								      <span class="input-group-addon">
			                	<span class="fa fa-calendar"></span>
			                </span>
							      </div>
							    </div>
							  </div>
							
							  <div class="form-group">
							    <label for="eventDesc" class="col-sm-2 control-label">Description</label>
							    <br /><br />
							    <div class="col-sm-12">
							      <textarea class="form-control" rows="3" id="eventDesc" name="eventDesc" placeholder="Description..." autocomplete="off"></textarea>
							    </div>
							  </div>

					  	</div>
					    
					  </div><!-- /tab-content -->

					</div>
	      </div><!-- /modal-body -->

	      <div class="modal-footer">
	        <button type="button" id="addCloseBtn" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save changes</button>
	      </div>

			</form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="updatedEventModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header borderless">
        <h4 class="modal-title"><center><i class="fa fa-check enlarge"></i></center></h4>
      </div>
      <div class="modal-body solid-text">
        <center><h2>Success...</h2></center>
      </div>
      <div class="modal-body translucent">
      	<center><h4>Event Successfully Updated!</h4></center>
      </div>
      <div class="modal-footer borderless">
        <center><button type="button" class="btn btn-info enlarge" id="updatedEventBtn" data-dismiss="modal">OK</button></center>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="failedUpdateEventModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header borderless">
        <h4 class="modal-title"><center><i class="glyphicon glyphicon-remove enlarge"></i></center></h4>
      </div>
      <div class="modal-body solid-text">
        <center><h2>Failed...</h2></center>
      </div>
      <div class="modal-body translucent">
      	<center><h4>Event Update Failed!</h4></center>
      </div>
      <div class="modal-footer borderless">
        <center><button type="button" class="btn btn-info enlarge" id="updatedEventBtn" data-dismiss="modal">OK</button></center>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="showHelpModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;&nbsp;Help</h4>
      </div>
      <div class="modal-body">

      	<div class="helpWhat">
	      	<h4>What is...</h4>
	      	<div class="helpInfo">
	        	<a data-toggle="collapse" href="#collapseW1" aria-expanded="false" aria-controls="collapseW1">
						  <h4>What is Calendar?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseW1">
						  <div class="well" style="margin-bottom: 0;">
						    The calendar is not only for displaying date and time but also great for supporting user on managing and displaying events.
						  </div>
						</div>
        	</div>

        	<div class="helpInfo">
	        	<a data-toggle="collapse" href="#collapseW2" aria-expanded="false" aria-controls="collapseW2">
						  <h4>What is All Day?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseW2">
						  <div class="well" style="margin-bottom: 0;">
						    All Day means lasting or available throughout the day.
						  </div>
						</div>
        	</div>
        </div>

        <hr />

        <div class="helpHow">
		     	<h4>How to...</h4>
	      	<div class="helpInfo">
	        	<a data-toggle="collapse" href="#collapseH1" aria-expanded="false" aria-controls="collapseH1">
						  <h4>How do I add a new event?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH1">
						  <div class="well" style="margin-bottom: 0;">
						    You can add a new event by clicking the <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Add Event</button> button on the EVENT card on the left.
						  </div>
						</div>
	      	</div>

	      	<div class="helpInfo">
						<a data-toggle="collapse" href="#collapseH2" aria-expanded="false" aria-controls="collapseH2">
						  <h4>How do I edit an event?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH2">
						  <div class="well" style="margin-bottom: 0;">
						    You can edit event by double clicking the <span style="background-color: #008080;border-color: #008080;border-radius: 5px;padding: 5px;color: #fff;font-size: .85em;line-height: 1.3;font-weight: 400;">Event</span> tag on the Calendar, then click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the bottom-right corner, it will show the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit&nbsp;&nbsp;</button> button.
						  </div>
						</div>
	      	</div>

	      	<div class="helpInfo">
						<a data-toggle="collapse" href="#collapseH3" aria-expanded="false" aria-controls="collapseH3">
						  <h4>How do I remove an event?<span class="pull pull-right fa fa-caret-down"></span></h4>
						</a>
						<div class="collapse" id="collapseH3">
						  <div class="well" style="margin-bottom: 0;">
						    You can remove event by double clicking the <span style="background-color: #008080;border-color: #008080;border-radius: 5px;padding: 5px;color: #fff;font-size: .85em;line-height: 1.3;font-weight: 400;">Event</span> tag on the Calendar, then click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button, it will show the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove&nbsp;&nbsp;</button> button.
						  </div>
						</div>
	      	</div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="showEventModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;&nbsp;Event Information</h4>
      </div>

			<form class="form-horizontal">

	      <div class="modal-body" style="overflow: auto;">
	      	<div>

					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
					    
					    <li role="presentation" class="active"><a href="#showEventTab" aria-controls="profile" role="tab" data-toggle="tab">Event Info</a></li>
					    <li role="presentation"><a href="#showEventDescTab" aria-controls="profile" role="tab" data-toggle="tab">Description</a></li>
					  </ul>

					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane fade in active" id="showEventTab">
								<br />

							  <div class="form-group">
							    <label for="showEventTitle" class="col-sm-3 control-label">Event Title :</label>
							    <div class="col-sm-9">
							    	<input type="hidden" name="showEventId" id="showEventId">
							      <input type="text" class="form-control" id="showEventTitle" name="showEventTitle" autocomplete="off" disabled>
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="showEventColor" class="col-sm-3 control-label">Event Color :</label>
							    <div class="col-sm-2">
								    <input type="color" class="form-control" id="showEventColor" name="showEventColor" disabled>
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="showEventAllDay" class="col-sm-3 control-label">All Day :</label>
							    <div class="col-sm-2">
								    <input type="checkbox" class="form-control" id="showAllDay" name="showAllDay" disabled>
								    <input type="hidden" class="form-control" id="showEventAllDay" name="showEventAllDay" value=0>
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="showEventStart" class="col-sm-3 control-label">Start Date :</label>
							    <div class="col-sm-9">
								    <div class="input-group date" id="showDateStart" name="showDateStart">
								      <input type="text" class="form-control" id="showEventStart" name="showEventStart" autocomplete="off" disabled>
								    </div>
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="showEventEnd" class="col-sm-3 control-label">End Date :</label>
							    <div class="col-sm-9">
							      <div class="input-group date" id="showDateEnd" name="showDateEnd">
								      <input type="text" class="form-control" id="showEventEnd" name="showEventEnd" autocomplete="off" disabled>
							      </div>
							    </div>
							  </div>
					    </div>

					    <div role="tabpanel" class="tab-pane fade" id="showEventDescTab">
						    <div class="form-group">
								  <div class="modal-body">
								    <label for="editEventDesc" class="col-sm-2 control-label">Description</label>
								    <br /><br />
								    <div class="col-sm-12">
								      <textarea class="form-control" rows="6" id="showEventDesc" name="showEventDesc" placeholder="Description..." autocomplete="off" disabled></textarea>
								    </div>
								   </div>
							  </div>    	
					    </div>
					  </div><!-- /tab-content -->

					</div>
	      </div><!-- /modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!-- Single button -->
        <span class="dropdown">
					<div class="btn-group">
					  <a type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Action <span class="caret"></span>
					  </a>
					  <ul class="dropdown-menu">
						  <li><a href="button" data-toggle="modal" data-target="#editEventModal" onclick="editEvent(document.getElementById('showEventId').value)"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit</a></li>
					    <li><a class="removeBtn" href="button" data-toggle="modal" data-target="#removeEventModal" onclick="removeEvent(document.getElementById('showEventId').value)"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove</a></li>
					  </ul>
					</div>
				</span>
      </div>

    </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="editEventModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit Event</h4>
      </div>

    	<form class="form-horizontal" id="editEventForm" action="php_action/editEvent.php" method="POST">

	      <div class="modal-body" style="overflow: auto;">
	        <div>

					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
					    
					    <li role="presentation" class="active"><a href="#editEventTab" aria-controls="info" role="tab" data-toggle="tab">Event Info</a></li>
					  </ul>

					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="editEventTab">
					    	<br />

							  <div class="form-group">
							    <label for="editEventTitle" class="col-sm-3 control-label">Event Title :</label>
							    <div class="col-sm-9">
								    <input type="hidden" name="editEventId" id="editEventId">
							      <input type="text" class="form-control" id="editEventTitle" name="editEventTitle" autocomplete="off">
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="editEventColor" class="col-sm-3 control-label">Event Color :</label>
							    <div class="col-sm-9">
								    <input type="color" class="form-control" id="editEventColor" name="editEventColor" value="#ffc0cb">
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="editEventAllDay" class="col-sm-3 control-label">All Day :</label>
							    <div class="col-sm-2">
								    <input type="checkbox" class="form-control" id="editAllDay" name="editAllDay">
								    <input type="hidden" class="form-control" id="editEventAllDay" name="editEventAllDay" value=0>
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="editEventStart" class="col-sm-3 control-label">Start Date :</label>
							    <div class="col-sm-9">
								    <div class="input-group date" id="editDateStart" name="editDateStart">
								      <input type="text" class="form-control" id="editEventStart" name="editEventStart" autocomplete="off">
								      <span class="input-group-addon">
			                	<span class="fa fa-calendar"></span>
			                </span>
								    </div>
							    </div>
							  </div>

							  <div class="form-group">
							    <label for="editEventEnd" class="col-sm-3 control-label">End Date :</label>
							    <div class="col-sm-9">
							      <div class="input-group date" id="editDateEnd" name="editDateEnd">
								      <input type="text" class="form-control" id="editEventEnd" name="editEventEnd" autocomplete="off">
								      <span class="input-group-addon">
			                	<span class="fa fa-calendar"></span>
			                </span>
							      </div>
							    </div>
							  </div>
							
							  <div class="form-group">
							    <label for="editEventDesc" class="col-sm-2 control-label">Description</label>
							    <br /><br />
							    <div class="col-sm-12">
							      <textarea class="form-control" rows="3" id="editEventDesc" name="editEventDesc" placeholder="Description..." autocomplete="off"></textarea>
							    </div>
							  </div>
					  	
					  	</div>  
					  </div><!-- /tab-content -->

					</div>
	      </div><!-- /modal-body -->

	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save changes</button>
	      </div>

			</form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="removeEventModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: cover;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove this event ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="cancelRemoveEventBtn" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;&nbsp;No</button>
        <button type="button" class="btn btn-primary" id="removeEventBtn"><i class="glyphicon glyphicon-ok-sign"></i>&nbsp;&nbsp;Confirm</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Moment 2.18.1 js -->
<script type="text/javascript" src="assets/plugins/moment/moment.min.js"></script>
<!-- FullCalendar 3.2.0 js -->
<script type="text/javascript" src="assets/plugins/fullcalendar/fullcalendar.min.js"></script>

<script type="text/javascript">
/*initialization*/
$(document).ready(function() {

	// active top nav bar dashboard
	$("#navDashboard").addClass('active');

	// date for the calendar events
	var date = new Date();
	var d = date.getDate(),
	m = date.getMonth(),
	y = date.getFullYear();

	/*calendar*/
	$("#calendar").fullCalendar({
		header: {
			left: 'month, agendaWeek, agendaDay, today',
			center: 'title',
			right: 'listWeek, prev, next'
		},
		buttonText: {
			today: 'Today',
			month: 'Month',
			week: 'Week',
			day: 'Day',
			listWeek: 'List'
		},
		views: {
			day: {
				editable: false,
			},
			month: {
				timeFormat: 'h:mm A',
			},
		},
		eventOrder: 'start',
		timeFormat: 'DD-MM-YYYY h:mm A',
		defaultView: 'month',
		selectable: true,// enable click and highlight
		navLinks: true,// enable link to day number in month view and agendaWeek view
		eventLimit: true,// allow "more" link when too many events
		eventDurationEditable: false,
		events: [// initialize event
		<?php 
		if($result->num_rows > 0){ 
			while($row = $result->fetch_assoc()) { ?>
			{
				id: '<?php echo $row['event_id']; ?>',
				title: '<?php echo $row['event_title']; ?>',
				start: '<?php echo $row['startdate']; ?>',
				end: '<?php echo $row['enddate']; ?>',
				description: '<?php echo str_replace(array("\r\n", "\r", "\n"), "\\n", $row['event_desc']); ?>',
				color: '<?php echo $row['event_color']; ?>',
				allDay: <?php echo $row['allDay']; ?>,
			},
		<?php 
			}
		} ?>
		],

		/*double click show event*/
		eventRender: function(event, element) {
			element.bind('dblclick', function() {
				if (event.allDay == 1) {
					var formStart = $.fullCalendar.formatDate(event.start,'DD-MM-YYYY');
					var formEnd = $.fullCalendar.formatDate(event.end,'DD-MM-YYYY');
				} else {
					var formStart = $.fullCalendar.formatDate(event.start,'DD-MM-YYYY h:mm A');
					var formEnd = $.fullCalendar.formatDate(event.end,'DD-MM-YYYY h:mm A');
				}
				/*show event modal*/
				$("#showEventModal #showEventId").val(event.id);
				$("#showEventModal #showEventTitle").val(event.title);
				$("#showEventModal #showAllDay").val(event.allDay);
				$("#showEventModal #showEventAllDay").val(event.allDay);
				if ($("#showEventModal #showEventAllDay").val() == 1) {
					document.getElementById("showAllDay").checked = true;
				} else {
					document.getElementById("showAllDay").checked = false;
				}
				$("#showEventModal #showEventColor").val(event.color);
				$("#showEventModal #showEventStart").val(formStart);
				$("#showEventModal #showEventEnd").val(formEnd);
				$("#showEventModal #showEventDesc").val(event.description);
				$("#showEventModal").modal('show');

				/*edit event modal*/
				$("#editEventModal #editEventId").val(event.id);
				$("#editEventModal #editEventTitle").val(event.title);
				$("#editEventModal #editAllDay").val(event.allDay);
				$("#editEventModal #editEventAllDay").val(event.allDay);
				if ($("#editEventModal #editEventAllDay").val() == 1) {
					document.getElementById("editAllDay").checked = true;
				} else {
					document.getElementById("editAllDay").checked = false;
				}
				$("#editEventModal #editEventColor").val(event.color);
				$("#editEventModal #editEventStart").val(formStart);
				$("#editEventModal #editEventEnd").val(formEnd);
				$("#editEventModal #editEventDesc").val(event.description);
				
			});
		},

	});// /calendar

	/*date time picker initialize*/
	/*add date initialize*/
	$("#dateStart").datetimepicker({
		useCurrent: false,
		showClear: true,
		showClose: true,
		format: 'DD-MM-YYYY h:mm A',
		widgetPositioning: {
			horizontal: 'right',
			vertical: 'bottom',
		},
	});
	$("#dateEnd").datetimepicker({
		useCurrent: false,
		showClear: true,
		showClose: true,
		format: 'DD-MM-YYYY h:mm A',
		widgetPositioning: {
			horizontal: 'right',
			vertical: 'bottom',
		},
	});

	/*linked add date*/
	$("#dateStart").on("dp.change", function (e) {
    $('#dateEnd').data("DateTimePicker").minDate(e.date);
  });
  $("#dateEnd").on("dp.change", function (e) {
    $('#dateStart').data("DateTimePicker").maxDate(e.date);
  });

	/*edit date initialize*/
  $("#editDateStart").datetimepicker({
			useCurrent: false,
			format: 'DD-MM-YYYY h:mm A',
			showClear: true,
			showClose: true,
			widgetPositioning: {
				horizontal: 'left',
				vertical: 'bottom',
		},
	});
	$("#editDateEnd").datetimepicker({
			useCurrent: false, //default current date false
			format: 'DD-MM-YYYY h:mm A',
			showClear: true,
			showClose: true,
			widgetPositioning: {
				horizontal: 'left',
				vertical: 'bottom',
		},
	});

	/*linked edit date*/
	$("#editDateStart").on("dp.change", function (e) {
    $('#editDateEnd').data("DateTimePicker").minDate(e.date);
  });
  $("#editDateEnd").on("dp.change", function (e) {
    $('#editDateStart').data("DateTimePicker").maxDate(e.date);
  });
  /* /date time picker */
  
  /*smooth toggle dropdown*/
  $('.dropdown').on('show.bs.dropdown', function () {
  	$(this).find('.dropdown-menu').first().stop(true, true).slideDown(100);
	});

	$('.dropdown').on('hide.bs.dropdown', function () {
  	$(this).find('.dropdown-menu').first().stop(true, true).slideUp(100);
	});

	$("#allDay").on('click', function () {
		if ($(this).is(':checked')) {
			$("#eventAllDay").val(1);
			$("#dateStart").data('DateTimePicker').format("DD-MM-YYYY");
			$("#dateEnd").data('DateTimePicker').format("DD-MM-YYYY");
			$("#dateStart").on("dp.change", function (e) {
				if(e.date == false){
			    $("#dateEnd").data("DateTimePicker").minDate(false);
				} else {
			    $("#dateEnd").data("DateTimePicker").minDate(moment(e.date, "DD-MM-YYYY").add(1, 'day'));
			  }
		  });
		  $("#dateEnd").on("dp.change", function (e) {
		    $('#dateStart').data("DateTimePicker").maxDate(e.date);
		  });
		} else {
			$("#eventAllDay").val(0);
			$("#dateStart").data('DateTimePicker').format("DD-MM-YYYY h:mm A");
			$("#dateEnd").data('DateTimePicker').format("DD-MM-YYYY h:mm A");
			$("#dateStart").on("dp.change", function (e) {
		    $('#dateEnd').data("DateTimePicker").minDate(e.date);
		  });
		  $("#dateEnd").on("dp.change", function (e) {
		    $('#dateStart').data("DateTimePicker").maxDate(e.date);
		  });
		}
	});

	$("#editAllDay").on('click', function () {
		if ($(this).is(':checked')) {
			$("#editEventAllDay").val(1);
			$("#editDateStart").data('DateTimePicker').format("DD-MM-YYYY");
			$("#editDateEnd").data('DateTimePicker').format("DD-MM-YYYY");
			$("#editDateStart").on("dp.change", function (e) {
		    $("#editDateEnd").data("DateTimePicker").minDate(moment(e.date).add(1, 'day'));
		  });
		  $("#editDateEnd").on("dp.change", function (e) {
		    $('#editDateStart').data("DateTimePicker").maxDate(e.date);
		  });
		} else {
			$("#editEventAllDay").val(0);
			$("#editDateStart").data('DateTimePicker').format("DD-MM-YYYY h:mm A");
			$("#editDateEnd").data('DateTimePicker').format("DD-MM-YYYY h:mm A");
			$("#editDateStart").on("dp.change", function (e) {
		    $('#editDateEnd').data("DateTimePicker").minDate(e.date);
		  });
		  $("#editDateEnd").on("dp.change", function (e) {
		    $('#editDateStart').data("DateTimePicker").maxDate(e.date);
		  });
		}
	});
	
});// /document

</script>

<script type="text/javascript" src="custom/js/dashboard.js"></script>

<?php require_once 'includes/footer.php'; ?>