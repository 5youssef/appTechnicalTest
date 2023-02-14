<template>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Tasks</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-success" @click="openModalCreatetask" ><i class="material-icons">&#xE147;</i> Add Task</button>
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
                            <th>Project</th>
                            <th>Member</th>
                            <th>Deadline</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="task in tasks" :key="task.id">
                            <td>{{ task.id }}</td>
                            <td>{{ task.title }}</td>
                            <td>{{ task.description }}</td>
                            <td>{{ task.status.name }}</td>
                            <td>{{ task.project.title }}</td>
                            <td>{{ task.user.name }}</td>
                            <td>{{ task.deadline }}</td>
                            <td>
                                <a href="#"  @click="openModalUpdatetask(task)" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#" @click="deletetask(task.id)" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
                
            </div>
        </div>        
    </div>
  
    <!-- Modal -->
    <div class="modal fade" id="createtask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Statuses</label>
                        <select class="form-control"  v-model="status_id">
                            <option v-for="status in statuses" :value="status.id">{{ status.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Members</label>
                        <select class="form-control"  v-model="user_id">
                            <option v-for=" user in users" :value="user.id">{{ user.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Projects</label>
                        <select class="form-control" name="" id="" v-model="project_id">
                            <option v-for="project in projects" :value="project.id">{{ project.title }}</option>
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
                    <button type="button" @click="addTask" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updatetask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Statuses</label>
                        <select class="form-control" name="" id="" v-model="task.status_id">
                            <option v-for="status in statuses" :key="status.id" :value="status.id" :selected="task.status_id == status.id">{{ status.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Members</label>
                        <select class="form-control"  v-model="task.user_id">
                            <option v-for=" user in users" :value="user.id" :key="user.id"  :selected="task.user_id == user.id">{{ user.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Projects</label>
                        <select class="form-control" name="" id="" v-model="task.project_id">
                            <option v-for="project in projects" :value="project.id" :key="project.id"  :selected="task.project_id == project.id">{{ project.title }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="task.title">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" v-model="task.description"  id="" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Deadline</label>
                        <input format="yyyy-MM-dd" type="date" class="form-control" v-model="task.deadline">
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" @click="updatetask" class="btn btn-primary">Save</button>
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
            projects: {},
            users: {},
            tasks: [],
            title: null,
            task: [],
            description: null,
            deadline: null,
            status_id: null,
            user_id: null,
            project_id: null,
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tasks')
            .then(response => {
                this.tasks = response.data;
            })
            .catch(function (error) {
                console.error(error);
            });
            this.$axios.get('/api/statuses')
            .then(response => {
                this.statuses = response.data
            })
            .catch(function (error) {
                console.error(error);
            });
            this.$axios.get('/api/projects')
            .then(response => {
                this.projects = response.data
            })
            .catch(function (error) {
                console.error(error);
            });
            this.$axios.get('/api/users')
            .then(response => {
                this.users = response.data
            })
            .catch(function (error) {
                console.error(error);
            });
        })
    },
    methods: {
        openModalCreatetask () {
            $('#createtask').modal('show');
        },
        openModalUpdatetask (task) {
            $('#updatetask').modal('show');
            this.task = task;
            this.task.deadline = moment(this.task.deadline).format('yyyy-MM-DD');
        },
        gettasks() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/tasks')
                .then(response => {
                    this.tasks = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        },
        addTask() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/tasks/add',{
                    title: this.title,
                    description: this.description,
                    deadline: this.deadline,
                    status_id: this.status_id,
                    project_id: this.project_id,
                    user_id: this.user_id,
                })
                .then(response => {
                    $('#createtask').modal('hide');
                    this.title = '';
                    this.description = '';
                    this.deadline = '';
                    this.status_id = '';
                    this.project_id = '';
                    this.user_id = '';
                    this.gettasks();
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        },
        updatetask() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/tasks/update/${this.task.id}`, {
                    title: this.task.title,
                    description: this.task.description,
                    deadline: this.task.deadline,
                    status_id: this.task.status_id,
                    project_id: this.task.project_id,
                    user_id: this.task.user_id,
                })
                .then(response => {
                    $('#updatetask').modal('hide');
                    this.gettasks();
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        },
        deletetask(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/tasks/delete/${id}`)
                .then(response => {
                    let i = this.tasks.map(item => item.id).indexOf(id); // find index of your object
                    this.tasks.splice(i, 1)
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
