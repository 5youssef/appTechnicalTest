<template>
    <div class="col-md-12">
        <div class="row">
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Task Open</h4>
                        
                        <div class="drop-zone">
                            <draggable v-model="open" item-key="id" tag="ul" group="ITEMS"  @add="onAdd($event, 1)"  @change="update">
                                <template  #item="{ element, index }">
                                    <li :key="element.id" :data-id="element.id">{{element.title}}</li>
                                </template>
                            </draggable>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Task Processing</h4>
                        <div class="drop-zone">
                            <draggable  v-model="processing" item-key="id" tag="ul" group="ITEMS"  @add="onAdd($event, 2)"  >
                                <template class="list-item" #item="{ element, index }">
                                    <li :key="element.id" :data-id="element.id" >{{element.title}})</li>
                                </template>
                            </draggable>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Task Completed</h4>
                        
                        <div class="drop-zone">
                            <draggable v-model="completed" item-key="no" tag="ul" group="ITEMS" @add="onAdd($event, 3)"  >
                                <template  #item="{ element, index }">
                                    <li :key="element.id" :data-id="element.id">{{element.title}}</li>
                                </template>
                            </draggable>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
import moment from 'moment';
import draggable from 'vuedraggable'

export default {
    components: {
        draggable,
    },
    data() {
        return {
            items:[
            {no:1, name:'test', categoryNo:'1'},
            {no:2, name:'test', categoryNo:'2'}
            ],
            items2:[
            {no:5, name:'test', categoryNo:'1'},
            {no:6, name:'test', categoryNo:'2'}
            ],
            
            open:[],
            processing: [],
            completed: [],
            
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
                this.open = this.tasks.filter((item) => item.status_id === 1)
                
                this.processing = this.tasks.filter((item) => item.status_id === 2)
                
                this.completed = this.tasks.filter((item) => item.status_id === 3)
                
            })
            .catch(function (error) {
                console.error(error);
            });
            
        })
    },
    methods: {
        onAdd(event, status) {
            let id = event.item.getAttribute('data-id');
            console.log(id);
            axios.post('api/demos/tasks/' + id, {
                status_id: status
            }).then((response) => {
                console.log(response.data);
            }).catch((error) => {
                console.log(error);
            })
        },
       
       
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>

<style scoped>
.drop-zone {
    background-color: #eee;
    margin-bottom: 10px;
    padding: 10px;
}

.drag-el {
    background-color: #fff;
    margin-bottom: 10px;
    padding: 5px;
}
.box {
    width: 50%;
    float: left;
    padding: 20px 0;
}
#box1 {
    background-color: #fdd;
}
#box2 {
    background-color: #ddf;
}
ul {
    list-style-type: none;
    padding-right: 2rem;
}
li {
    cursor:pointer;
    padding: 10px;
    border: solid #ddd 1px;
    background-color: #fff;
}
.list-item {
    margin: 10px;
    padding: 40px;
    cursor: pointer;
    font-size: 18px;
    border-radius: 5px;
    background: #f44336;
    display: inline-block;
}
</style>



