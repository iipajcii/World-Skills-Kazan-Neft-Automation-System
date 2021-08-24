<?php 
    require_once "../../.env.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dashboard - Accountable Party</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/buefy/dist/buefy.min.css">
    <script src="https://unpkg.com/buefy/dist/buefy.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <script type="text/javascript">
        var app_links = {
            assets: "<?php echo $env_api['assets']; ?>",
            create_emergency_maintenance: "<?php echo $env_api['create_emergency_maintenance']; ?>"
        }
    </script>
</head>
<body>
	<?php
		include "../pieces/header.php";
	?>
    <div id="asset-table" class="m-2 p-2">
    	<h1 class="is-size-5 has-text-weight-bold p-3">Available Assets</h1>
    	<div class="table-container">
            <table class="table is-fullwidth">
                <thead>
                    <tr class="">
                        <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Asset SN">Asset SN</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset Name">Asset Name</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Last Closed EM">Last Closed EM</abbr></th>
                        <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Number of EMs">Number of EMs</abbr></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="">
                        <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Asset SN">Asset SN</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Asset Name">Asset Name</abbr></th>
                        <th class="has-text-info has-text-left" style="vertical-align: middle;"><abbr title="Last Closed EM">Last Closed EM</abbr></th>
                        <th class="has-text-info has-text-centered" style="vertical-align: middle;"><abbr title="Number of EMs">Number of EMs</abbr></th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="(asset, index) in assets" @click="selectRow(index)" :class="{ 'is-selected': $data.index == index }">
                        <td class="has-text-centered" style="vertical-align: middle;">{{asset.AssetSN}}</td>
                        <td class="" style="vertical-align: middle;">{{asset.AssetName}}</td>
                        <td class="" style="vertical-align: middle;">{{asset.LastClosedEM == null ? '***' : asset.LastClosedEM}}</td>
                        <td class="has-text-centered" style="vertical-align: middle;">{{asset.NumberOfEMs}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button @click="activateMaintenanceModalToggle" class="button is-info is-medium">Send Emergency Maintenance Request</button>
         <b-modal v-model="isEmergencyMaintenanceModalActive">
            <div class="card">
                <header class="card-header">
                    <table class="table is-fullwidth">
                        <thead>
                            <th>AssetSN</th>
                            <th>Asset Name</th>
                            <th>DepartmentName</th>
                        </thead>
                        <tr>
                            <td>{{selectedAsset.AssetSN}}</td>
                            <td>{{selectedAsset.AssetName}}</td>
                            <td>{{selectedAsset.DepartmentName}}</td>
                        </tr>
                    </table>
                </header>
                <div class="card-content">
                    <div>
                        <div class="field">
                            <input ref="em_asset_id" name="id" type="hidden" :value="selectedAsset.id"/>
                            <label class="label">Priority</label>
                            <div class="control">
                                <div class="select">
                                    <select ref="em_priority" name="priority">
                                        <option value="1">General</option>
                                        <option value="2">High</option>
                                        <option value="3">Very High</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Description of Emergency</label>
                            <div class="control">
                                <textarea ref="em_description" name="description" class="textarea"></textarea>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Other Considerations</label>
                            <div class="control">
                                <textarea ref="em_considerations" name="considerations" class="textarea"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="has-text-centered">
                        <button @click="createEM" class="button is-medium is-info m-5 pl-6 pr-6">Send Request</button>
                        <button @click="emergencyMaintenanceModalToggle" class="button is-medium is-danger m-5 pl-6 pr-6">Cancel</button>
                    </div>
                </div>
                <footer class="card-footer"></footer>
            </div>
        </b-modal>
    </div>
    <script type="text/javascript">
    	let assetTable = new Vue({
    		el:"#asset-table",
            mounted(){
                this.getAssets();
            },
    		data(){
                return {
                    assets:[],
                    index: null,
                    isEmergencyMaintenanceModalActive: false
                }
    		},
    		computed:{
                selectedAsset(){
                    if(this.index == null){return {AssetSN:"",AssetName:"",DepartmentName:""};}
                    return this.assets[this.index];
                }
    		},
    		methods:{
                getAssets(){
                    let _this = this;
                    axios
                        .get(window.app_links.assets)
                        .then(function(res){
                            _this.assets = res.data;
                        })
                        .catch(function(res){
                            console.error(res.data);
                        })
                },
                selectRow(selectedIndex){
                    selectedIndex == this.index ? this.index = null : this.index = selectedIndex;
                },
                emergencyMaintenanceModalToggle(){
                    this.isEmergencyMaintenanceModalActive = !this.isEmergencyMaintenanceModalActive;
                },
                activateMaintenanceModalToggle(){
                    if(this.index == null){
                        this.$buefy.dialog.alert({
                            title: 'Notice',
                            message: 'Please select an asset first',
                            type: 'is-info',
                            ariaRole: 'alertdialog',
                            ariaModal: true
                        });
                        return false;
                    }
                    this.isEmergencyMaintenanceModalActive = true;
                },
                toggleMaintenanceModalActive(){
                    this.isEmergencyMaintenanceModalActive = !this.isEmergencyMaintenanceModalActive;
                },
                createEM(){
                    let _this = this;
                    let params = new URLSearchParams();
                    params.append('AssetID', this.$refs.em_asset_id.value);
                    params.append('Considerations', this.$refs.em_considerations.value);
                    params.append('Description', this.$refs.em_description.value);
                    params.append('PriorityID', this.$refs.em_priority.value);
                    axios
                        .post(window.app_links.create_emergency_maintenance, params)
                        .then(function(res){
                            if(res.data.value == true){
                                _this.$buefy.dialog.alert({
                                    title: 'Success',
                                    message: 'Emergency Maintenance submitted successfully',
                                    type: 'is-success',
                                    ariaRole: 'alertdialog',
                                    ariaModal: true
                                });
                            }
                            else {
                                _this.$buefy.dialog.alert({
                                    title: 'Warning',
                                    message: 'Emergency Maintenance could not be created, unfulfilled maintenance in the system',
                                    type: 'is-warning',
                                    ariaRole: 'alertdialog',
                                    ariaModal: true
                                });
                            }
                        })
                        .catch(function(error){
                            console.error(error);
                            _this.$buefy.dialog.alert({
                                title: 'Error',
                                message: 'There was an error with performing this action.',
                                type: 'is-danger',
                                ariaRole: 'alertdialog',
                                ariaModal: true
                            });
                        })
                }
    		}
    	});
    </script>

</body>
</html>

