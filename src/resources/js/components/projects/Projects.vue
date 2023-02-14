<template>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Projects</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-success" @click="openModalCreateProject" ><i class="material-icons">&#xE147;</i> Add Project</button>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created by</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="project in projects" :key="project.id">
                            <td>{{ project.id }}</td>
                                <td>{{ project.title }}</td>
                                <td>{{ project.description }}</td>
                                <td>{{ project.status.name }}</td>
                                <td>{{ project.user.name }}</td>
                            <td>
                                <a href="#"  @click="openModalUpdateProject(project)" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#" @click="deleteProject(project.id)" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                           
                            </td>
                        </tr>
                       
                    </tbody>
                </table>
                <div class="clearfix">
                    
                    <ul class="pagination">
                        <pagination align="center" :data="users" @pagination-change-page="list"></pagination>
                    </ul>
                </div>
            </div>
        </div>        
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="createProject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Statuses</label>
                        <select class="form-control" name="" id="" v-model="status_id">
                            <option v-for=" status in statuses" :value="status.id">{{ status.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="title">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" v-model="description"  id="" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Deadline</label>
                        <input type="date" class="form-control" v-model="deadline">
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" @click="addProject" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateProject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Statuses</label>
                        <select class="form-control" name="" id="" v-model="project.status_id">
                            <option v-for=" status in statuses" :key="status.id" :value="status.id" :selected="project.status_id == status.id">{{ status.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="project.title">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" v-model="project.description"  id="" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Deadline</label>
                        <input format="yyyy-MM-dd" type="date" class="form-control" v-model="project.deadline">
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" @click="updateProject" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    data() {
        return {
            statuses: {},
            projects: [],
            title: null,
            project: {},
            description: null,
            deadline: null,
            status_id: null,
        }
    },
    created() {
        this.getProjects();
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
    methods: {
        openModalCreateProject () {
            $('#createProject').modal('show');
        },
        openModalUpdateProject (project) {
            $('#updateProject').modal('show');
            this.project = project;
            this.project.deadline = moment(this.project.deadline).format('yyyy-MM-DD');
        },
        getProjects() {
            this.$axios.get('/api/projects')
            .then(response => {
                this.projects = response.data;
            })
            .catch(function (error) {
                console.error(error);
            });
        },
        addProject() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/projects/add',{
                    title: this.title,
                    description: this.description,
                    deadline: this.deadline,
                    status_id: this.status_id,
                })
                .then(response => {
                    $('#createProject').modal('hide');
                    this.deadline = '';
                    this.title = '';
                    this.description = '';
                    this.status_id = '';
                    this.getProjects();
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        },
        updateProject() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/projects/update/${this.project.id}`, {
                    title: this.project.title,
                    description: this.project.description,
                    deadline: this.project.deadline,
                    status_id: this.project.status_id,
                })
                .then(response => {
                    $('#updateProject').modal('hide');
                    this.getProjects();
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        },
        deleteProject(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/projects/delete/${id}`)
                .then(response => {
                    let i = this.projects.map(item => item.id).indexOf(id); // find index of your object
                    this.projects.splice(i, 1)
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

