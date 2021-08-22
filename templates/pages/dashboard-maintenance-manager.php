<?php 
    require_once "../../.env.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dashboard - Maintenance Manager</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/buefy/dist/buefy.min.css">
    <script src="https://unpkg.com/buefy/dist/buefy.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <script type="text/javascript">
        var app_links = {
            parts: "<?php echo $env_api['parts']; ?>",
            asset_history: "<?php echo $env_api['asset_history']; ?>",
            asset_maintenance: "<?php echo $env_api['asset_maintenance']; ?>",
        }
    </script>
</head>
<body>
	<?php
		include '../pieces/header.php';
	?>
	<p>Maintenance</p>
	<div id="maintenance-table" class="m-2 p-2">
    	<h1 class="is-size-5 has-text-weight-bold p-3">List of Assets Requesting EM</h1>
    	<div class="table-container">
            <table class="table is-fullwidth">
                <thead>
                    <tr class="">
                        <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Asset SN">Asset SN</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset Name">Asset Name</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Last Closed EM">Request Date</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Number of EMs">Employee Full Name</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Number of EMs">Department</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Number of EMs">Priority</abbr></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="">
                        <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Asset SN">Asset SN</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset Name">Asset Name</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Last Closed EM">Request Date</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Number of EMs">Employee Full Name</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Number of EMs">Department</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Number of EMs">Priority</abbr></th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="(request, index) in sorted_maintenance_requests" @click="selectRow(index)" :class="{ 'is-selected': $data.index == index }">
                        <td class="has-text-centered" style="vertical-align: middle;">{{request.AssetSN}}</td>
                        <td class="has-text-left" style="vertical-align: middle;">{{request.AssetName}}</td>
                        <td class="has-text-left" style="vertical-align: middle;">{{request.EMReportDate}}</td>
                        <td class="has-text-left" style="vertical-align: middle;">{{request.EmployeeFirstName}} {{request.EmployeeLastName}}</td>
                        <td class="has-text-left" style="vertical-align: middle;">{{request.DepartmentName}}</td>
                        <td class="has-text-left" style="vertical-align: middle;" v-html="">{{request.PriorityID}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button @click="manageRequest" class="button is-info is-medium">Manage Request</button>
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
                            <td>{{selectedRequest.AssetSN}}</td>
                            <td>{{selectedRequest.AssetName}}</td>
                            <td>{{selectedRequest.DepartmentName}}</td>
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
                                                    <div class="select">
                                                        <select ref="part_name" name="part_name">
                                                            <option v-for="(part, index) in parts" :value="part.Name" selected>{{part.Name}}</option>
                                                            <option value="" selected>-- -- --</option>
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
                                <div class="column is-narrow"><button @click="addToPartBasket" class="button is-primary"><span class="has-size-4">+</span>&nbsp;Add To List </button></div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-full">
                                <div class="table-container">
                                    <table class="table is-fullwidth">
                                        <thead>
                                            <tr class="">
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset SN">Part Name</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset Name">Amount</abbr></th>
                                                <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Last Closed EM">Action</abbr></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="">
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset SN">Part Name</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset Name">Amount</abbr></th>
                                                <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Last Closed EM">Action</abbr></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr v-if="part_basket.length == 0">
                                                <td class="has-text-centered" style="vertical-align: middle;">No Parts Have Been Added</td>
                                            </tr>
                                            <tr v-for="(part, index) in part_basket">
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.name}}</td>
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.amount}}</td>
                                                <td class="has-text-centered" style="vertical-align: middle;"><a class="has-text-info" @click="part_basket.splice(index, 1)">Remove</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="label is-size-4">Asset History</label>
                        <div class="columns">
                            <div class="column is-full">
                                <div class="table-container">
                                    <table class="table is-fullwidth">
                                        <thead>
                                            <tr class="">
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset SN">Part Name</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset Name">Amount</abbr></th>
                                                <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Last Closed EM">Time Lefts</abbr></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="">
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset SN">Part Name</abbr></th>
                                                <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset Name">Amount</abbr></th>
                                                <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Last Closed EM">Time Lefts</abbr></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr v-if="computed_asset_history.length == 0">
                                                <td class="has-text-centered" style="vertical-align: middle;">No Valid Part History Found for this Asset</td>
                                            </tr>
                                            <tr v-for="(part, index) in computed_asset_history">
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.Name}}</td>
                                                <td class="has-text-left" style="vertical-align: middle;">{{part.Amount}}</td>
                                                <td class="has-text-centered" style="vertical-align: middle;">{{part.daysLeft}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
    		el:"#maintenance-table",
            mounted(){
                this.getMaintenanceRequests();
                this.getParts();
            },
    		data(){
                return {
                    maintenance_requests:[],
                    parts:[],
                    part_basket: [],
                    index: null,
                    isMaintenanceRequestModalActive: false,
                    asset_history: []
                }
    		},
    		computed:{
                selectedRequest(){
                    if(this.index == null){return {id:"",AssetID:"",EMReportDate:"",AssetSN:"",AssetName:"",DepartmentLocationID:"",EmployeeID:"",EmployeeFirstName:"",EmployeeLastName:"",DepartmentName:""};}
                    return this.sorted_maintenance_requests[this.index];
                },
                computed_asset_history(){
                    let asset_history = [];
                    for(counter = 0, count = this.asset_history.length ; counter < count ; counter++){
                        if(this.asset_history[counter].daysLeft == null){continue;}
                        asset_history.push(this.asset_history[counter]);
                    }
                    return asset_history;
                },
                sorted_maintenance_requests(){
                    return this.maintenance_requests
                        .sort(function(a, b){
                            return b.PriorityID - a.PriorityID;
                        })
                        .sort(function(a, b){
                            return a.EMReportDate > b.EMReportDate;
                        });
                }
    		},
    		methods:{
                getMaintenanceRequests(){
                    let _this = this;
                    axios
                        .get(window.app_links.asset_maintenance)
                        .then(function(res){
                            _this.maintenance_requests = res.data;
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
                            _this.parts = res.data;
                        })
                        .catch(function(res){
                            console.error(res.data);
                        })
                },
                addToPartBasket(){
                    let _this = this;                    
                    if(parseInt(this.$refs.part_amount.value) < 1){
                        alert("Amount cannot be less than 1");
                        return;
                    }
                    //Checking if part to add is already in asset history
                    for(counter = 0, count = this.computed_asset_history.length; counter < count; counter++){
                        if((this.computed_asset_history[counter].Name == this.$refs.part_name.value) && this.computed_asset_history[counter].daysLeft > 0){
                            this.$buefy.dialog.confirm({
                                title: 'Replace Usable Part?',
                                message: `Are you sure you want replace the:<br/> \"<b>${this.$refs.part_name.value}</b>\"<br/> part in this asset? <br/><br/>The remaining days left will be lost.`,
                                confirmText: 'Replace Part',
                                type: 'is-warning',
                                hasIcon: true,
                                onConfirm: function(){_this.addToPartBasketFunction()},
                                onCancel: function(){}
                            })
                        }
                    }
                    
                },
                addToPartBasketFunction(){
                    for(counter = 0, count = this.part_basket.length; counter < count; counter++){
                        if(this.part_basket[counter].name == this.$refs.part_name.value){
                            this.part_basket[counter].amount = parseInt(this.part_basket[counter].amount) + parseInt(this.$refs.part_amount.value);
                            this.$refs.part_name.value = "";
                            this.$refs.part_amount.value = "";
                            return;                            
                        }
                    }
                    this.part_basket.push({
                        name: this.$refs.part_name.value,
                        amount: parseInt(this.$refs.part_amount.value)
                    });
                    this.$refs.part_name.value = "";
                    this.$refs.part_amount.value = "";
                },
                selectRow(selectedIndex){
                    selectedIndex == this.index ? this.index = null : this.index = selectedIndex;
                },
                manageRequest(){
                    this.activateMaintenanceModalToggle();
                    this.getAssetHistory();
                },
                getAssetHistory(){
                    let params = new URLSearchParams();
                    let _this = this;
                    params.append('AssetID', this.selectedRequest.AssetID);
                    axios
                        .post(window.app_links.asset_history, params)
                        .then(function(res){
                            _this.asset_history = res.data;
                        })
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

