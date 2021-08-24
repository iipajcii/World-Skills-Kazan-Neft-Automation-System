<?php 
    require_once "../../.env.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dashboard - Inventory Management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/buefy/dist/buefy.min.css">
    <script src="https://unpkg.com/buefy/dist/buefy.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <script type="text/javascript">
        var app_links = {
            inventory_transactions: "<?php echo $env_api['s2_inventory_transactions']; ?>",
            suppliers: "<?php echo $env_api['s2_suppliers']; ?>",
            warehouses: "<?php echo $env_api['s2_warehouses']; ?>",
            parts: "<?php echo $env_api['s2_parts']; ?>",
            inventory_report: "<?php echo $env_api['s2_inventory_report']; ?>",
            warehouse_management: "<?php echo $env_api['s2_warehouse_management']; ?>",
            purchase_order: "<?php echo $env_api['s2_purchase_order']; ?>",
            s2_remove_order_item: "<?php echo $env_api['s2_remove_order_item']; ?>",
        }
    </script>
</head>
<body>
	<?php
		include '../pieces/header.php';
	?>
	<div id="inventory-table" class="m-2 p-2">
	<div class="columns">
		<div class="column is-narrow"><button @click="purchaseOrderModalToggle()" class="button is-primary">Purchase Order Management</button></div>
		<div class="column is-narrow"><button @click="warehouseManagementModalToggle()" class="button is-primary">Warehouse Management</button></div>	
		<div class="column is-narrow"><button @click="inventoryReportModalToggle()" class="button is-primary">Inventory Report</button></div>	
	</div>
    	<div class="table-container">
            <table class="table is-fullwidth is-bordered">
                <thead>
                    <tr class="">
                        <th @click="changeCriteria('Name')" class="has-text-info has-text-centered" style="vertical-align: middle;">
                            <abbr title="Part Name">Part Name</abbr>
                            <span v-show="sort_criteria.Name == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.Name == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th @click="changeCriteria('TransactionName')" class="has-text-info has-text-left" style="vertical-align: middle;">
                            <abbr title="Transaction Type">Transaction Type</abbr>
                            <span v-show="sort_criteria.TransactionName == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.TransactionName == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th @click="changeCriteria('Date')" class="has-text-info has-text-left" style="vertical-align: middle;">
                            <abbr title="Date">Date</abbr>
                            <span v-show="sort_criteria.Date == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.Date == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th @click="changeCriteria('Amount')" class="has-text-info has-text-left" style="vertical-align: middle;">
                            <abbr title="Amount">Amount</abbr>
                            <span v-show="sort_criteria.Amount == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.Amount == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th @click="changeCriteria('SourceWarehouseName')" class="has-text-info has-text-left" style="vertical-align: middle;">
                            <abbr title="Source">Source</abbr>
                            <span v-show="sort_criteria.SourceWarehouseName == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.SourceWarehouseName == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th @click="changeCriteria('DestinationWarehouseName')" class="has-text-info has-text-left" style="vertical-align: middle;">
                            <abbr title="Destination">Destination</abbr>
                            <span v-show="sort_criteria.DestinationWarehouseName == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.DestinationWarehouseName == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Actions">Actions</abbr></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="">
                        <th @click="changeCriteria('Name')" class="has-text-info has-text-centered" style="vertical-align: middle;">
                            <abbr title="Part Name">Part Name</abbr>
                            <span v-show="sort_criteria.Name == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.Name == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th @click="changeCriteria('TransactionName')" class="has-text-info has-text-left" style="vertical-align: middle;">
                            <abbr title="Transaction Type">Transaction Type</abbr>
                            <span v-show="sort_criteria.TransactionName == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.TransactionName == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th @click="changeCriteria('Date')" class="has-text-info has-text-left" style="vertical-align: middle;">
                            <abbr title="Date">Date</abbr>
                            <span v-show="sort_criteria.Date == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.Date == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th @click="changeCriteria('Amount')" class="has-text-info has-text-left" style="vertical-align: middle;">
                            <abbr title="Amount">Amount</abbr>
                            <span v-show="sort_criteria.Amount == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.Amount == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th @click="changeCriteria('SourceWarehouseName')" class="has-text-info has-text-left" style="vertical-align: middle;">
                            <abbr title="Source">Source</abbr>
                            <span v-show="sort_criteria.SourceWarehouseName == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.SourceWarehouseName == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th @click="changeCriteria('DestinationWarehouseName')" class="has-text-info has-text-left" style="vertical-align: middle;">
                            <abbr title="Destination">Destination</abbr>
                            <span v-show="sort_criteria.DestinationWarehouseName == true" ><i class="fas fa-sort-up"></i></span>
                            <span v-show="sort_criteria.DestinationWarehouseName == false"><i class="fas fa-sort-down"></i></span>
                        </th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Actions">Actions</abbr></th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="(order, index) in sorted_inventory">
                        <td :name="order.Name" class="has-text-centered" style="vertical-align: middle;">{{order.Name}}</td>
                        <td :name="order.TransactionName" class="has-text-left" style="vertical-align: middle;">{{order.TransactionName}}</td>
                        <td :name="order.Date" class="has-text-left" style="vertical-align: middle;">{{order.Date}}</td>
                        <td :name="order.Amount" class="has-text-left" :class="{'has-background-success': order.TransactionName == 'Purchase Order'}" style="vertical-align: middle;">{{order.Amount}}</td>
                        <td :name="order.SourceWarehouseName" class="has-text-left" style="vertical-align: middle;" v-html="order.SourceWarehouseName == null ? '-- -- --' : order.SourceWarehouseName"></td>
                        <td :name="order.DestinationWarehouseName" class="has-text-left" style="vertical-align: middle;" v-html="order.DestinationWarehouseName == null ? '-- -- --' : order.DestinationWarehouseName"></td>
                        <td class="has-text-left" style="vertical-align: middle;"><button class="button">Edit</button><button @click="removeOrderItem(order.id)" class="ml-1 button is-danger is-light">Remove</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <b-modal v-model="isPurchaseOrderModalActive">
            <div class="card">
                <header class="card-header">
                </header>
                <div class="card-content">
                    <div>
                        <div>
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Suppliers</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select ref="po_supplier">
                                                    <option v-for="(supplier, index) in suppliers" :value="supplier.Name" :data-id="supplier.id">{{supplier.Name}}</option>
                                                    <option value="" selected>Please select a supplier</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Warehouse</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select ref="po_warehouse">
                                                    <option v-for="(warehouse, index) in warehouses" :value="warehouse.Name" :data-id="warehouse.id">{{warehouse.Name}}</option>
                                                    <option value="" selected>Please select a warehouse</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Date</label>
                                        <div class="control">
                                            <input ref="po_date" class="input" type="date" name="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="label mt-5 mb-3">Part List</label>
                        <div>
                            <div class="columns">
                                <div class="column">
                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label is-size-7">Part Name</label>
                                        </div>
                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    <div class="select is-small">
                                                        <select ref="po_part_name" v-model="selected_modal_part">
                                                            <option v-for="(part, index) in parts" :value="part.Name" :data-id="part.id">{{part.Name}}</option>
                                                            <option value="" selected>Please select a part</option>
                                                        </select>
                                                    </div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label is-size-7">Batch Number</label>
                                        </div>
                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    <input ref="po_part_batch" class="input is-small" type="text" name="batch" :disabled="!(selected_part.BatchNumberHasRequired)" :required="!(selected_part.BatchNumberHasRequired)"/>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label is-size-7">Amount</label>
                                        </div>
                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    <input ref="po_part_amount" min="0" class="input is-small" type="number" name="amount"/>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-narrow"><button @click="addToPartBasket" class="button is-small is-primary"><span class="has-size-5">+</span>&nbsp;Add To List </button></div>
                            </div>
                        </div>
                        <div class="columns mt-6 mt-4">
                            <div class="column is-full">
                                <div class="table-container">
                                    <table class="table is-fullwidth">
                                        <thead>
                                            <tr class="">
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Part Name">Part Name</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Batch">Batch</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Amount">Amount</abbr></th>
                                                <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Action">Action</abbr></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="">
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Part Name">Part Name</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Batch">Batch</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Amount">Amount</abbr></th>
                                                <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Action">Action</abbr></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr v-if="part_basket.length == 0">
                                                <td class="has-text-centered" colspan="4" style="vertical-align: middle;">No Parts Have Been Added</td>
                                            </tr>
                                            <tr v-for="(part, index) in part_basket">
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.name}}</td>
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.batch}}</td>
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.amount}}</td>
                                                <td class="has-text-centered" style="vertical-align: middle;"><a class="has-text-info" @click="part_basket.splice(index, 1);">Remove</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="has-text-centered">
                        <button @click="createPurchaseOrderRequest" class="button is-medium is-info m-5 pl-6 pr-6">Submit</button>
                        <button @click="purchaseOrderModalToggle" class="button is-medium is-danger m-5 pl-6 pr-6">Cancel</button>
                    </div>
                </div>
                <footer class="card-footer"></footer>
            </div>
        </b-modal>
        <b-modal v-model="isWarehouseManagementModalActive">
            <div class="card">
                <header class="card-header">
                </header>
                <div class="card-content">
                    <div>
                        <div>
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Source Warehouse</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select @change="changeWarehouse" ref="wm_source_warehouse">
                                                    <option v-for="(warehouse, index) in warehouses" :value="warehouse.id">{{warehouse.Name}}</option>
                                                    <option value="" selected>Please select a warehouse</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Destination Warehouse</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select @change="changeWarehouse" ref="wm_destination_warehouse">
                                                    <option v-for="(warehouse, index) in warehouses" :value="warehouse.id">{{warehouse.Name}}</option>
                                                    <option value="" selected>Please select a warehouse</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Date</label>
                                        <div class="control">
                                            <input ref="wm_date" class="input" type="date" name="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="label mt-5 mb-3">Part List</label>
                        <div>
                            <div class="columns">
                                <div class="column">
                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label is-size-7">Part Name</label>
                                        </div>
                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    <div class="select is-small">
                                                        <select ref="wm_part_name" v-model="selected_modal_part">
                                                            <option v-for="(part, index) in parts" :value="part.Name" :data-id="part.id">{{part.Name}}</option>
                                                            <option value="" selected>Please select a part</option>
                                                        </select>
                                                    </div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label is-size-7">Batch Number</label>
                                        </div>
                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    <input ref="wm_part_batch" class="input is-small" type="text" name="batch" :disabled="!(selected_part.BatchNumberHasRequired)" :required="!(selected_part.BatchNumberHasRequired)"/>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label is-size-7">Amount</label>
                                        </div>
                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    <input ref="wm_part_amount" min="0" class="input is-small" type="number" name="amount"/>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-narrow"><button @click="addToPartBasket" class="button is-small is-primary"><span class="has-size-5">+</span>&nbsp;Add To List </button></div>
                            </div>
                        </div>
                        <div class="columns mt-6 mt-4">
                            <div class="column is-full">
                                <div class="table-container">
                                    <table class="table is-fullwidth">
                                        <thead>
                                            <tr class="">
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Part Name">Part Name</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Batch">Batch</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Amount">Amount</abbr></th>
                                                <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Action">Action</abbr></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="">
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Part Name">Part Name</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Batch">Batch</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Amount">Amount</abbr></th>
                                                <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Action">Action</abbr></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr v-if="part_basket.length == 0">
                                                <td class="has-text-centered" colspan="4" style="vertical-align: middle;">No Parts Have Been Added</td>
                                            </tr>
                                            <tr v-for="(part, index) in part_basket">
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.name}}</td>
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.batch}}</td>
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.amount}}</td>
                                                <td class="has-text-centered" style="vertical-align: middle;"><a class="has-text-info" @click="part_basket.splice(index, 1)">Remove</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="has-text-centered">
                        <button @click="createWarehouseManagementRequest" class="button is-medium is-info m-5 pl-6 pr-6">Submit</button>
                        <button @click="warehouseManagementModalToggle" class="button is-medium is-danger m-5 pl-6 pr-6">Cancel</button>
                    </div>
                </div>
                <footer class="card-footer"></footer>
            </div>
        </b-modal>
        <b-modal v-model="isInventoryReportModalActive">
            <div class="card">
                <header class="card-header">
                </header>
                <div class="card-content">
                    <div>
                        <div>
                            <div class="columns is-vcentered">
                                <div class="column is-narrow">
                                    <div class="field">
                                        <label class="label">Warehouse</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select ref="ir_warehouse">
                                                    <option v-for="(warehouse, index) in warehouses" :value="warehouse.id">{{warehouse.Name}}</option>
                                                    <option value="" selected>Please select a warehouse</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-offset-1">
                                    <div class="columns is-multiline">
                                        <div class="column is-full has-text-left"><label class="label">Inventory Type</label></div>
                                        <div class="column is-full has-text-left">
                                            <div class="block">
                                                <b-radio v-model="inventoryReportType" name="name" native-value="current">Current Stock&nbsp;&nbsp;&nbsp;&nbsp;</b-radio>
                                                <b-radio v-model="inventoryReportType" name="name" native-value="received">Received Stock&nbsp;&nbsp;&nbsp;&nbsp;</b-radio>
                                                <b-radio v-model="inventoryReportType" name="name" native-value="out_of_stock">Out of Stock&nbsp;&nbsp;&nbsp;&nbsp;</b-radio>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="label mt-5 mb-3">Result</label>
                        <div class="columns">
                            <div class="column is-full">
                                <div class="table-container">
                                    <table class="table is-fullwidth">
                                        <thead>
                                            <tr class="">
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Part Name">Part Name</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Batch">Batch</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Amount">Amount</abbr></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="">
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Part Name">Part Name</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Batch">Batch</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Amount">Amount</abbr></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr v-if="inventory_report.length == 0">
                                                <td class="has-text-centered" colspan="4" style="vertical-align: middle;">No Report Has Been Generated</td>
                                            </tr>
                                            <tr v-for="(part, index) in sorted_inventory_report">
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.Name}}</td>
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.BatchNumber}}</td>
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.Amount}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="has-text-centered">
                        <button @click="getInventoryReport" class="button is-medium is-info m-5 pl-6 pr-6">Get Report</button>
                        <button @click="inventoryReportModalToggle" class="button is-medium is-danger m-5 pl-6 pr-6">Close</button>
                    </div>
                </div>
                <footer class="card-footer"></footer>
            </div>
        </b-modal>
    </div>
    <script type="text/javascript">
    	let inventoryTable = new Vue({
    		el:"#inventory-table",
            mounted(){
                this.getInventory();
                this.getSuppliers();
                this.getWarehouses();
                this.getParts();
            },
    		data(){
                return {
                	inventory:[],
                    inventory_report:[],
                    suppliers:[],
                    warehouses:[],
                    parts:[],
                    part_basket:[],
                    index: null,
                    isPurchaseOrderModalActive: false,
                    isWarehouseManagementModalActive: false,
                    isInventoryReportModalActive: false,
                    inventoryReportType: "",
                    selected_modal_part: "",
                    sort_criteria:{
                    	Name: null,
						TransactionName: null,
						Date: null,
						Amount: null,
						SourceWarehouseName: null,
						DestinationWarehouseName: null
                    }
                }
    		},
    		computed:{
                sorted_inventory(){
                    let sorted_inventory = this.inventory;
                    let criteria = Object.keys(this.sort_criteria);

                    for(counter = 0, count = criteria.length; counter < count; counter++){
                        if(this.sort_criteria[criteria[counter]] == true){
                            return sorted_inventory
                                .sort(function(a, b){
                                        let x = a[criteria[counter]];
                                        let y = b[criteria[counter]];
                                        if(x == null){x = "";}
                                        if(y == null){y = "";}
                                        return x > y;
                                }
                            )
                        }
                        else if(this.sort_criteria[criteria[counter]] == false){
                            return sorted_inventory
                                .sort(function(a, b){
                                        let x = a[criteria[counter]];
                                        let y = b[criteria[counter]];
                                        if(x == null){x = "";}
                                        if(y == null){y = "";}
                                        return x < y;
                                }
                            )
                        }
                    }

                    return sorted_inventory
                        .sort(function(a, b){
                            return a.Date > b.Date;
                        })
                        .sort(function(a, b){
                            if(a.TransactionTypeID == 1){
                                return false;
                            }
                            else {
                                return true;
                            }
                        });
                },
                selected_part(){
                    for(counter = 0, count = this.parts.length; counter < count; counter++){
                        if(this.selected_modal_part == this.parts[counter].Name){
                            return this.parts[counter];
                        }
                    }
                    return {}
                },
                inventory_report_type(){
                    switch(this.inventoryReportType){
                        case 'received':
                            return "Received Parts";
                            break;
                        case 'out_of_stock':
                            return "Out-Of-Stock Parts";
                            break;
                        case 'current':
                            return "Current Part Inventory";
                            break;
                        default:
                            return "";
                    }
                },
                sorted_inventory_report(){
                    return this.inventory_report
                        .sort(function(a, b){
                            if(a.Name < b.Name){
                                return false;
                            }
                            else {
                                return true;
                            }
                        });
                }
    		},
    		methods:{
                getInventory(){
                    let _this = this;
                    axios
                        .get(window.app_links.inventory_transactions)
                        .then(function(res){
                            _this.inventory = res.data;
                        })
                        .catch(function(res){
                            console.error(res.data);
                        })
                },
                getSuppliers(){
                    let _this = this;
                    axios
                        .get(window.app_links.suppliers)
                        .then(function(res){
                            _this.suppliers = res.data;
                        })
                        .catch(function(res){
                            console.error(res.data);
                        })
                },
                getWarehouses(){
                    let _this = this;
                    axios
                        .get(window.app_links.warehouses)
                        .then(function(res){
                            _this.warehouses = res.data;
                        })
                        .catch(function(res){
                            console.error(res.data);
                        })
                },
                getParts(){
                    let _this = this;
                    axios
                        .get(window.app_links.parts)
                        .then(function(res){
                            _this.parts = (res.data)
                                .sort(function(a,b){
                                    return a.Name.toLocaleLowerCase() > b.Name.toLocaleLowerCase();
                                })
                            ;
                        })
                        .catch(function(res){
                            console.error(res.data);
                        })
                },
                addToPartBasket(){
                    let part_amount = "";
                    if(this.isPurchaseOrderModalActive){
                        part_amount = this.$refs.po_part_amount
                    }
                    else if (this.isWarehouseManagementModalActive){
                        part_amount = this.$refs.wm_part_amount
                    }

                    let _this = this;
                    let isInHistory = false;                    
                    if(parseFloat(part_amount.value) < 1){
                        this.$buefy.dialog.alert({
                            title: 'Notice',
                            message: '"Amount cannot be less than 1"',
                            type: 'is-info',
                            ariaRole: 'alertdialog',
                            ariaModal: true
                        });
                        return;
                    }
                    //Checking if part to add is already in asset history
                    this.addToPartBasketFunction();
                    
                },
                addToPartBasketFunction(){
                    let part_amount = "";
                    let part_batch = "";
                    let part_name = "";
                    if(this.isPurchaseOrderModalActive){
                        part_amount = this.$refs.po_part_amount
                        part_batch = this.$refs.po_part_batch
                        part_name = this.$refs.po_part_name
                        part_id = this.$refs.po_part_name.options[this.$refs.po_part_name.options.selectedIndex].dataset.id;
                    }
                    else if (this.isWarehouseManagementModalActive){
                        part_amount = this.$refs.wm_part_amount
                        part_batch = this.$refs.wm_part_batch
                        part_name = this.$refs.wm_part_name
                        part_id = this.$refs.wm_part_name.options[this.$refs.wm_part_name.options.selectedIndex].dataset.id;
                    }

                    for(counter = 0, count = this.part_basket.length; counter < count; counter++){
                        if(this.part_basket[counter].name == part_name.value && this.part_basket[counter].batch == part_batch.value){
                            this.part_basket[counter].amount = parseFloat(this.part_basket[counter].amount) + parseFloat(part_amount.value);
                            part_name.value = "";
                            part_amount.value = "";
                            part_batch.value = "";
                            return;                            
                        }
                    }
                    this.part_basket.push({
                        name: part_name.value,
                        amount: parseFloat(part_amount.value),
                        batch: part_batch.value,
                        id: part_id
                    });
                    part_name.value = "";
                    part_amount.value = "";
                    part_batch.value = "";
                },
                changeCriteria(criteria){
                    let criteria_list = Object.keys(this.sort_criteria);
                    for(let counter = 0, count = criteria_list.length; counter < count; counter++){
                        if(criteria_list[counter] == criteria){continue;}
                        this.sort_criteria[criteria_list[counter]] = null;
                    }
                	if(this.sort_criteria[criteria] == null){
                		return this.sort_criteria[criteria] = true
                	}
                	else if(this.sort_criteria[criteria] == true){
                		return this.sort_criteria[criteria] = false
                	}
                	else if(this.sort_criteria[criteria] == false){
                		return this.sort_criteria[criteria] = null
                	}
                },
                purchaseOrderModalToggle(){
                    this.isPurchaseOrderModalActive = !this.isPurchaseOrderModalActive;
                },
                warehouseManagementModalToggle(){
                    this.isWarehouseManagementModalActive = !this.isWarehouseManagementModalActive;
                },
                inventoryReportModalToggle(){
                    this.isInventoryReportModalActive = !this.isInventoryReportModalActive;
                },
                activatePurchaseOrderModalToggle(){
                    if(this.index == null){
                        this.$buefy.dialog.alert({
                            title: 'Notice',
                            message: 'Please select a request first',
                            type: 'is-info',
                            ariaRole: 'alertdialog',
                            ariaModal: true
                        });
                        return false;
                    }
                    this.isPurchaseOrderModalActive = true;
                },
                getInventoryReport(){
                    let _this = this;
                    if(this.$refs.ir_warehouse.value == ""){
                        this.$buefy.dialog.alert({
                            title: 'Notice',
                            message: '"Please Select a Warehouse First"',
                            type: 'is-info',
                            ariaRole: 'alertdialog',
                            ariaModal: true
                        });
                        return
                    }
                    if(this.inventoryReportType == ""){
                        this.$buefy.dialog.alert({
                            title: 'Notice',
                            message: '"Please Select a Report Type"',
                            type: 'is-info',
                            ariaRole: 'alertdialog',
                            ariaModal: true
                        });
                        return
                    }

                    let params = new URLSearchParams();
                    params.append('warehouse_id', this.$refs.ir_warehouse.value);
                    params.append('report_type', this.inventoryReportType);
                    axios
                        .post(window.app_links.inventory_report,params)
                        .then(function(res){
                            _this.inventory_report = res.data;
                        })
                        .catch(function(res){
                            
                        })
                        .then(function(res){

                        })
                },
                createWarehouseManagementRequest(){
                    if((!this.part_basket.length)){
                        this.$buefy.dialog.alert({
                            title: 'Notice',
                            message: 'At least 1 product needs to be added in the basket before submission',
                            type: 'is-info',
                            ariaRole: 'alertdialog',
                            ariaModal: true
                        });
                        return;
                    }
                    let _this = this;
                    let params = new URLSearchParams();
                    params.append('source_warehouse', this.$refs.wm_source_warehouse.value);
                    params.append('destination_warehouse', this.$refs.wm_destination_warehouse.value);
                    params.append('date', this.$refs.wm_date.value);
                    params.append('parts', JSON.stringify(this.part_basket));
                    axios
                        .post(window.app_links.warehouse_management,params)
                        .then(function(res){
                            console.log(res.data);
                            _this.$buefy.dialog.alert({
                                title: 'Success',
                                message: 'Warehouse Management Request Successful',
                                type: 'is-success',
                                ariaRole: 'alertdialog',
                                ariaModal: true
                            });
                            _this.getInventory();
                        })
                        .catch(function(res){
                            
                        })
                        .then(function(res){

                        })
                },
                createPurchaseOrderRequest(){
                    if((!this.part_basket.length)){
                        this.$buefy.dialog.alert({
                            title: 'Notice',
                            message: 'At least 1 product needs to be added in the basket before submission',
                            type: 'is-info',
                            ariaRole: 'alertdialog',
                            ariaModal: true
                        });
                        return;
                    }
                    let _this = this;
                    let params = new URLSearchParams();
                    params.append('supplier', this.$refs.po_supplier.options[this.$refs.po_supplier.options.selectedIndex].dataset.id);
                    params.append('destination_warehouse', this.$refs.po_warehouse.options[this.$refs.po_warehouse.options.selectedIndex].dataset.id);
                    params.append('date', this.$refs.po_date.value);
                    params.append('parts', JSON.stringify(this.part_basket));
                    axios
                        .post(window.app_links.purchase_order,params)
                        .then(function(res){
                            console.log(res.data);
                            _this.$buefy.dialog.alert({
                                title: 'Success',
                                message: 'Purchase Order Request Successful',
                                type: 'is-success',
                                ariaRole: 'alertdialog',
                                ariaModal: true
                            });
                            _this.getInventory();
                        })
                        .catch(function(res){
                            
                        })
                        .then(function(res){

                        })
                },
                changeWarehouse(event){
                    if(this.$refs.wm_source_warehouse.value == this.$refs.wm_destination_warehouse.value){
                        event.target == this.$refs.wm_source_warehouse ? this.$refs.wm_destination_warehouse.value = "" : this.$refs.wm_source_warehouse.value = ""
                    }
                },
                removeOrderItem(id){
                    let _this = this;
                    this.$buefy.dialog.confirm({
                        title: 'Deleting Part',
                        message: 'Are you sure you want to <b>delete</b> this part transaction from inventory? This action cannot be undone.',
                        confirmText: 'Delete Transaction',
                        type: 'is-danger',
                        hasIcon: true,
                        onConfirm: function(){
                            let params = new URLSearchParams();
                            params.append('id', id)

                            axios
                                .post(window.app_links.s2_remove_order_item, params)
                                .then(function(res){
                                    _this.$buefy.dialog.alert({
                                        title: 'Success',
                                        message: 'Part Transaction removed submitted successfully',
                                        type: 'is-success',
                                        ariaRole: 'alertdialog',
                                        ariaModal: true,
                                        onConfirm:function(){
                                            _this.getInventory();
                                        }
                                    });
                                })

                        }
                    })
                    
                }
    		},
            watch:{
                selected_modal_part: function(newValue, oldValue){
                    let part_amount = "";
                    let part_batch = "";
                    let part_name = "";
                    if(this.isPurchaseOrderModalActive){
                        part_amount = this.$refs.po_part_amount;
                        part_batch = this.$refs.po_part_batch;
                        part_name = this.$refs.po_part_name;
                        part_id = this.$refs.po_part_name.options[this.$refs.po_part_name.options.selectedIndex].dataset.id;
                    }
                    else if (this.isWarehouseManagementModalActive){
                        part_amount = this.$refs.wm_part_amount;
                        part_batch = this.$refs.wm_part_batch;
                        part_name = this.$refs.wm_part_name;
                        part_id = this.$refs.wm_part_name.options[this.$refs.wm_part_name.options.selectedIndex].dataset.id;
                    }
                    console.log(newValue);
                    let part = this.selected_modal_part;
                    if(part_batch.getAttribute('disabled') == null){
                        part_batch.value = "";
                    }
                },
                isPurchaseOrderModalActive: function(nv,ov){
                    this.part_basket = [];
                },
                isWarehouseManagementModalActive: function(nv,ov){
                    this.part_basket = [];
                }
            }
    	});
    </script>
</body>
</html>

