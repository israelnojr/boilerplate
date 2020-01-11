<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-item-center justify-content-between">
                    <h3 class="card-title">Info Table</h3>

                    <div class="card-tools float-right">
                        <button class="btn btn-success" @click="createModal" >Add New <i class="fas fa-user-plus fa-fw"></i></button>
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Shippment Id</th>
                            <th>Track Id</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Remark</th>
                            <th>Registered At</th>
                            <th>Modify</th>
                        </tr>
 
                        <tr v-for=" info in infos" :key="info.id" >
                            <td>{{info.id}}</td>
                            <td>{{info.shippment_id}}</td>
                            <td>{{info.trackId}}</td>
                            <td>{{info.location}}</td>
                            <td>{{info.status}}</td>
                            <td>{{info.remark}}</td>
                            <td>{{info.created_at}}</td>
                            <td>
                                <a class="btn btn-info" href="#" @click="editModal(info)">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                                
                                <button class="btn btn-danger" href="#" @click="deleteInfo(info.id)">
                                    <i class="fa fa-trash red"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 </div>
        <div class="modal fade" id="AddNew" tabindex="-1" role="dialog" aria-labelledby="AddNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode"  id="AddNewLabel">Add New></h5>
                        <h5 class="modal-title" v-show="editMode"  id="AddNewLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editMode ? updateInfo() : createInfo() ">
                        <div class="modal-body">
                             <div class="form-group">
                                <select name="trackId" v-model="form.trackId" id="trackId" class="form-control" 
                                    :class="{ 'is-invalid': form.errors.has('trackId') }" @click="getInfo()">
                                    <option value="">Select Tracking ID</option>
                                     <option v-for="shippment in shippments" :key="shippment.id" v-bind:value="shippment.key">{{shippment.key}}</option>
                                </select>
                                <has-error :form="form" field="trackId"></has-error>
                            </div>

                            <div class="form-group">
                                <select name="shippment_id" v-model="form.shippment_id" id="shippment_id" class="form-control" 
                                    :class="{ 'is-invalid': form.errors.has('shippment_id') }"  @click="getInfo()">
                                    <option value="">Select Shipment ID</option>
                                     <option v-for="shippment in shippments" :key="shippment.id" v-bind:value="shippment.id">{{shippment.id}}</option>
                                </select>
                                <has-error :form="form" field="shippment_id"></has-error>
                            </div>
                            
                            <div class="form-group">
                                <input v-model="form.location" type="text" name="location"
                                    placeholder="Location"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('location') }">
                                <has-error :form="form" field="location"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.status" type="text" name="status"
                                    placeholder="Status"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
                                <has-error :form="form" field="status"></has-error>
                            </div>
                           
                            <div class="form-group">
                                <input v-model="form.remark" type="text" name="remark"
                                    placeholder="Remark"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('remark') }">
                                <has-error :form="form" field="remark"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                            <button v-show="!editMode" type="submit" class="btn btn-primary">Add Info</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>         
</template>

<script>
    export default {
        data(){
            return{
                editMode: false,
                infos: {},
                shippments: {},
                form: new Form({
                    id:'',
                    shippment_id:'',
                    trackId : '',
                    location: '',
                    status: '',
                    remark: '',
                })
            }
        },
        methods: {
            getInfo(){
                axios.get("api/shippment").then(({ data })=> (this.shippments = data));
            },

            updateInfo(){
                this.$Progress.start()
                this.form.put('api/info/'+this.form.id)

                .then(() => {
                    // hide modal
                    $('#AddNew').modal('hide')
                    // show success message
                    swal.fire(
                    'Updated!',
                    'info details updated successfully',
                    'success'
                    )  
                     this.$Progress.finish()
                })

                .catch(() => {
                   this.$Progress.fail()
                })

                // alert('Edit data')
            },

            editModal(info){
                this.editMode = true;
                this.form.reset();
                $('#AddNew').modal('show')
                this.form.fill(info);
            },

            createModal(){
                 this.editMode = false;
                this.form.reset();
                $('#AddNew').modal('show')
            },

            deleteInfo(id){
                swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    //send request to the server
                    if (result.value) {
                        this.form.delete('api/info/'+id).then(() => {                     
                            swal.fire(
                            'Deleted!',
                            'info deleted.',
                            'success'
                            )                     
                        }).catch(()=>{
                            swal("Failed!", "There was something wronge.", "warning");
                        })
                    }
                })
            },

            loadInfos(){
                axios.get("api/info").then(({ data })=> (this.infos = data));
            },

            createInfo(){
                this.$Progress.start()
                this.form.post('api/info')

                .then(() =>{
                    // Fire.$emit('afterCreated');
                    $('#AddNew').modal('hide')
                    toast.fire({
                    type: 'success',
                    title: 'Info Created Successfully'
                    })
                this.$Progress.finish()
                })
                .catch(() =>{
                    this.$Progress.fail()
                })
            }
        },
        created(){
            this.loadInfos();
            // Fire.$on('afterCreated', () => { this.loadInfos(); })
            setInterval(() => this.loadInfos(), 3000);
        }
    }
</script>


