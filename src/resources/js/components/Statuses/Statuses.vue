<template>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Statuses</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-success" @click="openModalCreateStatus" ><i class="material-icons">&#xE147;</i> Add Status</button>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="status in statuses" :key="status.id">
                            <td>{{ status.id }}</td>
                            <td>{{ status.name }}</td>
                            <td>
                                <a href="#"  @click="openModalUpdate(status)" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#" @click="deleteStatus(status.id)" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
               
            </div>
        </div>        
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="createStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="name">
                    </div><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" @click="addStatus" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="status.name">
                    </div><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" @click="updateStatus" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            statuses: [],
            name: null,
            status: [], 
        }
    },
    created() {
        this.getStatuses()
        console.log(this.statuses);
    },
    methods: {
        openModalCreateStatus () {
            $('#createStatus').modal('show');
        },
        openModalUpdate (status) {
            $('#updateStatus').modal('show');
            this.status = status;
        },
        getStatuses() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/statuses')
                .then(response => {
                    this.statuses = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        },
        addStatus() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/statuses/add',{name: this.name})
                .then(response => {
                    $('#createStatus').modal('hide');
                    this.name = '';
                    this.getStatuses();
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        },
        updateStatus() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/statuses/update/${this.status.id}`, {name: this.status.name})
                .then(response => {
                    $('#updateStatus').modal('hide');
                    this.getStatuses();
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        },
        deleteStatus(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/statuses/delete/${id}`)
                .then(response => {
                    let i = this.statuses.map(item => item.id).indexOf(id); // find index of your object
                    this.statuses.splice(i, 1)
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
