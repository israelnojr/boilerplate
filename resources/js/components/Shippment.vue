<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-item-center justify-content-between">
                    <h3 class="card-title">Shippments Table</h3>

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
                            <th>Title</th>
                            <th>TrackId</th>
                            <th>Ship Type</th>
                            <th>Weight</th>
                            <th>Departure</th>
                            <th>Destination</th>
                            <th>Booking Mode</th>
                            <th>Total Freight</th>
                            <th>Pick Up</th>
                            <th>Description</th>
                            <th>Registered Date</th>
                            <th>Action</th>

                        </tr>
 
                        <tr v-for=" shippment in shippments" :key="shippment.id" >
                            <td>{{shippment.id}}</td>
                            <td>{{shippment.title | upText}}</td>
                            <td>{{shippment.key}}</td>
                            <td>{{shippment.type | upText}}</td>
                            <td>{{shippment.weight}}</td>
                            <td>{{shippment.departure}}</td>
                            <td>{{shippment.destination}}</td>
                            <td>{{shippment.bookingMode}}</td>
                            <td>{{shippment.amount}}</td>
                            <td>{{shippment.pickupDate}}</td>
                            <td>{{shippment.description}}</td>
                            <td>{{shippment.created_at | myDate}}</td>
                            <td>
                                <a class="btn btn-info mb-2" href="#" @click="editModal(shippment)">
                                    <i class="fa fa-edit blue"></i>
                                </a>                               
                                <button class="btn btn-danger" href="#" @click="deleteshippment(shippment.id)">
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
<!-- Modal -->
        <div class="modal fade" id="AddNew" tabindex="-1" role="dialog" aria-labelledby="AddNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode"  id="AddNewLabel">Add New</h5>
                        <h5 class="modal-title" v-show="editMode"  id="AddNewLabel">Edit Shippment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" editMode ? UpdateShippment() : createShippment() ">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.title" type="text" name="title"
                                    placeholder="Title"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.shipperName" type="text" name="shipperName"
                                    placeholder="Sender Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('shipperName') }">
                                <has-error :form="form" field="shipperName"></has-error>
                            </div>
                            
                            <div class="form-group">
                                <input v-model="form.shipperNum" type="text" name="shipperNum"
                                    placeholder="Sender Number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('shipperNum') }">
                                <has-error :form="form" field="shipperNum"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.shipperAddress" type="address" name="shipperAddress"
                                    placeholder="Sender Address"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('shipperAddress') }">
                                <has-error :form="form" field="shipperAddress"></has-error>
                            </div>

                             <div class="form-group">
                                <input v-model="form.recieverName" type="text" name="recieverName"
                                    placeholder="Receiver Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('recieverName') }">
                                <has-error :form="form" field="recieverName"></has-error>
                            </div>
                            
                            <div class="form-group">
                                <input v-model="form.recieverNum" type="text" name="recieverNum"
                                    placeholder="Receiver Number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('recieverNum') }">
                                <has-error :form="form" field="recieverNum"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.recieverAddress" type="address" name="recieverAddress"
                                    placeholder="Receiver Address"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('recieverAddress') }">
                                <has-error :form="form" field="recieverAddress"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.type" type="text" name="type"
                                    placeholder="Package Type"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                <has-error :form="form" field="type"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.weight" type="number" name="weight"
                                    placeholder="Weight"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('weight') }">
                                <has-error :form="form" field="weight"></has-error>
                            </div>

                             <div class="form-group">
                                <input v-model="form.departure" type="text" name="departure"
                                    placeholder="Departure"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('departure') }">
                                <has-error :form="form" field="departure"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.destination" type="text" name="destination"
                                    placeholder="Destination"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('destination') }">
                                <has-error :form="form" field="destination"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.bookingMode" type="text" name="bookingMode"
                                    placeholder="Booking Mode"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('bookingMode') }">
                                <has-error :form="form" field="bookingMode"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.amount" type="number" name="amount"
                                    placeholder="Amount"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                                <has-error :form="form" field="amount"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.mode" type="text" name="mode"
                                    placeholder="Mode"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('mode') }">
                                <has-error :form="form" field="mode"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.pickupDate" type="date" name="pickupDate"
                                    placeholder="Pickup Date"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('pickupDate') }">
                                <has-error :form="form" field="pickupDate"></has-error>
                            </div>

                             <div class="form-group">
                                <textarea id="description" cols="30" rows="5" v-model="form.description" type="text" name="description"
                                    placeholder="Description"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                <has-error :form="form" field="description"></has-error></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                            <button v-show="!editMode" type="submit" class="btn btn-primary">Add Shippment</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
    <!-- /.card-body -->           
</template>

<script>
    export default {
        data(){
            return{
                editMode: false,
                shippments: {},
                form: new Form({
                    id:'',                   
                    title: '',
                    key: '',
                    shipperName: '',
                    shipperNum: '',
                    shipperAddress: '',
                    recieverName: '',
                    recieverNum: '',
                    recieverAddress: '',
                    type: '',
                    weight: '',
                    departure: '',
                    destination: '',
                    amount: '',
                    mode: '',
                    pickupDate: '',
                    description: '',
                })
            }
        },
        methods: {
            UpdateShippment(){
                this.$Progress.start()
                this.form.put('api/shippment/'+this.form.id)

                .then(() => {
                    // hide modal
                    $('#AddNew').modal('hide')
                    // show success message
                    swal.fire(
                    'Updated!',
                    'Shippment details updated successfully',
                    'success'
                    )  
                    this.$Progress.finish()
                })

                .catch(response => {
                    this.$Progress.fail()
                    swal(response.status, response.body.error, "error");
                })

                // alert('Edit data')
            },

            editModal(shippment){
                this.editMode = true;
                this.form.reset();
                $('#AddNew').modal('show')
                this.form.fill(shippment);
            },

            createModal(){
                this.editMode = false;
                this.form.reset();
                $('#AddNew').modal('show')
            },

            deleteshippment(id){
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
                        this.form.delete('api/shippment/'+id).then(() => {                     
                            swal.fire(
                            'Deleted!',
                            'Shippment deleted.',
                            'success'
                            )                     
                        }).catch(()=>{
                            swal("Failed!", "There was something wrong.", "warning");
                        })
                    }
                })
            },

            loadShippments(){
                axios.get("api/shippment").then(({ data })=> (this.shippments = data));
            },

            createShippment(){
                this.$Progress.start()
                this.form.post('api/shippment')

                .then(() =>{
                    // Fire.$emit('afterCreated');
                    $('#AddNew').modal('hide')
                    toast.fire({
                    type: 'success',
                    title: 'Shippment Created Successfully'
                    })
                    this.$Progress.finish()
                })
                .catch(() =>{
                    swal("Failed!", "There was something wrong.", "warning");
                    this.$Progress.fail()
                })
            }
        },
        created(){
            this.loadShippments();
            // Fire.$on('afterCreated', () => { this.loadShippments(); })
            setInterval(() => this.loadShippments(), 3000);
        }
    }
</script>


