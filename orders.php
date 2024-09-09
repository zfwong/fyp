<?php 
require_once 'php_action/db_connect.php';
require_once 'includes/header.php';

if($_GET['o'] == 'add') { 
  echo "<div class='div-request div-hide'>add</div>";
} else if($_GET['o'] == 'manord') { 
  echo "<div class='div-request div-hide'>manord</div>";
} else if($_GET['o'] == 'editOrd') { 
  echo "<div class='div-request div-hide'>editOrd</div>";
}

?>

<ol class="breadcrumb">
  <li><a href="dashboard.php">Home</a></li>
  <li>Orders</a></li>
  <li class="active">
  <?php if ($_GET['o'] == 'add') { ?>
  Add Orders
  <?php } else if ($_GET['o'] == 'manord') { ?>
  Manage Orders
  <?php } ?>
  </li>
</ol>

<div class="panel panel-info plus">
  <div class="panel-heading">
  <?php if ($_GET['o'] == 'add') { ?>
  <i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Add Order&nbsp;&nbsp;<a class="glyphicon glyphicon-question-sign" title="Help" data-toggle="modal" data-target="#showAddHelpModal"></a>
  <?php } else if ($_GET['o'] == 'manord') { ?>
  <i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Manage Orders&nbsp;&nbsp;<a class="glyphicon glyphicon-question-sign" title="Help" data-toggle="modal" data-target="#showManordHelpModal"></a>
  <?php } else if ($_GET['o'] == 'editOrd') { ?>
  <i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit Order
  <?php } ?>
  </div>
  <div class="panel-body">
  <?php if ($_GET['o'] == 'add') { ?>

  <div class="success-messages"></div>

  <form class="form-horizontal" id="createOrderForm" action="php_action/createOrder.php" method="POST">
    <div class="form-group">
      <label for="orderDate" class="col-sm-2 control-label">Order Date :</label>
      <div class="col-sm-10">
        <input type="text" class="form-control datePicker" id="orderDate" name="orderDate" placeholder="Order Date" autocomplete="off">
      </div>
    </div>

    <div class="form-group">
      <label for="orderSupplier" class="col-sm-2 control-label">Supplier :</label>
      <div class="col-sm-10">
        <select class="form-control" id="orderSupplier" name="orderSupplier" onchange="getSupplierData()">
        <option value="">~~SELECT~~</option>
        <?php
        $sql = "SELECT supplier_id, supplier_name FROM supplier WHERE supplier_active = 1 AND supplier_status = 1";
        $result = $connect->query($sql);

        while ($row = $result->fetch_array()) {
          $supplierId = $row[0];
          $supplierName = $row[1];
          echo "<option value='".$supplierId."'>".$supplierName."</option>";
        }
        ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="orderContact" class="col-sm-2 control-label">Supplier Contact :</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="orderContact" name="orderContact" readonly="true">
      </div>
    </div>

    <hr style="border-color: grey" />

    <table class="table" id="productTable">
      <thead>
        <tr>              
          <th style="width:40%;">Product</th>
          <th style="width:20%;">Cost / Unit (RM)</th>
          <th style="width:15%;">Quantity</th>
          <th style="width:15%;">Total (RM)</th>
          <th style="width:10%;"><button type="button" class="btn btn-default" onclick="addProductRow()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Item</button></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $arrayNumber = 0;
        for ($x = 1; $x < 4; $x++) { ?>
          <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
            <td>
              <div class="form-group">
                <select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" style="width: 97%">
                  <option value="">~~SELECT~~</option>
                  <?php
                  $productSql = "SELECT * FROM product WHERE active = 1 AND status = 1";
                  $result = $connect->query($productSql);

                  while ($row = $result->fetch_array()) {
                    echo "<option value='".$row['product_id']."'>".$row['product_name']."</option>";
                  }
                  ?>
                </select>
              </div>
            </td>
            <td>
              <input type="text" class="form-control" name="productCost[]" id="productCost<?php echo $x; ?>" readonly="true">
              <input type="hidden" class="form-control" name="productCostValue[]" id="productCostValue<?php echo $x; ?>">
            </td>
            <td style="padding-left: 20px">
              <div class="form-group">
                <input type="number" class="form-control" name="productQty[]" id="productQty<?php echo $x; ?>" min="1" onkeyup="getTotal(<?php echo $x; ?>)" onchange="getTotal(<?php echo $x; ?>)" autocomplete="off">
              </div>
            </td>
            <td style="padding-left: 20px">
              <input type="text" class="form-control" name="productTotal[]" id="productTotal<?php echo $x; ?>" readonly="true">
              <input type="hidden" class="form-control" name="productTotalValue[]" id="productTotalValue<?php echo $x; ?>">
            </td>
            <td>
              <button type="button" class="btn btn-default" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
            </td>
          </tr>
        <?php
        $arrayNumber++;
        }
        ?>
      </tbody>
    </table>

    <hr style="border-color: grey" />
    <div class="row">
      <div class="col-sm-8">
        <div class="form-group">
          <label for="paymentMethod" class="col-sm-3 control-label">Payment Method :</label>
          <div class="col-sm-4">
            <select class="form-control" name="paymentMethod" id="paymentMethod">
              <option value="">~~SELECT~~</option>
              <option value="1">Cash</option>
              <option value="2">Cheque</option>
              <option value="3">Credit Card</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label for="subTotal" class="col-sm-4 control-label">SubTotal:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true">
            <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue">
          </div>
        </div>
        <div class="form-group">
          <label for="gst" class="col-sm-4 control-label">GST 6% :</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="gst" name="gst" disabled="true">
            <input type="hidden" class="form-control" id="gstValue" name="gstValue">
          </div>
        </div>
        <hr style="border-color: grey" />
        <div class="form-group">
          <label for="grandTotal" class="col-sm-4 control-label">Grand Total :</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" style="font-weight: bold">
            <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" style="font-weight: bold">
          </div>
        </div>
        <div class="form-group">
          <label for="paid" class="col-sm-4 control-label">Paid (RM) :</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="paid" name="paid" onkeyup="getPaidAmount()" autocomplete="off">
          </div>
        </div>
        <hr style="border-color: grey" />
        <div class="form-group">
          <label for="due" class="col-sm-4 control-label">Due (RM) :</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="due" name="due" disabled="true" style="font-weight: bold">
            <input type="hidden" class="form-control" id="dueValue" name="dueValue" style="font-weight: bold">
          </div>
        </div>
      </div>
    </div>

    <hr style="border-color: grey" />
    <div class="col-sm-4 col-sm-offset-9">
      <button type="reset" class="btn btn-default" onclick="resetOrderForm()"><i class="glyphicon glyphicon-erase"></i>&nbsp;&nbsp;Reset</button>
      <button type="submit" class="btn btn-success" id="createOrderBtn" data-loading-text="Loading..."><i class="glyphicon glyphicon-ok-sign"></i>&nbsp;&nbsp;Save Changes</button>
    </div>

  </form>
  
  <?php } else if ($_GET['o'] == 'manord') { ?>

  <div class="success-messages"></div>

  <table class="display compact" id="manageOrderTable">
    <thead>
      <th>No.</th>
      <th>Order Date</th>
      <th>Supplier</th>
      <th>Contact</th>
      <th>Total Order Item</th>
      <th>Order Status</th>
      <th style="width: 15%">Option</th>
    </thead>
  </table>

  <?php } else if ($_GET['o'] == 'editOrd') { ?>

  <div class="success-messages"></div>

  <form class="form-horizontal" id="editOrderForm" action="php_action/editOrder.php" method="POST">
    <?php
    $orderId = $_GET['i'];
    $sql = "SELECT orders.order_id, orders.order_date, orders.supplier_id, orders.supplier_contact, orders.sub_total, orders.gst, orders.grand_total, orders.paid, orders.due, orders.payment_method, orders.order_active FROM orders WHERE orders.order_id = {$orderId}";

    $result = $connect->query($sql);
    $data = $result->fetch_row();
    ?>

    <div class="form-group">
      <label for="orderDate" class="col-sm-2 control-label">Order Date :</label>
      <div class="col-sm-10">
        <input type="text" class="form-control datePicker" id="orderDate" name="orderDate" value="<?php echo date('d-m-Y', strtotime($data[1])); ?>" placeholder="Order Date" autocomplete="off">
      </div>
    </div>

    <div class="form-group">
      <label for="orderSupplier" class="col-sm-2 control-label">Supplier :</label>
      <div class="col-sm-10">
        <select class="form-control" id="orderSupplier" name="orderSupplier" onchange="getSupplierData()">
        <option value="">~~SELECT~~</option>
        <?php
        $sql = "SELECT supplier_id, supplier_name FROM supplier WHERE supplier_active = 1 AND supplier_status = 1";
        $result = $connect->query($sql);

        while ($row = $result->fetch_array()) {
          $supplierId = $row[0];
          $supplierName = $row[1];
          $selected = "";
          if ($supplierId == $data[2]) {
            $selected = "selected";
          } else{
            $selected = "";
          }
          echo "<option value='".$supplierId."' ".$selected.">".$supplierName."</option>";
        }
        ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="orderContact" class="col-sm-2 control-label">Supplier Contact :</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="orderContact" name="orderContact" value="<?php echo $data[3]; ?>" readonly="true">
      </div>
    </div>

    <hr style="border-color: grey" />

    <table class="table" id="productTable">
      <thead>
        <tr>              
          <th style="width:40%;">Product</th>
          <th style="width:20%;">Cost / Unit (RM)</th>
          <th style="width:15%;">Quantity</th>
          <th style="width:15%;">Total (RM)</th>
          <th style="width:10%;"><button type="button" class="btn btn-default" onclick="addProductRow()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Item</button></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $orderItemSql = "SELECT orders_items.orders_item_id, orders_items.order_id, orders_items.product_id, orders_items.quantity, orders_items.cost, orders_items.total FROM orders_items WHERE orders_items.order_id = {$orderId}";
        $orderItemResult = $connect->query($orderItemSql); 
        $arrayNumber = 0;
        $x = 1;
        while ($orderItemData = $orderItemResult->fetch_array()) { ?>
          <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
            <td>
              <div class="form-group">
                <select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" style="width: 97%">
                  <option value="">~~SELECT~~</option>
                  <?php
                  $productSql = "SELECT * FROM product WHERE active = 1 AND status = 1";
                  $result = $connect->query($productSql);

                  while ($row = $result->fetch_array()) {
                    $selected = "";
                    if ($row['product_id'] == $orderItemData['product_id']) {
                      $selected = "selected";
                    } else {
                      $selected = "";
                    }
                    echo "<option value='".$row['product_id']."' ".$selected.">".$row['product_name']."</option>";
                  }
                  ?>
                </select>
              </div>
            </td>
            <td>
              <input type="text" class="form-control" name="productCost[]" id="productCost<?php echo $x; ?>" readonly="true" value="<?php echo $orderItemData['cost']; ?>">
              <input type="hidden" class="form-control" name="productCostValue[]" id="productCostValue<?php echo $x; ?>"  value="<?php echo $orderItemData['cost']; ?>">
            </td>
            <td style="padding-left: 20px">
              <div class="form-group">
                <input type="number" class="form-control" name="productQty[]" id="productQty<?php echo $x; ?>" value="<?php echo $orderItemData['quantity']; ?>" min="1" onkeyup="getTotal(<?php echo $x; ?>)" onchange="getTotal(<?php echo $x; ?>)" autocomplete="off">
              </div>
            </td>
            <td style="padding-left: 20px">
              <input type="text" class="form-control" name="productTotal[]" id="productTotal<?php echo $x; ?>" value="<?php echo $orderItemData['total']; ?>" readonly="true">
              <input type="hidden" class="form-control" name="productTotalValue[]" id="productTotalValue<?php echo $x; ?>" value="<?php echo $orderItemData['total']; ?>">
            </td>
            <td>
              <button type="button" class="btn btn-default" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
            </td>
          </tr>
        <?php
        $arrayNumber++;
        $x++;
        }
        ?>
      </tbody>
    </table>

    <hr style="border-color: grey" />
    <div class="row">
      <div class="col-sm-8">
        <div class="form-group">
          <label for="paymentMethod" class="col-sm-3 control-label">Payment Method :</label>
          <div class="col-sm-4">
            <select class="form-control" name="paymentMethod" id="paymentMethod">
              <option value="">~~SELECT~~</option>
              <option value="1"
              <?php if ($data[9] == 1) {
                echo "selected";}; ?> >Cash</option>
              <option value="2"
              <?php if ($data[9] == 2) {
                echo "selected";}; ?> >Cheque</option>
              <option value="3"
              <?php if ($data[9] == 3) {
                echo "selected";}; ?> >Credit Card</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="orderStatus" class="col-sm-3 control-label">Order Status :</label>
          <div class="col-sm-4">
            <select class="form-control" name="orderStatus" id="orderStatus">
              <option value="">~~SELECT~~</option>
              <option value="1"
              <?php if ($data[10] == 1) {
                echo "selected";}; ?> >Completed</option>
              <option value="2"
              <?php if ($data[10] == 2) {
                echo "selected";}; ?> >Ongoing</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label for="subTotal" class="col-sm-4 control-label">SubTotal:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="subTotal" name="subTotal" value="<?php echo $data[4]; ?>" disabled="true">
            <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="<?php echo $data[4]; ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="gst" class="col-sm-4 control-label">GST 6% :</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="gst" name="gst" value="<?php echo $data[5]; ?>" disabled="true">
            <input type="hidden" class="form-control" id="gstValue" name="gstValue" value="<?php echo $data[5]; ?>">
          </div>
        </div>
        <hr style="border-color: grey" />
        <div class="form-group">
          <label for="grandTotal" class="col-sm-4 control-label">Grand Total :</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="grandTotal" name="grandTotal" value="<?php echo $data[6]; ?>" disabled="true" style="font-weight: bold">
            <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" value="<?php echo $data[6]; ?>" style="font-weight: bold">
          </div>
        </div>
        <div class="form-group">
          <label for="paid" class="col-sm-4 control-label">Paid (RM) :</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="paid" name="paid" value="<?php echo $data[7]; ?>" onkeyup="getPaidAmount()" autocomplete="off">
          </div>
        </div>
        <hr style="border-color: grey" />
        <div class="form-group">
          <label for="due" class="col-sm-4 control-label">Due (RM) :</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="due" name="due" value="<?php echo $data[8]; ?>" disabled="true" style="font-weight: bold">
            <input type="hidden" class="form-control" id="dueValue" name="dueValue" value="<?php echo $data[8]; ?>" style="font-weight: bold">
          </div>
        </div>
      </div>
    </div>

    <hr style="border-color: grey" />
    <div class="col-sm-4 col-sm-offset-9">
      <input type="hidden" name="orderId" id="orderId" value="<?php echo $_GET['i'];?>">
      <button type="button" class="btn btn-default" onclick="javascript:history.go(-1)"><i class="glyphicon glyphicon-chevron-left"></i>&nbsp;&nbsp;Back</button>
      <button type="submit" class="btn btn-success" id="createOrderBtn" data-loading-text="Loading..."><i class="glyphicon glyphicon-ok-sign"></i>&nbsp;&nbsp;Save Changes</button>
    </div>

  </form>

  <?php } ?>

  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="removeOrderModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: url(../stock_system/custom/css/bg-image3.jpg) center fixed no-repeat;background-size: contain;color: white;border-radius: 5px 5px 0 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove Modal</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;&nbsp;No</button>
        <button type="button" class="btn btn-primary" id="removeOrderBtn" data-loading-text="Loading..."><i class="glyphicon glyphicon-ok-sign"></i>&nbsp;&nbsp;Confirm</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="showManordHelpModal">
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
              <b>This is a Manage Orders table where user can view and manage the orders.</b><br />
              User can edit, remove existing records, and print the records in a fast and easy way. Allow user for presentation or storage in both written material and data.
            </div>
        </div>

        <hr />

        <div class="helpHow">
          <h4>How to...</h4>
          <div class="helpInfo">
            <a data-toggle="collapse" href="#collapseH1" aria-expanded="false" aria-controls="collapseH1">
              <h4>How do I add a new order?<span class="pull pull-right fa fa-caret-down"></span></h4>
            </a>
            <div class="collapse" id="collapseH1">
              <div class="well" style="margin-bottom: 0;">
                You can add a new order by click on the <button class="btn btn-default" style="border-radius: 0;padding: 15px;"><i class="fa fa-truck"></i>&nbsp;&nbsp;Orders&nbsp;&nbsp;<span class="caret"></span></button> menu at the top navigation bar, then, click on <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Add Orders&nbsp;&nbsp;</button> button.
              </div>
            </div>
          </div>

          <div class="helpInfo">
            <a data-toggle="collapse" href="#collapseH2" aria-expanded="false" aria-controls="collapseH2">
              <h4>How do I edit the order?<span class="pull pull-right fa fa-caret-down"></span></h4>
            </a>
            <div class="collapse" id="collapseH2">
              <div class="well" style="margin-bottom: 0;">
                You can edit the order by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Edit&nbsp;&nbsp;</button> button.
              </div>
            </div>
          </div>

          <div class="helpInfo">
            <a data-toggle="collapse" href="#collapseH3" aria-expanded="false" aria-controls="collapseH3">
              <h4>How do I remove the order?<span class="pull pull-right fa fa-caret-down"></span></h4>
            </a>
            <div class="collapse" id="collapseH3">
              <div class="well" style="margin-bottom: 0;">
                You can remove the order by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Remove&nbsp;&nbsp;</button> button.
              </div>
            </div>
          </div>

          <div class="helpInfo">
            <a data-toggle="collapse" href="#collapseH4" aria-expanded="false" aria-controls="collapseH4">
              <h4>How do I print the order?<span class="pull pull-right fa fa-caret-down"></span></h4>
            </a>
            <div class="collapse" id="collapseH4">
              <div class="well" style="margin-bottom: 0;">
                You can print the order by click on the <a type="button" class="btn btn-default dropdown-toggle"> Action <span class="caret"></span></a> button at the Options column of the table, then, click on the <button class="well" style="padding: 3px 20px;"><i class="glyphicon glyphicon-print"></i>&nbsp;&nbsp;Print&nbsp;&nbsp;</button> button.
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

<div class="modal fade" tabindex="-1" role="dialog" id="showAddHelpModal">
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
              <b>This is Add Order Form where user can create new orders.</b><br />
              This page contain the informations of the order and auto-calculating system which helps user to calculate as the user input the number.
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="custom/js/order.js"></script>

<?php require_once 'includes/footer.php'; ?>