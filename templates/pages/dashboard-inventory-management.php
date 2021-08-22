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
            s2_inventory_transactions: "<?php echo $env_api['s2_inventory_transactions']; ?>",
        }
    </script>
</head>
<body>
	<?php
		include '../pieces/header.php';
	?>
	<div class="columns">
		<div class="column is-narrow"><button class="button is-primary">Purchase Order Management</button></div>
		<div class="column is-narrow"><button class="button is-primary">Warehouse Management</button></div>	
		<div class="column is-narrow"><button class="button is-primary">Inventory Report</button></div>	
	</div>
	<div id="inventory-table" class="m-2 p-2">
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
                    <tr v-for="(order, index) in sorted_orders" @click="selectRow(index)">
                        <td :name="order.Name" class="has-text-centered" style="vertical-align: middle;">{{order.Name}}</td>
                        <td :name="order.TransactionName" class="has-text-left" style="vertical-align: middle;">{{order.TransactionName}}</td>
                        <td :name="order.Date" class="has-text-left" style="vertical-align: middle;">{{order.Date}}</td>
                        <td :name="order.Amount" class="has-text-left" :class="{'has-background-success': order.TransactionName == 'Purchase Order'}" style="vertical-align: middle;">{{order.Amount}}</td>
                        <td :name="order.SourceWarehouseName" class="has-text-left" style="vertical-align: middle;" v-html="order.SourceWarehouseName == null ? '-- -- --' : order.SourceWarehouseName"></td>
                        <td :name="order.DestinationWarehouseName" class="has-text-left" style="vertical-align: middle;" v-html="order.DestinationWarehouseName == null ? '-- -- --' : order.DestinationWarehouseName"></td>
                        <td class="has-text-left" style="vertical-align: middle;"><button class="button">Edit</button><button class="ml-1 button is-danger is-light">Remove</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
         <b-modal v-model="isMaintenanceRequestModalActive">
            <div class="card">
                <header class="card-header">
                    <table class="table is-fullwidth">
                        <thead>
                            <th>AssetSN</th>
                            <th>Asset Name</th>
                            <th>DepartmentName</th>
                        </thead>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </header>
                <div class="card-content">
                    <div>
                        <label class="label is-size-4">Assert EM Report</label>
                        <div>
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Start Date</label>
                                        <div class="control">
                                            <input class="input" type="date" name="">
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Completed On</label>
                                        <div class="control">
                                            <input class="input" type="date" name="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Technician Note</label>
                                <div class="control">
                                    <textarea ref="em_technician_note" name="em_technician_note" class="textarea"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="label is-size-4">Replacement Parts</label>
                        <div>
                            <div class="columns">
                                <div class="column">
                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label">Part Name</label>
                                        </div>
                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label">Amount</label>
                                        </div>
                                        <div class="field-body">
                                            <div class="field">
                                                <p class="control">
                                                    <input ref="part_amount" min="0" class="input" type="number" name="amount"/>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-narrow"><button class="button is-primary"><span class="has-size-4">+</span>&nbsp;Add To List </button></div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-full">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="label is-size-4">Asset History</label>
                        <div class="columns">
                            <div class="column is-full">
                            </div>
                        </div>
                    </div>
                    <div class="has-text-centered">
                        <button @click="" class="button is-info">Submit</button>
                        <button class="button is-danger">Cancel</button>
                    </div>
                </div>
                <footer class="card-footer">Footer Here</footer>
            </div>
        </b-modal>
    </div>
    <script type="text/javascript">
    	let assetTable = new Vue({
    		el:"#inventory-table",
            mounted(){
                this.getOrders();
            },
    		data(){
                return {
                	orders:[],
                    maintenance_requests:[],
                    index: null,
                    isMaintenanceRequestModalActive: false,
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
                sorted_orders(){
                    let sorted_orders = this.orders;
                    let criteria = Object.keys(this.sort_criteria);

                    for(counter = 0, count = criteria.length; counter < count; counter++){
                        if(this.sort_criteria[criteria[counter]] == true){
                            return sorted_orders
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
                            return sorted_orders
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

                    return sorted_orders
                        .sort(function(a, b){
                            return a.Date > b.Date;
                        })
                        .sort(function(a, b){
                            if(a.TransactionTypeID = 1){
                                return false;
                            }
                            else {
                                return true;
                            }
                        });
                }
    		},
    		methods:{
                getOrders(){
                    let _this = this;
                    axios
                        .get(window.app_links.s2_inventory_transactions)
                        .then(function(res){
                            _this.orders = res.data;
                        })
                        .catch(function(res){
                            console.error(res.data);
                        })
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
                maintenanceRequestModalToggle(){
                    this.isMaintenanceRequestModalActive = !this.isMaintenanceRequestModalActive;
                },
                activateMaintenanceModalToggle(){
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
                    this.isMaintenanceRequestModalActive = true;
                }
    		}
    	});
    </script>
</body>
</html>

