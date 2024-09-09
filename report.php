<?php require_once 'includes/header.php'; ?>

<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>
		  <li class="active">Report</li>
		</ol>

		<div class="panel panel-info plus">
		  <div class="panel-heading"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Order Report&nbsp;&nbsp;<a class="glyphicon glyphicon-question-sign" title="Help" data-toggle="modal" data-target="#showHelpModal"></a></div>
		  <div class="panel-body">
		    <form class="form-horizontal" id="getOrderReportForm" action="php_action/getOrderReport.php" method="POST">
				  <div class="form-group">
				    <label for="reportStart" class="col-sm-2 control-label">Start Date :</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="reportStart" name="reportStart" autocomplete="off">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="reportEnd" class="col-sm-2 control-label">End Date :</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="reportEnd" name="reportEnd" autocomplete="off">
				    </div>
				  </div>
				  <br />
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				    	<button type="reset" class="btn btn-default" onclick="resetOrderReport()"><i class="glyphicon glyphicon-erase"></i>&nbsp;&nbsp;Reset</button>
				      <button type="submit" class="btn btn-primary" id="generateReport" name="generateReport"><i class="fa fa-clipboard"></i>&nbsp;&nbsp;Generate Report</button>
				    </div>
				  </div>
				</form>
		  </div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="showHelpModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: contain;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;&nbsp;Help</h4>
      </div>
      <div class="modal-body">
        
        <div class="helpWhat">
          <h4>What is this?</h4>
            <div class="well" style="margin-bottom: 0;">
              <b>This is Order Report where user can generate the order report according to the date.</b><br />
              User can generate the order report which is within a specific date range input by the user. 
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="custom/js/report.js"></script>
<?php require_once 'includes/footer.php'; ?>